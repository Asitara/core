<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2002
 * Date:		$Date: 2013-03-25 12:12:44 +0100 (Mo, 25 Mrz 2013) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 13246 $
 *
 * $Id: login.php 13246 2013-03-25 11:12:44Z godmod $
 */

class login_pageobject extends pageobject {
	public static function __shortcuts() {
		$shortcuts = array('user', 'tpl', 'in', 'pdh', 'jquery', 'config', 'core', 'db', 'time', 'env', 'email'=>'MyMailer', 'crypt' => 'encrypt');
		return array_merge(parent::__shortcuts(), $shortcuts);
	}

	public function __construct() {
		$handler = array(
			//Process
			'login' 				=> array('process' => 'process_login'),
			'logout' 				=> array('process' => 'process_logout','csrf' => true),
			'lostpassword'			=> array('process' => 'display_lost_password'),
			'newpassword'			=> array('process' => 'display_new_password'),
			'new_password' 			=> array('process' => 'process_new_password', 'csrf' => true),
			'lost_password' 		=> array('process' => 'process_lost_password', 'csrf' => true),
			'resendactivation'		=> array('process' => 'redirect_resend_activation'),
		);
		parent::__construct(false, $handler);

		$this->process();
	}

	public function process_login(){
		if (!$this->user->is_signedin()){
			//Check Captcha
			$blnShowCaptcha = false;
			if (((int)$this->config->get('failed_logins_inactivity') - 2) > 0){
				if ($this->user->data['session_failed_logins'] >= ((int)$this->config->get('failed_logins_inactivity') - 2)){
					$blnShowCaptcha = true;
				}
				if (!$blnShowCaptcha){
					$objQuery = $this->db->prepare("SELECT SUM(session_failed_logins) as failed_logins FROM __sessions WHERE session_ip =?")->execute($this->env->ip);
					if($objQuery && $objQuery->numRows){
						$arrResult = $objQuery->fetchAssoc();
						if ($arrResult['failed_logins'] >= ((int)$this->config->get('failed_logins_inactivity') - 2)){
							$blnShowCaptcha = true;
						}
					}		
				}
			}
		
			if ($blnShowCaptcha){
				require($this->root_path.'libraries/recaptcha/recaptcha.class.php');
				$captcha = new recaptcha;
				$response = $captcha->recaptcha_check_answer ($this->config->get('lib_recaptcha_pkey'), $this->env->ip, $this->in->get('recaptcha_challenge_field'), $this->in->get('recaptcha_response_field'));
				if (!$response->is_valid) {
					$this->core->message($this->user->lang('lib_captcha_wrong'), $this->user->lang('error'), 'red');
					$this->display();
					return;
				}
			}
		
			$blnAutoLogin = ( $this->in->exists('auto_login') ) ? true : false;
			//Login
			if ( !$this->user->login($this->in->get('username'), $this->in->get('password'), $blnAutoLogin) ){
				//error
				$strErrorCode = $this->user->error;
				switch($strErrorCode){
					case 'user_inactive': $strErrorMessage = $this->user->lang('error_account_inactive');
					break;
					case 'user_inactive_failed_logins': $strErrorMessage = $this->user->lang('error_account_inactive_failed_logins');
					break;
					case 'wrong_password':
					case 'wrong_username': $strErrorMessage = $this->user->lang('invalid_login');
					break;
					default: $strErrorMessage = $strErrorCode;
				}
				
				$this->core->global_warning($strErrorMessage.$this->user->lang('invalid_login_goto_admin'), 'icon_stop');
				
				$this->display();
				
			} else {
				//success
				if ($this->in->exists('redirect')){
					$redirect_url = preg_replace('#^.*?redirect=(.+?)&(.+?)$#', '\\1' . $this->SID . '&\\2', base64_decode($this->in->get('redirect')));
					if (strpos($redirect_url, '?') === false) {
						$redirect_url = $redirect_url.$this->SID;
					} else {
						$redirect_url = str_replace("?&", $this->SID.'&', $redirect_url);
					}
					
				} else {
					$redirect_url = $this->controller_path_plain;
				}
				
				redirect($redirect_url);
			}
		} else {
			redirect($this->controller_path_plain.$this->SID);
		}

	}

