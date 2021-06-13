<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
 * Changes:
 * 1. This project contains .htaccess file for windows machine.
 *    Please update as per your requirements.
 *    Samples (Win/Linux): http://stackoverflow.com/questions/28525870/removing-index-php-from-url-in-codeigniter-on-mandriva
 *
 * 2. Change 'encryption_key' in application\config\config.php
 *    Link for encryption_key: http://jeffreybarke.net/tools/codeigniter-encryption-key-generator/
 *
 * 3. Change 'jwt_key' in application\config\jwt.php
 *
 */

class Auth extends REST_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('Member_contact','member_contact');
        $this->load->model('Member_addr','member_addr');
        $this->load->model('Member_model');

        $this->load->library('form_validation');
        //定義自己的表單驗證function
        $this->form_validation->set_message('alpha_numeric2', '{field} 欄位只允許為字母和數字的組合');
        $this->load->helper('string');
    }
    public function callback_get()
    {
        if(!$this->session->userdata('id'))redirect('member/login');

        $decodedToken = AUTHORIZATION::validateToken($this->encrypt($this->input->get('code'),'D','PUNKGO'));
        if ($decodedToken != false) {
            $profile=[];
            if($decodedToken->redirect_uri=='/member/infomation'){
                //print_r($decodedToken);
                $member    =   $this->Member_model->get(['member.punkgo_id'=>$decodedToken->punkgo_id]);
                if(empty($member)){
                    $this->Member_model->update(['member.punkgo_id'=>$decodedToken->punkgo_id],['member.id'=>$this->session->userdata('id')]);
                     $profile['status']=1;
                     $this->session->set_userdata('punkgo_id',$decodedToken->punkgo_id);
                     $this->session->set_userdata('punkgo',$profile);
                }else{
                    $profile['error']='此朋客網帳號已有會員綁定，請重新操作';
                    $profile['status']=2;
                    $this->session->set_userdata('punkgo',$profile);
                }
                redirect(base_url($decodedToken->redirect_uri),'refresh');
            }

            if($decodedToken->redirect_uri=='/member/tAccount'){
                //print_r($decodedToken);
                $member    =   $this->Member_model->get(['member.punkgo_id'=>$decodedToken->punkgo_id]);
                if(empty($member)){
                    $this->Member_model->update(['member.punkgo_shop'=>$decodedToken->punkgo_id],['member.id'=>$this->session->userdata('id')]);
                     $profile['status']=1;
                     $this->session->set_userdata('punkgo_shop',$decodedToken->punkgo_id);
                     $this->session->set_userdata('punkgo',$profile);
                }else{
                    $profile['error']='此朋客網帳號已有老師綁定，請重新操作';
                    $profile['status']=2;
                    $this->session->set_userdata('punkgo',$profile);
                }
                redirect(base_url($decodedToken->redirect_uri),'refresh');
            }
            return;
        }else{
            redirect('member/login');
        }
    }
    public function login_get()
    {
        $shop=$this->get('shop')?$this->get('shop'):0;
        $Url=($shop==1)?['redirect_uri'=>'/member/tAccount','call_back'=>$this->config->item('call_back'),'shop'=>1,'user_id'=>$this->encrypt($this->session->userdata('id'),'E','PUNKGO')]:['redirect_uri'=>'/member/infomation','call_back'=>$this->config->item('call_back'),'shop'=>0,'user_id'=>$this->encrypt($this->session->userdata('id'),'E','PUNKGO')];
        $auth_url = $this->createAuthUrl($Url);
        redirect($auth_url);
    }

    public function createAuthUrl($Url=[]){
        $arr=[];
        foreach ($Url as $key => $value) {
            $arr[]=$key.'='.$value;
        }
        $auth_url = $this->config->item('jwt_url').'auth/login?'.implode('&', $arr);

        return $auth_url;
    }
    /**
     * URL: http://localhost/CodeIgniter-JWT-Sample/auth/token
     * Method: GET
     */
    public function token_get()
    {
        $tokenData = array();
        $tokenData['id'] = 12; //TODO: Replace with data for token
        $output['token'] =AUTHORIZATION::generateToken($tokenData);
        $this->set_response($output, REST_Controller::HTTP_OK);
    }

    /**
     * URL: http://localhost/CodeIgniter-JWT-Sample/auth/token
     * Method: POST
     * Header Key: Authorization
     * Value: Auth token generated in GET call
     */
    public function token_post()
    {
        $headers = $this->input->request_headers();

        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $this->set_response($decodedToken, REST_Controller::HTTP_OK);
                return;
            }
        }

        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
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