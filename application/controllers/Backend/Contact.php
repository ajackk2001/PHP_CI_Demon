<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once "MY_Manager.php";
class Contact extends MY_Manager {
	public function __construct(){
		parent::__construct();
		$this->load->model('Contact_type');
        $this->load->model('Contact_model');
	}

	public function TypeIndex(){
		$this->load->view('Backend/Contact/contact_type');
	}

	public function TypeList(){
        $select     = ['id','title','seq','status','IFNULL(total.counts, 0) counts'];
        $limit      = ['offset'=>NULL,'limit'=>NULL];
        $orderby    = ['seq ASC'];
        $conditions = [];
    	foreach ($this->input->post() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['page','limit'])){
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
        $return['list']     =   $this->Contact_type->search($select, $conditions, $orderby, $limit);
        $return['total']    =   $this->Contact_type->row_count;
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	public function TypeAdd(){
		$this->load->library('form_validation');
		if($this->form_validation->run()){
            $data   =   $this->input->post();
            $result     =   $this->Contact_type->insert($data);
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

    public function TypeInfo($id=''){
        $return     =  $this->Contact_type->get($id);
        if(empty($return)) redirect('/Backend/ContactType');
        $this->output->set_content_type('application/json')->set_output(json_encode(current($return)));
    }

	public function TypeEdit($id=''){
		$this->load->library('form_validation');
		if($this->form_validation->run()){
			$where 	=	['id'=>$id];
            $data   =   $this->input->post();
            $result     =   $this->Contact_type->update($data,$where);
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

	public function TypeDelete($id=''){
        try{
            $original = $this->Contact_type->get(['id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->Contact_type->delete($where);
            if (!$result)
                throw new Exception($this->lang->line('Delete_fail'));
    
            $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));

        } catch (Exception $e) {
			$error_msg = $e->getMessage();
            $return = $this->ReturnHandle(false,$error_msg);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    
    public function UpdateSeq(){
        $data       =   $this->input->post('seq');
        $result     =   $this->Contact_type->updateSeq($data);
        if ($result){
            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_seq_success'));
        }else {
            $return     =   $this->ReturnHandle(false,$this->lang->line('Update_seq_fail'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function UpdateStatus($kind,$id){
        $data   =   $this->input->post();
        $where  =   ['id' =>  $id];
        $thisModel  = ($kind=='type')? $this->Contact_type:$this->Contact_model; 
        $result     = $thisModel->update($data,$where);
        if ($result){
            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
        }else {
            $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	public function Index(){
        $data['types']  =   $this->Contact_type->get(['status'=>1],['id','title'],['seq ASC']);
		$this->load->view('Backend/Contact/contact',$data);
	}

    public function List(){
        $select     = ['contact.*,contact_type.title'];
        $limit      = ['offset'=>NULL,'limit'=>NULL];
        $orderby    = ['id DESC'];
        $conditions = [];
    	foreach ($this->input->post() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['page','limit'])){
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
        $return['list']     =   $this->Contact_model->search($select, $conditions, $orderby, $limit);
        $return['total']    =   $this->Contact_model->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function Detail($id=''){
        $result    =   $this->Contact_model->get(['contact.id'=>$id],['contact.*,contact_type.title']);
        if(empty($result)) redirect('/Backend/Contact');
        $data['contact'] = current($result);
        $this->load->view('Backend/Contact/contact_detail',$data);
    }

    public function Edit($id=''){
        $this->load->library('form_validation');
        $where  =   ['id'=>$id];
        $this->form_validation->set_data($where);
        if($this->form_validation->run()){
            $data   =   $this->input->post();
            $result     =   $this->Contact_model->update($data,$where);
            if($result){
                $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'),base_url('Backend/Contact/Edit/'.$id));
            }else{
                $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function Delete($id=''){
        try{
            $original = $this->Contact_model->get(['contact.id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->Contact_model->delete($where);
            if (!$result)
                throw new Exception($this->lang->line('Delete_fail'));
    
            $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));

        } catch (Exception $e) {
			$error_msg = $e->getMessage();
            $return = $this->ReturnHandle(false,$error_msg);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

   public function Reply($id=''){
        $this->load->library('form_validation');
        $this->load->library('Mailer');
        $this->mail     =   $this->mailer->mail;
        $this->Contact_model->record    =   false;
        if($this->form_validation->run()){
            $this->load->model('Web_Info');
            $info = $this->Web_Info->GetWebInfo(['*'],['id'=>1])[0];
            $this->mail->Subject = $info->title_ch; //設定郵件標題
            $data2['content']    =   $this->input->post('content');
            $data2['title_ch']  = $info->title_ch;
            $this->mail->Body = $this->load->view('Backend/Contact/send',$data2,true);; //設定郵件內容 
            $this->mail->IsHTML(true); //設定郵件內容為HTML
            $this->mail->AddAddress($this->input->post('email'), $this->input->post('email')); //設定收件者郵件及名稱  
            $result     =   $this->mail->send();
            if($result){
                $data['reply_title']    =   $info->title_ch;
                $data['reply']          =   $this->input->post('content');
                $data['visit']          =   1;
                $data['reply_date']     =   date('Y-m-d H:i:s');
                $this->Contact_model->update($data,['id'=>$id]);
                $return =   $this->ReturnHandle($result,$this->lang->line('success'));
            }else{
                log_message('error',$this->mail->ErrorInfo);
                $return =   $this->ReturnHandle($result,$this->lang->line('Unknown_error'));
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }


}
