<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_favorite_model extends My_Model{

    public $table_name	=	'item_favorite';
    public function __construct(){
        parent::__construct();
    }

    public function insert_record($id,$data2=[]){}

    public function RecordHandle($data,$data2=''){
        return '';
    }

    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        if(preg_grep('/member\./', $select))
            $this->db->join('member', 'member.id='.$this->table_name.'.member_id', 'left');
        if(preg_grep('/item\./', $select)){
            $this->db->join('item', 'item.id='.$this->table_name.'.item_id', 'left');
            //$this->db->join('list_points', 'list_points.id=item.list_points_id', 'left');
        }
        return parent::search($select, $conditions, $order_by, $limit);
    }
}
