<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Line extends MY_Controller {

	private $Line_channel='';
	private $access_line='';
	public function __construct(){
	parent::__construct();
		$this->load->model('Member_model','Member_model');
	 	//載入line
		$this->config->load('line_config');
		$this->Line_channel = $this->config->item('LINE_login_channel_info');
		$this->access_line = $this->config->item('LINE_authorization_request_param');
		$this->load->library('LINE_login', $this->Line_channel);
	}

	public function login(){
		$auth_url = $this->createAuthUrl();
		redirect($auth_url);
	}

	public function createAuthUrl(){
		$Url=$this->access_line;
		$Url['state']=($this->input->get('callbackUrl'))?$this->input->get('callbackUrl'):'/';
		$Url['client_id']=$this->Line_channel['channel_id'];
		$arr=[];
		foreach ($Url as $key => $value) {
			$arr[]=$key.'='.$value;
		}
		$auth_url = 'https://access.line.me/oauth2/v2.1/authorize?response_type=code&'.implode('&', $arr);

		return $auth_url;
	}

	//取消Linelogin
	public function linelogout(){
		$this->session->sess_destroy();
		redirect(base_url('front/member/login'));
	}

	public function CallBack(){
		if($this->input->get('code')) {
			$url = $this->session->userdata('uri_login')?$this->session->userdata('uri_login'):base_url();
		    $this->session->unset_userdata('uri_login');
			//抓取驗證碼 分析 |之後的值 跑到對應的網站
			$state = $this->input->get('state');
			//urldecode() 轉html碼
			//urlencode() 轉字串
			$callbackUrl = urldecode($state);
			$this->session->set_userdata('callbackUrl', $callbackUrl);
			// 接收 line 登入後的結果
			$this->line_login->check_authorization_response();

			// 為了使用 line login api 的功能，送出 token 請求，這樣才能取得我們需要 userId
			$access_token_callback = $this->config->item('LINE_authorization_request_param')['redirect_uri'];
			$this->line_login->request_access_token2($access_token_callback,$this->input->get('code'));
			//$access_token_callback = $this->line_login->request_access_token($access_token_callback);;
			// 取得 userId
			// 這邊就可以把 userId 存到資料庫去
			$Line	=	$this->line_login->getuserid();
			$line_user =$this->line_login->getuserEmail();
			$user_email ='';
			if(!empty($line_user))$user_email = $line_user['email'];

			if(!empty($Line['userId'])){
				if($user_email){
					$session_data=['id','name','username','login_count','nickname','type','status'];
					$line 	=	[
									'line'		=>	$Line['userId'],
								];
					$MemberData	=	$this->Member_model->GetMember($line,$session_data);
					if(!$MemberData){
						$MemberCheck	=	$this->Member_model->GetMember(['username'=>$user_email],$session_data);
						if(!$MemberCheck){
							$RegisterData	=	[
													'line'		=>	$Line['userId'],
													'name'			=>	$Line['displayName'],
													'nickname'			=>	$Line['displayName'],
													'username'		=>	$user_email,
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
							$this->Member_model->update(['line'	=>	$Line['userId']],['username'=>$user_email]);
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
					$return	=	$this->ReturnHandle(false,'此LINE帳號尚未設定Email，或未許可權限，故無法註冊。');
				}
			}else{
				$return	=	$this->ReturnHandle(false,$this->lang->line('Unknown_error'));
			}

		}else{
			$return	=	$this->ReturnHandle(false,$this->lang->line('Unknown_error'));
		}
		//$data['return']	=	json_encode($return);
		//$this->load->view('front/return',$data);
		end:
		$this->session->set_userdata('login',$return);
		redirect(base_url('/member/login'),'refresh');
	}

	/**直接登入並導向頁面**/
	public function line_userid_login($MemberData,$callbackUrl){
		if(!empty($MemberData)){
        	$this->load->helper('cookie');
			$UserData = get_object_vars($MemberData[0]);
			unset($UserData['status']);
			$UserData['member_permission']=json_decode($UserData['member_permission']);
			$this->SessionHandle($UserData);
			end:
			redirect(base_url($callbackUrl),'refresh');
		}
	}
}
