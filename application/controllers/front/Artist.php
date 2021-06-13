<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Front.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
class Artist extends MY_Front {
	//模特兒 創作者
	public function __construct(){
		parent::__construct();
		$this->load->model('Member_model','member');
		$this->load->model('Item_model','item');
		$this->load->model('Country_model','country');
        $this->load->model('Gift_model','gift');
        $this->load->model('Gift_log_model','gift_log');
	}
	public function model(){
		$data['country']    =   $this->country->get(['country.status'=>1],['country.*'],['seq asc']);
		//載入模版
		$this->load->view('front/artist/models',$data);
	}
	public function model_json(){
		$select = ['member.*','CONCAT("/",member.img) img'];
		$conditions = [
			[
                'field' => ['type'],
                'operator' => '=',
                'value' => '2',
            ],
            [
                'field' => ['member.status'],
                'operator' => '=',
                'value' => '1',
            ],
            [
                'field' => ['member.country'],
                'operator' => '=',
                'value' => $this->input->post('country'),
            ],
            [
                'field' => ['member.nickname'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search'),
            ],
		];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['create_time DESC'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        	$limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->member->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->member->row_count;

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	public function creator(){
		$data['country']    =   $this->country->get(['country.status'=>1],['country.*'],['seq asc']);
		//載入模版
		$this->load->view('front/artist/partner',$data);
	}

	public function creator_json(){
		$select = ['member.*','CONCAT("/",member.img) img'];
		$conditions = [
			[
                'field' => ['type'],
                'operator' => '=',
                'value' => '3',
            ],
            [
                'field' => ['member.status'],
                'operator' => '=',
                'value' => '1',
            ],
            [
                'field' => ['member.country'],
                'operator' => '=',
                'value' => $this->input->post('country'),
            ],
            [
                'field' => ['member.nickname'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search'),
            ],
		];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['create_time DESC'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        	$limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->member->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->member->row_count;

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	public function detail($id=''){
		$data=[];
		if($id){
			$data['member']=$this->member->get(['member.id'=>$id],['member.*','CONCAT("/",member.img) img','DATE_FORMAT(member.create_time,"%Y-%m-%d") as create_date','DATE_FORMAT(member.birthday,"%Y/%m/%d") as birthday','country.title as country_title']);
			$data['sex']=['1'=>'男','2'=>'女','0'=>''];
		}
		if(empty($data['member'])){
			redirect('/');
		}else{
            $data['gift']=$this->gift->get(['status'=>1],['gift.*'],['seq']);
			$data['member']=$data['member'][0];
			//載入模版
			$this->load->view('front/artist/profile',$data);
		}
	}

	public function item_json(){
		$select = ['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2'];
		$conditions = [
			[
                'field' => ['item.status'],
                'operator' => '=',
                'value' => '1',
            ],
            [
                'field' => ['item.member_id'],
                'operator' => '=',
                'value' => $this->input->post('member_id'),
            ],
		];
		// if($this->input->post('type_id')){
		// 	$where['travel.type_id'] = $this->input->post('type_id');
		// }
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['update_time DESC'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        	$limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->item->search($select, [$conditions], $orderby,$limit);
        foreach ($return['list'] as $k => $v) {
            if($v->ctr>=1000)$return['list'][$k]->ctr=$this->floor_dec(($v->ctr/1000),1).'k';
        }
        $return['total']    =   $this->item->row_count;

        // echo $this->db->last_query();
        // die();

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

    //贈送禮物
    public function add_gift(){
        $this->load->model('SetPoint_model','list_point');
        $this->load->model('Cash_model','cash');
        $this->load->model('Points_model','points');
        $msg  = '';
        try {
            $this->db->trans_begin();
            if(!$this->session->userdata('user')['id'])
                throw new Exception('此操作須登入會員',1);
            if(!$this->input->post('gift'))
                throw new Exception('請選擇要贈送的禮物');

            $gift=$this->gift->get(['status'=>1,'id'=>$this->input->post('gift')],['gift.*'],['seq']);

            if(empty($gift))
                throw new Exception('資料庫無此禮物資料');

             if(!$this->input->post('give_away_member_id'))
                throw new Exception('操作錯誤');

            $gift=$gift[0];

            $pay_point=$gift->points*$this->input->post('num');

            if(($this->points_total-$pay_point)<0)
                throw new Exception('點數不足');

            $member=$this->member->get(['member.id'=>$this->input->post('give_away_member_id')],['member.*'])[0];


            //消費者產生一筆扣除消費點數紀錄
            $pointsdata2=[
                'member_id'=>$this->session->userdata('user')['id'],
                'points'=>'-'.$pay_point,
                'date_add'=>date("Y-m-d H:i:s"),
                'type'=>2,
                'gift_id'=>$gift->id,
                'remark'=>'贈送會員: '.$member->nickname.'，禮物方案-'.$gift->title.'*'.$this->input->post('num').' '.$pay_point.'(鑽石)',
            ];
            $result = $this->points->insert($pointsdata2);

            $set = $this->list_point->get(['id'=>1])[0];

            $data2=[
                'member_id'=>$this->session->userdata('user')['id'],
                'points'=>$pay_point,
                'give_away_member_id'=>$this->input->post('give_away_member_id'),
                'date_add'=>date("Y-m-d H:i:s"),
                'gift_id'=>$gift->id,
                'num'=>$this->input->post('num'),
                'title'=>'贈送禮物方案-'.$gift->title.'*'.$this->input->post('num').' '.$pay_point.'(鑽石)',
            ];
            $result3 = $this->gift_log->insert($data2);

            $t="您已消費: {$pay_point}鑽石，購買「禮物方案-{$gift->title} {$gift->points}(鑽石)*{$this->input->post('num')}」，贈送給「{$member->nickname}」。";
            $url='/member/pointRecord';
            $this->insert_msg($this->session->userdata('user')['id'],$t,$url);

            //點數換算金額
            $give_away_price=round($gift->points/$set->points,1);

            $set = $this->list_point->get(['id'=>1])[0];
            $USD = round($give_away_price*($set->plus*0.01),1);
            //創作者產生兌現紀錄
            $cashdata2=[
                'from_member'=>$this->session->userdata('user')['id'],
                'member_id'=>$this->input->post('give_away_member_id'),
                'USD'=>$USD,
                'date_add'=>date("Y-m-d H:i:s"),
                'type'=>2,
                'gift_id'=>$gift->id,
                'title'=>'會員:'.$this->session->userdata('user')['nickname'].'，贈送禮物-'.$gift->title.' '.$gift->points.'(鑽石)',
            ];
            $result4 = $this->cash->insert($cashdata2);


            $t="恭喜您，「{$this->session->userdata('user')['nickname']}」贈送禮物「{$gift->title} {$gift->points}(鑽石)*1」 {$gift->points}鑽石給您，收入: $ {$USD}(USD)。";
            $url='/member/incomeRecord';
            $this->insert_msg($this->input->post('give_away_member_id'),$t,$url);
            $return     =  $this->ReturnHandle(true ,'禮物贈送成功','/artist/detail/'.$this->input->post('give_away_member_id'));
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


    //贈送禮物
    public function add_gift2(){
        $this->load->model('Points_model','points');
        $this->load->model('Item_member_model','item_member');
        die();
        $msg  = '';
        try {
            $this->db->trans_begin();
            if(!$this->session->userdata('item_id'))
                throw new Exception('無商品資料');
            if(!$this->session->userdata('user')['id'])
                throw new Exception('停留此畫面過久,請重新登入',1);

            $item     =  $this->item->get(['item.id'=>$this->session->userdata('item_id')],['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','ROUND(item.USD*list_points.NTD) as NTD','DATE_FORMAT(item.`update_time`,"%Y年%m月%d日") as update_date']);
            if(empty($item))
                throw new Exception('無商品資料');
            $item=$item[0];
            if(($this->points_total-$item->points)<0)
                throw new Exception('點數餘額不足');
            //消費者產生一筆扣除消費點數紀錄
            $pointsdata2=[
                'member_id'=>$this->session->userdata('user')['id'],
                'points'=>'-'.$item->points,
                'date_add'=>date("Y-m-d H:i:s"),
                'type'=>2,
                'item_id'=>$item->id,
                'remark'=>$item->title,
            ];
            $result3 = $this->points->insert($pointsdata2);
            if(!$result3)throw new Exception('點數購買失敗');
            $data2=[
                'member_id'=>$this->session->userdata('user')['id'],
                'item_id'=>$item->id,
                'create_time'=>date("Y-m-d H:i:s"),
            ];
            $this->item_member->insert($data2);

            //創作者產生兌現紀錄
            $cashdata2=[
                'from_member'=>$this->session->userdata('user')['id'],
                'member_id'=>$item->member_id,
                'USD'=>round($item->USD/2,1),
                'date_add'=>date("Y-m-d H:i:s"),
                'type'=>1,
                'payment_sn'=>'',
                'item_id'=>$item->id,
                'title'=>$item->title,
            ];
            $result4 = $this->cash->insert($cashdata2);
            if(!$result4)throw new Exception('兌現記錄寫入失敗');

            $return     =  $this->ReturnHandle(true ,'點數購買成功','/member/pointRecord');
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