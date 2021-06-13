<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="<?=version('assets/plugins/sweetalert/sweetalert2.min.css')?>" rel="stylesheet" type="text/css" />
        <link type="text/css" href="<?=version('assets/plugins/bootstrap3-editable/css/bootstrap-editable.css')?>" rel="stylesheet">
        <link type="text/css" href="<?=version('assets/plugins/select2/css/select2.min.css')?>" rel="stylesheet"></script>
        <link href="<?=version('assets/plugins/jquery.filer/css/jquery.filer.css')?>" rel="stylesheet" />
        <link href="<?=version('assets/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')?>" rel="stylesheet" />
        <link href="<?=version('assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css')?>" rel="stylesheet" />
        <link rel="stylesheet" href="/assets/plugins/slim/slim/slim.min.css">
    </head>
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
                                	<form name="save" class="form-horizontal">
                                		<div class="form-group row col-sm-8">
                                            <label class="col-sm-4 form-control-label"><?=$this->lang->line('icon')?></label>
                                            <div class="col-sm-8">
                                            	<div style="display:block">
                                            		<img src="<?=version(site_url($info->icon))?>" class="rounded d-block" >
                                            	</div>
                                                <div style="display:block">
                                                    <input type="file" name="icon" id="filer_input2" accept=".ico" style="width:100%">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row col-sm-8">
                                            <label class="col-sm-4 form-control-label"><?=$this->lang->line('img')?></label>
                                            <div class="col-sm-4">
                                                <input type="file" name="slim" id="addSlim" accept="image/png"/>
                                            </div>
                                        </div>
                                        <?php
                                            foreach ($info as $field => $value) {
                                                if(!in_array($field, ['id','icon','keyword','img'])){
                                        ?>
                                                    <div class="form-group row col-sm-8">
                                                        <label class="col-sm-4 form-control-label"><?=$this->lang->line($field)?></label>
                                                        <div class="col-sm-8">
                                                            <a href="#" id="<?=$field?>"
                                                                <?php if($field=='description'||$field=='ga_code'): ?>
                                                                    class="input-text" data-type="textarea"
                                                                <?php else: ?>
                                                                    class="input-text" data-type="text"
                                                                <?php endif; ?>
                                                              data-name="<?=$field?>" data-pk="1" data-title="<?=$this->lang->line($field)?>"><?=htmlspecialchars($value)?></a>
                                                        </div>
                                                    </div>
                                        <?php
                                                }
                                            }
                                        ?>
                                        <div class="form-group row col-sm-8">
                                            <label class="col-sm-4 form-control-label"><?=$this->lang->line('keyword')?></label>
                                            <div class="col-sm-8">
                                                <input type="text" value="<?=$info->keyword?>" name="keyword" data-role="tagsinput" placeholder="輸入後按Enter"/>
                                            </div>
                                        </div>
                                        <?php if(in_array(58, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                        <button type="submit" class="btn btn-primary">儲存</button>
                                        <?php endif; ?>
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
        <script src="<?=version('assets/plugins/sweetalert/sweetalert2.js')?>"></script>
        <script src="<?=version('assets/js/common.js')?>"></script>
        <script src="<?=version('assets/plugins/moment/moment.js')?>"></script>
        <script src="<?=version('assets/plugins/select2/js/select2.full.min.js')?>"></script>
        <script type="text/javascript" src="<?=version('assets/plugins/bootstrap3-editable/js/bootstrap-editable.js')?>"></script>
        <script src="<?=version('assets/plugins/jquery.filer/js/jquery.filer.min.js')?>"></script>
        <script src="<?=version('assets/pages/jquery.fileuploads.init.js')?>"></script>
        <script src="<?=version('assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js')?>"></script>
        <script src="/assets/plugins/slim/slim/slim.kickstart.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            let slimOption = {
                forceSize: {
                    width: 200,
                    height: 65,
                },
                label:'首頁LOGO',
                maxFileSize:'8'
            };

            let addSlim = new Slim(document.getElementById('addSlim'),slimOption);
            <?php if (file_exists(".".$info->img)): ?>
                addSlim.load('<?=$info->img?>');
            <?php endif ?>

            <?php if(in_array(58, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
             $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary editable-submit waves-effect waves-light"><i class="zmdi zmdi-check"></i></button>' +
                                        '<button type="button" class="btn editable-cancel btn-secondary waves-effect"><i class="zmdi zmdi-close"></i></button>';
            $('.input-text').editable({
             type: 'text',
             mode: 'inline'
            }).on('shown', function(e) {
                $('textarea').attr('cols',70);
            });
            // $('#keyword').editable({
            // 	mode: 'inline',
            // 	tpl:'<input type="text" value="Amsterdam,Washington,Sydney" data-role="tagsinput" placeholder="add tags"/>',

            // });
            // function readURL(input){
            //     if(input.files && input.files[0]){
            //         var reader = new FileReader();
            //         reader.onload = function (e) {
            //             console.log(e.target.result);
            //             $(".rounded").attr('src', e.target.result);
            //         }
            //         reader.readAsDataURL(input.files[0]);
            //     }
            // }
            // $('#filer_input2').change(function(e){
            //     readURL(this);
            //     $(this).hide();
            // })
            var setting_ajax    =   '/Backend/Management/EditSetting/<?=$info->id?>';
            $('form[name=save]').submit(function(e) {
                e.preventDefault();
            	var form 	= 	new FormData(this);
            	$.each($('.input-text').editable('getValue'),function(i,e){
            		form.append(i,e);
            	});
                $.ajax({
                    url:setting_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:form,
                    processData: false,
                    contentType: false,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                });
            });
            <?php endif; ?>
        </script>
    </body>
</html>