<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Front extends MY_Controller {
	public $cookie_lang =   '';
    public function __construct(){
        parent::__construct();
        //$this->cookie_lang =   strtolower(strtok($_SERVER['HTTP_ACCEPT_LANGUAGE'], ','));
        $this->load->helper('cookie');
        $this->load->model('Web_Info');
        $this->load->model('Points_model');
        $this->load->model('About_theme_model','about_theme');
        $this->load->model('Member_msg_model','member_msg');
        $this->load->model('SetPoint_model','list_point');
        $this->load->model('Uuid','uuid');
        $this->load->model('Give_away_point_model','give_away_point');
        $this->load->model('Give_away_point_log_model','give_away_point_log');
        $web_info   =   $this->Web_Info->GetWebInfo(['*'])[0];
        $this->about_theme   =   $this->about_theme->get(['status'=>1],['*']);
        //$this->about_theme   =   $this->about_theme->get(['id'=>'1'],['*'])[0];
        $this->web_title    =   $web_info->title_ch;
        $this->web_icon     =   $web_info->icon;
        $this->web_img      =   $web_info->img;
        $this->web_info     =   $web_info;
        $this->web_ga = $web_info->ga_code;
        $this->web_description =  $web_info->description;
        $this->web_keyword =    $web_info->keyword;
        $this->points_total =    0;
        $this->type_title = "";
        $this->msg_unread_quantitye=0;
        $this->chat_list_quantitye =0;
        $this->set = $this->list_point->get(['id'=>1])[0];
        if($this->session->userdata('user')){
            $this->load->model('Chat_list_model','chat_list');
            $this->Points_model->pointsTotal();
            if($this->session->userdata('user')['type']==2)$this->type_title = "(Girl)";
            if($this->session->userdata('user')['type']==3)$this->type_title = "(創作者)";
            $pointsTotal    =   $this->Points_model->total;
            if(!empty($pointsTotal[$this->session->userdata('user')['id']]))$this->points_total =    $pointsTotal[$this->session->userdata('user')['id']];
            //未讀通知
            $this->msg_unread_quantitye = $this->member_msg->check_quantitye(['member_id' => $this->session->userdata('user')['id'], 'msg_status' => 0]);
            //未讀訊息
            $this->chat_list_quantitye = $this->chat_list->check_quantitye(['to_user' => $this->session->userdata('user')['id'], 'read' => 0]);
            $this->give_away_log='';
            if($this->set->give_away_point==1){
                $date=date("Y-m-d");
                $give_away_point_log=$this->give_away_point_log->get(['result_date'=>$date,'member_id'=>$this->session->userdata('user')['id']]);
                if(empty($give_away_point_log)){
                    $give_away_point = $this->give_away_point->get([],[],['id asc']);
                    $uuid = $this->uuid->v4();
                    foreach ($give_away_point as $k => $v) {
                        $date =  date("Y-m-d",strtotime("+{$k} day"));
                        $data = [
                            'member_id'          => $this->session->userdata('user')['id'],
                            'give_away_point_id' => $v->id,
                            'points' => $v->points,
                            'status' => 0,
                            'title' => $v->title,
                            'result_date' => $date,
                            'create_time' => date("Y-m-d H:i:s"),
                            'uuid' => $uuid,
                        ];
                        $this->give_away_point_log->insert($data);
                    }
                    $give_away_point_log=$this->give_away_point_log->get(['result_date'=>$date,'member_id'=>$this->session->userdata('user')['id']]);
                }else{
                    $this->give_away_point_log->update(['status'=>2],['result_date <'=>$date,'member_id'=>$this->session->userdata('user')['id'],'status'=>0]);
                }
                $this->give_away_log=$this->give_away_point_log->get(['uuid'=>$give_away_point_log[0]->uuid],['give_away_point_log.*','give_away_point.img'],['id asc']);
            }
        }

    }
    function birthday($birthday){
        list($year,$month,$day) = explode("-",$birthday);
        $year_diff = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff  = date("d") - $day;//$day_diff < 0 ||
        if ( $month_diff < 0)
        $year_diff--;
        if($year_diff<0)$year_diff=0;
        return $year_diff;
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
    //無條件捨去
    function floor_dec($v, $precision){
        $c = pow(10, $precision);
        return floor($v*$c)/$c;
    }
}