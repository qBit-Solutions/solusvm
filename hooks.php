<?php
/*
 * SolusVM 
 *
 * WHMCS hooks for SolusVM module
 *
 * @package		SolusVM
 * @category	WHMCS Hooks
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  WHCMS HOOK FUNCTIONS 
 *  
 *  Customize sidebars for SolsuVM services
 * ---------------------------------------------------------------------------------------------------------------------
*/
	function solusvm_definesidebar( $SIDEBAR ) 
	{
		$service = Menu::context( 'service' );

		if($service->product->module == 'solusvm')
		{
	    }
	}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Register hook functions with WHMCS
 * ---------------------------------------------------------------------------------------------------------------------
*/
	add_hook( 'ClientAreaPrimarySidebar', -1, 'solusvm_definesidebar' );