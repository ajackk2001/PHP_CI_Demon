<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cron extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Member_model','member');
        $this->load->model('Mail_model');
        $this->load->model('Mail_type');
        $this->load->model('Website_model');
        $this->load->model('Receive');
        $this->load->model('Teacher_model','teacher');
        $this->load->model('Activity_model','activity');
		$this->load->model('Teacher_event_model','teacher_event');
		$this->load->model('Orders_return','orders_return');
		$this->load->model('Orders_model','orders');
		$this->load->model('Activity_session_model','activity_session');
		$this->load->model('Activity_model','activity');
		$this->load->library('Mailer');

	}
	//log寫入
    public function do_api_log($name,$data) {
        $path = APPPATH . 'logs/cron/';
        if (!is_dir($path)) { mkdir($path); @chmod($path,0775); }

        $filename   = $path . $name . '_' . date('Ymd') . '.log';
        $fp         = fopen($filename,'a+');
        if ($data) {
            fputs($fp, '['.date('Y-m-d H:i:s').'] ' . (is_array($data) ? json_encode($data) : $data) . "\n");
        }
        fclose($fp);
        $perms = fileperms($filename);
        if (!($perms & 0x0002)) { @chmod($filename,0666); }
    }

	/**
	* 發送陪玩訂單開課通知
	*/
	public function send_teacher_email(){
		if(is_cli()){
			//$where = ['DATE_FORMAT(`start_time`, "%Y-%m-%d") '=>date("Y-m-d",strtotime("-1 day")),'type'=>'開課'];
			$where = ['type'=>'陪玩',"DATE_FORMAT(start_time,'%Y-%m-%d')"=>date("Y-m-d",strtotime("+1 day"))];
			$teacher_event = $this->teacher_event->get($where,['teacher_event.*']);

			$where_in['key'] = 'orders.id';
            $where_in['val'] = $this->where_in_array($teacher_event,'orders_id');
            $orders = [];
            if(!empty($teacher_event)){
            	foreach ($this->orders->get(['status'=>1],['orders.*'],[],[],$where_in) as $k => $v) {
	            	$orders[$v->id] = $v;
	            }
            }
            if(!empty($orders)){
            	$where_in['key'] = 'teacher.id';
	            $where_in['val'] = $this->where_in_array($teacher_event,'teacher_id');
	            $teacher = [];
	            foreach ($this->teacher->get([],['teacher.*'],[],[],$where_in) as $k => $v) {
	            	 $teacher[$v->id] = $v;
	            }

	            $where_in['key'] = 'member.id';
	            $where_in['val'] = $this->where_in_array($orders,'member_id');
	            $member = [];
	            foreach ($this->member->get([],['member.*'],[],[],$where_in) as $k => $v) {
	            	$member[$v->id] = $v;
	            }

	            foreach ($teacher_event as $k => $v) {
	            	if($orders[$v->orders_id]->status==1){
	            		$result =$this->SendEmail_1($orders[$v->orders_id],$v,$teacher[$v->teacher_id],$member);
	            		if($result=='200'){
	            			$this->do_api_log('send_teacher_email','陪玩訂單'.$orders[$v->orders_id]->orders_sn.'課程開始發送Email通知成功');
	            		}else{
	            			$this->do_api_log('send_teacher_email','陪玩訂單'.$orders[$v->orders_id]->orders_sn.'課程開始發送Email通知失敗,失敗原因:'.$result);
	            		}
	            	}
	            }
            }

        }else{
            redirect(base_url('/'),'refresh');
        }
	}
	public function where_in_array($data,$key){
		$uidJson = json_encode($data);
        $uorder_sn = array_column(json_decode($uidJson,true), $key);
		return $uorder_sn;
	}

	/**
	* 發送活動訂單開課通知
	*/
	public function send_activity_email(){
		if(is_cli()){
			//$where = ['DATE_FORMAT(`start_time`, "%Y-%m-%d") '=>date("Y-m-d",strtotime("-1 day")),'type'=>'開課'];
			$where = ["DATE_FORMAT(start_time,'%Y-%m-%d')"=>date("Y-m-d",strtotime("+1 day"))];
			$activity_session = $this->activity_session->get($where,['activity_session.*','activity.title','activity.img']);

			$where_in['key'] = 'orders.activity_id';
            $where_in['val'] = $this->where_in_array($activity_session,'activity_id');
            $activity_session_id = $this->where_in_array($activity_session,'id');
            if(!empty($activity_session)){
            	$orders = $this->orders->get(['status'=>1],['orders.*'],[],[],$where_in);
            }
            if(!empty($orders)){
				foreach ($orders as $k => $v) {
	            	$session = json_decode($v->activity_session_id, true);
	            	$i=0;
	            	foreach ($session as $k => $id) {
	            		if(in_array($id,  $activity_session_id))$i++;
	            	}
	            	if($i==0)unset($orders[$k]);
	            }

	            $where_in['key']='orders_sn';
	            $where_in['val']=$this->where_in_array($orders,'orders_sn');
	            $orders_return = $this->orders_return->get([],['orders_return.*'],[],[],$where_in);

	            $order_array = $this->activity_num($orders,$orders_return,$activity_session_id);
	            //echo $this->db->last_query();

	            $where_in['key'] = 'teacher.id';
	            $where_in['val'] = $this->where_in_array($activity_session,'teacher_id');
	            $teacher = [];
	            foreach ($this->teacher->get([],['teacher.*'],[],[],$where_in) as $k => $v) {
	            	 $teacher[$v->id] = $v;
	            }
	            $where_in['key'] = 'member.id';
	            $where_in['val'] = $this->where_in_array($orders,'member_id');
	            $member = [];
	            foreach ($this->member->get([],['member.*'],[],[],$where_in) as $k => $v) {
	            	$member[$v->id] = $v;
	            }

	            foreach ($activity_session as $k => $v) {
	            	if(!empty($order_array[$v->id])){
                    	foreach ($order_array[$v->id] as $k2 => $v2) {
	                        if($v2->status==1){
	                            $result =$this->SendEmail_2($v2,$v,$teacher[$v->teacher_id],$member);
	                            if($result=='200'){
	                                $this->do_api_log('send_activity_email','活動訂單'.$v2->orders_sn.'活動開始發送Email通知成功');
	                            }else{
	                                $this->do_api_log('send_activity_email','活動訂單'.$v2->orders_sn.'活動開始發送Email通知失敗,失敗原因:'.$result);
	                            }
	                        }
                      	}
                    }
	            }
	        }


        }else{
            redirect(base_url('/'),'refresh');
        }
	}
	public function activity_num($data,$orders_return=[], $activity_session_id){
        $activity_num=[];
        foreach ($orders_return as $k => $v) {
            $return[$v->orders_sn][] =json_decode($v->json, true);
        }
     	$order_array=[];
        foreach ($data as $k => $v) {
            $session = json_decode($v->activity_session_id, true);

           	$i=0;
            foreach ($session as $k2 => $id) {
            	if(in_array($id, $activity_session_id)){
            		$activity_num[$id]=$v->people_num;
            		if(!empty($return[$v->orders_sn])){
	                    foreach ($return[$v->orders_sn] as $k3 => $v3) {
	                        if(!empty($v3['session'][$id])){
	                            $activity_num[$id] = $activity_num[$id]-count($v3['session'][$id]);
	                        }
	                    }
	                }
	                if($activity_num[$id]>0)$i++;
            	}
            }
            if($i==0)unset($data[$k]);
        }
        foreach ($data as $k => $v) {
            $session = json_decode($v->activity_session_id, true);
            foreach ($session as $k2 => $id) {
            	$order_array[$id][]=$v;
            }
        }
        return $order_array;
    }
	//陪玩通知
	public function SendEmail_1($data=[],$teacher_event,$teacher,$member){
        $data=(array)$data;
        $this->mailer->__construct();
        $this->mail     =   $this->mailer->mail;
        $data['teacher'] = $teacher->name.' / '.$teacher->nickname;

        $Member     =   $member[$data['member_id']];
        if(!$Member->email)return true;
        $this->mail->Subject ="您的訂單{$data['orders_sn']}，開課通知"; //設定郵件標題
        $content='';
        $content    =   $this->Mail_type->GetMail(['id'=>6],['content'])[0]->content;
        $replace    =   ['start_time'=>$teacher_event->start_time];
        foreach ($replace as $key => $value) {
            $content    =   preg_replace("/{".$key."}/isUx",$value ,$content);
        }
        $data['content']=$content;
        $content    =   $this->load->view('Backend/Mail/mailTemplate',$data,true);
        $this->mail->Body = $content; //設定郵件內容
        $this->mail->IsHTML(true); //設定郵件內容為HTML
        $this->mail->AddAddress($Member->email,$Member->name);
        $this->mail->AddBCC('a0980866672@gmail.com');
        $result = $this->mail->send() ? '200' : $mail->ErrorInfo;
        return $result;
        //echo $Member->email.'<br>';
    }

    //活動通知
	public function SendEmail_2($data=[],$activity_session,$teacher,$member){
        $data=(array)$data;
        $this->mailer->__construct();
        $this->mail     =   $this->mailer->mail;
        $data['activity_teacher'] = $teacher->name.' / '.$teacher->nickname;
        $data['activity'] = $activity_session;
        $data['activity']->id = $activity_session->activity_id;
        $Member     =   $member[$data['member_id']];
        if(!$Member->email)return true;
        $this->mail->Subject ="您的訂單{$data['orders_sn']}，活動通知"; //設定郵件標題
        $content='';
        $content    =   $this->Mail_type->GetMail(['id'=>5],['content'])[0]->content;
        $replace    =   ['title'=>$data['activity']->title,'start_time'=>$data['activity']->start_time];
        foreach ($replace as $key => $value) {
            $content    =   preg_replace("/{".$key."}/isUx",$value ,$content);
        }
        $data['content']=$content;
        $content    =   $this->load->view('Backend/Mail/mailTemplate',$data,true);
        $this->mail->Body = $content; //設定郵件內容
        $this->mail->IsHTML(true); //設定郵件內容為HTML
        $this->mail->AddAddress($Member->email,$Member->name);
        $this->mail->AddBCC('a0980866672@gmail.com');
        $result = $this->mail->send() ? '200' : $mail->ErrorInfo;
        return $result;
        //echo $Member->email.'<br>';
    }
}

/* End of file Index.php */
/* Location: ./application/controllers/Index.php */