<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";

class Theme extends MY_Manager {
    public $upload_setting  =   [
        'upload_path'   =>  '/uploads/popular/',
        'allowed_types' =>  ['jpg', 'jpeg', 'png', 'gif'],
        'max_size'       =>  8,
    ];
    //private $img_dir = 'uploads/banner/';

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('About_theme_model','about_theme');
        $this->load->model('Item_type_model','item_type');
        $this->load->model('Item_category_model','item_category');
    }

    /**
    總管
    **/
	public function Index(){
        $this->load->model('Item_type_model','item_type');
        $this->load->model('Item_category_model','item_category');
        $data['type'] = $this->item_type->get(['status' => 1], ['id', 'title', 'create_time', 'status'],['seq']);
        $data['category'] = $this->item_category->get(['status' => 1], ['item_category.*'],['seq']);
        $data['img_width']="180";
        $data['img_height']="180";
		$this->load->view('Backend/Articles/theme',$data);
	}

	/**
        輪播圖列表
    **/
    public function Show(){
        $limit = ['offset'=>NULL,'limit'=>NULL];
        $orderby = ['seq ASC','id DESC'];
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
        $return['list'] 	=	$this->about_theme->search(['about_theme.*','item_category.title as category_title','item_type.title as type_title'],$conditions,$orderby,$limit);
        $return['total']    =   $this->about_theme->row_count;
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**
        輪播圖新增
    **/
    public function Add(){
        try {
            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');
            $s=$this->about_theme->get();
            if(!empty($s)&&count($s)>=5)throw new Exception('主題連結最多五筆。');
            $data   =   $this->input->post();
            $data['update_time']   =   date('Y-m-d H:i:s');
            $result = $this->about_theme->insert($data);
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
        輪播圖更新
    **/
    public function Edit($id=''){
        include 'assets/plugins/slim/server/slim.php';
        try {
            $original = $this->about_theme->get($id);
			if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['update_time']   =   date('Y-m-d H:i:s');

            //slim
            $images = Slim::getImages();
            if($images == false)
                throw new Exception('Slim was not used to upload these images.');

            $image = array_shift($images);
            if (isset($image['output']['data'])) {
                $slimName = $image['output']['name'];
                $slimData = $image['output']['data'];
                $slimUnique = ($this->img_dir.$slimName == $original[0]->img)? false:true;
                $output = Slim::saveFile($slimData, $slimName, $this->img_dir, $slimUnique);

                $data['img'] = $output['path'];
                unset($data['slim']);

                if ($slimUnique && file_exists($original[0]->img)){
                    @unlink($original[0]->img);
                }
            }

            $where  =   ['id' =>  $id];
            $result = $this->about_theme->update($data,$where);
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
            $original = $this->about_theme->get(['id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->about_theme->delete($where);
            if (!$result)
                throw new Exception($this->lang->line('Delete_fail'));
            $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));
            foreach ($original[0] as $key=>$val){
                if (in_array($key,['img']) && !empty($val)){
                    @unlink($val);
                }
            }

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
        $return     =  $this->about_theme->get($id,['about_theme.*']);
        if (empty($return)) redirect('/Backend/BannerWebsite');
        $return = current($return);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        變更狀態
    **/
    public function UpdateStatus($id){
        $data   = $this->input->post();
        $where  = ['id' =>  $id];
        $result = $this->about_theme->update($data,$where);
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
        $result     =   $this->about_theme->UpdateSeq($data['seq']);
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
        $lastSeq = $this->about_theme->search(['max(seq) MaxSeq']);
        $return = ((!empty($lastSeq[0]->MaxSeq)))? $lastSeq[0]->MaxSeq:0;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}


}
