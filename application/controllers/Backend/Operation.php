<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";

class Operation extends MY_Manager {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
        $this->load->model('Administrator');
	}

    /**
        管理員操作紀錄
    **/
    public function Record(){
        $this->load->view('Backend/Operation/record');
    }

    /**
        管理員操作紀錄列表
    **/
    public function RecordList(){
        $this->load->model('Operation_record');
        $select     = ['operation_record.id','name','username','operation_record.date_add','ip','action'];
        $limit      = ['offset'=>NULL,'limit'=>NULL];
        $orderby    = ['operation_record.date_add desc'];
        $conditions = [];
    	foreach ($this->input->post() as $key => $value) {
    		if(trim($value)!="" && !in_array($key, ['search','page','limit'])){
                $conditions[0][] = [
                    'field' => $key,
                    'operator' => '=',
                    'value' => $value
                ];
    		}
    	}
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');   
            $limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->Operation_record->search($select, $conditions, $orderby, $limit);
        $return['total']    =   $this->Operation_record->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    /**
        刪除管理員操作紀錄
    **/
    public function RecordDelete(){
        $this->load->model('Operation_record');
        $this->Operation_record->record     =   false;
        if($this->form_validation->run()){
            $idArray = $this->input->post('id');
            $idStr = implode(",",$idArray);
            $where = "id in ($idStr)";
            $return['where']=$where;
            $result = $this->Operation_record->delete($where);
            if($result){
                $return =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));
            }else{
                $return =   $this->ReturnHandle(false,$this->lang->line('Delete_fail'));
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        --------------------------------------------------------------------------------------------------------------------
    **/

}
