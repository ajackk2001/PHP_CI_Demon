<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";
class Cash  extends MY_Manager {

	private $file_upload ="points_csv/";	//檔案上傳[路徑]
	public function __construct()
	{
		parent::__construct();
		//載入資料表
		$this->load->model('Cash_model','cash');
        $this->load->model('Member_model','member');
		$this->load->library('form_validation');
	}

    /**
        會員總管
    **/
    public function Index(){
        //$data['types']    =   $this->Member_type->GetMemberType();
        $this->load->view('Backend/Cash/cash');
    }

    /**
        會員列表-api
    **/
    public function Show(){
        $select = ['LPAD(member.id,4,0) as id2','member.*','DATE_FORMAT(member.create_time, "%Y-%m-%d") as create_date'];
        $conditions[] = [
            'field' => ['name','username','nickname'],
            'operator' => 'LIKE',
            'value' => $this->input->post('search'),
        ];
        $conditions[] = [
            'field' => ['`member`.type'],
            'operator' => '=',
            'value' => [2,3],
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
        $return['list']     =   $this->member->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->member->row_count;
        $this->cash->cashTotal();
        $Total    =   $this->cash->total;
        $cashTotal    =   $this->cash->cash_total;
        $income_total   =   $this->cash->income_total;
        if(!empty($return['list'])){
            foreach ($return['list']  as $k => $v) {
                $return['list'][$k]->cashTotal=(empty($cashTotal[$v->id]))?0:$cashTotal[$v->id];
                $return['list'][$k]->Total=(empty($Total[$v->id]))?0:$Total[$v->id];
                $return['list'][$k]->incomeTotal=(empty($income_total[$v->id]))?0:$income_total[$v->id];
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
     * 清單頁-view
     */
    public function income($member_id=''){
        $data['member_id']=$member_id;
        //載入模版
        $this->load->view('Backend/Cash/income',$data);
    }

    /**
        清單頁列表-api
    **/
    public function income_show($member_id=''){
        $date_start = $this->input->post('date_start') ? $this->input->post('date_start').' 00:00:00' : null;
        $date_end = $this->input->post('date_end') ? $this->input->post('date_end').' 23:59:59' : null;
        $select = ['cash_log.*','member.name','member.username','member.nickname'];
        $orderby    =   ['cash_log.date_add desc','cash_log.id desc'];
        $conditions = [
            [
                'field' => ['cash_log.status'],
                'operator' => '!=',
                'value' => 2,
            ],
            [
                'field' => ['cash_log.member_id'],
                'operator' => '=',
                'value' => $member_id,
            ],
            [
                'field' => ['member.name','member.username','member.nickname'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search'),
            ],
            [
                'field' => 'cash_log.date_add',
                'operator' => 'BETWEEN',
                'value' => ['from' => $date_start, 'to' => $date_end,]
            ],
        ];
        if($this->input->post('type')==1){
            $conditions[] = [
                'field' => ['cash_log.type'],
                'operator' => '=',
                'value' => [1,2,3],
            ];
        }
        if($this->input->post('type')==2){
            $conditions[] = [
                'field' => ['cash_log.type'],
                'operator' => '=',
                'value' => [4],
            ];
        }
        $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        $limit['limit']     =   $this->input->post('limit');

        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->cash->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->cash->row_count;
        $this->cash->cashTotal();
        $return['pointsTotal']    =   $this->cash->total2;
        // echo "<PRE>";
        // print_r($return['pointsTotal']);
        // die();
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

	//兌現點數待處理總管
	public function redeemcash_exchange_pending(){
        $this->load->view('Backend/Cash/redeemcash_exchange_pending.php');
    }

    //提領點數待處理總管-ajax
    public function redeemcash_exchange_pending_show()
    {
        $select = ['cash_log.*','member.nickname','member.name','member.username'];
        $orderby    =   ['cash_log.date_add desc'];
        $conditions = [
            [
                'field' => ['cash_log.status'],
                'operator' => '=',
                'value' => '0'
            ],
            [
                'field' => ['cash_log.type'],
                'operator' => '=',
                'value' => '4',
            ],
        ];
        $return['list']      =   $this->cash->search($select, [$conditions], $orderby);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

	//兌現點數已處理總管
	public function redeemcash_exchange_ok(){
        $this->load->view('Backend/Points/redeemcash_exchange_ok.php');
    }

    //兌現點數已處理總管-ajax
	public function redeemcash_exchange_ok_show(){
        $date_start = $this->input->post('date_start') ? $this->input->post('date_start').' 00:00:00' : null;
        $date_end = $this->input->post('date_end') ? $this->input->post('date_end').' 23:59:59' : null;

        $this->load->model('Points_Redeemcash','points_redeemcash');
        $select = ['points_redeemcash.*', '`member`.`username` as `username`' , '`member`.`cellphone` as `phone`', '`shop`.`name` as `s_name`','bank_username','bank_userid','bank_code','branch_code','bank_cc','bank_date','bank_img'];
        $orderby    =   ['points_redeemcash.result_date desc'];
        $conditions = [
            [
                'field' => ['points_redeemcash.status'],
                'operator' => '!=',
                'value' => 0,
            ],
            [
                'field' => ['shop.name','member.username','member.cellphone'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search'),
            ],
            [
                'field' => 'points_redeemcash.result_date',
                'operator' => 'BETWEEN',
                'value' => ['from' => $date_start, 'to' => $date_end,]
            ],
        ];
        if($this->input->post('status'))
        	$conditions[] =[
                'field' => ['points_redeemcash.status'],
                'operator' => '=',
                'value' => $this->input->post('status'),
            ];
        $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        $limit['limit']     =   $this->input->post('limit');
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->points_redeemcash->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->points_redeemcash->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function insert_redeemcash_exchange_msg($status,$member_id,$point){
        $this->load->model('Member_msg_model','member_msg');
        $price =$point - round($point*0.06);
        $t = ($status==1)?'您的點數兌換申請已通過，點數:'.$point.'，兌換金額:NT.$'.$price.'。':'您的點數兌換申請已退回，'.$this->input->post('remark').'。';
        $data = [
            'member_id'=> $member_id,
            'msg_type_id'=> 2,
            'title'=> '點數兌換結果通知',
            'create_time'=> date("Y-m-d H:i:s"),
            'mag_url'=> '/front/member/redeemcash_list',
            'msg'=>$t,
        ];
        $this->member_msg->insert($data);
    }

    //提領點數待處理總管-資料庫
    public function redeemcash_exchange_pending_edit($id='') {

        try {
            $this->db->trans_begin();
            $review_data = $this->cash->get(['cash_log.id' => $id]);
            if (empty($review_data))
                throw new Exception('查無審核資料');
            $cash=$review_data[0];

            $status = $this->input->post('status');
            if ($status == '' || !in_array($status, [0,1,2]))
                throw new Exception('資料傳送錯誤');
            $update = ['status'=>$status,'admin'=>$this->session->Manager->id,'result_date'=>date('Y-m-d H:i:s'),'remark'=>''];
            if ($status == 2) {
                $remark = $this->input->post('remark');
                if (empty($remark))
                    throw new Exception('請輸入退回原因');

                $update['remark'] = $remark;//member_id
                $t="您的收入提領，金額:  $ ".abs($cash->USD)."(USD)，系統審核失敗，詳細原因請洽公司客服。";
                $url='/member/exchangeCash';
                $this->insert_msg($cash->member_id,$t,$url);
            }

            if (!$this->cash->update($update,['cash_log.id' => $id]))
                throw new Exception('更新失敗');

            $return = $this->ReturnHandle(true,'更新成功');

        } catch (Exception $e) {
            $return = $this->ReturnHandle(false,$e->getMessage());
            $this->db->trans_rollback();
        }
        if($return['status']){
        	//$this->insert_redeemcash_exchange_msg($status,$this->input->post('member_id'),$review_data[0]->points);
            $this->db->trans_commit();
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }


    //提領點數待處理總管-資料庫批次
    public function redeemcash_exchange_pending_edit2() {
        if($this->input->post()){
            $m = $this->input->post();
            try {
                $this->db->trans_begin();
                $where_in['key']='id';
                $where_in['val']=$m;

                $cash = $this->cash->get([],['*'],[],[],$where_in);
                $result = $this->cash->redeemcash_ok($m);
                if(!$result) throw new Exception('資料庫更新失敗');

                foreach ($cash as $k => $v) {
                    $t="您的收入提領，金額:  $ ".abs($v->USD)."(USD)，系統審核通過，請查看帳戶是否入帳。";
                    $url='/member/exchangeCash';
                    $this->insert_msg($v->member_id,$t,$url);
                }

                $return     =  $this->ReturnHandle( true,'更新成功');

            }catch (Exception $e) {
                $return = $this->ReturnHandle(false,$e->getMessage());
                $this->db->trans_rollback();
            }
        }else{
            $return     =   $this->ReturnHandle(false,'未知的錯誤');
        }

        if($return['status']){
            $this->db->trans_commit();
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    //銀行資訊
    public function bank_info($id)
    {
    	$where  =   [  'member.id'=>$id];
        $return     =  $this->member->bank_get($where,['member.*','country.title as country_title'])[0];
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

/* End of file Points.php */
/* Location: ./application/controllers/admin/Points.php */