<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_msg_model extends My_Model{

    public $table_name = 'member_msg';
    public function __construct(){
        parent::__construct();
    }

    public function insert_record($id,$data2=[]){}

    public function RecordHandle(){
        return '';
    }

    public function check_quantitye($where=[]) {
        return $this->db->from($this->table_name)->where($where)->count_all_results();
    }
}
