<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google extends MY_Controller {

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
		$Web_Social	=	$this->Web_Social->GetWebSocial([],['title'=>'Google','status'=>1])[0];
		$this->Apiconfig	=	[
									'client_id'		=>	$Web_Social->client_id,
									'client_secret'	=>	$Web_Social->client_secret,
									'redirect_uri'	=>	$Web_Social->redirect_url,
								];
    	$this->google = new Google_Client($this->Apiconfig);
		$this->google->setAccessType("offline");        // offline access
		$this->google->setIncludeGrantedScopes(true);   // incremental auth
		$this->google->addScope([Google_Service_Oauth2::USERINFO_PROFILE,Google_Service_Oauth2::USERINFO_EMAIL]);
		$this->googleauth 	=	new Google_Service_Oauth2($this->google);
		$this->domain 		=	'kuaifuhui888.com';
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
		$auth_url = $this->google->createAuthUrl();
		redirect($auth_url);
	}

	public function Apilogin(){
		$this->cookie['value']	=	'apilogin';
		$this->input->set_cookie($this->cookie);
		$auth_url = $this->google->createAuthUrl();
		redirect($auth_url);
	}

	public function CallBack(){
		//die();
		if($this->input->get('code')) {
			$url = $this->session->userdata('uri_login')?$this->session->userdata('uri_login'):base_url();
		    $this->session->unset_userdata('uri_login');
			try {
				$data = $this->google->authenticate($this->input->get('code'));
				$access_token = $data['access_token'];
				$user_info = $this->GetUser();
				if($user_info->id){
					$session_data=['id','name','username','login_count','nickname','type','status'];
					$google 	=	['google'=>$user_info->id];
					$MemberData	=	$this->Member_model->GetMember($google,$session_data);
					if(!$MemberData){
						$MemberCheck	=	$this->Member_model->GetMember(['username'=>$user_info['email']],$session_data);
						if(!$MemberCheck){
							$RegisterData	=	[
													'google'		=>	$user_info->id,
													'name'			=>	$user_info->name,
													'nickname'			=>	$user_info->name,
													'username'		=>	$user_info->email,
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
							$this->Member_model->update(['google'		=>	$user_info->id],['username'=>$user_info['email']]);
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
						if($UserData['status']==0){
							$return	=	$this->ReturnHandle(false,'此會員帳號已停權');
							goto end;
						}
						$this->SessionHandle($UserData);
						$return	=	$this->ReturnHandle(true,'登入成功',$url);
					}
				}else{
					$return	=	$this->ReturnHandle(false,$this->lang->line('Unknown_error'));
				}
			}
			catch(Exception $e) {
				log_message('error',$e->getMessage());
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
		return $this->googleauth->userinfo->get();
	}

	public function Unbind(){
		if($this->session->userdata('id')){
			$google 	=	['google'=>NULL];
			$result	=	$this->Member_model->update($google,['id'=>$this->session->userdata('id')]);
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
