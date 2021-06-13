<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Front.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
class Point extends MY_Front {
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
        $this->load->model('Points_program','points_program');
        $this->load->model('SetPoint_model','list_point');
        $this->load->model('Orders_payment_model','orders_payment');
        $this->load->model('Points_model','points');
        if(!$this->session->userdata('user') && !in_array(uri_string(), ["test/mail"]) && $this->input->method()=='get'){
			if($this->router->method!='login'){
				redirect('member/login');
			}
		}
    }
    public function give_away_points_add(){
        $date=date("Y-m-d");
        $set = $this->list_point->get(['id'=>1])[0];
        $give_away_point_log=$this->give_away_point_log->get(['result_date'=>$date,'member_id'=>$this->session->userdata('user')['id']],['give_away_point_log.*','give_away_point.points']);
        try {
            $this->db->trans_begin();
            if($set->give_away_point!=1)
                throw new Exception('此功能尚未開放');
            if(!$this->session->userdata('user')['id'])
                throw new Exception('停留此畫面過久,請重新登入',1);
            if(empty($give_away_point_log))
                throw new Exception('此功能尚未開放');
            if($give_away_point_log[0]->status!=0)//
                throw new Exception('您今天已經簽到了');

            if($give_away_point_log[0]->status==0){
                $this->give_away_point_log->update(['status'=>1],['result_date'=>$date,'member_id'=>$this->session->userdata('user')['id']]);

                $t="每日簽到，{$give_away_point_log[0]->title}，贈送{$give_away_point_log[0]->points}點";

                //贈送每日簽到點數點數紀錄
                $pointsdata2=[
                    'member_id'=>$this->session->userdata('user')['id'],
                    'points'=>$give_away_point_log[0]->points,
                    'date_add'=>date("Y-m-d H:i:s"),
                    'type'=>7,
                    'payment_sn'=>'',
                    'remark'=>$t,
                ];

                $result3 = $this->points->insert($pointsdata2);
                if(!$result3)throw new Exception('點數贈送失敗');

                $url='/member/pointRecord';
                $this->insert_msg($this->session->userdata('user')['id'],$t,$url);
            }

            $return     =  $this->ReturnHandle(true ,'簽到成功','/');
            $return['text']="恭喜您獲得{$give_away_point_log[0]->points}點";
            $return['title']=$give_away_point_log[0]->title;

            $this->db->trans_commit();
        }catch (Exception $e) {
           $this->db->trans_rollback();
            $error_msg = $e->getMessage();
            $err_url='';
            if($e->getCode()==1)$err_url='/member/login';
            $return = $this->ReturnHandle(false,$error_msg,$err_url);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }


	//點數購買
	public function pointPlan(){
        $this->session->unset_userdata('payment_sn');
		$this->session->unset_userdata('points_program_id');
        $data['points_program']  =  $this->points_program->get(['points_program.status'=>1],['points_program.*','ROUND(ROUND(points_program.USD)*list_points.points*(1+points_program.discount*0.01)) as points','ROUND(ROUND(points_program.USD)*list_points.NTD) as NTD','(points_program.USD-0.01) as USD2'],['points_program.USD ASC']);
		//載入模版
		$this->load->view('front/point/pay-plan',$data);
	}

	public function payment(){
        $data=[];
        $this->load->model('Pay_model','list_pay');
        $pay=$this->list_pay->get(['status'=>1])[0];
        $data['pay_url']=$pay->id==1?'/createOrder':'/createOrder2';
        if($this->input->post('points_program_id')){
            $this->session->set_userdata('points_program_id', $this->input->post('points_program_id'));
            $points     =  $this->points_program->get(['points_program.id'=>$this->session->userdata('points_program_id')],['points_program.*','ROUND(ROUND(points_program.USD)*list_points.points*(1+points_program.discount*0.01)) as points','ROUND(ROUND(points_program.USD)*list_points.NTD) as NTD','(points_program.USD-0.01) as USD2'])[0];
            $points->title='$USD'.$points->USD2.'點數方案';
            $data['points'] =$points;
        }else{
            redirect('pointPlan');
        }
		//載入模版
		$this->load->view('front/point/payment-step01',$data);
	}
	public function pay_final(){
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

/* End of file FrontController.php */
/* Location: ./application/controllers/front/FrontController.php */