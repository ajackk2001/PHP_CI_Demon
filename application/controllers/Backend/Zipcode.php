<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'MY_Manager.php';

class Zipcode extends MY_Manager
{
    public function index()
    {
        $this->load->view('Backend/Zipcode/record.php');
    }

    public function import()
    {
        // 移除 road, scope，郵遞區號只擷取 3 碼
        function normalize_data($item)
        {
            $item[0] = substr($item[0], 0, 3);
            unset($item[3]);
            unset($item[4]);
            return $item;
        }

        $data = array_map('str_getcsv', file($_FILES['zipcode']['tmp_name']));
        // 去除 csv 第一行(欄位名稱)
        array_shift($data);
        $data = array_map('normalize_data', $data);
        $data = array_unique($data, SORT_REGULAR);
        // insert 縣市
        foreach (array_unique(array_column($data, 1)) as $city) {
            $this->db->insert('list_city', [
                'country_sn' => 1,
                'title' => $city,
            ]);
        }
        // insert 鄉鎮市區
        foreach ($data as $district) {
            $city_sn = $this->db->select('sn')->where('title', $district[1])->get('list_city')->row()->sn;
            $this->db->insert('list_area', [
                'city_sn' => $city_sn,
                'title' => $district[2],
                'zipcode' => $district[0],
            ]);
        }

        echo '完成';
        header('Refresh:1;url=/Backend/Zipcode');
    }
}
