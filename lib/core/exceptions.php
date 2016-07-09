<?php
/*
 * SolusVM Exception hanlder
 *
 * Extend PHP native exception handler to provide better error costumuzation and error handling.
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/

class SolusVM_Exception extends Exception
{
	public function __construct( $message, $error = '', $code = 0, Exception $previous = null ) 
	{
		// call the parrent
		parent::__construct($message, $code, $previous);
		
		// pass error into the exception scope
		$this->error = $error;
	}

	public function getError() 
	{
		return $this->error;
	}
}