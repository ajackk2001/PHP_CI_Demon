<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once "MY_Manager.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-後台付款及配送-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*//
class SetPoint extends MY_Manager {

	public function __construct()
	{
		parent::__construct();
		// //載入資料表
		$this->load->model('SetPoint_model','list_point');
	}

	/**
	 * 運送及優惠相關設定
	 */
	public function index(){
		$data['set'] = $this->list_point->get(['id'=>1])[0];
		//載入模版
		$this->load->view('Backend/Orders/setpoints',$data);
	}

	/**
	 * 運送設定更新
	 */
	public function Edit()
	{
		$data=$this->input->post();
		if($data['plus']>100){
			$return     =  $this->ReturnHandle(false,'分潤比例不可高於100%');
			goto end;
		}
		$where = ['id'=>1];
		$this->list_point->update($data,$where);
		$return     =  $this->ReturnHandle( true,'設定成功');
		end:
		$this->output->set_content_type('application/json')->set_output(json_encode($return));

	}

}

/* End of file Website_info.php */
/* Location: ./application/controllers/admin/Website_info.php */