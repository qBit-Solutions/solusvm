<?php
/*
 * SolusVM_ConfigOptions
 *
 * Define the settings that are configurable on a per product basis when a product uses the module
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_ConfigOptions extends SolusVM
	{	
		private $options = array
		(
			"virtualization" => array 
			(
				"FriendlyName" => "Virtualization",
				"Type" => "dropdown",
				'Options' => array
				(
					'openvz' 	=> "OpenVZ",
					'kvm'		=> "KVM",
					'xen'		=> "Xen"
				)
			)
		);

		function _exec()
		{
			// initalize module for the first time
			$this->_init_module();

			// 
			try
			{
				// check if virtualization is selected 
				$this->_check_settings();

				// Load SolusVM Node Groups
				$this->_load_groups();

				// Load nodes who support selected virtalization
				$this->_load_nodes();

				// load plans for the selected virtualizations
				$this->_load_plans();

				// load supported templates
				$this->_load_templates();

				// load general options 
				$this->_load_general_options();

				// load virtualization options
				$this->_load_vz_options();

			}
			catch( Exception $error ) {

				// show modle error
				$this->_error($error->getError(), $error->getMessage());

				// log the error into module debug log
				$this->_log( 'Config_Options', $this->input, $error->getError(), $error );
			}

			return $this->options;
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Initalize module server enviroment only on first run ( create DB tables etc.. )
 * ---------------------------------------------------------------------------------------------------------------------
*/
		function _init_module()
		{
			$this->_db->beginTransaction();

			try {

				$table = $this->_db->query("SELECT 1 FROM mod_solusvm LIMIT 1");

				// fetch product data in module configuration @To-Do: Investigate why WHMCS don't pass this data by default
				if(isset($_GET['id']) && ctype_digit($_GET['id']))
				{
					$product = $this->_db->query("SELECT * FROM tblproducts WHERE `id` = '".$_GET['id']."' LIMIT 1");
					$this->input = $product->fetchAll(PDO::FETCH_ASSOC)[0];

					// set server data like server location  and authorization keys
					$this->_set_server_data();
				}

			}
			catch( Exception $error ) {

				// create module service table
				$this->_db->query
				("	
					CREATE TABLE IF NOT EXISTS `mod_solusvm` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`service_id` int(11) NOT NULL,
					`vm_id` int(11) NOT NULL,
					`options` text,
					PRIMARY KEY (`id`),
					KEY `service_id` (`service_id`),
					KEY `vm_id` (`vm_id`)
					) AUTO_INCREMENT=1 ;
				");

				// create module users table
				$this->_db->query
				("	
					CREATE TABLE IF NOT EXISTS `mod_solusvm_users` (
					`user_id` int(11) NOT NULL,
					`username` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
					PRIMARY KEY (`user_id`),
					KEY `username` (`username`)
					);
				");

			}
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Load virtualization specific options
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _load_vz_options()
		{
			// check if virtualization options exists and load it.
			if(is_callable(array($this, "_{$this->vz}_options"))) 
			{
				$this->{"_{$this->vz}_options"}();
			}
		}
		
/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Check module settings and show coresponding errors
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _check_settings()
		{
			if 	// check and validate virtualization type
			(
				!isset($this->input['configoption1']) OR  
				empty($this->input['configoption1']) OR   
				!array_key_exists($this->input['configoption1'], $this->options['virtualization']['Options']) 
			)
				throw new  SolusVM_Exception('Choose your product virtalization type and save it, in order to load the other options!', 'No Hypervisor selected!');
			else
			{
				// preset virtualization type for easier refrerence
				$this->vz = $this->input['configoption1'];
				return true;
			}
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Load all node groups - used for node autoselect feature on VPS creation
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _load_groups()
		{
			// fetch node groups from the master
			$API = $this->_api(array
			(
				'action'	=> 'listnodegroups'
			));

			// validate API response
			if( $this->_validate_response($API) )
			{
				// extract groups, order and format them in propper format
				$raw_groups = explode(',',$API->nodegroups);

				foreach($raw_groups as $group )
				{
					$group = explode('|',$group);

					if(isset($group[1]))
						$groups[$group[0]] = $group[1];
					else
						$groups['none'] = $group[0]; // :)
				}

				// push the groups to the global options object
				array_push($this->options,array 
				(
					"FriendlyName" => "Node Group",
					"Type" => "dropdown",
					'Options' => $groups
				));
			}				
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Load nodes that support selected virtualization
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _load_nodes()
		{
			// fetch node groups from the master
			$node_names = $this->_api(array
			(
				'action'	=> 'listnodes',
				'type'		=> $this->vz
			));

			$node_ids = $this->_api(array
			(
				'action'	=> 'node-idlist',
				'type'		=> $this->vz
			));

			// validate API response
			if( $this->_validate_response($node_names) && $this->_validate_response($node_ids) )
			{
				// separate ID's and names
				$raw_nodes_ids = explode(',',$node_ids->nodes);
				$raw_nodes_names = explode(',',$node_names->nodes);

				// provide auto node select for this particular product
				$nodes['auto'] = '-- AUTO SELECT --';

				// join ID's and names into one array
				foreach( $raw_nodes_ids as $key => $node_id )
				{
					$nodes[$node_id] = $raw_nodes_names[$key];
				}

				// push the nodes to the global options object
				array_push($this->options,array 
				(
					"FriendlyName" => "Default Node",
					"Type" => "dropdown",
					'Options' => $nodes
				));
			}				
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Load VPS plans / packages 
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _load_plans()
		{
			// fetch node groups from the master
			$API = $this->_api(array
			(
				'action'	=> 'listplans',
				'type'		=> $this->vz
			));

			// validate API response
			if( $this->_validate_response( $API ) )
			{
				// split plans from the API response
				$raw_plans = explode(',',$API->plans);

				// update plan INDEX's for better DB handling
				foreach( $raw_plans as $plan )
					$plans[$plan] = $plan;

				// push the nodes to the global options object
				array_push($this->options,array 
				(
					"FriendlyName" => "Default Plan",
					"Type" => "dropdown",
					'Options' => $plans
				));
			}	
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Load supported VPS templates 
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _load_templates()
		{
			// fetch node groups from the master
			$API = $this->_api(array
			(
				'action'			=> 'listtemplates',
				'type'				=> $this->vz,
				'listpipefriendly' 	=> true
			));

			// validate API response
			if( $this->_validate_response( $API ) )
			{
				// determine avaliable templates for the selected virtualization, very strange API response WTF SoluSVM? 
				switch($this->vz)
				{
					case 'openvz':
						$raw_templates = $API->templates;
					break;

					case 'kvm':
						$raw_templates = $API->templateskvm;
					break;

					case 'hvm':
						$raw_templates = $API->templateshvm;
					break;
				}

				// split templates from API response
				$raw_templates = explode(',',$raw_templates);

				// extract templates, order and format them in propper format
				foreach($raw_templates as $template)
				{
					$template = explode('|',$template);

					if(isset($template[1]))
						$templates[$template[0]] = $template[1];
				}


				// push the nodes to the global options object
				array_push($this->options,array 
				(
					"FriendlyName" => "Default OS",
					"Type" => "dropdown",
					'Options' => $templates
				));
			}	
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Load general options 
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _load_general_options()
		{
			$global_options = array
			(
				'ipv4' => array
				(
					'Type' => 'text',
					"FriendlyName" => "IPv4 Addresses",
					'Size' => '25',
					'Default' => '1',
				),

				'randomip' => array
				(
					"FriendlyName" => "Randomize IPv4 pool",
					'Type' => 'yesno'
				),				

				'internal' => array
				(
					"FriendlyName" => "Internal IP's",
					'Type' => 'yesno',
				),

				'power' => array
				(
					"FriendlyName" => "Client Power Controll",
					'Type' => 'yesno'
				),

				'console' => array
				(
					"FriendlyName" => "Console/VNC Redirection",
					'Type' => 'yesno',
				)
			);

			$this->options = array_merge($this->options, $global_options);
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Load custom virtualization options 
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _openvz_options() // load OpenVZ options 
		{
		}

		private function _kvm_options() // load KVM options
		{
		}

		private function _hvm_options() // load HVM options
		{
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Set server connection data - https://github.com/WHMCS/sample-provisioning-module/issues/4
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _set_server_data()
		{
			// Get connection data from the primary server 
			$server = $this->_db->query
			("
				SELECT tblservers.*
				FROM tblservergroups
				LEFT JOIN tblservergroupsrel ON ( tblservergroupsrel.groupid = tblservergroups.id )
				LEFT JOIN tblservers ON ( tblservergroupsrel.serverid = tblservers.id )
				WHERE tblservergroups.id={$this->input['servergroup']} AND tblservers.active='1'
			")->fetchAll(PDO::FETCH_ASSOC)[0];

			// set connection settings
			$this->input['serverport'] 		= (isset($server['port'])) ? $server['port'] : (($server['secure'] == 'on')? 443 : 80);
			$this->input['serversecure'] 	= $server['secure'];
			$this->input['serverhostname'] 	= $server['hostname'];
			$this->input['serverusername'] 	= $server['username'];
			$this->input['serverpassword'] 	= localAPI('decryptpassword',array("password2" => $server['password']))['password'];
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Validate API response
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _validate_response( $DATA )
		{
			if(isset($DATA) AND is_object($DATA))
			{
				if($DATA->status == 'success')
					return true;
				else throw new SolusVM_Exception($DATA->statusmsg,'API ERROR!');
			}
			else
				throw new SolusVM_Exception('Recieved emtpy or mailformed response. Check module log for more information!', 'API Error!');

			return false;
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Show module configuration erros / warnings and notifications
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _error( $ERROR, $DESCRIPTION, $TYPE = 'error' )
		{
			echo '<div class="'.$TYPE.'box">
					<strong><span class="title">'.$ERROR.'</span></strong><br>
					'.$DESCRIPTION.'
				</div>';
		}

	}