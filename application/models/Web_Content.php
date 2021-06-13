<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_Content extends My_Model{
    public $table_name	=	'website_content';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function GetWebContent($field=['*'],$where=[]){
    	return $this->db->select(implode(",",$field))->from($this->table_name)->where($where)->get()->result();
    }

}
