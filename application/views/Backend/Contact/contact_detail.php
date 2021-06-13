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
                                    <form enctype="multipart/form-data" method="post" name="addForm" action="" target="" data-parsley-validate novalidate>
                                    	<table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td class="middle-align" width="120">聯絡姓名：</td>
                                                    <td><?=$contact->name?></td>
                                                </tr>
                                                <!-- <tr>
                                                    <td class="middle-align">Line ID</td>
                                                    <td>testLineID</td>
                                                </tr> -->
                                                <tr>
                                                    <td class="middle-align">電子郵件：</td>
                                                    <td><?=$contact->email ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="middle-align">聯絡電話：</td>
                                                    <td><?=$contact->company?></td>
                                                </tr>
                                                <tr>
                                                    <td class="middle-align">手機號碼：</td>
                                                    <td><?=$contact->phone?></td>
                                                </tr>
                                                <tr>
                                                    <td class="middle-align">詢問內容：</td>
                                                    <td><?=$contact->content?></td>
                                                </tr>
                                                <tr>
                                                    <td class="middle-align">詢問時間：</td>
                                                    <td><?=$contact->date_add?></td>
                                                </tr>
                                                <tr>
                                                    <td class="middle-align">後台備註：</td>
                                                    <td>
                                                        <?php if(in_array(16, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <textarea class="form-control" rows="3" name="admin_note"><?=$contact->admin_note?></textarea>
                                                        <?php else: ?>
                                                        <?=$contact->admin_note?>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="center">
                                            <button type="button" onclick="history.go(-1)" class="btn btn-secondary waves-effect">回上一頁</button>
                                            <?php if(in_array(16, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                            <button type="submit" style="cursor: pointer;" class="btn btn-primary">儲存備註</button>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php if(in_array(18, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                            <div class="col-md-12">
                                <div class="card-box">
                                    <h6>內容將會直接回覆至客戶端信箱。</h6>
                                    <form enctype="multipart/form-data" method="post" id="emailForm" name="sendmail" action="" target="" data-parsley-validate novalidate>
                                        <?php if(!$contact->visit): ?>
                                        <input type="hidden" name="id" value="<?=$contact->id ?>">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td class="middle-align">預設寄件信箱：</td>
                                                    <td><input class="form-control" type="email" name="email" value="<?=$contact->email ?>" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td width="140" class="middle-align">管理員回覆：</td>
                                                    <td><textarea class="form-control" id="admin_mail_content" rows="3" name="content" required></textarea></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class='text-muted'>尚無回覆紀錄</div>
                                        <?php else: ?>
                                        <h6>回覆記錄</h6>
                                        <div class="" style="font-size: 17px;"><?=$contact->reply_title?>
                                            <div class="text-muted">
                                                <?=$contact->reply?>
                                            </div>
                                            <?=$contact->reply_date?>
                                        </div>
                                        <?php endif; ?>
                                        <div class="center">
                                            <button type="button" onclick="history.go(-1)" class="btn btn-secondary waves-effect">回上一頁</button>
                                            <?php if(!$contact->visit): ?>
                                            <button type="submit" style="cursor: pointer;"  class="btn btn-danger btn_sendMail">寄出回覆信件</button>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php endif; ?>
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
            <?php if(in_array(16, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var contact_ajax   =   '/Backend/Contact/Edit/';
            $('form[name=addForm]').submit(function(e){
                e.preventDefault();
                var form    =   $(this).serialize();
                $.ajax({
                    url:contact_ajax+<?=$contact->id?>,
                    type:'POST',
                    dataType:'JSON',
                    data:form+'&status=1',
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                });
            });
            <?php endif; ?>
            <?php if(in_array(18, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var replay_ajax   =   '/Backend/Contact/Reply/';
            $('form[name=sendmail]').submit(function(e){
                e.preventDefault();
                var form    =   $(this);
                var data    =   form.serialize();
                var id      =   $(this).find('input[name=id]').val();
                $.ajax({
                    url:replay_ajax+id,
                    type:'POST',
                    dataType:'JSON',
                    data:data,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            location.reload();
                        }
                });
            });
            <?php endif; ?>
        </script>
    </body>
</html>