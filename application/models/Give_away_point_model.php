<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Give_away_point_model extends My_Model{

	public $table_name	=	'give_away_point';
    public $title   =   '每日簽到總管';
    public function __construct(){
        parent::__construct();
	}
	public function insert_record($id,$data2=[]){}
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
        if(preg_grep('/item_type\./', $select))
            $this->db->join('item_type', 'item_type.id='.$this->table_name.'.type_id', 'left');

        if(preg_grep('/item_category\./', $select))
            $this->db->join('item_category', 'item_category.id='.$this->table_name.'.category_id', 'left');
        return parent::search($select, $conditions, $order_by, $limit);
    }




}