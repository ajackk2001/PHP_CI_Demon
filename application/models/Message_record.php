<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_record extends My_Model{
    public $table_name	=	'message_record';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function GetMessageRecord($where,$fields=['*'],$orderby=[],$limit=['limit'=>NULL,'offset'=>NULL]){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->where($where)->order_by(implode(',',$orderby))->limit($limit['limit'],$limit['offset'])->get()->result();
    }

    public function GetMessageInfo($where,$fields=['*']){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->where($where)->get()->result();
    }

}
