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
		function _exec()
		{
			$this->_init_module();

			$options = array
			(
				"master" => array 
				(
					"FriendlyName" => "Master Server",
					"Type" => "dropdown",
					'Options' => array
					(
					)
				),
				"group" => array 
				(
					"FriendlyName" => "Node Group",
					"Type" => "dropdown",
					'Options' => array
					(
					)
				),
				"node" => array 
				(
					"FriendlyName" => "Default Node",
					"Type" => "dropdown",
					'Options' => array
					(
					)
				),

				"plan" => array 
				(
					"FriendlyName" => "Default Plan",
					"Type" => "dropdown",
					'Options' => array
					(
					)
				),

				"os" => array 
				(
					"FriendlyName" => "Default OS",
					"Type" => "dropdown",
					'Options' => array
					(
					)
				),

				'ipv4' => array
				(
					'Type' => 'text',
					"FriendlyName" => "IPv4 Addresses",
					'Size' => '25',
					'Default' => '1',
				),

				'ipv6' => array
				(
					'Type' => 'text',
					"FriendlyName" => "IPv6 Addresses",
					'Size' => '25',
					'Default' => '0',
				),				

				'internal' => array
				(
					"FriendlyName" => "Internal IP's",
					'Type' => 'yesno',
				),

				'quickbackup' => array
				(
					"FriendlyName" => "Quick Backup",
					'Type' => 'yesno',
				),

				'console' => array
				(
					"FriendlyName" => "Console/VNC Redirection",
					'Type' => 'yesno',
				),

				'tun' => array
				(
					"FriendlyName" => "TUN/TAP suport",
					'Type' => 'yesno',
				),

				'ppp' => array
				(
					"FriendlyName" => "PPP Support",
					'Type' => 'yesno',
					'Description' => 'Default PPP settings',
				),		

			);

			return $options;
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

	}