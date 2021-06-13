<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends My_Model{

    public $table_name	=	'member';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle($data,$data2=''){
        if(!is_array($data)){
            $data   =   $this->db->where(['id'=>$data])->get($this->table_name)->result();
        }
        $type=$this->uri->segment(3)=='Edit'?['1'=>'一般會員','2'=>'Girl','3'=>'創作者']:['0'=>'黑名單','1'=>'啟用'];
        $t=$this->uri->segment(3)=='Edit'?$data[0]->type:$data[0]->status;
        $descript='';
        $descript=':'.$data[0]->id.' '.$data[0]->name.'-'.$type[$t];
        return $descript;
    }

    // 準被棄用，改用 MY_Model#search
    public function GetMember($where,$fields=['*'],$orwhere=[],$orderby=[],$limit=['limit'=>NULL,'offset'=>NULL]){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->where($orwhere)->where($where)->order_by(implode(',',$orderby))->limit($limit['limit'],$limit['offset'])->get()->result();
    }

    public function GetMemberAraay($where_in=[],$select=['*']){
        $query=$this->db->select(implode(',',$select))->where_in('id',$where_in)->from($this->table_name)->get()->result_array();
        $data=array();
        foreach ($query as $r){
            $data[$r['id']]=$r;
        }
        return $data;
    }
    //計算會員推薦人數
    public function GetReferrerNum(){
        $data=$this->db->get($this->table_name)->result_array();
        $num=array();
        foreach ($data as $key => $v) {
            if(!empty($v['referrer_id'])){
                if(empty($num[$v['referrer_id']]))$num[$v['referrer_id']]=0;
                $num[$v['referrer_id']]++;
            }
        }
        return $num;
    }

    public function GetReferrerAraay($orwhere=[],$orderby=[],$between=[],$limit=[]){
        $query=$this->db->where($orwhere)->get($this->table_name)->result_array();
        $where_in=array();
        foreach ($query as $r){
            $where_in[]=$r['id'];
        }
        $this->db->select(implode(',',['LPAD(member.id,8,0) as id2','id','username','name','type','member.status','yunlian','sex','cellphone','shop_status','shop','referrer_id','invitation_code','LPAD(member.referrer_id,8,0) as referrer_id2','referrer_id','country_code','create_time']));
        if(!empty($between))$this->db->where($between);
        ((!empty($where_in))?$this->db->where_in('referrer_id',$where_in):$this->db->where(['id'=>'aaaa']));
        $this->db->order_by(implode(',',$orderby))->limit($limit['limit'],$limit['offset']);
        $data=$this->db->get($this->table_name)->result_array();
        return $data;
    }

    public function GetReferrerTotal($orwhere=[],$orderby=[],$between=[]){
        $query=$this->db->where($orwhere)->get($this->table_name)->result_array();
        $where_in=array();
        foreach ($query as $r){
            $where_in[]=$r['id'];
        }
        $this->db->select(implode(',',['count(id) as total']));
        if(!empty($between))$this->db->where($between);
        ((!empty($where_in))?$this->db->where_in('referrer_id',$where_in):$this->db->where(['id'=>'aaaa']));
        $data=$this->db->order_by(implode(',',$orderby))->get($this->table_name)->result_array();
        $total=$data[0]['total'];
        return  $total;
    }

    //get會員變更權限紀錄
    public function GetMemberPermissionlog($where=''){
        $query=$this->db->get('member_permission')->result_array();
        $member_permission=array();
        foreach ($query as $r){
            $member_permission[$r['id']]=$r['title'];
        }
        $arr=$this->db->from('member_permission_log')->where($where)->get()->result_array();
        foreach ($arr as $key => $v) {
            foreach ($v as $k => $v2) {
                if($k=='member_permission'){
                    $v2=json_decode($v2,true);
                    unset($arr[$key]['member_permission']);
                    foreach ($v2 as $id) {
                        $arr[$key]['member_permission'][]=$member_permission[$id];
                    }
                }
            }
        }
        return $arr;
    }

    public function GetMemberInfo($where,$fields=['*']){
    	return $this->db->select(implode(',',$fields))->from($this->table_name)->join('member_type','member_type.type_id=member.type','left')->where($where)->get()->result();
    }

    public function GetNoPairMember($where,$fields=['*'],$orwhere=[],$orderby=[],$limit=['limit'=>NULL,'offset'=>NULL]){
        return $this->db->select(implode(',',$fields))->from($this->table_name)->join('pair','pair.member_id='.$this->table_name.'.id','left')->where($orwhere)->where('pair_id is null')->where($where)->order_by(implode(',',$orderby))->limit($limit['limit'],$limit['offset'])->get()->result();
    }

    public function GetInfo($where,$fields=['*']){
        return $this->db->select(implode(',',$fields))->from($this->table_name)->join('member_type','member_type.type_id=member.type','left')->where($where)->get()->row();
    }

    public function CheckPayPasswd($payment_password) {
        return $this->db->from($this->table_name)->where('payment_password',$payment_password)->count_all_results();
    }

    public function get($id = null, array $select = ['*'], array $order_by = [], array $limit = [], array $where_in = [],array $group = []){
        if(preg_grep('/country\./', $select))
            $this->db->join('country', 'country.id='.$this->table_name.'.country', 'left');
        if(!empty($group))$this->db->group_by($group);

        return parent::get($id, $select, $order_by, $limit, $where_in);
    }

    public function bank_get($id = null, array $select = ['*'], array $order_by = [], array $limit = [], array $where_in = [],array $group = []){
        if(preg_grep('/country\./', $select))
            $this->db->join('country', 'country.id='.$this->table_name.'.bank_country', 'left');
        if(!empty($group))$this->db->group_by($group);

        return parent::get($id, $select, $order_by, $limit, $where_in);
    }

    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[]){
        if(preg_grep('/country\./', $select))
            $this->db->join('country', 'country.id='.$this->table_name.'.country', 'left');
        return parent::search($select, $conditions, $order_by, $limit);
    }

}
