<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="<?= version('assets/plugins/hopscotch/css/hopscotch.min.css') ?>" rel="stylesheet" type="text/css" />
    </head>
    <body class="fixed-left popoverLg">
        <!-- Begin page -->
        <div id="wrapper">
            <?php $this->load->view('Backend/layouts/topbar');?>
            <?php $this->load->view('Backend/layouts/menu');?>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <?php $this->load->view('Backend/layouts/nav');?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box" >
                                    <?php if(in_array(60, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                    <div class="clearfix">
                                        <button type="button" class="btn btn-custom waves-effect waves-light m-b-20 add" data-toggle="modal" data-target=".modal_add">新增活動花絮</button>
                                    </div>
                                    <?php endif; ?>
                                    <div class="clearfix">
                                        <form name="search">
                                            <div class="row">
                                                <fieldset class="form-group col-md-4 col-12">
                                                    <select name="type_id" class="form-control" id="searchType" onChange="Table.LoadTable()">
                                                        <option value="">-- 選擇分類 --</option>
                                                        <?php foreach ($typeData as $type):?>
                                                            <option value="<?=$type->id?>"><?=$type->title?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered data_list">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="30" data-tablesaw-sortable-col data-tablesaw-priority="1" data-priority="1">#</th>
                                                        <th width="100" class="text-center" data-priority="1">分類</th>
                                                        <th width="" class="text-center" data-priority="1">標題</th>
                                                        <th width="100" class="text-center" data-priority="1">圖片總數<a href="javascript:;" onclick="tour(photos_tour)"><i class="ion-help-circled"></i></a></th>
                                                        <th width="150" class="text-center" data-priority="1">發佈日期</th>
                                                        <th width="70" class="text-center" data-priority="1">啟用</th>
                                                        <?php if(in_array(61, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th width="70" class="text-center" data-priority="1">編輯</th>
                                                        <?php endif; ?>
                                                        <?php if(in_array(62, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th width="70" class="text-center" data-priority="1" data-toggle="tooltip" data-placement="left" title="數量大於0，不可刪除">刪除<i class="zmdi zmdi-info-outline text-info"></i></th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody><!-- 依照日期做排序 -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row m-t-20">
                                        <div class="col-md-5">
                                            <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">
                                                總共 0 筆中第 0 - 0 筆
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination justify-content-end">
                                                    <li class="page-item disabled">
                                                        <a class="page-link" href="#" tabindex="-1">«</a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="#">»</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Row -->
                        <div class="modal fade bs-example-modal-sm modal_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form name="modal_add" enctype="multipart/form-data" >
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mySmallModalLabel">新增活動花絮</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addTitle">標題<span class="text-danger">*</span></label>
                                                        <input type="text" name="title" class="form-control" id="addTitle" placeholder="標題" required>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="editTypeId">分類<span class="text-danger">*</span></label>
                                                        <select class="form-control" name="type_id" id="editTypeId" required>
                                                            <option value="">-分類名稱-</option>
                                                            <?php foreach ($typeData as $key=>$val):?>
                                                                <option value="<?=$val->id?>"><?=$val->title?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addPublishTime">發佈日期 <span class="text-danger">*</span> <small class="text-info">依照發佈日期排序</small></label>
                                                        <input type="date" name="publish_time" class="form-control datepicker" id="addPublishTime" value="" required>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addContent">描述</label>
                                                        <textarea name="content" class="form-control" id="addCountent"></textarea>
                                                    </fieldset>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                            <button type="submit" class="btn btn-primary">新增</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-example-modal-sm modal_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form name="modal_edit" enctype="multipart/form-data" >
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mySmallModalLabel">編輯活動花絮</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="editTitle">標題<span class="text-danger">*</span></label>
                                                        <input type="text" name="title" class="form-control" id="editTItle" placeholder="標題" value="" required>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="editTypeId">分類<span class="text-danger">*</span></label>
                                                        <select class="form-control" name="type_id" id="editTypeId" required>
                                                            <option value="">-分類名稱-</option>
                                                            <?php foreach ($typeData as $key=>$val):?>
                                                                <option value="<?=$val->id?>"><?=$val->title?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="editPublishTime">發佈日期 <small class="text-danger">*</small> <small class="text-info">依照發佈日期排序</small></label>
                                                        <input type="date" name="publish_time" class="form-control datepicker" id="editPublishTime" value="" required>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="editContent">描述</label>
                                                        <textarea name="content" class="form-control" id="editCountent"></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="id">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                            <button type="submit" class="btn btn-primary">修改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container -->
                </div> <!-- content -->
            </div>
            <!-- End content-page -->
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
            <!-- Right Sidebar -->
            <?php $this->load->view('Backend/layouts/right_sidebar');?>
            <!-- /Right-bar -->
            <?php $this->load->view('Backend/layouts/footer');?>
        </div>
        <!-- END wrapper -->
        <?php $this->load->view('Backend/layouts/script');?>
        <script src="<?=version('assets/plugins/hopscotch/js/hopscotch.min.js')?>"></script>
        <script>
            $(document).ready(() => {

                var json_ajax =   '/Backend/Albums/List';
                Table.DrawTable =   function(){
                    var form    =   $('form[name=search]').serialize();
                    $.ajax({
                        url:json_ajax,
                        type:'GET',
                        dataType:'JSON',
                        data:form+'&page='+Page.page+'&limit='+Page.row,
                        beforeSend: function () { waitingDialog.show(); }
                    }).always(function () {
                        waitingDialog.hide();
                    }).done(function(data){
                            str =   '';
                            $.each(data.list,function(i,e){
                                str +=` <tr>
                                            <td class="text-center vertical-align-middle">${(((Page.page-1)*Page.row)+(i+1))}</td>
                                            <td class="vertical-align-middle itemType">${e.type_title}</td>
                                            <td class="vertical-align-middle itemTitle">${e.title}</td>
                                            <td class="text-center vertical-align-middle"><a href="/Backend/Albums/Photos/${e.id}" id="photosLink${i}">${e.counts}</a></td>
                                            <td class="text-center vertical-align-middle">${e.publish_time}</td>
                                            <td class="text-center vertical-align-middle"><input class="status" type="checkbox" ${((e.status==1)?'checked':'')} data-id="${e.id}" data-plugin="switchery" data-color="#64b0f2" data-size="small"></td>
                                            <?php if(in_array(61, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                            <td class="text-center vertical-align-middle"><a href="javascript:void(0);" class="edit" data-id="${e.id}" data-toggle="modal" data-target=".modal_edit"><i class="zmdi zmdi-edit text-info"></i></a></td>
                                            <?php endif; ?>
                                            <?php if(in_array(62, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                            <td class="text-center">${((e.counts>0)?`<span data-toggle="tooltip" data-placement="left" title="不可刪除"><i class="ion-minus-round"></i></span>`:`<a href="javascript:;" data-id="${e.id}" class="delete-alert delete"><i class="zmdi zmdi-delete text-danger"></i></a>`)}</td>
                                            <?php endif; ?>
                                        </tr>`;
                                        // <td class="text-center vertical-align-middle">${e.ctr}</td>
                            });
                            $('.data_list>tbody').html(str);
                            $.each($('input[data-plugin=switchery]'),function(i,e){
                                new Switchery(e,{color:$('input[data-plugin=switchery]').eq(i).data('color'),size:$('input[data-plugin=switchery]').eq(i).data('size'),});
                            });
                            Page.DrawPage(data.total);
                            $('[data-toggle="tooltip"]').tooltip();
                            $('.table-responsive').responsiveTable('update');
                    });
                }
                $(document).on('change','.searchChange',function(){
                    Page.page=1;
                    Table.LoadTable();
                });

                $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '焦點', display : '顯示', displayAll: '全部顯示'}});
                Table.LoadTable();
                $('.search').click(function(){
                    Page.page=1;
                    Table.LoadTable();
                });
                $('.reset').click(function(){
                    $('form[name=search]')[0].reset();
                    Table.LoadTable();
                });
            });

            var status_ajx  =   '/Backend/Albums/UpdateStatus/item/';
            $(document).on('change','.status',function(){
                $.ajax({
                    url:status_ajx+$(this).attr('data-id'),
                    type:'POST',
                    dataType:'JSON',
                    data:{'status':(($(this).prop('checked'))?1:0)},
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                        }
                });
            });


            <?php if(in_array(60, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var add_ajax   =   '/Backend/Albums/Add';
            $('form[name=modal_add]').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url         : add_ajax,
                    type        : 'POST',
                    data        : formData,
                    dataType    : 'JSON',
                    processData: false,
                    contentType: false,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                            $('form[name=modal_add]')[0].reset();
                            $('.modal_add').modal('hide');
                        }
                });
            });
            <?php endif; ?>
            <?php if(in_array(61, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var edit_ajax   =   '/Backend/Albums/Edit/';
            $('form[name=modal_edit]').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var id      = $('form[name=modal_edit] input[name=id]').val();
                $.ajax({
                    url         : edit_ajax+id,
                    type        : 'POST',
                    data        : formData,
                    dataType    : 'JSON',
                    processData: false,
                    contentType: false,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                            $('form[name=modal_edit]')[0].reset();
                            $('.modal_edit').modal('hide');
                        }
                });
            });
            <?php endif; ?>
            $(document).on('click','.edit',function(){
                var info_ajax  =   '/Backend/Albums/Info/';
                $.ajax({
                    url:info_ajax+$(this).attr('data-id'),
                    type:'GET',
                    dataType:'JSON',
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(data){
                        if (Object.keys(data).length > 0){
                            $.each(data,function(key,value){
                                if (key=='type_id'){ 
                                    $('form[name=modal_edit] select[name=type_id]').val(value).change();
                                }else if (key=='content'){ 
                                    $('form[name=modal_edit] textarea[name=content]').html(value);
                                }else{
                                    $('form[name=modal_edit] input[name='+key+']').val(value);
                                }
                            });

                        }else{
                            $('.modal_edit').modal('hide');
                            swal({
                                title:'查無資訊',
                                type:'warning'
                            })
                        }
                });
            });
            <?php if(in_array(62, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            $(document).on('click','.delete',function(){
                var delete_ajax  =   '/Backend/Albums/Delete/';
                var $this = $(this);
                var id = $this.attr('data-id');
                var title = $this.closest('tr').find('.itemTitle').text();
                swal({
                    title: '是否刪除' + title,
                    text: "刪除後不可回復",
                    type:'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定刪除',
                    cancelButtonText: '取消',
                }).then(function(result){
                    if(result.value){
                        $.ajax({
                            url:delete_ajax+id,
                            type:'POST',
                            dataType:'JSON',
                            beforeSend: function () { waitingDialog.show(); }
                        }).always(function () {
                            waitingDialog.hide();
                        }).done(function(result){
                                ResultData2(result);
                                Table.LoadTable();
                        });
                    }
                });
            });
            <?php endif; ?>

            /* 說明 */
            function tour(which) {
                hopscotch.startTour(which);
            }

            var photos_tour = {
                id: "photos_tour",
                scrollDuration: 200,
                steps: [
                    {
                        target: 'photosLink0',
                        content: "按下圖片數量的數字轉跳至<a href='/Backend/Albums/Photos'>'圖片上傳'</a>頁面",
                        placement: 'top',
                    }
                ],
            }

        </script>
    </body>
</html>