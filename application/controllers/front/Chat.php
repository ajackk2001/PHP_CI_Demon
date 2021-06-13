<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Front.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
class Chat extends MY_Front {
	//模特兒 創作者
	public function __construct(){
		parent::__construct();
        $this->load->model('Chat_meta_model','chat_meta');
        $this->load->model('Chat_list_model','chat_list');
        $this->load->model('Member_model','member');
        $this->load->model('SetPoint_model','list_point');
        $this->load->model('Cash_model','cash');
        $this->load->model('Points_model','points');
	}
    public function chat_add($id=''){
        try {
            if(!$id)
                throw new Exception('資料庫錯誤');
            if(!$this->session->userdata('user')['id'])
                throw new Exception('此操作須登入會員',1);

            if($this->session->userdata('user')['id']!=$id){
                $where = ['from_user'=>$this->session->userdata('user')['id'],'to_user'=>$id];
                $chat_meta = $this->chat_meta->get($where);
                if(empty($chat_meta)){
                    $data=[
                        'from_user'=>$this->session->userdata('user')['id'],
                        'to_user'=>$id,
                        'room_key'=>uniqid(),
                        'create_time'=>date("Y-m-d H:i:s"),
                        'update_time'=>date("Y-m-d H:i:s"),
                    ];
                    $this->chat_meta->insert($data);
                }else{
                    $result = $this->chat_meta->update(['update_time'=>date("Y-m-d H:i:s")],$where);
                }
            }
            $return     =  $this->ReturnHandle(true ,'');
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
    public function chat_list_add(){
        $this->load->model('SetPoint_model','list_point');
        try {
            $id=$this->input->post('to_member');
            if(!$id)
                throw new Exception('資料庫錯誤');
            if(!$this->session->userdata('user')['id'])
                throw new Exception('此操作須登入會員',1);

            $member=$this->member->get(['member.id'=>$id],['member.*'])[0];
            $from_member=$this->member->get(['member.id'=>$this->session->userdata('user')['id']],['member.*'])[0];
            $set = $this->list_point->get(['id'=>1])[0];
            if($member->type==2&&($this->points_total-$member->chat_point)<0)
                throw new Exception('點數餘額不足');

            if($this->session->userdata('user')['id']!=$id){
                $from_chat_meta = $this->chat_meta->get(['from_user'=>$this->session->userdata('user')['id'],'to_user'=>$id]);
                $where = ['from_user'=>$id,'to_user'=>$this->session->userdata('user')['id']];
                $chat_meta = $this->chat_meta->get($where);
                if(empty($chat_meta)){
                    $data=[
                        'from_user'=>$id,
                        'to_user'=>$this->session->userdata('user')['id'],
                        'room_key'=>$from_chat_meta[0]->room_key,
                        'create_time'=>date("Y-m-d H:i:s"),
                        'update_time'=>date("Y-m-d H:i:s"),
                    ];
                    $this->chat_meta->insert($data);
                }else{
                    $result = $this->chat_meta->update(['update_time'=>date("Y-m-d H:i:s")],$where);
                }
            }
            $msg_data=[
                'from_user'=>$this->input->post('member_id'),
                'to_user'=>$this->input->post('to_member'),
                'message'=>$this->input->post('message'),
                'read'=>0,
                'room_key'=>$from_chat_meta[0]->room_key,
                'update_time'=>date("Y-m-d H:i:s"),
            ];
            $this->chat_list->insert($msg_data);

            if($member->type==2&&($this->points_total-$member->chat_point)>=0){
                $this->points_total=$this->points_total-$member->chat_point;
                //消費者產生一筆扣除消費點數紀錄
                $pointsdata2=[
                    'member_id'=>$this->session->userdata('user')['id'],
                    'points'=>'-'.$member->chat_point,
                    'date_add'=>date("Y-m-d H:i:s"),
                    'type'=>2,
                    'item_id'=>'',
                    'remark'=>'對象:'.$member->nickname.'聊天扣除'.$member->chat_point.'點',
                ];
                $result3 = $this->points->insert($pointsdata2);

                $t="您已消費: {$member->chat_point}鑽石，聊天對象:「{$member->nickname}」。";
                $url='/member/pointRecord';
                $this->insert_msg($this->session->userdata('user')['id'],$t,$url);

                $set = $this->list_point->get(['id'=>1])[0];
                $USD = round(($member->chat_point*($set->plus*0.01))/$set->points,1);
                //創作者產生兌現紀錄
                $cashdata2=[
                    'from_member'=>$this->session->userdata('user')['id'],
                    'member_id'=>$member->id,
                    'USD'=>$USD,
                    'date_add'=>date("Y-m-d H:i:s"),
                    'type'=>3,
                    'payment_sn'=>'',
                    'item_id'=>'',
                    'title'=>'從:'.$from_member->nickname.'聊天獲得'.$member->chat_point.'點',
                ];
                $result4 = $this->cash->insert($cashdata2);

                $t="恭喜您，從聊天對象:「{$from_member->nickname}」獲得 {$member->chat_point}鑽石，收入:$ {$USD}(USD)。";
                $url='/member/incomeRecord';
                $this->insert_msg($member->id,$t,$url);
            }


            $return     =  $this->ReturnHandle(true ,'');
            $return['type']=$member->type;
            $return['points']=$this->points_total;
            $return['chat_data']=[];
            if($this->session->userdata('user')['id']==$this->input->post('member_id'))$return['chat_data']=[
                'name'=>$this->input->post('name'),
                'message'=>$this->input->post('message'),
            ];
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
    //聊天成員列表
    public function chat_get_json(){
        $select = ['chat_list.*'];
        $orderby    =   ['update_time'];
        $conditions = [];//
        $conditions[] = [
            'field' => ['room_key'],
            'operator' => '=',
            'value' => $this->input->post('room_key'),
        ];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $return['list']     =   $this->chat_list->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->chat_list->row_count;
        $return['to_member'] = $this->chat_meta->get(['from_user'=>$this->session->userdata('user')['id'],'room_key'=>$this->input->post('room_key')],['chat_meta.*','to_member.chat_point','to_member.nickname','to_member.type','CONCAT("/",to_member.img) as img'],['update_time asc'],['limit'=>1])[0];

        $to_user = $return['to_member']->to_user;
        $this->chat_list->update(['read'=>1],['from_user'=>$to_user,'to_user'=>$this->session->userdata('user')['id']]);
        $return['chat_list_quantitye'] = $this->chat_list->check_quantitye(['to_user' => $this->session->userdata('user')['id'], 'read' => 0]);
        if($return['chat_list_quantitye']==0)$return['chat_list_quantitye']='';

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function chat_get(){
        $select = ['chat_list.*','from_member.nickname as from_name'];
        $orderby    =   ['update_time'];
        $conditions = [];//
        $conditions[] = [
            'field' => ['room_key'],
            'operator' => '=',
            'value' => $this->input->post('room_key'),
        ];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   $this->input->post('page')-1;
            $limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->chat_list->search($select, [$conditions], $orderby, $limit);
        if(!empty($return['list']))$return['list'][0]->class=($return['list'][0]->from_user==$this->input->post('member_id'))?'from':'to';
        //$return['total']    =   $this->chat_list->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
	public function server(){
        // $this->load->library('WebSocket');
        // $this->websocket->run();


        $this->load->library('Sock');
        $this->sock->run();
    }

    //上傳影片
    public function upload_image(){
        try {
            if(!$this->session->userdata('user')['id'])
                throw new Exception('停留此頁面時間過久，請重新登入');
            if(!file_exists($_FILES['file']['tmp_name']))
                throw new Exception('上傳圖片失敗');
            $img_folder ='/'.$_POST['save_path'].$this->session->userdata('user')['id'].'/';
            // 確保上傳資料夾存在
            @mkdir('.'.$img_folder, 0777, true);
            //取得圖檔原來的名稱
            $file_name = $_FILES['file']['name'];

            if(move_uploaded_file($_FILES['file']['tmp_name'], '.'.$img_folder . $file_name)){
                $return     =   $this->ReturnHandle(true,'');
                $file_name=$img_folder . $file_name;
                $msg_data=[
                    'from_user'=>$this->input->post('member_id'),
                    'to_user'=>$this->input->post('to_member'),
                    'message'=>$file_name,
                    'type'=>2,
                    'read'=>0,
                    'room_key'=>$this->input->post('room_key'),
                    'update_time'=>date("Y-m-d H:i:s"),
                ];
                $this->chat_list->insert($msg_data);
                $return['chat_data']=[
                    'name'=>$this->input->post('name'),
                    'message'=>$file_name,
                ];
                //$return['file_path']=$_POST['save_path'].'/'.$this->session->userdata('user')['id'].'/' . $file_name;
            }else{
                throw new Exception('影片檔案搬移失敗');
            }
        }catch (Exception $e) {
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

/* End of file FrontController.php */
/* Location: ./application/controllers/front/FrontController.php */