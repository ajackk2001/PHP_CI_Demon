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
                                    <div class="clearfix">
                                        <form name="search">
                                            <div class="row">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered data_list" data-tablesaw-sortable data-tablesaw-sortable-switch>
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="30" data-priority="1">#</th>
                                                        <th class="text-center" data-priority="1">聯絡姓名</th>
                                                        <th class="text-center" data-priority="1">聯絡信箱</th>
                                                        <th class="text-center" data-priority="1">新增時間</th>
                                                        <?php if(in_array(16, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th class="text-center" width="100" data-priority="1">處理狀態</th>
                                                        <?php endif; ?>
                                                        <?php if(in_array(17, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th class="text-center" width="70" data-priority="1">刪除</th>
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
        <script type="text/javascript">
            var contact_ajax =   '/Backend/Contact';
            
            Table.DrawTable =   function(){
                var form    =   $('form[name=search]').serialize();
                $.ajax({
                    url:contact_ajax,
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
                            str += `<td class="text-center">${(((Page.page-1)*Page.row)+(i+1))}</td>`;
                            str += '<td class="text-center"><a href="/Backend/Contact/Edit/'+e.id+'">'+e.name+'</a></td>';
                            str += '<td class="text-center">'+e.email+'</td>';
                            str += '<td class="text-center">'+e.date_add+'</td>';
                            <?php if(in_array(16, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                            str += '<td class="text-center"><a href="javascript:;" class="icon-edit change_status" data-id="'+e.id+'" data-status="'+((e.status==1)?0:1)+'">'+((e.status==0)?'<i class="ion-close text-danger"></i>':'<i class="ion-checkmark checked text-info"></i>')+'</a></td>';
                            <?php endif; ?>
                            <?php if(in_array(17, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                            str += '<td class="text-center"><a href="javascript:;" data-id="'+e.id+'" class="icon-edit delete-alert"><i class="zmdi zmdi-delete text-danger"></i></a></td>';
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

            <?php if(in_array(17, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            //-*-*-*-*- 移除
            var delete_ajax = '/Backend/Contact/Delete/'
            $(document).on('click','.delete-alert',function(){
                var deleteId = $(this).attr("data-id");
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
                            url:delete_ajax+deleteId,
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
            <?php if(in_array(16, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            $(document).on('click','.change_status',function(){
                var id      =   $(this).attr("data-id");
                var status  =   $(this).attr("data-status");
                $.ajax({
                    url:'/Backend/Contact/Edit/'+id,
                    type:'POST',
                    dataType:'JSON',
                    data:{status:status},
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        Table.LoadTable();
                })
            });
            <?php endif; ?>
            
        </script>
    </body>
</html>