<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'MY_Manager.php';

class Setting extends MY_Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
    }

    public function index()
    {
        $this->load->view('Backend/Complition/setting');
    }
    public function SettingEdit()
    {
        $jsonFile = $_SERVER["DOCUMENT_ROOT"].'/uploads/json/Setting.json';
        $data = $this->input->post();
        $json_strings = json_encode($data);
        if ( !write_file($jsonFile, $json_strings)){
            $return = $this->ReturnHandle(false, '檔案權限不足', '/Backend/Setting');
        }else{
            $return = $this->ReturnHandle(true, $this->lang->line('Update_Info_success'), '/Backend/Setting');
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

	public function Mail(){
		$this->load->model('Mail_model');
		$data['Mails']	=	$this->Mail_model->GetMail();
		$this->load->view('Backend/Management/mail',$data);
	}
	public function MailEdit($id=''){
		$this->load->model('Mail_model');
		$this->load->library('form_validation');
		if($this->form_validation->run()){
			$where 	=	['id'=>$id];
            $data   =   $this->input->post();
            $result     =   $this->Mail_model->update($data,$where);
            if($result){
                $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'),base_url('/Backend/Management/Mail'));
            }else{
                $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

}
