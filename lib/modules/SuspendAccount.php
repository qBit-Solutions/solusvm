<?php
/*
 * SolusVM SuspendAccount
 *
 * Suspend VPS instance
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_SuspendAccount extends SolusVM
	{
		function _exec()
		{
			try 
			{
				// check if the VPS is into the module database
				if(!$this->input['vm_id'])
					throw new  Exception("Can't find VPS ID into module database");

				// try to fetch client login keys
				$suspend = $this->_api(array
				(
					'action' 	=> 'vserver-suspend',
					'vserverid' => $this->input['vm_id']
				));

				// validate API response
				if($suspend->status == 'success')
					return 'success';
				elseif(!is_object($suspend) or !isset($suspend))
					throw new  Exception("Some API transport error occured please check module debug log!");
				else
					throw new  Exception($suspend->statusmsg);

			} catch ( Exception $error ) {
				// log the errors
				$this->_log( 'SuspendAccount', $this->input, $suspend, $error );

				return $error->getMessage();
			}
		}
	}