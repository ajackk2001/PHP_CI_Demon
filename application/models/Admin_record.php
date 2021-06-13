<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_record extends My_Model{
    public $table_name	=	'admin_record';
    public $title       =   '管理系統';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function GetRecordList($where,$fields=['*'],$orderby=[],$limit=['limit'=>NULL,'offset'=>NULL]){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->join('administrator','administrator.id='.$this->table_name.'.admin_id','left')->where($where)->order_by(implode(',',$orderby))->limit($limit['limit'],$limit['offset'])->get()->result();
    }

    public function get($id = null, array $select = ['*'], array $order_by = [], array $limit = [], array $where_in = []){
        $this->db->join('administrator','administrator.id='.$this->table_name.'.admin_id','left');
        $this->db->join('(select albums_id,count(id) counts from albums_img group by albums_id) total','albums.id=total.albums_id','left');
        return parent::get($id, $select, $order_by, $limit, $where_in);
    }

    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[],$group=[]){
        $this->db->join('administrator','administrator.id='.$this->table_name.'.admin_id','left');
        $this->db->join('(select albums_id,count(id) counts from albums_img group by albums_id) total','albums.id=total.albums_id','left');
        return parent::search($select, $conditions, $order_by, $limit);
    }

}
