<?php

/**
 * 
 */
class Share
{
	
	function __construct()
	{
		$this->CI 	=	& get_instance();
		
	}

	/**
        登入session
    **/
    public function SessionHandle($data){
        $this->session->set_userdata($data);
        if($this->session->userdata('id')){
            $data   =   [
                            'login_count'   =>  ($this->session->userdata('login_count'))+1,
                            'login_date'    =>  date('Y-m-d H:i:s'),
                        ];
            $this->Member_model->updata($data,['id'=>$this->session->userdata('id')]);
        }
    }
    /**
        回傳處理
    **/
    public function ReturnHandle($status,$msg='',$redirect=''){
        $ReturnHandle   =   ['status'   =>  $status,    'msg'   =>  $msg];
        if($redirect){
            $ReturnHandle['redirect']   =   $redirect;
        }
        return $ReturnHandle;
    }
    /**
        居住地区
    **/
    public function AreaHandle(){
        $areas  =   $this->List_area->GetArea();
        $new_areas  =   [];
        foreach ($areas as $area) {
            $new_areas[$area->city_sn][]    =   $area;
        }
        return $new_areas;
    }
    /**
        多重搜尋處理
    **/
    public function SearchHandle($orwhere_field,$value){
        $orwhere    =   '';
        $orwhere    .=  '(';
        $tmp =  [];
        foreach ($orwhere_field as $field) {
            $tmp[]  =   "`".$field."` LIKE '%".$value."%'";
        }
        $orwhere    .=  implode(" OR ", $tmp);
        $orwhere    .=  ')';
        return $orwhere;
    }
    /**
        會員註冊
    **/
    public function MemberRegister(){
            
        $unset  =   ['year','month','day','passwords','fileuploader-list-education_file','captcha'];
        $data   =   $this->input->post();
        $data['password']   =   password_hash($data['password'],PASSWORD_DEFAULT);
        if(!isset($data['birthday'])){
            $data['birthday']   =   $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day');
        }
        $data['create_time']    =   date('Y-m-d H:i:s');
        if($this->input->post('type')==2){
            $data['check']          =   1;
            $data['check_date']     =   date('Y-m-d H:i:s');
        }
        foreach($unset as $v){
            unset($data[$v]);
        }
        $this->Member_model->trans_start();
        /**判斷是否有相同帳號**/
        if(!$this->Member_model->GetMember(['username'=>$this->input->post('username')],['username'])){
            $result     =   $this->Member_model->insert($data);
            /**檢查會員是否新增成功**/
            if($result){
                $MemberId   =   $this->Member_model->insert_id();
                $this->UserData   =   [
                                    'id'            =>  $MemberId,
                                    'name'          =>  $this->input->post('name'),
                                    'nickname'      =>  $this->input->post('nickname'),
                                    'login_count'   =>  0,
                                ];
                /**判斷是否為服務專員上傳檔案**/
                if($this->input->post('type')==2){
                    if(!$this->upload_file($MemberId)){
                        $return =   $this->ReturnHandle(false,$this->lang->line('error_education_file'));
                        $this->Member_model->trans_rollback();
                    }else{
                        $return =   $this->ReturnHandle(true,$this->lang->line('success_register'),base_url());
                    }
                }else{
                    $return =   $this->ReturnHandle(true,$this->lang->line('success_register'),base_url());
                }
                
            }else{
                $return =   $this->ReturnHandle(false,$this->lang->line('error_register'));
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->lang->line('error_same_user'));
        }
        $this->Member_model->trans_complete();
        return $return;
    }
    /**
        多檔案上傳
    **/
    public function upload_file($MemberId=''){
        $this->load->library('upload',$this->upload_setting);
        $files = $_FILES;
        $TotalFile  =   count($_FILES['education_file']['name'])-1;
        if($TotalFile>0){
            for ($i = 0; $i < $TotalFile; $i ++) {
                $name = $files ['education_file'] ['name'] [$i];
                $_FILES['education_file']['name']       = $name;
                $_FILES['education_file']['type']       = $files ['education_file'] ['type'] [$i];
                $_FILES['education_file']['tmp_name']   = $files ['education_file'] ['tmp_name'] [$i];
                $_FILES['education_file']['error']      = $files ['education_file'] ['error'] [$i];
                $_FILES['education_file']['size']       = $files ['education_file'] ['size'] [$i];
                if($this->upload->do_upload('education_file')){
                    $this->FileData = $this->upload->data();
                    $data   =   [
                                    'member_id'     =>  $MemberId,
                                    'education'     =>  'uploads/education/'.$this->FileData['file_name'],
                                    'create_time'   =>  date('Y-m-d H:i:s'),
                                ];
                    if(!$this->Education->insert($data)){
                        return false;   
                    }
                }else{
                    return false;
                }
            }
        }elseif(count($this->Education->GetEducation(['member_id'=>$MemberId]))>0){
            return true;
        }else{
            return false;
        }
        return true;    
    }
    /**
        會員學歷更新
    **/
    public function UpdateMemberEducation($id=''){
        if($this->form_validation->run()){
            $unset  =   ['fileuploader-list-education_file'];
            $data   =   $this->input->post();
            $data['check']          =   1;
            $data['check_date']     =   date('Y-m-d H:i:s');
            $data['update_time']    =   date('Y-m-d H:i:s');
            foreach($unset as $v){
                unset($data[$v]);
            }
            $this->Member_model->trans_start();
            $result =   $this->Member_model->updata($data,['id'=>$id]);
            if($result){
                if(!$this->upload_file($id)){
                    $return =   $this->ReturnHandle(false,$this->lang->line('error_education_file'));
                    $this->Member_model->trans_rollback();
                }else{
                    $return =   $this->ReturnHandle($result,(($result)?$this->lang->line('Update_Info_success'):$this->lang->line('Update_Info_fail')),base_url('Member/Information'));
                }
            }else{
                $return =   $this->ReturnHandle($result,(($result)?$this->lang->line('Update_Info_success'):$this->lang->line('Update_Info_fail')),base_url('Member/Information'));
            }
            $this->Member_model->trans_complete();
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        return $return;
    }
    /**
        刪除學歷檔案
    **/
    public function DeleteMemberEducation($id=''){
        if($this->form_validation->run()){
            $this->load->model('Education');
            $this->Education->trans_start();
            $where  =   [
                            'member_id' =>  $id,
                        ];
            $TotalEduaction =   count($this->Education->GetEducation($where));
            if($TotalEduaction>1){
                $where['id']    =   $this->input->post('id');
                $result =   $this->Education->delete($where);
                if($result){
                    $return =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));
                }else{
                    $return =   $this->ReturnHandle(false,$this->lang->line('Delete_fail'));
                }
            }else{
                $return =   $this->ReturnHandle(false,$this->lang->line('Education_file_limit'));
            }
            $this->Education->trans_complete();
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        return $return;
    }
    /**
     * 更新會員通知
     */
    public function UpdataMsgCount(){
        $this->load->model('Member_msg_model');
        $msg_count = $this->Member_msg_model->get_list_count(['where'=>['member_id'=>$this->session->userdata('id'),'flag'=>'0']]);
        if (!$this->session->has_userdata('msg_count')) {
            $this->session->set_userdata('msg_count', $msg_count);
        } elseif ($this->session->has_userdata('msg_count') && $msg_count != $this->session->userdata('msg_count')) {
            $this->session->unset_userdata('msg_count');
            $this->session->set_userdata('msg_count', $msg_count);
        }
        return true;
    }
    /**
        檢查驗證碼
    **/
    public function CheckCaptcha($captcha){
        return (($captcha!="" && strtolower($captcha)==$this->session->userdata('Front'))?true:false);
    }
}

?>