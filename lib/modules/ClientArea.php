<?php
/*
 * SolusVM_ClientArea
 *
 * Define module specific client area output. 
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_ClientArea extends SolusVM
	{
		// main sub module execution
		function _exec( $INPUT )
		{
			return array
			(
				'tabOverviewReplacementTemplate' => 'templates/overview.tpl',
				'templateVariables' => array()
			);
		}
	}