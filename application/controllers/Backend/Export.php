<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('Export_model');
		$this->ExcelName='';
		for ($i=65; $i<=90; $i++) {
			$this->A[]=chr($i);
		}
		$this->d=[];
	}

	public function ExportAjax() {
		$this->load->model('Export_model');
		$this->Export_model->trans_start();
		$msg = '';
		if ($this->input->post('action')) {
			switch ($this->input->post('action')) {
				case 'redeemcash':
					$this->RecordExcel();
					break;
				default:
					# code...
					break;
			}
		} else {
			$msg = 'error_action';
		}
	}

	/**
     * 建立 Excel
     * @param array  $data['data']  建立的內容
     * @param array  $data['title'] 第一行的中文字
     * @param array  $data['key']   $data['data'] 順序的key值
     */
	public function SaveExcel($data) {
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$ChrStr = ord("A");
		$Rows   = 1;
		for ($i = 0; $i < sizeof($data['title']); $i++) {
			$o=($i<26)?'':$this->A[($i/26)-1];
			$u=$this->A[$i%26];
			$ou =$o.$u;
			$width=(empty($data['setWidth'][$ou]))?'':$data['setWidth'][$ou];
			$objPHPExcel->getActiveSheet()->getColumnDimension($ou)->setWidth($width);
			$objPHPExcel->getActiveSheet()->setCellValue($ou.$Rows, $data['title'][$i]);
		}
		//echo "<pre>";
		foreach ($data['data'] as $key => $value) {
			$ChrStr = ord("A");
			$Rows++;
			$objPHPExcel->getActiveSheet()->getRowDimension($Rows)->setRowHeight(25);
			//print_r($value);
			for ($i = 0; $i < sizeof($data['title']); $i++) {
				$o=($i<26)?'':$this->A[($i/26)-1];
				$u=$this->A[$i%26];
				$ou =$o.$u;
				$val=(empty($data['key'][$i]))?'':$value[$data['key'][$i]];
				if(!empty($data['key'][$i])){
					$objPHPExcel->getActiveSheet()->getStyle($ou.$Rows)->getAlignment()->setWrapText(true);
				}
				$objPHPExcel->getActiveSheet()->getStyle($ou.$Rows)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				if(empty($data['string'][chr($ChrStr)])){
					$objPHPExcel->getActiveSheet()->setCellValue($ou.$Rows, $val);
				}else{
					$objPHPExcel->getActiveSheet(0)->getCell($ou.$Rows)->setValueExplicit($val, PHPExcel_Cell_DataType::TYPE_STRING);
				}

				$ChrStr++;
			}
		}
		//die();
		$objPHPExcel->getActiveSheet()->freezePane('A2');
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$this->ExcelName.'_'.time().'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
		return true;
	}


	//匯出會員目標
	public function RecordExcel() {
		$this->ExcelName = '兌現處理紀錄';
		$this->load->model('Cash_model','cash');
		$where_in['key']='cash_log.id';
		$where_in['val']= explode(",",$this->input->post('id_sn'));
		$select = ['cash_log.*','member.name','member.username','member.nickname','member.bank_name','member.bank_cc','member.bank_username','country.title as country_title','DATE_FORMAT(date_add,"%Y-%m-%d") as create_date'];
        $orderby    =   ['cash_log.date_add asc'];
		$return['data'] = $this->cash->get([], $select, $orderby, [],$where_in);
		$return['data']=$this->object_array($return['data']);


		foreach ($return['data'] as $k => $v) {
			$return['data'][$k]['USD']='$'.abs($v['USD']);
		}
		$return['setWidth']=['A'=>'21','B'=>'36','C'=>'18','D'=>'18','E'=>'40','F'=>'14','G'=>'14','H'=>'14','I'=>'28','J'=>'28','K'=>'27','L'=>'27','M'=>'32'];

		$return['title'] = ['新增日期','會員帳號','會員姓名','會員暱稱','提領金額(USD)','銀行國家','銀行名稱', '銀行戶名', '撥款帳號(分行別＋科目＋帳號)'];
		$return['string']=['A'=>'string','B'=>'string','C'=>'string','D'=>'string','E'=>'string','I'=>'string','J'=>'string','K'=>'string','L'=>'string','M'=>'string'];
		$return['key']   = ['create_date','username','name','nickname','USD','country_title','bank_name','bank_username','bank_cc'];
		return $this->SaveExcel($return);
	}

	//PHP stdClass Object轉array
	function object_array($array) {
		if(is_object($array)) {
			$array = (array)$array;
		}
		if(is_array($array)) {
			foreach($array as $key=>$value) {
				$array[$key] = (array)$value;
			}
		}
		return $array;
	}

}

/* End of file Banner.php */
/* Location: ./application/controllers/admin/Banner.php */
