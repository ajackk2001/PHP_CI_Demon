<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_model extends My_Model{

	public $table_name	=	'cash_log';
    public $title   =   '兌現紀錄';
    public function __construct(){
        parent::__construct();
	}

    public function RecordHandle($data){
        $descript =   '';

        return $descript;
    }

    //計算會員點數結餘
    public function cashTotal(){
        $data=$this->db->get($this->table_name)->result_array();
        $total=array();//計錄會員點數總額
        $total2=array();//計錄每次點數計算當下的總額
        $cash_total=array();
        $income_total =array();
        foreach ($data as $key => $v) {
            if ($v['status']!=2) {
                $point=round($v['USD'],1);
                if(empty($total[$v['member_id']]))$total[$v['member_id']]=0;
                if(empty($cash_total[$v['member_id']]))$cash_total[$v['member_id']]=0;
                if(empty($income_total[$v['member_id']]))$income_total[$v['member_id']]=0;
                $total[$v['member_id']]+=round($point,1);
                $total2[$v['member_id']][$v['id']]=$total[$v['member_id']];
                if($v['type']==4){
                    $cash_total[$v['member_id']]+=$point;
                }else{
                    $income_total[$v['member_id']]+=$point;
                }
            }
        }
        $this->total=$total;
        $this->total2=$total2;
        $this->cash_total=$cash_total;
        $this->income_total=$income_total;
    }

    public function redeemcash_ok($where_in){
        $this->db->where_in('id',$where_in);
        $result =   $this->db->update($this->table_name, ['status'=>1,'admin'=>$this->session->Manager->id,'result_date'=>date('Y-m-d H:i:s'),'remark'=>'']);
        return $result;
    }

    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        if(preg_grep('/member\./', $select))
            $this->db->join('member', 'member.id='.$this->table_name.'.member_id', 'left');
        if(preg_grep('/from_member\./', $select))
            $this->db->join('member from_member', 'from_member.id='.$this->table_name.'.from_member', 'left');
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