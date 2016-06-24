<?php
/*
 * SolusVM_MetaData
 *
 * Admin Single SignOn feature that allows you to directly access SolusVM admin panel from WHMCS 
 *  
 * sadly SolusVM don't support admin key login so for now we're forced to manualy login into the admin panel.
 * Feature request was sent to SolusVM development team so we're waiting for implementation 
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_AdminSingleSignOn extends SolusVM
	{
		function _exec( )
		{
			// get master url 
			$master = $this->_get_master_url();

			// return url to SolusVM admin control panel
			return array
			(
				'success' => true,
				'redirectTo' => $master.'/admincp/'
			);
		}
	}