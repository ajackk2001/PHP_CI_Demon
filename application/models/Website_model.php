<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website_model extends CI_Model {

	/**
	 * 網站資訊
	 */
	public function get_web_info()
	{
		$query = $this->db->get('website_info')->row_array();
		return $query;
	}

	/**
	 * 網站資訊更新
	 */
	public function web_info_update($data='')
	{
		$this->db->where('id',1);
		$this->db->update('website_info',$data);
	}

	/**
	 * 社群登入設定
	 */
	public function get_social_auth()
	{
		$query = $this->db->get('website_social_auth')->result_array();
		return $query;
	}

	/**
	 * 網站社群設定更新
	 */
	public function web_social_update($data='',$id)
	{
		$this->db->where('id',$id);
		$this->db->update('website_social_auth',$data);
	}


}

/* End of file Website_model.php */
/* Location: ./application/models/Website_model.php */