<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊// 
class FrontController extends CI_Controller {

	public $cookie_lang =   '';
	public function __construct()
	{
		parent::__construct();
		$this->cookie_lang =   strtok($_SERVER['HTTP_ACCEPT_LANGUAGE'], ',');
		$this->load->model('Website_model','website');
		$this->load->helper('cookie');
        if(get_cookie('lang')){
            $this->cookie_lang  =   get_cookie('lang');
            $this->config->set_item('language',$this->cookie_lang);
            //$this->lang->load('basic_lang',$this->cookie_lang);
        }
		$this->load->model('Lang_model','language');
		$this->lang = strtok($_SERVER['HTTP_ACCEPT_LANGUAGE'], ',');
		//取出網站開關
		$website = $this->website->get_web_info();
		$website_open = $website['website_open'];
		$session_website_open = $this->session->userdata('sess_website_open');
		$session_admin_uid = $this->session->userdata('uid');
		$session_admin_user = $this->session->userdata('username');
		// var_dump($website_open);die;
		//網站關閉
		if( $website_open == 0 && $session_website_open!=1 && empty($session_admin_uid) && empty($session_admin_user) ){
			redirect('lock_website');
		}
	}

}

/* End of file FrontController.php */
/* Location: ./application/controllers/front/FrontController.php */