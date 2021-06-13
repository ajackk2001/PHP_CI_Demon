<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'MY_Manager.php';

// 商店分類
class Item_scale extends MY_Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item_scale_model','item_scale');
        $this->load->model('Item_model','item');
    }

    /*
     * 列表-view
     */
    public function index()
    {
        $this->load->view('Backend/Item/scale');
    }

    /*
     * 列表-api
     */
    public function show()
    {
        $select = ['item_scale.*',];
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
        $return['list'] = $this->item_scale->search($select, [$condition], $orderby, $limit);
        $return['total'] = $this->item_scale->row_count;
        $return['item_quantity']  =   $this->item->getQuantity('scale_id');
       // $return['shop_quantity']  =   $this->shop->getShopQuantity('type_id');
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
            $return = $this->ReturnHandle($this->item_scale->insert($data), $this->lang->line('Insert_success'));
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
        $return = $this->item_scale->get(['id' => $id], ['id', 'title', 'status'])[0];
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
            $return = $this->ReturnHandle($this->item_scale->update($data, ['id' => $id]), $this->lang->line('Update_Info_success'));
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
            $return = $this->ReturnHandle($this->item_scale->delete($where), $this->lang->line('Delete_success'));
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
                $return = $this->ReturnHandle($this->item_scale->update($data, $where), $this->lang->line('Update_Info_success'));
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
            $this->load->model('item_scale');
            $this->item_scale->updateSeq($this->input->post('seq'));
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
        $lastSeq = $this->item_scale->search(['max(seq) MaxSeq']);
        $return = ((!empty($lastSeq[0]->MaxSeq)))? $lastSeq[0]->MaxSeq:0;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
}
