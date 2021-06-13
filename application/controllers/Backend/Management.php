<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once "MY_Manager.php";
class Management extends MY_Manager {

	public $upload_setting	=	[
									'upload_path'	=>	'./uploads/icon',
									'allowed_types'	=>	'ico',
								];
	private $img_dir = 'uploads/icon/';

	public function __construct(){
		parent::__construct();
	}

	public function Setting(){
		$this->load->model('Web_Info');
		$data['info']	=	$this->Web_Info->GetWebInfo(['id','icon','title_ch','title_en','siteurl','email','address','servicetime','phone','fax','keyword','description','ga_code','CONCAT("/",img) img'])[0];
		$this->load->view('Backend/Management/setting',$data);
	}

	public function SettingEdit($id=''){
		$this->load->model('Web_Info');
		$this->load->library('form_validation');
		$this->load->library('upload',$this->upload_setting);
		include 'assets/plugins/slim/server/slim.php';
		if($this->form_validation->run()){
			if (@!is_dir($this->img_dir)) { mkdir($this->img_dir,0777,true); }
			$this->load->library('upload',$this->upload_setting);
			$result	=	true;
			$where 	=	['id'=>$id];
            $data   =   $this->input->post();
        	$files = $_FILES;
			$TotalFile  =   count($_FILES['icon']['name'])-1;
	        if($TotalFile>0){
	            for ($i = 0; $i < $TotalFile; $i ++) {
	                $name = $files ['icon'] ['name'] [$i];
	                $_FILES['icon']['name']       = $name;
	                $_FILES['icon']['type']       = $files ['icon'] ['type'] [$i];
	                $_FILES['icon']['tmp_name']   = $files ['icon'] ['tmp_name'] [$i];
	                $_FILES['icon']['error']      = $files ['icon'] ['error'] [$i];
	                $_FILES['icon']['size']       = $files ['icon'] ['size'] [$i];
	                if($this->upload->do_upload('icon')){
	                    $this->FileData = $this->upload->data();
	                    $data['icon']	=	$this->img_dir.$this->FileData['file_name'];
	                }else{
	                    $result	=	false;
	                }
	            }
	        }
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

			if($result){
				$result     =   $this->Web_Info->update($data,$where);
	            if($result){
	                $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'),base_url('/Backend/Management/Setting'));
	            }else{
	                $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
	            }
			}else{
				$return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
			}
            
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	public function Mail(){
		$this->load->model('Mail_model');
		$data['Mails']	=	$this->Mail_model->GetMail();
		$this->load->view('Backend/Management/mail',$data);
	}

	public function MailEdit($id=''){
		$this->load->model('Mail_model');
		$this->load->library('form_validation');
		if($this->form_validation->run()){
			$where 	=	['id'=>$id];
            $data   =   $this->input->post();
            $result     =   $this->Mail_model->update($data,$where);
            if($result){
                $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'),base_url('/Backend/Management/Mail'));
            }else{
                $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	public function Social(){
		$this->load->model('Web_Social');
		$data['socials']	=	$this->Web_Social->GetWebSocial([],['id >'=>'2']);
		$data['socials'][0]->title='綠界金流';
		$data['socials'][1]->title='萬事達金流';
		// echo "<pre>";
		// print_r($data['socials']);
		// die();
		$this->load->view('Backend/Management/social',$data);
	}

	public function SocialEdit($id=''){
		$this->load->model('Web_Social');
		$this->load->library('form_validation');
		if($this->form_validation->run()){
			$where 	=	['id'=>$id];
            $data   =   $this->input->post();
            $result     =   $this->Web_Social->update($data,$where);
            if($result){
                $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'),base_url('/Backend/Management/Social'));
            }else{
                $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
            }
        }else{
            $return =   $this->ReturnHandle(false,$this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

}
