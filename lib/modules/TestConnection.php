<?php
/*
 * SolusVM TestConnection
 *
 * Test connection with the MASTER SolusVM node and display any errors
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_TestConnection extends SolusVM
	{
		function _exec( $INPUT )
		{
			// fetch simple information from the API to check the connection
			$check = $this->_api(array
			(
				'action' => 'listnodegroups'
			));

			// handle connection testing
			if(isset($check) and is_object($check))
			{
				if($check->status == 'success')
					return array('success' => true);
				else
					return array( 'sucess' => false, 'error' => $check->statusmsg );
			}
			else
				return array('success' => false, 'error' => 'Recieved emtpy or mailformed response. Check module log for more information!');
		}
	}