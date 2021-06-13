 <?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <link rel="stylesheet" href="/assets/plugins/jquery.filer/css/jquery.filer.css" />
        <link rel="stylesheet" href="/assets/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" />
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link rel="stylesheet" href="/assets/plugins/slim/css/slim.min.css">
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
                                                        <th width="120" class="text-center" data-priority="1">會員類型</th>
                                                        <th width="250" class="text-center" data-priority="1">Email(帳號)</th>
                                                        <th width="" class="text-center" data-priority="1">會員名稱/暱稱</th>
                                                        <th width="180" class="text-center" data-priority="1">聊天點數</th>
                                                        <th width="170" class="text-center" data-priority="1">最後登入時間</th>
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

                        <?php if(in_array(25, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                        <div class="modal fade bs-example-modal-sm news_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form name="News_add">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mySmallModalLabel">新增會員</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <fieldset class="form-group">
                                                <label>手機號碼(帳號)<span class="text-danger">*</span></label>
                                                <input type="text" name="username" class="form-control" placeholder="請輸入手機號碼" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>會員名稱<span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control"  placeholder="請輸入會員名稱" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">密碼<span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" name="password" placeholder="請輸入(4~12位英數)" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">再次確認密碼<span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" name="passwords" placeholder="請輸入(4~12位英數)" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>Email<span class="text-danger"></span></label>
                                                <input type="email" name="email" class="form-control" placeholder="請輸入Email">
                                            </fieldset>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                            <button type="button" id="add_submit" class="btn btn-primary ">新增</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>

                        <div class="modal fade bs-example-modal-sm news_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form name="News_edit">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mySmallModalLabel">編輯會員</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <fieldset class="form-group">
                                                <label>手機號碼(帳號)<span class="text-danger">*</span></label>
                                                <input type="text" name="username" class="form-control" placeholder="請輸入手機號碼" required readonly>
                                                <input type="hidden" name="id">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>會員名稱<span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control"  placeholder="請輸入會員名稱" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">密碼<span class="text-danger"></span></label>
                                                <input type="password" class="form-control" name="password" placeholder="請輸入(4~12位英數)" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">再次確認密碼<span class="text-danger"></span></label>
                                                <input type="password" class="form-control" name="passwords" placeholder="請輸入(4~12位英數)" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>Email<span class="text-danger"></span></label>
                                                <input type="email" name="email" class="form-control" placeholder="請輸入Email">
                                            </fieldset>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                            <button type="button" id="edit_submit" class="btn btn-primary ">送出</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-example-modal-sm member_view" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form name="">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mySmallModalLabel">檢視會員資料</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class=""><!--公司-->
                                                <ul class="nav nav-tabs m-b-10" id="myTab" role="tablist">
                                                     <li class="nav-item"> <!-- 普通/個人/學生 就顯示 會員資料 與帳號資訊即可 -->
                                                        <a class="nav-link active" id="memberInfoView-tab" data-toggle="tab" href="#memberInfoView" role="tab" aria-controls="memberInfoView" aria-expanded="true">會員資料</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="loginInfoView-tab" data-toggle="tab" href="#loginInfoView" role="tab" aria-controls="loginInfoView">會員大頭照</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="descInfoView-tab" data-toggle="tab" href="#descInfoView" role="tab" aria-controls="descInfoView">帳號資訊</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div role="tabpanel" class="tab-pane fade in active show" id="memberInfoView" aria-labelledby="memberInfoView-tab">
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">會員Email(帳號)</div>
                                                            <div class="col-9" id="username">M000001</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">會員名稱</div>
                                                            <div class="col-9" id="name">R12345678</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">會員暱稱</div>
                                                            <div class="col-9" id="nickname">R12345678</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">國籍</div>
                                                            <div class="col-9" id="country_title"></div> <!-- 會員未綁定 顯示 "-" -->
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">性別</div>
                                                            <div class="col-9" id="sex">abc@mail.com</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">生日</div>
                                                            <div class="col-9" id="birthday"></div> <!-- 會員未綁定 顯示 "-" -->
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">身高</div>
                                                            <div class="col-9" id="height"></div> <!-- 會員未綁定 顯示 "-" -->
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">三圍</div>
                                                            <div class="col-9" id="measurement"></div> <!-- 會員未綁定 顯示 "-" -->
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">職業</div>
                                                            <div class="col-9" id="profession"></div> <!-- 會員未綁定 顯示 "-" -->
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">職業</div>
                                                            <div class="col-9" id="profession"></div> <!-- 會員未綁定 顯示 "-" -->
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">職業</div>
                                                            <div class="col-9" id="profession"></div> <!-- 會員未綁定 顯示 "-" -->
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">Facebook</div>
                                                            <div class="col-9" id="Facebook_path"></div> <!-- 會員未綁定 顯示 "-" -->
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">Instagram</div>
                                                            <div class="col-9" id="Instagram"></div> <!-- 會員未綁定 顯示 "-" -->
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">Youtube</div>
                                                            <div class="col-9" id="Youtube"></div> <!-- 會員未綁定 顯示 "-" -->
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">描述</div>
                                                            <div class="col-9" id="desc"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="loginInfoView" role="tabpanel" aria-labelledby="loginInfoView-tab">
                                                        <fieldset class="form-group col-xl-12" id="img">
                                                        </fieldset>
                                                    </div>
                                                    <div class="tab-pane fade" id="descInfoView" role="tabpanel" aria-labelledby="descInfoView-tab">
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">註冊日期</div>
                                                            <div class="col-9" id="create_date"></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">登入次數</div>
                                                            <div class="col-9" id="login_count"></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3 text-muted">最後登入時間</div>
                                                            <div class="col-9" id="login_date"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
        <script src="/assets/plugins/slim/js/slim.kickstart.min.js" type="text/javascript"></script>
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

            var member_ajax =   '/Backend/Member/Chat_point';
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
                            var line=(e.line)?'<span class="label label-success" style=" padding: 7px;font-size: 12px;">已綁定</span>':'<span style="background-color: #818a91; padding: 7px;font-size: 12px;" class="label label-default">未綁定</span>';
                            var google=(e.google)?'<span class="label label-danger" style=" padding: 7px;font-size: 12px;">已綁定</span>':'<span style="background-color: #818a91; padding: 7px;font-size: 12px;" class="label label-default">未綁定</span>';
                            var facebook=(e.facebook)?'<span class="label label-primary" style=" padding: 7px;font-size: 12px;">已綁定</span>':'<span style="background-color: #818a91; padding: 7px;font-size: 12px;" class="label label-default">未綁定</span>';
                            var type = (e.teacher_name)?'2':'1';
                            //data-toggle="modal" data-target=".member_view" data-id="${e.id}" class="view"
                            str +=`
                                <tr>
                                    <td class="text-center vertical-align-middle">${(((Page.page-1)*Page.row)+(i+1))}</td>
                                    <td class="text-center vertical-align-middle">${e.create_date}</td>
                                    <td class="text-center">
                                        Girl
                                    </td>
                                    <td class="text-center vertical-align-middle">
                                        ${e.username}
                                    </td>
                                    <td class="vertical-align-middle itemTitle text-left">
                                        <a href="javascript:;"  data-id="${e.id}" class="view">
                                            ${e.id2} ${e.name} / ${e.nickname}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" style="width:150px;text-align: center;"  data-id="${e.id}" style="text-center;" name="chat_point" class="form-control"  placeholder="" value="${e.chat_point}">
                                    </td>
                                    <td class="text-center">${e.login_date?e.login_date:'----'}</td>
                                </tr>
                            `;
                            // data-id="${e.id}" data-toggle="modal" data-target=".news_edit"
                        });
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

            $(document).on('blur','input[name="chat_point"]',function(){
                var id      =   $(this).attr("data-id");
                var chat_point  =   $(this).val();
                swal({
                    title:'確定變更聊天點數?',
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
                            data:{chat_point:chat_point},
                            success:function(result){
                                ResultData(result);
                            }
                        });
                    }
                });
            });

        </script>
    </body>
</html>