<?php

class MY_Model extends CI_Model {
    public $insertId;
    public $action;
    public $record  =   false;
    public $title;
    public $trans_action    =   [
                                    'INSERT'    =>  '新增',
                                    'UPDATA'    =>  '編輯',
                                    'DELETE'    =>  '刪除',
                                    'LOGIN'     =>  '登入',
                                ];
    public $row_count;

    function __construct()
    {
        parent::__construct();
        if(preg_match("/Backend/",uri_string())){
            $this->record   =   true;
            if(!$this->title){
                $this->title    =   $this->PermissionCheck(uri_string());
            }
        }
        if(in_array(uri_string(),['Backend/Login'])){
            $this->action   =   'LOGIN';
        }
    }

    public function insert($data='') {
        $result =   $this->db->insert($this->table_name, $data);
        $this->insertId=$this->insert_id();
        if(!$this->action){
            $this->action   = 'INSERT';
        }
        $data['id']     = $this->db->insert_id();
        $this->insert_id      = $this->db->insert_id();
        $this->insert_record($data['id']);
        //$this->insert_audittrail($data);
        return $result;
    }
    public function insert_record($id,$data2=[]){
        if(isset($this->title[0]->title))$str=str_replace($this->trans_action[$this->action] , '' ,$this->title[0]->title);
        if($this->record){
            $data   =   [
                            'session_id'    =>  $this->session->userdata('session_id'),
                            'user_id'       =>  $this->session->userdata('Manager')->id,
                            'user_name'     =>  $this->session->userdata('Manager')->username,
                            'action_type'   =>  $this->action,
                            'date_add'      =>  date('Y-m-d H:i:s'),
                            'ip'            =>  $this->input->ip_address(),
                            'action'        =>  '['.$this->trans_action[$this->action].']'.((isset($this->title[0]->title))?$str:$this->title).$this->RecordHandle($id,$data2),
                        ];
            $this->db->insert('operation_record',$data);
        }
    }

    public function replace($where='', $data='') {
        return $this->db->replace($this->table_name, $data);
    }

    /**
      * 需要 join 時，繼承的 class 的 funtion 先 $this->db->join()，再呼叫 parent::get($conditions)
      *
      * @param array|mixed $id 若為 array，當作 where 條件
      *                        若為其他型態，以 id 篩選 ( where `id` = $id )
     */
    public function get($id = null, array $select = ['*'], array $order_by = [], array $limit = [], array $where_in = [])
    {
        if(!empty($id)){
            if(is_array($id)){
                $this->db->where($where = $id);
            }
            else{
                $this->db->where('id', $id);
            }
        }

        if(!empty($where_in['key'])){
            $this->db->where_in($where_in['key'],$where_in['val']);
        }

        $this->db->select(implode(', ', $select));

        $this->row_count = $this->db->count_all_results($this->table_name, false);

        if($order_by !== []){
            $this->db->order_by(implode(',', $order_by));
        }

        if(isset($limit['limit']) && !empty($limit['limit'])){
            $this->db->limit($limit['limit']);
        }

        if(isset($limit['offset']) && !empty($limit['offset'])){
            $this->db->offset($limit['offset']);
        }

        return $this->db->get()->result();
    }

    public function update($data='',$where=array()) {
        $data2= $data;
        @list($key) = each($data);
        $r=$this->db->select($key)->where($where)->get($this->table_name)->result();
        $data2=$r[0];
        $result =   $this->db->update($this->table_name, $data, $where);
        //echo $this->db->last_query();
        if(!$this->action){
            $this->action = 'UPDATA';
        }
        $data = $this->get_updata_data($where);
        $this->insert_record($data,$data2);
        return $result;
    }
    /**
     * 刪除動作
    */
    public function delete($where=array()) {
        // $result = $this->db->delete($this->table_name, $where);
        $this->action = 'DELETE';
        $data = $this->get_updata_data($where);
        $this->insert_record($data);
        $result =   $this->db->delete($this->table_name, $where);
        return $result;
    }

    public function trans_start(){
        $this->db->trans_start();
    }

    public function trans_complete(){
        $this->db->trans_complete();
    }

    public function trans_rollback(){
        $this->db->trans_rollback();
    }

    public function insert_id(){
        return $this->db->insert_id();
    }

    public function PermissionCheck($path){
        $str = "SELECT `menu_id`,`title`,`url`,`menu_parent_id`,`type` FROM `admin_menu` WHERE '{$path}' REGEXP url AND `status` = 1";
        $query = $this->db->query($str);
        return $query->result();
    }

    public function get_updata_data($where){
        $this->db->from($this->table_name)->where($where);
        return $this->db->get()->result();
    }

    /**
     * 更新排序
     * 基本上不會失敗，失敗的影響也不大，因此不檢查
     */
    public function updateSeq($data)
    {
        foreach ($data as $id => $seq) {
            $this->db->update($this->table_name, ['seq' => $seq], ['id' => $id]);
        }
    }

