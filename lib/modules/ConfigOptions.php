<?php
/*
 * SolusVM_ConfigOptions
 *
 * Define the settings that are configurable on a per product basis when a product uses the module
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_ConfigOptions extends SolusVM
	{

		function _exec()
		{
			$options = array
			(
				"master" => array 
				(
					"FriendlyName" => "Master Server",
					"Type" => "dropdown",
					'Options' => array
					(
					)
				),
				"group" => array 
				(
					"FriendlyName" => "Node Group",
					"Type" => "dropdown",
					'Options' => array
					(
					)
				),
				"node" => array 
				(
					"FriendlyName" => "Default Node",
					"Type" => "dropdown",
					'Options' => array
					(
					)
				),

				"plan" => array 
				(
					"FriendlyName" => "Default Plan",
					"Type" => "dropdown",
					'Options' => array
					(
					)
				),

				"os" => array 
				(
					"FriendlyName" => "Default OS",
					"Type" => "dropdown",
					'Options' => array
					(
					)
				),

				'ipv4' => array
				(
					'Type' => 'text',
					"FriendlyName" => "IPv4 Addresses",
					'Size' => '25',
					'Default' => '1',
				),

				'ipv6' => array
				(
					'Type' => 'text',
					"FriendlyName" => "IPv6 Addresses",
					'Size' => '25',
					'Default' => '0',
				),				

				'internal' => array
				(
					"FriendlyName" => "Internal IP's",
					'Type' => 'yesno',
				),

				'quickbackup' => array
				(
					"FriendlyName" => "Quick Backup",
					'Type' => 'yesno',
				),

				'console' => array
				(
					"FriendlyName" => "Console/VNC Redirection",
					'Type' => 'yesno',
				),

				'tun' => array
				(
					"FriendlyName" => "TUN/TAP suport",
					'Type' => 'yesno',
				),

				'ppp' => array
				(
					"FriendlyName" => "PPP Support",
					'Type' => 'yesno',
					'Description' => 'Default PPP settings',
				),		

			);

			return $options;
		}

	}