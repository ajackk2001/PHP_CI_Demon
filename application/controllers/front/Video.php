<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Front.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
class Video extends MY_Front {
	//視頻
	
	public function item_list(){
		//載入模版
		$this->load->view('front/video/video');
	}
}

/* End of file FrontController.php */
/* Location: ./application/controllers/front/FrontController.php */