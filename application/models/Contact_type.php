<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_type extends MY_Model {


	public $table_name	=	'contact_type';
    public $title       =   '詢問類型';
	public function __construct(){
        parent::__construct();
    }

    public function RecordHandle($data){
        $descript =   '';
        $statusStr = '';
        $where = [];
        if(!is_array($data)){
            $where = ['id'=>$data];
        }else if (isset($data->id)){
            $where = ['id'=>$data->id];
            $statusStr = (isset($data->status))? $this->RecordStr('status',$data->status):'';
        }else if (isset($data[0]->id)){
            $where = ['id'=>$data[0]->id];
            $statusStr = (isset($data[0]->status))? $this->RecordStr('status',$data[0]->status):'';
        }
        
        $result = (!empty($where))? $this->db->select('title')->from($this->table_name)->where($where)->get()->row():'';
        $descript = (!empty($result))? "-".$result->title.$statusStr:'';
        
        return $descript;
    }
        
    private function RecordStr($field,$value){
        switch ($field) {
            case 'status':
                return ($value==0)? "->停用":"->啟用";
                break;
            default:
                return '';
                break;
        }
    }

    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        $this->db->join('(select type_id,count(id) counts from contact group by type_id) total','contact_type.id=total.type_id','left');
        return parent::search($select, $conditions, $order_by, $limit);
    }

}
