<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";

class Albums extends MY_Manager {
    private $img_dir = 'uploads/albums/';

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Albums_model');
		$this->load->model('Albums_type');
        $this->load->model('Albums_img');
        ini_set('memory_limit','256M');
    }
    
    /**
        相薄總管
    **/
	public function Index(){
        $type     =  $this->Albums_type->get(['status'=>1],['id','title']);
        $return['typeData'] = $type;
		$this->load->view('Backend/Albums/albums',$return);
	}

	/**
        相薄列表
    **/
    public function Show(){
        $limit = ['offset'=>NULL,'limit'=>NULL];
        $select = ['albums.id','albums.title','albums.content','albums.publish_time','albums.status','albums.type_id','IFNULL(total.counts, 0) counts','albums_type.title type_title'];
        $orderby = ['publish_time DESC','albums.id DESC'];
        $conditions = [];
    	foreach ($this->input->get() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['search','page','limit'])){
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
        $return['list'] 	=	$this->Albums_model->search($select, $conditions, $orderby, $limit);
        $return['total']    =   $this->Albums_model->row_count;
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**
        相薄新增
    **/
    public function Add(){
        try {
            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['create_time']   =   date('Y-m-d H:i:s');
            $result = $this->Albums_model->insert($data);
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
        相薄更新
    **/
    public function Edit($id=''){
        try {
            $original = $this->Albums_model->get($id);
			if (empty($id) || count($original) == 0)
				throw new Exception('查無資料');

            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['create_time']   =   date('Y-m-d H:i:s');

            $where  =   ['id' =>  $id];
            $result = $this->Albums_model->update($data,$where);
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
        相薄刪除
    **/
    public function Delete($id=''){
        try{
            $original = $this->Albums_model->get(['id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->Albums_model->delete($where);
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
        相薄資訊
    **/
    public function Info($id=''){
        $return     =  $this->Albums_model->get($id,['id','type_id','title','content','publish_time','status']);
        if (empty($return)) redirect('/Backend/RelationsWebsite');
        $return = current($return);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }


/**
*@img function
**/
    /**
        相片總管
    **/
	public function photoAbout($id=''){
        $data['selectAblums'] = '';
        $data['fileuploaderImages'] = [];
        
        if (!empty($id)){
            // fileuploader preload
            foreach ($this->load_images($id) as $v) {
                $img_info = pathinfo($v->img);
                $data['fileuploaderImages'][] = [
                    'name' => '/'.$v->img,  // 檔名，這邊用來存放圖檔 url，以利前端傳資料回後端時知道圖片在哪
                    'type' => 'image',
                    'size' => filesize($v->img),
                    'file' => version($v->img),  // 圖檔路徑
                    'data' => [
                        // 縮圖路徑
                        'thumbnail' => version($img_info['dirname'].'/'.$img_info['filename'].'_thumbnail.'.$img_info['extension']),
                    ],
                ];
            }
            $data['selectAblums'] = $id;
        }
        $data['selectData'] = $this->Albums_model->get(['status'=>1],['*'],['publish_time DESC']);
		$this->load->view('Backend/Albums/photos',$data);
    }
    
    public function fileuploader_image_upload($id)
    {
        $this->img_dir .= 'album'.$id.'/';
        // 確保上傳資料夾存在
        @mkdir($this->img_dir, 0777, true);
        include 'assets/plugins/fileuploader2/src/class.fileuploader.php';
        // 上傳圖片
        $fileUploader = new MyFileUploader('files', array(
            'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
            'required' => true,
            'uploadDir' => $this->img_dir,
            'title' => time(),
            'replace' => false,
        ));
        $upload = $fileUploader->upload();

        if ($upload['isSuccess']) {
            // 製作縮圖
            // 縮圖檔名: 原檔名後綴 "_thumbnail"
            $img = $upload['files'][0];
            $thumbnail = $this->img_dir.basename($img['name'], '.'.$img['extension']).'_thumbnail.'.$img['extension'];
            if (MyFileUploader::resize($img['file'], 200, 200, $thumbnail, null, 100)) {
                $return = $this->ReturnHandle(true, '/'.$img['file']);
            } else {
                $return = $this->ReturnHandle(false, $this->lang->line('Update_Info_fail'));
            }
        } else {
            $return = $this->ReturnHandle(false, $this->lang->line('Update_Info_fail'));
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function save_images($id)
    {
        $this->img_dir .= 'album'.$id.'/';

        // 確定需要的圖片
        $fileuploader_images = json_decode($this->input->post('fileuploader_images'));
        // 去掉路徑開頭 '/'
        array_walk($fileuploader_images, function (&$img) {
            $img = substr($img, 1, strlen($img));
        });
        $this->clear_images($fileuploader_images);

        // 更新資料庫 刪除圖片
        $imgs = array_column($this->load_images($id), 'img');
        foreach (array_diff($imgs, $fileuploader_images) as $img_to_delete) {
            $this->delete_images(['img' => $img_to_delete]);
        }

        // 更新資料庫 新增的圖片
        $fileuploader_new_images = json_decode($this->input->post('fileuploader_uploaded_images'));
        // 去掉路徑開頭 '/'
        array_walk($fileuploader_new_images, function (&$img) {
            $img = substr($img, 1, strlen($img));
        });
        foreach (array_diff($fileuploader_new_images, $imgs) as $new_img) {
            $this->add_image([
                'albums_id' => $id,
                'img' => $new_img,
                'create_time' => date('Y-m-d H:i:s'),
            ]);
        }

        include_once 'assets/plugins/fileuploader2/src/class.fileuploader.php';
        $editor = json_decode($this->input->post('fileuploader_editor'), true);
        foreach ($fileuploader_images as $i => $img) {
            // 更新排序
            $this->update_image(['seq' => $i], ['img' => $img]);
            // 裁圖
            MyFileUploader::resize($img, null, null, null, (isset($editor[$i]['crop']) ? $editor[$i]['crop'] : null), 100, (isset($editor[$i]['rotation']) ? $editor[$i]['rotation'] : null));
            $img_info = pathinfo($img);
            // 製作縮圖
            // 縮圖檔名: 原檔名後綴 "_thumbnail"
            $thumbnail = $img_info['dirname'].'/'.$img_info['filename'].'_thumbnail.'.$img_info['extension'];
            MyFileUploader::resize($img, 400, 360, $thumbnail, null, 100);
        }
        $this->setRecord(['id'=>$id]);
        $return = $this->ReturnHandle(true, $this->lang->line('Update_Info_success'), '/Backend/Albums/Photos/'.$id);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    private function add_image($data)
    {
        $this->Albums_img->insert($data);
    }

    private function load_images($id)
    {
        return $this->Albums_img->get(['albums_id'=>$id],['img'],['seq ASC']);
    }

    private function clear_images(array $images)
    {
        // 取得 thumbnails
        $fileuploader_thumbnails = [];
        foreach ($images as $img) {
            $img_info = pathinfo($img);
            $fileuploader_thumbnails[] = $img_info['dirname'].'/'.$img_info['filename'].'_thumbnail.'.$img_info['extension'];
        }

        // 刪除沒用到的圖片、縮圖
        foreach (array_diff(glob($this->img_dir.'*'), array_merge($images, $fileuploader_thumbnails)) as $file_path) {
            @unlink($file_path);
        }
    }

    private function delete_images($where)
    {
        $this->Albums_img->delete($where);
    }

    private function update_image($data, $where)
    {
        $this->Albums_img->update($data, $where);
    }

    private function setRecord($data)
    {
        $this->Albums_img->setRecord($data);
    }


    

    /**
    *@TYPE function
    **/
    /**
        相薄分類總管
    **/
	public function TypeIndex(){
		$this->load->view('Backend/Albums/albums_type');
	}

	/**
        相薄分類列表
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
        $return['list'] 	=	$this->Albums_type->search($select, $conditions, $orderby, $limit);
        $return['total']    =   $this->Albums_type->row_count;
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**
        相薄分類新增
    **/
    public function TypeAdd(){
        try {
            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['create_time']   =   date('Y-m-d H:i:s');
            $result = $this->Albums_type->insert($data);
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
        相薄分類更新
    **/
    public function TypeEdit($id=''){
        try {
            $original = $this->Albums_type->get($id);
			if (empty($id) || count($original) == 0)
				throw new Exception('查無資料');

            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['create_time']   =   date('Y-m-d H:i:s');

            $where  =   ['id' =>  $id];
            $result = $this->Albums_type->update($data,$where);
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
        相薄分類刪除
    **/
    public function TypeDelete($id=''){
        try{
            $original = $this->Albums_type->get(['id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->Albums_type->delete($where);
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
        相薄分類資訊
    **/
    public function TypeInfo($id=''){
        $return     =  $this->Albums_type->get($id,['id','title','status','seq']);
        if (empty($return)) redirect('/Backend/RelationsWebsite');
        $return = current($return);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	
	/**
        變更排序
    **/
    public function UpdateSeq($kind){
        $data   =   $this->input->post();
        $thisModel = ($kind=='type')? $this->Albums_type:$this->Albums_model; 
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
        $thisModel = ($kind=='type')? $this->Albums_type:$this->Albums_model; 
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
        $thisModel = ($kind=='type')? $this->Albums_type:$this->Albums_model; 
        $lastSeq = $thisModel->search(['max(seq) MaxSeq']);
        $return = ((!empty($lastSeq[0]->MaxSeq)))? $lastSeq[0]->MaxSeq:0;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}


}
