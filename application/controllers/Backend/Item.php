<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'MY_Manager.php';

// 商店分類
class Item extends MY_Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item_model','item');
    }
    public function Index()
    {
        $this->load->view('Backend/Item/record.php');
    }

    /*
     * 收付款列表
     */
    public function Show()
    {
        $select = ['item.*','CONCAT("/",member.img) as member_img','member.username','member.name','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','country.title as country_title','item_category.title as category_title','item_type.title as type_title','item_scale.title as scale_title'];
        $conditions = [
            [
                'field' => ['item.review_status'],
                'operator' => '=',
                'value' => '1',
            ],
            [
                'field' => ['item.type_id'],
                'operator' => '=',
                'value' => $this->input->post('type'),
            ],
            [
                'field' => ['item.category_id'],
                'operator' => '=',
                'value' => $this->input->post('category'),
            ],
            [
                'field' => ['member.country'],
                'operator' => '=',
                'value' => $this->input->post('country'),
            ],
            [
                'field' => ['item.scale_id'],
                'operator' => '=',
                'value' => $this->input->post('scale'),
            ],
            [
                'field' => ['member.name','member.username','member.nickname'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search'),
            ],
            [
                'field' => ['item.title'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search2'),
            ],
        ];
        $orderby    =   ['update_time DESC'];
        $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        $limit['limit']     =   $this->input->post('limit');
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->item->search($select, [$conditions], $orderby, $limit);
        $return['total']    =   $this->item->row_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function Index2($member_id='')
    {
        $data['member_id'] = $member_id;
        $this->load->view('Backend/Item/record2.php',$data);
    }

    /*
     * 收付款列表
     */
    public function Show2($member_id='')
    {
        // $select = ['item.*','CONCAT("/",member.img) as member_img','member.username','member.name','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','country.title as country_title','item_category.title as category_title','item_type.title as type_title','item_scale.title as scale_title'];
        // $conditions = [
        //     [
        //         'field' => ['item.review_status'],
        //         'operator' => '=',
        //         'value' => '1',
        //     ],
        //     [
        //         'field' => ['item.type_id'],
        //         'operator' => '=',
        //         'value' => $this->input->post('type'),
        //     ],
        //     [
        //         'field' => ['item.category_id'],
        //         'operator' => '=',
        //         'value' => $this->input->post('category'),
        //     ],
        //     [
        //         'field' => ['member.country'],
        //         'operator' => '=',
        //         'value' => $this->input->post('country'),
        //     ],
        //     [
        //         'field' => ['item.scale_id'],
        //         'operator' => '=',
        //         'value' => $this->input->post('scale'),
        //     ],
        // ];
        // $orderby    =   ['update_time DESC'];
        // $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
        // $limit['limit']     =   $this->input->post('limit');
        // $return['page']     =   $this->input->post('page');
        // $return['list']     =   $this->item->search($select, [$conditions], $orderby, $limit);
        // $return['total']    =   $this->item->row_count;



        $this->load->model('Item_member_model','item_member');
       $select = ['item.title','item_member.create_time','CONCAT("/",member.img) as member_img','member.username','member.name','member.nickname','ROUND(item.USD*list_points.points) as points','(item.USD-0.01) as USD2','item_category.title as category_title','item_type.title as type_title','item_scale.title as scale_title'];
        $conditions = [
            [
                'field' => ['item_member.member_id'],
                'operator' => '=',
                'value' => $member_id,
            ],
        ];
        $limit  =   ['offset'=>NULL,'limit'=>NULL];
        $orderby    =   ['item_member.create_time'];
        if($this->input->post('page')&&$this->input->post('limit')){
            $limit['offset']    =   ($this->input->post('page')-1)*$this->input->post('limit');
            $limit['limit']     =   $this->input->post('limit');
        }
        $return['page']     =   $this->input->post('page');
        $return['list']     =   $this->item_member->search($select, [$conditions], $orderby,$limit);
        $return['total']    =   $this->item_member->row_count;

        // foreach ($return['list'] as $k => $v) {
        //     if($v->ctr>=1000)$return['list'][$k]->ctr=$this->floor_dec(($v->ctr/1000),1).'k';
        // }

        // $this->output->set_content_type('application/json')->set_output(json_encode($return));

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    //作品審核紀錄
    public function itemReview(){
        $data=[];
        $this->load->view('Backend/Item/itemReview',$data);
    }

    public function reviewRecordList(){
        $fields = ['item.*','member.username','member.name','member.nickname','administrator.name as admin_name'];
        $conditions = [
            [
                'field' => 'item.review_status',
                'operator' => '=',
                'value' => $this->input->post('shop_status') ?:($this->input->post('search')?['0','1','2']: ['0','2']),
            ],
            [
                'field' => ['item.title','member.username','member.name','member.nickname'],
                'operator' => 'LIKE',
                'value' => $this->input->post('search'),
            ],
        ];
        $orderby = ['item.update_time DESC'];
        $limit['limit'] = $this->input->post('limit');
        $limit['offset'] = ($this->input->post('page')-1)*$this->input->post('limit');
        $return['list']     =   $this->item->search($fields, [$conditions], $orderby, $limit);
        $return['total']    =   $this->item->row_count;
        $return['page']     =   $this->input->post('page');
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function itemReviewEdit($id='') {

        try {
            $this->db->trans_begin();
            $review_data = $this->item->get(['item.id' => $id]);
            if (empty($review_data))
                throw new Exception('查無審核資料');
            $item=$review_data[0];
            // if ($review_data->shop_status != 0)
            //     throw new Exception('狀態已更新');

            $status = $this->input->post('status');
            if ($status == '' || !in_array($status, [0,1,2]))
                throw new Exception('資料傳送錯誤');

            $update = ['review_status'=>$status,'admin'=>$this->session->Manager->id,'result_date'=>date('Y-m-d'),'update_time'=>date('Y-m-d H:i:s')];

            $update['status'] = ($status==1)?1:0;

            if ($status == 2) {
                $remark = $this->input->post('remark');
                if (empty($remark))
                    throw new Exception('請輸入拒絕原因');

                $update['remark'] = $remark;
            }else{
                $update['remark']='';
            }



            if (!$this->item->update($update,['id' => $id]))
                throw new Exception('更新失敗');

            $t=($status==1)?"恭喜您，您的作品「{$item->title}」，系統已審核通過並上架。":"您的作品「{$item->title}」，系統審核未通過，請查看原因，修改後重新送審。";
            $url='/member/productShelf';
            $this->insert_msg($item->member_id,$t,$url);

            $return = $this->ReturnHandle(true,'更新成功');

        } catch (Exception $e) {
            $return = $this->ReturnHandle(false,$e->getMessage());
            $this->db->trans_rollback();
        }
        if($return['status']){
            $this->db->trans_commit();
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    /**
    狀態
    **/
    public function UpdateStatus($id){
        $data   = $this->input->post();
        $where  = ['id' =>  $id];
        $result = $this->item->update($data,$where);
        if ($result){
            $return     =   $this->ReturnHandle(true,$this->lang->line('Update_Info_success'));
            if($data['status']==0){
                $item = $this->item->get(['item.id' => $id])[0];
                $t="您的作品「{$item->title}」，系統已下架，詳細原因請洽公司客服。";
                $url='/member/productShelf';
                $this->insert_msg($item->member_id,$t,$url);
            }
        }else {
            $return     =   $this->ReturnHandle(false,$this->lang->line('Update_Info_fail'));
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
