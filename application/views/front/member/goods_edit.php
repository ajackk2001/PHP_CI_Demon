<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('front/include/layout_head');?>
    <title><?=$this->web_title?></title>

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/jquery.scrollbar.css">
    <link rel="stylesheet" href="/assets/plugins/adminLTE/css/adminlte.css">

    <link rel="stylesheet" href="/assets/plugins/slim/slim/slim.min.css">
    <link rel="stylesheet" href="<?=version('assets/css/front/style.css')?>">
    <link href="<?=version('assets/plugins/ckeditor5/ckeditor-styles.css')?>" rel="stylesheet">
    <link href="<?= version('assets/plugins/fileuploader2.2/dist/font/font-fileuploader.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= version('assets/plugins/fileuploader2.2/dist/jquery.fileuploader.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= version('assets/plugins/fileuploader2.2/css/jquery.fileuploader-theme-thumbnails.css') ?>" rel="stylesheet" type="text/css">
    <style type="text/css">
        .slim-btn-group button {
            display:inline-block;
        }
        .redtxt {
            color: #e61f6e;
            padding-right: 5px;
        }
        input.error,input:focus.error , textarea.error,textarea:focus.error,select.error,select:focus.error{
            background: rgb(251, 227, 228);
            border: 1px solid #fbc2c4;
            color: #8a1f11;
        }
        label.error {
            color: #8a1f11;
            display: block;
            margin-left: 10px;
            margin-top: 5px;
        }
        .video_css{
            opacity: 0;
            width: 100%;
            position: absolute;
            left: 41px;
            z-index: 1000;
            cursor: pointer;
        }
        .video_icon{
            position: absolute;
            bottom: 50px;
            left: 53px;
            z-index: 0;
        }
        .video_info , .video_info2{
            max-height: 315px;
        }
        video{
            width: 100%;
            max-height: 300px;
        }
    </style>
