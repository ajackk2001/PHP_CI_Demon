<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";
class Member extends MY_Manager {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
        //定義自己的表單驗證function
        $this->form_validation->set_message('alpha_numeric2', '{field} 欄位只允許為字母和數字的組合');
		$this->load->model('Member_model','Member_model');
	}
    public function alpha_numeric2($str){
        return (bool) preg_match("/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i", $str);
    }

	/**
        會員總管
    **/
    public function Index(){
    	//$data['types']	=	$this->Member_type->GetMemberType();
        $this->load->view('Backend/Member/member');
    }

    /**
        會員列表-api
    **/
    public function Show(){
        $this->load->model('Orders_payment_model','orders_payment');
        $this->load->model('Item_member_model','item_member');

        $select = ['LPAD(member.id,4,0) as id2','member.*','DATE_FORMAT(member.create_time, "%Y-%m-%d") as create_date'];
        $conditions[] = [
            'field' => ['name','username','nickname'],
            'operator' => 'LIKE',
            'value' => $this->input->post('search'),
        ];
        $conditions[] = [
            'field' => ['`member`.status'],
            'operator' => '=',
            'value' => $this->input->post('status'),
        ];
        $conditions[] = [
            'field' => ['`member`.id'],
            'operator' => '!=',
            'value' => '0000000',
        ];
        if($this->input->post('line')){
            $conditions[] = [
                'field' => ['`member`.line'],
                'operator' => (($this->input->post('line')==2)?'=':'!='),
                'skip_empty' => false,
                'value' => '',
            ];
        }
        $orderby    =   ['member.create_time desc'];
        $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        $limit['limit']     =   $this->input->post('limit');
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->Member_model->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->Member_model->row_count;
        $this->load->model('Points_model');
        $this->Points_model->pointsTotal();
        $pointsTotal    =   $this->Points_model->total;
        foreach ($return['list']  as $k => $v) {
            if(empty($pointsTotal[$v->id]))$pointsTotal[$v->id]=0;
            $return['pointsTotal']=$pointsTotal;
        }

        $midJson = json_encode($return['list']);
        $mid = array_column(json_decode($midJson,true), 'id');

        $where_in['key']='member_id';
        $where_in['val']=$mid;

        foreach ($mid as $k => $v) {
             if(empty($return['paymentTotal'][$v]))$return['paymentTotal'][$v]=0;
             if(empty($return['itemTotal'][$v]))$return['itemTotal'][$v]=0;
        }

        foreach ($this->orders_payment->get([],['*'],[],[],$where_in) as $k => $v) {
            if($v->status==1)$return['paymentTotal'][$v->member_id]+=intval($v->paid_amount);
        }

        foreach ($this->item_member->get([],['*'],[],[],$where_in) as $k => $v) {
            $return['itemTotal'][$v->member_id]++;
        }

        //die();

        // echo "<pre>";
        // print_r($mid);
        // die();

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }


    /**
        會員總管
    **/
    public function Chat_point(){
        //$data['types']    =   $this->Member_type->GetMemberType();
        $this->load->view('Backend/Member/chat_point');
    }

    /**
        會員列表-api
    **/
    public function Chat_point_show(){
        $select = ['LPAD(member.id,4,0) as id2','member.*','DATE_FORMAT(member.create_time, "%Y-%m-%d") as create_date'];
        $conditions[] = [
            'field' => ['name','username','nickname'],
            'operator' => 'LIKE',
            'value' => $this->input->post('search'),
        ];
        $conditions[] = [
            'field' => ['`member`.status'],
            'operator' => '=',
            'value' => $this->input->post('status'),
        ];
        $conditions[] = [
            'field' => ['`member`.id'],
            'operator' => '!=',
            'value' => '0000000',
        ];
        $conditions[] = [
            'field' => ['`member`.type'],
            'operator' => '=',
            'value' => '2',
        ];
        $orderby    =   ['member.create_time desc'];
        $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        $limit['limit']     =   $this->input->post('limit');
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->Member_model->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->Member_model->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function Info($id=''){
        $where  =   ['member.id'=>$id];
        $return     =  $this->Member_model->get($where,['LPAD(member.id,8,0) as id2','member.*','CONCAT("/",member.img) img','DATE_FORMAT(member.create_time, "%Y-%m-%d") as create_date','country.title as country_title'])[0];
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        更新
    **/
    public function Edit($id=''){
        try {
            $original = $this->Member_model->get($id);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $data   =   $this->input->post();

            $type_title='';
            if($this->input->post('type')==2)$type_title='Girls';
            if($this->input->post('type')==3)$type_title='創作者';

            $where  =   ['id' =>  $id];
            $result = $this->Member_model->update($data,$where);
            if (!$result)
                throw new Exception($this->lang->line('Update_Info_fail'));
            if(!empty($type_title)){
                $t="恭喜您已升級為「{$type_title}」。";
                $url='';
                $this->insert_msg($id,$t,$url);
            }

            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
        } catch (Exception $e) {
            $error_msg = $e->getMessage();
            $return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function insert_msg($member_id,$t,$url){
        $this->load->model('Member_msg_model','member_msg');
        $data = [
            'member_id'=> $member_id,
            'msg_type_id'=> 2,
            'title'=> '會員通知',
            'create_time'=> date("Y-m-d H:i:s"),
            'mag_url'=> $url,
            'msg'=>$t,
        ];
        $this->member_msg->insert($data);
    }

}
