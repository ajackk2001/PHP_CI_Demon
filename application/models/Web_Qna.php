<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_Qna extends My_Model{
    public $table_name	=	'website_qna';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function GetWebQna($where,$fields=['*'],$orderby=[],$limit=['limit'=>NULL,'offset'=>NULL]){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->where($where)->order_by(implode(',',$orderby))->limit($limit['limit'],$limit['offset'])->get()->result();
    }

    public function GetQnaInfo($where,$fields=['*']){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->where($where)->get()->result();
    }

}
