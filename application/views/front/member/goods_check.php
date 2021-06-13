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

    <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet"/>

    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
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
        .form-control-plaintext{
            padding-left: 10px;
        }
        .my-video{
            width: 100%;
            height: 315px;
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
                        <div class="card-header">作品審核</div>
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
                                            <?php if (!empty($item->member_img)): ?>
                                                <img src="<?=$item->member_img?>" class="rounded-circle">
                                            <?php else: ?>
                                                <img src="/assets/images/front/member_default.jpg" class="rounded-circle">
                                            <?php endif ?>
                                        </div>
                                        <div class="UserInfo">
                                            <h1><?=$item->nickname?></h1>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <form action="" name="add">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt"></span>作品封面</label>
                                                    <img src="/uploads/item/image/<?=$item->img?>" alt="" style="max-width: 100%;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt"></span>主分類</label>
                                                    <div class="form-control-plaintext"><?=$item->type_title?></div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt"></span>次分類</label>
                                                    <div class="form-control-plaintext"><?=$item->category_title?></div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt"></span>尺度分類</label>
                                                    <div class="form-control-plaintext"><?=$item->scale_title?></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <label class="col-form-label"><span class="redtxt"></span>作品名稱</label>
                                                    <div class="form-control-plaintext"><?=$item->title?></div>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <label class="col-form-label"><span class="redtxt"></span>作品說明</label>
                                                    <div class="form-control-plaintext ck-content">
                                                        <?=$item->content?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label class="col-form-label"><span class="redtxt"></span>售價</label>
                                                    <div class="input-group">
                                                        <div class="form-control-plaintext">$ <?=$item->USD?> USD</div>
                                                    </div>
                                                    <label style="margin-top: 5px;" class="col-form-label"><span class="redtxt"></span>點數</label>
                                                    <div class="form-control-plaintext"style="font-size: 16px;"><i class="far fa-gem" style="color: #f15ca7;"></i><span class="point"><?=$item->points?></span></div>
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

                                                <div class="video_info2 m-4" style="">
                                                    <?php if ($item->video1): ?>
                                                        <video id="my-video" class="video-js vjs-big-play-centered videoBox my-video" controls preload="auto" poster=""  data-setup="{}" >
                                                            <source src="/uploads/videos/<?=$item->member_id?>/<?=$item->id?>/<?=$item->video1?>" type="video/mp4" />
                                                            <source src="MY_VIDEO.webm" type="video/webm" />
                                                            <p class="vjs-no-js">
                                                              To view this video please enable JavaScript, and consider upgrading to a
                                                              web browser that
                                                              <a href="https://videojs.com/html5-video-support/" target="_blank"
                                                                >supports HTML5 video</a
                                                              >
                                                            </p>

                                                        </video>
                                                    <?php else: ?>
                                                        此作品無上傳影片
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                            <div class="video">
                                                <h3>上傳付費影片(僅限mp4格式)</h3>
                                                <div class="video_info2 m-4">
                                                    <?php if ($item->video2): ?>
                                                            <video id="my-video2" class="video-js vjs-big-play-centered videoBox my-video" controls preload="auto" poster=""  data-setup="{}" >
                                                                <source src="/uploads/videos/<?=$item->member_id?>/<?=$item->id?>/<?=$item->video2?>" type="video/mp4" />
                                                                <source src="MY_VIDEO.webm" type="video/webm" />
                                                                <p class="vjs-no-js">
                                                                  To view this video please enable JavaScript, and consider upgrading to a
                                                                  web browser that
                                                                  <a href="https://videojs.com/html5-video-support/" target="_blank"
                                                                    >supports HTML5 video</a
                                                                  >
                                                                </p>

                                                            </video>
                                                    <?php else: ?>
                                                        此作品無上傳影片
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
                                    <div class="col-12">
                                        <div class="add-image-title">上傳免費照片(不限制張數，僅限png jpg格式)</div>
                                    </div>
                                    <?php foreach ($item_img1 as $k => $v): ?>
                                        <div class="col-12 col-md-3">
                                            <a data-fancybox="gallery" href="<?=$v->img?>">
                                                <img src="<?=$v->img?>" alt="" style="max-width: 100%;height: 315px;">
                                            </a>
                                        </div>
                                    <?php endforeach ?>
                                    <div class="col-12">
                                        <div class="add-image-title">上傳付費照片(不限制張數，僅限png jpg格式)</div>
                                    </div>
                                    <?php foreach ($item_img2 as $k => $v): ?>
                                        <div class="col-12 col-md-3">
                                            <a data-fancybox="gallery-paid" href="<?=$v->img?>">
                                                <img src="<?=$v->img?>" alt="" style="max-width: 100%;height: 315px;">
                                            </a>
                                        </div>
                                    <?php endforeach ?>
                                    <div class="col-12 text-center mb-4 mt-4">
                                        <button class="btn prev-step btn-send">上一步</button>
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
    <script src="<?=version('assets/plugins/fileuploader2.2/dist/jquery.fileuploader.min.js')?>"></script>
    <script src="<?=version('assets/js/fileuploader-ajax-image.js')?>"></script>
    <script src="https://vjs.zencdn.net/7.8.4/video.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>


        $(function() {
            <?php if ($item->video1): ?>
                var player = videojs('my-video');
                var player2 = videojs('my-video2');
            <?php endif ?>
            $('.nav-tabs > li a[title]').tooltip();
            //Wizard
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

                var target = $(e.target);
                if (target.parent().hasClass('disabled')) {
                    return false;
                }
            });

            $(".next-step").click(function (e) {
                var active = $('.wizard .nav-tabs li.active');
                active.next().removeClass('disabled');
                nextTab(active);

            });
            $(".prev-step").click(function (e) {

                var active = $('.wizard .nav-tabs li.active');
                prevTab(active);

            });
        });
        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }



        $('.nav-tabs').on('click', 'li', function() {
            $('.nav-tabs li.active').removeClass('active');
            $(this).addClass('active');
        });
        //主分類






    </script>
</body>
</html>