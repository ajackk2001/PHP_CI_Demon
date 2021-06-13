<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_model extends My_Model{

    public $table_name	=	'website_mail_server';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function GetMail($where=[]){
    	return $this->db->where($where)->get($this->table_name)->row();
    }
}
