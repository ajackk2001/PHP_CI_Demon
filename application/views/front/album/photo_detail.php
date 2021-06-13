<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('front/include/layout_head');?>
    <title><?=$this->web_title?></title>
    <link rel="stylesheet" type="text/css" href="/assets/css/front/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/jquery.scrollbar.css">
    <link rel="stylesheet" href="<?=version('assets/plugins/ckeditor5/ckeditor-styles.css')?>">
    <link rel="stylesheet" href="<?=version('assets/css/front/style.css')?>">

    <link href="https://vjs.zencdn.net/7.8.4/video-js.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" type="text/css" rel="stylesheet"/>

    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <style type="text/css">
        .vjs-paused .vjs-big-play-button,
        .vjs-paused.vjs-has-started .vjs-big-play-button {
            display: block;
        }
        .video-js .vjs-big-play-button{
            /*font-size: 17px;display: none;*/
        }

        .video-js.vjs-playing .vjs-tech {
            pointer-events: auto;
        }

        .vid-length , .vid-length2{
            color: #fff;
            position: absolute;
            border-radius: 2px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: end;
            -ms-flex-align: end;
            align-items: flex-end;
            -webkit-box-pack: start;
            -ms-flex-pack: start;
            justify-content: flex-start;
            padding: .1rem .5rem;
            left: .5rem;
            bottom: .5rem;
            font-size: 18px;
            font-weight: 400;
            background-color: rgba(91,91,91,.5);
            z-index: 100;
        }
        .pip-small.clickable{
            display: none;
        }

        .orderInfoStatus i {
            color: #28a745 !important;
        }

    </style>
