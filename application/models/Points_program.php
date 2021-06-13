<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Points_program extends My_Model{

	public $table_name	=	'points_program';
    public $title   =   '點數方案';
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

        $result = (!empty($where))? $this->db->select('USD')->from($this->table_name)->where($where)->get()->row():'';
        $descript = (!empty($result))? "-".$result->USD.'USD'.$statusStr:'';

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
        $this->db->join('list_points', 'list_points.id='.$this->table_name.'.list_points_id', 'left');
        return parent::search($select, $conditions, $order_by, $limit);
    }

    public function get($id = null, array $select = ['*'], array $order_by = [], array $limit = [], array $where_in = []){
        $this->db->join('list_points', 'list_points.id='.$this->table_name.'.list_points_id', 'left');

        return parent::get($id, $select, $order_by, $limit, $where_in);
    }




}