</head>
<body>
    <?php //$this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <div class="container-fluid">
            <div class="inner">
                <div class="content">
                    <div class="card">
                        <div class="card-header">作品上架</div>
                        <div class="card-body wizard">
                            <div class="wizard-inner">
                                <div class="connecting-line"></div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>作品設定</i></a>
                                    </li>
                                    <li role="presentation" class="disabled">
                                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i>影片設定</i></a>
                                    </li>
                                    <li role="presentation" class="disabled">
                                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span> <i>寫真設定</i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="step1">
                <section class="product_add">
                    <div class="container-fluid">
                        <div class="inner">
                            <div class="content">
                                <div class="row">
                                    <div class="TopBox col-12 col-md-3">
                                        <div class="Avatar" style="margin: 0 auto;">
                                            <?php if (!empty($member->img)): ?>
                                                <img src="<?=$member->img?>" class="rounded-circle">
                                            <?php else: ?>
                                                <img src="/assets/images/front/member_default.jpg" class="rounded-circle">
                                            <?php endif ?>
                                        </div>
                                        <div class="UserInfo">
                                            <h1><?=$this->session->userdata('user')['nickname']?></h1>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-9">

                                        <form action="" name="add">
                                            <?php if ($item->review_status==2): ?>
                                                <div class="row">
                                                    <div class="col-12" style="margin-bottom: 15px;">
                                                        <span class="badge bg-secondary" style="margin-bottom:8px;background: #a71717 !important;">審核未通過</span>
                                                        <p><?=$item->remark?></p>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt">※</span>作品封面</label>
                                                    <input type="file" name="slim" id="addSlim" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt">※</span>主分類</label>
                                                    <select name="type_id" id="" class="form-control" required>
                                                        <option value="">請選擇主分類</option>
                                                        <?php foreach ($type as $key => $value) : ?>
                                                            <option value="<?=$value->id?>" <?=$value->id==$item->type_id?'selected="selected"':''?>><?=$value->title?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt">※</span>次分類</label>
                                                    <select name="category_id" id="" class="form-control category" required>
                                                        <option value="">請選擇次分類</option>
                                                    </select>
                                                    <select name="" id="category_id" class="form-control d-none">
                                                        <option value="">請選擇次分類</option>
                                                        <?php foreach ($category as $key => $value) : ?>
                                                            <option value="<?=$value->id?>" data-type_id="<?=$value->type_id?>" <?=$value->id==$item->category_id?'selected="selected"':''?>><?=$value->title?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt">※</span>尺度分類</label>
                                                    <select name="scale_id" id="" class="form-control" required>
                                                        <option value="">請選擇尺度</option>
                                                        <?php foreach ($scale as $key => $value) : ?>
                                                            <option value="<?=$value->id?>" <?=$value->id==$item->scale_id?'selected="selected"':''?>><?=$value->title?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <label class="col-form-label"><span class="redtxt">※</span>作品名稱</label>
                                                    <input type="text" class="form-control"  value="<?=$item->title?>" name="title" required placeholder="作品名稱">
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <label class="col-form-label"><span class="redtxt">※</span>作品說明</label>
                                                   <textarea name="content" class="form-control" id="editContent" ><?=$item->content?></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt">※</span>售價(請輸入美金金額USD)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="text" class="form-control USD"  value="<?=$item->USD?>" name="USD" required placeholder="">
                                                    </div>
                                                    <label style="margin-top: 5px;" class="col-form-label"><span class="redtxt">※</span>點數(輸入售價金額會自動換算)</label>
                                                    <div style="font-size: 16px;"><i class="far fa-gem" style="color: #f15ca7;"></i><span class="point"><?=$item->points?></span></div>
                                                    <input type="hidden" name="point">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn next-step btn-send">下一步</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="tab-pane" role="tabpanel" id="step2">
                <section class="product_add">
                    <div class="container-fluid">
                        <div class="inner">
                            <div class="content">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-md-flex justify-content-center">
                                            <div class="video">
                                                <h3>上傳免費影片(僅限mp4格式)</h3>

                                                <div class="round" style="position: relative;">
                                                    <input type="file" class="video_css" name="video_path" accept="video/mp4">
                                                    <input type="hidden" id="video_path" value="<?=$item->video1?>">
                                                    <i class="fas fa-cloud-upload-alt video_icon"></i>
                                                </div>
                                                <p class="desc1">點擊上傳的按鈕上傳影片</p>
                                                <p class="desc2">影片在發布前都會維持私人狀態。</p>
                                                <div class="text-center m-4 d-none">
                                                    <button class="btn btn-primary">選取檔案</button>
                                                </div>

                                                <div class="video_info m-4">
                                                    <?php if ($item->video1): ?>
                                                        <video id="video1" src='/uploads/videos/<?=$item->member_id?>/<?=$item->id?>/<?=$item->video1?>' controls></video>
                                                        <div class="text-center m-4">
                                                            <button class="btn btn-danger delete_video" data-div="1">刪除</button>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                            <div class="video">
                                                <h3>上傳付費影片(僅限mp4格式)</h3>

                                                <div class="round" style="position: relative;">
                                                    <input type="file" class="video_css" name="video_path2" accept="video/mp4">
                                                    <input type="hidden" id="video_path2" value="<?=$item->video2?>">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                </div>
                                                <p class="desc1">點擊上傳的按鈕上傳影片</p>
                                                <p class="desc2">影片在發布前都會維持私人狀態。</p>
                                                <div class="text-center m-4 d-none">
                                                    <button class="btn btn-primary">選取檔案</button>
                                                </div>

                                                <div class="video_info2 m-4">
                                                     <?php if ($item->video2): ?>
                                                        <video id="video2" src='/uploads/videos/<?=$item->member_id?>/<?=$item->id?>/<?=$item->video2?>' controls></video>
                                                        <div class="text-center m-4">
                                                            <button class="btn btn-danger delete_video" data-div="2">刪除</button>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn prev-step btn-send">上一步</button>
                                        <button class="btn next-step btn-send">下一步</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="tab-pane" role="tabpanel" id="step3">
                <section class="product_add">
                    <div class="container-fluid">
                        <div class="inner">
                            <div class="content">
                                <div class="row">
                                    <div class="col-12 m-md-4">
                                        <div class="add-image-title">上傳免費照片(不限制張數，僅限png jpg格式)</div>
                                        <input type="file" name="files[]" data-fileuploader-files='<?=$item_img1?>'>
                                    </div>
                                    <div class="col-12 m-md-4">
                                        <div class="add-image-title">上傳付費照片(不限制張數，僅限png jpg格式)</div>
                                        <input type="file" name="files2[]" data-fileuploader-files='<?=$item_img2?>'>
                                    </div>
                                    <div class="col-12 m-4 text-center">
                                        <button class="btn prev-step btn-send">上一步</button>
                                        <button class="btn btn-send add">送出</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>


    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="<?=version('assets/plugins/ckeditor5/ckeditor.js')?>"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <!-- dropzone -->
    <script src="/assets/plugins/dropzone/dropzone.js"></script>


    <script src="/assets/plugins/slim/slim/slim.kickstart.min.js" type="text/javascript"></script>

    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script src="/assets/plugins/jquery-validation/src/localization/messages_zh_TW.js" type="text/javascript"></script>
    <script src="<?=version('assets/plugins/fileuploader2.2/dist/jquery.fileuploader.min.js')?>"></script>
    <script src="<?=version('assets/js/fileuploader-ajax-image.js')?>"></script>
    <script>
        let slimOption = {
            forceSize: {
                width: 1000,
                height: 600,
            },
            label:'請上傳作品封面照',
            maxFileSize:'8'
        };
        let addSlim = new Slim(document.getElementById('addSlim'),slimOption);
        <?php if (file_exists("./uploads/item/image/".$item->img)): ?>
            addSlim.load("/uploads/item/image/<?=$item->img?>");
        <?php endif ?>

        let a = fileuploaderAjaxImage($('input[name="files[]"]'), {
            url: '/item/fileuploader_image_upload'
        },'fileuploader-thumbnails-input');

        let b = fileuploaderAjaxImage($('input[name="files2[]"]'), {
            url: '/item/fileuploader_image_upload2'
        },'fileuploader-thumbnails-input2');


    </script>
    <script>
        //ckeditor5
        var cktoolbarOption = {
            toolbar:{items:["heading","fontSize","fontColor","fontBackgroundColor","removeFormat","|","outdent","indent","alignment","bold","italic","underline","strikethrough","link","bulletedList","numberedList","undo","redo"]},
            link: {addTargetToExternalLinks: true}, //自動變成外部連結
            mediaEmbed: {removeProviders: [ 'instagram', 'twitter', 'googleMaps', 'flickr', 'facebook' ]}
        };

        jQuery.validator.addMethod("err_point", function(value, element) {
            if(value=='NaN'){
                return false;
            }
            return true;
        }, "金額錯誤");

        $('form[name=add]').validate({
            rules: {
                USD: {
                    required: true,
                    err_point: true,
                    digits: true,
                },
            },
            messages: {
                USD: {
                    digits:$.validator.format("金額只能輸入正整數"),
                },
            }
        });
        $(function() {
            $('[name=type_id]').change();
            $(`[name=category_id]`).val('<?=$item->category_id?>');
            $('.nav-tabs > li a[title]').tooltip();
            //Wizard
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

                var target = $(e.target);
                if (target.parent().hasClass('disabled')) {
                    return false;
                }
            });

            $(".next-step").click(function (e) {
                if(editContent.getData()==''){
                    $('.ck-content').css("background", "rgb(251, 227, 228)");
                }
                if(!$('form[name=add]').valid()||!check_ck5())return false;
                if(!check_img())return false;
                if(!check_video())return false;
                var active = $('.wizard .nav-tabs li.active');
                active.next().removeClass('disabled');
                nextTab(active);

            });
            $(".prev-step").click(function (e) {

                var active = $('.wizard .nav-tabs li.active');
                prevTab(active);

            });
            ClassicEditor.create( document.querySelector( '#editContent' ),cktoolbarOption ).then( editor => {window.editContent = editor;} ).catch( error => {console.error( error );} );
        });
        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

        function check_ck5(){
            if(editContent.getData()==''){
                return false;
            }else{
                return true;
            }
        }
        function check_img(){
            var msg = {};
            if(!addSlim.data.input.name){
                msg.banner = "請上傳封面圖片"
            }
            if (Object.keys(msg).length != 0) {
                ResultData({
                    msg: msg
                });
                return false;
            }else{
                return true;
            }
        }
        function check_video() {
            if($("#video_path").val()&&!$("#video_path2").val()){
                swal({
                    title:'請上傳付費影片',
                    type:'warning'
                });
                return false;
            }
            if(!$("#video_path").val()&&$("#video_path2").val()){
                swal({
                    title:'請上傳免費影片',
                    type:'warning'
                });
                return false;
            }
            return true;
        }

        $('.nav-tabs').on('click', 'li', function() {
            if(editContent.getData()==''){
                $('.ck-content').css("background", "rgb(251, 227, 228)");
            }
            if(!$('form[name=add]').valid()||!check_ck5())return false;
            if(!check_img())return false;
            if(!check_video())return false;
            $('.nav-tabs li.active').removeClass('active');
            $(this).addClass('active');
        });
        //主分類
        $('[name=type_id]').change((e)=>{
            //$('[name=city]').val(e.target.value);

            $('[name=category_id] option').remove();
            var options = (e.target.value)?$("#category_id").find(`option[data-type_id=0],option[data-type_id='${e.target.value}']`).clone():$("#category_id").find(`option:first`).clone();
            $(`[name=category_id]`).append(options);
            $(`[name=category_id]`).find('option').eq(0).prop("selected",true);
        });

        let points = parseInt('<?=$set->points?>');
        $(document).on('input','.USD',function(){
            let USD =  Math.round($('form[name=add] [name=USD]').val());
            $('.point').html(USD*points);
            $('[name=point]').val(USD*points);
        });


        //上傳圖片的input更動的時候
        $("input[name='video_path']").on("change", function() {
            //產生 FormData 物件
            var file_data = new FormData(),
                file_name = $(this)[0].files[0]['name'],
                save_path = "uploads/videos/tmp/";

            //FormData 新增剛剛選擇的檔案
            file_data.append("file", $(this)[0].files[0]);
            file_data.append("save_path", save_path);
            var filesize = $(this)[0].files[0].size;
            var size = (filesize/1024/1024).toFixed(2);
            if(size>=500){
                swal({
                    title:'上傳影片已超過限制500M',
                    type:'warning'
                });
                return false;
            }

            //透過ajax傳資料
            $.ajax({
                type : 'POST',
                url : '/item/upload_video',
                data : file_data,
                cache : false, //因為只有上傳檔案，所以不要暫存
                processData : false, //因為只有上傳檔案，所以不要處理表單資訊
                contentType : false, //送過去的內容，由 FormData 產生了，所以設定false
                dataType : 'JSON',
                beforeSend: function () {
                  waitingDialog.show();
                },
                complete: function () {
                  waitingDialog.hide();
                },
                success:function(result){
                    ResultData(result);
                    if(result.status){
                        var str=`
                            <video id="video1" src='/uploads/videos/tmp/<?=$this->session->userdata('user')['id']?>/${file_name}' controls></video>
                            <div class="text-center m-4">
                                <button class="btn btn-danger delete_video" data-div="1">刪除</button>
                            </div>`;
                        $("div.video_info").html(str);
                        //給予 #image_path 值，等等存檔時會用
                        $("#video_path").val(result.file_name);;
                    }else{
                        if(result.msg=='停留此頁面時間過久，請重新登入')result.redirect='/member/login';
                    }
                }
            }).done(function(result) {

            }).fail(function(jqXHR, textStatus, errorThrown) {
                waitingDialog.hide();
                //失敗的時候
                swal({
                    title:'伺服器出錯，請洽網站資訊人員',
                    type:'warning',
                    allowOutsideClick:false,
                });
                console.log(jqXHR.responseText);
            });
        });

        $("input[name='video_path2']").on("change", function() {
            //產生 FormData 物件
            var file_data = new FormData(),
                file_name = $(this)[0].files[0]['name'],
                save_path = "uploads/videos/tmp/";

            //FormData 新增剛剛選擇的檔案
            file_data.append("file", $(this)[0].files[0]);
            file_data.append("save_path", save_path);
            var filesize = $(this)[0].files[0].size;
            var size = (filesize/1024/1024).toFixed(2);
            if(size>=500){
                swal({
                    title:'上傳影片已超過限制500M',
                    type:'warning'
                });
                return false;
            }
            //透過ajax傳資料
            $.ajax({
                type : 'POST',
                url : '/item/upload_video',
                data : file_data,
                cache : false, //因為只有上傳檔案，所以不要暫存
                processData : false, //因為只有上傳檔案，所以不要處理表單資訊
                contentType : false, //送過去的內容，由 FormData 產生了，所以設定false
                dataType : 'JSON',
                beforeSend: function () {
                  waitingDialog.show();
                },
                complete: function () {
                  waitingDialog.hide();
                },
                success:function(result){
                    ResultData(result);
                    if(result.status){
                        var str=`
                            <video id="video2" src='/uploads/videos/tmp/<?=$this->session->userdata('user')['id']?>/${file_name}' controls></video>
                            <div class="text-center m-4">
                                <button class="btn btn-danger delete_video" data-div="2">刪除</button>
                            </div>`;
                        $("div.video_info2").html(str);
                        //給予 #image_path 值，等等存檔時會用
                        $("#video_path2").val(result.file_name);
                    }else{
                        if(result.msg=='停留此頁面時間過久，請重新登入')result.redirect='/member/login';
                    }
                },

            }).done(function(result) {

            }).fail(function(jqXHR, textStatus, errorThrown) {
                waitingDialog.hide();
                swal({
                    title:'伺服器出錯，請洽網站資訊人員',
                    type:'warning',
                    allowOutsideClick:false,
                });
                console.log(jqXHR.responseText);
            });
        });

        $(document).on('click','.delete_video',function(){
            var div =    $(this).data('div');
            swal({
                title:'確定刪除?',
                type:'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: '確定刪除',
                cancelButtonText: '取消',
                reverseButtons: true,
            }).then(function(result){
                if(result.value){
                    if(div==1){
                        $("div.video_info").html('');
                        $("#video_path").val('');
                    }else{
                        $("div.video_info2").html('');
                        $("#video_path2").val('');
                    }
                }
            });
        });

        //上傳作品
        var register_ajax   =   '/item/edit/<?=$item->id?>';
        $(document).on('click','.add',function(){
            swal({
                title: '確定送出?',
                text: "提醒您送出資料後，作品會下架重新審核，確認無誤後請按確定，謝謝。",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: '確定',
                cancelButtonText: '取消',
                allowOutsideClick:false,
                reverseButtons: true,
            }).then((isConfirm) => {
                if (isConfirm.value) {
                    $('form[name=add] textarea[name=content]').val(editContent.getData());
                    var data = new FormData(document.forms['add']);
                    var api = $.fileuploader.getInstance($('input[name="files[]"]'));
                    var fileList = api.getFileList();
                    var _list = [];
                    var _editor = [];


                    var data = new FormData(document.forms['add']);
                    var api2 = $.fileuploader.getInstance($('input[name="files2[]"]'));
                    var fileList2 = api2.getFileList();
                    var _list2 = [];
                    var _editor2 = [];

                    if($('video').length>0){
                        data.append('video1_length', getVideoTime('video1'));
                        data.append('video2_length', getVideoTime('video2'));
                        data.append('video_total_length', getVideoTime('total'));
                    }


                    msg ={};
                    //var fileList = api.getFileList();
                    if (fileList.length === 0) {
                        msg.carousel = "免費照片上傳數不可為0";
                    }
                    if (fileList2.length === 0) {
                        msg.carousel2 = "付費照片上傳數不可為0";
                    }

                    if (Object.keys(msg).length > 0) {
                        ResultData({
                          msg: msg
                        });
                        return false;
                    }
                    $.each(fileList, function (i, item) {
                        _list.push(item.name);
                        _editor.push(item.editor);
                    });

                    $.each(fileList2, function (i, item) {
                        _list2.push(item.name);
                        _editor2.push(item.editor);
                    });
                    data.append('video1', $("#video_path").val());
                    data.append('video2', $("#video_path2").val());

                    data.append('fileuploader_images', JSON.stringify(_list));
                    data.append('fileuploader_editor', JSON.stringify(_editor));
                    data.append('fileuploader_uploaded_images', JSON.stringify(api.getUploadedFiles().map(e => e.name)));
                    data.append('fileuploader_images2', JSON.stringify(_list2));
                    data.append('fileuploader_editor2', JSON.stringify(_editor2));
                    data.append('fileuploader_uploaded_images2', JSON.stringify(api2.getUploadedFiles().map(e => e.name)));
                    $.ajax({
                        url:register_ajax,
                        type:'POST',
                        dataType:'JSON',
                        data:data,
                        processData: false,
                        contentType: false,
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

        function formatSeconds(value) {
            var secondTime = parseInt(value);// 秒
            var minuteTime = 0;// 分
            var hourTime = 0;// 小時
            if(secondTime > 60) {//如果秒數大於60，將秒數轉換成整數
                //獲取分鐘，除以60取整數，得到整數分鐘
                minuteTime = parseInt(secondTime / 60);
                //獲取秒數，秒數取佘，得到整數秒數
                secondTime = parseInt(secondTime % 60);
                //如果分鐘大於60，將分鐘轉換成小時
                if(minuteTime > 60) {
                    //獲取小時，獲取分鐘除以60，得到整數小時
                    hourTime = parseInt(minuteTime / 60);
                    //獲取小時後取佘的分，獲取分鐘除以60取佘的分
                    minuteTime = parseInt(minuteTime % 60);
                }
            }
            if(secondTime<10)secondTime='0'+secondTime;
            var result = "" + secondTime + "";

            if(minuteTime >= 0) {
                if(minuteTime<10)minuteTime="0"+minuteTime;
                result = "" + minuteTime + ":" + result;
            }
            if(hourTime > 0) {
                result = "" + parseInt(hourTime) + ":" + result;
            }
            return result;
        }



        function getVideoTime(id){
            if (document.getElementById(id)) {
                let videoPlayer = document.getElementById(id);
                let d = videoPlayer.duration;
                return formatSeconds(d);
            }else if(id=='total'){
                let videoPlayer = document.getElementById('video1');
                let d1 = parseInt(videoPlayer.duration);
                let videoPlayer2 = document.getElementById('video2');
                let d2 = parseInt(videoPlayer2.duration);
                return formatSeconds(d1+d2);

            }
            return false;
        }



    </script>
</body>
</html>