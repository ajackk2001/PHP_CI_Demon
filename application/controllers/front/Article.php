<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Front.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
class Article extends MY_Front {
	//最新消息分類清單
	public function __construct(){
		parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Articles_model');
        //$this->load->model('AboutForm_model');
    }
	public function privacy(){
		$data['privacy']     =  $this->Articles_model->get(['list_type'=>'privacy'],['*'])[0];
		//載入模版
		$this->load->view('front/article/privacy',$data);
	}
	public function terms(){
		$data['terms']     =  $this->Articles_model->get(['list_type'=>'terms'],['*'])[0];
		//載入模版
		$this->load->view('front/article/terms',$data);
	}
	public function faq(){
		$this->load->model('Faq_model','faq');
		$data['faq']     =  $this->faq->get(['status'=>1],['*'],['seq']);
		//載入模版
		$this->load->view('front/article/faq',$data);
	}

	public function over18(){
		$this->session->set_userdata('over18', 1);
	}
}

/* End of file FrontController.php */
/* Location: ./application/controllers/front/FrontController.php */