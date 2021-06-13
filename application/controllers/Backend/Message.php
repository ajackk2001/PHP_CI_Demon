<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once "MY_Manager.php";
class Message extends MY_Manager {
	public function __construct(){
		parent::__construct();
	}

	public function Setting(){
		$this->load->view('Backend/Message/setting');
	}
    /**
        簡訊格式列表
    **/
    public function SettingList(){
        $this->load->model('Message_type');
        $where  =   [];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   [];
        foreach ($this->input->post() as $key => $value) {
            if(trim($value)!="" && !in_array($key, ['search','page','limit'])){
                $where[$key]    =   $value;
            }
        }
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');   
            $limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['total']    =   $this->Message_type->GetMessage($where,['count(id) as total'])[0]->total;
        $return['list']     =   $this->Message_type->GetMessage($where,['id','title','content','create_time','lock','update_time'],$orderby,$limit);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        簡訊格式新增
    **/
    public function SettingAdd(){
        $this->load->model('Message_type');
        $this->load->library('form_validation');
        if($this->form_validation->run()){
            $data                   =   $this->input->post();
            $data['create_time']    =   date('Y-m-d H:i:s');
            $return     =   $this->ReturnHandle( $this->Message_type->insert($data),$this->lang->line('Insert_success'));
        }else{ 
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
     /**
        簡訊格式內容
    **/
    public function SettingInfo($id){
        $this->load->model('Message_type');
        $where  =   [  'id'=>$id    ];
        $return     =  $this->Message_type->GetMessage($where,['id','title','content'])[0];
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        簡訊格式更新
    **/
    public function SettingEdit($id=''){
        $this->load->model('Message_type');
        $this->load->library('form_validation');
        if($this->form_validation->run()){
            $where  =   [
                            'id'    =>  $id,
                        ];
            $data   =   $this->input->post();
            $data['update_time']    =   date('Y-m-d H:i:s');
            $return     =  $this->ReturnHandle( $this->Message_type->update($data,$where),$this->lang->line('Update_Info_success'));
        }else{ 
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        簡訊格式刪除
    **/
    public function SettingDelete($id=''){
        $this->load->model('Message_type');
        $this->load->library('form_validation');
        if($this->form_validation->run()){
            $where  =   [
                            'id'    =>  $id,
                        ];
            $return     =  $this->ReturnHandle( $this->Message_type->delete($where),$this->lang->line('Delete_success'));
        }else{ 
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

	public function Send(){
        $this->load->model('Message_type');
        $this->load->model('Member_model');
        $this->load->model('Member_type');
        $mails  =   $this->Message_type->GetMessage([],['id','title','content']);
        $data['settings']   =   [];
        foreach ($mails as $mail) {
            $data['settings'][$mail->id]    =   $mail;
        }
        $data['members']    =   $this->Member_model->GetMember(['member.status'=>1]);
        $data['types']      =   $this->Member_type->GetMemberType();
		$this->load->view('Backend/Message/send',$data);
	}

	public function Record(){
		$this->load->view('Backend/Message/record');
	}
	/**
        簡訊發送列表
    **/
    public function RecordList(){
    	$this->load->model('Message_record');
    	$where	=	[];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['create_time DESC'];
    	foreach ($this->input->post() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['search','page','limit'])){
    			$where[$key]	=	$value;
    		}
    	}
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');   
            $limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['total']    =   $this->Message_record->GetMessageRecord($where,['count(member_id) as total'])[0]->total;
    	$return['list'] 	=	$this->Message_record->GetMessageRecord($where,['message_record.id','name','username','cellphone','content','push_date','message_record.create_time'],$orderby,$limit);
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

}