	public function process_logout(){
		if ($this->user->is_signedin()){
			$this->user->logout();
		}
		redirect($this->controller_path_plain.$this->SID);
	}

	public function redirect_resend_activation(){
		redirect($this->controller_path_plain.'Register/ResendActivation/'.$this->SID);
	}

	//Save new password
	public function process_new_password(){
		if((int)$this->config->get('cmsbridge_active') == 1 && strlen($this->config->get('cmsbridge_reg_url'))) {
			redirect($this->config->get('cmsbridge_reg_url'),false,true);
		}

		//Check if passwords are the same
		if (strlen($this->in->get('password1', '')) && ($this->in->get('password1', '') === $this->in->get('password2'))){
			if (!strlen($this->in->get('key', ''))){
				message_die($this->user->lang('error_invalid_key'));
			}
			
			$objQuery = $this->db->prepare("SELECT user_id, user_active
				FROM __users
				WHERE user_key =?")->limit(1)->execute($this->in->get('key', ''));
			
			if ($objQuery && $objQuery->numRows){
				$row = $objQuery->fetchAssoc();
				
				// Account's inactive, can't give them their password
				if ( !(int)$row['user_active'] ) {
					message_die($this->user->lang('error_account_inactive'));
				}
				
				$user_salt = $this->user->generate_salt();
				$user_password = $this->in->get('password1');
				
				$arrSet = array(
						'user_password' => $this->user->encrypt_password($user_password, $user_salt).':'.$user_salt,
						'user_key' => '',
				);
				
				$objQuery = $this->db->prepare("UPDATE __users :p WHERE user_id=?")->set($arrSet)->execute($row['user_id']);
				
				if ($objQuery){
					$this->core->message($this->user->lang('password_reset_success'), $this->user->lang('success'), 'green');
					$this->display();
				} else {
					$this->core->message($this->user->lang('error'),'', 'red');
					$this->display_new_password();
				}
				
			} else {
				message_die($this->user->lang('error_invalid_key'));
			}

		} else {
			$this->display_new_password();
		}

	}


	//Send email with Key for changing password
	public function process_lost_password(){
		if((int)$this->config->get('cmsbridge_active') == 1 && strlen($this->config->get('cmsbridge_reg_url'))) {
			redirect($this->config->get('cmsbridge_reg_url'),false,true);
		}

		$username	= ( $this->in->exists('username') )	? trim(strip_tags($this->in->get('username'))) : '';

		// Look up record based on the username
		$objQuery = $this->db->prepare("SELECT user_id, username, user_email, user_active, user_lang
				FROM __users
				WHERE LOWER(username)=?")->execute(clean_username($username));
		if ($objQuery){
			$row = $objQuery->fetchAssoc();
			
			//Check if email
			if(!$row){
				$userid = $this->pdh->get('user', 'userid_for_email', array($username));
				if ($userid) $row = $this->pdh->get('user', 'data', array($userid));
			} else {
				$row['user_email'] = $this->crypt->decrypt($row['user_email']);
			}
			
			//We have an hit
			if ($row) {
				// Account's inactive, can't give them their password
				if ( !$row['user_active'] ) {
					message_die($this->user->lang('error_account_inactive'));
				}
			
				$username = $row['username'];
			
				// Create a new activation key
				$user_key = $this->pdh->put('user', 'create_new_activationkey', array($row['user_id']));
				if(!strlen($user_key)) {
					$this->core->message($this->user->lang('error_set_new_pw'), $this->user->lang('error'), 'red');
					$this->display();
				}
			
				// Email them their new password
				$bodyvars = array(
						'USERNAME'		=> $row['username'],
						'DATETIME'		=> $this->time->user_date(false, true),
						'U_ACTIVATE'	=> $this->env->link . $this->controller_path_plain. '/Login/NewPassword/?key=' . $user_key,
				);
			
				if($this->email->SendMailFromAdmin($row['user_email'], $this->user->lang('email_subject_new_pw'), 'user_new_password.html', $bodyvars)) {
					message_die($this->user->lang('password_sent'), $this->user->lang('get_new_password'));
				} else {
					message_die($this->user->lang('error_email_send'), $this->user->lang('get_new_password'));
				}
			} else {
				message_die($this->user->lang('error_invalid_user_or_mail'), $this->user->lang('get_new_password'));
			}
			
			
		} else {
			message_die($this->user->lang('error_invalid_user_or_mail'), $this->user->lang('get_new_password'));
		}
		
	}

	public function display_new_password(){
		$this->jquery->Validate('new_password', array(
			array('name' => 'password1', 'value' => $this->user->lang('fv_required_password')),
			array('name' => 'password2', 'value' => $this->user->lang('fv_required_password_repeat'))
		));

		$this->jquery->ResetValidate('new_password');

		$this->tpl->add_js('document.new_password.password1.focus();', 'docready');

		$this->tpl->assign_vars(array(
			'KEY'	=> sanitize($this->in->get('key', '')),
		));

		$this->core->set_vars(array(
			'page_title'		=> $this->user->lang('create_new_password'),
			'template_file'		=> 'new_password.html',
			'display'			=> true,
		));
	}

	public function display_lost_password(){
		$this->jquery->Validate('lost_password', array(
			array('name' => 'username', 'value' => $this->user->lang('fv_required_user')),
		));
		$this->jquery->ResetValidate('lost_password');

		$this->tpl->add_js('document.lost_password.username.focus();', 'docready');
		$this->tpl->assign_vars(array(
			'BUTTON_NAME'			=> 'lost_password',
		));

		$this->core->set_vars(array(
			'page_title'		=> $this->user->lang('get_new_password'),
			'template_file'		=> 'lost_password.html',
			'display'			=> true,
		));
	}

	public function display(){
		if ($this->user->is_signedin()){
			redirect('settings.php'.$this->SID);
		}
		$blnShowCaptcha = false;
		if (((int)$this->config->get('failed_logins_inactivity') - 2) > 0){
			if ($this->user->data['session_failed_logins'] >= ((int)$this->config->get('failed_logins_inactivity') - 2)){
				$blnShowCaptcha = true;
			}
			if (!$blnShowCaptcha){
				$objQuery = $this->db->prepare("SELECT SUM(session_failed_logins) as failed_logins FROM __sessions WHERE session_ip =?")->execute($this->env->ip);
				if($objQuery && $objQuery->numRows){
					$arrResult = $objQuery->fetchAssoc();
					if ($arrResult['failed_logins'] >= ((int)$this->config->get('failed_logins_inactivity') - 2)){
						$blnShowCaptcha = true;
					}
				}
			}
		}
		
		
		//Captcha
		if ($blnShowCaptcha){
			require($this->root_path.'libraries/recaptcha/recaptcha.class.php');
			$captcha = new recaptcha;
			$this->tpl->assign_vars(array(
				'CAPTCHA'				=> $captcha->recaptcha_get_html($this->config->get('lib_recaptcha_okey')),
				'S_DISPLAY_CATPCHA'		=> true,
			));
		}


		$this->jquery->Validate('login', array(
			array('name' => 'username', 'value'=> $this->user->lang('fv_required_user')),
			array('name'=>'password', 'value'=>$this->user->lang('fv_required_password'))
		));
		
		$arrPWresetLink = $this->core->handle_link($this->config->get('cmsbridge_pwreset_url'),$this->user->lang('lost_password'),$this->config->get('cmsbridge_embedded'),'pwreset');

		$this->tpl->add_js('$("#username").focus();', 'docready');
		$this->tpl->assign_vars(array(
			'S_USER_ACTIVATION'		=> ($this->config->get('account_activation') == 1) ? true : false,
			'REDIRECT'				=> ( isset($redirect) ) ? '<input type="hidden" name="redirect" value="'.base64_decode($redirect).'" />' : '',
		));

		$this->core->set_vars(array(
			'page_title'		=> $this->user->lang('login'),
			'template_file'		=> 'login.html',
			'display'			=> true,
		));

	}

}

?>