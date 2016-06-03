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

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Simple loop increase check
 * ---------------------------------------------------------------------------------------------------------------------
*/
	function __( &$i , $WHILE )
	{
		$i++;

		if($i <= $WHILE )	
			return $i;
		return false;
	}
