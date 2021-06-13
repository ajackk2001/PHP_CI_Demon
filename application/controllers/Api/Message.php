<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends MY_Controller {

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
	public $debug;

	public function __construct(){
		parent::__construct();
		$this->load->model('Message_record');
		$this->load->model('Message_model');
		$this->load->model('Member_model');
		$this->load->library('form_validation');
		// $this->load->helper('string');
		$this->MessageInfo 		=	$this->Message_model->GetMessageInfo(['id'=>1])[0];
		$this->Username			=	$this->MessageInfo->username;
		$this->Password 		=	$this->MessageInfo->password;
		$this->header 			= 	[];
	    $this->cookie_folder 	= 	APPPATH."/cookie";
	    $this->logs_folder 		= 	APPPATH."/logs/sms";
	    $this->curl_timeout 	= 	30000;
	    $this->url 				= 	$this->MessageInfo->host;
	    $this->cookie 			= 	'sms';
	    $this->useragent 		= 	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36';
	    $this->encoding 		= 	"UTF-8";
	    $this->post 			=	[];
	    $this->debug 			=	true;
	}

	public function Recive(){
		$this->log_file	=	'Request'.date('Y-m-d').'.log';
		$this->_logs($this->log_file,'-----'.$this->cookie.'------');
	    $this->_logs($this->log_file,'URL: '.current_url());
	    $this->_logs($this->log_file,'IP: '.$this->input->ip_address());
	    $this->_logs($this->log_file,'USERAGENT: '.$this->input->user_agent());
	    $this->_logs($this->log_file,'POST DATA: '.json_encode($this->input->post()));
	    $this->_logs($this->log_file,'-----------------');
	    echo "ok";
	}

	public function check(){
		$this->post 	=	[
								'username'	=>	$this->Username,
								'password'	=>	$this->Password,
							];
		$this->url 	=	$this->url.'api_query_credit.php';
		$content 	=	json_decode($this->curl(),true);
		$return 	=	(($content['stats'])?explode("|", $content['error_msg'])[1]:0);
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	public function test2(){
		/*
      $json = '[{"name":"%EF%BB%BF%E4%BD%95%E5%BF%B5%E5%BA%AD","phone":"0985072985"},{"name":"%E8%A8%B1%E5%BA%AD%E6%81%A9","phone":"0933052064"},{"name":"%E8%83%A1%E6%98%B1%E6%96%87","phone":"0984259774"},{"name":"%E6%B1%9F%E6%B7%91%E8%B2%9E","phone":"0938658031"},{"name":"%E6%9E%97%E8%BE%B0%E5%BD%A5","phone":"0985398597"},{"name":"%E6%9E%97%E5%BF%83%E6%B7%B3","phone":"0983189560"},{"name":"%E9%84%AD%E5%85%83%E7%90%A6","phone":"0908371658"},{"name":"%E5%BB%96%E6%97%BB%E6%BE%A4","phone":"0976711480"},{"name":"%E9%BB%83%E6%80%9D%E7%BF%94","phone":"0970961766"},{"name":"%E6%AE%B7%E7%B4%AB%E8%BB%92","phone":"0908788533"},{"name":"%E6%B1%9F%E4%BD%A9%E9%9B%AF","phone":"0963786430"},{"name":"%E5%8D%93%E7%B6%BA%E6%98%8E","phone":"0931384542"},{"name":"%E4%BD%99%E4%BD%A9%E7%92%87","phone":"0928698850"},{"name":"%E9%AB%98%E5%8D%83%E5%96%9C","phone":"0963711246"},{"name":"%E9%99%B3%E7%AD%B1%E8%87%BB","phone":"0988234085"},{"name":"%E6%9E%97%E6%85%A7%E7%91%9C","phone":"0905653703"},{"name":"%E8%94%A1%E9%9B%A8%E7%92%87","phone":"0985862268"},{"name":"%E8%AC%9D%E5%B2%B3%E4%BC%B6","phone":"0965163162"},{"name":"%E8%83%A1%E5%AE%B6%E7%B6%BA","phone":"0907817226"},{"name":"%E8%95%AD%E8%8E%89%E5%A9%95","phone":"0936565790"},{"name":"%E9%84%AD%E7%8F%BA%E8%94%A7","phone":"0979324015"},{"name":"%E6%96%B9%E6%A6%86","phone":"0919493744"},{"name":"%E8%AC%9D%E4%BD%B3%E5%A6%A4","phone":"0905093973"},{"name":"%E9%82%B1%E7%90%AC%E6%99%B4","phone":"0989890918"},{"name":"%E5%BB%96%E4%B8%B9%E7%90%AA","phone":"0913727111"},{"name":"%E9%99%B3%E5%A9%89%E6%9F%94","phone":"0976538705"},{"name":"%E5%AD%AB%E6%95%AC%E9%9B%AF","phone":"0970963182"},{"name":"%E5%BB%96%E7%8E%89%E9%9B%B2","phone":"0968520052"},{"name":"%E5%BC%B5%E7%91%8B%E7%8F%8A","phone":"0906782999"},{"name":"%E6%9E%97%E5%BD%A9%E5%A8%9F","phone":"0970186036"},{"name":"%E8%97%8D%E6%B9%89","phone":"0975036341"},{"name":"%E6%9D%8E%E6%9B%89%E5%AD%98","phone":"0905647781"},{"name":"%E5%BC%B5%E8%95%8E%E7%91%9C","phone":"0972766925"},{"name":"%E5%8A%89%E9%A6%99%E5%90%9F","phone":"0958322646"},{"name":"%E5%BB%96%E7%B4%AB%E7%A1%AF","phone":"0938136336"},{"name":"%E6%9D%8E%E7%BE%BD%E4%BF%AE","phone":"0983122955"},{"name":"%E8%B6%99%E7%8F%AE%E5%9C%BB","phone":"0911576296"},{"name":"%E6%9D%8E%E5%BA%AD%E8%96%B0","phone":"0988766092"},{"name":"%E8%A9%B9%E5%AE%9C%E8%87%BB","phone":"0911771749"},{"name":"%E5%BB%96%E5%87%B0%E6%A3%8B","phone":"0918251778"},{"name":"%E9%99%B3%E5%AD%9F%E7%AD%A0","phone":"0975872397"},{"name":"%E9%84%AD%E8%87%B3%E5%96%AC","phone":"0933178940"},{"name":"%E7%8E%8B%E9%A1%97%E6%85%88","phone":"0905315571"},{"name":"%E9%99%B3%E5%AE%A5%E5%BB%B7","phone":"0909532036"},{"name":"%E7%8E%8B%E5%A7%B5%E7%92%87","phone":"0928331175"},{"name":"%E9%BB%83%E8%A9%A9%E8%AB%AD","phone":"0970891138"},{"name":"%E6%9E%97%E4%BD%B3%E8%B3%A2","phone":"0935900521"},{"name":"%E5%BE%90%E8%A9%A9%E6%99%B4","phone":"0978076025"},{"name":"%E6%9E%97%E7%A7%91%E7%91%84","phone":"0979886990"},{"name":"%E6%B1%9F%E7%8F%88%E7%91%A9","phone":"0925629586"},{"name":"%E5%BE%90%E5%AD%9F%E7%B6%BA","phone":"0905529472"},{"name":"%E5%90%B3%E5%BF%B5%E6%85%88","phone":"0984300547"},{"name":"%E5%AE%8B%E5%A7%BF%E5%84%80","phone":"0981794347"},{"name":"%E6%A5%8A%E9%9B%85%E9%9B%AF","phone":"0909897070"},{"name":"%E5%8A%89%E5%B3%BB%E5%BB%B7","phone":"0965454825"},{"name":"%E6%9E%97%E4%BD%B3%E8%B3%A2","phone":"0935900521"},{"name":"%E6%B4%AA%E5%8D%83%E9%9B%85","phone":"0975005562"},{"name":"%E9%BB%83%E6%B8%9D%E7%8F%8A","phone":"0906159204"},{"name":"%E9%BB%83%E7%BE%BD%E7%91%88","phone":"0934135642"},{"name":"%E6%9E%97%E5%B0%B9%E5%96%AC","phone":"0930060596"},{"name":"%E9%99%B3%E5%A7%BF%E4%BC%B6","phone":"0972263623"},{"name":"%E6%A5%8A%E7%9F%A5%E7%91%9B","phone":"0975238530"},{"name":"%E6%A5%8A%E8%8C%B9%E4%BA%91","phone":"0968491338"},{"name":"%E6%9E%97%E4%BD%B3%E8%B3%A2","phone":"0935900521"},{"name":"%E6%9E%97%E4%BD%B3%E8%B3%A2","phone":"0935900521"},{"name":"%E9%99%B3%E6%80%9D%E6%B8%9D","phone":"0972314709"},{"name":"%E6%A5%8A%E7%90%A6%E5%AE%89","phone":"0905200551"}]';
     //echo  urldecode($json);
     $arr = json_decode(urldecode($json), true);
     echo "<pre>";
    //1 print_r($arr);
     foreach ($arr as $key => $v) {
    		$uid = uniqid(uniqid());
       //密碼加密
		$password = password_hash($v['phone'], PASSWORD_DEFAULT);
       echo "INSERT INTO `administrator` (`menu_permission`,`name`, `uid`, `permission_type`, `username`, `password`, `date_add`) VALUES ( '[\"49\",\"54\"]' ,'".$v['name']."', '".$uid."', 'manager', '".$v['phone']."', '".$password."', '".date("Y-m-d H:i:s")."');<br>";
     }
     die();	*/
		$file = fopen('./uploads/test.csv','r');
		//$file = fopen('windows_2011_s.csv','r'); 
		while ($data = fgetcsv($file)) { //每次讀取CSV裡面的一行內容
		//print_r($data); //此為一個數組，要獲得每一個數據，訪問陣列下標即可
		$d=['name'=>urlencode($data[0]),'phone'=>'0'.$data[1]];
		$goods_list[] = $d;
		 }
		 echo "<pre>";
		 echo  $goods_list = json_encode($goods_list);
		//print_r($goods_list);
		/* foreach ($goods_list as $arr){
		    if ($arr[0]!=""){
		        echo $arr[0]."<br>";
		    }
		} */
		 //echo $goods_list[2][0];
		 fclose($file);
	}

	public function test(){
		$this->post 	=	[
								'username'	=>	$this->Username,
								'password'	=>	$this->Password,
								'method'	=>	'2',
								'sms_msg'	=>	'2',
								'phone'		=>	'',
								'send_date'	=>	'2018/11/15',
								'hour'		=>	'12',
								'min'		=>	'01',
							];
		$this->url 	=	$this->url.'api_send.php';
		echo $this->curl();
	}

	public function Send($method,$content,$phone){
			$this->url 	=	$this->url.'api_send.php';
			$this->post 	=	[
									'username'	=>	$this->Username,
									'password'	=>	$this->Password,
									'method'	=>	$method,
									'sms_msg'	=>	$content,
									'phone'		=>	$phone,
								];
			$curl 	=	json_decode($this->curl(),true);
			$result		=	$curl['stats'];
			if($result){
				$this->Recording(0,$content,$phone);
				return true;
			}else{
				log_message('error',$content['error_code'].' : '.$content['error_msg']);
				return false;
			}
	}

	public function SendMessage(){
		if($this->form_validation->run()){
			$this->load->model('Member_model');
			$this->load->model('Message_record');
			$this->Message_record->record 	=	false;
			$where			=	[
									'member.status'	=>	1,
								];
			$fields			=	['id','username','name','nickname','sex','cellphone'];
			$limit			=	['limit'=>NULL,'offset'=>NULL];
			switch ($this->input->post('send_type')) {
				case 'all':
					$members	=	$this->Member_model->GetMember($where,$fields);
					break;
				case 'type':
					$orwhere_field	=	['type','type'];
					if($this->input->post('member_type')){
						$members	=	$this->Member_model->GetMember($where,$fields,[],[],$limit,'type',$this->input->post('member_type'));
					}else{
						$members	=	[];
					}
					break;
				case 'select':
					$members	=	$this->Member_model->GetMember($where,$fields,[],[],$limit,'id',$this->input->post('member_select'));
					break;
			}
			if(count($members)<=250){
				$send_phone		=	[];
				foreach ($members as $member) {
					if($member->cellphone){
						$send_phone[]	=	$member->cellphone;
					}
				}
				$this->url 	=	$this->url.'api_send.php';
				$this->post 	=	[
										'username'	=>	$this->Username,
										'password'	=>	$this->Password,
										'method'	=>	$this->input->post('push_time_type'),
										'sms_msg'	=>	$this->input->post('content'),
										'phone'		=>	implode(",", $send_phone),
									];
				if($this->input->post('push_time_type')==2){
					$time 	=	$this->input->post('push_time');
					$this->post['send_date']	=	date('Y/m/d',strtotime($time));
					$this->post['hour']	=	date('H',strtotime($time));
					$this->post['min']	=	date('i',strtotime($time));
				}
				$content 	=	json_decode($this->curl(),true);
				$result		=	$content['stats'];
				if($result){
					foreach ($members as $member) {
						$this->Recording($member->id);
					}
					$return	=	$this->ReturnHandle($result,$this->lang->line('success'));
				}else{
					log_message('error',$content['error_code'].' : '.$content['error_msg']);
					$return	=	$this->ReturnHandle($result,$this->lang->line('Unknown_error'));
				}
			}else{
				$return	=	$this->ReturnHandle(false,$this->lang->line('Member_limit_250'));
			}

		}else{
			$return = 	$this->ReturnHandle(false,$this->form_validation->error_array());
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	public function Recording($id,$content='',$phone=''){
		$data	=	[
						'member_id'		=>	$id,
						'content'		=>	($content)?$content:$this->input->post('content'),
						'push_type'		=>	$this->input->post('push_time_type'),
						'push_date'		=>	(($this->input->post('push_time') && $this->input->post('push_time_type')==2)?$this->input->post('push_time'):date('Y-m-d H:i:s')),
						'create_time'	=>	date('Y-m-d H:i:s'),
						'phone'  		=>  $phone
					];
		$this->Message_record->insert($data);
	}

	public function curl(){
		if(!is_dir($this->cookie_folder)){
			mkdir($this->cookie_folder);
		}
		$this->log_file = $this->cookie."_".date("Y-m-d_His");
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
	    curl_setopt($ch, CURLOPT_HEADER,0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_URL, $this->url);
	    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
	    curl_setopt($ch, CURLOPT_ENCODING, $this->encoding);
	    curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
	    curl_setopt($ch, CURLOPT_FORBID_REUSE, TRUE);
	    curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_folder."/".$this->cookie);
    	curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_folder."/".$this->cookie);	
	    if($this->post){
	        curl_setopt($ch, CURLOPT_POST, 1); 
	        if(is_array($this->post)){
	        	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->post));	
	        }else{
	        	curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
	        }
	        $this->data = http_build_query($this->post);
	    }else{
	    	$this->data = '';
	    }
	    $contents = curl_exec($ch);
	    $this->_logs($this->log_file,'-----'.$this->cookie.'------');
	    $this->_logs($this->log_file,'URL: '.$this->url);
	    $this->_logs($this->log_file,'DATA: '.$this->data);
	    if(curl_error($ch)!=''){
	    	$this->curl_error = curl_error($ch);
	    	$this->curl_errno = curl_errno($ch);
	    	$this->_logs($this->log_file,'CURL ERRORNO: '.$this->curl_errno);
	    	$this->_logs($this->log_file,'CURL ERROR: '.$this->curl_error);
	    }
	    $this->_logs($this->log_file,$contents);
	    $this->_logs($this->log_file,'-----------------');
	    curl_close($ch);
	    $this->post = '';
	    return $contents;
	}

	public function _logs($filename,$data){
		if(!is_dir($this->logs_folder)){
			mkdir($this->logs_folder);
		}

		if(is_array($data)){
			$data = json_encode($data);
		}

		error_log('['.date('Y-m-d H:i:s').']'.$data.PHP_EOL,3,$this->logs_folder."/".$filename);
	}

	/**會員註冊-發送手機驗證碼**/
	public function Captcha(){
		$this->load->helper('string');
		$this->load->model('Message_type');
		$this->load->model('Member_model');
		if($this->form_validation->run()){
			if($this->Member_model->get(['username'=>$this->input->post('cellphone')],['username'])){
	            $return =   $this->ReturnHandle(false,$this->lang->line('error_same_cellphone'));
	        }else{
	        	if(!isset($this->session->userdata('Message')['time2']) || ($this->session->userdata('Message')['time2']<=time())){
					$Captcha['code']	=	random_string('numeric',6);
					$Captcha['time']	=	time()+60;
					$Captcha['time2']	=	time()+180;
					$Captcha['phone']	=	$this->input->post('cellphone');
					$content 	=	str_replace(['{code}'], [$Captcha['code']], $this->Message_type->GetMessage(['id'=>2],['content'])[0]->content);
					$result		=	(!$this->debug)?$this->Send(1,$content,$this->input->post('cellphone')):true;
					$result		=	$this->Send(1,$content,$this->input->post('cellphone'));
					if($result){
						$this->session->set_userdata('Message',$Captcha);
						$return =   $this->ReturnHandle($result,$this->lang->line('Message_captcha_success'));
						//$return['code']=$Captcha['code'];
					}else{
						$return =   $this->ReturnHandle($result,$this->lang->line('Message_captcha_fail '));
					}
				}else{
					$return =   $this->ReturnHandle(false,str_replace(['{second}'], [$this->session->userdata('Message')['time2']-time()], $this->lang->line('Message_captcha_sent')));
					$return['time']=$this->session->userdata('Message')['time']-time();
				}
	        }
		}else{
			$return = 	$this->ReturnHandle(false,$this->form_validation->error_array());
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**忘記密碼-發送手機驗證碼**/
	public function Captcha2(){
		$this->load->helper('string');
		$this->load->model('Message_type');
		$this->load->model('Member_model');
		if(!$this->Member_model->GetMember(['username'=>$this->input->post('cellphone')],['username'])){
	        $return =   $this->ReturnHandle(false,$this->lang->line('error_phone_username'));
        }else{
        	if(!isset($this->session->userdata('forget')['time']) || ($this->session->userdata('forget')['time']<=time())){
				$Captcha['code']	=	random_string('numeric',6);
				$Captcha['time']	=	time()+30;
				$Captcha['time2']	=	time()+180;
				$Captcha['phone']	=	$this->input->post('cellphone');
				$content 	=	str_replace(['{code}'], [$Captcha['code']], $this->Message_type->GetMessage(['id'=>2],['content'])[0]->content);
				$result		=	(!$this->debug)?$this->Send(1,$content,$this->input->post('cellphone')):true;
				$result		=	$this->Send(1,$content,$this->input->post('cellphone'));
				if($result){
					$this->session->set_userdata('forget',$Captcha);
					$return =   $this->ReturnHandle($result,$this->lang->line('Message_captcha_success'));
				}else{
					$return =   $this->ReturnHandle($result,$this->lang->line('Message_captcha_fail '));
				}
			}else{
				$return =   $this->ReturnHandle(false,str_replace(['{second}'], [$this->session->userdata('forget')['time']-time()], $this->lang->line('Message_captcha_sent')));
				$return['time']=$this->session->userdata('forget')['time']-time();
			}
        }
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**會員更改密碼-發送手機驗證碼**/
	public function passwordCaptcha(){
		$this->load->helper('string');
		$this->load->model('Message_type');
		$this->load->model('Member_model');
		if($this->session->userdata('id')){
			$type=$this->input->post('type');
			if(!isset($this->session->userdata($type)['time']) || ($this->session->userdata($type)['time']<=time())){
				$Captcha['code']	=	random_string('numeric',6);
				$Captcha['time']	=	time()+60;
				$Captcha['time2']	=	time()+180;
				$content 	=	str_replace(['{code}'], [$Captcha['code']], $this->Message_type->GetMessage(['id'=>2],['content'])[0]->content);
				$phone=$this->input->post('value');
				$result		=	(!$this->debug)?$this->Send(1,$content,$phone):true;
				$result		=	$this->Send(1,$content,$phone);
				if($result){
					$this->session->set_userdata($type,$Captcha);
					$return =   $this->ReturnHandle($result,$this->lang->line('Message_captcha_success'));
				}else{
					$return =   $this->ReturnHandle($result,$this->lang->line('Message_captcha_fail '));
				}
			}else{
				$return =   $this->ReturnHandle(false,str_replace(['{second}'], [$this->session->userdata($type)['time']-time()], $this->lang->line('Message_captcha_sent')));
				$return['time']=$this->session->userdata($type)['time']-time();
			}
		}else{
			$return = 	$this->ReturnHandle(false,'此操作須登入會員使用。');
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	public function look(){
		print_r($this->session->userdata('Message'));
	}

}
