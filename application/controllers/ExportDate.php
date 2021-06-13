<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportDate extends MY_Controller {
	private $ExcelName = '';
	public function __construct(){
		parent::__construct();
	}

	public function Message($to = 'World')
	{
		echo "Hello {$to}!".PHP_EOL;
	}

	public function Excel()	{
		$this->load->library('Excel');
		$this->load->model('Export_model');

		$SelectData = [
			'fields' => ['export.*','ext.name AS type_name'],
			'where'  => ['export.status' => '0'],
		];
		$ExportList = $this->Export_model->get_list($SelectData);

		if (sizeof($ExportList) > 0) {
			foreach ($ExportList as $key => $value) {
				$Status = false;
				//$this->ExcelName = $value->name; //preg_replace('/\s(?=)/', '', $value->name);
				$this->ExcelName = "Excel_{$value->id}";
				switch ($value->type) {
					case '1':
						$Status = $this->AdvisoryExcel($value);
						break;
					default:
						# code...
						break;
				}
				$this->Export_model->update(['status' => '1'],['id' => $value->id]);
			}
		} else {
			echo "Not Fount!!";
		}
		return true;
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
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($ChrStr))->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->setCellValue(chr($ChrStr).$Rows, $data['title'][$i]);
			$ChrStr++;
		}
		foreach ($data['data'] as $key => $value) {
			$ChrStr = ord("A");
			$Rows++;
			for ($i = 0; $i < sizeof($data['title']); $i++) {
				$objPHPExcel->getActiveSheet()->setCellValue(chr($ChrStr).$Rows, $value->{$data['key'][$i]});
				$ChrStr++;
			}
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="{$this->ExcelName}.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
		return true;
	}

	public function AdvisoryExcel($data) {
		$this->load->model('Advisory_model');

		$Param 		= json_decode($data->param);
		$SelectData = [];
		$SelectData['fields'] 	 = ['advisory.title','advisory.score','advisory.create_time AS cdate','advisory.update_time AS udate','pro.name as pr_name','mem.name as me_name'];
		$SelectData['order']   	 = ['DESC' => 'advisory.update_time'];
		$SelectData['where']   	 = ['advisory.status' => 3];
		$SelectData['where_str'] = '1=1';
		if (!empty($Param->search_text)) {
			$SelectData['where_str'] .= " AND advisory.title LIKE '%".$Param->search_text."%' OR mem.name LIKE '".$Param->search_text."' OR pro.name LIKE '".$Param->search_text."'";
		}
		if (!empty($Param->date_start) && !empty($Param->date_end)) {
			$SelectData['where_str'] .= " AND advisory.update_time BETWEEN '".$Param->date_start." 00:00:00' AND '".$Param->date_end." 23:59:59'";
		}
		if (!empty($Param->score)) {
			$SelectData['where']['advisory.score'] = $Param->score;
		}
		$return['data']  = $this->Advisory_model->get_list($SelectData);

		//資料處理
		foreach ($return['data'] as $key => $value) {
			$return['data'][$key]->date 	= date('Y-m-d H:i', strtotime($value->cdate));
			$return['data'][$key]->udate 	= date('Y-m-d H:i', strtotime($value->udate));
		}

		$return['title'] = ['新增日期', '個案暱稱', '主題',  '專員暱稱', '結案時間', '評分'];
		$return['key']   = ['date',     'me_name',  'title', 'pr_name',  'udate',    'score'];

		return $this->SaveExcel($return);
	}
}