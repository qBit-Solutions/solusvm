<?php
/*
 * SolusVM TerminateAccount
 *
 * Remove / Terminate VPS instance
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_TerminateAccount extends SolusVM
	{
		function _exec()
		{
			try 
			{
				// check if the VPS is into the module database
				if(!$this->input['vm_id'])
					throw new  Exception("Can't find VPS ID into module database'");

				// try to fetch client login keys
				$terminate = $this->_api(array
				(
					'action' 		=> 'vserver-terminate',
					'deleteclient'	=> false,
					'vserverid' 	=> $this->input['vm_id']
				));

				// validate API response
				if($terminate->status == 'success')
					return 'success';
				elseif(!is_object($terminate) or !isset($terminate))
					throw new  Exception("Some API transport error occured please check module debug log!");
				else
					throw new  Exception($terminate->statusmsg);

			} catch ( Exception $error ) {
				// log the errors
				$this->_log( 'Terminate_Account', $this->input, $terminate, $error );

				return $error->getMessage();
			}
		}
	}