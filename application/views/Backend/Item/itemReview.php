<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="/assets/plugins/sweetalert/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <style>
            .center {
                text-align: center;
            }
            .zmdi {
                font-size: 22px;
                color: rgba(43, 61, 81, 0.7);
            }
        </style>
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
                                    <form name="search">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-8 col-xl-4 m-b-10">
                                                <input name="search" class="form-control m-b-20" type="text" placeholder="可搜尋：會員帳號/姓名/暱稱/作品名稱" value="">
                                            </div>
                                            <div class="col-xs-6 col-md-4 col-xl-2 m-b-10">
                                                <select name="shop_status" class="form-control shop_status" id="exampleSelect1">
                                                    <option value="">-審核狀態-</option>
                                                    <option value="0">等待審核</option><!-- success -->
                                                    <option value="1">完成審核</option><!-- primary -->
                                                    <option value="2">資料有誤</option><!-- danger -->
                                                </select>
                                            </div>
                                            <div class="col-xs-6 col-sm-3 col-md-2 col-xl-2 col-xl-2 m-b-10">
                                                <button type="button" class="btn btn-block btn-primary waves-effect waves-light search">送出搜尋</button>
                                            </div>
                                            <div class="col-xs-6 col-sm-3 col-md-2 col-xl-2">
                                                <button type="button" class="btn btn-block btn-outline-secondary waves-effect reset">清空搜尋</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- <div class="clearfix">
                                        <button type="button" class="btn btn-custom waves-effect waves-light m-b-20" onclick="location.href='/Backend/Member/MemberAdd'">新增會員</button>
                                        <button type="button" class="btn btn-warning waves-effect waves-light pull-right" href="/admin/export/item_list" target="_blank">匯出資料</button>
                                    </div> -->
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered review_list">
                                                <thead>
                                                <tr>
                                                    <th width="50" class="text-center" data-priority="1">#</th>
                                                    <th class="center" data-priority="1">新增時間</th>
                                                    <th class="center" data-priority="1">會員帳號</th>
                                                    <th class="center" data-priority="1">會員姓名/暱稱</th>
                                                    <th class="center" data-priority="1">作品名稱</th>
                                                    <th class="center" data-priority="1">審核狀態</th>
                                                    <th class="center" data-priority="1">備註</th>
                                                    <th class="center" data-priority="1">審核人員</th>
                                                    <th class="center" data-priority="1">審核時間</th>
                                                    <th width="50" class="center" data-priority="1">操作</th>
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
        <script src="/assets/plugins/sweetalert/sweetalert2.js"></script>
        <script src="<?=version('style/admin/js/common.js')?>"></script>
        <script type="text/javascript">
            Page.row = 10;
            var review_status     =   {0:'等待審核',1:'審核通過',2:'審核不通過'};
            var sex             =   {0:'女',1:'男'};
            var review_ajax =   '/Backend/Item/ItemReview';
            Table.DrawTable =   function(){
                var form    =   $('form[name=search]').serialize();
                $.ajax({
                    url:review_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:form+'&page='+Page.page+'&limit='+Page.row,
                    success:function(data){
                        str =   '';
                        $.each(data.list,function(i,e){
                            color   =   '';
                            switch(e.review_status){
                                case '0':
                                    color   =   'text-warning';
                                break;
                                case '1':
                                    color   =   'text-success';
                                break;
                                case '2':
                                    color   =   'text-danger';
                                break;
                            }
                            str+=   '<tr>';
                            str +=  '<td class="text-center">'+(((Page.page-1)*Page.row)+(i+1))+'</td>';
                            str+=   '<td class="text-center">'+e.update_time+'</td>';
                            str+=   '<td class="text-center">'+e.username+'</td>';
                            str+=   '<td class="text-center">'+e.name+' / '+e.nickname+'</td>';
                            str+=   '<td class="text-center"><a href="/member/product/check/'+e.id+'" data-toggle="tooltip" data-animation="false" data-placement="left" title="點選至前台作品頁面" target="_blank">'+e.title+'</a></td>';
                            str+=   '<td class="text-center"><span class="'+color+'">'+review_status[e.review_status]+'</span></td>';
                            str+=   '<td class="text-center">'+(e.remark||'')+'</td>';
                            str+=   '<td class="text-center">'+(e.admin_name||'---')+'</td>';
                            str+=   '<td class="text-center">'+(Date.parse(e.result_date) ? e.result_date : '---')+'</td>';
                            str+=   '<td>';
                            if (e.review_status == 0||e.review_status == 2) {
                                str+=   '<a href="javascript:;" data-toggle="tooltip" data-animation="false" data-placement="left" title="審核通過"><i class="zmdi zmdi-check-square zmdi-hc-fw text-info pass" data-id="'+e.id+'"></i></a>';
                                str+=   '<a href="javascript:;" data-toggle="tooltip" data-animation="false" data-placement="left" title="審核不通過"><i class="zmdi zmdi-minus-square zmdi-hc-fw text-danger break" data-id="'+e.id+'"></i></a>';
                            }
                            str+=   '</td>';
                            str+=   '</tr>';
                        });
                        if(!str)str='<tr><td colspan="10" class="text-center">無資料</td></tr>';
                        $('.review_list>tbody').html(str);
                        Page.DrawPage(data.total);
                        $('[data-toggle="tooltip"]').tooltip();
                        $('.table-responsive').responsiveTable('update');
                    }
                });
            }
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
            $(document).on('click','i.pass',function() {
                var ajax_edit   = '/Backend/Item/ItemReview/';
                var id          = $(this).data('id');
                swal({
                    title:'確定審核通過?',
                    type:'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定',
                    cancelButtonText: '取消',
                }).then(function(result){
                    if(result.value){
                        $.ajax({
                            url         : ajax_edit + id,
                            type        : 'POST',
                            dataType    : 'JSON',
                            data        : {status : 1},
                            success:function(result){
                                ResultData(result);
                                //if(result.status)$('select[name=shop_status]').val(1);
                                Table.LoadTable();
                            }
                        });
                    }
                }).catch(swal.noop);
            });

            $(document).on('click','i.break',function() {
                var ajax_edit   = '/Backend/Item/ItemReview/';
                var id          = $(this).data('id');
                swal({
                    title: '請輸入拒絕原因',
                    input: 'text',
                    showCancelButton    : true,
                    confirmButtonText   : '確定',
                    cancelButtonText    : '取消',
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url         : ajax_edit + id,
                            type        : 'POST',
                            dataType    : 'JSON',
                            data        : {status : 2,remark : result.value},
                            success:function(result){
                                ResultData(result);
                                if(result.status)$('select[name=shop_status]').val(2);
                                Table.LoadTable();
                            }
                        });
                    }
                });
            });

            $(document).on('change','.shop_status',function(){
                Table.LoadTable();
            });
        </script>
    </body>
</html>