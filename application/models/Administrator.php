<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends My_Model{
    const PASS_KEY = '70xk5v7nbZkQVrEGOECD';
    public $table_name	=	'administrator';
    public $title       =   '管理員';
    public function __construct(){
        parent::__construct();
    }

    public function RecordHandle($data){
        $descript =   '';
        $statusStr = '';
        $where = [];
        if(!is_array($data)){
            $where = ['id'=>$data];
        }else if (isset($data->id)){
            $where = ['id'=>$data->id];
            $statusStr = (isset($data->status))? $this->RecordStr('status',$data->status):'';
        }else if (isset($data[0]->id)){
            $where = ['id'=>$data[0]->id];
            $statusStr = (isset($data[0]->status))? $this->RecordStr('status',$data[0]->status):'';
        }
        
        $result = (!empty($where))? $this->db->select('username')->from($this->table_name)->where($where)->get()->row():'';
        $descript = (!empty($result))? "-".$result->username.$statusStr:'';
        
        return $descript;
    }
        
    private function RecordStr($field,$value){
        switch ($field) {
            case 'status':
                return ($value==0)? "->停用":"->啟用";
                break;
            default:
                return '';
                break;
        }
    }


    public function LoginCheck($account,$password){
        $where = [
            'username'  => $account,
            'password'  => MD5($password.self::PASS_KEY),
            'status'    => '1'
        ];
        return $this->db->select('id,username,permission_type,name,menu_permission')->from($this->table_name)->where($where)->get()->first_row();
    }
    public function UpdateLoginData($id){
        $str = "UPDATE {$this->table_name} SET login_count = login_count+1,last_login = NOW() WHERE id = '{$id}'";
        $this->db->query($str);
    }
    public function PermissionCheck($path){
        //$str = "SELECT `menu_id`,`title`,`url`,`menu_parent_id`,`type` FROM `admin_menu` WHERE '{$path}' REGEXP url AND `status` = 1 order by menu_id desc limit 1";
        $str = "SELECT `menu_id`,`title`,`url`,`menu_parent_id`,`type` FROM `admin_menu` WHERE url = '{$path}' AND `status` = 1 order by menu_id desc limit 1";
        $query = $this->db->query($str);
        if($query->num_rows()==0){
            $str = "SELECT `menu_id`,`title`,`url`,`menu_parent_id`,`type` FROM `admin_menu` WHERE '{$path}' REGEXP url AND `status` = 1 order by menu_id desc limit 1";
            $query = $this->db->query($str);
        }
        // echo $this->db->last_query();
        // die();
        return ($query->num_rows() > 0)?$query->row():null;
    }

    public function GetAdminList($where,$fields=['*'],$orwhere=[],$orderby=[],$limit=['limit'=>NULL,'offset'=>NULL]){
        return $this->db->select(implode(',',$fields))->from($this->table_name)->where($where)->order_by(implode(',',$orderby))->limit($limit['limit'],$limit['offset'])->get()->result();
    }

    public function GetPermiision($where){
        return $this->db->select('menu_permission')->where($where)->get($this->table_name)->result();
    }

    public function GetMenuList(){
        return $this->db->select('menu_id,title,menu_parent_id,url,icon_image,seq')->where('type',0)->where('status',1)->order_by('menu_parent_id','ASC')->order_by('seq','asc')->get('admin_menu')->result();
    }
    public function GetFirstPath(){
        return $this->db->select('menu_id,url')->where('type',0)->where('status',1)->where('url <>','')->get('admin_menu')->result();
    }
    public function ChangePassword($id,$pw){
        $password = MD5($pw.self::PASS_KEY);
        $str = "UPDATE {$this->table_name} SET password = '{$password}' WHERE id = '{$id}'";
        return $this->db->query($str);
    }
}
