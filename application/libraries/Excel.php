<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";				//引用套件
require_once APPPATH . "third_party/PHPExcel/PHPExcel/IOFactory.php";	//匯入用
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-PHPExcel匯出-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*// 
class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}
