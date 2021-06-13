<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'MY_Manager.php';

// 商店類型
class Item_category extends MY_Manager
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
        $data['type'] = $this->item_type->get(['status' => 1], ['id', 'title', 'create_time', 'status'],['seq']);
        $this->load->view('Backend/Item/category', $data);
    }

    /*
     * 列表-api
     */
    public function show()
    {

        $select = ['item_category.*', 'item_type.title AS type_name'];
        $condition = [
            [
                'field' => 'item_type.id',
                'operator' => '=',
                'value' => $this->input->post('type'),
            ],
        ];
        $orderby = ['item_type.seq','item_category.update_time asc'];
        $limit['limit'] = $this->input->post('limit');
        $limit['offset'] = ($this->input->post('page') - 1) * $this->input->post('limit');

        $return['page'] = $this->input->post('page');
        $return['list'] = $this->item_category->search($select, [$condition], $orderby, $limit);
        $return['total'] = $this->item_category->row_count;
        $return['theme_quantity']  =   $this->about_theme->getQuantity('category_id');
        $return['popular_quantity']  =   $this->popular->getQuantity('category_id');
        $return['item_quantity']  =   $this->item->getQuantity('category_id');
        //$return['shop_quantity']  =   $this->shop->getShopQuantity('category_id');

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
            $data['update_time'] = date("Y-m-d H:i:s");
            $return = $this->ReturnHandle($this->item_category->insert($data), $this->lang->line('Insert_success'));
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
        $where = ['id' => $id];
        $return = $this->item_category->get($where, ['id', 'title', 'type_id', 'status'])[0];
        //$shop_quantity = $this->shop->getShopQuantity('category_id');
        //$return->shop_quantity  = (empty($shop_quantity[$return->id]))?0:$shop_quantity[$return->id];
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
            $return = $this->ReturnHandle($this->item_category->update($data, ['id' => $id]), $this->lang->line('Update_Info_success'));
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
            $return = $this->ReturnHandle($this->item_category->delete($where), $this->lang->line('Delete_success'));
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
                $return = $this->ReturnHandle($this->item_category->update($data, $where), $this->lang->line('Update_Info_success'));
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
            $this->item_category->updateSeq($this->input->post('seq'));
            $return = $this->ReturnHandle(true, $this->lang->line('Update_Info_seq'));
        } else {
            $return = $this->ReturnHandle(false, $this->form_validation->error_array());
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
}
