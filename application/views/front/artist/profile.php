<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('front/include/layout_head');?>
    <title><?=$this->web_title?></title>

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/jquery.scrollbar.css">
    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/assets/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/assets/js/front/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="/assets/plugins/clockpicker/bootstrap-clockpicker.css">
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/assets/plugins/adminLTE/css/adminlte.css">

    <link rel="stylesheet" href="<?=version('assets/css/front/style.css')?>">

</head>
<body>
    <?php $this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <?php if (!empty($member->banner_img)&&file_exists($member->banner_img)): ?>
        <div id="banner" class="edit" style="background: url(/<?=$member->banner_img?>) center center / cover;"></div>
    <?php else: ?>
        <div class="profile-banner edit">
            <div class="setbanner "></div>
        </div>
    <?php endif ?>
    <main>
        <div class="container-fluid profile">
            <div class="row">
                <div class="TopBox col-12 col-md-3">
                    <div class="Avatar">
                        <?php if (!empty($member->img)): ?>
                            <img src="<?=$member->img?>" class="rounded-circle">
                        <?php else: ?>
                            <img src="/assets/images/front/member_default.jpg" class="rounded-circle">
                        <?php endif ?>
                    </div>
                    <div class="UserInfo">
                        <h1><?=$member->nickname?></h1>
                        <div class="toolbar">
                            <button data-toggle="modal" data-target="#modal-default"><i class="fas fa-gift"></i><span>送禮</span></button>
                            <button class="chat_add" data-id="<?=$member->id?>"><i class="fab fa-telegram-plane"></i><span>私訊</span></button>
                        </div>
                        <div class="model_des">
                            <p>
                                <?php if ($member->height): ?>
                                    <span><?=$member->height?>cm</span>
                                    <span class="and"></span>
                                <?php endif ?>
                                <?php if ($member->measurement): ?>
                                    <span><?=$member->measurement?></span>
                                    <span class="and"></span>
                                <?php endif ?>
                                <span><?=$member->profession?></span>
                            </p>
                            <p class="infotxt">
                                <?=nl2br($member->desc)?>
                            </p>
                        </div>
                        <div class="scoreboard"><i class="far fa-clock"></i>加入時間 <?=$member->create_date?></div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-img-tab" data-toggle="pill" href="#custom-tabs-img" role="tab" aria-controls="custom-tabs-img" aria-selected="true">寫真/視頻</a>
                                </li>
                                <li class="nav-item d-none">
                                    <a class="nav-link" id="custom-tabs-video-tab" data-toggle="pill" href="#custom-tabs-video" role="tab" aria-controls="custom-tabs-video" aria-selected="false">視頻</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-info-tab" data-toggle="pill" href="#custom-tabs-info" role="tab" aria-controls="custom-tabs-info" aria-selected="false">簡介</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-img" role="tabpanel" aria-labelledby="custom-tabs-img-tab">
                                <div class="card-body">
                                    <div class="row list item_list">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-video" role="tabpanel" aria-labelledby="custom-tabs-content-tab">
                                <div class="card-body">
                                    <div class="row list">
                                        <!-- <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                                            <div class="playlist-item">
                                                <div class="model-info">
                                                    <a href="/artist/detail">
                                                        <img src="/assets/images/front/p03.jpg" class="rounded-circle">
                                                        <p>夢夢monmon</p>
                                                    </a>
                                                </div>
                                                <a href="javascript:;">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v04.jpg">
                                                    </div>
                                                    <p class="txt-title">上空無遮-樂樂Ｘ瞳瞳【暴風雨】童貞弟弟用媚藥讓姊姊和她的同事色慾覺醒《中文字幕》上空劇情長片動画</p>
                                                </a>
                                                <div class="info-box">
                                                    <p class="original-price">$5.88</p>
                                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                                            <div class="playlist-item">
                                                <div class="model-info">
                                                    <a href="/artist/detail">
                                                        <img src="/assets/images/front/p03.jpg" class="rounded-circle">
                                                        <p>夢夢monmon</p>
                                                    </a>
                                                </div>
                                                <a href="javascript:;">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v04.jpg">
                                                    </div>
                                                    <p class="txt-title">上空無遮-樂樂Ｘ瞳瞳【暴風雨】童貞弟弟用媚藥讓姊姊和她的同事色慾覺醒《中文字幕》上空劇情長片動画</p>
                                                </a>
                                                <div class="info-box">
                                                    <p class="original-price">$5.88</p>
                                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                                            <div class="playlist-item">
                                                <div class="model-info">
                                                    <a href="/artist/detail">
                                                        <img src="/assets/images/front/p03.jpg" class="rounded-circle">
                                                        <p>夢夢monmon</p>
                                                    </a>
                                                </div>
                                                <a href="javascript:;">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v04.jpg">
                                                    </div>
                                                    <p class="txt-title">上空無遮-樂樂Ｘ瞳瞳【暴風雨】童貞弟弟用媚藥讓姊姊和她的同事色慾覺醒《中文字幕》上空劇情長片動画</p>
                                                </a>
                                                <div class="info-box">
                                                    <p class="original-price">$5.88</p>
                                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                                            <div class="playlist-item">
                                                <div class="model-info">
                                                    <a href="/artist/detail">
                                                        <img src="/assets/images/front/p03.jpg" class="rounded-circle">
                                                        <p>夢夢monmon</p>
                                                    </a>
                                                </div>
                                                <a href="javascript:;">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v04.jpg">
                                                    </div>
                                                    <p class="txt-title">上空無遮-樂樂Ｘ瞳瞳【暴風雨】童貞弟弟用媚藥讓姊姊和她的同事色慾覺醒《中文字幕》上空劇情長片動画</p>
                                                </a>
                                                <div class="info-box">
                                                    <p class="original-price">$5.88</p>
                                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                                            <div class="playlist-item">
                                                <div class="model-info">
                                                    <a href="/artist/detail">
                                                        <img src="/assets/images/front/p03.jpg" class="rounded-circle">
                                                        <p>夢夢monmon</p>
                                                    </a>
                                                </div>
                                                <a href="javascript:;">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v04.jpg">
                                                    </div>
                                                    <p class="txt-title">上空無遮-樂樂Ｘ瞳瞳【暴風雨】童貞弟弟用媚藥讓姊姊和她的同事色慾覺醒《中文字幕》上空劇情長片動画</p>
                                                </a>
                                                <div class="info-box">
                                                    <p class="original-price">$5.88</p>
                                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                                            <div class="playlist-item">
                                                <div class="model-info">
                                                    <a href="/artist/detail">
                                                        <img src="/assets/images/front/p03.jpg" class="rounded-circle">
                                                        <p>夢夢monmon</p>
                                                    </a>
                                                </div>
                                                <a href="javascript:;">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v04.jpg">
                                                    </div>
                                                    <p class="txt-title">上空無遮-樂樂Ｘ瞳瞳【暴風雨】童貞弟弟用媚藥讓姊姊和她的同事色慾覺醒《中文字幕》上空劇情長片動画</p>
                                                </a>
                                                <div class="info-box">
                                                    <p class="original-price">$5.88</p>
                                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                                            <div class="playlist-item">
                                                <div class="model-info">
                                                    <a href="/artist/detail">
                                                        <img src="/assets/images/front/p03.jpg" class="rounded-circle">
                                                        <p>夢夢monmon</p>
                                                    </a>
                                                </div>
                                                <a href="javascript:;">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v04.jpg">
                                                    </div>
                                                    <p class="txt-title">上空無遮-樂樂Ｘ瞳瞳【暴風雨】童貞弟弟用媚藥讓姊姊和她的同事色慾覺醒《中文字幕》上空劇情長片動画</p>
                                                </a>
                                                <div class="info-box">
                                                    <p class="original-price">$5.88</p>
                                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                                            <div class="playlist-item">
                                                <div class="model-info">
                                                    <a href="/artist/detail">
                                                        <img src="/assets/images/front/p03.jpg" class="rounded-circle">
                                                        <p>夢夢monmon</p>
                                                    </a>
                                                </div>
                                                <a href="javascript:;">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v04.jpg">
                                                    </div>
                                                    <p class="txt-title">上空無遮-樂樂Ｘ瞳瞳【暴風雨】童貞弟弟用媚藥讓姊姊和她的同事色慾覺醒《中文字幕》上空劇情長片動画</p>
                                                </a>
                                                <div class="info-box">
                                                    <p class="original-price">$5.88</p>
                                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-info" role="tabpanel" aria-labelledby="custom-tabs-info-tab">
                                <div class="card-body InfoBox">
                                    <div class="row">
                                        <div class="col-12 profile-field col-md-4"><?=$member->country_title?></div>
                                        <?php if ($member->birthday!='0000/00/00'): ?>
                                            <div class="col-12 profile-field col-md-4"><?=$member->birthday?></div>
                                        <?php endif ?>
                                        <div class="col-12 profile-field col-md-4"><?=$sex[$member->sex]?></div>
                                        <?php if ($member->Facebook_path): ?>
                                            <div class="col-12 profile-field">
                                                <i class="fab fa-facebook-square"></i>
                                                <?=$member->Facebook_path?>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($member->Instagram): ?>
                                            <div class="col-12 profile-field">
                                                <i class="fab fa-instagram"></i>
                                                <?=$member->Instagram?>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($member->Youtube): ?>
                                            <div class="col-12 profile-field">
                                                <i class="fab fa-youtube"></i>
                                                <?=$member->Youtube?>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- 送禮方案 -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" name="gift_add">
                    <input type="hidden" name="give_away_member_id" value="<?=$member->id?>">
                    <div class="modal-header">
                        <h4 class="modal-title">送禮方案</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row gifts">
                            <?php foreach ($gift as $k => $v): ?>
                                <div class="col-6 col-md-3">
                                    <input type="radio" name="gift" id="gift<?=$k+1?>"  value="<?=$v->id?>" class="gift-option">
                                    <label for="gift<?=$k+1?>" class="GiftBox">
                                        <h5><?=$v->title?></h5>
                                        <img src="/<?=$v->img?>">
                                        <div class="price" data-points="<?=$v->points?>"><?=$v->points?><span>(鑽石)</span></div>
                                    </label>
                                </div>
                            <?php endforeach ?>
                    </div>
                    <div>
                        <div class="input-group">
                        <button class="btn btn-send" type="button" id="buttonMinus"> - </button>
                        <input style="text-align: center;" id="qty" type="text" value="1" name="num" class="form-control">
                        <button class="btn btn-send" type="button" id="buttonPlus"> + </button>
                        </div>
                    </div>
                    <div class="pay">支付 0 鑽石</div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary btn-block">確認送禮</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugins/input-spinner/bootstrap-input-spinner.js"></script>
    <!-- ChartJS -->
    <script src="/assets/plugins/chart-2.9.3.js/Chart.min.js"></script>
    <!-- JQVMap -->
    <script src="/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/assets/js/front/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/assets/js/front/moment/moment.min.js"></script>
    <script src="/assets/js/front/daterangepicker/daterangepicker.js"></script>
    <!-- clockpicker -->
    <script src="/assets/plugins/clockpicker/bootstrap-clockpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/assets/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- Ladda -->
    <script src="/assets/plugins/ladda/spin.min.js"></script>
    <script src="/assets/plugins/ladda/ladda.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>

    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script>
        let pointsx=0;
        var ajax_url = '/item_json';
        $.LoadTable=function(){
            var form    =   $('form[name=search]').serialize();
            Page.row=15;
            //Page.cookie_name='activity_page';
            //Page.page=($.cookie(Page.cookie_name))?$.cookie(Page.cookie_name):Page.page;
            $.ajax({
                url:ajax_url,
                type:'POST',
                dataType:'JSON',
                data:form+'&page='+Page.page+'&limit='+Page.row+'&member_id=<?=$member->id?>',
                async:false,
                success:function(data){
                    str='';
                    $.each(data.list,function(i,e){
                        str +=`
                            <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                                <div class="playlist-item">
                                    <div class="model-info">
                                        <a href="/artist/detail/${e.member_id}">
                                            <img src="${(e.member_img||'/assets/images/front/member_default.jpg')}" class="rounded-circle">
                                            <p>${e.nickname}</p>
                                        </a>
                                    </div>
                                    <a href="/album/detail/${e.id}">
                                        <div class="imgbox">
                                            <img src="/uploads/item/image/${e.img}">
                                        </div>
                                        <p class="txt-title">${e.title}</p>
                                    </a>
                                    <div class="info-box" style="display: block;">
                                        <p class="original-price">$${e.USD==0?e.USD:e.USD2}</p>
                                        <p class="view-times"><i class="fa fa-eye"></i>${e.ctr}</p>
                                        ${(e.video_total_length?`<div class="preview-length">${e.video_total_length}</div>`:'')}
                                        ${(e.img_num?`<div class="preview-length">${e.img_num} P</div>`:'')}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    //$("").html(data.total);
                    //Page.DrawPage(data.total);
                    //if(!str)str='<tr><td colspan="9" class="text-center">無作品資料</td></tr>';
                    $('.item_list').html(str);
                }

            });
        };
        $.LoadTable();
        $(document).on('click','.GiftBox',function(){
            pay($(this));
        });

        function pay(div){
            if(div)pointsx=parseInt(div.find('.price').data('points'));
            let qty =parseInt($('#qty').val());
            points=  thousandComma(pointsx*qty);
            $('.pay').html(`支付${points}鑽石`);
        }

        var thousandComma = function(number){
             var num = number.toString();
             var pattern = /(-?\d+)(\d{3})/;
              
             while(pattern.test(num)){
                num = num.replace(pattern, "$1,$2");
              
             }
             return num;     
        }


        var type_add_ajax   =   '/artist/add_gift';
        $('form[name=gift_add]').submit(function(){
            var form    =   $(this);
            var data    =   form.serialize();
            swal({
                title: '確定送禮?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: '確定',
                cancelButtonText: '取消',
                allowOutsideClick:false,
                reverseButtons: true,
            }).then((isConfirm) => {
                if (isConfirm.value) {
                    $.ajax({
                        url:type_add_ajax,
                        type:'POST',
                        dataType:'JSON',
                        data:data,
                        beforeSend:function(){//表單發送前做的事
                            waitingDialog.show();
                        },
                        complete: function () {
                          waitingDialog.hide();
                        },
                        success:function(result){
                            ResultData(result);
                            if(result.status){
                                // Table.LoadTable();
                                // form[0].reset();
                                $('#modal-default').modal('hide');
                            }
                        }
                    });
                }
            });
            return false;
        });


        $(document).on('click','.chat_add',function(){
            var ajax_url='/chat/chat_add/';
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: ajax_url+id,
                dataType: 'json',
                success:function(r){
                    if(r.status){
                        window.location.href='/member/chat';
                    }else{
                        ResultData(r);
                    }
                }

            });
        });

         // 送禮數量設定
        var maxQty = 10; // 最大上限
        $('#buttonPlus').on('click', function(){
            var qty = parseInt($('#qty').val(), 10); // 字串轉數字
            if (qty < maxQty) {
                $('#qty').val(qty + 1)
            }
            pay();
        })
        $('#buttonMinus').on('click', function(){
            var qty = parseInt($('#qty').val(), 10); // 字串轉數字
            if (qty > 1) {
                $('#qty').val(qty - 1)
            }
            pay();
        })


    </script>
</body>
</html>