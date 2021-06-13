<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('front/include/layout_head');?>
    <title><?=$this->web_title?></title>
    <link rel="stylesheet" type="text/css" href="/assets/css/front/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/jquery.scrollbar.css">
    <link rel="stylesheet" href="<?=version('assets/css/front/style.css')?>">
</head>
<body>
    <?php $this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <div class="container-fluid special">
            <div class="row search-area">
                <div class="col-xs-12 col-sm-6">
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="filter-bar">
                        <span>篩選:</span>
                        <span>時間</span>
                        <span>價格</span>
                        <span>觀看次數</span>
                        <div class="btn-group">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">尺度
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">全部</a>
                                <a class="dropdown-item" href="#">上空</a>
                                <a class="dropdown-item" href="#">遮點</a>
                                <a class="dropdown-item" href="#">內、睡衣</a>
                                <a class="dropdown-item" href="#">比基尼</a>
                                <a class="dropdown-item" href="#">誘惑</a>
                            </div>
                        </div>
                    </div>
                    <div class="flag">
                        <span>國籍選擇:</span>
                        <a href="#" style="background-image: url('/assets/images/front/JP.jpg');"></a>
                        <a href="#" style="background-image: url('/assets/images/front/UA.jpg');"></a>
                        <a href="#" style="background-image: url('/assets/images/front/TH.jpg');"></a>
                        <a href="#" style="background-image: url('/assets/images/front/TW.jpg');"></a>
                    </div>
                </div>
            </div>
            <div class="unit_title">
                <h2 class="title-txt">特別企劃</h2>
            </div>
            <div class="card-content">
                <div class="row list">
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <div class="special_list">
                            <div class="ImgBox"><a href="javascript:;"><img src="/assets/images/front/s01.jpg"></a></div>
                            <div class="txt-title"><a href="#">
                                    <h3>月宮寂寞騷美人</h3>
                                </a></div>
                            <div class="row InfoBox">
                                <div class="col-xs-12 col-sm-6 model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 func-box">
                                    <p class="original-price">$5.88</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <div class="special_list">
                            <div class="ImgBox"><a href="javascript:;"><img src="/assets/images/front/s01.jpg"></a></div>
                            <div class="txt-title"><a href="#">
                                    <h3>月宮寂寞騷美人</h3>
                                </a></div>
                            <div class="row InfoBox">
                                <div class="col-xs-12 col-sm-6 model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 func-box">
                                    <p class="original-price">$5.88</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <div class="special_list">
                            <div class="ImgBox"><a href="javascript:;"><img src="/assets/images/front/s01.jpg"></a></div>
                            <div class="txt-title"><a href="#">
                                    <h3>月宮寂寞騷美人</h3>
                                </a></div>
                            <div class="row InfoBox">
                                <div class="col-xs-12 col-sm-6 model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 func-box">
                                    <p class="original-price">$5.88</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <div class="special_list">
                            <div class="ImgBox"><a href="javascript:;"><img src="/assets/images/front/s01.jpg"></a></div>
                            <div class="txt-title"><a href="#">
                                    <h3>月宮寂寞騷美人</h3>
                                </a></div>
                            <div class="row InfoBox">
                                <div class="col-xs-12 col-sm-6 model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 func-box">
                                    <p class="original-price">$5.88</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <div class="special_list">
                            <div class="ImgBox"><a href="javascript:;"><img src="/assets/images/front/s01.jpg"></a></div>
                            <div class="txt-title"><a href="#">
                                    <h3>月宮寂寞騷美人</h3>
                                </a></div>
                            <div class="row InfoBox">
                                <div class="col-xs-12 col-sm-6 model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 func-box">
                                    <p class="original-price">$5.88</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <div class="special_list">
                            <div class="ImgBox"><a href="javascript:;"><img src="/assets/images/front/s01.jpg"></a></div>
                            <div class="txt-title"><a href="#">
                                    <h3>月宮寂寞騷美人</h3>
                                </a></div>
                            <div class="row InfoBox">
                                <div class="col-xs-12 col-sm-6 model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 func-box">
                                    <p class="original-price">$5.88</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>77K</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <nav aria-label="Contacts Page Navigation">
                        <ul class="pagination justify-content-center m-0">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
</body>
</html>