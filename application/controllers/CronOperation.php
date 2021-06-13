<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CronOperation extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

	}

	/**
	 * 檢查需要提醒的諮詢
	 */
	public function CheckAdvisory()	{
		$this->load->model('Advisory_model');
		$this->load->model('Advisory_detail_model');

		// 六天專員未回复
		$select_data['fields'] 		= ['advisory.id'];
		$select_data['where_str']   = "advisory.status IN ('0','1') AND advisory.flag <> 2";
		$select_data['where_str']  .= " AND last_advisory_time < '" . date('Y-m-d H:i:s', strtotime('-6 DAY')) . "'";
		$select_data['where_str']  .= " AND (advisory.last_reply_time IS NULL OR advisory.last_reply_time < advisory.last_advisory_time)";
		$data 						= $this->Advisory_model->get_list($select_data);
		if (sizeof($data) > 0) {
			$ad_id_arr = [];
			foreach ($data as $key => $value) {
				$ad_id_arr[] = $value->id;
				$this->InsertMemberMsg($value->id,2);
			}
			$this->Advisory_model->update(['flag' => '2'],"id IN ('".implode("','", $ad_id_arr)."')");
		}

		// 三天專員未回复
		$select_data['fields'] 		= ['advisory.id'];
		$select_data['where'] 		= ['advisory.flag' => '0'];
		$select_data['where_str']   = "advisory.status IN ('0','1')";
		$select_data['where_str']  .= " AND last_advisory_time < '" . date('Y-m-d H:i:s', strtotime('-3 DAY')) . "'";
		$select_data['where_str']  .= " AND (advisory.last_reply_time IS NULL OR advisory.last_reply_time < advisory.last_advisory_time)";
		$data 						= $this->Advisory_model->get_list($select_data);
		if (sizeof($data) > 0) {
			$ad_id_arr = [];
			foreach ($data as $key => $value) {
				$ad_id_arr[] = $value->id;
				$this->InsertMemberMsg($value->id,1);
			}
			$this->Advisory_model->update(['flag' => '1'],"id IN ('".implode("','", $ad_id_arr)."')");
		}

		// 會員三天沒有評分
		$select_data['fields'] 		= ['advisory.id','advisory.profession_id'];
		$select_data['where'] 		= ['advisory.status' => '1'];
		$select_data['where_str'] 	= "advisory.flag <> 4";
		$select_data['where_str']  .= " AND advisory.profession_id IS NOT NULL";
		$select_data['where_str']  .= " AND advisory.last_reply_time > last_advisory_time";
		$select_data['where_str']  .= " AND advisory.last_reply_time < '" . date('Y-m-d H:i:s', strtotime('-3 DAY')) . "'";
		$data 						= $this->Advisory_model->get_list($select_data);
		if (sizeof($data) > 0) {
			$ad_id_arr = [];
			foreach ($data as $key => $value) {
				$select_data = [];
				$select_data['where'] = ['advisory_detail.advisory_id' => $value->id, 'advisory_detail.member_id' => $value->profession_id];
				if ($this->Advisory_detail_model->get_list_count($select_data)) {
					$ad_id_arr[] = $value->id;
					$this->InsertMemberMsg($value->id,4);
				}
			}
			if (sizeof($ad_id_arr) > 0) {
				$this->Advisory_model->update(['flag' => '4','status' => '2'],"id IN ('".implode("','", $ad_id_arr)."')");
			}
		}

		// 會員两天沒有評分
		$select_data['fields'] 		= ['advisory.id','advisory.profession_id'];
		$select_data['where'] 		= ['advisory.status' => '1'];
		$select_data['where_str'] 	= "advisory.flag <> 3";
		$select_data['where_str']  .= " AND advisory.profession_id IS NOT NULL";
		$select_data['where_str']  .= " AND advisory.last_reply_time > last_advisory_time";
		$select_data['where_str']  .= " AND advisory.last_reply_time < '" . date('Y-m-d H:i:s', strtotime('-2 DAY')) . "'";
		$data 						= $this->Advisory_model->get_list($select_data);
		if (sizeof($data) > 0) {
			$ad_id_arr = [];
			foreach ($data as $key => $value) {
				$select_data = [];
				$select_data['where'] = ['advisory_detail.advisory_id' => $value->id, 'advisory_detail.member_id' => $value->profession_id];
				if ($this->Advisory_detail_model->get_list_count($select_data)) {
					$ad_id_arr[] = $value->id;
					$this->InsertMemberMsg($value->id,3);
				}
			}
			if (sizeof($ad_id_arr) > 0) {
				$this->Advisory_model->update(['flag' => '3'],"id IN ('".implode("','", $ad_id_arr)."')");
			}
		}
		exit;
	}

	public function InsertMemberMsg($advisory_id,$type='') {
		$this->load->model('Member_msg_model');
		$advisory_data = $this->Advisory_model->get_date(['where' => ['advisory.id'=>$advisory_id],'fields' => ['advisory.*','mem.name AS me_name','pro.name AS pr_name']]);
		$insert_data = [
			'key'			=> 'advisory',
			'value'			=> $advisory_id,
			'flag'			=> 0,
			'create_time'	=> date('Y-m-d H:i:s'),
			'update_time'	=> date('Y-m-d H:i:s'),
		];
		switch ($type) {
			case '1':
				$insert_data['msg'] = $advisory_data->me_name . '的諮詢已三天無專員回覆了';
				$insert_data['create_time'] = date('Y-m-d H:i:s', strtotime($advisory_data->update_time . '+3 DAY'));
				$insert_data['update_time'] = date('Y-m-d H:i:s', strtotime($advisory_data->update_time . '+3 DAY'));
				if (empty($advisory_data->profession_id)) { //沒有任何專員認領
					$this->load->model('Pair');
					$pair_arr = $this->Pair->GetMemberPair(['member_id' => $advisory_data->member_id]);
					foreach ($pair_arr as $key => $value) {
						$insert_data_tmp = $insert_data;
						$insert_data_tmp['member_id'] 	= $value->pair_id;
						$this->Member_msg_model->insert($insert_data_tmp);
					}
				} else {
					$insert_data['member_id'] 	= $advisory_data->profession_id;
					$this->Member_msg_model->insert($insert_data);
				}
				break;
			case '2':
				$insert_data['msg'] = $advisory_data->me_name . '的諮詢已六天無專員回覆了。';
				$insert_data['create_time'] = date('Y-m-d H:i:s', strtotime($advisory_data->update_time . '+6 DAY'));
				$insert_data['update_time'] = date('Y-m-d H:i:s', strtotime($advisory_data->update_time . '+6 DAY'));
				$insert_data['member_id'] 	= 0;
				$this->Member_msg_model->insert($insert_data);
				break;
			case '3':
				$insert_data['msg'] = '您有諮詢已超過兩天沒有評分了，趕快前往評分。';
				$insert_data['create_time'] = date('Y-m-d H:i:s', strtotime($advisory_data->update_time . '+2 DAY'));
				$insert_data['update_time'] = date('Y-m-d H:i:s', strtotime($advisory_data->update_time . '+2 DAY'));
				$insert_data['member_id'] 	= $advisory_data->member_id;
				$this->Member_msg_model->insert($insert_data);
				break;
			case '4':
				$insert_data['msg'] = '您有諮詢已超過三天沒有評分了，趕快前往評分。';
				$insert_data['create_time'] = date('Y-m-d H:i:s', strtotime($advisory_data->update_time . '+3 DAY'));
				$insert_data['update_time'] = date('Y-m-d H:i:s', strtotime($advisory_data->update_time . '+3 DAY'));
				$insert_data['member_id'] 	= $advisory_data->member_id;
				$this->Member_msg_model->insert($insert_data);
				break;
			default:
				# code...
				break;
		}
		return true;
	}
}

/* End of file Index.php */
/* Location: ./application/controllers/Index.php */