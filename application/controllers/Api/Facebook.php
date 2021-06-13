<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('Member_model','Member_model');
		$this->load->model('Web_Social');
		$this->load->library('user_agent');
		$Web_Social	=	$this->Web_Social->GetWebSocial([],['title'=>'Facebook','status'=>1])[0];
		$this->Apiconfig	=	[
									'app_id'				=>	$Web_Social->client_id,
									'app_secret'			=>	$Web_Social->client_secret,
									'default_graph_version'	=>	'v2.10',
								];
		$this->domain 		=	$_SERVER['SERVER_NAME'];
		//$this->domain 		=	'punkgo.dinj.co';
    	$this->CallBackUrl	=	'https://'.$this->domain.'/Facebook/CallBack';
    	$this->data_filed	=	[
    								'id',
    								'name',
    								'email',
    								'age_range',
    								'birthday',
    								'first_name',
    								'gender',
    								'last_name',
    							];
		$this->facebook 	=	new Facebook\Facebook($this->Apiconfig);
		$this->load->helper('cookie');
		$this->cookie 	=	array(
							    'name'   => 'action',
							    'value'  => '',
							    'expire' => '0',
							    'domain' => '.'.$this->domain,
							    'path'   => '/',
							    'prefix' => '',
							    'secure' => TRUE
							);
	}

	public function login(){
		$this->cookie['value']	=	'login';
		$this->input->set_cookie($this->cookie);
		$helper = $this->facebook->getRedirectLoginHelper();
		$permissions = ['email'];
		$loginUrl = $helper->getLoginUrl($this->CallBackUrl, $permissions);
		redirect(($loginUrl));
	}

	public function Apilogin(){
		$this->cookie['value']	=	'apilogin';
		$this->input->set_cookie($this->cookie);
		$helper = $this->facebook->getRedirectLoginHelper();
		$permissions = ['email'];
		$loginUrl = $helper->getLoginUrl($this->CallBackUrl, $permissions);
		redirect(($loginUrl));
	}

	public function CallBack(){
		$helper = $this->facebook->getRedirectLoginHelper();
		$url = $this->session->userdata('uri_login')?$this->session->userdata('uri_login'):base_url();
		$this->session->unset_userdata('uri_login');
		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  log_message('error','Graph returned an error: ' . $e->getMessage());
		  $return	=	$this->ReturnHandle('error',$this->lang->line('Unknown_error'));
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  log_message('error','Facebook SDK returned an error: ' . $e->getMessage());
		  $return	=	$this->ReturnHandle('error',$this->lang->line('Unknown_error'));
		}

		if (! isset($accessToken)) {
		  if ($helper->getError()) {
		    // header('HTTP/1.0 401 Unauthorized');
		    log_message('error',"Error: " . $helper->getError());
		    log_message('error',"Error Code: " . $helper->getErrorCode());
		    log_message('error',"Error Reason: " . $helper->getErrorReason());
		    log_message('error',"Error Description: " . $helper->getErrorDescription());
		  } else {
		    // header('HTTP/1.0 400 Bad Request');
		    log_message('error','Bad request');
		  }
		  $return	=	$this->ReturnHandle('error',$this->lang->line('Unknown_error'));
		}else{
			$oAuth2Client = $this->facebook->getOAuth2Client();
			$tokenMetadata = $oAuth2Client->debugToken($accessToken);
			// Validation (these will throw FacebookSDKException's when they fail)
			$tokenMetadata->validateAppId($this->Apiconfig['app_id']); // Replace {app-id} with your app id
			// If you know the user ID this access token belongs to, you can validate it here
			//$tokenMetadata->validateUserId('123');
			$tokenMetadata->validateExpiration();
			if (! $accessToken->isLongLived()) {
			  try {
			    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
			  } catch (Facebook\Exceptions\FacebookSDKException $e) {
			    log_message('error',"Error getting long-lived access token: " . $e->getMessage());
			    $return	=	$this->ReturnHandle('error',$this->lang->line('Unknown_error'));
			  }
			}
			$this->session->set_userdata([	'fb_access_token'	=>	$accessToken,]);
			$user_info = $this->GetUser();
			if($user_info['id']){
				$session_data=['id','name','username','login_count','nickname','type','status'];
				$facebook 	=	[
									'facebook'		=>	$user_info['id'],
								];
				$MemberData	=	$this->Member_model->GetMember($facebook,$session_data);
				if(!$MemberData){
					$MemberCheck	=	$this->Member_model->GetMember(['username'=>$user_info['email']],$session_data);
					if(!$MemberCheck){
						$RegisterData	=	[
												'facebook'		=>	$user_info['id'],
												'name'			=>	$user_info['name'],
												'nickname'			=>	$user_info['name'],
												'username'		=>	$user_info['email'],
												'create_time'	=>	date('Y-m-d H:i:s'),
											];
						if($this->Member_model->insert($RegisterData)){
							$id 	=	$this->Member_model->insert_id();
							$MemberData	=	$this->Member_model->GetMember(['id'=>$id],$session_data);
							$UserData =   get_object_vars($MemberData[0]);
							$this->SessionHandle($UserData);
							$return	=	$this->ReturnHandle(true,$this->lang->line('success_register'),base_url());
						}else{
							$return	=	$this->ReturnHandle(false,$this->lang->line('fail_register'));
						}
					}else{
						$this->Member_model->update(['facebook'=>$user_info['id']],['username'=>$user_info['email']]);
						$UserData =   get_object_vars($MemberCheck[0]);
						if($UserData['status']==0){
							$return	=	$this->ReturnHandle(false,'此會員帳號已停權');
							goto end;
						}
						$this->SessionHandle($UserData);
						$return	=	$this->ReturnHandle(true,'登入成功',$url);
					}
				}else{
					$UserData =   get_object_vars($MemberData[0]);
					$this->SessionHandle($UserData);
					if($UserData['status']==0){
						$return	=	$this->ReturnHandle(false,'此會員帳號已停權');
						goto end;
					}
					$return	=	$this->ReturnHandle(true,'登入成功',$url);
				}
			}else{
				$return	=	$this->ReturnHandle(false,$this->lang->line('Unknown_error'));
			}
		}
		//$data['return']	=	json_encode($return);
		//$this->load->view('front/return',$data);
		end:
		$this->session->set_userdata('login',$return);
		redirect(base_url('/member/login'),'refresh');
	}

	public function GetUser(){
		try {
		  $response = $this->facebook->get('/me?fields='.implode(",",$this->data_filed), $this->session->userdata('fb_access_token'));
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  log_message('error','Graph returned an error: ' . $e->getMessage());
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  log_message('error','Facebook SDK returned an error: ' . $e->getMessage());
		}
		return $response->getGraphUser();
	}

	public function Unbind(){
		if($this->session->userdata('id')){
			$facebook 	=	['facebook'=>NULL];
			$result	=	$this->Member_model->update($facebook,['id'=>$this->session->userdata('id')]);
			if($result){
				$return 	=	$this->ReturnHandle('success',$this->lang->line('Release_Bind_success'));
			}else{
				$return 	=	$this->ReturnHandle('error',$this->lang->line('Release_Bind_fail'));
			}
		}else{
			$return 	=	$this->ReturnHandle('error',$this->lang->line('relogin'),base_url('Member/Login'));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

}
