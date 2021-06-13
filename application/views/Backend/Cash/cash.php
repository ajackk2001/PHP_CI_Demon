 <?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <link rel="stylesheet" href="/assets/plugins/jquery.filer/css/jquery.filer.css" />
        <link rel="stylesheet" href="/assets/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" />
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <style type="text/css">
            .table td, .table th {
                vertical-align: middle;
            }
            .mb-2 {
                margin-bottom: 12px !important;
                line-height: 25px;
            }
            input.error {
                background: rgb(251, 227, 228);
                border: 1px solid #fbc2c4;
                color: #8a1f11;
            }
            label.error {
                color: #8a1f11;
                display: inline-block;
                margin-left: 1.5em;
            }
        </style>

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

                        <!-- <div class="row">
                            123
                        </div> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box" style="">
                                    <form name="search" class="m-b-10">
                                        <div class="row">
                                            <div class="col-12  col-sm-6 col-md-4 col-xl-3 mb-3 mb-sm-0">
                                                <input name="search" class="form-control" type="text" placeholder="搜尋:會員名稱 / 暱稱 / Email">
                                            </div>
                                            <div class="col-6 col-sm-3 col-md-2 col-xl-2 col-xl-2">
                                                <button type="button" class="btn btn-block btn-primary waves-effect waves-light search">送出搜尋</button>
                                            </div>
                                            <div class="col-6 col-sm-3 col-md-2 col-xl-2">
                                                <button type="button" class="btn btn-block btn-outline-secondary waves-effect reset">清空搜尋</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="clearfix">
                                        <!-- <button type="button" class="btn btn-warning waves-effect waves-light pull-right" href="/admin/export/item_list" target="_blank">匯出資料</button> -->
                                    </div>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered member_list">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="50" data-tablesaw-sortable-col data-tablesaw-priority="1" data-priority="1">#</th>
                                                        <th width="150" class="text-center" data-priority="1">註冊日期</th>
                                                        <th width="200" class="text-center" data-priority="1">會員類型</th>
                                                        <th width="250" class="text-center" data-priority="1">Email(帳號)</th>
                                                        <th width="" class="text-center" data-priority="1">會員名稱/暱稱</th>
                                                        <th width="100" class="text-center" data-priority="1">全部收入</th>
                                                        <th width="100" class="text-center" data-priority="1">已提領金額</th>
                                                        <th width="100" class="text-center" data-priority="1">目前帳戶金額</th>
                                                        <th width="170" class="text-center" data-priority="1">檢視</th>
                                                    </tr>
                                                </thead>
                                                <tbody><!-- 依照註冊日期做排序 -->
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
        <script src="/assets/plugins/jquery.filer/js/jquery.filer.js"></script>
        <script src="/assets/plugins/moment/moment.js"></script>

        <script src="/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>

        <script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

        <script src="/assets/plugins/jquery-validation/dist/jquery.validate.js" type="text/javascript"></script>
        <script src="/assets/plugins/jquery-validation/src/localization/messages_zh_TW.js"></script>
        <script>

            //驗證手機號碼
            jQuery.validator.addMethod("isPhone", function(value, element) {
                if (!(/^09\d{8}$/).test(value)) {
                    return false;
                } else {
                    return true;
                }
            }, "請填寫正確的手機號碼");//可以自定義默認提示信息

            $('form[name=News_add]').validate({
                rules: {
                    'username': { //
                        required: true,
                        isPhone: true,
                    },
                },
            });


            $('#date-range').datepicker({
                toggleActive: true,
                format: 'yyyy-mm-dd',
            });
            Page.row = 10;

            var member_ajax =   '/Backend/Cash/Item';
            Table.DrawTable =   function(){
                var form    =   $('form[name=search]').serialize();
                $.ajax({
                    url:member_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:form+'&page='+Page.page+'&limit='+Page.row,
                    success:function(data){
                        var str =   '';
                        $.each(data.list,function(i,e){
                            var Total='<span class="text-success" style="font-weight: bold;font-size: 16px;">'+Math.round(e.Total*10)/10+'</span>';
                            var cashTotal='<span class="text-danger" style="font-weight: bold;font-size: 16px;">'+e.cashTotal+'</span>';
                            var incomeTotal='<span class="text-primary" style="font-weight: bold;font-size: 16px;">'+Math.round(e.incomeTotal*10)/10+'</span>';
                           // var type = (e.teacher_name)?'2':'1';
                            //data-toggle="modal" data-target=".member_view" data-id="${e.id}" class="view"
                            str +=`
                                <tr>
                                    <td class="text-center vertical-align-middle">${(((Page.page-1)*Page.row)+(i+1))}</td>
                                    <td class="text-center vertical-align-middle">${e.create_date}</td>
                                    <td class="text-center">
                                        ${TypeTag(e.type)}
                                    </td>
                                    <td class="text-center vertical-align-middle">
                                        ${e.username}
                                    </td>
                                    <td class="vertical-align-middle itemTitle text-center">
                                        ${e.name} / ${e.nickname}
                                    </td>
                                    <td class="text-center">${incomeTotal}</td>
                                    <td class="text-center">${cashTotal}</td>
                                    <td class="text-center">${Total}</td>
                                    <td class="text-center"><a href="/Backend/Cash/income/${e.id}" target="_blank"  data-toggle="tooltip" data-animation="false" data-placement="left" title="檢視該會員收入提領明細"><i class="zmdi zmdi-assignment-account text-info"></i></a></td>
                                </tr>
                            `;
                            // data-id="${e.id}" data-toggle="modal" data-target=".news_edit"
                        });
                        console.log(str);
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
            $('.search').click(function(){
                Page.page=1;
                Table.LoadTable();
            });
            $('.reset').click(function(){
                $('form[name=search]')[0].reset();
                Table.LoadTable();
            });

            jQuery('#date-range').datepicker({
                toggleActive: true
            });




            $(document).on('click','.view',function(){
                var news_info_ajax  =   '/Backend/Member/Info/';
                $.ajax({
                    url:news_info_ajax+$(this).data('id'),
                    type:'GET',
                    dataType:'JSON',
                    success:function(data){
                        $.each(data,function(key,value){
                            if(key=='line'){
                                value=(value)?'<span style="font-size: 12px;" class="label label-success">已綁定</span>':'<span style="background-color: #818a91;font-size: 12px;" class="label label-default">未綁定</span>';
                            }else if(key=='name'){
                                value=data.id2+' '+value;
                            }else if(key=='sex'){
                                if(value ==0)value="尚無資料";
                                if(value ==1)value="男";
                                if(value ==2)value="女";
                            }else if(key=='birthday'){
                                if(!value||value=='0000-00-00')value="尚無資料";
                            }else if(key=='img'){
                                //console.log('123');
                                value = `<img src="${value}" alt=""/ style="width: 100%">`;
                            }else if(key=='desc'){
                                value=`
                                    <textarea name="desc" cols="30" rows="5" class="form-control" required>${value}</textarea>
                                `;
                            }else{
                                if(!value)value='尚無資料';
                            }
                            $('.member_view #'+key).html(value);
                        });
                    }
                });
                $('.member_view').modal('show');
            });

            $(document).on('change','.type',function(){
                var id      =   $(this).attr("data-id");
                var type  =   $(this).val();
                swal({
                    title:'確定變更會員類型?',
                    type:'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定',
                    cancelButtonText: '取消',
                    allowOutsideClick:false,
                }).then(function(result){
                    if(result.value){
                        $.ajax({
                            url:'/Backend/Member/Edit/'+id,
                            type:'POST',
                            dataType:'JSON',
                            data:{type:type},
                            success:function(result){
                                ResultData(result);
                            }
                        });
                    }
                });
            });


            function TypeTag(payTypeNumber){
              switch (payTypeNumber) {
                case '3':
                    return '創作者';
                    break;
                case '2':
                    return 'Girl';
                    break;
              }
        }



        </script>
    </body>
</html>