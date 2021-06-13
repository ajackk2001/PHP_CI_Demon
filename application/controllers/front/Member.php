<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Front.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
class Member extends MY_Front {
	private $img_dir = 'uploads/member/';
	public function __construct(){
		parent::__construct();
		$this->load->model('Member_model','member');
		$this->load->model('Member_model','Member_model');
		$this->load->library('form_validation');
		$this->load->model('Country_model','country');
		$this->load->model('Points_model','points');
		$this->load->model('Orders_payment_model','orders_payment');
		$this->load->model('Item_type_model','item_type');
        $this->load->model('Item_category_model','item_category');
        $this->load->model('Item_scale_model','item_scale');
        $this->load->model('SetPoint_model','list_point');
        $this->load->model('Item_model','item');
        $this->load->model('Cash_model','cash');
		if(!$this->session->userdata('user') && !in_array($this->router->method, ["productCheck",'test']) && $this->input->method()=='get'){
			uri_string();
			if($this->router->method!='login'){
				redirect('member/login');
			}
		}
	}

	//會員
	/**
    資訊
    **/
    public function info(){
        include 'assets/plugins/slim/server/slim.php';
        $id=$this->session->userdata('user')['id'];
        $return     =  $this->member->get($id,['member.*']);
        $return = current($return);
        $return->banner_img = site_url($return->banner_img);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    //會員中心
	public function test(){
		phpinfo();
		//載入模版
		//$this->load->view('front/chat_view');
	}
	//會員中心
	public function memberInfo(){
		//載入模版
		$this->load->view('front/member/member');
	}
	public function CheckLoginCaptcha($captcha){
        return (($captcha!="" && strtolower($captcha)==$this->session->userdata('loginCaptcha')['code'])?true:false);
    }
	//登入
	public function login(){
		if($this->session->userdata('user')&&!$this->session->userdata('login'))redirect('/');
		//載入模版
		$this->load->view('front/member/login');
	}
	//會員中心-會員登入 資料庫連結
	public function login_ajax(){
    	if($this->form_validation->run()){
    		if($this->CheckLoginCaptcha($this->input->post('captcha'))){
    			$url = $this->session->userdata('uri_login')?$this->session->userdata('uri_login'):base_url('/');
    			$session_data=['id','name','username','login_count','nickname','type','status'];
    			$MemberCheck	=	$this->member->get(['username'=>$this->input->post('email')],$session_data);
				if(!$MemberCheck){
					$name = mb_split("@",$this->input->post('email'));
					$RegisterData	=	[
											'name'			=>	$name[0],
											'nickname'			=>	$name[0],
											'username'		=>	$this->input->post('email'),
											'create_time'	=>	date('Y-m-d H:i:s'),
										];
					if($this->member->insert($RegisterData)){
						$id 	=	$this->member->insert_id();
						$MemberData	=	$this->member->GetMember(['id'=>$id],$session_data);
						$UserData =   get_object_vars($MemberData[0]);
						$this->SessionHandle($UserData);
						$return	=	$this->ReturnHandle('success',$this->lang->line('success_register'),base_url('/'));
						$this->session->unset_userdata('loginCaptcha');
					}else{
						$return	=	$this->ReturnHandle('error',$this->lang->line('fail_register'),base_url());
					}
				}else{
					$UserData =   get_object_vars($MemberCheck[0]);
					if($UserData['status']==0){
						$return	=	$this->ReturnHandle(false,'此會員帳號已停權');
						goto end;
					}
					$this->SessionHandle($UserData);
					$return	=	$this->ReturnHandle('success','登入成功',$url);
					$this->session->unset_userdata('loginCaptcha');
				}
    		}else{
    			$return =   $this->ReturnHandle(false,$this->lang->line('error_captcha'));
    		}
    	}else{
    		$return = 	$this->ReturnHandle(false,$this->form_validation->error_array());
    	}
    	end:
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
	//會員登出
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
	//檢視個人資料
	public function detail(){
		$data['member_URL'] = 'https://'.$_SERVER['HTTP_HOST'].'/artist/detail/'.$this->session->userdata('user')['id'];
		$data['member']=$this->Member_model->get(['member.id'=>$this->session->userdata('user')['id']],['member.*','CONCAT("/",member.img) img','DATE_FORMAT(member.create_time,"%Y-%m-%d") as create_date','DATE_FORMAT(member.birthday,"%Y/%m/%d") as birthday','country.title as country_title','type'])[0];
		$data['sex']=['1'=>'男','2'=>'女','0'=>''];

		//載入模版
		$this->load->view('front/member/profile',$data);
	}
	//密碼變更(((聽說是沒有這頁
	public function passwordChange(){
		//載入模版
		$this->load->view('front/member/change');
	}
	//編輯個人資料
	public function infoEdit(){
		$data['member']=$this->Member_model->get(['id'=>$this->session->userdata('user')['id']],['member.*','CONCAT("/",member.img) img'])[0];
		$data['country']    =   $this->country->get(['country.status'=>1],['country.*'],['seq asc']);
		//載入模版
		$this->load->view('front/member/profile_edit',$data);
	}

	//會員中心-會員修改 資料庫連結
    public function edit(){
		if($this->session->userdata('user')){
			include 'assets/plugins/slim/server/slim.php';
			$data   =   $this->input->post();
			$data['update_time']    =  date('Y-m-d H:i:s');
            $unset  =   ['slim','banner_img'];
        	foreach($unset as $v){
                unset($data[$v]);
            }
            $id=$this->session->userdata('user')['id'];
            try {
            	$original = $this->member->get($id);

	            $data   =   $this->input->post();
				$data['update_time']    =  date('Y-m-d H:i:s');
	            $unset  =   ['slim'];
	        	foreach($unset as $v){
	                unset($data[$v]);
	            }
	            //$data['desc'] = mysqli_real_escape_string($data['desc']);

	            //slim
	            $images = Slim::getImages();
	            if($images == false)
	                throw new Exception('Slim was not used to upload these images.');

	            $image = array_shift($images);
	            if (isset($image['output']['data'])) {
	                $slimName = $image['output']['name'];
	                $slimData = $image['output']['data'];
	                $slimUnique = ($this->img_dir.$slimName == $original[0]->img)? false:true;
	                $output = Slim::saveFile($slimData, $slimName, $this->img_dir.$this->session->userdata('user')['id'].'/', $slimUnique);

	                $data['img'] = $output['path'];

	                if ($slimUnique && file_exists($original[0]->img)){
	                    @unlink($original[0]->img);
	                }
	            }

	            $result =   $this->member->update($data,['id'=>$this->session->userdata('user')['id']]);
	            if (!$result)
	                throw new Exception($this->lang->line('Update_Info_fail'));

	            $return =   $this->ReturnHandle($result,(($result)?$this->lang->line('Update_Info_success'):$this->lang->line('Update_Info_fail')),base_url('/member/infoEdit'));

	            $session_data=['id','name','username','login_count','nickname','type'];
	            $MemberData	=	$this->Member_model->GetMember(['id'=>$id],$session_data);
				$UserData =   get_object_vars($MemberData[0]);
				$this->session->set_userdata('user',$UserData);

			} catch (Exception $e) {
				$error_msg = $e->getMessage();
				$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
			}
		}else{
			$return = 	$this->ReturnHandle(false,'此操作須登入會員使用。');
		}
		//die();
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	public function bank_edit(){
		if($this->session->userdata('user')){
			$data   =   $this->input->post();
			$data['update_time']    =  date('Y-m-d H:i:s');
            $unset  =   ['slim','banner_img'];
        	foreach($unset as $v){
                unset($data[$v]);
            }
            $id=$this->session->userdata('user')['id'];
            try {
            	$original = $this->member->get($id);

	            $data   =   $this->input->post();
				$data['update_time']    =  date('Y-m-d H:i:s');

	            $result =   $this->member->update($data,['id'=>$this->session->userdata('user')['id']]);
	            if (!$result)
	                throw new Exception($this->lang->line('Update_Info_fail'));

	            $return =   $this->ReturnHandle($result,(($result)?$this->lang->line('Update_Info_success'):$this->lang->line('Update_Info_fail')),base_url('/member/exchangeCash'));

			} catch (Exception $e) {
				$error_msg = $e->getMessage();
				$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
			}
		}else{
			$return = 	$this->ReturnHandle(false,'此操作須登入會員使用。');
		}
		//die();
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	public function banner_edit(){
		if($this->session->userdata('user')){
			include 'assets/plugins/slim/server/slim.php';
			$data   =   $this->input->post();
			$data['update_time']    =  date('Y-m-d H:i:s');
            $unset  =   ['slim'];
        	foreach($unset as $v){
                unset($data[$v]);
            }
            $id=$this->session->userdata('user')['id'];
            try {
            	$original = $this->member->get($id);

	            $data   =   $this->input->post();
				$data['update_time']    =  date('Y-m-d H:i:s');
	            $unset  =   ['slim'];
	        	foreach($unset as $v){
	                unset($data[$v]);
	            }

	            //slim
	            $images = Slim::getImages();
	            if($images == false)
	                throw new Exception('Slim was not used to upload these images.');

	            $image = array_shift($images);
	            if (isset($image['output']['data'])) {
	                $slimName = $image['output']['name'];
	                $slimData = $image['output']['data'];
	                $slimUnique = ($this->img_dir.$slimName == $original[0]->img)? false:true;
	                $output = Slim::saveFile($slimData, $slimName, $this->img_dir.$this->session->userdata('user')['id'].'/', $slimUnique);

	                $data['banner_img'] = $output['path'];

	                if ($slimUnique && file_exists($original[0]->banner_img)){
	                    @unlink($original[0]->banner_img);
	                }
	            }

	            $result =   $this->member->update($data,['id'=>$this->session->userdata('user')['id']]);
	            if (!$result)
	                throw new Exception($this->lang->line('Update_Info_fail'));

	            $return =   $this->ReturnHandle($result,(($result)?$this->lang->line('Update_Info_success'):$this->lang->line('Update_Info_fail')),base_url('/member/infoEdit'));


			} catch (Exception $e) {
				$error_msg = $e->getMessage();
				$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
			}
		}else{
			$return = 	$this->ReturnHandle(false,'此操作須登入會員使用。');
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	//購買紀錄-顯示已經購買的商品
	public function purchasedItem(){
		//載入模版
		$this->load->view('front/member/purchases');
	}
	public function purchasedItem_json(){
		$this->load->model('Item_member_model','item_member');
		$select = ['item.*','CONCAT("/",member.img) as member_img','member.nickname','(item.USD-0.01) as USD2'];
		$conditions = [
            [
                'field' => ['item_member.member_id'],
                'operator' => '=',
                'value' => $this->session->userdata('user')['id'],
            ],
            $conditions[] = [
	            'field' => ['item.title','member.name','member.username'],
	            'operator' => 'LIKE',
	            'value' => $this->input->post('search'),
	        ],
		];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['item_member.create_time DESC'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        	$limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->item_member->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->item_member->row_count;

        foreach ($return['list'] as $k => $v) {
			if($v->ctr>=1000)$return['list'][$k]->ctr=$this->floor_dec(($v->ctr/1000),1).'k';
		}

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	//最愛收藏
	public function collection(){
		//載入模版
		$this->load->view('front/member/collections');
	}

	public function collection_json(){
		$this->load->model('Item_favorite_model','item_favorite');
		$select = ['item.*','CONCAT("/",member.img) as member_img','member.nickname','(item.USD-0.01) as USD2'];
		$conditions = [
            [
                'field' => ['item_favorite.member_id'],
                'operator' => '=',
                'value' => $this->session->userdata('user')['id'],
            ],
            $conditions[] = [
	            'field' => ['item.title','member.name','member.username'],
	            'operator' => 'LIKE',
	            'value' => $this->input->post('search'),
	        ],
		];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['update_time DESC'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        	$limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->item_favorite->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->item_favorite->row_count;
        foreach ($return['list'] as $k => $v) {
			if($v->ctr>=1000)$return['list'][$k]->ctr=$this->floor_dec(($v->ctr/1000),1).'k';
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	//點數使用紀錄-消費紀錄
	public function pointRecord(){
		//載入模版
		$this->load->view('front/member/record');
	}
	//聊天管理
	public function chat(){
		$this->load->model('Chat_meta_model','chat_meta');
		$this->load->model('Chat_list_model','chat_list');
		$limit['limit']=1;
		$chat_meta = $this->chat_meta->get(['from_user'=>$this->session->userdata('user')['id']],['*'],['update_time desc'],$limit);
		if(!empty($chat_meta)){
			$to_user = $chat_meta[0]->to_user;
			$this->chat_list->update(['read'=>1],['from_user'=>$to_user,'to_user'=>$this->session->userdata('user')['id']]);
			$this->chat_list_quantitye = $this->chat_list->check_quantitye(['to_user' => $this->session->userdata('user')['id'], 'read' => 0]);
		}

		$data['socket_url'] = "wss://taihot.dinj.co:8880/ws/server";//socket server 路徑指向
		$data['name'] = $this->session->userdata('user')['nickname'] ;
		$data['member_id'] = $this->session->userdata('user')['id'] ;
		//載入模版
		$this->load->view('front/member/chat',$data);
	}
	//聊天管理-聯絡人列表
	public function chat_json(){
		$this->load->model('Chat_meta_model','chat_meta');
		$this->load->model('Chat_list_model','chat_list');
		$select = ['CONCAT("/",to_member.img) as img','to_member.chat_point','to_member.nickname','to_member.type','to_user','room_key'];
		$conditions = [
			[
                'field' => ['from_user'],
                'operator' => '=',
                'value' => $this->session->userdata('user')['id'],
            ],
		];
		$return['chat_meta']='';
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['chat_meta.update_time DESC'];
        $return['list']     =   $this->chat_meta->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->chat_meta->row_count;
        if(!empty($return['list'])){
        	$return['to_member'] = $return['list'][0];
        	$return['chat_meta'] = $this->chat_list->get(['room_key'=>$return['to_member']->room_key],['*'],['update_time asc']);
        	$return['total']    =   count($return['chat_meta']);

        	$uidJson = json_encode($return['list']);
	        $to_member = array_column(json_decode($uidJson,true), 'to_user');

	        $where_in=['key'=>'from_user','val'=>$to_member];

	        $chat_member=[];

	        $chat_member=$this->chat_list->get(['read'=>0],[],[],[],$where_in);
	        foreach ($return['list'] as $k => $v) {
	        	if(empty($return['read_num'][$v->to_user]))$return['read_num'][$v->to_user]=0;
	        }
	        foreach ($chat_member as $k => $v) {
	        	$return['read_num'][$v->from_user]++;
	        }

        }



        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	//商品上架
	public function productShelf(){
		$this->clear_images();
		//載入模版
		$this->load->view('front/member/goods');
	}
	//商品上架
	public function productShelf_json(){
		$this->load->model('Item_member_model','item_member');
		$select = ['item.*','DATE_FORMAT(item.`update_time`,"%Y-%m-%d") as update_date','item_category.title as category_title','item_type.title as type_title','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2'];
		$conditions = [
			[
                'field' => ['member_id'],
                'operator' => '=',
                'value' => $this->session->userdata('user')['id'],
            ],
		];
		// if($this->input->post('type_id')){
		// 	$where['travel.type_id'] = $this->input->post('type_id');
		// }
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['item.update_time DESC'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        	$limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->item->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->item->row_count;
        if(!empty($return['list'])){
        	$uidJson = json_encode($return['list']);
	        $uid = array_column(json_decode($uidJson,true), 'id');

	        $where_in=['key'=>'item_id','val'=>$uid];

	        $item_member=[];

	        $item_member=$this->item_member->get([],[],[],[],$where_in);

	        foreach ($return['list'] as $k => $v) {
	        	if(empty($return['member_num'][$v->id]))$return['member_num'][$v->id]=0;
	        }
	        foreach ($item_member as $k => $v) {
	        	$return['member_num'][$v->item_id]++;
	        }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	//新增商品
	public function productAdd(){
        $data['type'] = $this->item_type->get(['status' => 1], ['id', 'title', 'create_time', 'status'],['seq']);
        $data['category'] = $this->item_category->get(['status' => 1], ['item_category.*']);
        $data['scale'] = $this->item_scale->get(['status' => 1], ['item_scale.*'],['seq']);
        $data['set'] = $this->list_point->get(['id'=>1])[0];
        $data['member']=$this->Member_model->get(['member.id'=>$this->session->userdata('user')['id']],['member.*','CONCAT("/",member.img) img','DATE_FORMAT(member.create_time,"%Y-%m-%d") as create_date','DATE_FORMAT(member.birthday,"%Y/%m/%d") as birthday','country.title as country_title'])[0];
		//載入模版
		$this->load->view('front/member/goods_add',$data);
	}
	//新增商品
	public function productEdit($id=''){
		$data=[];
        $data['type'] = $this->item_type->get(['status' => 1], ['id', 'title', 'create_time', 'status'],['seq']);
        $data['category'] = $this->item_category->get(['status' => 1], ['item_category.*']);
        $data['scale'] = $this->item_scale->get(['status' => 1], ['item_scale.*'],['seq']);
        $data['set'] = $this->list_point->get(['id'=>1])[0];
        $data['member']=$this->Member_model->get(['member.id'=>$this->session->userdata('user')['id']],['member.*','CONCAT("/",member.img) img','DATE_FORMAT(member.create_time,"%Y-%m-%d") as create_date','DATE_FORMAT(member.birthday,"%Y/%m/%d") as birthday','country.title as country_title'])[0];
        $this->load->model('Item_img_model','item_img');
		if($id){
			$data['item']     =  $this->item->get(['item.id'=>$id],['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','item_category.title as category_title','item_type.title as type_title','item_scale.title as scale_title']);
		}

		if(empty($data['item'])){
			redirect('/');
		}else{
			$data['item']=$data['item'][0];
			if($this->session->userdata('user')['id']!=$data['item']->member_id)redirect('/');

			$item_img1=$item_img2 = [];
			foreach ($this->item_img->get(['item_id'=>$id,'type'=>1],['item_img.*'],['seq']) as $k => $v) {
				$img_info = pathinfo($v->img);
                if(file_exists('.'.$v->img)){
                    $item_img1[] = [
                        'name' => $v->img,
                        'type' => 'image',
                        'size' => filesize('.'.$v->img),
                        'file' => version($v->img),
                        'data' => [
                            //'thumbnail' => version($img_info['dirname'].'/'.$img_info['filename'].'_thumbnail.'.$img_info['extension']),
                        ],
                    ];
                }
			}

			foreach ($this->item_img->get(['item_id'=>$id,'type'=>2],['item_img.*'],['seq']) as $k => $v) {
				$img_info = pathinfo($v->img);
                if(file_exists('.'.$v->img)){
                    $item_img2[] = [
                        'name' => $v->img,
                        'type' => 'image',
                        'size' => filesize('.'.$v->img),
                        'file' => version($v->img),
                        'data' => [
                            //'thumbnail' => version($img_info['dirname'].'/'.$img_info['filename'].'_thumbnail.'.$img_info['extension']),
                        ],
                    ];
                }
			}
			$data['item_img1']=json_encode($item_img1);
			$data['item_img2']=json_encode($item_img2);
			//載入模版
			$this->load->view('front/member/goods_edit',$data);
		}
	}
	//作品審核
	public function productCheck($id=''){
		$this->load->model('Item_img_model','item_img');
		$data=[];
		if($id){
			$data['item']     =  $this->item->get(['item.id'=>$id],['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','item_category.title as category_title','item_type.title as type_title','item_scale.title as scale_title']);
		}
		if(empty($data['item'])){
			redirect('/');
		}else{
			$data['item']=$data['item'][0];
			if($this->session->Manager->id)goto end;
			if($this->session->userdata('user')['id']!=$data['item']->member_id)redirect('/');
			end:
			$data['item_img1']=$this->item_img->get(['item_id'=>$id,'type'=>1],['item_img.*'],['seq']);
			$data['item_img2']=$this->item_img->get(['item_id'=>$id,'type'=>2],['item_img.*'],['seq']);
			//載入模版
			$this->load->view('front/member/goods_check',$data);
		}

	}
	//聊天紀錄
	public function chat_list(){
		$id=$this->session->userdata('user')['id'];
        $data     =  current($this->member->get($id,['member.chat_point']));
		//載入模版
		$this->load->view('front/member/chat-list',$data);
	}
	public function chat_list_json(){
        $select = ['cash_log.*','member.name','member.username','member.nickname'];
        $orderby    =   ['cash_log.date_add desc','cash_log.id desc'];
        $conditions = [
            [
                'field' => ['cash_log.type'],
                'operator' => '=',
                'value' => 3,
            ],
            [
                'field' => ['cash_log.member_id'],
                'operator' => '=',
                'value' => $this->session->userdata('id'),
            ],
        ];
        $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        $limit['limit']     =   $this->input->post('limit');

        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->cash->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->cash->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	public function chat_point_edit(){
		if($this->session->userdata('user')){
			$data   =   $this->input->post();
			$data['update_time']    =  date('Y-m-d H:i:s');
            $id=$this->session->userdata('user')['id'];
            try {
            	if($this->input->post('chat_point')<1000)
            		throw new Exception('聊天點數不可低於1000點');
	            $data   =   $this->input->post();
				$data['update_time']    =  date('Y-m-d H:i:s');

	            $result =   $this->member->update($data,['id'=>$this->session->userdata('user')['id']]);
	            if (!$result)
	                throw new Exception($this->lang->line('Update_Info_fail'));

	            $return =   $this->ReturnHandle($result,(($result)?$this->lang->line('Update_Info_success'):$this->lang->line('Update_Info_fail')),base_url('/member/chat_list'));

			} catch (Exception $e) {
				$error_msg = $e->getMessage();
				$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
			}
		}else{
			$return = 	$this->ReturnHandle(false,'此操作須登入會員使用。');
		}
		//die();
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	//訂單紀錄-點數購買紀錄
	public function pointOrder(){
		//載入模版
		$this->load->view('front/member/p-list');
	}

	public function orders_json(){
		$select = ['orders_payment.*','DATE_FORMAT(`create_time`,"%Y年%m月%d日") as create_date'];
		$conditions = [
			[
                'field' => ['member_id'],
                'operator' => '=',
                'value' => $this->session->userdata('user')['id'],
            ],
            [
                'field' => ['orders_payment.status'],
                'operator' => '!=',
                'value' => 0,
            ],
		];
		if($this->input->post('type_id')){
			$where['travel.type_id'] = $this->input->post('type_id');
		}
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['orders_payment.create_time DESC'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        	$limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->orders_payment->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->orders_payment->row_count;

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	public function point_json(){
		$select = ['points_log.*','DATE_FORMAT(`date_add`,"%Y年%m月%d日") as create_date'];
		$conditions = [
			[
                'field' => ['member_id'],
                'operator' => '=',
                'value' => $this->session->userdata('user')['id'],
            ],
		];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['points_log.date_add DESC'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        	$limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->points->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->points->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	//點數兌換-點數換現金
	public function exchangeCash(){
		$data['member']=$this->Member_model->get(['id'=>$this->session->userdata('user')['id']],['member.*','CONCAT("/",member.img) img'])[0];
		$data['country']    =   $this->country->get(['country.status'=>1],['country.*'],['seq asc']);
		$data['cashTotal']=0;
		$this->cash->cashTotal();
		$cashTotal    =   $this->cash->total;
            if(!empty($cashTotal[$this->session->userdata('user')['id']]))$data['cashTotal'] =  $cashTotal[$this->session->userdata('user')['id']];
		//載入模版
		$this->load->view('front/member/cash',$data);
	}

	//點數兌換-點數換現金
	public function exchangeCash_json(){
		$select = ['cash_log.*','DATE_FORMAT(`date_add`,"%Y年%m月%d日") as create_date','DATE_FORMAT(`result_date`,"%Y年%m月%d日") as result_date'];
		$conditions = [
			[
                'field' => ['member_id'],
                'operator' => '=',
                'value' => $this->session->userdata('user')['id'],
            ],
            [
                'field' => ['type'],
                'operator' => '=',
                'value' => 4,
            ],
		];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['cash_log.date_add DESC'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        	$limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->cash->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->cash->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	// 收入紀錄
	public function incomeRecord() {
		$this->load->view('front/member/income_record');
	}
	// 收入紀錄
	public function incomeRecord_json() {
		$select = ['cash_log.*','DATE_FORMAT(`date_add`,"%Y年%m月%d日") as create_date','DATE_FORMAT(`result_date`,"%Y年%m月%d日") as result_date','from_member.nickname'];
		$conditions = [
			[
                'field' => ['cash_log.member_id'],
                'operator' => '=',
                'value' => $this->session->userdata('user')['id'],
            ],
            [
                'field' => ['cash_log.type'],
                'operator' => '!=',
                'value' => '4',
            ],
		];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['cash_log.date_add DESC'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        	$limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->cash->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->cash->row_count;

        $this->cash->cashTotal();
        $return['pointsTotal']    =  $this->cash->total[$this->session->userdata('user')['id']];
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	// 刪除沒用到的圖片、縮圖
    private function clear_images(){
        $dir1 = './uploads/videos/tmp/'.$this->session->userdata('user')['id'].'/';
        $dir2 = './uploads/item/image/tmp/'.$this->session->userdata('user')['id'].'/';

        // 刪除沒用到的圖片、縮圖
        foreach (glob($dir1.'*') as $file_path) {
            @unlink($file_path);
        }

        foreach (glob($dir2.'*') as $file_path) {
            @unlink($file_path);
        }
    }

    public function cash_add(){
        try {
            $this->db->trans_begin();
            if(!$this->CheckLoginCaptcha($this->input->post('captcha')))
            	throw new Exception($this->lang->line('error_captcha'));
            if(!$this->session->userdata('user')['id'])
                throw new Exception('停留此畫面過久,請重新登入',1);

            $cash     =  $this->cash->get(['member_id'=>$this->session->userdata('user')['id'],'status'=>0]);

            if(!empty($cash))
            	throw new Exception('一次僅可兌現一筆，處理中不可再申請');

            //創作者產生兌現紀錄
            $cashdata2=[
                'member_id'=>$this->session->userdata('user')['id'],
                'USD'=>'-'.$this->input->post('USD'),
                'date_add'=>date("Y-m-d H:i:s"),
                'type'=>4,
                'status'=>0,
                'title'=>'提領金額 : $'.$this->input->post('USD').'USD',
            ];
            $result4 = $this->cash->insert($cashdata2);
            if(!$result4)throw new Exception('提領記錄寫入失敗');

            $return     =  $this->ReturnHandle(true ,'申請紀錄已成功送出','/member/exchangeCash');

            $this->session->unset_userdata('loginCaptcha');
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
}

/* End of file FrontController.php */
/* Location: ./application/controllers/front/FrontController.php */