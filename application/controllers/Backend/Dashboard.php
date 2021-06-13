<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";

class Dashboard extends MY_Manager {
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
	}

	public function index(){
		$this->load->view('Backend/dashboard');
	}
}
