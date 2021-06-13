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
                                    <div class="col-md-6 col-xs-12 m-t-20">
                                        <ul class="nav nav-tabs m-b-10" id="myTab" role="tablist">
                                            <?php
                                                foreach ($socials as $key   =>  $value) {
                                            ?>
                                                <li class="nav-item">
                                                    <a class="nav-link <?=(($key==0)?'active':'')?>" id="tab-<?=$key?>" data-toggle="tab" href="#tab<?=$key?>"
                                                       role="tab" aria-expanded="true" aria-controls="tab<?=$key?>"><?=$value->title?></a>
                                                </li>
                                            <?php
                                                }
                                            ?>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            
                                            <?php
                                                foreach ($socials as $key   =>  $social) {
                                            ?>
                                            
                                                <div role="tabpanel" class="tab-pane fade <?=(($key==0)?'in active show':'')?>" id="tab<?=$key?>" aria-labelledby="tab-<?=$key?>">
                                                    <h4><?=$social->title?></h4>
                                                    <form>
                                                        <?php 
                                                            foreach ($social as $field => $value) {
                                                                switch ($field) {
                                                                    case 'title':
                                                                        break;
                                                                    case 'id':
                                                        ?>
                                                                        <input type="hidden" name="<?=$field?>" value="<?=$value?>">
                                                        <?php
                                                                        break;
                                                                    default:
                                                                        if ($field == 'client_secret' || $field == 'redirect_url' || $field == 'status'){
                                                                            break;
                                                                        }
                                                        ?>
                                                                            <div class="form-group col-sm-10">
                                                                                <fieldset class="form-group">
                                                                                    <label ><?=$this->lang->line($field)?></label>
                                                                                    <input type="text" class="form-control" name="<?=$field?>" 
                                                                                           placeholder="" value="<?=$value?>">
                                                                                    
                                                                                </fieldset>
                                                                            </div>
                                                        <?php
                                                                        break;
                                                                }
                                                            }
                                                        ?>
                                                        <button type="submit" class="btn btn-primary">儲存</button>
                                                    </form>
                                                </div>
                                            
                                            <?php
                                                }
                                            ?>
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
            var social_ajax =   '/Backend/Management/SocialEdit/';
            $('form').submit(function(e){
                e.preventDefault();
                var form    =   $(this).serialize();
                var id      =   $(this).find('input[name=id]').val();
                $.ajax({
                    url:social_ajax+id,
                    type:'POST',
                    dataType:'JSON',
                    data:form+'&status='+(($(this).find('input.status').prop("checked"))?1:0),
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                });
                return false;
            });
        </script>
    </body>
</html>