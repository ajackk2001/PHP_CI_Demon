<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once "MY_Manager.php";
class Mail extends MY_Manager {
	public function __construct(){
		parent::__construct();
	}

	public function Setting(){
        $this->load->view('Backend/Mail/setting');
	}
    /**
        郵件格式列表
    **/
    public function SettingList(){
        $this->load->model('Mail_type');

        $select     = ['id','title','content','create_time','lock','update_time'];
        $limit      = ['offset'=>NULL,'limit'=>NULL];
        $orderby    = ['id ASC'];
        $conditions = [];
    	foreach ($this->input->post() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['search','page','limit'])){
                $conditions[0][] = [
                    'field' => $key,
                    'operator' => '=',
                    'value' => $value
                ];
    		}
    	}
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');   
            $limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->Mail_type->search($select, $conditions, $orderby, $limit);
        $return['total']    =   $this->Mail_type->row_count;

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        郵件格式新增
    **/
    public function SettingAdd(){
        $this->load->model('Mail_type');
        $this->load->library('form_validation');
        if($this->form_validation->run()){
            $data                   =   $this->input->post();
            $data['create_time']    =   date('Y-m-d H:i:s');
            $return     =   $this->ReturnHandle( $this->Mail_type->insert($data),$this->lang->line('Insert_success'));
        }else{ 
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        郵件格式內容
    **/
    public function SettingInfo($id){
        $this->load->model('Mail_type');
        $return     =  $this->Mail_type->get($id,['id','title','content']);
        $this->output->set_content_type('application/json')->set_output(json_encode(current($return)));
    }
    /**
        郵件格式更新
    **/
    public function SettingEdit($id=''){
        $this->load->model('Mail_type');
        $this->load->library('form_validation');
        if($this->form_validation->run()){
            $where  =   [
                            'id'    =>  $id,
                        ];
            $data   =   $this->input->post();
            $data['update_time']    =   date('Y-m-d H:i:s');
            $return     =  $this->ReturnHandle( $this->Mail_type->update($data,$where),$this->lang->line('Update_Info_success'));
        }else{ 
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        郵件格式刪除
    **/
    public function SettingDelete($id=''){
        $this->load->model('Mail_type');
        $this->load->library('form_validation');
        if($this->form_validation->run()){
            $where  =   [
                            'id'    =>  $id,
                        ];
            $return     =  $this->ReturnHandle( $this->Mail_type->delete($where),$this->lang->line('Delete_success'));
        }else{ 
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function SettingAjax() {
        $this->load->model('WebsiteMailServer');
        parse_str(file_get_contents("php://input"),$put);
        if ($this->WebsiteMailServer->update($put,['id'=>'1'])) {
            $return = $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
        }else{
            $return = $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));

    }

	public function Send(){
        $this->load->model('Mail_type');
        $this->load->model('Member_model');
        $this->load->model('Member_type');
        $mails  =   $this->Mail_type->get(['status'=>1],['id','title','content']);
        $data['settings']   =   [];
        foreach ($mails as $mail) {
            $data['settings'][$mail->id]    =   $mail;
        }
        $data['members']    =   $this->Member_model->get(['member.status'=>1]);
        $data['types']      =   $this->Member_type->GetMemberType();
		$this->load->view('Backend/Mail/send',$data);
	}

	public function Record(){
		$this->load->view('Backend/Mail/record');
	}
	/**
        郵件發送列表
    **/
    public function RecordList(){
    	$this->load->model('Mail_record');
        $select     = ['mail_record.id','mail_record.title','mail_record.content','mail_record.push_date','mail_record.create_time','(case when contact.email is not null then contact.email when admin.username is not null then admin.username end) username','(case  when contact.name is not null then contact.name when admin.name is not null then admin.name end) name'];
        $limit      = ['offset'=>NULL,'limit'=>NULL];
        $orderby    = ['push_date DESC'];
        $conditions = [];
    	foreach ($this->input->post() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['search','page','limit'])){
    			$conditions[0][] = [
                    'field' => $key,
                    'operator' => '=',
                    'value' => $value,
                ];
    		}
    	}
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');   
            $limit['limit']     =   $this->input->post('limit');
        }

        $return['list']     =   $this->Mail_record->search($select, $conditions, $orderby, $limit);
        $return['total']    =   $this->Mail_record->row_count;

        $return['page']     =   $this->input->post('page');
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        收件信箱總管
    **/
    public function Receive(){
        $this->load->model('Mail_receive_type');
        $data['mail_send_type'] =   $this->Mail_receive_type->get(['status'=>1],['*']);
        $this->load->view('Backend/Mail/receive',$data);
    }
	/**
        收件信箱列表
    **/
    public function ReceiveList(){
        $this->load->model('Mail_receive');
        $select     = ['website_mail_send.*','website_mail_send_type.title as type_title'];
        $limit      = ['offset'=>NULL,'limit'=>NULL];
        $orderby    = ['id DESC'];
        $conditions = [];
    	foreach ($this->input->post() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['search','page','limit'])){
    			$conditions[0][] = [
                    'field' => $key,
                    'operator' => '=',
                    'value' => $value,
                ];
    		}
    	}
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');   
            $limit['limit']     =   $this->input->post('limit');
        }

        $return['list']     =   $this->Mail_receive->search($select, $conditions, $orderby, $limit);
        $return['total']    =   $this->Mail_receive->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
	/**
        新增收件信箱
    **/
    public function ReceiveAdd(){
        $this->load->library('form_validation');
        $this->load->model('Mail_receive');
        if($this->form_validation->run()){
            $data   =   $this->input->post();
            $result     =   $this->Mail_receive->insert($data);
            if($result){
                $return     =   $this->ReturnHandle(true,$this->lang->line('Insert_success'));
            }else{
                $return     =   $this->ReturnHandle(false,$this->lang->line('Insert_fail'));
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
	/**
        編輯收件信箱
    **/
    public function ReceiveEdit($id=''){
        $this->load->library('form_validation');
        $this->load->model('Mail_receive');
        if($this->form_validation->run()){
            $where  =   ['id'=>$id];
            $data   =   $this->input->post();
            $result     =   $this->Mail_receive->update($data,$where);
            if($result){
                $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
            }else{
                $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
	/**
        刪除收件信箱
    **/
    public function ReceiveDelete($id=''){
        if($id){
            $this->load->model('Mail_receive');
            $where  =   ['id'=>$id];
            $result     =   $this->Mail_receive->delete($where);
            if($result){
                $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));
            }else{
                $return     =   $this->ReturnHandle(false,$this->lang->line('Delete_fail'));
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->lang->line('Unknoew_error'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        收件信箱
    **/
    public function ReceiveInfo($id){
        $this->load->model('Mail_receive');
        $return     =  $this->Mail_receive->get($id,['*']);
        $this->output->set_content_type('application/json')->set_output(json_encode(current($return)));
    }

}
