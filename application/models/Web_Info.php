<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_Info extends My_Model{
    public $table_name	=	'website_info';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function GetWebInfo($field=['*'],$where=[]){
    	return $this->db->select(implode(",",$field))->from($this->table_name)->where($where)->get()->result();
    }

}
