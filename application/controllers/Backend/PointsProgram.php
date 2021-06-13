<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";

class PointsProgram extends MY_Manager {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
        $this->load->model('Points_program','points_program');
        $this->load->model('SetPoint_model','list_point');
    }

    /**
    總管
    **/
	public function Index(){
		$data['set'] = $this->list_point->get(['id'=>1])[0];
        //載入模版
        $this->load->view('Backend/Orders/points_program',$data);
	}

	/**
    列表
    **/
    public function Show(){
        $limit = ['offset'=>NULL,'limit'=>NULL];
        $orderby = ['points_program.status desc','points_program.USD ASC'];
        $conditions = [];
    	foreach ($this->input->post() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['page','limit'])){
                $conditions[0][] = [
                    'field' => $key,
                    'operator' => 'like',
                    'value' => $value
                ];
    		}
    	}
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');   
            $limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list'] 	=	$this->points_program->search(['points_program.*','ROUND(ROUND(points_program.USD)*list_points.points*(1+points_program.discount*0.01)) as points','ROUND(ROUND(points_program.USD)*list_points.NTD) as NTD','(points_program.USD-0.01) as USD2'],$conditions,$orderby,$limit);
        /*foreach ($return['list'] as $k => $v) {
            $return['list'][$k]->points_total = round(round($v->USD)*$v->points*(1+$v->discount));
            $return['list'][$k]->NTD = round(round($v->USD)*$v->NTD);
        }*/
        $return['total']    =   $this->points_program->row_count;
    	$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	/**
    新增
    **/
    public function Add(){
        try {

            $data   =   $this->input->post();
            $data['update_time']   =   date('Y-m-d H:i:s');


            $result = $this->points_program->insert($data);
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
        try {
            $original = $this->points_program->get(['points_program.id'=>$id]);
			if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');
            $data   =   $this->input->post();
            $data['update_time']   =   date('Y-m-d H:i:s');


            $where  =   ['id' =>  $id];
            $result = $this->points_program->update($data,$where);
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
            $original = $this->points_program->get(['points_program.id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->points_program->delete($where);
            if (!$result)
                throw new Exception($this->lang->line('Delete_fail'));
            $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));

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
        $return     =  $this->points_program->get(['points_program.id'=>$id],['points_program.*','ROUND(ROUND(points_program.USD)*list_points.points*(1+points_program.discount*0.01)) as points','ROUND(ROUND(points_program.USD)*list_points.NTD) as NTD'])[0];
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
    變更狀態
    **/
    public function UpdateStatus($id){
        $data   = $this->input->post();
        $where  = ['id' =>  $id];
        $result = $this->points_program->update($data,$where);
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
        $result     =   $this->points_program->UpdateSeq($data['seq']);
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
        $lastSeq = $this->points_program->search(['max(seq) MaxSeq']);
        $return = ((!empty($lastSeq[0]->MaxSeq)))? $lastSeq[0]->MaxSeq:0;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}


}
