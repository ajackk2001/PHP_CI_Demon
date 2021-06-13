<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";

class Admin extends MY_Manager {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    const PASS_KEY = '70xk5v7nbZkQVrEGOECD';
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
        $this->load->model('Administrator');
	}

	/**
        管理員總管
    **/
    public function Index(){
        $this->load->view('Backend/Admin/manager');
    }
    /**
        權限列表
    **/
    public function Permission($id=''){
        $this->load->model('Admin_menu');
        $Admin_menu =   $this->Admin_menu->GetPermiisionList(['status'=>1,'url!='=>'Backend/Admin']); 
        $permission =   $this->Administrator->GetPermiision(['id'=>$id])[0];
        $data      =   get_object_vars($this->Administrator->GetAdminList(['id'=>$id])[0]);
        $data['permission']     =   [];
        if($permission->menu_permission){
            $data['permission'] =   json_decode($permission->menu_permission,true);
        }
        $menu   =   [];
        foreach ($Admin_menu as $k => $v) {
            if($v->menu_parent_id==0){
                $menu[$v->menu_id]['modal']  =   $v;
                $menu[$v->menu_id]['list']  =   [];
            }else if (isset($menu[$v->menu_parent_id])){
                $menu[$v->menu_parent_id]['list'][]  =   $v;
            }
        }
        $data['menus']  =    $menu;
        $data['id']     =   $id;
        $this->load->view('Backend/Admin/permission',$data);
    }
    /**
        管理員列表
    **/
    public function AdminList(){
    	$where	=	['status!='=>'2'];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['id asc'];
    	foreach ($this->input->get() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['search','page','limit'])){
    			$where['member.'.$key]	=	$value;
    		}
    	}
    	$orwhere_field	=	['name','nickname','username','cellphone'];
    	$orwhere	=	[];
    	if($this->input->get('search')){
    		$orwhere 	=	$this->SearchHandle($orwhere_field,$this->input->get('search'));
    	}
        if($this->input->get('page')&&$this->input->get('limit')){
            $limit['offset']    =   ($this->input->get('page')-1)*$this->input->get('limit');   
            $limit['limit']     =   $this->input->get('limit');
        }
        $return['page']     =   $this->input->get('page');
        $return['total']    =   $this->Administrator->GetAdminList($where,['count(id) as total'],$orwhere)[0]->total;
    	$return['list'] 	=	$this->Administrator->GetAdminList($where,['*'],$orwhere,$orderby,$limit);
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        更新管理員狀態
    **/
    public function AdminUpdateStatus($id=''){
        if($id){
            if($this->form_validation->run()){
                $where  =   [
                                'id'    =>  $id,
                            ];
                $data   =   $this->input->post();
                $result     =   $this->Administrator->update($data,$where);
                if($result){
                    $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
                }else{
                    $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
                }
            }else{
                $return =   $this->ReturnHandle(false,$this->lang->line('error_register'));
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->lang->line('Unknown_error'));
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        更新管理員
    **/
    public function AdminUpdate($id=''){
        if($id){
            if($this->form_validation->run()){
                $where  =   [
                                'id'    =>  $id,
                            ];
                $data   =   $this->input->post();
                $data['menu_permission']    =   '['.$this->input->post('permission').']';
                unset($data['permission']);
                if($data['password']!=''){
                    $data['password']   =   MD5($data['password'].self::PASS_KEY);
                }else{
                    unset($data['password']);
                }
                unset($data['passwords']);
                $result     =   $this->Administrator->update($data,$where);
                if($result){
                    $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'),base_url('Backend/Admin'));
                }else{
                    $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
                }
            }else{
                $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->lang->line('Unknown_error'));
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        刪除管理員
    **/
    public function AdminDelete($id=''){
        if($id){
            if($this->form_validation->run()){
                $where  =   [
                                'id'    =>  $id,
                            ];
                $data   =   ['status'=>2];
                $result     =   $this->Administrator->update($data,$where);
                if($result){
                    $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));
                }else{
                    $return     =   $this->ReturnHandle(false,$this->lang->line('Delete_fail'));
                }
            }else{
                $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->lang->line('Unknown_error'));
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        管理員新增
    **/
    public function AdminAdd(){
        $this->load->model('Administrator');
        $this->load->library('form_validation');
        if($this->form_validation->run()){
            $where  =   ['username' =>  $this->input->post('username'),'status!='=>2];
            $admin     =   $this->Administrator->GetAdminList($where);
            if(!$admin){
                $data                   =   $this->input->post();
                $data['password']       =   MD5($data['password'].self::PASS_KEY);
                $data['date_add']    =   date('Y-m-d H:i:s');
                $data['menu_permission']    =   '[]';
                unset($data['passwords']);
                $return     =   $this->ReturnHandle( $this->Administrator->insert($data),$this->lang->line('Insert_success'));
            }else{
                $return     =   $this->ReturnHandle(false,$this->lang->line('error_same_user'));
            }
        }else{ 
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        管理員登入紀錄
    **/
    public function LoginRecord(){
        $this->load->view('Backend/Admin/record');
    }

    /**
        管理員登入列表
    **/
    public function LoginRecordList(){
        $this->load->model('Admin_record');
        $where  =   [];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['create_time desc'];
        foreach ($this->input->post() as $key => $value) {
            if(trim($value)!="" && !in_array($key, ['search','page','limit'])){
                $where['member.'.$key]  =   $value;
            }
        }
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');   
            $limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['total']    =   $this->Admin_record->GetRecordList($where,['count(admin_record.id) as total'])[0]->total;
        $return['list']     =   $this->Admin_record->GetRecordList($where,['name','username','create_time','ip'],$orderby,$limit);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        修改密碼
    **/
    public function ChangePW(){
        
        if ($this->form_validation->run('Admin/ChangePW')) {
            $msg = '';
            $oldpw      = $this->input->post('oldpw');
            $newpw      = $this->input->post('newpw');
            $confirmpw  = $this->input->post('confirmpw');
            if ($newpw != $confirmpw) {
                $msg = '新密碼與確認密碼不相同';
            }

            if ($oldpw == $newpw) {
                $msg = '新密碼與舊密碼不得相同';
            }
            if ($msg == '') {
                $userdata = $this->Administrator->logincheck($this->session->userdata('Manager')->username,$oldpw);
                if (!is_object($userdata)){
                    $msg = $userdata;//'舊密碼輸入錯誤';
                }
            }

            if ($msg == '') {
                if (!$this->Administrator->ChangePassword($this->session->userdata('Manager')->id,$newpw)) {
                    $msg = '更新密碼失敗';
                }
            }

            if ($msg == '') {
                $return = $this->ReturnHandle(true, '密碼修改成功');
            } else {
                $return = $this->ReturnHandle(false, $msg);
            }
        }else{
            $return = $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        --------------------------------------------------------------------------------------------------------------------
    **/

}
