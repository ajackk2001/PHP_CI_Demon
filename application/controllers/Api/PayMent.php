<?php
date_default_timezone_set("Asia/Taipei");
defined('BASEPATH') OR exit('No direct script access allowed');

class PayMent extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Member_model','member');
        $this->load->model('Points_program','points_program');
        $this->load->model('SetPoint_model','list_point');
        $this->load->model('Orders_payment_model','orders_payment');
        $this->load->model('Points_model','points');
        $this->load->model('Cash_model','cash');
        $this->load->model('Item_model','item');
        $this->load->model('Item_member_model','item_member');
        $this->load->model('Web_Social');
		$Web_Social	= $this->Web_Social->GetWebSocial([],['title'=>'Gomypay'])[0];
		$this->domain       = $Web_Social->domain;
        $this->MerchantID   = $Web_Social->client_id;
        $this->Ksn   		= $Web_Social->client_secret;
        //$this->cancel_url   = $Web_Social->cancel_url;
        //$this->cron_url     = $Web_Social->cron_url;
	}


    //自動排程
    public function cron(){
        //$this->account();
        if(is_cli()){
           $this->account();
        }else{
            redirect(base_url('/'),'refresh');
        }
    }

    public function codetoarray($jsonx){
        if(!empty(explode("DATA=",$jsonx)[1])){
            $json = explode("DATA=",$jsonx)[1];
            $dataArray = json_decode($json,true);
            $data = ['message'=>$json];
            $data['code'] = $dataArray['returnCode'];
        }else{
            $data = '';
        }
        return $data;
    }


    //入帳搜尋
    public function account_search($payment_sn){
        $DATA=[
            'MID'   =>   $this->MerchantID,
            'ONO'   =>   $payment_sn
        ];
        $data['data']    =   json_encode($DATA);
        $data['ksn']     =   1;
        $data['mac']     =   urlencode(hash('sha256', $data['data'].$this->Ksn));
        $url = $this->cron_url;
        return $this->curl($url, $data);
    }
	public function do_api_log($name='test',$url='',$post='',$return='',$header='') {
        $path = APPPATH . '/logs/gomypay/';
        if (!is_dir($path)) { mkdir($path); }

        $filename   = $path . $name . '_' . date('Ymd') . '.log';
        $fp         = fopen($filename,'a+');
        fputs($fp, "======================================="."\n");
        fputs($fp, "date >>>> ".date('Y-m-d H:i:s')."\n");
        if ($header) {
            fputs($fp, "url >>>> " . json_encode($header) . "\n");
        }
        if ($url) {
            fputs($fp, "url >>>> $url \n");
        }
        if ($post) {
            fputs($fp, "post >>>> " . json_encode($post) . "\n");
        }
        if ($return) {
            fputs($fp, "return >>>> $return\n");
        }
        fclose($fp);
        $perms = fileperms($filename);
        if (!($perms & 0x0002)) { @chmod($filename,0666); }
    }

	public function payment(){
        if(!is_cli())$this->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].'/payment/callback';
        $type=['CVS'=>6,'Credit'=>0];
        $payment_sn = $order_tmp='';
        if(!$this->session->userdata('points_program_id'))redirect('pointPlan');
        while (empty($payment_sn)) {
            $order_tmp='N'.date('Ymd').time();
            $count      = $this->orders_payment->CheckOrder($order_tmp);
            if ($count == 0) $payment_sn = $order_tmp;
        }
        if($this->session->userdata('payment_sn')){
            echo "<script>alert('請勿重複提交');javascript:location.href='/pointPlan';</script>";exit;
        }else{
            $this->session->set_userdata('payment_sn', $payment_sn);
        }

        $points     =  $this->points_program->get(['points_program.id'=>$this->session->userdata('points_program_id')],['points_program.*','ROUND(ROUND(points_program.USD)*list_points.points*(1+points_program.discount*0.01)) as points','ROUND(ROUND(points_program.USD)*list_points.NTD) as NTD','(points_program.USD-0.01) as USD2'])[0];
        $data = [
            'payment_sn' => $payment_sn,
            'title' => '$USD'.$points->USD2.'點數方案',
            'member_id' => $this->session->userdata('user')['id'],
            'payment_type' => $this->input->post('payment_type'),
            'status' => 0,
            'create_time' => date("Y-m-d H:i:s"),
            'update_time' => date("Y-m-d H:i:s"),
            'paid_amount' => $points->NTD,
            'points' => $points->points,
            'USD' => $points->USD2,
        ];
        $this->orders_payment->insert($data);


        $data2=[
            'Send_Type'   =>    $type[$this->input->post('payment_type')],
            'Pay_Mode_No' =>    2,
            'CustomerId'  =>    $this->MerchantID,
            'Order_No'    =>    $payment_sn,
            'TransCode'   =>    00,
            'Buyer_Memo'  =>    '$USD'.$points->USD2.'點數方案',
            'Buyer_Mail'  =>    $this->session->userdata('user')['username'],
            //'e_return'    =>    1,
            //'Str_Check'   =>    $this->Ksn,
            'Callback_Url'=>    $this->redirect_uri,
            //'Return_url'  =>    $this->redirect_uri,
            'TransMode'   =>    1,
            'Amount'      =>    $points->NTD,
        ];

        $url = $this->domain;
        $this->form_submit($url,$data2);

	}


    public function  item_payment($order_sn=""){
        if(!is_cli())$this->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].'/payment/callback2';
        $type=['CVS'=>6,'Credit'=>0];
        $payment_sn = $order_tmp='';
        if(!$this->session->userdata('item_id'))redirect('/album/detail/'.$this->session->userdata('item_id'));
        while (empty($payment_sn)) {
            $order_tmp='N'.date('Ymd').time();
            $count      = $this->orders_payment->CheckOrder($order_tmp);
            if ($count == 0) $payment_sn = $order_tmp;
        }
        if($this->session->userdata('payment_sn')){
            echo "<script>alert('請勿重複提交');javascript:location.href='/payment_item';</script>";exit;
        }else{
            $this->session->set_userdata('payment_sn', $payment_sn);
        }

        $item     =  $this->item->get(['item.id'=>$this->session->userdata('item_id')],['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','ROUND(item.USD*list_points.NTD) as NTD','DATE_FORMAT(item.`update_time`,"%Y年%m月%d日") as update_date'])[0];
        $data = [
            'payment_sn' => $payment_sn,
            'title' => $item->title,
            'member_id' => $this->session->userdata('user')['id'],
            'payment_type' => $this->input->post('payment_type'),
            'status' => 0,
            'item_member_id'=>$item->member_id,
            'create_time' => date("Y-m-d H:i:s"),
            'update_time' => date("Y-m-d H:i:s"),
            'paid_amount' => $item->NTD,
            'USD' => $item->USD2,
            'item_id' => $item->id,
        ];
        $orders_payment = $this->orders_payment->get(['member_id' => $this->session->userdata('user')['id'],'status'=>0,'item_id'=>$item->id]);
        if(empty($orders_payment)){
            $this->orders_payment->insert($data);
        }else{
            $this->orders_payment->update($data,['member_id' => $this->session->userdata('user')['id'],'status'=>0,'item_id'=>$item->id]);
        }
        $title = '$USD'.$item->USD2.'寫真作品';
        $data2=[
            'Send_Type'   =>    $type[$this->input->post('payment_type')],
            'Pay_Mode_No' =>    2,
            'CustomerId'  =>    $this->MerchantID,
            'Order_No'    =>    $payment_sn,
            'TransCode'   =>    00,
            'Buyer_Memo'  =>    $title,
            'Buyer_Mail'  =>    $this->session->userdata('user')['username'],
            //'e_return'    =>    1,
            //'Str_Check'   =>    $this->Ksn,
            'Callback_Url'=>    $this->redirect_uri,
            //'Return_url'  =>    $this->redirect_uri,
            'TransMode'   =>    1,
            'Amount'      =>    $item->NTD,
        ];

        $url = $this->domain;
        $this->form_submit($url,$data2);
    }

    public function callback(){
        $msg  = '';
        try {
            //$get_data = $_GET;

            $get_data = $this->input->post();
            if (empty($get_data)) $get_data = $_GET;


            $this->db->trans_begin();
            $orders_payment = $this->orders_payment->get(['payment_sn' => $get_data['e_orderno'],'status'=>0]);

            if (empty($orders_payment))
                throw new Exception('付款編號錯誤');
            $orders_payment = $orders_payment[0];

            if ($get_data['result'] == 1) { //成功
                $result = $this->orders_payment->update(['status'=>1,'reply_code'=> $get_data['result'],'reply_message'=>json_encode($get_data),'update_time'=>date("Y-m-d H:i:s"),'TradeNo'=>$get_data['OrderID']],['payment_sn'=>$get_data['e_orderno']]);
                if(!$result)
                    throw new Exception('更新付款資訊失敗');
                $msg ='付款成功';
                if($orders_payment->points>0){
                    //消費者產生一筆扣除消費點數紀錄
                    $pointsdata2=[
                        'member_id'=>$orders_payment->member_id,
                        'points'=>$orders_payment->points,
                        'date_add'=>date("Y-m-d H:i:s"),
                        'type'=>1,
                        'payment_sn'=>$orders_payment->payment_sn,
                        'remark'=>$orders_payment->title,
                    ];
                    $result3 = $this->points->insert($pointsdata2);
                    if(!$result3)throw new Exception('點數購買失敗');
                    $t="恭喜您，訂單「{$orders_payment->payment_sn}」已付款完成，{$orders_payment->points}鑽石已入帳。";
                    $url='/member/pointRecord';
                    $this->insert_msg($orders_payment->member_id,$t,$url);
                }
            }else{
                $result2 = $this->orders_payment->update(['status'=>2,'reply_code'=> $get_data['result'],'reply_message'=>json_encode($get_data),'update_time'=>date("Y-m-d H:i:s"),'TradeNo'=>$get_data['OrderID']],['payment_sn'=>$get_data['e_orderno']]);
                $msg ='付款失敗';
            }
            $this->db->trans_commit();
            echo 'SUCCESS';
        }catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
        }
        $this->do_api_log('CallBack','',json_encode($get_data),$msg,[]);
        exit;
    }

    public function callback2(){
        $msg  = '';
        try {
            $arParameters = $this->input->post();
            if (empty($arParameters)) $arParameters = $_GET;
            $this->db->trans_begin();
            $orders_payment = $this->orders_payment->get(['payment_sn' => $arParameters['e_orderno'],'orders_payment.status'=>0],['orders_payment.*','member.nickname']);
            if (empty($orders_payment))
                throw new Exception('付款編號錯誤');
            $orders_payment=$orders_payment[0];
            if (!$orders_payment->item_id)
                throw new Exception('無作品資料');
            if ($arParameters['result'] == 1) { //成功
                $result = $this->orders_payment->update(['status'=>1,'reply_code'=> $arParameters['result'],'reply_message'=>json_encode($arParameters),'update_time'=>date("Y-m-d H:i:s"),'TradeNo'=>$arParameters['OrderID']],['payment_sn'=>$arParameters['e_orderno']]);
                if(!$result)
                    throw new Exception('更新付款資訊失敗');
                $msg ='付款成功';
                $data2=[
                    'member_id'=>$orders_payment->member_id,
                    'item_id'=>$orders_payment->item_id,
                    'create_time'=>date("Y-m-d H:i:s"),
                ];
                $result3 = $this->item_member->insert($data2);
                if(!$result3)throw new Exception('作品購買失敗');

                $item  =  $this->item->get(['item.id'=>$orders_payment->item_id],['item.*','member.nickname'])[0];

                $t="恭喜您，訂單「{$arParameters['e_orderno']}」已付款完成，成功購買「{$item->title}-{$item->nickname}」作品。";
                $url='/member/purchasedItem';
                $this->insert_msg($orders_payment->member_id,$t,$url);

                $set = $this->list_point->get(['id'=>1])[0];
                $USD = round(($orders_payment->USD+0.01)*($set->plus*0.01),1);
                //創作者產生兌現紀錄
                $cashdata2=[
                    'from_member'=>$orders_payment->member_id,
                    'member_id'=>$orders_payment->item_member_id,
                    'USD'=>$USD,
                    'date_add'=>date("Y-m-d H:i:s"),
                    'type'=>1,
                    'item_id'=>$orders_payment->item_id,
                    'payment_sn'=>$orders_payment->payment_sn,
                    'title'=>"會員:{$orders_payment->nickname}，購買「{$item->title}」作品",
                ];
                $result4 = $this->cash->insert($cashdata2);
                if(!$result4)throw new Exception('兌現記錄寫入失敗');
                $t="恭喜您的作品「{$item->title}」已被購買，收入: $ {$USD}(USD)。";
                $url='/member/incomeRecord';
                $this->insert_msg($orders_payment->item_member_id,$t,$url);
            }else{
                $result2 = $this->orders_payment->update(['status'=>2,'reply_code'=> $arParameters['result'],'reply_message'=>json_encode($arParameters),'update_time'=>date("Y-m-d H:i:s"),'TradeNo'=>$arParameters['OrderID']],['payment_sn'=>$arParameters['e_orderno']]);
                $msg ='付款失敗';
            }
            $this->db->trans_commit();
            echo 'SUCCESS';
        }catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
        }
        $this->do_api_log('CallBack','',json_encode($arParameters),$msg,[]);
        exit;
    }


    public function form_submit($url,$data,$title='傳送交易資訊') {
        $data['title'] = $title;
        $data['form'] = $data;
        $data['url'] = $url;
        return $this->load->view('api/form_submit',$data);
    }

    //拆解回傳參數
    public function dismantling($str){
        $data=[];
        $ia=explode(",",$str);
        foreach ($ia as $val) {
            $ia2=explode("=",$val);
            $data[$ia2[0]]=$ia2[1];
        }
        return $data;
    }

 	public function curl($url, $data=[], $extheader=array(), $proxy=false){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 40);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $extheader);
        if($proxy){
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($ch, CURLOPT_HEADER, false);
        if($data){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        if ($error){
             $response = '$error : ('.curl_errno($ch).')' . $error . PHP_EOL;
        }
        curl_close($ch);
        return $response;
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
