<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";

class Give_away_point extends MY_Manager {
    public $upload_setting  =   [
        'upload_path'   =>  '/uploads/give_away_point/',
        'allowed_types' =>  ['jpg', 'jpeg', 'png', 'gif'],
        'max_size'       =>  8,
    ];
    private $img_dir = 'uploads/give_away_point/';

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
        $this->load->model('Gift_model','gift');
		$this->load->model('Gift_log_model','gift_log');
        $this->load->model('Give_away_point_model','give_away_point');
        $this->load->model('SetPoint_model','list_point');
    }

    /**
    總管
    **/
	public function Index(){
        $data['set'] = $this->list_point->get(['id'=>1])[0];
        $data['img_width']="280";
        $data['img_height']="282";
		$this->load->view('Backend/Points/give_away_point',$data);
	}

	/**
    列表
    **/
    public function Show(){
        $limit = ['offset'=>NULL,'limit'=>NULL];
        $orderby = ['id asc'];
        $conditions = [];
    	foreach ($this->input->get() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['page','limit'])){
                $conditions[0][] = [
                    'field' => $key,
                    'operator' => 'like',
                    'value' => $value
                ];
    		}
    	}
        if($this->input->get('page')&&$this->input->get('limit')){
            $limit['offset']    =   ($this->input->get('page')-1)*$this->input->get('limit');   
            $limit['limit']     =   $this->input->get('limit');
        }
        $return['page']     =   $this->input->get('page');
        $return['list'] 	=	$this->give_away_point->search(['give_away_point.*'],$conditions,$orderby,$limit);
        $return['total']    =   $this->give_away_point->row_count;
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}


    /**
     * 清單頁-view
     */
    public function Record($member_id=''){
        $data['member_id']=$member_id;
        //載入模版
        $this->load->view('Backend/Gift/record',$data);
    }

    /**
        清單頁列表-api
    **/
    public function Record_Show(){
        $date_start = $this->input->post('date_start') ? $this->input->post('date_start').' 00:00:00' : null;
        $date_end = $this->input->post('date_end') ? $this->input->post('date_end').' 23:59:59' : null;
        $select = ['gift_log.*','member.name','member.username','member.nickname','give_away_member.name as away_name','give_away_member.username as away_username','give_away_member.nickname as away_nickname'];
        $orderby    =   ['gift_log.date_add desc','gift_log.id desc'];
        $conditions = [
            [
                'field' => ['member.name','member.username','member.nickname'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search'),
            ],
            [
                'field' => 'gift_log.date_add',
                'operator' => 'BETWEEN',
                'value' => ['from' => $date_start, 'to' => $date_end,]
            ],
        ];
        $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        $limit['limit']     =   $this->input->post('limit');

        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->gift_log->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->gift_log->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

	/**
    新增
    **/
    public function Add(){
        include 'assets/plugins/slim/server/slim.php';
        try {
            if(!$this->form_validation->run())
                throw new Exception('form_validation_error');
            if($this->input->post('points')<=0)
                throw new Exception('禮物點數不可為0');
            $data   =   $this->input->post();
            $data['update_time']   =   date('Y-m-d H:i:s');

            //slim
            $images = Slim::getImages();
            if($images == false)
                throw new Exception('Slim was not used to upload these images.');

            $image = array_shift($images);
            if (isset($image['output']['data'])) {
                $slimName = $image['output']['name'];
                $slimData = $image['output']['data'];
                $output = Slim::saveFile($slimData, $slimName, $this->img_dir, true);

                $data['img'] = $output['path'];
                unset($data['slim']);
            }

            $result = $this->give_away_point->insert($data);
            if (!$result)
                throw new Exception($this->lang->line('Insert_fail'));

			$return     =   $this->ReturnHandle(true,$this->lang->line('Insert_success'));
		} catch (Exception $e) {
			$error_msg = $e->getMessage();
			$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
    更新
    **/
    public function Edit($id=''){
        include 'assets/plugins/slim/server/slim.php';
        try {
            $original = $this->give_away_point->get($id);
			if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            // if(!$this->form_validation->run())
            //     throw new Exception('form_validation_error');

            $data   =   $this->input->post();
            $data['update_time']   =   date('Y-m-d H:i:s');

            //slim
            $images = Slim::getImages();
            if($images == false)
                throw new Exception('Slim was not used to upload these images.');

            $image = array_shift($images);
            if (isset($image['output']['data'])) {
                $slimName = $image['output']['name'];
                $slimData = $image['output']['data'];
                $slimUnique = ($this->img_dir.$slimName == $original[0]->img)? false:true;
                $output = Slim::saveFile($slimData, $slimName, $this->img_dir, $slimUnique);

                $data['img'] = $output['path'];
                unset($data['slim']);

                if ($slimUnique && file_exists($original[0]->img)){
                    @unlink($original[0]->img);
                }
            }

            $where  =   ['id' =>  $id];
            $result = $this->give_away_point->update($data,$where);
            if (!$result)
                throw new Exception($this->lang->line('Update_Info_fail'));

            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));

		} catch (Exception $e) {
			$error_msg = $e->getMessage();
			$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
    刪除
    **/
    public function Delete($id=''){
        try{
            $original = $this->give_away_point->get(['id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->give_away_point->delete($where);
            if (!$result)
                throw new Exception($this->lang->line('Delete_fail'));

            $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));

            foreach ($original[0] as $key=>$val){
                if (in_array($key,['img']) && !empty($val)){
                    @unlink($val);
                }
            }

        } catch (Exception $e) {
			$error_msg = $e->getMessage();
            $return = $this->ReturnHandle(false,$error_msg);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
    資訊
    **/
    public function Info($id=''){
        include 'assets/plugins/slim/server/slim.php';
        $return     =  $this->give_away_point->get($id,['give_away_point.*']);
        if (empty($return)) redirect('/Backend/BannerWebsite');
        $return = current($return);
        $return->img = site_url($return->img);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
    狀態
    **/
    public function UpdateStatus($id=''){
        $data   = $this->input->post();
        $where  = ['id' =>  1];
        $result = $this->list_point->update($data,$where);
        if ($result){
            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
        }else {
            $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	/**
    變更排序
    **/
    public function UpdateSeq(){
        $data   =   $this->input->post();
        $result     =   $this->give_away_point->UpdateSeq($data['seq']);
        if ($result){
            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_seq_success'));
        }else {
            $return     =   $this->ReturnHandle(false,$this->lang->line('Update_seq_fail'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

    /**
    最後一個seq
    **/
    public function lastSeq(){
        $lastSeq = $this->give_away_point->search(['max(seq) MaxSeq']);
        $return = ((!empty($lastSeq[0]->MaxSeq)))? $lastSeq[0]->MaxSeq:0;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}


}