</head>
<body>
    <?php //$this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <div class="container-fluid video_detail">
            <div class="card-content">
                <div class="row">
                    <div class="col-md-8">
                        <div class="VideoBox">
                            <img src="/uploads/item/image/<?=$item->img?>">
                        </div>
                        <div class="Avatar_Info">
                            <div class="Video_Title">
                                <div class="col-8">
                                    <h1><?=$item->title?></h1>
                                </div>
                                <div class="col-4 text-right">
                                <?=!empty($item->video_total_length)?'<div class="preview-length">'.$item->video_total_length.'</div>':''?>
                                        <?=!empty($item->img_num)?'<div class="preview-length">'.$item->img_num.' P</div>':''?>
                                    <p class="view-count text-right">
                                        <?php if ($this->session->userdata('user')['id']): ?>
                                            <!-- 註：設定data-active為0為空心愛心，設1為實心愛心 -->
                                            <button class="btn add-favorite" data-active="<?=$isActive?>" data-item_id="<?=$item->id?>">
                                                <span id="favorite-icon"></span><span id="favorite"><?=$favorite?></span>
                                            </button>
                                        <?php endif ?>

                                        觀看次數：<?=$item->ctr?>次
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-8">
                                    <div class="Avatar_name">
                                        <?php if ($item->member_img): ?>
                                            <img src="<?=$item->member_img?>" class="rounded-circle">
                                        <?php else: ?>
                                            <img src="/assets/images/front/member_default.jpg" class="rounded-circle">
                                        <?php endif ?>
                                        <h3><?=$item->nickname?></h3>
                                    </div>
                                    <div class="date">
                                        <i class="far fa-clock" style="margin-right: 3px;"></i><?=$item->update_time?> <span style="margin-left: 8px;color: #444;">本劇情純屬虛構</span><span style="margin-left: 8px;color: #444;">版權所有，翻印必究</span>
                                    </div>
                                    <div class="description ck-content">
                                        <?=$item->content?>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 price-details">
                                    <?php if ($result): ?>
                                        <p class="orderInfoStatus text-success">
                                            <i class="far fa-check-circle"></i> 已購買
                                        </p>
                                    <?php else: ?>
                                        <p class="mb-4">$ <?=$item->USD==0?$item->USD:$item->USD2?> <span class="currency">USD</span></p>
                                        <p><i class="far fa-gem"></i><?=$item->points?></p>
                                        <button class="btn btn-send create_order" data-item_id="<?=$item->id?>">購買</button>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <div class="row showPic">
                            <?php if ($item->video): ?>
                                <div class="col-xs-6 col-md-3">
                                    <div class="photos card-deck">
                                        <div class="vid-length" style="left: 0.5rem"><?=$item->video1_length?></div>
                                        <a data-fancybox="gallery" href="<?=$item->video?>">
                                            <video id="my-video" class="video-js vjs-big-play-centered videoBox" controls preload="" poster="/uploads/item/image/<?=$item->img?>"  data-setup="{}" >
                                                <source src="<?=$item->video?>" type="video/mp4" />
                                                <source src="MY_VIDEO.webm" type="video/webm" />
                                                <!-- <p class="vjs-no-js">
                                                  To view this video please enable JavaScript, and consider upgrading to a
                                                  web browser that
                                                  <a href="https://videojs.com/html5-video-support/" target="_blank"
                                                    >supports HTML5 video</a
                                                  >
                                                </p> -->

                                            </video>
                                        </a>
                                    </div>
                                </div>
                            <?php endif ?>
                            <?php if ($item->video2): ?>
                                <div class="col-xs-6 col-md-3">
                                    <div class="photos card-deck2">
                                        <div class="vid-length2" style="left: 0.5rem"><?=$item->video2_length?></div>
                                        <div class="vid-length2" style="left: 0.5rem"></div>
                                        <a data-fancybox="gallery" href="<?=$item->video2?>">
                                            <video id="my-video2" class="video-js vjs-big-play-centered videoBox" controls preload="" poster="/uploads/item/image/<?=$item->img?>"  data-setup="{}" >
                                                <source src="<?=$item->video2?>" type="video/mp4" />
                                                <source src="MY_VIDEO.webm" type="video/webm" />
                                                <!-- <p class="vjs-no-js">
                                                  To view this video please enable JavaScript, and consider upgrading to a
                                                  web browser that
                                                  <a href="https://videojs.com/html5-video-support/" target="_blank"
                                                    >supports HTML5 video</a
                                                  >
                                                </p> -->

                                            </video>
                                        </a>
                                    </div>
                                </div>
                            <?php endif ?>
                            <?php foreach ($item_img1 as $k => $v): ?>
                                <div class="col-xs-6 col-md-3">
                                    <div class="photos"><a data-fancybox="gallery" href="<?=$v->img?>"><img src="<?=$v->img?>"></a></div>
                                </div>
                            <?php endforeach ?>
                            <?php foreach ($item_img2 as $k => $v): ?>
                                <div class="col-xs-6 col-md-3">
                                    <div class="photos lock">
                                        <?php if ($v->status==0): ?>
                                            <div class="pic-lock"><i class="fas fa-lock"></i></div>
                                        <?php else: ?>
                                            <div class="photos"><a data-fancybox="gallery" href="<?=$v->img?>"><img src="<?=$v->img?>"></a></div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row list">
                            <?php foreach ($itemx as $k => $v): ?>
                                <div class="col-md-12 playlist-item">
                                    <div class="model-info">
                                        <a href="/artist/detail/<?=$v->member_id?>">
                                            <?php if ($v->member_img): ?>
                                                <img src="<?=$v->member_img?>" class="rounded-circle">
                                            <?php else: ?>
                                                <img src="/assets/images/front/member_default.jpg" class="rounded-circle">
                                            <?php endif ?>
                                            <p><?=$v->nickname?></p>
                                        </a>
                                    </div>
                                    <a href="/album/detail/<?=$v->id?>">
                                        <div class="imgbox">
                                            <img src="/uploads/item/image/<?=$v->img?>">
                                        </div>
                                        <p class="txt-title"><?=$v->title?></p>
                                    </a>
                                    <div class="info-box">
                                        <p class="original-price">$ <?=$v->USD2<0?$v->USD:$v->USD2?></p>
                                        <p class="view-times"><i class="fa fa-eye"></i><?=$v->ctr?></p>
                                        <?=!empty($v->video_total_length)?'<div class="preview-length">'.$v->video_total_length.'</div>':''?>
                                        <?=!empty($v->img_num)?'<div class="preview-length">'.$v->img_num.' P</div>':''?>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script src="https://vjs.zencdn.net/7.8.4/video.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script type="text/javascript">
        window.onload = function() {
        }

        // 有#my-video才執行播放影片
        var elementExists = document.getElementById("my-video");
        var elementExists2 = document.getElementById("my-video2");
        if (elementExists) {
            var player = videojs('my-video',{
                    autoplay:false,
                    controlBar: {
                        fullscreenToggle: false
                    }
            });
            var f=true;
            player.on('mouseover',function () {
                //player.play();
               // $(".vid-length").addClass("d-none");

            });
            player.on('mouseout',function (){
               player.pause();
                $(".vid-length").removeClass("d-none");

            });

            player.on('playing',function (){
                player.pause();
                $('.card-deck a').click();
                $(".vid-length").removeClass("d-none");

            });

            player.on('loadedmetadata',function(){
                let t=$('.vid-length').html();
                if(!t){
                    var videoLength = player.duration();
                    $('.vid-length').html(formatSeconds(videoLength));
                }
                //console.log()
            });
            player.ready(function() {
                player.tech_.off('dblclick');
            });
        }

        if (elementExists2) {
            var player2 = videojs('my-video2',{
                    autoplay:false,
                    controlBar: {
                        fullscreenToggle: false
                    }
            });
            var f=true;
            player2.on('mouseover',function () {
                //player.play();
                //$(".vid-length2").addClass("d-none");

            });
            player2.on('mouseout',function (){
               player2.pause();
                //$(".vid-length2").removeClass("d-none");

            });

            player2.on('playing',function (){
                player2.pause();
                $('.card-deck2 a').click();
                $(".vid-length2").removeClass("d-none");

            });

            player2.on('loadedmetadata',function(){
                let t2=$('.vid-length2').html();
                if(!t2){
                    var videoLength = player2.duration();
                    $('.vid-length2').html(formatSeconds(videoLength));
                }
                //console.log()
            });
            player2.ready(function() {
                player2.tech_.off('dblclick');
            });
        }

        $('[data-fancybox]').fancybox({
            protect: true
        })


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

        function toggleFavorIcon() {
            if ( $('.add-favorite').data('active') === 1) {
                $('#favorite-icon').html('<i class="fas fa-heart"></i>')
            } else {
                $('#favorite-icon').html('<i class="far fa-heart"></i>')
            }
        }
        $(function() {
            toggleFavorIcon();
            $('.add-favorite').on('click', function() {
                var isActive = $('.add-favorite').data('active');
                var item_id = $('.add-favorite').data('item_id');
                var ajax_url = isActive==0?"/item_favorite_add/":"/item_favorite_delete/";
                // 註：在此要ajax去修改資料庫儲存 data-active的值
                $.ajax({
                    type: 'POST',
                    url: ajax_url+item_id,
                    dataType: 'json',
                    success:function(r){
                        if(r.status){
                            $('.add-favorite').data('active', isActive ? 0 : 1);
                            toggleFavorIcon();
                            var favorite = isActive==0?parseInt($('#favorite').text())+1:parseInt($('#favorite').text())-1;
                            $('#favorite').text(favorite);
                        }
                    }

                });
            })
        })

        document.oncontextmenu = function(e) {
            var target = (typeof e != "undefined") ? e.target : event.srcElement
            if (target.tagName == "IMG" || (target.tagName == 'A' && target.firstChild.tagName == 'IMG'))
                return false

        }

        $(document).on('click','.create_order',function(){
            var item_id = $(this).data('item_id');
            var form = $("<form method='post'></form>");
            form.attr({"action":'/payment_item'});
            $("body").append($(form));
            var str =`
                <input type="hidden" name="item_id" value="${item_id}">
            `;
            form.html(str);
            form.submit();
            return false;
        });




    </script>
</body>
</html>