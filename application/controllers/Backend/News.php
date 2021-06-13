<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";

class News extends MY_Manager {
    public $upload_setting  =   [
        'upload_path'   =>  '/uploads/news/',
        'allowed_types' =>  ['jpg', 'jpeg', 'png', 'gif'],
        'max_size'       =>  32,    
    ];
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('News_model');
		$this->load->model('News_type');
    }
    
    /**
        最新消息總管
    **/
	public function Index(){
        $type     =  $this->News_type->get(['status'=>1],['id','title']);
        $return['typeData'] = $type;
		$this->load->view('Backend/News/news',$return);
	}

	/**
        最新消息列表
    **/
    public function Show(){
        $limit = ['offset'=>NULL,'limit'=>NULL];
        $select = ['news.*','news_type.title type_title'];
        $orderby = ['publish_time DESC','news.id DESC'];
        $conditions = [];
    	foreach ($this->input->get() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['page','limit'])){
                $conditions[0][] = [
                    'field' => $key,
                    'operator' => '=',
                    'value' => $value
                ];
    		}
    	}
        if($this->input->get('page')&&$this->input->get('limit')){
            $limit['offset']    =   ($this->input->get('page')-1)*$this->input->get('limit');   
            $limit['limit']     =   $this->input->get('limit');
        }
        $return['page']     =   $this->input->get('page');
        $return['list'] 	=	$this->News_model->search($select, $conditions, $orderby, $limit);
        $return['total']    =   $this->News_model->row_count;
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**
        最新消息新增
    **/
    public function Add(){
        try {
            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['create_time']   =   date('Y-m-d H:i:s');
            $result = $this->News_model->insert($data);
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
        最新消息更新
    **/
    public function Edit($id=''){
        try {
            $original = $this->News_model->get($id);
			if (empty($id) || count($original) == 0)
				throw new Exception('查無資料');

            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['create_time']   =   date('Y-m-d H:i:s');

            $where  =   ['id' =>  $id];
            $result = $this->News_model->update($data,$where);
            if (!$result)
                throw new Exception($this->lang->line('Update_Info_fail'));

			$return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
		} catch (Exception $e) {
			$error_msg = $e->getMessage();
			$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        最新消息刪除
    **/
    public function Delete($id=''){
        try{
            $original = $this->News_model->get(['id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->News_model->delete($where);
            if (!$result)
                throw new Exception($this->lang->line('Delete_fail'));
    
            $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));
        
            foreach ($original[0] as $key=>$val){
                if (in_array($key,['file']) && !empty($val)){
                    unlink($_SERVER['DOCUMENT_ROOT'].$val);
                }
            }

        } catch (Exception $e) {
			$error_msg = $e->getMessage();
            $return = $this->ReturnHandle(false,$error_msg);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        最新消息資訊
    **/
    public function Info($id=''){
        $return     =  $this->News_model->get($id,['id','title','img','content','publish_time','status','type_id']);
        if (empty($return)) redirect('/Backend/RelationsWebsite');
        $return = current($return);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    

    /**
    *@TYPE function
    **/
    /**
        最新消息分類總管
    **/
	public function TypeIndex(){
		$this->load->view('Backend/News/news_type');
	}

	/**
        最新消息分類列表
    **/
    public function TypeShow(){
        $limit = ['offset'=>NULL,'limit'=>NULL];
        $select = ['id','title','seq','status','IFNULL(total.counts, 0) counts'];
        $orderby = ['seq ASC','status DESC','create_time DESC'];
        $conditions = [];
    	foreach ($this->input->get() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['page','limit'])){
                $conditions[0][] = [
                    'field' => $key,
                    'operator' => '=',
                    'value' => $value
                ];
    		}
    	}
        if($this->input->get('page')&&$this->input->get('limit')){
            $limit['offset']    =   ($this->input->get('page')-1)*$this->input->get('limit');   
            $limit['limit']     =   $this->input->get('limit');
        }
        $return['page']     =   $this->input->get('page');
        $return['list'] 	=	$this->News_type->search($select, $conditions, $orderby, $limit);
        $return['total']    =   $this->News_type->row_count;
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**
        最新消息分類新增
    **/
    public function TypeAdd(){
        try {
            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['create_time']   =   date('Y-m-d H:i:s');
            $result = $this->News_type->insert($data);
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
        最新消息分類更新
    **/
    public function TypeEdit($id=''){
        try {
            $original = $this->News_type->get($id);
			if (empty($id) || count($original) == 0)
				throw new Exception('查無資料');

            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['create_time']   =   date('Y-m-d H:i:s');

            $where  =   ['id' =>  $id];
            $result = $this->News_type->update($data,$where);
            if (!$result)
                throw new Exception($this->lang->line('Update_Info_fail'));

			$return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
		} catch (Exception $e) {
			$error_msg = $e->getMessage();
			$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        最新消息分類刪除
    **/
    public function TypeDelete($id=''){
        try{
            $original = $this->News_type->get(['id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->News_type->delete($where);
            if (!$result)
                throw new Exception($this->lang->line('Delete_fail'));
    
            $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));
        
            foreach ($original[0] as $key=>$val){
                if (in_array($key,['file']) && !empty($val)){
                    unlink($_SERVER['DOCUMENT_ROOT'].$val);
                }
            }

        } catch (Exception $e) {
			$error_msg = $e->getMessage();
            $return = $this->ReturnHandle(false,$error_msg);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        最新消息分類資訊
    **/
    public function TypeInfo($id=''){
        $return     =  $this->News_type->get($id,['id','title','status','seq']);
        if (empty($return)) redirect('/Backend/RelationsWebsite');
        $return = current($return);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	
	/**
        變更排序
    **/
    public function UpdateSeq($kind){
        $data   =   $this->input->post();
        $thisModel = ($kind=='type')? $this->News_type:$this->News_model; 
        $result     =   $thisModel->UpdateSeq($data['seq']);
        if ($result){
            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_seq_success'));
        }else {
            $return     =   $this->ReturnHandle(false,$this->lang->line('Update_seq_fail'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
    
	
	/**
        變更狀態
    **/
    public function UpdateStatus($kind,$id){
        $data   =   $this->input->post();
        $where  =   ['id' =>  $id];
        $thisModel = ($kind=='type')? $this->News_type:$this->News_model; 
        $result     =   $thisModel->update($data,$where);
        if ($result){
            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
        }else {
            $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

    /**
        最後一個seq
    **/
    public function lastSeq($kind){
        $thisModel = ($kind=='type')? $this->News_type:$this->News_model; 
        $lastSeq = $thisModel->search(['max(seq) MaxSeq']);
        $return = ((!empty($lastSeq[0]->MaxSeq)))? $lastSeq[0]->MaxSeq:0;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}


}
