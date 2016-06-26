<?php
/*
 * SolusVM TestConnection
 *
 * Test connection with the MASTER SolusVM node and display / log any errors
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_TestConnection extends SolusVM
	{
		function _exec()
		{
			try 
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
						throw new  Exception($check->statusmsg);
				}
				else
					throw new  Exception('Recieved emtpy or mailformed response. Check module log for more information!');
			} catch ( Exception $error ) {
				// log the errors
				$this->_log( 'Connection_Test', $this->input, $check, $error );

				return array('success' => false, 'error' => $error->getMessage());
			}
		}
	}