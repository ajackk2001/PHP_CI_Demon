<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ec_pay extends MY_Controller {
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
       // $this->load->model('Uuid','uuid');
	}
	public function  payment($order_sn=""){
		$payment_sn = $order_tmp='';
        if(!$this->session->userdata('points_program_id'))redirect('pointPlan');
		while (empty($payment_sn)) {
			$order_tmp='N'.date('Ymd').time();
			$count 		= $this->orders_payment->CheckOrder($order_tmp);
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
		$this->load->library('ECPay');
		return $this->ecpay->Send($data);
	}
    public function  item_payment($order_sn=""){
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
        $data['title'] = '$USD'.$item->USD2.'寫真作品';
        $this->load->library('ECPay');
        return $this->ecpay->Send($data,'/ecpay/callback2');
    }
    public function  cancel($order_sn=""){
        try {
            $orders = $this->orders->get(['orders_sn' => $order_sn]);
            $orders_payment = $this->orders_payment->get(['orders_sn' => $order_sn,'status'=>1]);
            if(empty($orders_payment))
                throw new Exception('無此訂單');

            $json=json_decode($orders_payment[0]->reply_message, true);

            $this->load->library('ECPay');


            $data=[
                'CreditRefundId' => $json['gwsr'],
                'CreditAmount' => $json['TradeAmt'],
            ];
            $query = $this->ecpay->queryPay($data);

            $action ='N';
            if($query['RtnValue']['status']=='要關帳'){
                $data=[
                    'MerchantTradeNo'=>$json['MerchantTradeNo'],
                    'Action'=>'E',
                    'TradeNo'=>$json['TradeNo'],
                    'TotalAmount'=>$json['TradeAmt']
                ];
                $this->ecpay->do_action($data);
            }
            if($query['RtnValue']['status']=='已關帳'){
                $action ='R';
            }

            $data=[
                'MerchantTradeNo'=>$json['MerchantTradeNo'],
                'Action'=>$action,
                'TradeNo'=>$json['TradeNo'],
                'TotalAmount'=>$json['TradeAmt']
            ];
            $cancel = $this->ecpay->do_action($data);
            if(!empty($cancel)&&$cancel['RtnCode']==1){
                $result = $this->orders_payment->update(['cancel_status'=>1,'cancel_message'=>json_encode($cancel),'query_message'=>json_encode($query),'update_time'=>date("Y-m-d H:i:s")],['payment_sn'=>$orders_payment[0]->payment_sn]);
                if(!$result)
                    throw new Exception('更新付款資訊失敗');
                $update_data = [
                    'payment_status'=>3,
                    'pay_time'=>date("Y-m-d H:i:s"),
                ];
                if(!$this->orders->update($update_data,['orders_sn' => $order_sn]))
                    throw new Exception('更新訂單資訊失敗');

                $data = [
                    'desc'=>"[".date("Y-m-d H:i:s")."] [".$this->session->userdata('Manager')->name."] 已成功退款",
                    'orders_sn'=>$order_sn,
                    'title'=>'成功退款',
                    'create_time'=>date("Y-m-d H:i:s"),
                    'ip'=>$_SERVER["REMOTE_ADDR"],
                    'admin_id'=>$this->session->userdata('Manager')->id,
                    'admin_name'=>$this->session->userdata('Manager')->name,
                ];
                $this->orders_log->insert($data);
            }else{
                throw new Exception('退款失敗');
            }
            if ($this->db->trans_status() === FALSE)
                throw new Exception($this->lang->line('Delete_fail'));

            $return     =  $this->ReturnHandle(true ,'已成功退款','/Cart/Orders/Detail/'.$orders[0]->id);//'/activity/finish'
            $this->db->trans_commit();

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $error_msg = $e->getMessage();
            $err_url='';
            $return = $this->ReturnHandle(false,$error_msg,$err_url);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function return_money_finish($id=''){
        try {
            $return_list   =   $this->orders_return_list->get(['orders_return_list_id'=>$id],['orders_return_list.*']);
            if(empty($return_list))
                throw new Exception('此操作無效');
            $order_sn = $return_list[0]->orders_sn;
            $orders = $this->orders->get(['orders_sn' => $order_sn]);
            $orders_payment = $this->orders_payment->get(['orders_sn' => $return_list[0]->orders_sn,'status'=>1]);

            $json=json_decode($orders_payment[0]->reply_message, true);
            $this->load->library('ECPay');
            $return_total=$return_list[0]->return_total;
            foreach ($this->orders_return_list->get(['orders_sn' => $order_sn,'return_status'=>1]) as $k => $v) {
                $return_total+=$v->return_total;
            }

            $data=[
                'CreditRefundId' => $json['gwsr'],
                'CreditAmount' => $json['TradeAmt'],
            ];
            $query = $this->ecpay->queryPay($data);
            $TotalAmount = $return_list[0]->return_total;
            $action="R";
            if($return_total>=$json['TradeAmt']){
                $action="N";
                if($query['RtnValue']['status']=='要關帳'){
                    $data=[
                        'MerchantTradeNo'=>$json['MerchantTradeNo'],
                        'Action'=>'E',
                        'TradeNo'=>$json['TradeNo'],
                        'TotalAmount'=>$json['TradeAmt']
                    ];
                    $this->ecpay->do_action($data);
                    $TotalAmount=$json['TradeAmt'];
                }
                if($query['RtnValue']['status']=='已關帳')$action='R';
            }else{
                if($query['RtnValue']['status']=='已授權'){
                    $data=[
                        'MerchantTradeNo'=>$json['MerchantTradeNo'],
                        'Action'=>'C',
                        'TradeNo'=>$json['TradeNo'],
                        'TotalAmount'=>$json['TradeAmt']
                    ];
                    $this->ecpay->do_action($data);
                }
            }


            $data=[
                'MerchantTradeNo'=>$json['MerchantTradeNo'],
                'Action'=>$action,
                'TradeNo'=>$json['TradeNo'],
                'TotalAmount'=>$TotalAmount
            ];
            $cancel = $this->ecpay->do_action($data);
            if(!empty($cancel)&&$cancel['RtnCode']==1){
                $result = $this->orders_return_list->update(['return_status'=>1,'return_message'=>json_encode($cancel),'query_message'=>json_encode($query),'update_time'=>date("Y-m-d H:i:s")],['orders_return_list_id'=>$id]);
                if(!$result)
                    throw new Exception('更新付款資訊失敗');


                $a=0;
                foreach ($this->orders_return_list->get(['orders_sn' => $order_sn]) as $k => $v) {
                    if($v->return_status!=1)$a++;
                }

                if($a==0){
                    $update_data = [
                        'payment_status'=>3,
                    ];
                    if(!$this->orders->update($update_data,['orders_sn' => $order_sn]))
                        throw new Exception('更新訂單資訊失敗');
                }

                $data = [
                    'desc'=>"[".date("Y-m-d H:i:s")."] [".$this->session->userdata('Manager')->name."] 已成功退款，退款金額:$".$return_list[0]->return_total." 【 子訂單號：".$return_list[0]->list_sn." 】",
                    'orders_sn'=>$order_sn,
                    'title'=>'成功退款',
                    'create_time'=>date("Y-m-d H:i:s"),
                    'ip'=>$_SERVER["REMOTE_ADDR"],
                    'admin_id'=>$this->session->userdata('Manager')->id,
                    'admin_name'=>$this->session->userdata('Manager')->name,
                ];
                $this->orders_log->insert($data);
            }else{
                throw new Exception('退款失敗');
            }
            if ($this->db->trans_status() === FALSE)
                throw new Exception($this->lang->line('Delete_fail'));

            $return     =  $this->ReturnHandle(true ,'已成功退款','/Cart/Orders/Detail/'.$orders[0]->id);//'/activity/finish'
            $this->db->trans_commit();

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $error_msg = $e->getMessage();
            $err_url='';
            $return = $this->ReturnHandle(false,$error_msg,$err_url);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

	public function ecpay_callback(){
       $this->load->library('ECPay');
        $msg  = '';
        try {
            $arParameters = $this->input->post();
            if (empty($arParameters)) $post_data = $_GET;
            $CheckMacValue  = $this->ecpay->CheckMacValue($arParameters);
            if (!$CheckMacValue)
                throw new Exception('簽名驗證失敗');
            $this->db->trans_begin();
            $orders_payment = $this->orders_payment->get(['payment_sn' => $arParameters['MerchantTradeNo'],'status'=>0]);
            if (empty($orders_payment))
                throw new Exception('付款編號錯誤');
            $orders_payment = $orders_payment[0];
            if ($orders_payment->paid_amount !=$arParameters['TradeAmt'])
                throw new Exception('訂單金額錯誤');
            $result = $this->orders_payment->update(['status'=>$arParameters['RtnCode'],'reply_code'=> $arParameters['RtnMsg'],'reply_message'=>json_encode($arParameters),'update_time'=>date("Y-m-d H:i:s"),'TradeNo'=>$arParameters['TradeNo']],['payment_sn'=>$arParameters['MerchantTradeNo']]);
            if(!$result)
                throw new Exception('更新付款資訊失敗');
            if ($arParameters['RtnCode'] == 1) { //成功
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
                    $t="恭喜您，訂單「{$arParameters['MerchantTradeNo']}」已付款完成，{$orders_payment->points}鑽石已入帳。";
                    $url='/member/pointRecord';
                    $this->insert_msg($orders_payment->member_id,$t,$url);
                }
            }else{
                $result2 = $this->orders_payment->update(['status'=>2,'reply_code'=> $arParameters['RtnMsg'],'reply_message'=>json_encode($arParameters),'update_time'=>date("Y-m-d H:i:s"),'TradeNo'=>$arParameters['TradeNo']],['payment_sn'=>$arParameters['MerchantTradeNo']]);
                $msg ='付款失敗';
            }
            $this->db->trans_commit();
            echo '1|OK';
        }catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
        }
        $this->do_api_log('CallBack','',json_encode($arParameters),$msg,[]);
        exit;
    }

    public function ecpay_callback2(){
       $this->load->library('ECPay');
        $msg  = '';
        try {
            $arParameters = $this->input->post();
            if (empty($arParameters)) $post_data = $_GET;
            $CheckMacValue  = $this->ecpay->CheckMacValue($arParameters);
            if (!$CheckMacValue)
                throw new Exception('簽名驗證失敗');
            $this->db->trans_begin();
            $orders_payment = $this->orders_payment->get(['payment_sn' => $arParameters['MerchantTradeNo'],'orders_payment.status'=>0],['orders_payment.*','member.nickname']);
            if (empty($orders_payment))
                throw new Exception('付款編號錯誤');
            $orders_payment = $orders_payment[0];
            if ($orders_payment->paid_amount !=$arParameters['TradeAmt'])
                throw new Exception('訂單金額錯誤');
            if (!$orders_payment->item_id)
                throw new Exception('無作品資料');
            $result = $this->orders_payment->update(['status'=>$arParameters['RtnCode'],'reply_code'=> $arParameters['RtnMsg'],'reply_message'=>json_encode($arParameters),'update_time'=>date("Y-m-d H:i:s"),'TradeNo'=>$arParameters['TradeNo']],['payment_sn'=>$arParameters['MerchantTradeNo']]);
            if(!$result)
                throw new Exception('更新付款資訊失敗');
            if ($arParameters['RtnCode'] == 1) { //成功
                $msg ='付款成功';
                $data2=[
                    'member_id'=>$orders_payment->member_id,
                    'item_id'=>$orders_payment->item_id,
                    'create_time'=>date("Y-m-d H:i:s"),
                ];
                $result3 = $this->item_member->insert($data2);
                if(!$result3)throw new Exception('作品購買失敗');


                $item  =  $this->item->get(['item.id'=>$orders_payment->item_id],['item.*','member.nickname'])[0];

                $t="恭喜您，訂單「{$arParameters['MerchantTradeNo']}」已付款完成，成功購買「{$item->title}-{$item->nickname}」作品。";
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
                $result2 = $this->orders_payment->update(['status'=>2,'reply_code'=> $arParameters['RtnMsg'],'reply_message'=>json_encode($arParameters),'update_time'=>date("Y-m-d H:i:s"),'TradeNo'=>$arParameters['TradeNo']],['payment_sn'=>$arParameters['MerchantTradeNo']]);
                $msg ='付款失敗';
            }
            $this->db->trans_commit();
            echo '1|OK';
        }catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
        }
        $this->do_api_log('CallBack','',json_encode($arParameters),$msg,[]);
        exit;
    }

    public function SendEmail($data=[]){
        $this->load->model('Mail_model');
        $this->load->model('Mail_type');
        $this->load->model('Website_model');
        $this->load->model('Receive');
        $this->load->library('Mailer');
        $this->mail     =   $this->mailer->mail;
        $data['web']=$this->Website_model->get_web_info();
        $this->mail->Subject ="會員{$data['ord_name']}您好，您有一筆來自PUNKGO的訂單通知，訂單編號:{$data['orders_sn']}";//設定郵件標題
        $content    =   $this->Mail_type->GetMail(['id'=>4],['content'])[0]->content;

        $replace    =   ['name'=>$data['ord_name']];
        foreach ($replace as $key => $value) {
            $content    =   preg_replace("/{".$key."}/isUx",$value ,$content);
        }
        $data['content']=$content;
        $content    =   $this->load->view('eshop/mail/mailTemplate',$data,true);
        $this->mail->Body = $content; //設定郵件內容
        $this->mail->IsHTML(true); //設定郵件內容為HTML
        $this->mail->AddAddress($data['email'],$data['ord_name']);
        $this->mail->AddBCC('a0980866672@gmail.com');
        //$this->mail->AddBCC('s5439003@gmail.com');
        $sendemail = $this->Receive->GetReceive(['type_id'=>2]);
        foreach ($sendemail as $email => $name) {
            $this->mail->AddBCC($email);
        }
        $result     =   $this->mail->send();
        return $result;
    }

    public function ecpay_paymentInfo(){
        $this->load->library('ECPay');
        $msg  = '';
        try {
            $arParameters = $this->input->post();
            if (empty($arParameters)) $post_data = $_GET;
            $CheckMacValue  = $this->ecpay->CheckMacValue($arParameters);
            if (!$CheckMacValue)
                throw new Exception('簽名驗證失敗');
            $this->db->trans_begin();

            $orders_payment = $this->orders_payment->get(['payment_sn' => $arParameters['MerchantTradeNo'],'status'=>0]);
            $orders = $this->orders->get(['payment_sn' => $arParameters['MerchantTradeNo'],'payment_status'=>0]);
            if (empty($orders_payment))
                throw new Exception('付款編號錯誤');
            if (empty($orders))
                throw new Exception('無此訂單');
            $orders_payment = $orders_payment[0];
            if ($orders_payment->paid_amount !=$arParameters['TradeAmt'])
                throw new Exception('訂單金額錯誤');

            $result = $this->orders_payment->update(['BankCode'=>$arParameters['BankCode'],'vAccount'=> $arParameters['vAccount'],'info_message'=>json_encode($arParameters),'ExpireDate'=>$arParameters['ExpireDate'].' 23:59:59'],['payment_sn'=>$arParameters['MerchantTradeNo']]);
            if(!$result)
                throw new Exception('更新ATM取號資訊失敗');
            if ($arParameters['RtnCode'] == 2) { //成功
                $update_data = [
                    'atminfo_status'=>1,
                ];
                if(!$this->orders->update($update_data,['payment_sn' => $arParameters['MerchantTradeNo']]))
                    throw new Exception('更新訂單資訊失敗');
                $msg ='ATM取號成功';
            }else{
                throw new Exception('ATM取號失敗');
            }
            $this->db->trans_commit();
            echo '1|OK';
        }catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
        }
        echo $msg;
        $this->do_api_log('paymentInfo','',json_encode($arParameters),$msg,[]);
        exit;
    }

	public function do_api_log($name='test',$url='',$post='',$return='',$header='') {
		$path = APPPATH . '/logs/ecpay/';
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

    public function csv_map(){
        $this->load->model('Cart_model','cart');
        $data=$this->input->post();
        if(!$this->session->userdata('cart'))redirect(base_url('/eshop/cart'),'refresh');
        if($data['LogisticsSubType'] == '7-11'){    //7-11
            $data['LogisticsSubType'] = 'UNIMARTC2C';
        }else
        if($data['LogisticsSubType'] == '全家'){  //全家
            $data['LogisticsSubType'] = 'FAMIC2C';
        }else
        if($data['LogisticsSubType'] == '萊爾富'){ //萊爾富
            $data['LogisticsSubType'] = 'HILIFEC2C';
        }
        $this->session->set_userdata('cart_csv',$data);
        $data2['cart_csv']=$this->session->userdata('cart_csv');
        $data2['cart']=$this->session->userdata('cart');
        $data2['eshop_user']=$this->session->userdata('eshop_user');
        $json = json_encode($data2);
        $member_id=$this->session->userdata('eshop_user')['id'];
        $this->cart->update(['json'=>$json],['member_id'=>$this->session->userdata('eshop_user')['id']]);
        $this->load->library('Ecpay_Logistic');
        return $this->ecpay_logistic->SendCvsMap($data,$member_id);
    }

    public function csv_map_callback(){
        if(!$this->input->post('CVSStoreID'))redirect(base_url('/'),'refresh');
        $data = $this->input->post();
        switch($data['LogisticsSubType']) {
            case 'UNIMARTC2C':
                $data['csvType'] = '7-11';
                break;
            case 'FAMIC2C':
                $data['csvType'] = '全家';
                break;
            case 'HILIFEC2C':
                $data['csvType'] = '萊爾富';
                break;
        }
        $data['contact_phone'] = $this->session->userdata('cart_csv')['contact_phone'];
        $data['contact_name'] = $this->session->userdata('cart_csv')['contact_name'];
        $this->session->set_userdata('cart_csv',$data);
        redirect(base_url('/eshop/cart/info'),'refresh');
        //$this->form_submit('/eshop/cart/info');
    }
    public function form_submit($url,$data=[],$title='資料傳輸中') {
        $data['title'] = $title;
        $data['form'] = $data;
        $data['url'] = $url;
        return $this->load->view('api/form_submit',$data);
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

?>