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
    <style>
        .copy-content {
            border: 1px solid #aaa;
            border-radius: 5px;
            padding: 5px 7px;
            font-size: 16px;
        }
        .copy-content::after {
            content: ''
        }
    </style>

</head>
<body>
    <?php //$this->load->view('front/include/include_cover18');?>
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
                        <!-- <div class="toolbar">
                            <button data-toggle="modal" data-target="#modal-default"><i class="fas fa-gift"></i><span>??????</span></button>
                            <button onclick="window.location.href='/member/chat'"><i class="fab fa-telegram-plane"></i><span>??????</span></button>
                        </div> -->
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
                        <div class="scoreboard"><i class="far fa-clock"></i>???????????? <?=$member->create_date?></div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-img-tab" data-toggle="pill" href="#custom-tabs-img" role="tab" aria-controls="custom-tabs-img" aria-selected="true">??????/??????</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-info-tab" data-toggle="pill" href="#custom-tabs-info" role="tab" aria-controls="custom-tabs-info" aria-selected="false">??????</a>
                                </li>
                                <li class="nav-item d-none">
                                    <a class="nav-link" id="custom-tabs-account-tab" data-toggle="pill" href="#custom-tabs-account" role="tab" aria-controls="custom-tabs-account" aria-selected="false">????????????</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-img" role="tabpanel" aria-labelledby="custom-tabs-img-tab">
                                <div class="card-body">
                                    <div class="row list item_list">
                                        <!-- <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                                            <div class="playlist-item">
                                                <div class="model-info">
                                                    <a href="/artist/detail">
                                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                                        <p>??????monmon</p>
                                                    </a>
                                                </div>
                                                <a href="/album/detail">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v02.jpg">
                                                    </div>
                                                    <p class="txt-title">??????????????? ????????????...</p>
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
                                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                                        <p>??????monmon</p>
                                                    </a>
                                                </div>
                                                <a href="/album/detail">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v02.jpg">
                                                    </div>
                                                    <p class="txt-title">??????????????? ????????????...</p>
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
                                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                                        <p>??????monmon</p>
                                                    </a>
                                                </div>
                                                <a href="/album/detail">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v02.jpg">
                                                    </div>
                                                    <p class="txt-title">??????????????? ????????????...</p>
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
                                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                                        <p>??????monmon</p>
                                                    </a>
                                                </div>
                                                <a href="/album/detail">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v02.jpg">
                                                    </div>
                                                    <p class="txt-title">??????????????? ????????????...</p>
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
                                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                                        <p>??????monmon</p>
                                                    </a>
                                                </div>
                                                <a href="/album/detail">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v02.jpg">
                                                    </div>
                                                    <p class="txt-title">??????????????? ????????????...</p>
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
                                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                                        <p>??????monmon</p>
                                                    </a>
                                                </div>
                                                <a href="/album/detail">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v02.jpg">
                                                    </div>
                                                    <p class="txt-title">??????????????? ????????????...</p>
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
                                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                                        <p>??????monmon</p>
                                                    </a>
                                                </div>
                                                <a href="/album/detail">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v02.jpg">
                                                    </div>
                                                    <p class="txt-title">??????????????? ????????????...</p>
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
                                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                                        <p>??????monmon</p>
                                                    </a>
                                                </div>
                                                <a href="/album/detail">
                                                    <div class="imgbox">
                                                        <img src="/assets/images/front/v02.jpg">
                                                    </div>
                                                    <p class="txt-title">??????????????? ????????????...</p>
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
                                        <?php if ($member->type!=1): ?>
                                            <div class="col-12 profile-field">
                                                <i class="fas fa-link"></i><span style="margin-left: 7px;">??????????????????</span>
                                                <div class="row">
                                                    <div id="link" class="copy-content col-12 col-sm-6"><?=$member_URL?></div>
                                                    <div class="col-12 col-sm-3">
                                                        <button data-clipboard-text="<?=$member_URL?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="?????????????????????" id="copyBtn" class="btn btn-send">????????????</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 profile-field">
                                                <i class="fas fa-qrcode"></i><span style="margin-left: 7px;">????????????QRcode</span>
                                                <br>
                                                <div id="qrcode" style="width: 175px;background-color: #fff;padding: 20px;"></div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-account" role="tabpanel" aria-labelledby="custom-tabs-account-tab">
                                <div class="card-body"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- ???????????? -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">????????????</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row gifts">
                        <div class="col-6 col-md-3">
                            <input type="radio" name="gift" id="gift1" class="gift-option">
                            <label for="gift1" class="GiftBox">
                                <h5>??????</h5>
                                <img src="/assets/images/front/flower.png">
                                <div class="price">2500<span>(??????)</span></div>
                            </label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="radio" name="gift" id="gift2" class="gift-option">
                            <label for="gift2" class="GiftBox">
                                <h5>??????</h5>
                                <img src="/assets/images/front/perfume.png">
                                <div class="price">10000<span>(??????)</span></div>
                            </label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="radio" name="gift" id="gift3" class="gift-option">
                            <label for="gift3" class="GiftBox">
                                <h5>??????</h5>
                                <img src="/assets/images/front/diamondRing.png">
                                <div class="price">20000<span>(??????)</span></div>
                            </label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="radio" name="gift" id="gift4" class="gift-option">
                            <label for="gift4" class="GiftBox">
                                <h5>??????</h5>
                                <img src="/assets/images/front/car.png">
                                <div class="price">50000<span>(??????)</span></div>
                            </label>
                        </div>
                    </div>
                    <form action="">
                        <div class="input-group">
                        <button class="btn btn-send" type="button" id="buttonMinus"> - </button>
                        <input style="text-align: center;" id="qty" type="text" value="1" name="qty" class="form-control">
                        <button class="btn btn-send" type="button" id="buttonPlus"> + </button>    
                        </div>
                    </form>
                    <p class="pay">?????? 2,500 ??????</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary btn-block">????????????</button>
                </div>
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
    <!-- <script src="/assets/plugins/chart-2.9.3.js/Chart.min.js"></script> -->
    <!-- Sparkline -->
    <!-- <script src="/assets/plugins/sparklines/sparkline.js"></script> -->
    <!-- JQVMap -->
    <!-- <script src="/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
    <!-- jQuery Knob Chart -->
    <script src="/assets/js/front/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/assets/js/front/moment/moment.min.js"></script>
    <script src="/assets/js/front/daterangepicker/daterangepicker.js"></script>
    <!-- clockpicker -->
    <script src="/assets/plugins/clockpicker/bootstrap-clockpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <!-- <script src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
    <!-- Summernote -->
    <!-- <script src="/assets/plugins/summernote/summernote-bs4.min.js"></script> -->
    <!-- overlayScrollbars -->
    <script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- Ladda -->
    <script src="/assets/plugins/ladda/spin.min.js"></script>
    <script src="/assets/plugins/ladda/ladda.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/plugins/adminLTE/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="/assets/plugins/adminLTE/js/pages/dashboard.js"></script> -->
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="/assets/plugins/adminLTE/js/demo.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script> -->
    <!-- ???????????? -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script src="<?=version('/assets/js/Qrcode/qrcode.min.js')?>"></script>
    <script>
    $.widget.bridge('uibutton', $.ui.button);
    $("input[type='number']").inputSpinner();
    $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
    Ladda.bind('button.ladda-button', {
        callback: function(instance) {
            var progress = 0;
            var interval = setInterval(function() {
                progress = Math.min(progress + Math.random() * 0.1, 1);
                instance.setProgress(progress);
                if (progress === 1) {
                    instance.stop();
                    clearInterval(interval);
                }
            }, 20);
        }
    });
    $(function() {
        // ????????????
        var clipboard = new ClipboardJS('#copyBtn');
        var copy = document.getElementById('copyBtn');
        var tooltip = new bootstrap.Tooltip(copy, {
            trigger: 'manual',
        })
        clipboard.on('success', function(e) {
            tooltip.show()
            setTimeout(function() {
                tooltip.hide()
            }, 2000)
        });

        clipboard.on('error', function(e) {

        });

        // ??????????????????
        var maxQty = 10; // ????????????
        $('#buttonPlus').on('click', function(){
            var qty = parseInt($('#qty').val(), 10); // ???????????????
            if (qty < maxQty) {
                $('#qty').val(qty + 1)
            }
        })
        $('#buttonMinus').on('click', function(){
            var qty = parseInt($('#qty').val(), 10); // ???????????????
            if (qty > 1) {
                $('#qty').val(qty - 1)
            }
        })
        //Enable check and uncheck all functionality
        $('.checkbox-toggle').click(function() {
            var clicks = $(this).data('clicks')
            if (clicks) {
                //Uncheck all checkboxes
                $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
                $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
            } else {
                //Check all checkboxes
                $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
                $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
            }
            $(this).data('clicks', !clicks)
        })
    })
    //Date range picker
    $('#reservation').daterangepicker()
    $('.clockpicker').clockpicker()
        .find('input').change(function() {
            console.log(this.value);
        });
    var input = $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $('.clockpicker-with-callbacks').clockpicker({
            donetext: 'Done',
            init: function() {
                console.log("colorpicker initiated");
            },
            beforeShow: function() {
                console.log("before show");
            },
            afterShow: function() {
                console.log("after show");
            },
            beforeHide: function() {
                console.log("before hide");
            },
            afterHide: function() {
                console.log("after hide");
            },
            beforeHourSelect: function() {
                console.log("before hour selected");
            },
            afterHourSelect: function() {
                console.log("after hour selected");
            },
            beforeDone: function() {
                console.log("before done");
            },
            afterDone: function() {
                console.log("after done");
            }
        })
        .find('input').change(function() {
            console.log(this.value);
        });
    // Manually toggle to the minutes view
    $('#check-minutes').click(function(e) {
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show')
            .clockpicker('toggleView', 'minutes');
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }

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
                                        <p class="original-price">$${e.USD>0?e.USD2:e.USD}</p>
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
                    //if(!str)str='<tr><td colspan="9" class="text-center">???????????????</td></tr>';
                    $('.item_list').html(str);
                }

            });
        };
        $.LoadTable();
        $(function () {
          qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "<?=$member_URL?>",
            width: 140,
            height: 140
          });
        });
    </script>
</body>
</html>