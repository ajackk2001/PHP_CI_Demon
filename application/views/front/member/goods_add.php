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
                        <div class="card-header">????????????</div>
                        <div class="card-body wizard">
                            <div class="wizard-inner">
                                <div class="connecting-line"></div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>????????????</i></a>
                                    </li>
                                    <li role="presentation" class="disabled">
                                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i>????????????</i></a>
                                    </li>
                                    <li role="presentation" class="disabled">
                                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span> <i>????????????</i></a>
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
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt">???</span>????????????</label>
                                                    <input type="file" name="slim" id="addSlim" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt">???</span>?????????</label>
                                                    <select name="type_id" id="" class="form-control" required>
                                                        <option value="">??????????????????</option>
                                                        <?php foreach ($type as $key => $value) : ?>
                                                            <option value="<?=$value->id?>"><?=$value->title?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt">???</span>?????????</label>
                                                    <select name="category_id" id="" class="form-control category" required>
                                                        <option value="">??????????????????</option>
                                                    </select>
                                                    <select name="" id="category_id" class="form-control d-none">
                                                        <option value="">??????????????????</option>
                                                        <?php foreach ($category as $key => $value) : ?>
                                                            <option value="<?=$value->id?>" data-type_id="<?=$value->type_id?>"><?=$value->title?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt">???</span>????????????</label>
                                                    <select name="scale_id" id="" class="form-control" required>
                                                        <option value="">???????????????</option>
                                                        <?php foreach ($scale as $key => $value) : ?>
                                                            <option value="<?=$value->id?>"><?=$value->title?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <label class="col-form-label"><span class="redtxt">???</span>????????????</label>
                                                    <input type="text" class="form-control"  value="" name="title" required placeholder="????????????">
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <label class="col-form-label"><span class="redtxt">???</span>????????????</label>
                                                   <textarea name="content" class="form-control" id="editContent" ></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt">???</span>??????(?????????????????????USD)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="text" class="form-control USD"  value="" name="USD" required placeholder="">
                                                    </div>
                                                    <label style="margin-top: 5px;" class="col-form-label"><span class="redtxt">???</span>??????(?????????????????????????????????)</label>
                                                    <div style="font-size: 16px;"><i class="far fa-gem" style="color: #f15ca7;"></i><span class="point">0</span></div>
                                                    <input type="hidden" name="point">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn next-step btn-send">?????????</button>
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
                                                <h3>??????????????????(??????mp4??????)</h3>

                                                <div class="round" style="position: relative;">
                                                    <input type="file" class="video_css" name="video_path" accept="video/mp4">
                                                    <input type="hidden" id="video_path" value="">
                                                    <i class="fas fa-cloud-upload-alt video_icon"></i>
                                                </div>
                                                <p class="desc1">?????????????????????????????????</p>
                                                <p class="desc2">?????????????????????????????????????????????</p>
                                                <div class="text-center m-4 d-none">
                                                    <button class="btn btn-primary">????????????</button>
                                                </div>

                                                <div class="video_info m-4"></div>
                                            </div>
                                            <div class="video">
                                                <h3>??????????????????(??????mp4??????)</h3>

                                                <div class="round" style="position: relative;">
                                                    <input type="file" class="video_css" name="video_path2" accept="video/mp4">
                                                    <input type="hidden" id="video_path2" value="">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                </div>
                                                <p class="desc1">?????????????????????????????????</p>
                                                <p class="desc2">?????????????????????????????????????????????</p>
                                                <div class="text-center m-4 d-none">
                                                    <button class="btn btn-primary">????????????</button>
                                                </div>

                                                <div class="video_info2 m-4"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn prev-step btn-send">?????????</button>
                                        <button class="btn next-step btn-send">?????????</button>
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
                                        <div class="add-image-title">??????????????????(????????????????????????png jpg??????)</div>
                                        <input type="file" name="files[]" data-fileuploader-files='' img>
                                    </div>
                                    <div class="col-12 m-md-4">
                                        <div class="add-image-title">??????????????????(????????????????????????png jpg??????)</div>
                                        <input type="file" name="files2[]" data-fileuploader-files='' img>
                                    </div>
                                    <div class="col-12 m-4 text-center">
                                        <button class="btn prev-step btn-send">?????????</button>
                                        <button class="btn btn-send add">??????</button>
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
            label:'????????????????????????',
            maxFileSize:'8'
        };

        let addSlim = new Slim(document.getElementById('addSlim'),slimOption);

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
            link: {addTargetToExternalLinks: true}, //????????????????????????
            mediaEmbed: {removeProviders: [ 'instagram', 'twitter', 'googleMaps', 'flickr', 'facebook' ]}
        };

        jQuery.validator.addMethod("err_point", function(value, element) {
            if(value=='NaN'){
                return false;
            }
            return true;
        }, "????????????");

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
                    digits:$.validator.format("???????????????????????????"),
                },
            }
        });
        $(function() {
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
                msg.banner = "?????????????????????"
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
                    title:'?????????????????????',
                    type:'warning'
                });
                return false;
            }
            if(!$("#video_path").val()&&$("#video_path2").val()){
                swal({
                    title:'?????????????????????',
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
        //?????????
        $('[name=type_id]').change((e)=>{
            //$('[name=city]').val(e.target.value);

            $('[name=category_id] option').remove();
            var options = (e.target.value)?$("#category_id").find(`option[data-type_id=0],option[data-type_id='${e.target.value}']`).clone():$("#category_id").find(`option:first`).clone();
            $(`[name=category_id]`).append(options);
            $(`[name=category_id]`).find('option').eq(0).attr("selected",true);
        });
        let points = parseInt('<?=$set->points?>');
        $(document).on('input','.USD',function(){
            let USD =  Math.round($('form[name=add] [name=USD]').val());
            $('.point').html(USD*points);
            $('[name=point]').val(USD*points);
        });


        //???????????????input???????????????
        $("input[name='video_path']").on("change", function() {
            //?????? FormData ??????
            var file_data = new FormData(),
                file_name = $(this)[0].files[0]['name'],
                save_path = "uploads/videos/tmp/";

            //FormData ???????????????????????????
            file_data.append("file", $(this)[0].files[0]);
            file_data.append("save_path", save_path);
            var filesize = $(this)[0].files[0].size;
            var size = (filesize/1024/1024).toFixed(2);
            if(size>=500){
                swal({
                    title:'???????????????????????????500M',
                    type:'warning'
                });
                return false;
            }
            //??????ajax?????????
            $.ajax({
                type : 'POST',
                url : '/item/upload_video',
                data : file_data,
                cache : false, //?????????????????????????????????????????????
                processData : false, //?????????????????????????????????????????????????????????
                contentType : false, //???????????????????????? FormData ????????????????????????false
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
                                <button class="btn btn-danger delete_video" data-div="1">??????</button>
                            </div>`;
                        $("div.video_info").html(str);
                        window.setTimeout(function(){getVideoTime('video1')}, 2000);
                        //?????? #image_path ???????????????????????????
                        $("#video_path").val(result.file_name);
                    }else{
                        if(result.msg=='?????????????????????????????????????????????')result.redirect='/member/login';
                    }
                }
            }).done(function(result) {

            }).fail(function(jqXHR, textStatus, errorThrown) {
                waitingDialog.hide();
                //???????????????
                swal({
                    title:'??????????????????????????????????????????',
                    type:'warning',
                    allowOutsideClick:false,
                });
                console.log(jqXHR.responseText);
            });
        });

        $("input[name='video_path2']").on("change", function() {
            //?????? FormData ??????
            var file_data = new FormData(),
                file_name = $(this)[0].files[0]['name'],
                save_path = "uploads/videos/tmp/";

            //FormData ???????????????????????????
            file_data.append("file", $(this)[0].files[0]);
            file_data.append("save_path", save_path);
            var filesize = $(this)[0].files[0].size;
            var size = (filesize/1024/1024).toFixed(2);
            if(size>=500){
                swal({
                    title:'???????????????????????????500M',
                    type:'warning'
                });
                return false;
            }
            //??????ajax?????????
            $.ajax({
                type : 'POST',
                url : '/item/upload_video',
                data : file_data,
                cache : false, //?????????????????????????????????????????????
                processData : false, //?????????????????????????????????????????????????????????
                contentType : false, //???????????????????????? FormData ????????????????????????false
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
                                <button class="btn btn-danger delete_video" data-div="2">??????</button>
                            </div>`;
                        $("div.video_info2").html(str);
                        //?????? #image_path ???????????????????????????
                        $("#video_path2").val(result.file_name);
                    }else{
                        if(result.msg=='?????????????????????????????????????????????')result.redirect='/member/login';
                    }
                },

            }).done(function(result) {

            }).fail(function(jqXHR, textStatus, errorThrown) {
                waitingDialog.hide();
                swal({
                    title:'??????????????????????????????????????????',
                    type:'warning',
                    allowOutsideClick:false,
                });
                console.log(jqXHR.responseText);
            });
        });

        $(document).on('click','.delete_video',function(){
            var div =    $(this).data('div');
            swal({
                title:'?????????????',
                type:'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: '????????????',
                cancelButtonText: '??????',
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

        //????????????
        var register_ajax   =   '/item/add';
        $(document).on('click','.add',function(){
            swal({
                title: '?????????????',
                text: "",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: '??????',
                cancelButtonText: '??????',
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


                    msg ={};
                    //var fileList = api.getFileList();
                    if (fileList.length === 0) {
                        msg.carousel = "??????????????????????????????0";
                    }
                    if (fileList2.length === 0) {
                        msg.carousel2 = "??????????????????????????????0";
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

                    if($('video').length>0){
                        data.append('video1_length', getVideoTime('video1'));
                        data.append('video2_length', getVideoTime('video2'));
                        data.append('video_total_length', getVideoTime('total'));
                    }

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
                        beforeSend:function(){//????????????????????????
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
            var secondTime = parseInt(value);// ???
            var minuteTime = 0;// ???
            var hourTime = 0;// ??????
            if(secondTime > 60) {//??????????????????60???????????????????????????
                //?????????????????????60??????????????????????????????
                minuteTime = parseInt(secondTime / 60);
                //????????????????????????????????????????????????
                secondTime = parseInt(secondTime % 60);
                //??????????????????60???????????????????????????
                if(minuteTime > 60) {
                    //?????????????????????????????????60?????????????????????
                    hourTime = parseInt(minuteTime / 60);
                    //????????????????????????????????????????????????60????????????
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