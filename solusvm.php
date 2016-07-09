<?php 
/*
 * SolusVM 
 *
 * WHMCS module for SolusVM ( GUI for VPS management system with full OpenVZ, KVM and XEN virtualization )
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/

	if (!defined("WHMCS")) 
		die("This file cannot be accessed directly");

	// define module root directory
	define('_SOLUSVM_ROOT', dirname(__FILE__));

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Initalize SolusVM Module CORE and load common scripts
 * ---------------------------------------------------------------------------------------------------------------------
*/
	include_once( _SOLUSVM_ROOT.'/lib/core/common.php' );

	include_once( _SOLUSVM_ROOT.'/lib/core/exceptions.php' );
	
	include_once( _SOLUSVM_ROOT.'/lib/core/core.php' );

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  WHMCS PROVISIONING MODULES FUNCTIONS
 * ---------------------------------------------------------------------------------------------------------------------
*/
	// define module metadata and module configurable options
	include_once( _SOLUSVM_ROOT.'/lib/whmcs/config.php' );

	// default whmcs profisioning functions 
	include_once( _SOLUSVM_ROOT.'/lib/whmcs/provision.php' );

	// single sign on whmcs function
	include_once( _SOLUSVM_ROOT.'/lib/whmcs/signon.php' );

	// gui elements and template file loarders 
	include_once( _SOLUSVM_ROOT.'/lib/whmcs/gui.php' );

	// custom admin module functions 
	include_once( _SOLUSVM_ROOT.'/lib/whmcs/custom.php' );