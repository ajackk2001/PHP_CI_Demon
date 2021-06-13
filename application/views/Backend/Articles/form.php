<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link rel="stylesheet" href="/assets/plugins/slim/css/slim.min.css">
        <style type="text/css">
            select.form-control{margin-bottom: 0.5rem !important;}
            .form-text {display: block;margin-top: 0.25rem;font-size: 15px;line-height: 1.2;margin: 4px 5px;}
            .text-danger {color: #dc3545 !important;}
            .mapinfo {float: right;display: inline;margin: 10px 0 30px 0;}
            label {font-weight: 500;}
            .btn-primary{cursor: pointer;}
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
                                	<form enctype="multipart/form-data" name="register" action="" target="" data-parsley-validate novalidate>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                <div class="row">
                                                    <div class="form-group col-xs-12 col-sm-12 col-md-8 col-xl-8">
                                                        <label>內容</label><span class="text-danger"></span>
                                                        <input type="text" name="content" class="form-control"  placeholder="" required value="<?=$list->content?>">
                                                    </div>
                                                    <div class="form-group col-xs-12 col-sm-12 col-md-8 col-xl-8">
                                                        <label>連結網址</label><span class="text-danger"></span>
                                                        <input type="url" name="weblink" class="form-control" id="addWeblink" placeholder="<?=$list->weblink?>" >
                                                    </div>
                                                </div>
                                                <div class="center m-t-30">
                                                    <button type="submit" class="btn btn-primary">確認送出</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
        <script src="/assets/plugins/slim/js/slim.kickstart.min.js" type="text/javascript"></script>

        <script type="text/javascript">
            var register_ajax   =   '/Backend/About/EditForm';
            $('form[name=register]').submit(function(){
                if($(".slim-btn-group").css("display")=='none'){
                    swal({
                        type:'warning',
                        title: "請上傳圖片",
                        confirmButtonText: '關閉',
                    });
                    return false;
                }

                var form    =   $(this);
                var data    =   form.serialize();
                swal({
                    title:'確定更新內容嗎?',
                    type:'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定',
                    cancelButtonText: '取消',
                }).then(function(dismiss){
                    if (dismiss.value) {
                        $.ajax({
                            url:register_ajax,
                            type:'POST',
                            dataType:'JSON',
                            data:data,
                            // processData: false,
                            // contentType: false,
                            beforeSend:function(){//表單發送前做的事
                                waitingDialog.show();
                            },
                            complete: function () {
                              waitingDialog.hide();
                            },
                            success:function(result){
                                ResultData(result);
                            }
                        });
                    }
                });
                return false;
            });
        </script>
    </body>
</html>