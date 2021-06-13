<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Manager extends MY_Controller {
	public $menu;
	public $nav	=	[];
	public $current;
	public $issuper = false;
    public function __construct(){
        parent::__construct();
        if(!$this->session->has_userdata('Manager')){
            redirect('/Backend/Login');exit;
        }else{
        	$this->load->model('Administrator','admin');
            $this->load->model('Admin_record');
            $this->load->model('Operation_record');
            $this->load->model('Web_Info');
        	$current = (in_array($this->uri->uri_string(),['Backend/Dashboard','Backend/Admin/ChangePW']))?$this->uri->uri_string() : $this->admin->PermissionCheck($this->uri->uri_string());
        	$this->issuper = $this->session->userdata('Manager')->permission_type == "superadmin";
    		/*
            if(  (sizeof($this->session->userdata('Manager')->menu_permission) == 0 || !isset($current->menu_id) ||
                !in_array($current->menu_id,$this->session->userdata('Manager')->menu_permission)) && !$this->issuper && !in_array($current,['Backend/Dashboard','Backend/Admin/ChangePW'])
            ){
    			echo '<script>alert("沒有權限");window.location="/Backend/Login";</script>';exit;
    		}*/
            $data   =   [];
    		foreach ($this->admin->GetMenuList() as $k => $v) {
    			if(in_array($v->menu_id,$this->session->userdata('Manager')->menu_permission) || ($this->issuper && count($this->session->userdata('Manager')->menu_permission)==0)){
                    $v->url = ($v->url!="")?"/".$v->url:"javascript:void(0);";
                    if($v->menu_parent_id == 0){
                        $data[$v->menu_id]['data'] = $v;
                    }else{
                        if(isset($data[$v->menu_parent_id])){
                            $data[$v->menu_parent_id]['sub'][] = $v;
                        }
                    }
                    $this->menu[$v->menu_id]    =   $v;
                }
	        }
	        if(isset($current->menu_parent_id) && $current->menu_parent_id!=0){
	        	$this->CurrentHandle($current->menu_parent_id);
            }
            $this->current 	= $current;

    		$this->menu = $data;

            $this->record   =   $this->Admin_record->GetRecordList(['create_time >'=>date('Y-m-d 00:00:00')],['ip','name','create_time'],['create_time desc'],['limit'=>5,'offset'=>0]);

            $this->operation_record    =   $this->Operation_record->search(['operation_record.date_add','name','action'],[],['operation_record.date_add desc'],['limit'=>10,'offset'=>0]);

            if (is_array($this->session->userdata('Manager')->menu_permission)) {
                $this->ShowMsg = in_array('38',$this->session->userdata('Manager')->menu_permission);
            } else {
                $this->ShowMsg = preg_match("/\"38\"/i", json_encode($this->session->userdata('Manager')->menu_permission));
            }
            $web_info   =   $this->Web_Info->GetWebInfo(['title_ch','icon'])[0];
            $this->web_title    =   $web_info->title_ch;
            $this->web_icon     =   $web_info->icon;

        }
    }

    public function CurrentHandle($menu_id){
        if(isset($this->menu[$menu_id])){
            if($this->menu[$menu_id]->menu_parent_id!=0){
                $this->CurrentHandle($this->menu[$menu_id]->menu_parent_id);
            }
            $this->nav[]    =   $this->menu[$menu_id];
        }
    }


    public function uploadFileAction($action,$filePath,$file=[]){
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        if (substr($documentRoot, -1) !== '/') {
            $documentRoot .= '/';
        }

        if ($action == 'upload' && !empty($file)){
            if ($file['error']>0)
                throw new Exception('檔案上傳錯誤');

            if (file_exists($documentRoot.$filePath))
                throw new Exception('檔案存在');
            
            if(!is_uploaded_file($file['tmp_name']))
                throw new Exception($file['name'].' is not uploaded via HTTP POST');

            if(!move_uploaded_file($file['tmp_name'],$documentRoot.$filePath))
                throw new Exception($file['name'].' 上傳失敗');

            return $filePath;
        }else if ($action == 'delete'){
            @unlink($documentRoot.$filePath);
            return true;
        }else{
            throw new Exception('執行錯誤');
        }
    }

}