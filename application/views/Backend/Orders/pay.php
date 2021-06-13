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
                            <div class="col-sm-9 center">
                                <form enctype="multipart/form-data" method="post" id="addForm1" name="addForm1" action="" target="" data-parsley-validate novalidate>
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                <h5>金流設定</h5><hr>
                                                <table class="tablesaw table m-b-30 ">
                                                    <thead>
                                                        <tr>
                                                            <th width="70">啟用</th>
                                                            <th>名稱</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($shipment as $k=>$v): ?>
                                                        <tr>
                                                            <td>
                                                                <input class="publish status" type="checkbox" data-plugin="switchery" data-color="#64b0f2" data-size="small" <?php echo ($v->status==1) ? 'checked disabled': ''; ?> data-id="<?=$v->id?>"/>
                                                                <input type="hidden" name="id[<?=$k?>]" value="<?=$v->id?>">
                                                            </td>
                                                            <td><?=$v->title;?></td>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <div class="text-center m-t-30 m-b-30">
                                                    <button type="submit" class="btn btn-primary">確認送出</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
        <script src="<?=version('assets/plugins/ckeditor/ckeditor.js')?>"></script>
        <script src="<?=version('assets/plugins/ckfinder/ckfinder.js')?>"></script>
        <script type="text/javascript">
            var status_ajx  =   '/Backend/Orders/PayUpdate/';
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