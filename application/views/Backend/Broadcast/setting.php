<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="<?=version('assets/plugins/sweetalert/sweetalert2.min.css')?>" rel="stylesheet" type="text/css" />
    </head>
    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">
            <?php $this->load->view('Backend/layouts/topbar');?>
            <?php $this->load->view('Backend/layouts/menu');?>
            <!-- Left Sidebar End -->
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
                        <?php $this->load->view('Backend/layouts/nav');?>
                        <!-- end row -->

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                    <?php if(in_array(35, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                	<div class="clearfix">
                                        <button type="button" class="btn btn-custom waves-effect waves-light m-b-20" data-toggle="modal" data-target=".broadcast_add">新增推播信息</button>
                                    </div>
                                    <?php endif; ?>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered qna_list">
                                                <thead>
                                                <tr>
                                                    <th width="50" data-priority="1" class="text-center">#</th>
                                                    <th class="text-center" data-priority="1">推播信息標題</th>
                                                    <th class="text-center" data-priority="1">推播信息建立時間</th>
                                                    <?php if(in_array(35, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                    <th width="80" class="text-center" data-priority="1">編輯</th>
                                                    <?php endif; ?>
                                                    <?php if(in_array(36, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                    <th width="80" class="text-center" data-priority="1">刪除</th>
                                                    <?php endif; ?>
                                                </tr>
                                                </thead>
                                                <tbody>
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
                                    <div class="modal fade bs-example-modal-sm broadcast_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form name="Broadcast_add">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="mySmallModalLabel">新增推播信息</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <fieldset class="form-group">
                                                            <label for="exampleInputEmail1">推播信息標題</label>
                                                            <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="推播信息標題">
                                                        </fieldset>
                                                        <fieldset class="form-group">
                                                            <label for="exampleInputEmail1">推播信息內容</label>
                                                            <textarea class="form-control" name="content"></textarea>
                                                        </fieldset>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                                        <button type="submit" class="btn btn-primary">新增</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade bs-example-modal-sm broadcast_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form name="Broadcast_edit">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="mySmallModalLabel">編輯推播信息</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id">
                                                        <fieldset class="form-group">
                                                            <label for="exampleInputEmail1">推播信息標題</label>
                                                            <input type="text" name="title" class="form-control" placeholder="推播信息標題">
                                                        </fieldset>
                                                        
                                                        <fieldset class="form-group">
                                                            <label for="exampleInputEmail1">推播信息內容</label>
                                                            <textarea class="form-control" name="content" id="edit_content"></textarea>
                                                        </fieldset>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                                        <button type="submit" class="btn btn-primary">修改</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End of Row -->


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
        <script src="<?=version('assets/plugins/sweetalert/sweetalert2.js')?>"></script>
        <script src="<?=version('assets/js/common.js')?>"></script>
        <script type="text/javascript">
            var broadcast_ajax =   '/Backend/Broadcast/Setting';
            Table.DrawTable =   function(){
                $.ajax({
                    url:broadcast_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:'page='+Page.page+'&limit='+Page.row,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(data){
                        str =   '';
                        $.each(data.list,function(i,e){
                            str +='<tr>';
                            str +='<td class="text-center">'+(((Page.page-1)*Page.row)+(i+1))+'</td>';
                            str +='<td class="text-center">'+e.title+'</td>';
                            str +='<td class="text-center">'+e.create_time+'</td>';
                            <?php if(in_array(35, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                            str +='<td class="text-center"><a href="javascript:void(0);" class=" edit" data-id="'+e.id+'"><i class="zmdi zmdi-edit text-info"></i></a></td>';
                            <?php endif; ?>
                            <?php if(in_array(36, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                            str +='<td class="text-center"><a href="javascript:;" data-id="'+e.id+'" class=" delete-alert delete"><i class="zmdi zmdi-delete text-danger"></i></a></td>';
                            <?php endif; ?>
                            str +='</tr>';
                        });
                        $('.qna_list>tbody').html(str);
                        $.each($('input[data-plugin=switchery]'),function(i,e){
                            new Switchery(e,{color:$('input[data-plugin=switchery]').eq(i).data('color'),size:$('input[data-plugin=switchery]').eq(i).data('size'),});
                        });
                        Page.DrawPage(data.total);
                        $('.table-responsive').responsiveTable('update');
                });
            }
            $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '焦點', display : '顯示', displayAll: '全部顯示'}});
            Table.LoadTable();
            <?php if(in_array(34, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var broadcast_add_ajax   =   '/Backend/Broadcast/SettingAdd';
            $('form[name=Broadcast_add]').submit(function(e){
                e.preventDefault();
                var form    =   $(this);
                var data    =   form.serialize();
                $.ajax({
                    url:broadcast_add_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:data,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                            form[0].reset();
                            $('.broadcast_add').modal('hide');
                        }
                });
            });
            <?php endif; ?>
            <?php if(in_array(35, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var broadcast_edit_ajax   =   '/Backend/Broadcast/SettingEdit/';
            $('form[name=Broadcast_edit]').submit(function(e){
                e.preventDefault();
                var form    =   $(this);
                var data    =   form.serialize();
                var id      =   $('form[name=Broadcast_edit] input[name=id]').val();
                $.ajax({
                    url:broadcast_edit_ajax+id,
                    type:'POST',
                    dataType:'JSON',
                    data:data,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                            $('.broadcast_edit').modal('hide');
                        }
                });
            });
            <?php endif; ?>
            $(document).on('click','.edit',function(){
                var broadcast_info_ajax  =   '/Backend/Broadcast/SettingEdit/';
                $.ajax({
                    url:broadcast_info_ajax+$(this).attr('data-id'),
                    type:'GET',
                    dataType:'JSON',
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(data){
                        $.each(data,function(key,value){
                            if(key=='content'){
                                $('form[name=Broadcast_edit] textarea[name='+key+']').text(value);
                            }else{
                                $('form[name=Broadcast_edit] input[name='+key+']').val(value);
                            }
                        });
                        $('.broadcast_edit').modal('show');
                });
            });
            <?php if(in_array(36, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            $(document).on('click','.delete',function(){
                var broadcast_delete_ajax   =   '/Backend/Broadcast/SettingDelete/';
                var id                      =   $(this).attr('data-id');
                swal({
                    title:'確定刪除?',
                    type:'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定刪除',
                    cancelButtonText: '取消',
                }).then(function(result){
                    if(result.value){
                        $.ajax({
                            url:broadcast_delete_ajax+id,
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
        </script>
    </body>
</html>