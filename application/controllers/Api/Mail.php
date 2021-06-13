<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends MY_Controller {

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
		$this->load->model('Mail_model');
		$this->load->model('Member_model');
		$this->load->model('Web_Info');
		$this->load->library('form_validation');
		$this->load->helper('string');
		$this->load->model('Mail_type');
		$this->MailInfo 	=	$this->Mail_model->get(['id'=>1])[0];
		$this->mail 	=	new PHPMailer();
		$this->mail->IsSMTP();
		$this->mail->SMTPAuth	=	true;
		$this->mail->SMTPSecure	=	$this->MailInfo->port_type;
		$this->mail->Host 		=	$this->MailInfo->host;
		$this->mail->Port 		=	$this->MailInfo->port;
		$this->mail->CharSet	=	'utf8';
		$this->mail->Username	=	$this->MailInfo->username;
		$this->mail->Password 	=	$this->MailInfo->password;
		$this->mail->setFrom($this->MailInfo->username,$this->MailInfo->from_to);
		// $this->mail->SMTPDebug = 2;
	}

	public function Forgot(){
		if($this->form_validation->run()){
			$Member 	=	$this->Member_model->GetMember(['username'=>$this->input->post('email')]);
			if($Member){
				$password 	=	random_string('alnum',8);
				$data['password']   =   password_hash($password,PASSWORD_DEFAULT);
				$result 	=	$this->Member_model->update($data,['id'=>$Member[0]->id]);
				if($result){
					$this->mail->Subject = "食藥安會員重置密碼"; //設定郵件標題   
					$content 	=	'食藥安會員重置密碼<br>';
					$content 	.=	'密碼為:'.$password;
					$this->mail->Body = $content; //設定郵件內容 
					$this->mail->IsHTML(true); //設定郵件內容為HTML   
					$this->mail->AddAddress($this->input->post('email'), $this->input->post('email')); //設定收件者郵件及名稱  
					$result 	=	$this->mail->send();
					if($result){
						$return	=	$this->ReturnHandle($result,$this->lang->line('success'));
					}else{
						log_message('error',$this->mail->ErrorInfo);
						$return	=	$this->ReturnHandle($result,$this->lang->line('Unknown_error'));
					}
				}else{
					$return	=	$this->ReturnHandle(false,'重製失敗');
				}
			}else{
				$return	=	$this->ReturnHandle(false,$this->lang->line('error_username'));
			}
		}else{
			$return = 	$this->ReturnHandle(false,$this->form_validation->error_array());
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	public function Send(){
		if($this->form_validation->run()){
			$this->mail->Subject = "測試郵件"; //設定郵件標題   
			$content 	=	'測試郵件發送成功';
			$this->mail->Body = $content; //設定郵件內容 
			$this->mail->IsHTML(true); //設定郵件內容為HTML   
			$this->mail->AddAddress($this->input->post('email'), $this->input->post('email')); //設定收件者郵件及名稱  
			$result 	=	$this->mail->send();
			if($result){
				$return	=	$this->ReturnHandle($result,$this->lang->line('success'));
			}else{
				log_message('error',$this->mail->ErrorInfo);
				$return	=	$this->ReturnHandle($result,$this->lang->line('Unknown_error'));
			}
		}else{
			$return = 	$this->ReturnHandle(false,$this->form_validation->error_array());
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**登入-發送驗證碼-ajax**/
	public function loginCaptcha(){
		//$Member 	=	$this->Member_model->GetMember(['username'=>$this->input->post('email')],['member.id','email','username']);
		$Captcha['code']	=	random_string('numeric',6);
		$Captcha['time']	=	time()+60;
		$Captcha['time2']	=	time()+180;
		$content 	=	$this->Mail_type->GetMail(['id'=>1],['content'])[0]->content;
		$data['title']='登入會員';
		$replace 	=	['username'=>$this->input->post('email'),'code'=>$Captcha['code'],'title'=>$data['title']];
		foreach ($replace as $key => $value) {
			$content 	=	preg_replace("/{".$key."}/isUx",$value ,$content);
		}
		$data['web']['title_ch']='TaiHot';
		$data['content']=$content;
		$email=$this->input->post('email');//('.date("Y/m/d H:i").")"
		$content 	=	$this->load->view('front/emailsend',$data,true);
		//$content    =   $this->load->view('eshop/mail/mailTemplate',$data,true);
		$this->mail->Subject = 'TaiHot - 登入會員 '.date("Y/m/d H:i"); //設定郵件標題
		$this->mail->Body = $content; //設定郵件內容
		$this->mail->IsHTML(true); //設定郵件內容為HTML
		$this->mail->AddAddress($email, $email); //設定收件者郵件及名稱
		$result 	=	$this->mail->send();
		if($result){
			$this->session->set_userdata('loginCaptcha',$Captcha);
			$return	=	$this->ReturnHandle($result,$this->lang->line('mail_captcha_success2'));
		}else{
			log_message('error',$this->mail->ErrorInfo);
			$return	=	$this->ReturnHandle($result,$this->lang->line('Unknown_error'));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**兌現現金-發送驗證碼-ajax**/
	public function cashCaptcha(){
		$this->load->model('Cash_model','cash');
		try {
			if(!$this->session->userdata('user')['id'])
                throw new Exception('停留此頁面時間過久，請重新登入',1);

            $cash     =  $this->cash->get(['member_id'=>$this->session->userdata('user')['id'],'status'=>0]);

            if(!empty($cash))
            	throw new Exception('一次僅可兌現一筆，處理中不可再申請');

            $data['title']='提領現金';
			$Captcha['code']	=	random_string('numeric',6);
			$Captcha['time']	=	time()+60;
			$Captcha['time2']	=	time()+180;
			$content 	=	$this->Mail_type->GetMail(['id'=>2],['content'])[0]->content;
			$replace 	=	['nickname'=>$this->session->userdata('user')['name'],'USD'=>$this->input->post('USD'),'code'=>$Captcha['code'],'title'=>$data['title']];
			foreach ($replace as $key => $value) {
				$content 	=	preg_replace("/{".$key."}/isUx",$value ,$content);
			}

			$data['web']['title_ch']='TaiHot';
			$data['content']=$content;
			$email=$this->session->userdata('user')['username'];//('.date("Y/m/d H:i").")"
			$content 	=	$this->load->view('front/emailsend',$data,true);
			//$content    =   $this->load->view('eshop/mail/mailTemplate',$data,true);
			$this->mail->Subject = 'TaiHot - 提領現金發送驗證碼 '.date("Y/m/d H:i"); //設定郵件標題
			$this->mail->Body = $content; //設定郵件內容
			$this->mail->IsHTML(true); //設定郵件內容為HTML
			$this->mail->AddAddress($email, $email); //設定收件者郵件及名稱
			$result 	=	$this->mail->send();
			if($result){
				$this->session->set_userdata('loginCaptcha',$Captcha);
				$return	=	$this->ReturnHandle($result,$this->lang->line('mail_captcha_success2'));
			}else{
				log_message('error',$this->mail->ErrorInfo);
				throw new Exception($this->mail->ErrorInfo);
			}

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $error_msg = $e->getMessage();
            $err_url='';
            if($e->getCode()==1)$err_url='/member/login';
            $return = $this->ReturnHandle(false,$error_msg,$err_url);
        }

        //die();
        end:
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	public function TestSend(){
		$this->mail->Subject = "[ {$this->MailInfo->from_to} ] - 發送測試成功";
		$content 			 = '※本信件由系統自動寄出，請勿直接回覆。';
		$this->mail->Body = $content; //設定郵件內容 
		$this->mail->IsHTML(true); //設定郵件內容為HTML   
		$this->mail->AddAddress($this->input->post('email'), $this->input->post('email')); //設定收件者郵件及名稱  
		$result =	$this->mail->send();
		if($result){
			$return	=	$this->ReturnHandle($result,$this->lang->line('success'));
		}else{
			log_message('error',$this->mail->ErrorInfo);
			$return	=	$this->ReturnHandle($result,$this->lang->line('Unknown_error'));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

}
