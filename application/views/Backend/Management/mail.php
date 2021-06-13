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
                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                                        <input type="hidden" name="id" value="<?=$Mails->id?>">
                                        <form name="mail">
                                            <fieldset class="form-group">
                                                <label for="">主機位址</label>
                                                <input type="text" class="form-control" name="host" 
                                                       placeholder="主機位址" value="<?=$Mails->host?>">
                                                
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="">端口</label>
                                                <input type="text" class="form-control" name="port" 
                                                       placeholder="端口" value="<?=$Mails->port?>">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="">端口類型</label>
                                                <input type="text" class="form-control" name="port_type" 
                                                       placeholder="端口類型" value="<?=$Mails->port_type?>">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="">Email帳號</label>
                                                <input type="test" class="form-control" name="username" 
                                                       placeholder="Email帳號" value="<?=$Mails->username?>">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="">密碼</label>
                                                <input type="password" class="form-control" name="password" 
                                                       placeholder="密碼" value="<?=$Mails->password?>" autocomplete="current-password">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="">發信名稱</label>
                                                <input type="text" class="form-control" name="from_to" 
                                                       placeholder="發信名稱" value="<?=$Mails->from_to?>">
                                            </fieldset>
                                            <button type="submit" class="btn btn-primary">儲存</button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".send">發送信件測試</button>
                                        </form>
                                    </div><!-- end col -->
                                </div>
                            </div>
                        </div>
                        <!-- End of Row -->
                        <div class="modal fade bs-example-modal-sm send" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="mySmallModalLabel">發送測試電子郵件</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form name="send">
                                        <div class="modal-body">
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">電子郵件</label>
                                                <input type="text" name="email" class="form-control" placeholder="電子郵件">
                                            </fieldset>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                            <button type="submit" class="btn btn-primary">發送</button>
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
        <script src="<?=version('assets/plugins/sweetalert/sweetalert2.js')?>"></script>
        <script src="<?=version('assets/js/common.js')?>"></script>
        <script type="text/javascript">
            var mail_ajax   =   '/Backend/Management/MailEdit/';
            $('form[name=mail]').submit(function(e){
                e.preventDefault();
                var form    =   $(this).serialize();
                $.ajax({
                    url:mail_ajax+$('input[name=id]').val(),
                    type:'POST',
                    dataType:'JSON',
                    data:form,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                });
            });
            var send_ajax   =   '/Backend/Management/TestSend';
            $('form[name=send]').submit(function(e){
                e.preventDefault();
                var form    =   $(this).serialize();
                $.ajax({
                    url:send_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:form,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        $('.send').modal('hide');
                });
            });
        </script>
    </body>
</html>