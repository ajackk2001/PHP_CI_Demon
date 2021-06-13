<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_msg_model extends My_Model{

    public $table_name = 'admin_msg';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function get_list($data) {
        $this->db->from($this->table_name);
        if (!empty($data['fields'])) {
            $this->db->select(implode(',',$data['fields']));
        }
        if (!empty($data['where'])) {
            $this->db->where($data['where']);
        }
        if (!empty($data['where_str'])) {
            $this->db->where($data['where_str']);
        }
        if (!empty($data['page']) && !empty($data['rows'])) {
            $this->db->limit($data['rows'], ($data['page'] - 1) * $data['rows']);
        }
        if (!empty($data['order'])) {
            foreach ($data['order'] as $key => $value) {
                $this->db->order_by($value, $key);
            }
        } else {
            $this->db->order_by("{$this->table_name}.create_time", 'DESC');
        }
        return $this->db->get()->result();
    }

    public function get_list_count($data) {
        $this->db->from($this->table_name);
        if (!empty($data['fields'])) {
            $this->db->select(implode(',',$data['fields']));
        }
        if (!empty($data['where'])) {
            $this->db->where($data['where']);
        }
        if (!empty($data['where_str'])) {
            $this->db->where($data['where_str']);
        }
        return $this->db->count_all_results();
    }

    public function GetAdminPermission($permission) {
        $this->db->from('administrator');
        $this->db->where("menu_permission LIKE '%{$permission}%'");
        return $this->db->get()->result();
    }

    
}
