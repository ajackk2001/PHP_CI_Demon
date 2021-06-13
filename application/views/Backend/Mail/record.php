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
                        <!-- <div class="row">
                            <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="card-box tilebox-one">
                                    <i class="icon-paypal float-right text-muted"></i>
                                    <h6 class="text-muted text-uppercase m-b-20">剩餘郵件點數</h6>
                                    <h2 class="m-b-20">$<span data-plugin="counterup">0</span></h2>
                                    <span class="label label-danger">注意!!</span><span class="text-muted text-danger">您目前已無郵件點數!! 若需增加郵件點數，請與管理者連繫</span>
                                </div>
                            </div>
                        </div> -->
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                	<div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered mail_record_list">
                                                <thead>
                                                <tr>
                                                    <th width="50" class="text-center" data-priority="1">發送序號</th>
                                                    <th width="200" class="text-center" data-priority="1">會員/帳號</th>
                                                    <th width="200" class="text-center" data-priority="1">發送標題</th>
                                                    <th width="400" class="text-center" data-priority="1">發送內容</th>
                                                    <th class="text-center" data-priority="1">新增時間</th>
                                                    <th class="text-center" data-priority="1">發送時間</th>
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
        <script src="<?=version('assets/plugins/sweetalert/sweetalert2.js')?>"></script>
        <script src="<?=version('assets/js/common.js')?>"></script>
        <script type="text/javascript">
            var mail_record_ajax =   '/Backend/Mail/Record';
            Table.DrawTable =   function(){
                $.ajax({
                    url:mail_record_ajax,
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
                            str +='<td class="text-center"><span class="">'+e.id+'</span></td>';
                            str +='<td class="text-center">'+e.name+'/'+e.username+'</td>';
                            str +='<td class="text-center">'+e.title+'</td>';
                            str +='<td class="text-center"><div class="td_content">'+e.content+'</div></td>';
                            str +='<td class="text-center">'+e.create_time+'</td>';
                            str +='<td class="text-center">'+e.push_date+'</td>';
                            str +='</tr>';
                        });
                        $('.mail_record_list>tbody').html(str);
                        Page.DrawPage(data.total);
                        $('.table-responsive').responsiveTable('update');
                });
            }
            $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '焦點', display : '顯示', displayAll: '全部顯示'}});
            Table.LoadTable();
            
        </script>
    </body>
</html>