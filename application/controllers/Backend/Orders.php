<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'MY_Manager.php';
class Orders extends MY_Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model');
        $this->load->model('Orders_payment_model','orders_payment');
    }

    public function Index()
    {
        $this->load->model('Member_model','Member_model');
        $member_id=htmlspecialchars(strip_tags($this->input->get('member_id')));
        $data['name']='';
        $member=$this->Member_model->get(['id'=>$member_id],['nickname']);
        if(!empty($member))$data['name']=$member[0]->nickname;
        $this->load->view('Backend/Orders/record.php',$data);
    }

    /*
     * 收付款列表
     */
    public function Show()
    {
        $date_start = $this->input->post('date_start') ? $this->input->post('date_start').' 00:00:00' : null;
        $date_end = $this->input->post('date_end') ? $this->input->post('date_end').' 23:59:59' : null;

        $conditions = [
            [
                'field' => ['member.name','member.username','member.nickname'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search'),
            ],
            [
                'field' => ['orders_payment.TradeNo'],
                'operator' => '=',
                'value' => $this->input->post('TradeNo'),
            ],
            [
                'field' => ['orders_payment.payment_sn'],
                'operator' => '=',
                'value' => $this->input->post('payment_sn'),
            ],
            [
                'field' => 'orders_payment.create_time',
                'operator' => 'BETWEEN',
                'value' => ['from' => $date_start, 'to' => $date_end,]
            ],
            [
                'field' => ['orders_payment.status'],
                'operator' => '!=',
                'value' => 0,
            ],
        ];
        $select = ['orders_payment.*','member.name','member.username','member.nickname'];
        $orderby    =   ['orders_payment.create_time desc'];
        $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        $limit['limit']     =   $this->input->post('limit');
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->orders_payment->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->orders_payment->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
     * 收付款細項
     */
    public function Detail($id)
    {
        $select = ['payment.type','payment.payment_sn','payment.remark','payment.shop_member_id','payment.member_id','payment.status','payment.point','payment.price','payment.paid_amount','payment.shop_id','payment.create_time','payment.id','member.cellphone as m_phone','member.username as m_username','member.name as m_name', '`shop_member`.`username` as `s_username`', '`shop_member`.`cellphone` as `s_phone`', '`shop`.`name` as `s_name`','pay_type.name as type_name','pay_name','pay_phone'];
        $data =$this->payment->get(['payment.id'=>$id], $select)[0];

        $this->load->view('Backend/Income_and_expenditure/detail.php', $data);
    }

    //退貨總管
    public function return_pending(){
        $this->load->view('Backend/Income_and_expenditure/return_pending.php');
    }

    //退貨總管-ajax
    public function return_pending_show()
    {
        $date_start = $this->input->post('date_start') ? $this->input->post('date_start').' 00:00:00' : null;
        $date_end = $this->input->post('date_end') ? $this->input->post('date_end').' 23:59:59' : null;

        $select = ['payment_return.*','payment.point','payment.price','payment.type','member.username as m_username','member.name as m_name', '`shop_member`.`username` as `s_username`', '`shop_member`.`cellphone` as `s_phone`', '`shop`.`name` as `s_name`','pay_name','pay_phone'];
        $orderby    =   ['payment_return.create_time desc'];
        $conditions = [
            [
                'field' => ['payment.type'],
                'operator' => '=',
                'value' => $this->input->post('type'),
            ],
            [
                'field' => ['payment.type'],
                'operator' => '!=',
                'value' => 5,
            ],
            [
                'field' => ['payment_return.status'],
                'operator' => '=',
                'value' =>$this->input->post('status'),// $this->input->post('status')
            ],
            [
                'field' => ['member.name','member.username','member.cellphone'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search'),
            ],
            [
                'field' => ['shop.name','shop_member.username','shop_member.cellphone'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search2'),
            ],
            [
                'field' => ['payment.payment_sn'],
                'operator' => '=',
                'value' => $this->input->post('payment_sn'),
            ],
            [
                'field' => 'payment_return.create_time',
                'operator' => 'BETWEEN',
                'value' => ['from' => $date_start, 'to' => $date_end,]
            ],
        ];
        $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        $limit['limit']     =   $this->input->post('limit');
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->payment_return->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->payment_return->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    //退貨總管-資料庫
    public function return_pending_edit($id='') {
        try {
            $this->db->trans_begin();
            $review_data = $this->payment_return->get(['payment_return.id' => $id]);
            if (empty($review_data))
                throw new Exception('查無審核資料');

            $status = $this->input->post('status');
            if ($status == '' || !in_array($status, [0,1,2]))
                throw new Exception('資料傳送錯誤');
            $update = ['status'=>$status,'admin'=>$this->session->Manager->id,'result_date'=>date('Y-m-d H:i:s'),'remark'=>$this->input->post('remark')];

            $payment_data = $this->payment->get(['payment.payment_sn' => $review_data[0]->payment_sn],['payment.*']);
            if(empty($payment_data))
                throw new Exception('查無此訂單資訊');
            $payment_data = (array)$payment_data[0];
            if ($status == 2) {
                $remark = $this->input->post('remark');
                if (empty($remark))
                    throw new Exception('請輸入退回原因');

                $update['remark'] = $remark;//member_id

            }else if($status == 1){
                //假如有消費點數
                if($payment_data['point']>0){
                    //消費者產生一筆扣除消費點數紀錄
                    $pointsdata2=[
                        'member_id'=>$payment_data['member_id'],
                        'points'=>$payment_data['point'],
                        'date_add'=>date("Y-m-d H:i:s"),
                        'type'=>3,
                        'payment_sn'=>$payment_data['payment_sn'],
                        'remark'=>$payment_data['payment_sn'].'退貨，點數退回',
                    ];
                    $result4 = $this->point->insert($pointsdata2);
                    if(!$result4)throw new Exception('操作失敗');
                }

                $point_return_data = (!empty($payment_data['payment_sn']))?$this->point->get(['payment_sn' => $payment_data['payment_sn'],'type'=>1 ],['*']):'';
                if(!empty($point_return_data)){
                    foreach ($point_return_data as $k => $v) {
                        $pointsdata = (array)$v;
                        unset($pointsdata['id']);
                        $pointsdata['remark'] = $payment_data['payment_sn'].'退貨';
                        $pointsdata['date_add'] = date("Y-m-d H:i:s");
                        $pointsdata['type'] = 6;
                        $pointsdata['points'] = '-'.$pointsdata['points'];
                        if(!$this->point->insert($pointsdata))throw new Exception('操作失敗');
                    }
                }

                unset($payment_data['id']);
                $payment_data['create_time'] = date("Y-m-d H:i:s");
                $payment_data['update_time'] = date("Y-m-d H:i:s");
                $payment_data['grant_sn'] = '';
                $payment_data['type'] = '5';
                $payment_data['status'] = '5';
                $payment_data['paid_amount'] = ($payment_data['paid_amount']==0)?0:-$payment_data['paid_amount'];
                $payment_data['point'] = ($payment_data['point']==0)?0:-$payment_data['point'];
                $payment_data['price'] = -$payment_data['price'];

                $result3 = $this->payment->insert($payment_data);
                if(!$result3)throw new Exception('操作失敗');
            }

            if (!$this->payment_return->update($update,['id' => $id]))
                throw new Exception('操作失敗');

            $return = $this->ReturnHandle(true,'操作成功');

        } catch (Exception $e) {
            $return = $this->ReturnHandle(false,$e->getMessage());
            $this->db->trans_rollback();
        }
        if($return['status']){
            $this->insert_return_msg($payment_data['payment_sn']);
            $this->db->trans_commit();
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function insert_return_msg($payment_sn){
        $this->load->model('Member_msg_model','member_msg');
        $payment = $this->payment->get(['payment.payment_sn' =>$payment_sn],['payment.*','member.username','shop.name'])[0];
        if($payment->member_id != '00000000'){
            $data = [
                'member_id'=> $payment->member_id,
                'msg_type_id'=> 3,
                'title'=> '退貨完成通知',
                'create_time'=> date("Y-m-d H:i:s"),
                'mag_url'=> '/front/member/orderbuy_stores',
                'msg'=> '您有一筆退貨'.$payment->payment_sn.'「'.$payment->name.'」，支付金額:NT$'.$payment->paid_amount.'，退貨完成。',
            ];
            $this->member_msg->insert($data);
        }
        $username = ($payment->member_id=='00000000')?$payment->pay_name:$payment->username;
        $data = [
            'member_id'=> $payment->shop_member_id,
            'msg_type_id'=> 3,
            'title'=> '退貨完成通知',
            'create_time'=> date("Y-m-d H:i:s"),
            'mag_url'=> '/front/member/orderbuy_stores',
            'msg'=> '您有一筆退貨'.$payment->payment_sn.'「'.$username.'」，訂單金額:NT$'.$payment->price.'，退貨完成。',
        ];
        $this->member_msg->insert($data);
    }

    /**
     * 運送及優惠相關設定
     */
    public function Pay(){
        $this->load->model('Pay_model','list_pay');
        $data['shipment'] = $this->list_pay->get();
        //載入模版
        $this->load->view('Backend/Orders/pay',$data);
    }

    /**
     * 運送設定更新
     */
    public function PayUpdate($id)
    {
        $this->load->model('Pay_model','list_pay');
        $this->list_pay->update(['status'=>0]);
        $where = ['id'=>$id];
        $this->list_pay->update(['status'=>1],$where);
        $return     =  $this->ReturnHandle( true,'設定成功','/Backend/Orders/Pay');
        $this->output->set_content_type('application/json')->set_output(json_encode($return));

    }
}
