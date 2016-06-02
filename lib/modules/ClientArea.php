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
			try
			{
				return array
				(
					'tabOverviewReplacementTemplate' => 'templates/overview.tpl',
					'templateVariables' => array()
				);
				
			} catch ( Exception $error )
			{
				// log the error
				$this->_log( 'Template Error', $INPUT, NULL, $error );

				// return failback custom error 
				return array
				(
					'tabOverviewReplacementTemplate' => 'error.tpl',
					'templateVariables' => array
					(
						'usefulErrorHelper' => $eror->getMessage()
					)
				);
			}
		}
	}