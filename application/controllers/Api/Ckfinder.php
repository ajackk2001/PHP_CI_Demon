<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ckfinder extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	private $path = './uploads/ckfinder/';

	public function Uploads(){
		$this->load->helper('url');
        $funcNum = $this->input->get('CKEditorFuncNum');
        $source = $_FILES['upload']['tmp_name'];
        $file = $_FILES['upload']['name'];
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $newName = date('YmdHis').rand(1000, 9999); //新檔名
        $message = '';
        $url = '';
        try {
            $fileName = "{$newName}.{$ext}";
            $target = $this->path.$fileName;
            if(!is_dir($this->path)) mkdir($this->path);
            if (move_uploaded_file($source, $target)) {
                $url = base_url($target);
            } else {
                $message = '上傳失敗';
            }
        } catch (Exception $e) {
          $message = $e->getMessage();
        }

        if(empty($message)){
	        $return['uploaded']     =  true;
        	$return['url']  =  $url;
	    }else{
	        $return['uploaded']     =  false;
        	$return['url']  =  $message;
	    }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
 	}


}
