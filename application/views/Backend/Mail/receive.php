<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
    </head>
    <body class="fixed-left">
        <div id="wrapper">
            <?php $this->load->view('Backend/layouts/topbar');?>
            <?php $this->load->view('Backend/layouts/menu');?>
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <?php $this->load->view('Backend/layouts/nav');?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <?php if(in_array(66, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                    <button type="button" class="btn btn-custom waves-effect waves-light m-b-20 add" data-toggle="modal" data-target=".modal_add">新增收件信箱</button>
                                    <?php endif; ?>
                                    <div class="clearfix">
                                        <form name="search">
                                            <div class="row">
                                                <fieldset class="form-group col-12 col-md-4">
                                                    <select class="form-control" name="type_id" id="searchType" onChange="Table.LoadTable()">
                                                        <option value="">--- 選擇收件類型 ---</option>
                                                        <?php foreach($mail_send_type as $key => $type): ?>
                                                            <option value="<?=$type->id?>"><?=$type->title?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered data_list">
                                                <thead>
                                                    <tr id="navbar">
                                                        <th class="text-center" data-priority="1">#</th>
                                                        <th class="text-center" data-priority="1">收件類型</th>
                                                        <th class="text-center" data-priority="1">收件姓名</th>
                                                        <th class="text-center" data-priority="1">收件信箱</th>
                                                        <?php if(in_array(67, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th class="text-center" width="70" data-priority="1">編輯</th>
                                                        <?php endif; ?>
                                                        <?php if(in_array(68, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th class="text-center" width="70" data-priority="1">刪除</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
                        <?php if(in_array(66, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                        <div class="modal fade bs-example-modal-sm modal_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="mySmallModalLabel">新增收件信箱</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form name="modal_add">
                                        <div class="modal-body">
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">選擇收件類型</label>
                                                <select class="form-control" name="type_id" required>
                                                    <option value="">--- 選擇收件類型 ---</option>
                                                    <?php foreach($mail_send_type as $key => $value): ?>
                                                        <option value="<?=$value->id?>"><?=$value->title?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">收件人姓名</label>
                                                <input type="text" name="title" class="form-control" placeholder="收件人姓名" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">收件人信箱</label>
                                                <input type="text" name="email" class="form-control" placeholder="收件人信箱" required>
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
                        <?php endif; ?>
                        <?php if(in_array(67, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                        <div class="modal fade bs-example-modal-sm modal_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="mySmallModalLabel">編輯收件信箱</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form name="modal_edit">
                                        <div class="modal-body">
                                            <input type="hidden" name="id">
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">選擇收件類型</label>
                                                <select class="form-control" name="type_id" required>
                                                    <option value="">--- 選擇收件類型 ---</option>
                                                    <?php foreach($mail_send_type as $key => $value): ?>
                                                        <option value="<?=$value->id?>"><?=$value->title?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">收件人姓名</label>
                                                <input type="text" name="title" class="form-control" placeholder="收件人姓名" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">收件人信箱</label>
                                                <input type="text" name="email" class="form-control" placeholder="收件人信箱" required>
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
                        <?php endif; ?>

                    </div>
                </div>
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
    </body>
    
    <script type="text/javascript">
        var json_ajax   =   '/Backend/Mail/Receive';
        Table.DrawTable =   function(){
            var form    =   $('form[name=search]').serialize();
            $.ajax({
                url:json_ajax,
                type:'POST',
                dataType:'JSON',
                data:form+'&page='+Page.page+'&limit='+Page.row,
                beforeSend: function () { waitingDialog.show(); }
            }).always(function () {
                waitingDialog.hide();
            }).done(function(data){
                    str =   '';
                    $.each(data.list,function(i,e){
                        str += '<tr>';
                        str += '<td class="text-center">'+(((Page.page-1)*Page.row)+(i+1))+'</td>';
                        str += '<td class="text-center">'+e.type_title+'</td>';
                        str += '<td class="text-center">'+e.title+'</td>';
                        str += '<td class="text-center">'+e.email+'</td>';
                        <?php if(in_array(67, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                        str += '<td class="text-center"><a href="javascript:void(0)" data-id="'+e.id+'" class="icon-edit edit"><i class="zmdi zmdi-edit text-info"></i></a></td>';
                        <?php endif; ?>
                        <?php if(in_array(68, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                        str += '<td class="text-center"><a href="javascript:;" data-id="'+e.id+'" class="icon-edit delete-alert delete"><i class="zmdi zmdi-delete text-danger"></i></a></td>';
                        <?php endif; ?>
                        str += '</tr>';
                    });
                    $('.data_list>tbody').html(str);
                    Page.DrawPage(data.total);
                    $('.table-responsive').responsiveTable('update');
            });
        }
        $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '焦點', display : '顯示', displayAll: '全部顯示'}});
        Table.LoadTable();

        var add_ajax   =   '/Backend/Mail/ReceiveAdd';
        $('form[name=modal_add]').submit(function(e){
            e.preventDefault();
            var form    =   $(this);
            var data    =   form.serialize();
            $.ajax({
                url:add_ajax,
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
                        $('.modal_add').modal('hide');
                    }
            });
        });
        <?php if(in_array(67, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
        var edit_ajax   =   '/Backend/Mail/ReceiveEdit/';
        $('form[name=modal_edit]').submit(function(e){
            e.preventDefault();
            var form    =   $(this);
            var data    =   form.serialize();
            var id      =   $('form[name=modal_edit] input[name=id]').val();
            $.ajax({
                url:edit_ajax+id,
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
                        $('.modal_edit').modal('hide');
                    }
            });
        });
        <?php endif; ?>
        $(document).on('click','.edit',function(){
            var info_ajax  =   '/Backend/Mail/ReceiveEdit/';
            $.ajax({
                url:info_ajax+$(this).attr('data-id'),
                type:'GET',
                dataType:'JSON',
                beforeSend: function () { waitingDialog.show(); }
            }).always(function () {
                waitingDialog.hide();
            }).done(function(data){
                    $.each(data,function(key,value){
                        if(key=='type_id'){
                            $('form[name=modal_edit] select[name='+key+']').val(value).change;
                        }else{
                            $('form[name=modal_edit] input[name='+key+']').val(value);
                        }
                    });
                    $('.modal_edit').modal('show');
            });
        });
        <?php if(in_array(68, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
        $(document).on('click','.delete',function(){
            var delete_ajax  =   '/Backend/Mail/ReceiveDelete/';
            var id = $(this).attr('data-id');
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
    </script>
</html>