<?php
/*
 * SolusVM ChangePassword
 *
 * Change VPS hostname
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_Update_Hostname extends SolusVM
	{
		function _exec( $INPUT )
		{
			try 
			{
				// check if the VPS is into the module database
				if(!$this->input['vm_id'])
					throw new  Exception("Can't find VPS ID into module database");

				// check if package is set 
				if(!$this->input['domain'] or empty($this->input['domain']))
					throw new  Exception("No hostname was provided.");

				// try to fetch client login keys
				$response = $this->_api(array
				(
					'action' 		=> 'vserver-hostname',
					'hostname'	=> $this->input['domain'],
					'vserverid' 	=> $this->input['vm_id']
				));

				// validate API response
				if($response->status == 'success')
					return 'success';
				elseif(!is_object($response) or !isset($response))
					throw new  Exception("Some API transport error occured please check module debug log!");
				else
					throw new  Exception($response->statusmsg);

			} catch ( Exception $error ) {
				// log the errors
				$this->_log( 'Update_Hostname', $this->input, $upgrade, $error );

				return $error->getMessage();
			}
		}
	}