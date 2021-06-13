<?php

class MY_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    /**
        登入session
    **/
    public function SessionHandle($data){
        $this->session->set_userdata('user',$data);
        $this->load->model('Member_model','Member_model');
        if($this->session->userdata('user')['id']){
            $data   =   [
                            'login_count'   =>  ($this->session->userdata('user')['login_count'])+1,
                            'login_date'    =>  date('Y-m-d H:i:s'),
                        ];
            $this->Member_model->update($data,['id'=>$this->session->userdata('user')['id']]);
        }
    }
    /**
        回傳處理
    **/
    public function ReturnHandle($status,$msg='',$redirect=''){
        $ReturnHandle   =   ['status'   =>  $status,    'msg'   =>  $msg];
        if($redirect){
            $ReturnHandle['redirect']   =   $redirect;
        }
        return $ReturnHandle;
    }
    /**
        多重搜尋處理
    **/
    public function SearchHandle($orwhere_field,$value){
        $orwhere    =   '';
        $orwhere    .=  '(';
        $tmp =  [];
        foreach ($orwhere_field as $field) {
            $tmp[]  =   "`".$field."` LIKE '%".$value."%'";
        }
        $orwhere    .=  implode(" OR ", $tmp);
        $orwhere    .=  ')';
        return $orwhere;
    }
    /**
        檢查驗證碼
    **/
    public function CheckCaptcha($captcha){
        return (($captcha!="" && strtolower($captcha)==$this->session->userdata('Front'))?true:false);
    }
    /**
        居住地区
    **/
    public function AreaHandle(){
        $areas  =   $this->List_area->GetArea();
        $new_areas  =   [];
        foreach ($areas as $area) {
            $new_areas[$area->city_sn][]    =   $area;
        }
        return $new_areas;
    }

    //加密
    public function encrypt($string,$operation,$key=''){
        $key=md5($key);
        $key_length=strlen($key);
          $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++){
               $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++){
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++){
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D'){
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
                return substr($result,8);
            }else{
                return'';
            }
        }else{
            return str_replace('=','',base64_encode($result));
        }
    }

}