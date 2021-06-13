<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
    </head>
    <body class="fixed-left">
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
                        <!-- end row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <button type="button" class="btn btn-custom waves-effect waves-light m-b-20" data-toggle="modal" data-target=".admin_add">新增管理員</button>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered data_list" id="datatable">
                                                <thead>
                                                <tr>
                                                	<th width="80" class="text-center" data-priority="1">管理員編號</th>
                                                    <th width="80" class="text-center" data-priority="1">管理員類型</th>
                                                    <th width="80" class="text-center" data-priority="1">管理員帳號</th>
                                                    <th width="200" class="text-center" data-priority="1">管理員名稱</th>
                                                    <th class="text-center" data-priority="1">建立時間</th>
                                                    <th width="80" class="text-center" data-priority="1">最後登入時間</th>
                                                    <th width="150" class="text-center" data-priority="1">登入次數</th>
                                                    <th width="100" class="text-center" data-priority="1">狀態</th>
                                                    <th width="70" class="text-center" data-priority="1">啟用 <a data-toggle="tooltip" data-placement="left" title="" href="javascript:;" data-original-title="若要將會員設為黑名單，則不啟用此帳號，此會員將不能進行登入之動作"></th>
                                                    <th width="55" class="text-center" data-priority="1">編輯</th>
                                                    <th width="55" class="text-center" data-priority="1">刪除</th>
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
                                    <div class="modal fade bs-example-modal-sm admin_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form name="Admin_add">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="mySmallModalLabel">新增管理員</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <fieldset class="form-group">
                                                            <label for="addAdminId">管理員帳號</label>
                                                            <input type="text" name="username" class="form-control" id="addAdminId" placeholder="管理員帳號" autocomplete="username">
                                                        </fieldset>
                                                        <fieldset class="form-group">
                                                            <label for="addAdminPW">管理員密碼</label>
                                                            <input type="password" name="password" class="form-control" id="addAdminPW" placeholder="管理員密碼" autocomplete="new-password">
                                                        </fieldset>
                                                        <fieldset class="form-group">
                                                            <label for="addAdminCheckPw">再次確認密碼</label>
                                                            <input type="password" name="passwords" class="form-control" id="addAdminCheckPw" placeholder="再次確認密碼" autocomplete="new-password">
                                                        </fieldset>
                                                        <fieldset class="form-group">
                                                            <label for="addAdminName">管理員名稱</label>
                                                            <input type="text" name="name" class="form-control" id="addAdminName" placeholder="管理員名稱">
                                                        </fieldset>
                                                  
                                                        <fieldset class="form-group">
                                                            <label for="addAdminType">管理員類型</label>
                                                            <select name="permission_type" class="form-control" id="addAdminType">
                                                                <option value="superadmin">最大權限</option>
                                                                <option value="manager">一般管理</option>
                                                                <!-- <option value="admin">客服人員</option> -->
                                                            </select>
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
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


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
        <script type="text/javascript">
            var type    =   {'superadmin':'最大權限','manager':'一般管理','admin':'客服人員'};
            var check_status    =   {0:'停用',1:'啟用'};
            var admin_ajax =   '/Backend/Admin/AdminList';
            Table.DrawTable =   function(){
                var form    =   $('form[name=search]').serialize();
                $.ajax({
                    url:admin_ajax,
                    type:'GET',
                    dataType:'JSON',
                    data:form+'&page='+Page.page+'&limit='+Page.row,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(data){
                        str =   '';
                        $.each(data.list,function(i,e){
                            var label_class =   '';
                            if(e.status==0){
                                label_class =   'label label-danger';
                            }else{
                                label_class =   'label label-success';
                            }
                            str +='<tr>';
                            str +='<td class="text-center">'+e.id+'</td>';
                            str +='<td class="text-center">'+type[e.permission_type]+'</td>';
                            str +='<td class="text-center">'+e.username+'</td>';
                            str +='<td class="text-center">'+e.name+'</td>';
                            str +='<td class="text-center">'+e.date_add+'</td>';
                            str +='<td class="text-center">'+((e.last_login!=null)?e.last_login:'')+'</td>';
                            str +='<td class="text-center">'+e.login_count+'</td>';
                            str +='<td class="text-center"><span class="'+label_class+'">'+check_status[e.status]+'</span></td>';
                            str +='<td class="text-center vertical-align-middle"><input class="status" type="checkbox" '+((e.status==1)?'checked':'')+' data-id="'+e.id+'" data-plugin="switchery" data-color="#64b0f2" data-size="small"></td>';
                            str +='<td class="text-center"><a href="/Backend/Admin/Permission/'+e.id+'" class="col-md-4"><i class="zmdi zmdi-edit text-info"></i></a></td>';
                            str +='<td class="text-center"><a href="#" data-id="'+e.id+'" class="col-md-4 delete delete-alert"><i class="zmdi zmdi-delete text-danger"></i></a></td>';
                            str +='</tr>';
                        });
                        $('.data_list>tbody').html(str);
                        $.each($('input[data-plugin=switchery]'),function(i,e){
                            new Switchery(e,{color:$('input[data-plugin=switchery]').eq(i).data('color'),size:$('input[data-plugin=switchery]').eq(i).data('size'),});
                        });
                        Page.DrawPage(data.total);
                        $('.table-responsive').responsiveTable('update');

                });
            }
            $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '焦點', display : '顯示', displayAll: '全部顯示'}});
            Table.LoadTable();
            var status_ajx  =   '/Backend/Admin/AdminUpdateStatus/'
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
                    Table.LoadTable();
                });
            });

            var delete_ajax =   '/Backend/Admin/AdminDelete/';
            $(document).on('click','.delete',function(){
                var id = $(this).attr('data-id');
                swal({
                    title:'確定刪除?',
                    type:'warning',
                    showCancelButton: true, 
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定刪除',
                    cancelButtonText: '取消',
                }).then((result) => {
                  if (result.value) {
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
            var admin_add_ajax   =   '/Backend/Admin/AdminAdd';
            $('form[name=Admin_add]').submit(function(e){
                e.preventDefault();
                var form    =   $(this);
                var data    =   form.serialize();
                $.ajax({
                    url:admin_add_ajax,
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
                        $('.admin_add').modal('hide');
                    }
                });
            });
        </script>
    </body>
</html>