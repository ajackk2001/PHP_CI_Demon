<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebsiteMailServer extends My_Model{

    public $table_name = 'website_mail_server';
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

    public function get_date($data) {
		$this->db->from($this->table_name);
		if (!empty($data['fields'])) {
			$this->db->select(implode(',',$data['fields']));
		}
		if (!empty($data['where'])) {
			$this->db->where($data['where']);
		}
    	return $this->db->get()->row();
    }

    public function GetStar($where=[],$fields=['*']){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->where($where)->group_by('profession_id')->get()->result();
    }
}
