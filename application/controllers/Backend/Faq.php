<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";

class Faq extends MY_Manager {
    public $upload_setting  =   [
        'upload_path'   =>  '/uploads/banner_img/',
        'allowed_types' =>  ['jpg', 'jpeg', 'png', 'gif'],
        'max_size'       =>  8,
    ];
    private $img_dir = 'uploads/banner_img/';

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Faq_model','faq');
    }

    /**
    輪播圖總管
    **/
	public function Index(){
        $data['img_width']="472";
        $data['img_height']="314";
		$this->load->view('Backend/Articles/faq',$data);
	}

	/**
        輪播圖列表
    **/
    public function Show(){
        $limit = ['offset'=>NULL,'limit'=>NULL];
        $orderby = ['seq','id DESC'];
        $conditions = [];
    	foreach ($this->input->get() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['page','limit'])){
                $conditions[0][] = [
                    'field' => $key,
                    'operator' => 'like',
                    'value' => $value
                ];
    		}
    	}
        if($this->input->get('page')&&$this->input->get('limit')){
            $limit['offset']    =   ($this->input->get('page')-1)*$this->input->get('limit');   
            $limit['limit']     =   $this->input->get('limit');
        }
        $return['page']     =   $this->input->get('page');
        $return['list'] 	=	$this->faq->search(['faq.*'],$conditions,$orderby,$limit);
        $return['total']    =   $this->faq->row_count;
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**
    新增
    **/
    public function Add(){
        try {
            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['update_time']   =   date('Y-m-d H:i:s');

            $result = $this->faq->insert($data);
            if (!$result)
                throw new Exception($this->lang->line('Insert_fail'));

			$return     =   $this->ReturnHandle(true,$this->lang->line('Insert_success'));
		} catch (Exception $e) {
			$error_msg = $e->getMessage();
			$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
    更新
    **/
    public function Edit($id=''){
        try {
            $original = $this->faq->get($id);
			if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['update_time']   =   date('Y-m-d H:i:s');

            $where  =   ['id' =>  $id];
            $result = $this->faq->update($data,$where);
            if (!$result)
                throw new Exception($this->lang->line('Update_Info_fail'));

            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));

		} catch (Exception $e) {
			$error_msg = $e->getMessage();
			$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
			foreach ($catchErrorDel as $exclude_file){
				if (!empty($exclude_file))
					$this->uploadFileAction('delete',$exclude_file);
            }
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        輪播圖刪除
    **/
    public function Delete($id=''){
        try{
            $original = $this->faq->get(['id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->faq->delete($where);
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
        輪播圖資訊
    **/
    public function Info($id=''){
        $return     =  $this->faq->get($id,['*'])[0];
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        變更狀態
    **/
    public function UpdateStatus($id){
        $data   = $this->input->post();
        $where  = ['id' =>  $id];
        $result = $this->faq->update($data,$where);
        if ($result){
            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
        }else {
            $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**
        變更排序
    **/
    public function UpdateSeq(){
        $data   =   $this->input->post();
        $result     =   $this->faq->UpdateSeq($data['seq']);
        if ($result){
            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_seq_success'));
        }else {
            $return     =   $this->ReturnHandle(false,$this->lang->line('Update_seq_fail'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

    /**
        最後一個seq
    **/
    public function lastSeq(){
        $lastSeq = $this->faq->search(['max(seq) MaxSeq']);
        $return = ((!empty($lastSeq[0]->MaxSeq)))? $lastSeq[0]->MaxSeq:0;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}


}
