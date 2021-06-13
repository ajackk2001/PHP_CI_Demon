<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AboutForm_model extends My_Model{

    public $table_name  = 'about_form';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle($data,$data2=''){
        if(!is_array($data)){
            $data   =   $this->db->where(['id'=>$data])->get($this->table_name)->result();
        }
        $result =   $this->db->select('title')->from($this->table_name)->where(['id'=>$data[0]->id])->get()->result();
        $descript =(!empty($result))?$result[0]->title:"";
         if(!empty($data2)){
            foreach ($data2 as $k => $val) {
                switch ($k) {
                   case 'status':
                       $descript =($val==1)? $descript." -> 下架":$descript." -> 啟用";
                       break;
               }
            }
            $descript=':'.$descript;
        }else{$descript ="-".$descript;}
        return $descript;
    }

}
