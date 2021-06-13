<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_Social extends My_Model{
    public $table_name	=	'website_social_auth';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function GetWebSocial($field=['*'],$where=[]){
    	return $this->db->select(implode(",",$field))->from($this->table_name)->where($where)->get()->result();
    }

}
