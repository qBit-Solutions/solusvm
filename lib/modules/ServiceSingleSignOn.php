<?php
/*
 * SolusVM_ServiceSingleSignOn
 *
 * Perform single sign-on for a given instance of a product/service in this case VPS to the SolusVM control panel
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_ServiceSingleSignOn extends SolusVM
	{
		function _exec()
		{
			// check if the VPS is into the module database
			if($this->input['vm_id'])
			{
				// try to fetch client login keys
				$login = $this->_api(array
				(
					'action' 	=> 'client-key-login',
					'vserverid' => $this->input['vm_id'],
					'forward'	=> 1
				));

				if($login->status == 'success')
				{
					// set autologin redirect URL 
					$url = $this->__set_redirect_url( $login );

					return array // send redirect result to WHMCS
					(
						'success' => true,
						'redirectTo' => $url
					);
				}
				elseif(!is_object($login) or !isset($login))
					return array('success' => false, 'errorMsg' => 'Some API transport error occured please check module debug log!');
				else
					return array('success' => false, 'errorMsg' => $login->statusmsg);
			}
			else
				return array('success' => false, 'errorMsg' => 'Can\'t find VPS ID into module database');
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Generate redirect URl
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function __set_redirect_url( $LOGIN )
		{
			$master = $this->_get_master_url(); // get master location

			return $master.'/auth.php?_a='.$LOGIN->hasha.'&_b='.$LOGIN->hashb;
		}
	}