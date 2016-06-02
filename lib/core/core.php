<?php
/*
 * SolusVM 
 *
 * Core of the WHMCS module a place where the magic happens
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM
	{
/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Define Public/Private variables
 * ---------------------------------------------------------------------------------------------------------------------
*/

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Preset CORE variables and init modular enviroment
 * ---------------------------------------------------------------------------------------------------------------------
*/
		function __construct( $INIT = false )
		{
			if( $INIT ) // run this only once
			{
				// scan for additional modules
				foreach(glob(_SOLUSVM_ROOT."/lib/modules/*.php") as $file )
				{
					// determine classname based on it's filename
					$class_name = 'SolusVM_'.str_replace('.php','',end(explode('/',$file)));

					if(!class_exists($class_name)) // check if class exists & if ! load it
					{
						include_once($file); // To-DO: Failback for invalid class name
						$this->{$class_name} = new $class_name();
					}
				}
			}
		}
/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Hanlde / Route all incoming requests
 * ---------------------------------------------------------------------------------------------------------------------
*/
		public function __call( $METHOD, $INPUT )
		{
			// clean up method name
			$method_name = $this->_cleanup( $METHOD );

			// VALIDATE TRY TO CALL THE REQUESTED METHOD
			try {
					return $this->_call( $method_name, $INPUT );
			} catch (Exception $error ) {
					$this->_log($method_name, $INPUT, NULL, $error );
			}
		}
/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Validate input request 
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _call( $METHOD , $INPUT )
		{
			if( isset($this->$METHOD) )
			{
				if( is_callable( array($this->$METHOD,'_exec') ))
					return $this->{$METHOD}->_exec($INPUT[0]);
				else
					throw new Exception("The requested method: $METHOD can't be executed.");
			}
			else
				throw new Exception("The requested method: $METHOD don't exist.");
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  FILTER * CLEANUP incoming method name 
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _cleanup( $METHOD )
		{
			return str_replace('solusvm','SolusVM',$METHOD);
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Validate input request 
 * ---------------------------------------------------------------------------------------------------------------------
*/
		public function _api()
		{
		}

	}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Initalize the global solusvm opbject
 * ---------------------------------------------------------------------------------------------------------------------
*/
	global 	$solusvm;
			$solusvm = new SolusVM( true );