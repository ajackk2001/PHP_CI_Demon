<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_type extends My_Model{

    public $table_name	=	'message_type';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function GetMessage($where=[],$fields=['*']){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->where($where)->get()->result();
    }

}
