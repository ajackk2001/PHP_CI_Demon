<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Albums_img extends My_Model{

    public $table_name	=	'albums_img';
    public $title	=	'圖片上傳';
    public function __construct(){
        parent::__construct();
        $this->record = false;
    }

    public function RecordHandle($data){
        $descript   =   '';
        $result   =   $this->db->select('title')->where($data)->get('albums')->row();
        $descript   .=  $result->title;
        return '-'.$descript;
    }

    public function setRecord($data){
        $this->record = true;
        $this->action = 'UPDATA';
        $this->insert_record($data);
    }

}
