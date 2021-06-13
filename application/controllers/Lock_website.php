<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lock_website extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

	}

	/**
	 * 關閉網站
	 */
	public function index()
	{

		//載入模版
		$this->load->view('front/lock_website');
	}


}

/* End of file Lock_website.php */
/* Location: ./application/controllers/Lock_website.php */