<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Front.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
class Special extends MY_Front {
	//特別企劃
	
	public function item_list(){
		//載入模版
		$this->load->view('front/special/special');
	}
}

/* End of file FrontController.php */
/* Location: ./application/controllers/front/FrontController.php */