<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export_model extends My_Model{

    public $table_name = 'export';
    public function __construct(){
        parent::__construct();
    }

	public function get_list($data) {
		$this->db->from($this->table_name)->join('export_type AS ext','ext.id='.$this->table_name.'.type','left');
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
			$this->db->order_by("{$this->table_name}.create_time", 'ASC');
		}
    	return $this->db->get()->result();
    }

    public function get_list_count($data) {
		$this->db->from($this->table_name)->join('export_type AS ext','ext.id='.$this->table_name.'.type','left');
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

    public function get_date($data) {
		$this->db->from($this->table_name)->join('export_type AS ext','ext.id='.$this->table_name.'.type','left');
		if (!empty($data['fields'])) {
			$this->db->select(implode(',',$data['fields']));
		}
		if (!empty($data['where'])) {
			$this->db->where($data['where']);
		}
		if (!empty($data['where_str'])) {
			$this->db->where($data['where_str']);
		}
		$this->db->order_by("{$this->table_name}.create_time", 'DESC');
    	return $this->db->get()->row();
    }

    public function GetStar($where=[],$fields=['*']){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->where($where)->group_by('profession_id')->get()->result();
    }
}
