<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_img_model extends My_Model{

	public $table_name	=	'banner_img';
    public $title   =   '主題圖片';
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




}