<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_record extends My_Model{
    public $table_name	=	'mail_record';
    public function __construct(){
        parent::__construct();
        $this->record  =  false;
    }

    public function RecordHandle(){
        return '';
    }

    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        $this->db->join('contact','contact.id='.$this->table_name.'.contact_id','left');
        $this->db->join('administrator admin','admin.id='.$this->table_name.'.admin_id','left');
        return parent::search($select, $conditions, $order_by, $limit);
    }

}
