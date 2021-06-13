<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_msg_type_model extends My_Model{

    public $table_name = 'member_msg_type';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function GetList($where,$fields=['*'],$orwhere=[],$orderby=[],$limit=['limit'=>NULL,'offset'=>NULL]){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->get()->result();
    }

    public function GetInfo($where,$fields=['*']){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->where($where)->get()->row();
    }
}
