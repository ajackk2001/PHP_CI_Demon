<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_scale_model extends MY_Model{
    public $table_name	=	'item_scale';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle($data){
        $descript   =   '';
        if(!is_array($data)){
            $data   =   $this->db->where(['id'=>$data])->get($this->table_name)->result();
        }
        $result =   $this->db->select('title')->from($this->table_name)->where(['id'=>$data[0]->id])->get()->result();
        $descript   .=  $result[0]->title;
        return '-'.$descript;
    }
}
