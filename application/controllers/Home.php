<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('front/MY_Front.php');
class Home extends MY_Front {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('AboutForm_model','about_form');
		$this->load->model('Advertising_img_model','advertising_img');
		$this->load->model('Banner_slide');
		$this->load->model('Banner_img_model','banner_img');
		$this->load->model('Item_model','item');
		$this->load->model('Member_model','member');
		$this->load->model('Popular_model','popular');
	}

	/**
	 * 首頁
	 */
	public function index(){
		 $data['about_form']     =  $this->about_form->get(['id'=>'1'],['*'])[0];
		 $data['banner']     =  $this->Banner_slide->get(['status'=>'1'],['*'],['seq'],['limit'=>6]);
		 $data['popular']     =  $this->popular->get(['popular.status'=>'1'],['popular.*','item_category.title as category_title'],['popular.seq']);
		 $data['advertising_img']     =  $this->advertising_img->get(['status'=>'1'],['advertising_img.*'],['rand()'],['limit'=>1]);
		 if(!empty($data['advertising_img']))$data['advertising_img']=$data['advertising_img'][0];
		 $data['banner_img']     =  $this->banner_img->get(['status'=>'1'],['banner_img.*'],['rand()'],['limit'=>6]);
		$data['item']     =  $this->item->get(['item.status'=>'1'],['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2'],['update_time DESC'],['limit'=>8]);
		foreach ($data['item'] as $k => $v) {
			if($v->ctr>=1000)$data['item'][$k]->ctr=$this->floor_dec(($v->ctr/1000),1).'k';
		}
		$data['model']     =  $this->member->get(['member.status'=>'1','type'=>2],['member.*','CONCAT("/",member.img) img'],['create_time'],['limit'=>12]);
		$data['creator']     =  $this->member->get(['member.status'=>'1','type'=>3],['member.*','CONCAT("/",member.img) img'],['create_time'],['limit'=>12]);
		//載入模版
		//$this->load->view('welcome_message');
		$this->load->view('/front/index',$data);
	}


	/**
	 * 404頁面
	 */
	public function page404()
	{
		//載入模版
		$this->load->view('404_page.php');
	}

}

/* End of file Index.php */
/* Location: ./application/controllers/Index.php */