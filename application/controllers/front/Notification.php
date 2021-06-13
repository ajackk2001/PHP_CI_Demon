<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Front.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
class Notification extends MY_Front {
	//模特兒 創作者
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user') && !in_array($this->router->method, ["productCheck"]) && $this->input->method()=='get'){
			uri_string();
			if($this->router->method!='login'){
				redirect('member/login');
			}
		}

	}

	public function index(){
		$this->member_msg->update(['msg_status'=>1,],['member_id'=>$this->session->userdata('user')['id']]);
		//未讀訊息
        $this->msg_unread_quantitye = $this->member_msg->check_quantitye(['member_id' => $this->session->userdata('user')['id'], 'msg_status' => 0]);
		//載入模版
		$this->load->view('front/notification/index');
	}

	public function show(){
		$select = ['member_msg.*'];
		$conditions = [
			[
                'field' => ['member_id'],
                'operator' => '=',
                'value' => $this->session->userdata('user')['id'],
            ],
		];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['member_msg.create_time DESC'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        	$limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->member_msg->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->member_msg->row_count;

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}





}

/* End of file FrontController.php */
/* Location: ./application/controllers/front/FrontController.php */