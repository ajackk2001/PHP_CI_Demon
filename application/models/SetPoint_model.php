<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SetPoint_model extends My_Model{

    public $table_name	=	'list_points';
    public function __construct(){
        parent::__construct();
    }
    public function insert_record($id,$data2=[]){}

    public function RecordHandle($data,$data2=''){
        return '';
    }
    public function get($id = null, array $select = ['*'], array $order_by = [], array $limit = [], array $where_in = []){
        if(preg_grep('/purchase\./', $select))
            $this->db->join('purchase', 'purchase.id='.$this->table_name.'.purchase_id', 'left');
        return parent::get($id, $select, $order_by, $limit, $where_in);
    }

}
