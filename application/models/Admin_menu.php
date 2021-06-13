<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_menu extends My_Model{
    public $table_name	=	'admin_menu';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle(){
        return '';
    }

    public function GetPermiisionList($type=['type'=>0]){
        return $this->db->order_by('menu_parent_id','asc')->order_by('seq','asc')->where($type)->get($this->table_name)->result();
    }

}
