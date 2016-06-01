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

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Initalize Module CORE
 * ---------------------------------------------------------------------------------------------------------------------
*/


/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  WHMCS PROVISIONING MODULES FUNCTIONS
 *
 *  Set module configurable options
 * ---------------------------------------------------------------------------------------------------------------------
*/
	function solusvm_ConfigOptions( array $PARAMS ) 
	{
	}


	function solusvm_MetaData() // Define module metadata
	{
		return array
		(
			'DisplayName' 				=> 'SolusVM',
			'APIVersion' 				=> '1.1',
			'RequiresServer' 			=> true,
			'DefaultNonSSLPort' 		=> '80', 							// Default Non-SSL Connection Port
			'DefaultSSLPort' 			=> '443', 							// Default SSL Connection Port
			'ServiceSingleSignOnLabel' 	=> 'Login to SolusVM',
			'AdminSingleSignOnLabel' 	=> 'Login to Admin Panel',
		);
	}
	
	function solusvm_CreateAccount( array $PARAMS ) //  Run VPS create functions on SolusVM master
	{
		try
		{


		} catch ( Exception $error ) // catch and log module errors
		{
			return __log( $error, __FUNCTION__, $PARAMS );
		}

		return 'success';
	}


	function solusvm_SuspendAccount( array $PARAMS ) // Run VPS suspend function on SolusVM master 
	{
		try
		{


		} catch ( Exception $error ) // catch and log module errors
		{
			return __log( $error, __FUNCTION__, $PARAMS );
		}

		return 'success';
	}


	function solusvm_UnsuspendAccount( array $PARAMS ) // Run VPS un-suspend function on SolusVM master 
	{
		try
		{


		} catch ( Exception $error ) // catch and log module errors
		{
			return __log( $error, __FUNCTION__, $PARAMS );
		}

		return 'success';
	}


	function solusvm_TerminateAccount( array $PARAMS ) //Run VPS terminate function on SolusVM master
	{
		try
		{


		} catch ( Exception $error ) // catch and log module errors
		{
			return __log( $error, __FUNCTION__, $PARAMS );
		}

		return 'success';
	}


	function solusvm_ChangePassword( array $PARAMS ) //Run VPS change root password function on SolusVM master
	{
		try
		{


		} catch ( Exception $error ) // catch and log module errors
		{
			return __log( $error, __FUNCTION__, $PARAMS );
		}

		return 'success';
	}

	function solusvm_ChangePackage( array $PARAMS ) //Run change plan function on SolusVM master
	{
		try
		{


		} catch ( Exception $error ) // catch and log module errors
		{
			return __log( $error, __FUNCTION__, $PARAMS );
		}

		return 'success';
	}

	function solusvm_TestConnection( array $PARAMS ) // test the connection between WHMCS and SolusVM master
	{
		try
		{
			$status = true;
			$error_msg  = '';

		} catch ( Exception $error ) // catch and log module errors
		{
			$status = __log( $error, __FUNCTION__, $PARAMS );
			$error_msg  = $error->getMessage();
		}

		return array
		(
			'success' => $status,
			'error' => $error_msg,
		);
	}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  CUSTOM ADMIN MODULE FUNCTIONS 
 *
 *  register custom admin module functions
 * ---------------------------------------------------------------------------------------------------------------------
*/
	function solusvm_AdminCustomButtonArray()
	{
		return array
		(
			"TUN-TAP ON/OFF" 	=> "TUN",
			"PPP ON/OFF" 		=> "PPP",
			"Reset Bandwidth"	=> "resetBW",
			"Update Hostname" 	=> "change_hostname",
		);
	}


	function solusvm_TUN( array $PARAMS ) // Enable TUN/TAP feature on the VPS
	{
		try
		{


		} catch ( Exception $error ) // catch and log module errors
		{
			return __log( $error, __FUNCTION__, $PARAMS );
		}

		return 'success';
	}


	function solusvm_PPP( array $PARAMS ) // enable TUN/TAP feature on the VPS
	{
		try
		{


		} catch ( Exception $error ) // catch and log module errors
		{
			return __log( $error, __FUNCTION__, $PARAMS );
		}

		return 'success';
	}


	function solusvm_resetBW( array $PARAMS ) // reset bandwidth usage
	{
		try
		{


		} catch ( Exception $error ) // catch and log module errors
		{
			return __log( $error, __FUNCTION__, $PARAMS );
		}

		return 'success';
	}


	function solusvm_change_hostname( array $PARAMS ) // change VPS hostname
	{
		try
		{


		} catch ( Exception $error ) // catch and log module errors
		{
			return __log( $error, __FUNCTION__, $PARAMS );
		}

		return 'success';
	}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  GUI ELEMENTS AND TEMPLATE FILE LOADERS
 *
 *  add aditional tab fields in the admin service view
 * ---------------------------------------------------------------------------------------------------------------------
*/
	function solusvm_AdminServicesTabFields( array $PARAMS ) 
	{
		try 
		{
			return array
			(
				'VPS VMID' => (int) 0,
			);

		} catch ( Exception $error ) 
		{
			__log( $error, __FUNCTION__, $PARAMS );
		}
	}

	// customize the client area 
	function solusvm_ClientArea(array $PARAMS )
	{
	}


/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  SINGLE SIGN ON WHMCS FUNCTIONS 
 *
 *  initialize single client sign in 
 * ---------------------------------------------------------------------------------------------------------------------
*/
	function solusvm_ServiceSingleSignOn( array $PARAMS )
	{
		try 
		{
			return array
			(
				'success' => true,
				'redirectTo' => 'http://qbit.solutions/'
			);

		} catch ( Exception $error ) 
		{
			__log( $error, __FUNCTION__, $PARAMS );

			return array
			(
				'success' => false,
				'errorMsg' => $error->getMessage()
			);
		}
	}

	function solusvm_AdminSingleSignOn( array $PARAMS ) // initalize admin area sign in
	{
			try 
			{
				return array
				(
					'success' => true,
					'redirectTo' => 'http://qbit.solutions/'
				);

			} catch ( Exception $error ) 
			{
				__log( $error, __FUNCTION__, $PARAMS);

				return array
				(
					'success' => false,
					'errorMsg' => $error->getMessage()
				);
			}
	}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  VPS USAGE WHMCS UPDATE FUNCTIONS 
 * ---------------------------------------------------------------------------------------------------------------------
*/
	function solusvm_UsageUpdate( array $PARAMS ) 
	{
	}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Module debug log 
 * ---------------------------------------------------------------------------------------------------------------------
*/
	function __log( $ERROR, $FUNCTION , $PARAMS) 
	{
		// Record the error in WHMCS's module log.
		logModuleCall
		(
			'solusvm',
			$function,
			$PARAMS,
			$error->getMessage(),
			$error->getTraceAsString()
		);
		return $error->getMessage();
	}