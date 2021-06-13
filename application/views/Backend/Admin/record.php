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
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered data_list">
                                                <thead>
                                                <tr>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-sortable-default-col="" data-tablesaw-priority="3" width="200" class="text-center" data-priority="1">管理員姓名</th>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="2" class="text-center" data-priority="1">管理員帳號</th>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="1" class="text-center" data-priority="1">登入IP</th>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="1" width="200" class="text-center" data-priority="1">登入時間</th>
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
            var record_ajax =   '/Backend/Admin/LoginRecord';
            Table.DrawTable =   function(){
                $.ajax({
                    url:record_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:'page='+Page.page+'&limit='+Page.row,
                    success:function(data){
                        str =   '';
                        $.each(data.list,function(i,e){
                            str +='<tr>';
                            str +='<td class="text-center">'+e.name+'</td>';
                            str +='<td class="text-center">'+e.username+'</td>';
                            str +='<td class="text-center">'+e.ip+'</td>';
                            str +='<td class="text-center font-13">'+e.create_time+'</td>';
                            str +='</tr>';
                        });
                        $('.data_list>tbody').html(str);
                        Page.DrawPage(data.total);
                    }
                });
            }
            $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '焦點', display : '顯示', displayAll: '全部顯示'}});
            Table.LoadTable();
        </script>
    </body>
</html>