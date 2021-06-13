<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Front.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
class Contact extends MY_Front {
	//聯絡我們
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Contact_model');
        $this->load->model('Website_model');
        $this->load->model('Mail_receive','Receive');
        $this->load->library('Mailer');
		$this->mail 	=	$this->mailer->mail;
	}
	public function form(){
		//載入模版
		$this->load->view('front/contact/contact');
	}

	//聯繫我們POST
	public function contactAjax(){
		if ($this->input->post('captcha') != $this->session->userdata('Front')) {
			$return = $this->ReturnHandle(false,'驗證號碼輸入錯誤');
		} else {
			if($this->form_validation->run('contact/contactAjax')){
	            $data 	= $this->input->post();
	            $data['date_add'] = date('Y-m-d H:i:s');
	            unset($data['captcha']);
	            $result = $this->Contact_model->insert($data);
	            if($result){
	            	$result=$this->SendEmail($data);
	            	if($result){
	            		$return = $this->ReturnHandle(true,'表單已送出','/contact');
	            	}else{
	            		log_message('error',$this->mail->ErrorInfo);
                		$return =   $this->ReturnHandle($result,$this->lang->line('Unknown_error'));
	            	}
	            }else{
	                $return = $this->ReturnHandle(false,$this->lang->line('Insert_fail'));
	            }
	        }else{
	            $return = $this->ReturnHandle(false,$this->form_validation->error_array());
	        }
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	//發送聯絡我們信件
	public function SendEmail($data){
		$data['web']=$this->Website_model->get_web_info();
		$this->mail->Subject =$data['web']['title_ch']."-聯絡我們"; //設定郵件標題
		$content 	=	$this->load->view('front/contact/send',$data,true);
		$this->mail->Body = $content; //設定郵件內容
		$this->mail->IsHTML(true); //設定郵件內容為HTML
		$sendemail = $this->Receive->get(['type_id'=>1]);
		foreach ($sendemail as $e => $v) {
			$this->mail->AddAddress($v->email,$v->title);
		}
		$result 	=	$this->mail->send();
		return $result;
	}
}

/* End of file FrontController.php */
/* Location: ./application/controllers/front/FrontController.php */