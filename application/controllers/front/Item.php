<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  "MY_Front.php";
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
//-*-*-*-前台共用-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-＊//
class Item extends MY_Front {
	private $img_dir = 'uploads/item/image/';
	//聯絡我們
	public function __construct(){
		parent::__construct();
		$this->load->model('Item_model','item');
		$this->load->model('Item_img_model','item_img');
        $this->load->model('Cash_model','cash');
	}
	//上傳影片
	public function upload_video(){
		try {
			if(!$this->session->userdata('user')['id'])
				throw new Exception('停留此頁面時間過久，請重新登入');
			if(!file_exists($_FILES['file']['tmp_name']))
				throw new Exception('上傳影片失敗');
			if($_FILES['file']['type']!="video/mp4")
				throw new Exception('請上傳mp4格式的影片');
			$mb = $this->getFilesize($_FILES['file']['size']);
			$img_folder = './'.$_POST['save_path'].$this->session->userdata('user')['id'].'/';
			// 確保上傳資料夾存在
        	@mkdir($img_folder, 0777, true);
			//取得圖檔原來的名稱
			$file_name = $_FILES['file']['name'];

			if(move_uploaded_file($_FILES['file']['tmp_name'],$img_folder . $file_name)){
				$return     =   $this->ReturnHandle(true,'上傳影片成功');
				$return['file_name']=$img_folder . $file_name;
				//$return['file_path']=$_POST['save_path'].'/'.$this->session->userdata('user')['id'].'/' . $file_name;
			}else{
				throw new Exception('影片檔案搬移失敗');
			}
		}catch (Exception $e) {
			$error_msg = $e->getMessage();
			$return = ($error_msg == 'form_validation_error')? $this->ReturnHandle(false,$this->form_validation->error_array()):$this->ReturnHandle(false,$error_msg);
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	//fileuploader-ajax動線
    public function fileuploader_image_upload(){
    	if(!$this->session->userdata('user')['id']){
    		$return = $this->ReturnHandle(false, '停留此頁面時間過久，請重新登入');
	    	goto end;
	    }
    	$img_dir=$this->img_dir.'tmp/'.$this->session->userdata('user')['id'].'/';
        // 確保上傳資料夾存在
        @mkdir($img_dir, 0777, true);
        include 'assets/plugins/fileuploader2/src/class.fileuploader.php';
        // 上傳圖片
        $fileUploader = new MyFileUploader('files', array(
            'fileMaxSize' => 15,
            'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
            'required' => true,
            'uploadDir' => $img_dir,
            'title' => time(),
            'replace' => false,
        ));
        $upload = $fileUploader->upload();

        if ($upload['isSuccess']) {
            $img = $upload['files'][0];
            $return = $this->ReturnHandle(true, '/'.$img['file']);
            // 製作縮圖
            // 縮圖檔名: 原檔名後綴 "_thumbnail"
            // $img = $upload['files'][0];
            // $thumbnail = $this->img_dir.basename($img['name'], '.'.$img['extension']).'_thumbnail.'.$img['extension'];
            // if (MyFileUploader::resize($img['file'], 200, 200, $thumbnail, null, 100)) {
            //     $return = $this->ReturnHandle(true, '/'.$img['file']);
            // } else {
            //     $return = $this->ReturnHandle(false, $this->lang->line('Update_Info_fail'));
            // }
        } else {
            $return = $this->ReturnHandle(false, '上傳圖檔失敗');
        }
        end:
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    //fileuploader-ajax動線
    public function fileuploader_image_upload2(){
    	if(!$this->session->userdata('user')['id']){
    		$return = $this->ReturnHandle(false, '停留此頁面時間過久，請重新登入');
    		goto end;
    	}

    	$img_dir=$this->img_dir.'tmp/'.$this->session->userdata('user')['id'].'/';
        // 確保上傳資料夾存在
        @mkdir($img_dir, 0777, true);
        include 'assets/plugins/fileuploader2/src/class.fileuploader.php';
        // 上傳圖片
        $fileUploader = new MyFileUploader('files2', array(
            'fileMaxSize' => 15,
            'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
            'required' => true,
            'uploadDir' => $img_dir,
            'title' => time(),
            'replace' => false,
        ));
        $upload = $fileUploader->upload();

        if ($upload['isSuccess']) {
            $img = $upload['files'][0];
            $return = $this->ReturnHandle(true, '/'.$img['file']);
            // 製作縮圖
            // 縮圖檔名: 原檔名後綴 "_thumbnail"
            // $img = $upload['files'][0];
            // $thumbnail = $this->img_dir.basename($img['name'], '.'.$img['extension']).'_thumbnail.'.$img['extension'];
            // if (MyFileUploader::resize($img['file'], 200, 200, $thumbnail, null, 100)) {
            //     $return = $this->ReturnHandle(true, '/'.$img['file']);
            // } else {
            //     $return = $this->ReturnHandle(false, $this->lang->line('Update_Info_fail'));
            // }
        } else {
            $return = $this->ReturnHandle(false, '上傳圖檔失敗');
        }
        end:
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function add(){
    	$data = $this->input->post();
        try {
        	if(!$this->session->userdata('user')['id'])
				throw new Exception('停留此頁面時間過久，請重新登入');
            $this->db->trans_begin();

            $data['create_time'] = date('Y-m-d H:i:s');
            $data['update_time'] = date('Y-m-d H:i:s');
            $data['member_id'] = $this->session->userdata('user')['id'];
            if(!empty($data['option']))$data['option']=json_encode($data['option']);
            $unset  =   ['fileuploader-list-files','fileuploader_images','fileuploader_editor','fileuploader_uploaded_images','fileuploader-list-files2','fileuploader_images2','fileuploader_editor2','fileuploader_uploaded_images2','slim','point'];
            foreach($unset as $v){
                unset($data[$v]);
            }
            $images_arr = $this->input->post('slim');
            $img_data = json_decode($images_arr,true);
            if ($img_data && sizeof($img_data) > 0) {
                preg_match('/^(data:\s*image\/(\w+);base64,)/', $img_data['output']['image'], $result);
                $image_type = $result[2];
                if (in_array($image_type,array('pjpeg','jpeg','jpg','gif','bmp','png'))) {
                    if (in_array($image_type, ['pjpeg','jpeg','jpg'])) $image_type = 'jpg';
                    $image_name = "Item".time().".{$image_type}";
                    $image_path ='./uploads/item/image/';
                    if(!is_dir($image_path)) mkdir($image_path);
                    $image_src  = "{$image_path}/{$image_name}";
                    $image      = str_replace($result[1], '', $img_data['output']['image']);
                    $image      = str_replace(' ', '+', $image);
                    if (file_put_contents($image_src, base64_decode($image))) {
                        $data['img'] = $image_name;
                    }
                }
            }
            if($data['video1']){
            	$data['video1']=$image_name = "Video_1".time().".mp4";
            	$data['video2']=$image_name = "Video_2".time().".mp4";
            }
            $m1 = count(json_decode($this->input->post('fileuploader_images')));
            $m2 = count(json_decode($this->input->post('fileuploader_images2')));
            $data['img_num'] = $m1+$m2;
            $this->item->insert($data);
            $id = $this->item->insert_id;
            if($data['video1']){
            	$img_folder='./uploads/videos/'.$this->session->userdata('user')['id'].'/'.$id.'/';
            	@mkdir($img_folder, 0777, true);
            	if(file_exists($this->input->post('video1')))
            		rename($this->input->post('video1'),$img_folder . $data['video1']);

				if(file_exists($this->input->post('video2')))
            		rename($this->input->post('video2'),$img_folder . $data['video2']);
            }
            $this->save_images($id);
            $this->save_images2($id);

            if ($this->db->trans_status() === FALSE)
                throw new Exception($this->lang->line('Delete_fail'));

            $this->db->trans_commit();
            $return     =  $this->ReturnHandle(true ,'成功送出','/member/productShelf');

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $error_msg = $e->getMessage();
            $return = $this->ReturnHandle(false,$error_msg);
        }
        end:
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function edit($id=''){
        $data = $this->input->post();
        try {
            if (!$id)
                throw new Exception('資料庫無資料');
            if(!$this->session->userdata('user')['id'])
                throw new Exception('停留此頁面時間過久，請重新登入');

            $item     =  $this->item->get(['item.id'=>$id],['item.*']);
            if (empty($item))
                throw new Exception('資料庫無資料');
            $this->db->trans_begin();

            $data['review_status'] = 0;
            $data['status'] = 0;
            $data['update_time'] = date('Y-m-d H:i:s');
            $data['member_id'] = $this->session->userdata('user')['id'];
            if(!empty($data['option']))$data['option']=json_encode($data['option']);
            $unset  =   ['fileuploader-list-files','fileuploader_images','fileuploader_editor','fileuploader_uploaded_images','fileuploader-list-files2','fileuploader_images2','fileuploader_editor2','fileuploader_uploaded_images2','slim','point'];
            foreach($unset as $v){
                unset($data[$v]);
            }
            $images_arr = $this->input->post('slim');
            $img_data = json_decode($images_arr,true);
            if ($img_data && sizeof($img_data) > 0) {
                preg_match('/^(data:\s*image\/(\w+);base64,)/', $img_data['output']['image'], $result);
                $image_type = $result[2];
                if (in_array($image_type,array('pjpeg','jpeg','jpg','gif','bmp','png'))) {
                    if (in_array($image_type, ['pjpeg','jpeg','jpg'])) $image_type = 'jpg';
                    $image_name = "Item".time().".{$image_type}";
                    $image_path ='./uploads/item/image/';
                    if(!is_dir($image_path)) mkdir($image_path);
                    $image_src  = "{$image_path}/{$image_name}";
                    $image      = str_replace($result[1], '', $img_data['output']['image']);
                    $image      = str_replace(' ', '+', $image);
                    if (file_put_contents($image_src, base64_decode($image))) {
                        $data['img'] = $image_name;
                    }
                }
            }
            if(!empty($data['img'])){
                $r      =  $item[0];
                if(file_exists($image_path.'/'.$r->img)){
                    unlink($image_path.'/'.$r->img);//將檔案刪除
                }
            }
            if($data['video1']&&$data['video1']!=$item[0]->video1){
                $data['video1']=$image_name = "Video_1".time().".mp4";
            }
            if($data['video2']&&$data['video2']!=$item[0]->video2){
                $data['video2']=$image_name = "Video_2".time().".mp4";
            }
            $this->item->update($data,['id'=>$id]);
            $img_folder='./uploads/videos/'.$this->session->userdata('user')['id'].'/'.$id.'/';
             @mkdir($img_folder, 0777, true);
            if($data['video1']&&$data['video1']!=$item[0]->video1){
                if(file_exists($this->input->post('video1')))
                    rename($this->input->post('video1'),$img_folder . $data['video1']);

                if($item[0]->video1&&file_exists($img_folder.$item[0]->video1)){
                    unlink($img_folder.$item[0]->video1);//將檔案刪除
                }
            }
            if($data['video2']&&$data['video2']!=$item[0]->video2){
                if(file_exists($this->input->post('video2')))
                    rename($this->input->post('video2'),$img_folder . $data['video2']);
                if($item[0]->video2&&file_exists($img_folder.$item[0]->video2)){
                    unlink($img_folder.$item[0]->video2);//將檔案刪除
                }
            }

            if($item[0]->video1&&!$data['video1']){
                if($item[0]->video2&&file_exists($img_folder.$item[0]->video2)){
                    unlink($img_folder.$item[0]->video2);//將檔案刪除
                }
                if($item[0]->video1&&file_exists($img_folder.$item[0]->video1)){
                    unlink($img_folder.$item[0]->video1);//將檔案刪除
                }
            }


            $this->edit_images1($id);
            $this->edit_images2($id);

            if ($this->db->trans_status() === FALSE)
                throw new Exception($this->lang->line('Delete_fail'));

            $this->db->trans_commit();
            $return     =  $this->ReturnHandle(true ,'成功送出','/member/productShelf');

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $error_msg = $e->getMessage();
            $return = $this->ReturnHandle(false,$error_msg);
        }

        //die();
        end:
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    public function save_images($id){
        $m=0;
        // 確定需要的圖片
        $fileuploader_images = json_decode($this->input->post('fileuploader_images'));
        // 去掉路徑開頭 '/'
        array_walk($fileuploader_images, function (&$img) {
            $img = substr($img, 1, strlen($img));
        });

        include_once 'assets/plugins/fileuploader2/src/class.fileuploader.php';
        $editor = json_decode($this->input->post('fileuploader_editor'), true);
        foreach ($fileuploader_images as $i => $img) {
            // 更新排序
            //$this->update_image(['seq' => $i], ['img' => $img]);
            // 裁圖
            $image_path = '/uploads/item/image/'.$id;
            if(!is_dir('.'.$image_path)) mkdir('.'.$image_path);
            MyFileUploader::resize($img, null, null, $img, (isset($editor[$i]['crop']) ? $editor[$i]['crop'] : null), 100, (isset($editor[$i]['rotation']) ? $editor[$i]['rotation'] : null));
            $img_info = pathinfo($img);
            $img_name=explode("/",$img);
            $image_path=$image_path.'/'.end($img_name);
            rename('./'.$img,'.'.$image_path);
            $this->item_img->insert([
                'item_id'     => $id,
                'img'         =>  $image_path,
                'update_time' =>  date('Y-m-d H:i:s'),
                'seq'         =>  $i+1,
                'type'        =>  1,
            ]);
        }
    }
    public function save_images2($id){
        // 確定需要的圖片
        $fileuploader_images = json_decode($this->input->post('fileuploader_images2'));
        // 去掉路徑開頭 '/'
        array_walk($fileuploader_images, function (&$img) {
            $img = substr($img, 1, strlen($img));
        });

        include_once 'assets/plugins/fileuploader2/src/class.fileuploader.php';
        $editor = json_decode($this->input->post('fileuploader_editor2'), true);
        foreach ($fileuploader_images as $i => $img) {
            // 更新排序
            //$this->update_image(['seq' => $i], ['img' => $img]);
            // 裁圖
            $image_path = '/uploads/item/image/'.$id;
            if(!is_dir('.'.$image_path)) mkdir('.'.$image_path);
            MyFileUploader::resize($img, null, null, $img, (isset($editor[$i]['crop']) ? $editor[$i]['crop'] : null), 100, (isset($editor[$i]['rotation']) ? $editor[$i]['rotation'] : null));
            $img_info = pathinfo($img);
            $img_name=explode("/",$img);
            $image_path=$image_path.'/'.end($img_name);
            // echo $image_path;
            // die();
            rename('./'.$img,'.'.$image_path);
            $this->item_img->insert([
                'item_id'     => $id,
                'img'         =>  $image_path,
                'update_time' =>  date('Y-m-d H:i:s'),
                'seq'         =>  $i+1,
                'type'        =>  2,
            ]);
        }
    }
	public function getFilesize($num){
		$p = 0;
		$format='bytes';
		if($num>0 && $num<1024){
		$p = 0;
		return number_format($num).' '.$format;
		}
		if($num>=1024 && $num<pow(1024, 2)){
		$p = 1;
		$format = 'KB';
		}
		if ($num>=pow(1024, 2) && $num<pow(1024, 3)) {
			$p = 2;
			$format = 'MB';
		}
		$num /= pow(1024, $p);
		return number_format($num, 3);
	}


    public function edit_images1($id){
        $im = $this->item_img->get(['item_id'=>$id,'type'=>1], ['img'], ['seq']);
        // 確定需要的圖片
        $fileuploader_images = json_decode($this->input->post('fileuploader_images'));
        foreach ($im as $key => $v) {
            if(!in_array($v->img, $fileuploader_images)){
                @unlink('.'.$v->img);
            }
        }
         // 去掉路徑開頭 '/'
        array_walk($fileuploader_images, function (&$img) {
            $img = substr($img, 1, strlen($img));
        });
        $fileuploader_uploaded_images = json_decode($this->input->post('fileuploader_uploaded_images'));
         // 去掉路徑開頭 '/'
        array_walk($fileuploader_uploaded_images, function (&$img) {
            $img = substr($img, 1, strlen($img));
        });


        $editor = json_decode($this->input->post('fileuploader_editor'), true);

        $this->item_img->delete(['item_id' => $id,'type'=>1]);
        include_once 'assets/plugins/fileuploader2/src/class.fileuploader.php';
        foreach ($fileuploader_images as $i => $img) {
           if(in_array($img, $fileuploader_uploaded_images)){
                $image_path = '/uploads/item/image/'.$id;
                if(!is_dir('.'.$image_path)) mkdir('.'.$image_path);
                MyFileUploader::resize($img, null, null, $img, (isset($editor[$i]['crop']) ? $editor[$i]['crop'] : null), 100, (isset($editor[$i]['rotation']) ? $editor[$i]['rotation'] : null));
                $img_info = pathinfo($img);
                $img_name=explode("/",$img);
                $image_path=$image_path.'/'.end($img_name);
                rename('./'.$img,'.'.$image_path);
           }else{
                $image_path = '/'.$img;
           }

            $this->item_img->insert([
                'item_id'       =>  $id,
                'img'           =>  $image_path,
                'update_time'   =>  date('Y-m-d H:i:s'),
                'seq'           =>  $i+1,
                'type'          =>  1,
            ]);
        }
    }

    public function edit_images2($id){
        $im = $this->item_img->get(['item_id'=>$id,'type'=>2], ['img'], ['seq']);
        // 確定需要的圖片
        $fileuploader_images = json_decode($this->input->post('fileuploader_images2'));
        foreach ($im as $key => $v) {
            if(!in_array($v->img, $fileuploader_images)){
                @unlink('.'.$v->img);
            }
        }
         // 去掉路徑開頭 '/'
        array_walk($fileuploader_images, function (&$img) {
            $img = substr($img, 1, strlen($img));
        });
        $fileuploader_uploaded_images = json_decode($this->input->post('fileuploader_uploaded_images2'));
         // 去掉路徑開頭 '/'
        array_walk($fileuploader_uploaded_images, function (&$img) {
            $img = substr($img, 1, strlen($img));
        });


        $editor = json_decode($this->input->post('fileuploader_editor2'), true);

        $this->item_img->delete(['item_id' => $id,'type'=>2]);
        include_once 'assets/plugins/fileuploader2/src/class.fileuploader.php';
        foreach ($fileuploader_images as $i => $img) {
           if(in_array($img, $fileuploader_uploaded_images)){
                $image_path = '/uploads/item/image/'.$id;
                if(!is_dir('.'.$image_path)) mkdir('.'.$image_path);
                MyFileUploader::resize($img, null, null, $img, (isset($editor[$i]['crop']) ? $editor[$i]['crop'] : null), 100, (isset($editor[$i]['rotation']) ? $editor[$i]['rotation'] : null));
                $img_info = pathinfo($img);
                $img_name=explode("/",$img);
                $image_path=$image_path.'/'.end($img_name);
                rename('./'.$img,'.'.$image_path);
           }else{
                $image_path = '/'.$img;
           }

            $this->item_img->insert([
                'item_id'       =>  $id,
                'img'           =>  $image_path,
                'update_time'   =>  date('Y-m-d H:i:s'),
                'seq'           =>  $i+1,
                'type'          =>  2,
            ]);
        }
    }

    public function payment(){
        if(!$this->session->userdata('user')['id'])redirect('/member/login');
        $this->session->unset_userdata('payment_sn');
        $data=[];
        $this->load->model('Pay_model','list_pay');
        $pay=$this->list_pay->get(['status'=>1])[0];
        $data['pay_url']=$pay->id==1?'/createItemOrder':'/createItemOrder2';
        if($this->input->post('item_id')||$this->session->userdata('item_id')){
            if($this->input->post('item_id'))$this->session->set_userdata('item_id', $this->input->post('item_id'));
            $item     =  $this->item->get(['item.id'=>$this->session->userdata('item_id')],['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','DATE_FORMAT(item.`update_time`,"%Y年%m月%d日") as update_date'])[0];
            $data['item'] =$item;
        }else{
            redirect();
        }
        //載入模版
        $this->load->view('front/item/payment',$data);
    }
    //點數購買商品
    public function point_order(){
        $this->load->model('Points_model','points');
        $this->load->model('Item_member_model','item_member');
        $this->load->model('SetPoint_model','list_point');
        $msg  = '';
        try {
            $this->db->trans_begin();
            if(!$this->session->userdata('item_id'))
                throw new Exception('無商品資料');
            if(!$this->session->userdata('user')['id'])
                throw new Exception('停留此畫面過久,請重新登入',1);

            $item     =  $this->item->get(['item.id'=>$this->session->userdata('item_id')],['item.*','CONCAT("/",member.img) as member_img','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','ROUND(item.USD*list_points.NTD) as NTD','DATE_FORMAT(item.`update_time`,"%Y年%m月%d日") as update_date']);
            if(empty($item))
                throw new Exception('無商品資料');
            $item=$item[0];
            if(($this->points_total-$item->points)<0)
                throw new Exception('點數餘額不足');

            if($item->points>0){
                //消費者產生一筆扣除消費點數紀錄
                $pointsdata2=[
                    'member_id'=>$this->session->userdata('user')['id'],
                    'points'=>'-'.$item->points,
                    'date_add'=>date("Y-m-d H:i:s"),
                    'type'=>2,
                    'item_id'=>$item->id,
                    'remark'=>"購買「{$item->title}-{$item->nickname}」作品",
                ];
                $result3 = $this->points->insert($pointsdata2);
                if(!$result3)throw new Exception('點數購買失敗');
            }


            $t="您已消費: {$item->points}鑽石，成功購買「{$item->title}-{$item->nickname}」作品。";
            $url='/member/purchasedItem';
            $this->insert_msg($this->session->userdata('user')['id'],$t,$url);



            $data2=[
                'member_id'=>$this->session->userdata('user')['id'],
                'item_id'=>$item->id,
                'create_time'=>date("Y-m-d H:i:s"),
            ];
            $this->item_member->insert($data2);
            $set = $this->list_point->get(['id'=>1])[0];
            $USD = round($item->USD*($set->plus*0.01),1);
            if($item->points>0){
                //創作者產生兌現紀錄
                $cashdata2=[
                    'from_member'=>$this->session->userdata('user')['id'],
                    'member_id'=>$item->member_id,
                    'USD'=>$USD,
                    'date_add'=>date("Y-m-d H:i:s"),
                    'type'=>1,
                    'payment_sn'=>'',
                    'item_id'=>$item->id,
                    'title'=>"會員:{$this->session->userdata('user')['nickname']}，購買「{$item->title}」作品",
                ];
                $result4 = $this->cash->insert($cashdata2);
                if(!$result4)throw new Exception('兌現記錄寫入失敗');
            }


            $t="恭喜您的作品「{$item->title}」已被購買，收入: $ {$USD}(USD)。";
            $url=$USD==0?"":'/member/incomeRecord';
            $this->insert_msg($item->member_id,$t,$url);

            $return     =  $this->ReturnHandle(true ,'點數購買成功','/member/purchasedItem');
            $this->db->trans_commit();
        }catch (Exception $e) {
           $this->db->trans_rollback();
            $error_msg = $e->getMessage();
            $err_url='';
            if($e->getCode()==1)$err_url='/member/login';
            $return = $this->ReturnHandle(false,$error_msg,$err_url);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function insert_msg($member_id,$t,$url){
        $this->load->model('Member_msg_model','member_msg');
        $data = [
            'member_id'=> $member_id,
            'msg_type_id'=> 2,
            'title'=> '會員通知',
            'create_time'=> date("Y-m-d H:i:s"),
            'mag_url'=> $url,
            'msg'=>$t,
        ];
        $this->member_msg->insert($data);
    }

}

/* End of file FrontController.php */
/* Location: ./application/controllers/front/FrontController.php */