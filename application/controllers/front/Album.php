<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Front.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
class Album extends MY_Front {
	public function __construct(){
		parent::__construct();
		$this->load->model('Member_model','member');
		$this->load->model('Item_model','item');
		$this->load->model('Item_img_model','item_img');
		$this->load->model('Item_type_model','item_type');
		$this->load->model('Item_category_model','item_category');
		$this->load->model('Country_model','country');
		$this->load->model('Item_scale_model','item_scale');
		$this->load->model('Item_favorite_model','item_favorite');
	}
	//相簿
	public function item_list(){
		$data['type'] = $this->item_type->get(['status' => 1], ['id', 'title', 'create_time', 'status'],['seq']);
		$data['scale'] = $this->item_scale->get(['status' => 1], ['item_scale.*'],['seq']);
		$data['country']    =   $this->country->get(['country.status'=>1],['country.*'],['seq asc']);
		$data['type_id']=htmlspecialchars(strip_tags($this->input->get('type_id')));
		$data['category_id']=htmlspecialchars(strip_tags($this->input->get('category_id')));
		$data['category'] = $this->item_category->get(['status' => 1], ['item_category.*'],['type_id']);
		//載入模版
		$this->load->view('front/album/photo',$data);
	}
	//相簿
	public function item_list_json(){
		$select = ['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','country.title as country_title'];
		$conditions = [
			[
                'field' => ['item.status'],
                'operator' => '=',
                'value' => '1',
            ],
            [
                'field' => ['item.type_id'],
                'operator' => '=',
                'value' => $this->input->post('type'),
            ],
            [
                'field' => ['item.category_id'],
                'operator' => '=',
                'value' => $this->input->post('category'),
            ],
            [
                'field' => ['member.country'],
                'operator' => '=',
                'value' => $this->input->post('country'),
            ],
            [
                'field' => ['item.scale_id'],
                'operator' => '=',
                'value' => $this->input->post('scale'),
            ],
		];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    = ($this->input->post('orderby'))?$this->input->post('orderby'):['update_time DESC'];
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
        $return['category'] = $this->item_category->get(['status' => 1], ['item_category.*'],['type_id']);

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	public function onetype_list(){
		//載入模版
		$this->load->view('front/album/onetype_list');
	}
	public function detail($id=''){
        $this->session->unset_userdata('item_id');
		$this->load->model('Item_member_model','item_member');
		$data=$item_favorite=[];
		$result=false;
		$favorite=$isActive=0;
		if($id){
			$data['item']=$this->item->get(['item.id'=>$id],['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','DATE_FORMAT(item.`update_time`,"%Y年%m月%d日") as update_date']);
		}
		if(empty($data['item'])){
			redirect('/');
		}else{
			$this->item->updateCount(['item.id'=>$id]);
			if($this->session->userdata('user')['id']&&!empty($this->item_member->get(['item_id'=>$id,'member_id'=>$this->session->userdata('user')['id']])))$result=true;
			$item_favorite = $this->item_favorite->get(['item_id'=>$id]);
			if(!empty($item_favorite)){
				foreach ($item_favorite as $k => $v) {
					if($v->member_id==$this->session->userdata('user')['id']){
						$isActive=1;
						break;
					}
				}
			}
			$favorite =  count($item_favorite);
			$data['favorite'] =$favorite;
			$data['isActive'] =$isActive;
			$data['item']=$data['item'][0];
			$data['item_img1']=$this->item_img->get(['item_id'=>$id,'type'=>1],['item_img.*'],['seq']);
			$data['item_img2']=$this->item_img->get(['item_id'=>$id,'type'=>2],['item_img.*'],['seq']);
			foreach ($data['item_img2'] as $k => $v) {
				$data['item_img2'][$k]->status=($result)?1:0;
			}
			$data['item']->video=($data['item']->video1)?"/uploads/videos/{$data['item']->member_id}/{$data['item']->id}/".$data['item']->video1:"";
			$data['itemx']=[];
			if($result){
                $data['item']->video2=($data['item']->video2)?"/uploads/videos/{$data['item']->member_id}/{$data['item']->id}/".$data['item']->video2:"";
            }else{
                $data['item']->video2='';
            }
			$data['itemx']     =  $this->item->get(['item.status'=>'1','item.id !='=>$id,'member_id'=>$data['item']->member_id],['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2'],['update_time DESC'],['limit'=>6]);
			$data['result']=$result;
			foreach ($data['itemx'] as $k => $v) {
				if($v->ctr>=1000)$data['itemx'][$k]->ctr=$this->floor_dec(($v->ctr/1000),1).'k';
			}
			//載入模版
			$this->load->view('front/album/photo_detail',$data);
		}
	}

	public function item_favorite_add($item_id=''){
		try {
            if(!$item_id)
                throw new Exception('無商品資料');
            if(!$this->session->userdata('user')['id'])
                throw new Exception('此帳號尚未登入,請重新登入');

            $item     =  $this->item->get(['item.id'=>$item_id],['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','ROUND(item.USD*list_points.NTD) as NTD','DATE_FORMAT(item.`update_time`,"%Y年%m月%d日") as update_date']);
            if(empty($item))
                throw new Exception('無作品資料');
            $where=[
                'member_id'=>$this->session->userdata('user')['id'],
                'item_id'=>$item_id,
            ];
            if(!empty($this->item_favorite->get($where)))
            	throw new Exception('此作品已收藏');
            $data2=[
                'member_id'=>$this->session->userdata('user')['id'],
                'item_id'=>$item_id,
                'create_time'=>date("Y-m-d H:i:s"),
            ];
            $this->item_favorite->insert($data2);
            $return     =  $this->ReturnHandle(true ,'收藏成功');
            $this->db->trans_commit();
        }catch (Exception $e) {
           $this->db->trans_rollback();
            $error_msg = $e->getMessage();
            $err_url='';
            $return = $this->ReturnHandle(false,$error_msg,$err_url);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	public function item_favorite_delete($item_id=''){
		try {
            if(!$item_id)
                throw new Exception('無商品資料');
            if(!$this->session->userdata('user')['id'])
                throw new Exception('此帳號尚未登入,請重新登入');

            $item     =  $this->item->get(['item.id'=>$item_id],['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','ROUND(item.USD*list_points.NTD) as NTD','DATE_FORMAT(item.`update_time`,"%Y年%m月%d日") as update_date']);
            if(empty($item))
                throw new Exception('無作品資料');
            $where=[
                'member_id'=>$this->session->userdata('user')['id'],
                'item_id'=>$item_id,
            ];
            if(empty($this->item_favorite->get($where)))
            	throw new Exception('此作品無收藏');
            $this->item_favorite->delete($where);
            $return     =  $this->ReturnHandle(true ,'收藏取消');
            $this->db->trans_commit();
        }catch (Exception $e) {
           $this->db->trans_rollback();
            $error_msg = $e->getMessage();
            $err_url='';
            $return = $this->ReturnHandle(false,$error_msg,$err_url);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

}

/* End of file FrontController.php */
/* Location: ./application/controllers/front/FrontController.php */