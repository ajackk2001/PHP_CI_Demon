<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";

class Relations_file extends MY_Manager {
    public $upload_setting  =   [
        'upload_path'   =>  '/uploads/relations_file/',
        'allowed_types' =>  [ 'doc','xls','pdf','ppt','png','img','gif' ],
        'max_size'       =>  32,    
    ];
    private $upload_dir = 'uploads/relations_file/';
    private $documentRoot;

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
        $this->load->model('Relations_file_model','Relations_file');
        if (substr($_SERVER['DOCUMENT_ROOT'], -1) !== '/') {
            $this->documentRoot = $_SERVER['DOCUMENT_ROOT'].'/';
        }
    }
    
    /**
        檔案下載總管
    **/
	public function Index(){
		$this->load->view('Backend/Relations/Relations_file');
	}

	/**
        檔案下載列表
    **/
    public function Show(){
        $limit = ['offset'=>NULL,'limit'=>NULL];
        $orderby = ['publish_time DESC','id DESC'];
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
        $return['list'] 	=	$this->Relations_file->search(['id','title','CONCAT("/",file) file','publish_time','status','dtr'],$conditions,$orderby,$limit);
        $return['total']    =   $this->Relations_file->row_count;
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**
        檔案下載新增
    **/
    public function Add(){
        try {
            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['create_time']   =   date('Y-m-d H:i:s');
            if (@!is_dir($this->upload_dir)) { mkdir($this->upload_dir,0777,true); }
            
            //JQUERY.filer fileupload
            foreach ($data as $key=>$val){
                if(preg_match("/jfiler-items-exclude-/i", $key)){
                    if (isset($data[$key])){
                        $removed_file = json_decode($data[$key]);
                    }
                    unset($data[$key]);
                }
            }

            if (isset($_FILES['file'])){
                $uploadFile = $_FILES['file'];
                if (!empty($uploadFile)){
                    $temp = explode('.',$uploadFile["name"]);
                    $extension = end($temp);
                    array_pop($temp);
                    $filename = $this->upload_dir.implode('.',$temp).'_'.date('Ymd').'.'.$extension;
                    $data['file'] = $this->uploadFileAction('upload',$filename,$uploadFile);
                }
            }else{
                throw new Exception('請上傳檔案');
            }

            $result = $this->Relations_file->insert($data);
            if (!$result)
                throw new Exception($this->lang->line('Insert_fail'));

			$return     =   $this->ReturnHandle(true,$this->lang->line('Insert_success'));
		} catch (Exception $e) {
			$error_msg = $e->getMessage();
			$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
			if(isset($data['file']) && $data['file'] != 'undefined'){
                $this->uploadFileAction('delete',$data['file']);
            }
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        檔案下載更新
    **/
    public function Edit($id=''){
        try {
            $original = $this->Relations_file->get($id);
			if (empty($id) || count($original) == 0)
				throw new Exception('查無資料');

            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['create_time']   =   date('Y-m-d H:i:s');
            if (@!is_dir($this->upload_dir)) { mkdir($this->upload_dir,0777,true); }

            //JQUERY.filer fileupload
            foreach ($data as $key=>$val){
                if(preg_match("/jfiler-items-exclude-/i", $key)){
                    if (isset($data[$key])){
                        $removed_file = json_decode($data[$key]);
                    }
                    unset($data[$key]);
                }
            }

            if (isset($_FILES['file'])){
                $uploadFile = $_FILES['file'];
                if (!empty($uploadFile)){
                    $temp = explode('.',$uploadFile["name"]);
                    $extension = end($temp);
                    array_pop($temp);
                    $filename = $this->upload_dir.implode('.',$temp).'_'.date('Ymd').'.'.$extension;
                    $data['file'] = $this->uploadFileAction('upload',$filename,$uploadFile);
                }
                if(isset($removed_file)){
                    foreach ($removed_file as $exclude_file){
                    if (!empty($exclude_file))
                        $this->uploadFileAction('delete',$this->upload_dir.$exclude_file);
                    }
                }
                if(isset($original[0]->file)){
                    $this->uploadFileAction('delete',$original[0]->file);
                }
            }else if(isset($removed_file)){
                throw new Exception('請上傳檔案');
            }else{
                unset($data['file']);
            }


            $where  =   ['id' =>  $id];
            $result = $this->Relations_file->update($data,$where);
            if (!$result)
                throw new Exception($this->lang->line('Update_Info_fail'));

			$return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
		} catch (Exception $e) {
			$error_msg = $e->getMessage();
			$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
			if(isset($data['file']) && $data['file'] != 'undefined'){
                $this->uploadFileAction('delete',$data['file']);
            }
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        檔案下載刪除
    **/
    public function Delete($id=''){
        try{
            $original = $this->Relations_file->get(['id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->Relations_file->delete($where);
            if (!$result)
                throw new Exception($this->lang->line('Delete_fail'));
    
            $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));
        
            foreach ($original[0] as $key=>$val){
                if (in_array($key,['file']) && !empty($val)){
                    unlink($this->documentRoot.$val);
                }
            }

        } catch (Exception $e) {
			$error_msg = $e->getMessage();
            $return = $this->ReturnHandle(false,$error_msg);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        檔案下載資訊
    **/
    public function Info($id=''){
        $return     =  $this->Relations_file->get($id,['id','title','file','publish_time']);
        if (empty($return)) redirect('/Backend/RelationsWebsite');

        $return = current($return);
        if (!empty($return->file) && file_exists($this->documentRoot.$return->file)){
            $tem = explode('/',$return->file);
            $return->file = [
                'name'	=> end($tem),
                'size'	=> filesize($this->documentRoot.$return->file),
                'type'	=> filetype($this->documentRoot.$return->file),
                'file'	=> $return->file,
                'url'	=> site_url($return->file)
            ];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
    
    /**
        變更狀態
    **/
    public function UpdateStatus($id){
        $data   = $this->input->post();
        $where  = ['id' =>  $id];
        $result = $this->Relations_file->update($data,$where);
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
        $result     =   $this->Relations_file->UpdateSeq($data['seq']);
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
        $lastSeq = $this->Relations_file->search(['max(seq) MaxSeq']);
        $return = ((!empty($lastSeq[0]->MaxSeq)))? $lastSeq[0]->MaxSeq:0;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}


}
