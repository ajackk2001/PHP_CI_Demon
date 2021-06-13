<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";
class Articles extends MY_Manager {


	public function __construct(){
		parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Articles_model');
        $this->load->model('AboutForm_model');
    }

    /**
        網站文宣
    **/
	public function WebInfo(){

        $select     = ['*'];
        $limit      = ['offset'=>NULL,'limit'=>NULL];
        $orderby    = ['seq ASC'];
        $conditions[] = [
            [
            'field' => 'list_type',
            'operator' => '!=',
            'value' => 'about'
            ]
        ];
        $data['contents']     =   $this->Articles_model->search($select, $conditions, $orderby, $limit);

		$this->load->view('Backend/Articles/webinfo',$data);
	}

    /**
        關於我們
    **/
    public function about(){
        $this->load->view('Backend/Articles/about');
    }
    /**
        關於我們列表
    **/
    public function Show(){
        $select     = ['*'];
        $limit      = ['offset'=>NULL,'limit'=>NULL];
        $orderby    = ['seq ASC'];
        $conditions[] = [
            [
            'field' => 'list_type',
            'operator' => '=',
            'value' => 'about'
            ]
        ];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');   
            $limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->Articles_model->search($select, $conditions, $orderby, $limit);
        $return['total']    =   $this->Articles_model->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        關於我們資訊
    **/
    public function Info($id=''){
        $return     =  $this->Articles_model->get($id);
        if(empty($return)) redirect('/Backend/About');
        $this->output->set_content_type('application/json')->set_output(json_encode(current($return)));
    }

    /**
        關於我們新增
    **/
    public function Add(){
        if($this->form_validation->run()){
			$data   	=   $this->input->post();

			$data['list_type']	=	"about";
			$data['page_url']	=	"about";
            $data['create_time'] = date('Y-m-d H:i:s');

            $result     =   $this->Articles_model->insert($data);
            if($result){
                $return     =   $this->ReturnHandle(true,$this->lang->line('Insert_success'));
            }else{
                $return     =   $this->ReturnHandle(false,$this->lang->line('Insert_fail'));
            }
            
        }else{ 
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        編輯關於我們
    **/
    public function Edit($id=''){
        $this->load->library('form_validation');
        if($this->form_validation->run()){
            $where  =   ['id'=>$id];
            $data   =   $this->input->post();
            unset($data['id']);
            $data['update_time'] = date('Y-m-d H:i:s');
            $result     =   $this->Articles_model->update($data,$where);
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
        刪除關於我們
    **/
    public function Delete($id=''){
        try{
            $original = $this->Articles_model->get(['id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->Articles_model->delete($where);
            if (!$result)
                throw new Exception($this->lang->line('Delete_fail'));
            $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));

        } catch (Exception $e) {
			$error_msg = $e->getMessage();
            $return = $this->ReturnHandle(false,$error_msg);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

	/**
        排序
    **/
    public function UpdateSeq(){
        $data       =   $this->input->post('seq');
        $result     =   $this->Articles_model->updateSeq($data);
        if ($result){
            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_seq_success'));
        }else {
            $return     =   $this->ReturnHandle(false,$this->lang->line('Update_seq_fail'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function Form(){
        $data['list']     =  $this->AboutForm_model->get(['id'=>'1'],['*'])[0];
        $this->load->view('Backend/Articles/form',$data);
    }

    public function EditForm(){
       if($this->form_validation->run()){
            $data = $this->input->post();
            $data['date_update'] = date('Y-m-d H:i:s');
            $return     =  $this->ReturnHandle( $this->AboutForm_model->update($data,['id'=>'1']),$this->lang->line('Update_Info_success'));
        }else{
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function Theme(){
        $this->load->model('About_theme_model','about_theme');
        $this->load->model('Item_type_model','item_type');
        $this->load->model('Item_category_model','item_category');
        $data['type'] = $this->item_type->get(['status' => 1], ['id', 'title', 'create_time', 'status'],['seq']);
        $data['category'] = $this->item_category->get(['status' => 1], ['item_category.*'],['seq']);
        $data['list']     =  $this->about_theme->get(['id'=>'1'],['*'])[0];
        $this->load->view('Backend/Articles/theme',$data);
    }

    public function EditTheme(){
    $this->load->model('About_theme_model','about_theme');
       if($this->form_validation->run()){
            $data = $this->input->post();
            $data['update_time'] = date('Y-m-d H:i:s');
            $return     =  $this->ReturnHandle( $this->about_theme->update($data,['id'=>'1']),$this->lang->line('Update_Info_success'));
        }else{
            $return     =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

}
