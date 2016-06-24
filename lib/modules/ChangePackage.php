<?php
/*
 * SolusVM ChangePackage
 *
 * Change VPS package upgrade / downgrade
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_ChangePackage extends SolusVM
	{
		function _exec( $INPUT )
		{
			try 
			{
				// check if the VPS is into the module database
				if(!$this->input['vm_id'])
					throw new  Exception("Can't find VPS ID into module database");

				// check if package is set 
				if(!$this->input['configoption4'] or $this->input['configoption4'] == '')
					throw new  Exception("Requested product is missing package parameter. Please update the 'Default Plan' in product/ service module settings!");

				// try to fetch client login keys
				$upgrade = $this->_api(array
				(
					'action' 	=> 'vserver-change',
					'changehdd'	=> true,
					'plan'		=> $this->input['configoption4'],
					'vserverid' => $this->input['vm_id']
				));

				// validate API response
				if($upgrade->status == 'success')
					return 'success';
				elseif(!is_object($upgrade) or !isset($upgrade))
					throw new  Exception("Some API transport error occured please check module debug log!");
				else
					throw new  Exception($upgrade->statusmsg);

			} catch ( Exception $error ) {
				// log the errors
				$this->_log( 'Change_Package', $this->input, $upgrade, $error );

				return $error->getMessage();
			}
		}
	}