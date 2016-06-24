<?php
/*
 * SolusVM_AdminCustomButtonArray
 *
 * Define custom functions in your module for admin users. This can contain more functions than the client area equivalent.
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_AdminCustomButtonArray extends SolusVM
	{
		function _exec()
		{
			return array
			(
				// BUTTON LABEL     => BUTTON FUNCTION 
				"Update Hostname"	=> 'Update_Hostname'
			);
		}
	}