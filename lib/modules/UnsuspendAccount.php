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
			// check if the VPS is into the module database
			if($this->input['vm_id'])
			{
				// try to fetch client login keys
				$suspend = $this->_api(array
				(
					'action' 	=> 'vserver-unsuspend',
					'vserverid' => $this->input['vm_id']
				));

				if($suspend->status == 'success')
					return 'success';
				elseif(!is_object($suspend) or !isset($suspend))
					return 'Some API transport error occured please check module debug log!';
				else
					return $suspend->statusmsg;
			}
			else
				return 'Can\'t find VPS ID into module database';
		}
	}