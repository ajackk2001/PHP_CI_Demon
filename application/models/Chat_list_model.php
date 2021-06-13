<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_list_model extends My_Model{

	public $table_name	=	'chat_list';
    public $title   =   '聊天訊息清單';
    public function __construct(){
        parent::__construct();
	}

    public function RecordHandle($data){
        $descript =   '';

        return $descript;
    }


    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        if(preg_grep('/from_member\./', $select))
            $this->db->join('member from_member', 'from_member.id='.$this->table_name.'.from_user', 'left');
        if(preg_grep('/to_member\./', $select))
            $this->db->join("member to_member", "to_member.id={$this->table_name}.to_user", 'inner');
        return parent::search($select, $conditions, $order_by, $limit);
    }

    public function check_quantitye($where=[]) {
        return $this->db->from($this->table_name)->where($where)->count_all_results();
    }


}