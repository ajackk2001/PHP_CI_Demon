<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gift_log_model extends My_Model{

	public $table_name	=	'gift_log';
    public $title   =   '禮物贈送紀錄';
    public function __construct(){
        parent::__construct();
	}

    public function RecordHandle($data){
        $descript =   '';

        return $descript;
    }

    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        if(preg_grep('/member\./', $select))
            $this->db->join('member', 'member.id='.$this->table_name.'.member_id', 'left');
        if(preg_grep('/give_away_member\./', $select))
            $this->db->join("member give_away_member", "give_away_member.id={$this->table_name}.give_away_member_id", 'inner');
        return parent::search($select, $conditions, $order_by, $limit);
    }

    public function get($id = null, array $select = ['*'], array $order_by = [], array $limit = [], array $where_in = []){
        if(preg_grep('/member\./', $select))
            $this->db->join('member', 'member.id='.$this->table_name.'.member_id', 'left');
        if(preg_grep('/country\./', $select))
            $this->db->join('country', 'country.id=member.bank_country', 'left');
        return parent::get($id, $select, $order_by, $limit, $where_in);
    }


}