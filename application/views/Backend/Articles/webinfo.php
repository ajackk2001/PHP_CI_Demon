<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="<?=version('assets/plugins/ckeditor5/ckeditor-styles.css')?>" rel="stylesheet">
        <style>
            .ck.ck-editor__main {
                height: 400px;
            }
            .ck.ck-editor__editable_inline {
                overflow: auto;
                height: 400px;
            }
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
                                	<div class="col-md-12 col-xs-12 m-t-20">
                                        <ul class="nav nav-tabs m-b-10" id="myTab" role="tablist">
                                            <?php
                                                foreach ($contents as $key   =>  $value) {
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
                                                foreach ($contents as $key   =>  $content) {
                                            ?>
                                            
                                                <div role="tabpanel" class="tab-pane fade <?=(($key==0)?'in active show':'')?>" id="tab<?=$key?>" aria-labelledby="tab-<?=$key?>">
                                                    <form>
                                                        <?php 
                                                            foreach ($content as $field => $value) {
                                                                switch ($field) {
                                                                    case 'id':
                                                        ?>
                                                                        <input type="hidden" name="<?=$field?>" value="<?=$value?>">
                                                        <?php
                                                                        break;
                                                                    case 'title':
                                                        ?>
                                                                        <input type="hidden" name="<?=$field?>" value="<?=$value?>">
                                                        <?php
                                                                        break;
                                                                    case 'content':
                                                        ?>
                                                                        <div class="form-group col-sm-12">
                                                                            <fieldset class="form-group">
                                                                                <textarea class="form-control" id="<?=$field.$content->id?>" name="content"><?=$value?></textarea>
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
        <script src="<?=version('assets/js/common.js')?>"></script>
        <script src="<?=version('assets/plugins/ckeditor5/ckeditor.js')?>"></script>
        <script type="text/javascript">
            //ckeditor5
            var cktoolbarOption = {
                toolbar:{items:["heading","fontSize","fontColor","fontBackgroundColor","removeFormat","|","outdent","indent","alignment","bold","italic","underline","strikethrough","link","bulletedList","numberedList","imageUpload","imageStyle:full","imageStyle:alignLeft","imageStyle:alignCenter","imageStyle:alignRight","mediaEmbed","blockQuote","insertTable","undo","redo"]},
                link: {addTargetToExternalLinks: true}, //自動變成外部連結
                mediaEmbed: {removeProviders: [ 'instagram', 'twitter', 'googleMaps', 'flickr', 'facebook' ]},
            };

            $.each($('textarea[name=content]'), function (i, e) { 
                ClassicEditor.create( e,cktoolbarOption ).then( editor => {window.content = editor;} ).catch( error => {console.error( error );} );
            });

            var web_content_ajax =   '/Backend/WebInfo/Edit/';
            $('form').submit(function(e){
                e.preventDefault();
                var form    =   $(this).serialize();
                var id      =   $(this).find('input[name=id]').val();
                $.ajax({
                    url:web_content_ajax+id,
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
        </script>
    </body>
</html>