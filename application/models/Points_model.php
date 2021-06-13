<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Points_model extends My_Model{

	public $table_name	=	'points_log';
    public $title   =   '點數方案';
    public function __construct(){
        parent::__construct();
	}

    public function RecordHandle($data){
        $descript =   '';

        return $descript;
    }

    //計算會員點數結餘
    public function pointsTotal(){
        $data=$this->db->get($this->table_name)->result_array();
        $total=array();//計錄會員點數總額
        $total2=array();//計錄每次點數計算當下的總額
        foreach ($data as $key => $v) {
            //$point=($v['type']==1)?$v['points']:-$v['points'];
            $point=$v['points'];
            if(empty($total[$v['member_id']]))$total[$v['member_id']]=0;
            $total[$v['member_id']]+=$point;
            $total2[$v['member_id']][$v['id']]=$total[$v['member_id']];
        }
        $this->total=$total;
        $this->total2=$total2;
    }

    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        if(preg_grep('/member\./', $select))
            $this->db->join('member', 'member.id='.$this->table_name.'.member_id', 'left');
        return parent::search($select, $conditions, $order_by, $limit);
    }


}