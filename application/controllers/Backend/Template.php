<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'MY_Manager.php';

class Template extends MY_Manager
{
    private $img_dir = 'uploads/backend-template/image/';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // fileuploader preload
        $data['fileuploaderImages'] = [];
        foreach ($this->load_images() as $v) {
            $img_info = pathinfo($v->img);
            $data['fileuploaderImages'][] = [
                'name' => '/'.$v->img,  // 檔名，這邊用來存放圖檔 url，以利前端傳資料回後端時知道圖片在哪
                'type' => 'image',
                'size' => filesize($v->img),
                'file' => version($v->img),  // 圖檔路徑
                'data' => [
                    // 縮圖路徑
                    'thumbnail' => version($img_info['dirname'].'/'.$img_info['filename'].'_thumbnail.'.$img_info['extension']),
                ],
            ];
        }

        $this->load->model('City_model');
        $this->load->model('Area_model');
        $data['cities'] = $this->City_model->get();
        $data['areas'] = $this->Area_model->get();

        $this->load->view('template', $data);
    }

    public function fileuploader_image_upload()
    {
        // 確保上傳資料夾存在
        @mkdir($this->img_dir, 0777, true);
        include 'assets/plugins/fileuploader2/src/class.fileuploader.php';
        // 上傳圖片
        $fileUploader = new MyFileUploader('files', array(
            'fileMaxSize' => 8,
            'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
            'required' => true,
            'uploadDir' => $this->img_dir,
            'title' => time(),
            'replace' => false,
        ));
        $upload = $fileUploader->upload();

        if ($upload['isSuccess']) {
            // 製作縮圖
            // 縮圖檔名: 原檔名後綴 "_thumbnail"
            $img = $upload['files'][0];
            $thumbnail = $this->img_dir.basename($img['name'], '.'.$img['extension']).'_thumbnail.'.$img['extension'];
            if (MyFileUploader::resize($img['file'], 200, 200, $thumbnail, null, 100)) {
                $return = $this->ReturnHandle(true, '/'.$img['file']);
            } else {
                $return = $this->ReturnHandle(false, $this->lang->line('Update_Info_fail'));
            }
        } else {
            $return = $this->ReturnHandle(false, $this->lang->line('Update_Info_fail'));
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function save_images()
    {
        // 確定需要的圖片
        $fileuploader_images = json_decode($this->input->post('fileuploader_images'));
        // 去掉路徑開頭 '/'
        array_walk($fileuploader_images, function (&$img) {
            $img = substr($img, 1, strlen($img));
        });
        $this->clear_images($fileuploader_images);

        // 更新資料庫 刪除圖片
        $imgs = array_column($this->load_images(), 'img');
        foreach (array_diff($imgs, $fileuploader_images) as $img_to_delete) {
            $this->delete_images(['img' => $img_to_delete]);
        }

        // 更新資料庫 新增的圖片
        $fileuploader_new_images = json_decode($this->input->post('fileuploader_uploaded_images'));
        // 去掉路徑開頭 '/'
        array_walk($fileuploader_new_images, function (&$img) {
            $img = substr($img, 1, strlen($img));
        });
        foreach (array_diff($fileuploader_new_images, $imgs) as $new_img) {
            $this->add_image([
                'img' => $new_img,
                'create_time' => date('Y-m-d H:i:s'),
            ]);
        }

        include_once 'assets/plugins/fileuploader2/src/class.fileuploader.php';
        $editor = json_decode($this->input->post('fileuploader_editor'), true);
        foreach ($fileuploader_images as $i => $img) {
            // 更新排序
            $this->update_image(['seq' => $i], ['img' => $img]);
            // 裁圖
            MyFileUploader::resize($img, null, null, null, (isset($editor[$i]['crop']) ? $editor[$i]['crop'] : null), 100, (isset($editor[$i]['rotation']) ? $editor[$i]['rotation'] : null));
            $img_info = pathinfo($img);
            // 製作縮圖
            // 縮圖檔名: 原檔名後綴 "_thumbnail"
            $thumbnail = $img_info['dirname'].'/'.$img_info['filename'].'_thumbnail.'.$img_info['extension'];
            MyFileUploader::resize($img, 400, 360, $thumbnail, null, 100);
        }
        $return = $this->ReturnHandle(true, $this->lang->line('Update_Info_success'), '/Backend/Template');
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    private function add_image($data)
    {
        $this->db->insert('template_images', $data);
    }

    private function load_images()
    {
        return $this->db
            ->select('img')
            ->order_by('seq')
            ->get('template_images')
            ->result();
    }

    private function clear_images(array $images)
    {
        // 取得 thumbnails
        $fileuploader_thumbnails = [];
        foreach ($images as $img) {
            $img_info = pathinfo($img);
            $fileuploader_thumbnails[] = $img_info['dirname'].'/'.$img_info['filename'].'_thumbnail.'.$img_info['extension'];
        }

        // 刪除沒用到的圖片、縮圖
        foreach (array_diff(glob($this->img_dir.'*'), array_merge($images, $fileuploader_thumbnails)) as $file_path) {
            @unlink($file_path);
        }
    }

    private function delete_images($where)
    {
        $this->db->delete('template_images', $where);
    }

    private function update_image($data, $where)
    {
        $this->db->update('template_images', $data, $where);
    }
}
