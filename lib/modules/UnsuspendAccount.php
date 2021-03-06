<?php
/*
 * SolusVM UnsuspendAccount
 *
 * UnsuspendAccount VPS instance
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_UnsuspendAccount extends SolusVM
	{
		function _exec()
		{
			try 
			{
				// check if the VPS is into the module database
				if(!$this->input['vm_id'])
					throw new  Exception("Can't find VPS ID into module database'");

				// try to fetch client login keys
				$unsuspend = $this->_api(array
				(
					'action' 	=> 'vserver-unsuspend',
					'vserverid' => $this->input['vm_id']
				));

				// validate API response
				if($unsuspend->status == 'success')
					return 'success';
				elseif(!is_object($unsuspend) or !isset($unsuspend))
					throw new  Exception("Some API transport error occured please check module debug log!");
				else
					throw new  Exception($unsuspend->statusmsg);

			} catch ( Exception $error ) {
				// log the errors
				$this->_log( 'SuspendAccount', $this->input, $unsuspend, $error );

				return $error->getMessage();
			}
		}
	}