<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="<?=version('assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=version('assets/plugins/multiselect/css/multi-select.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=version('assets/plugins/select2/css/select2.min.css')?>" rel="stylesheet" type="text/css" />
          <link href="<?=version('assets/css/style2.css')?>" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .form-control {font-size: 15px;}
            .ms-container {max-width: 1200px !important;}
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
                        <form enctype="multipart/form-data" method="post" id="addForm" name="addForm" action="" target="" data-parsley-validate novalidate>
                            <input type="hidden" name="formCheck" value="TRUE">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box">
                                        <div class="col-md-12 col-xs-12 m-t-20">
                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                <div class="row">
                                                    <div class="form-group col-xs-6">
                                                        <label>類型</label>
                                                        <div>
                                                          <div class="radio-inline group_type ">
                                                              <input type="radio" name="group_type" id="all" value="all" checked>
                                                              <label for="all">全部會員</label>
                                                          </div>
                                                          <div class="radio-inline group_type">
                                                              <input type="radio" name="group_type" id="select" value="select">
                                                              <label for="select">各別會員</label>
                                                          </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="member_select" class="row m-b-2 hide">
                                                    <div class="col-xs-12">
                                                        <select name="member_select[]" class="multi-select" multiple="" id="my_multi_select3">
                                                            <?php foreach ($member_select as $key => $v): ?>
                                                                <option value="<?=$v->id?>"><?=$v->username?> / <?=(($v->name)?$v->name:'---')?> / <?=(($v->nickname)?$v->nickname:'---')?></option>
                                                            <?php endforeach ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <div class="row">
                                                    <fieldset class="form-group col-xs-4">
                                                        <div class="checkbox checkbox-success checkbox-inline">
                                                            <input type="checkbox" class="send_email" id="send_email" name="send_email" value="1">
                                                            <label for="send_email"> 發送信件 <a data-toggle="tooltip" data-placement="right" title="是否發送信件通知會員" href="javascript:;" ><i class="ion-information-circled"></i></a></label>
                                                        </div>
                                                    </fieldset>
                                                </div> -->
                                                <label style="margin-bottom:10px; ">點數</label>
                                                <div class="row">
                                                    <fieldset class="form-group col-xs-12 col-md-12 col-lg-12 col-xl-6" required style="padding:0;">
                                                        <div class="col-xs-12 col-md-6 col-lg-4 type">
                                                            <select class="c-select form-control" name="type" id="type" required>
                                                                <option value="">--類型--</option>
                                                                <option value="7">贈送</option>
                                                                <option value="2">扣除</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-md-6 col-lg-4">
                                                            <input type="text" class="form-control" name="points" parsley-trigger="change" placeholder="點數" onkeyup="value=this.value.replace(/\D+/g,'')" required>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                                <!-- <div class="row date_exp">
                                                    <fieldset class="form-group col-xs-12 col-md-4">
                                                        <label>有效日期</label>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control datepicker" id="date_exp" name="date_exp" value="<?=date('Y-m-d')?>">
                                                            <span class="input-group-addon"><i class="icon-calender "></i></span>
                                                        </div>
                                                    </fieldset>
                                                </div> -->
                                                <div class="row">
                                                    <fieldset class="form-group col-xs-12 col-md-12 col-lg-12 col-xl-6" required>
                                                        <label for="exampleTextarea">備註</label>
                                                        <textarea class="form-control" name="remark" id="remark" rows="3" required></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="center">
                                <button type="button" onclick="history.back();" class="btn btn-secondary waves-effect">回上一頁</button>
                                <button type="submit" class="btn btn-primary">確認送出</button>
                            </div>
                        </form>
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
        <script src="<?=version('assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js')?>"></script>
        <script src="<?=version('assets/plugins/jquery-quicksearch/jquery.quicksearch.js')?>" type="text/javascript"></script>
        <script src="<?=version('assets/plugins/select2/js/select2.full.min.js')?>" type="text/javascript"></script>
        <script src="<?=version('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')?>" type="text/javascript"></script>

        <script type="text/javascript" src="<?=version('assets/plugins/multiselect/js/jquery.multi-select.js')?>"></script>
        <script type="text/javascript" src="<?=version('assets/plugins/autocomplete/jquery.mockjax.js')?>"></script>
        <script type="text/javascript" src=" <?=version('assets/plugins/autocomplete/jquery.autocomplete.min.js')?>"></script>
        <script type="text/javascript" src="<?=version('assets/plugins/autocomplete/countries.js')?>"></script>
        <!-- <script type="text/javascript" src="<?=version('assets/pages/jquery.autocomplete.init.js')?>"></script> -->
        <script type="text/javascript" src="<?=version('assets/pages/jquery.formadvanced.init.js')?>"></script>

        <script type="text/javascript" src="<?=version('assets/plugins/parsleyjs/v2.8.1/parsley.min.js')?>"></script>
        <script type="text/javascript" src="<?=version('assets/plugins/parsleyjs/language/zh_TW.js')?>"></script>
        <script type="text/javascript">
            //-*-*-*-*-*- 會員類型
            $('.group_type').click(function(event) {
                var $group_type = $('input[name="group_type"]:checked').val();
                if($group_type == 'all'){
                    $('#member_select').hide();
                    $('#member_type_select').hide();
                    $('#member_type_csv').hide();
                }
                if($group_type == 'type'){
                    $('#member_type_select').fadeIn(400);
                    $('#member_select').hide();
                    $('#member_type_csv').hide();
                }
                if($group_type == 'select'){
                    $('#member_type_csv').hide();
                    $('#member_type_select').hide();
                    $('#member_select').fadeIn(400);
                }
                if($group_type == 'csv'){
                    $('#member_select').hide();
                    $('#member_type_select').hide();
                    $('#member_type_csv').fadeIn(400);
                }
            });
            $('form[name=addForm]').submit(function(){
                var register_ajax   =   '/Backend/Points/Add';
                if($(this).parsley().isValid()){
                    var form =  $(this).serialize();
                    swal({
                        title: '確認送出?',
                        text: "",
                        type:'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '確定',
                        cancelButtonText: '取消',
                    }).then(function(result){
                        if(result.value){
                            $.ajax({
                                url:register_ajax,
                                type:'POST',
                                dataType:'JSON',
                                data:form,
                                beforeSend:function(){//表單發送前做的事
                                    waitingDialog.show();
                                },
                                complete: function () {
                                  waitingDialog.hide();
                                },
                                success:function(result){
                                    ResultData(result);
                                    if(result.status&&result.redirect){
                                        setTimeout(function(){ window.location.href =result.redirect; }, 1000);
                                    }
                                }
                            });
                        }
                    });
                }
                return false;
            });
        </script>
    </body>
</html>