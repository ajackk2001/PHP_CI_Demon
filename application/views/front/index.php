<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <?php $this->load->view('front/include/layout_head');?>
    <title><?=$this->web_title?></title>
    <link rel="stylesheet" type="text/css" href="/assets/css/front/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/jquery.scrollbar.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?=version('assets/css/front/style.css')?>">
    <style>
        .category {
            text-align: center;
        }
    </style>
<body>
    <?php $this->load->view('front/include/include_cover18');?>
    <?php if (!empty($about_form->content)): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
             <a class="top-message" href="<?=$about_form->weblink?$about_form->weblink:'javascript:;'?>"><?=$about_form->content?></a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
    <?php $this->load->view('front/include/include_header');?>
    <div class="container-fluid banner">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php foreach ($banner as $k => $v): ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?=$k?>" class="<?=$k==0?"active":""?>"></li>
                <?php endforeach ?>
                <!-- <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> -->
            </ol>
            <div class="carousel-inner">
                <?php foreach ($banner as $k => $v): ?>
                    <div class="carousel-item <?=$k==0?"active":""?>">
                        <a href="<?=$v->weblink?$v->weblink:"javascript:"?>">
                            <img class="d-block w-100" src="/<?=$v->img?>" alt="">
                        </a>
                    </div>
                <?php endforeach ?>
                <!-- <div class="carousel-item">
                    <img class="d-block w-100" src="/assets/images/front/banner01.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="/assets/images/front/banner01.jpg" alt="Third slide">
                </div> -->
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <main>
        <div class="container-fluid unit-box">
            <div class="card-content">
                <div class="unit_title">
                    <h2><a href="javascript:;"><span>每日更新</span>高畫質寫真</a></h2>
                </div>
                <div class="unit">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php foreach ($item as $k => $v): ?>
                                <div class="swiper-slide playlist-item" style="">
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
                                        <p class="original-price">$<?=$v->USD==0?$v->USD:$v->USD2?></p>
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
        <div class="container-fluid unit-box d-none">
            <div class="card-content">
                <div class="unit_title">
                    <h2><a href="javascript:;"><span>最新上傳影片</span>Girls</a></h2>
                </div>
                <div class="unit">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <!-- <div class="swiper-slide playlist-item">
                                <div class="model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                        <p>夢夢monmon</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v02.jpg">
                                    </div>
                                    <p class="txt-title">情色野球拳 兩女一男...</p>
                                </a>
                                <div class="info-box">
                                    <p class="original-price">$7.99</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                            <div class="swiper-slide playlist-item">
                                <div class="model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                        <p>夢夢monmon</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v02.jpg">
                                    </div>
                                    <p class="txt-title">情色野球拳 兩女一男...</p>
                                </a>
                                <div class="info-box">
                                    <p class="original-price">$7.99</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                            <div class="swiper-slide playlist-item">
                                <div class="model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                        <p>夢夢monmon</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v02.jpg">
                                    </div>
                                    <p class="txt-title">情色野球拳 兩女一男...</p>
                                </a>
                                <div class="info-box">
                                    <p class="original-price">$7.99</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                            <div class="swiper-slide playlist-item">
                                <div class="model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                        <p>夢夢monmon</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v02.jpg">
                                    </div>
                                    <p class="txt-title">情色野球拳 兩女一男...</p>
                                </a>
                                <div class="info-box">
                                    <p class="original-price">$7.99</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                            <div class="swiper-slide playlist-item">
                                <div class="model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                        <p>夢夢monmon</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v02.jpg">
                                    </div>
                                    <p class="txt-title">情色野球拳 兩女一男...</p>
                                </a>
                                <div class="info-box">
                                    <p class="original-price">$7.99</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                            <div class="swiper-slide playlist-item">
                                <div class="model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                        <p>夢夢monmon</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v02.jpg">
                                    </div>
                                    <p class="txt-title">情色野球拳 兩女一男...</p>
                                </a>
                                <div class="info-box">
                                    <p class="original-price">$7.99</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                            <div class="swiper-slide playlist-item">
                                <div class="model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p02.jpg" class="rounded-circle">
                                        <p>夢夢monmon</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v02.jpg">
                                    </div>
                                    <p class="txt-title">情色野球拳 兩女一男...</p>
                                </a>
                                <div class="info-box">
                                    <p class="original-price">$7.99</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid unit-box">
            <div class="unit_title">
                <h2><a href="javascript:;"><span>熱門分類</span>就在這</a></h2>
            </div>
            <div class="container-fluid">
                <div class="row category">
                    <?php foreach ($popular as $k => $v): ?>
                        <div class="col-6 col-md-1"><a href="/album?type_id=<?=$v->type_id?>&category_id=<?=$v->category_id?>"><img src="<?=$v->img?>" class="rounded-circle"><p class="name"><?=$v->category_title?></p></div>
                    <?php endforeach ?>
                    <!-- <div class="col-6 col-md-1"><a href="/models"><img src="/assets/images/front/category02.png" class="rounded-circle"></div>
                    <div class="col-6 col-md-1"><a href="/models"><img src="/assets/images/front/category03.png" class="rounded-circle"></div>
                    <div class="col-6 col-md-1"><a href="/models"><img src="/assets/images/front/category04.png" class="rounded-circle"></div> -->
                </div>
            </div>
        </div>
        <div class="container-fluid unit-box">
            <div class="card-content">
                <div class="unit_title">
                    <h2><a href="javascript:;"><span>熱門解鎖的</span>模特兒</a></h2>
                </div>
                <div class="container-fluid">
                    <div class="row popular-list">
                        <?php foreach ($model as $k => $v): ?>
                            <div class="col-3 col-md-1">
                                <a href="/artist/detail/<?=$v->id?>">
                                    <img src="<?=$v->img?$v->img:"/assets/images/front/member_default.jpg"?>" class="rounded-circle">
                                    <p class="name"><?=$v->nickname?></p>
                                </a>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid unit-box">
            <div class="card-content">
                <div class="unit_title">
                    <h2><a href="javascript:;"><span>超熱銷創作者</span>頻道</a></h2>
                </div>
                <div class="container-fluid">
                    <div class="row popular-list">
                        <?php foreach ($creator as $k => $v): ?>
                            <div class="col-3 col-md-1">
                                <a href="/artist/detail/<?=$v->id?>">
                                    <img src="<?=$v->img?$v->img:"/assets/images/front/member_default.jpg"?>" class="rounded-circle">
                                    <p class="name"><?=$v->nickname?></p>
                                </a>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid Ad-area">
            <?php if (!empty($advertising_img)): ?>
                <div class="row Ad-box">
                    <div class="col-lg-6 p-0">
                        <div class="large_item set-bg" style="background-image: url(/<?=$advertising_img->img1?>);"><a href="<?=$advertising_img->weblink1?$advertising_img->weblink1:"javascript:"?>"></a></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-6 p-0">
                                <div class="medium_item set-bg" style="background-image: url(/<?=$advertising_img->img2?>);"><a href="<?=$advertising_img->weblink2?$advertising_img->weblink2:"javascript:"?>"></a></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                                <div class="medium_item set-bg" style="background-image: url(/<?=$advertising_img->img3?>);"><a href="<?=$advertising_img->weblink3?$advertising_img->weblink3:"javascript:"?>"></a></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                                <div class="medium_item set-bg" style="background-image: url(/<?=$advertising_img->img4?>);"><a href="<?=$advertising_img->weblink4?$advertising_img->weblink4:"javascript:"?>"></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <?php if (!empty($banner_img)): ?>
                <div class="row Ad-box ad_medium">
                    <?php foreach ($banner_img as $k => $v): ?>
                        <div class="col-lg-4 p-0">
                            <div class="medium_item set-bg" style="background-image: url(/<?=$v->img?>);"><a href="<?=$v->weblink?$v->weblink:"javascript:"?>"></a></div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.easing.1.3.js"></script>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 2,
        spaceBetween: 10,
        // init: false,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 40,
            },
            1024: {
                slidesPerView: 6,
                spaceBetween: 50,
            },
        }
    });

    </script>
</body>
</html>