<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_category_model extends MY_Model{
    public $table_name = 'item_category';
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

    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        if(preg_grep('/item_type\./', $select))
            $this->db->join('item_type','item_type.id='.$this->table_name.'.type_id','left');

        return parent::search($select, $conditions, $order_by, $limit);
    }
}
