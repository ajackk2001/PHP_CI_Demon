<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Manager.php";

class Advertising_img extends MY_Manager {
    public $upload_setting  =   [
        'upload_path'   =>  '/uploads/add_img/',
        'allowed_types' =>  ['jpg', 'jpeg', 'png', 'gif'],
        'max_size'       =>  8,
    ];
    private $img_dir = 'uploads/add_img/';

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Advertising_img_model','advertising_img');
    }

    /**
        輪播圖總管
    **/
    public function Index(){
        $data['img_width1']="955";
        $data['img_height1']="638";
        $data['img_width2']="955";
        $data['img_height2']="314";
        $data['img_width3']="472";
        $data['img_height3']="314";
        $this->load->view('Backend/Banner/advertising_img',$data);
    }

    /**
        輪播圖列表
    **/
    public function Show(){
        $limit = ['offset'=>NULL,'limit'=>NULL];
        $orderby = ['update_time desc','id DESC'];
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
        $return['list']     =   $this->advertising_img->search(['advertising_img.*'],$conditions,$orderby,$limit);
        $return['total']    =   $this->advertising_img->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        輪播圖新增
    **/
    public function Add(){
        include 'assets/plugins/slim/server/slim.php';
        try {

            $data   =   $this->input->post();
            $data['update_time']   =   date('Y-m-d H:i:s');

            //slim
            $images = Slim::getImages();
            if($images == false)
                throw new Exception('Slim was not used to upload these images.');
            foreach ($images as $k => $image) {
                //$image = array_shift($images);
                if (isset($image['output']['data'])) {
                    $slimName = $image['output']['name'];
                    $slimData = $image['output']['data'];
                    $output = Slim::saveFile($slimData, $slimName, $this->img_dir, true);

                    $data['img'.($k+1)] = $output['path'];
                }
            }
            unset($data['slim']);

            $result = $this->advertising_img->insert($data);
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
        輪播圖更新
    **/
    public function Edit($id=''){
        include 'assets/plugins/slim/server/slim.php';
        try {
            $original = $this->advertising_img->get($id);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');


            $data   =   $this->input->post();
            $data['update_time']   =   date('Y-m-d H:i:s');

            //slim
            $images = Slim::getImages();
            if($images == false)
                throw new Exception('Slim was not used to upload these images.');
            foreach ($images as $k => $image) {
                if (isset($image['output']['data'])) {
                    if($k==0)$img_old=$original[0]->img1;
                    if($k==1)$img_old=$original[0]->img2;
                    if($k==2)$img_old=$original[0]->img3;
                    if($k==3)$img_old=$original[0]->img4;
                    $slimName = $image['output']['name'];
                    $slimData = $image['output']['data'];
                    $slimUnique = ($this->img_dir.$slimName == $img_old)? false:true;
                    $output = Slim::saveFile($slimData, $slimName, $this->img_dir, $slimUnique);

                    $data['img'.($k+1)] = $output['path'];

                    if ($slimUnique && file_exists($img_old)){
                        @unlink($img_old);
                    }
                }
            }
            unset($data['slim']);

            $where  =   ['id' =>  $id];
            $result = $this->advertising_img->update($data,$where);
            if (!$result)
                throw new Exception($this->lang->line('Update_Info_fail'));

            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));

        } catch (Exception $e) {
            $error_msg = $e->getMessage();
            $return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
            foreach ($catchErrorDel as $exclude_file){
                if (!empty($exclude_file))
                    $this->uploadFileAction('delete',$exclude_file);
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        輪播圖刪除
    **/
    public function Delete($id=''){
        try{
            $original = $this->advertising_img->get(['id'=>$id]);
            if (empty($id) || count($original) == 0)
                throw new Exception('查無資料');

            $where = ['id' => $id];
            $result = $this->advertising_img->delete($where);
            if (!$result)
                throw new Exception($this->lang->line('Delete_fail'));

            $return     =   $this->ReturnHandle(true,$this->lang->line('Delete_success'));

            foreach ($original[0] as $key=>$val){
                if (in_array($key,['img1','img2','img3','img4']) && !empty($val)){
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
        輪播圖資訊
    **/
    public function Info($id=''){
        include 'assets/plugins/slim/server/slim.php';
        $return     =  $this->advertising_img->get($id,['advertising_img.*']);
        if (empty($return)) redirect('/Backend/BannerWebsite');
        $return = current($return);
        $return->img1 = site_url($return->img1);
        $return->img2 = site_url($return->img2);
        $return->img3 = site_url($return->img3);
        $return->img4 = site_url($return->img4);
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        變更狀態
    **/
    public function UpdateStatus($id){
        $data   = $this->input->post();
        $where  = ['id' =>  $id];
        $result = $this->advertising_img->update($data,$where);
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
        $result     =   $this->advertising_img->UpdateSeq($data['seq']);
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
        $lastSeq = $this->advertising_img->search(['max(seq) MaxSeq']);
        $return = ((!empty($lastSeq[0]->MaxSeq)))? $lastSeq[0]->MaxSeq:0;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }


}
