<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="<?= version('assets/plugins/hopscotch/css/hopscotch.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= version('assets/plugins/fileuploader2.2/dist/font/font-fileuploader.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= version('assets/plugins/fileuploader2.2/dist/jquery.fileuploader.min.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= version('assets/plugins/fileuploader2.2/css/jquery.fileuploader-theme-thumbnails.css') ?>" rel="stylesheet" type="text/css">
        <style type="text/css" media="screen">
            .reference {
                font-size: 0.4em;
                vertical-align: super;
            }
        </style>
    </head>
    <body class="fixed-left">
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

                        <div class="card-box">
                            <!-- input 在不符合需求時請自行設定大小 -->
                            <h2 class="h5" id="fileuploader-ajax">圖片上傳區<a href="javascript:;"  onclick="tour(fileuploader_ajax_tour)"><i class="ion-help-circled"></i></a></h2>
                            <div class="row mt-4">
                                <div class="col-12 col-md-6">
                                    <select id="selectData" name="date" class="form-control" onchange="location.href='/Backend/Albums/Photos/'+this.value">
                                    <option value="">-請選擇花絮-</option>
                                    <?php foreach ($selectData as $key => $value): ?>
                                        <?=$value->folder?>
                                        <option value="<?=$value->id?>" <?=($value->id==$selectAblums)? 'selected':'';?>><?=$value->title?></option>
                                    <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <?php if(!empty($selectAblums)):?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <form>
                                        <input type="file" name="files[]" data-fileuploader-files='<?= json_encode($fileuploaderImages) ?>'>
                                        <button class="btn btn-primary save_images" type="button">儲存圖片</button>
                                    </form>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>

                    </div> <!-- container -->
                </div> <!-- content -->
            </div> <!-- End content-page -->
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
        <script src="<?=version('assets/plugins/hopscotch/js/hopscotch.min.js')?>"></script>
        <script src="<?=version('assets/plugins/fileuploader2.2/dist/jquery.fileuploader.min.js')?>"></script>
        <script src="<?=version('assets/js/fileuploader-ajax-image.js')?>"></script>
        <script>
            let a = fileuploaderAjaxImage($('input[name="files[]"]'), {
                url: '/Backend/Albums/fileuploader_image_upload/'+$('select[name=date] :selected').val(),
                limit: null
            });
            $('.save_images').click(function(){
                waitingDialog.show();
                var selectedId = $('select[name=date] :selected').val();
                if(selectedId == undefined){
                    waitingDialog.hide();
                    result = {'status':false,'msg':'請選擇上傳區'};
                    ResultData2(result);
                }else{
                    var data = new FormData();
                    var api = $.fileuploader.getInstance($('input[name="files[]"]'));
                    var fileList = api.getFileList();
                    var _list = [];
                    var _editor = [];

                    $.each(fileList, function(i, item) {
                        _list.push(item.name);
                        _editor.push(item.editor);
                    });
                    // 使用者選取的圖片
                    data.append('fileuploader_images', JSON.stringify(_list));
                    // 使用者選取圖片的裁切資訊
                    data.append('fileuploader_editor', JSON.stringify(_editor));
                    // 新增的圖片
                    data.append('fileuploader_uploaded_images', JSON.stringify(api.getUploadedFiles().map(e=>e.name)));
                    $.ajax({
                        url: '/Backend/Albums/save_images/'+selectedId,
                        type: 'POST',
                        data: data,
                        processData: false,
                        contentType: false,
                    }).then((result) => {
                        waitingDialog.hide();
                        ResultData2(result);
                    })
                }

            })

            /* 說明 */
            function tour(which) {
                hopscotch.startTour(which);
            }

            var fileuploader_ajax_tour = {
                id: "fileuploader-ajax",
                steps: [
                    {
                        target: document.querySelector("#selectData"),
                        content: "「活動花絮」設定在<a href='/Backend/Albums'>HERE</a>",
                        placement: 'top',
                    },
                    {
                        target: document.querySelector(".fileuploader-thumbnails-input"),
                        content: "按下 + 選擇後圖片即時上傳至伺服器",
                        placement: 'top',
                    },
                    {
                        target: document.querySelector(".save_images"),
                        content: "按下儲存圖片儲存修改資訊，若未按儲存圖片，新增、刪除、裁切資訊將不記入資料庫",
                        placement: 'top',
                    },
                ],
            }
        </script>
    </body>
</html>
