<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends My_Model{

	public $table_name	=	'item';
    public $title   =   '作品';
    public function __construct(){
        parent::__construct();
	}

    public function RecordHandle($data){

        return '';
    }

    private function RecordStr($field,$value){
        switch ($field) {
            case 'status':
                return ($value==0)? "->停用":"->啟用";
                break;
            default:
                return '';
                break;
        }
    }


    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        if(preg_grep('/member\./', $select))
            $this->db->join('member', 'member.id='.$this->table_name.'.member_id', 'left');
        if(preg_grep('/item_type\./', $select))
            $this->db->join('item_type', 'item_type.id='.$this->table_name.'.type_id', 'left');

        if(preg_grep('/item_category\./', $select))
            $this->db->join('item_category', 'item_category.id='.$this->table_name.'.category_id', 'left');
        if(preg_grep('/item_scale\./', $select))
            $this->db->join('item_scale', 'item_scale.id='.$this->table_name.'.scale_id', 'left');
        if(preg_grep('/administrator\./', $select))
            $this->db->join('administrator', 'item.admin=administrator.id', 'left');
        if(preg_grep('/country\./', $select))
            $this->db->join('country', 'country.id=member.country', 'left');
        $this->db->join('list_points', 'list_points.id='.$this->table_name.'.list_points_id', 'left');
        return parent::search($select, $conditions, $order_by, $limit);
    }

    public function get($id = null, array $select = ['*'], array $order_by = [], array $limit = [], array $where_in = []){
        if(preg_grep('/member\./', $select))
            $this->db->join('member', 'member.id='.$this->table_name.'.member_id', 'left');
        if(preg_grep('/item_type\./', $select))
            $this->db->join('item_type', 'item_type.id='.$this->table_name.'.type_id', 'left');
        if(preg_grep('/item_scale\./', $select))
            $this->db->join('item_scale', 'item_scale.id='.$this->table_name.'.scale_id', 'left');

        if(preg_grep('/item_category\./', $select))
            $this->db->join('item_category', 'item_category.id='.$this->table_name.'.category_id', 'left');
        $this->db->join('list_points', 'list_points.id='.$this->table_name.'.list_points_id', 'left');

        return parent::get($id, $select, $order_by, $limit, $where_in);
    }




}