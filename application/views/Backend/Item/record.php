<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="<?=version('assets/plugins/sweetalert/sweetalert2.min.css')?>" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .label{font-size: 12px;}
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
                                            <div class="col-xs-12 col-md-8 col-xl-5">
                                                <input name="search" class="form-control m-b-20" type="text" placeholder="可搜尋Girl/創作者 會員資訊：帳號/姓名/暱稱">
                                            </div>
                                            <div class="col-xs-12 col-md-8 col-xl-5">
                                                <input name="search2" class="form-control m-b-20" type="text" placeholder="可搜尋作品資訊：作品名稱">
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
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered type_list">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" data-priority="1">時間</th>
                                                        <th class="text-center" data-priority="1">會員帳號 / 名稱 / 暱稱</th>
                                                        <th class="text-center" data-priority="1">主/次分類</th>
                                                        <th class="text-center" data-priority="1">尺度分類</th>
                                                        <th class="text-center" data-priority="1" width="250">作品名稱</th>
                                                        <th class="text-center" data-priority="1">金額(USD)</th>
                                                        <th class="text-center" data-priority="1">點數</th>
                                                        <th width="70" class="text-center" data-priority="1">上下架</th>
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
            Page.row = 10;
            var type_ajax =   '/Backend/Item/Item';
            Table.DrawTable =   function(){
                var form    =   $('form[name=search]').serialize();
                $.ajax({
                    url:type_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:form+'&page='+Page.page+'&limit='+Page.row,
                    success:function(data){
                        str =   '';
                        $.each(data.list,function(i,e){
                        	var point = (e.point>=0)?'-'+Math.abs(e.point):Math.abs(e.point);
                            var name = (e.type==4)?e.pay_name+' / '+e.pay_phone:e.m_username+' / '+((e.m_name)?e.m_name:'---')+' / '+((e.m_phone)?'0'+e.m_phone:'---');
                            str +='<tr>';
                            str +='<td class="text-center">'+e.update_time+'</td>';
                            str +='<td class="text-center">'+`${e.username+' / '+e.name+' / '+e.nickname}`+'</td>';
                            str +='<td class="text-center">'+`${e.type_title} / ${e.category_title}`+'</td>';
                            str +='<td class="text-center">'+`${e.scale_title}`+'</td>';
                            str +=`<td class="text-center" style="text-overflow: ellipsis;white-space: nowrap;cursor: default; " title="${e.title}"><a href="/album/detail/${e.id}" style="width: 250px;display: block;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" target="_blank">${e.title}</a></td>`;
                            str +='<td class="text-center"><span class="">'+e.USD2+'</span></td>';
                            str +='<td class="text-center"><span class="">'+e.points+'</span></td>';
                            str +='<td class="text-center"><input class="status" type="checkbox" '+((e.status==1)?'checked':'')+' data-id="'+e.id+'" data-plugin="switchery" data-color="#64b0f2" data-size="small"></td>';
                            str +='</tr>';
                            //console.log();
                        });
                        $('.type_list>tbody').html(str);
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

            function statusTag(statusNumber)
            {
                switch (statusNumber) {
                    case '5':
                        return '<span class="label label-success" style="background-color:#978e8e;">退貨完成</span>'
                        break;
                    case '1':
                        return '<span class="label label-success">交易完成</span>'
                        break;
                    case '2':
                        return '<span class="label label-danger">交易失敗</span>'
                        break;
                    case '0':
                        return '<span class="label label-warning">待付款</span>'
                        break;
                    case '3':
                        return '<span class="label label-danger">取消交易</span>'
                        break;
                    // case '4':
                    //     return '<span class="label label-success">退款+</span>'
                    //     break;
                    // case '6':
                    //     return '<span class="label label-success">紅包+</span>'
                    //     break;
                    // case '7':
                    //     return '<span class="label label-success">回饋+</span>'
                    //     break;
                    default:
                        return '其他';
                        break;
                }
            }
            function payTypeTag(payTypeNumber){
                switch (payTypeNumber) {
                    case '4':
                        return '<span class="label label-primary">快速付款</span>'
                        break;
                    case '2':
                        return '<span class="label label-info">朋有支付</span>'
                        break;
                    case '3':
                        return '<span class="label label-danger">Punkcoco抵扣</span>'
                        break;
                    case '5':
                        return '<span class="label label-success" style="background-color:#978e8e;">退貨</span>'
                        break;
                    default:
                        return '其他';
                        break;
                }
            }

            $('#date-range').datepicker({
                toggleActive: true,
                format: 'yyyy-mm-dd',
            });

            $('form[name=search] input[name=search],form[name=search] input[name=search2]').blur(function (){
                var phone = $(this).val();
                if(checkPhone(phone)){
                    if (phone.substring(0, 1) == 0) {
                      phone = phone.substring(1);
                    }
                    $(this).val(phone);
                }
            });

            $('form[name=search]').submit(function(){
                Page.page=1;
                Table.LoadTable();
                return false;
            });

            $('.reset').click(function(){
                $('form[name=search]')[0].reset();
                Table.LoadTable();
                return false;
            });

            var status_ajx  =   '/Backend/Item/UpdateStatus/';
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
        </script>
    </body>
</html>
