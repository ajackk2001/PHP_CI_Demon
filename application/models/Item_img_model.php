<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_img_model extends My_Model{

    public $table_name	=	'item_img';
    public function __construct(){
        parent::__construct();
    }

    public function insert_record($id,$data2=[]){}

    public function RecordHandle($data,$data2=''){
        return '';
    }

}
