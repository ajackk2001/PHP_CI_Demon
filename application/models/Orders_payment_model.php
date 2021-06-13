<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_payment_model extends My_Model{

    public $table_name = 'orders_payment';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function CheckOrder($order) {
        return $this->db->from($this->table_name)->where('payment_sn',$order)->count_all_results();
    }
    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        if(preg_grep('/member\./', $select))
            $this->db->join('member', 'member.id='.$this->table_name.'.member_id', 'left');
        return parent::search($select, $conditions, $order_by, $limit);
    }

    public function get($id = null, array $select = ['*'], array $order_by = [], array $limit = [], array $where_in = [],array $group = []){
        if(preg_grep('/member\./', $select))
            $this->db->join('member', 'member.id='.$this->table_name.'.member_id', 'left');

        return parent::get($id, $select, $order_by, $limit, $where_in);
    }
}
