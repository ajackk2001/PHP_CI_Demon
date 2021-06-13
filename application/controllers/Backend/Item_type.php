<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'MY_Manager.php';

// 商店分類
class Item_type extends MY_Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item_type_model','item_type');
        $this->load->model('Item_category_model','item_category');
        $this->load->model('About_theme_model','about_theme');
        $this->load->model('Popular_model','popular');
        $this->load->model('Item_model','item');
    }

    /*
     * 列表-view
     */
    public function index()
    {
        $this->load->view('Backend/Item/type');
    }

    /*
     * 列表-api
     */
    public function show()
    {
        $select = ['item_type.*',];
        $condition = [
            // [
            //     'field' => 'title',
            //     'operator' => 'like',
            //     'value' => $this->input->post('title'),
            // ],
        ];
        $orderby = ['seq'];
        $limit['limit'] = $this->input->post('limit');
        $limit['offset'] = ($this->input->post('page') - 1) * $this->input->post('limit');

        $return['page'] = $this->input->post('page');
        $return['list'] = $this->item_type->search($select, [$condition], $orderby, $limit);
        $return['total'] = $this->item_type->row_count;
        $return['category_quantity']  =   $this->item_category->getQuantity('type_id');
        $return['theme_quantity']  =   $this->about_theme->getQuantity('type_id');
        $return['popular_quantity']  =   $this->popular->getQuantity('type_id');
        $return['item_quantity']  =   $this->item->getQuantity('type_id');
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /*
     * 新增-operation
     */
    public function add()
    {
        $this->load->library('form_validation');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $data['create_time'] = date('Y-m-d H:i:s');
            $return = $this->ReturnHandle($this->item_type->insert($data), $this->lang->line('Insert_success'));
        } else {
            $return = $this->ReturnHandle(false, $this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /*
     * 編輯-api
     */
    public function info($id)
    {
        $return = $this->item_type->get(['id' => $id], ['id', 'title', 'status'])[0];
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /*
     * 更新-operation
     */
    public function edit($id)
    {
        $this->load->library('form_validation');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $data['update_time'] = date("Y-m-d H:i:s");
            $return = $this->ReturnHandle($this->item_type->update($data, ['id' => $id]), $this->lang->line('Update_Info_success'));
        } else {
            $return = $this->ReturnHandle(false, $this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /*
     * 刪除-operation
     */
    public function delete($id)
    {
        $this->load->library('form_validation');
        if ($this->form_validation->run()) {
            $where = [
                'id' => $id,
            ];
            $return = $this->ReturnHandle($this->item_type->delete($where), $this->lang->line('Delete_success'));
        } else {
            $return = $this->ReturnHandle(false, $this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /*
     * 更新狀態(上下架)-operation
     */
    public function updateStatus($id)
    {
        if ($id) {
            $this->load->library('form_validation');
            parse_str(file_get_contents('php://input'), $put);
            $this->form_validation->set_data($put);
            if ($this->form_validation->run()) {
                $where = [
                    'id' => $id,
                ];
                $data = $put;
                $return = $this->ReturnHandle($this->item_type->update($data, $where), $this->lang->line('Update_Info_success'));
            } else {
                $return = $this->ReturnHandle(false, $this->form_validation->error_array());
            }
        } else {
            $return = $this->ReturnHandle(false, $this->lang->line('Unknown_error'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /*
     * 更新排序(編號)-operation
     */
    public function updateSeq()
    {
        $this->load->library('form_validation');
        if ($this->form_validation->run()) {
            $this->load->model('item_type');
            $this->item_type->updateSeq($this->input->post('seq'));
            $return = $this->ReturnHandle(true, $this->lang->line('Update_Info_seq'));
        } else {
            $return = $this->ReturnHandle(false, $this->form_validation->error_array());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
        最後一個seq
    **/
    public function lastSeq(){
        $lastSeq = $this->item_type->search(['max(seq) MaxSeq']);
        $return = ((!empty($lastSeq[0]->MaxSeq)))? $lastSeq[0]->MaxSeq:0;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
}
