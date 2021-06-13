<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Manager extends CI_Controller {
    function __construct(){
        parent::__construct();
        if(!$this->session->has_userdata('Backend')){
            $this->load->helper('http');
            redirect('/Backend/Login');exit;
        }
    }
}