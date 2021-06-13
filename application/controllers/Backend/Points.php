<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";
class Points  extends MY_Manager {

	public function __construct()
	{
		parent::__construct();
		//載入資料表
		$this->load->model('Points_model','points');
		$this->load->library('form_validation');
	}


	/**
	 * 清單頁-view
	 */
	public function index($page=1){
        $this->load->model('Member_model','Member_model');
        $member_id=htmlspecialchars(strip_tags($this->input->get('member_id')));
        $data['name']='';
        $member=$this->Member_model->get(['id'=>$member_id],['nickname']);
        if(!empty($member))$data['name']=$member[0]->nickname;
		//載入模版
		$this->load->view('Backend/Points/points',$data);
	}

	/**
        清單頁列表-api
    **/
    public function show(){
    	$date_start = $this->input->post('date_start') ? $this->input->post('date_start').' 00:00:00' : null;
        $date_end = $this->input->post('date_end') ? $this->input->post('date_end').' 23:59:59' : null;
        $select = ['points_log.*','member.name','member.username','member.nickname'];
        $orderby    =   ['points_log.date_add desc','points_log.id desc'];
        $conditions = [
        	[
                'field' => ['points_log.type'],
                'operator' => '=',
                'value' => $this->input->post('type'),
            ],
            [
                'field' => ['member.name','member.username','member.nickname'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search'),
            ],
            [
                'field' => ['points_log.payment_sn'],
                'operator' => '=',
                'value' => $this->input->post('search2'),
            ],
            [
                'field' => 'points_log.date_add',
                'operator' => 'BETWEEN',
                'value' => ['from' => $date_start, 'to' => $date_end,]
            ],
        ];
        $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        $limit['limit']     =   $this->input->post('limit');

        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->points->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->points->row_count;
        $this->points->pointsTotal();
        $return['pointsTotal']    =   $this->points->total2;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    //銀行資訊
    public function bank_info($id)
    {
    	$this->load->model('Points_Redeemcash','points_redeemcash');
    	$where  =   [  'member.id'=>$id];
        $return     =  $this->points_redeemcash->get_bank($where,['shop.name as shop_name','member.bank_code','member.branch_code','bankname','branch_name','member.bank_username','member.bank_userid','member.bank_cc','member.bank_img'])[0];
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
     * 新增-view
     */
    public function create(){
        //載入資料表
        $this->load->model('Member_model');
        $data['member_select']     =   $this->Member_model->get([],['member.*'],['id asc'],[]);
        //載入模版
        $this->load->view('Backend/Points/points_add',$data);
    }
    /**
     * 新增-ajax
     */
    public function add(){
        if($this->form_validation->run('Points/add/'.$this->input->post('group_type'))){
            //載入資料表
            $this->load->model('Member_model');
            if($this->input->post('group_type')=='all'){
                $MemberId_array     =   $this->Member_model->GetMember([],['id'],[],['id asc']);
                $uidJson = json_encode($MemberId_array);
                $MemberId_array = array_column(json_decode($uidJson,true), 'id');
            }else if($this->input->post('group_type')=='select'&&$this->input->post('member_select')){
                $MemberId_array     = $this->input->post('member_select');
            }
            if(!empty($MemberId_array)){
                foreach ($MemberId_array as $MemberId) {
                    $result=$this->insert($MemberId);
                }
                if($result){
                    $return =  $this->ReturnHandle(true,$this->lang->line('Insert_success'),base_url('/Backend/Points/'));
                }else{
                    $return =   $this->ReturnHandle(false,'未知的錯誤');
                }
            }else{
                $return =   $this->ReturnHandle(false,'未知的錯誤');
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
     * 新增-資料庫連動
     */
    public function insert($MemberId){
        $prints = $this->input->post('points');
        if($this->input->post('type')=='2')$prints = '-'.$prints;
        $data=
        [
            'member_id'=>$MemberId,
            'points'=>$prints,
            'date_add'=>date('Y-m-d H:i:s'),
            'type'=>$this->input->post('type'),
            'remark'=>$this->input->post('remark'),
        ];
        $result     =   $this->points->insert($data);
        return $result;
    }
}

/* End of file Points.php */
/* Location: ./application/controllers/admin/Points.php */