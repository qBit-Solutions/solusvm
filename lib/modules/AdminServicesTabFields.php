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
	class SolusVM_AdminServicesTabFields extends SolusVM
	{
		function _exec()
		{
			try 
			{
				return array(
				'Power Management' 	=> 'SOME HTML, CSS, JS HERE',
				'Server Status' 	=> 'SOME HTML, CSS, JS HERE',
				'Media Manager' 	=> 'SOME HTML, CSS, JS HERE',
				'Network' 			=> 'SOME HTML, CSS, JS HERE',
				'VNC / Console' 	=> 'SOME HTML, CSS, JS HERE',
				'Resource Manager' 	=> 'SOME HTML, CSS, JS HERE',
				);

			} catch ( Exception $error ) {
				// log the errors
				$this->_log( 'Admin_Services_Tab_Fields', $this->input, NULL, $error );

				return array();
			}
		}
	}