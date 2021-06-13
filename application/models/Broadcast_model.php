<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Broadcast_model extends My_Model{
    public $table_name	=	'broadcast';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function GetBroadcast($where,$fields=['*'],$orderby=[],$limit=['limit'=>NULL,'offset'=>NULL]){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->where($where)->order_by(implode(',',$orderby))->limit($limit['limit'],$limit['offset'])->get()->result();
    }

    public function GetBroadcastInfo($where,$fields=['*']){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->where($where)->get()->result();
    }

}
