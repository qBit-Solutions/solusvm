<?php
/*
 * SolusVM_MetaData
 *
 * Define module basic parameters such as module name, API ports etc... 
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_MetaData extends SolusVM
	{
		function _exec()
		{
				return array
				(
					'DisplayName' 				=> 'SolusVM',
					'APIVersion' 				=> '1',
					'RequiresServer' 			=> true,
					'DefaultNonSSLPort' 		=> '80', 							// Default Non-SSL Connection Port
					'DefaultSSLPort' 			=> '443', 							// Default SSL Connection Port
					'ServiceSingleSignOnLabel' 	=> 'Login to SolusVM',
					'AdminSingleSignOnLabel' 	=> 'Login to Admin Panel',
				);
		}
	}