    /**
     * 多條件搜尋
     * array 第一層條件做 OR
     * array 第二層條件做 AND
     *
     * @param array $where
     * json 範例
     * [
     *     [
     *         {
     *             "field": "username",
     *             "operator": "like",
     *             "value": ["Bob", "John"]
     *         },
     *         {
     *             "field": "phone",
     *             "operator": "!=",
     *             "value": "0933877208"
     *         },
     *         {
     *             "field": "sex",
     *             "operator": "=",
     *             "value": "female"
     *         }
     *     ],
     *     [
     *         {
     *             "field": "username",
     *             "operator": "!=",
     *             "value": "Alex"
     *         },
     *         {
     *             "field": "sex",
     *             "operator": "=",
     *             "value": "female"
     *         }
     *     ]
     * ]
     *
     * "field" 欄位名稱; 可為 string 或 numeric array; 為 numeric array 時，"value" 一次比較多個欄位
     * "operator" SQL 比較運算子 (Comparison Operators)
     * "operator" 為 "IN" 時，"value" 必須為 numeric array
     * "operator" 為 "BETWEEN" 時， "value" 必須為 associative array，並有 keys: "from", "to"
     * "value" 可為 string 或 array； 為 numeric array 時，"value" 條件為 OR
     * "skip_empty" 為 true ，內容等同於空值時跳過不做比較，就等於沒有設定該篩選條件，預設為 true
     *
     * 需要 join 時，繼承的 class 的 funtion 先 $this->db->join()，再呼叫 parent::search($conditions)
     *
     * @return array
     *
     */
    public function search(array $select=['*'], array $conditions=[], array $order_by=[], array $limit=[],array $group=[])
    {
        $this->db->select(is_array($select) ? implode(',', $select) : $select);

        // 允許不輸入 conditions，等同於 SQL 不用 WHERE
        if(!empty($conditions)){
            foreach ($conditions as $grouped_where_or) {
                $this->db->or_group_start();
                $this->db->where('1 = 1');  // 極重要！ 避免 or_group_start(), group_end() 裏面沒有東西

                foreach ($grouped_where_or as $grouped_where_and) {

                    // 排除空字串, null, 或空 array
                    if(!isset($grouped_where_and['skip_empty']) || isset($grouped_where_and['skip_empty']) && $grouped_where_and['skip_empty'] === true){
                        if(!isset($grouped_where_and['value']) || ($grouped_where_and['value'] !== "0" && $grouped_where_and['value'] !== 0 && empty($grouped_where_and['value'])))
                        continue;
                    }

                    // 將 "field" 包裝成 array
                    if(!is_array($grouped_where_and['field']))
                        $grouped_where_and['field'] = [$grouped_where_and['field']];

                    // 將 "value" 包裝成 array
                    if(!is_array($grouped_where_and['value']))
                        $grouped_where_and['value'] = [$grouped_where_and['value']];

                    // LIKE
                    if(strtoupper($grouped_where_and['operator']) === 'LIKE') {
                        $this->db->group_start();
                        foreach($grouped_where_and['field'] as $field){
                            foreach ($grouped_where_and['value'] as $value) {
                                $this->db->or_like($field, $value, 'both');
                            }
                        }
                        $this->db->group_end();
                        continue;
                    }

                    // IN
                    if(strtoupper($grouped_where_and['operator']) === 'IN') {
                        $this->db->group_start();
                        foreach($grouped_where_and['field'] as $field){
                            $this->db->or_where_in($field, $grouped_where_and['value']);
                        }
                        $this->db->group_end();
                        continue;
                    }

                    // BETWEEN
                    if((strtoupper($grouped_where_and['operator']) === 'BETWEEN')){
                        if($grouped_where_and['value']['from'])
                            $this->db->where($grouped_where_and['field'][0].' >= ', $grouped_where_and['value']['from']);
                        if($grouped_where_and['value']['to'])
                            $this->db->where($grouped_where_and['field'][0].' <= ', $grouped_where_and['value']['to']);

                        continue;
                    }

                    // >, >=, <, ...
                    $this->db->group_start();
                    foreach($grouped_where_and['field'] as $field){
                        foreach ($grouped_where_and['value'] as $value) {
                            $this->db->or_where($field.' '.$grouped_where_and['operator'], $value);
                        }
                    }
                    $this->db->group_end();
                }

                $this->db->group_end();
            }
        }
        if(!empty($group)){
            $this->db->group_by($group);
        }
        $this->row_count = $this->db->count_all_results($this->table_name, false);

        if($order_by !== []){
            $this->db->order_by(implode(',', $order_by));
        }

        if(isset($limit['limit']) && !empty($limit['limit'])){
            $this->db->limit($limit['limit']);
        }

        if(isset($limit['offset']) && !empty($limit['offset'])){
            $this->db->offset($limit['offset']);
        }

        return $this->db->get()->result();
    }
}