<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
	}

	public function login(){
		if ($this->session->has_userdata('Manager')){
			redirect('/Backend/Dashboard');exit;
		}
		$this->load->model('Web_Info');
		$web_info   =   $this->Web_Info->GetWebInfo(['title_ch','icon'])[0];
		$this->web_icon     =   $web_info->icon;
		$this->web_title     =   $web_info->title_ch;
		// $this->session->sess_destroy();
		$this->session->unset_userdata('Manager');
		$this->load->view('Backend/login');
	}

	public function logout(){
		$this->load->model('Web_Info');
		$web_info   =   $this->Web_Info->GetWebInfo(['title_ch','icon'])[0];
		$this->web_icon     =   $web_info->icon;
		$this->web_title     =   $web_info->title_ch;
		$this->session->unset_userdata('Manager');
		$this->load->view('Backend/login');
	}

	public function login_ajax(){
		$this->load->model('Administrator','admin');
		$acc		= $this->input->post('account',TRUE);
		$passwd		= $this->input->post('password',TRUE);
		$captcha	= $this->input->post('captcha',TRUE);

		if($captcha == "" ||strtolower($captcha)!=$this->session->userdata('Backend')){
			$data = array('status'=>false,'msg'=>'驗證碼錯誤');
			return $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($data));
		}
		$this->session->unset_userdata('Backend');//驗證碼驗證過就不需要了

		$userdata	= $this->admin->logincheck($acc,$passwd);


		if(($userdata)){
			$url = 'Backend/Dashboard';
			$this->admin->UpdateLoginData($userdata->id);
			$userdata->menu_permission = json_decode($userdata->menu_permission);
			$this->load->model('Admin_msg_model');
			$userdata->msg_count = $this->Admin_msg_model->get_list_count(['where'=>['admin_id'=>$userdata->id,'flag'=>'0']]);
			$result = $this->admin->GetFirstPath();
			$this->session->set_userdata('Manager',$userdata);
			$data = array('status'=>true,'data'=>"/".$url);
			$record_data	=	[
									'admin_id'		=>	$userdata->id,
									'ip'			=>	$this->input->ip_address(),
									'user_agent'	=>	$this->input->user_agent(),
									'create_time'	=>	date('Y-m-d H:i:s'),
								];
			$this->load->model('Admin_record');
			$this->Admin_record->insert($record_data);
		}else{
			$data = array('status'=>false,'msg'=>'帳號或密碼錯誤');
		}
		
		return $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($data));
	}
}
