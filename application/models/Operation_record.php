<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operation_record extends My_Model{
    public $table_name	=	'operation_record';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle($data){
        return '';
    }

    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        $this->db->join('administrator',$this->table_name.'.user_id=administrator.id','left');
        return parent::search($select, $conditions, $order_by, $limit);
    }

}
