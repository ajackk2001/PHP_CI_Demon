<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <style type="text/css">
            .m-t-1{margin: 5px 0;}
            .c-select {
                display: inline-block;
                /*max-width: 100%;*/
                padding: .375rem 1.75rem .375rem .75rem;
                padding-right: .75rem \9;
                color: #55595c;
                vertical-align: middle;
                background: #fff url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAUCAMAAACzvE1FAAAADFBMVEUzMzMzMzMzMzMzMzMKAG/3AAAAA3RSTlMAf4C/aSLHAAAAPElEQVR42q3NMQ4AIAgEQTn//2cLdRKppSGzBYwzVXvznNWs8C58CiussPJj8h6NwgorrKRdTvuV9v16Afn0AYFOB7aYAAAAAElFTkSuQmCC) no-repeat right 0.75rem center;
                    background-size: auto;
                background-image: none \9;
                background-size: 8px 10px;
                border: 1px solid #ccc;
                -moz-appearance: none;
                -webkit-appearance: none;
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
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <form name="search">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-7 col-md-8 col-lg-7 col-xl-7 m-b-10">
                                                <div class="input-daterange input-group" id="date-range">
                                                    <input type="text" class="form-control day_start" name="date_start" placeholder="起始日期" data-de="<?=date('Y-m-d')?>" value="" readonly />
                                                    <span class="input-group-addon bg-custom b-0">～</span>
                                                    <input type="text" class="form-control day_end" name="date_end" placeholder="結束日期" data-de="<?=date('Y-m-d')?>" value="" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-3 col-md-2 col-xl-2 col-xl-2 m-b-10">
                                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light search">送出搜尋</button>
                                            </div>
                                            <div class="col-xs-6 col-sm-3 col-md-2 col-xl-2">
                                                <button type="button" class="btn btn-block btn-outline-secondary waves-effect reset">清空搜尋</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="clearfix">
                                    </div>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered member_list">
                                                <thead>
                                                <tr>
                                                    <th width="50" class="text-center" data-priority="1">#</th>
                                                    <th width="200" class="text-center" data-priority="1">時間</th>
                                                    <th class="text-center" data-priority="1">會員</th>
                                                    <th width="" class="text-center" data-priority="1">項目</th>
                                                    <th width="" class="text-center" data-priority="1">贈送對象</th>
                                                    <th width="100" class="text-center" data-priority="1">點數</th>
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
            Page.row = 10;

            var member_ajax =   '/Backend/Gift/Record';
            Table.DrawTable =   function(){
                var form    =   $('form[name=search]').serialize();
                $.ajax({
                    url:member_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:form+'&page='+Page.page+'&limit='+Page.row,
                    success:function(data){
                        str =   '';
                        $.each(data.list,function(i,e){
                            str+=`
                                 <tr>
                                    <td class="text-center">${(((Page.page-1)*Page.row)+(i+1))}</td>
                                    <td class="text-center">${e.date_add}</td>
                                    <td class="text-center" data-priority="1">${e.username+' / '+((e.name)?e.name:'---')+' / '+((e.nickname)?e.nickname:'---')}</td>
                                    <td width="" class="text-center" data-priority="1">
                                        ${e.title}
                                    </td>
                                    <td width="" class="text-center" data-priority="1">${e.away_username+' / '+((e.away_name)?e.away_name:'---')+' / '+((e.away_nickname)?e.away_nickname:'---')}</td>
                                    <td width="100" class="text-center" data-priority="1"><span class="" style="font-weight: bold;font-size: 16px;">${e.points}</span></td>
                                </tr>
                            `;
                        });
                        if(str=='')str=' <tr><td colspan="20" class="text-center" data-org-colspan="1" data-priority="1" data-columns="tech-companies-1-col-0" style="background-color: rgba(0,0,0,.05);">無內容</td></tr>';
                        $('.member_list>tbody').html(str);
                        $.each($('input[data-plugin=switchery]'),function(i,e){
                            new Switchery(e,{color:$('input[data-plugin=switchery]').eq(i).data('color'),size:$('input[data-plugin=switchery]').eq(i).data('size'),});
                        });
                        Page.DrawPage(data.total);
                        $('[data-toggle="tooltip"]').tooltip();
                        $('.table-responsive').responsiveTable('update');
                    }
                });
            }
            $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '焦點', display : '顯示', displayAll: '全部顯示'}});
            Table.LoadTable();
            $('form[name=search] input[name=search]').blur(function (){
                var phone = $(this).val();
                if(checkPhone(phone)){
                    if (phone.substring(0, 1) == 0) {
                      phone = phone.substring(1);
                    }
                    $(this).val(phone);
                }
            });
            $('#date-range').datepicker({
                toggleActive: true,
                format: 'yyyy-mm-dd',
            });

            $('form[name=search]').submit(function(){
                Page.page=1;
                Table.LoadTable();
                return false;
            });

            $('.reset').click(function(){
                $('form[name=search]')[0].reset();
                Page.page=1;
                Table.LoadTable();
            });

        </script>
    </body>
</html>