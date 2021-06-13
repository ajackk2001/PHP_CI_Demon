<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once "MY_Manager.php";
class Broadcast extends MY_Manager {
	public function __construct(){
		parent::__construct();
	}

	public function Setting(){
		$this->load->view('Backend/Broadcast/setting');
	}
	/**
        推波設定列表
    **/
    public function SettingList(){
    	$this->load->model('Broadcast_model');
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
        $return['total']    =   $this->Broadcast_model->GetBroadcast($where,['count(id) as total'])[0]->total;
    	$return['list'] 	=	$this->Broadcast_model->GetBroadcast($where,['id','title','create_time'],$orderby,$limit);
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        推波設定新增
    **/
    public function SettingAdd(){
    	$this->load->model('Broadcast_model');
    	$this->load->library('form_validation');
        if($this->form_validation->run()){
            $data   				=   $this->input->post();
            $data['create_time']	=   date('Y-m-d H:i:s');
            $return     = 	$this->ReturnHandle( $this->Broadcast_model->insert($data),$this->lang->line('Insert_success'));
        }else{ 
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
     /**
        推波設定內容
    **/
    public function SettingInfo($id){
    	$this->load->model('Broadcast_model');
    	$where  =   [  'id'=>$id 	];
        $return     =  $this->Broadcast_model->GetBroadcast($where,['id','title','content'])[0];
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        推波設定更新
    **/
    public function SettingEdit($id=''){
    	$this->load->model('Broadcast_model');
    	$this->load->library('form_validation');
        if($this->form_validation->run()){
            $where  =   [
                            'id'    =>  $id,
                        ];
            $data   =   $this->input->post();
            $return     =  $this->ReturnHandle( $this->Broadcast_model->update($data,$where),$this->lang->line('Update_Info_success'));
        }else{ 
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        推波設定刪除
    **/
    public function SettingDelete($id=''){
    	$this->load->model('Broadcast_model');
    	$this->load->library('form_validation');
        if($this->form_validation->run()){
            $where  =   [
                            'id'    =>  $id,
                        ];
            $return     =  $this->ReturnHandle( $this->Broadcast_model->delete($where),$this->lang->line('Delete_success'));
        }else{ 
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

	public function Record(){
		$this->load->view('Backend/Broadcast/record');
	}
	/**
        推波紀錄列表
    **/
    public function RecordList(){
    	$this->load->model('Broadcast_record');
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
        $return['total']    =   $this->Broadcast_record->GetBroadcastRecord($where,['count(id) as total'])[0]->total;
    	$return['list'] 	=	$this->Broadcast_record->GetBroadcastRecord($where,['id','member_id','content','create_time'],$orderby,$limit);
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
}
