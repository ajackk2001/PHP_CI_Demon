<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Albums_model extends My_Model{

    public $table_name	=	'albums';
    public $title	=	'活動花絮';
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
    
    public function get($id = null, array $select = ['*'], array $order_by = [], array $limit = [], array $where_in = []){
        if(preg_grep('/albums_type\./', $select)) $this->db->join('albums_type','albums_type.id=albums.type_id','left');
        $this->db->join('(select albums_id,count(id) counts from albums_img group by albums_id) total','albums.id=total.albums_id','left');
        return parent::get($id, $select, $order_by, $limit, $where_in);
    }

    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        if(preg_grep('/albums_type\./', $select)) $this->db->join('albums_type','albums_type.id=albums.type_id','left');
        $this->db->join('(select albums_id,count(id) counts from albums_img group by albums_id) total','albums.id=total.albums_id','left');
        return parent::search($select, $conditions, $order_by, $limit);
    }

}
