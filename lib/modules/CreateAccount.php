<?php
/*
 * SolusVM Create Account
 *
 * Provision new VPS instance for given package or custom configuration
 *
 * @package		SolusVM
 * @category	WHMCS Provisioning Modules
 * @author		Trajche Petrov
 * @link		https://qbit.solutions/
*/
	class SolusVM_CreateAccount extends SolusVM
	{
		function _exec()
		{
			try 
			{
				// check & create user in SolusVM system if needed. 
				if(!$this->_user_exist()) 
					$this->_user_create();
				

			} catch ( Exception $error ) {
				// log the errors
				$this->_log( 'Create_Account', $this->input, NULL, $error );

				return $error->getMessage();
			}
		}

/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Sent API call to check if the user exists in SolusVM system
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _user_exist()
		{
			// check if client user exists in solusvm users table
			$query = $this->_db->query("SELECT username FROM mod_solusvm_users WHERE `user_id` = '{$this->input['clientsdetails']['userid']}' LIMIT 1");
			$user = $query->fetchObject();

			if(isset($user->username))
			{
				$this->username = $user->username;
				return true;
			}
			else
				return false;
		}
/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _set_username()
		{
			// check if there are valid user details if not generate random username
			if($this->input['clientsdetails']['firstname'] == '' OR $this->input['clientsdetails']['lastname'] == '')
				$tmp_user = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 10);
			else
				$tmp_user = substr(strtolower(substr($this->input['clientsdetails']['lastname'],0,1).".".$this->input['clientsdetails']['firstname']),0,20);

			// check if the generated user allready exists into the database 
			$user_check = $this->_db->query("SELECT * FROM mod_solusvm_users WHERE `username` = '$tmp_user' LIMIT 1");

			// if user exists in the table add client USER ID for diversity
			if($user_check->rowCount() > 0)
				$tmp_user = $tmp_user.".".$this->input['clientsdetails']['userid'];

			return $tmp_user;
		}
/*
 * ---------------------------------------------------------------------------------------------------------------------
 *  Create 
 * ---------------------------------------------------------------------------------------------------------------------
*/
		private function _user_create()
		{
			$this->username = $new_user = $this->_set_username();

			// do double check on the remote server local check 
			$user = $this->_api(array(
				'action' 	=> 'client-create',
				'username' 	=> $new_user,
				'password'	=> $this->input['password'],
				'email'		=> $this->input['clientsdetails']['email'],
				'firstname'	=> $this->input['clientsdetails']['firstname'],
				'lastname'	=> $this->input['clientsdetails']['lastname'],
				'company'	=> $this->input['clientsdetails']['companyname']
			));

			if(isset($user) and is_object($user))
			{
				if($user->status == 'success')
				{
					// add user to the local database
					$this->_db->query("INSERT INTO `mod_solusvm_users` (`user_id`, `username`) VALUES ('".$this->input['clientsdetails']['userid']."', '$new_user');");
				}
				else
					throw new  Exception("Failed to create SolusVM user: ".$user->statusmsg);
			}
			else
				throw new  Exception('Recieved emtpy or mailformed response. Check module log for more information!');
		}
	}