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
        <div class="container-fluid video">
            <div class="row search-area">
                <div class="col-xs-12 col-sm-6">
                    <div class="TagsBox">
                        <ul id="level1" class="level1">
                            <li>
                                <a href="javascript:;">全部</a>
                            </li>
                            <li>
                                <a href="javascript:;" data-category="1">大尺度</a>
                            </li>
                            <li>
                                <a href="javascript:;" data-category="2">服裝</a>
                            </li>
                            <li><a href="javascript:;" data-category="3">絲襪</a></li>
                            <li><a href="javascript:;">運動</a></li>
                            <li><a href="javascript:;">劇情</a></li>
                        </ul>
                        <ul id="level2" class="level2">
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="filter-bar">
                        <span>篩選:</span>
                        <span class="filter-item" data-filter="time">時間</span>
                        <span id="time" class="vertical-arrows down arrow-up active">
                            <img src="/assets/images/front/sort-arrow.svg" class="up arrow" alt="">
                            <img src="/assets/images/front/sort-arrow.svg" class="down arrow">
                        </span>
                        <span class="filter-item" data-filter="price">價格</span>
                        <span id="price" class="vertical-arrows down arrow-up">
                            <img src="/assets/images/front/sort-arrow.svg" class="up arrow" alt="">
                            <img src="/assets/images/front/sort-arrow.svg" class="down arrow">
                        </span>
                        <span class="filter-item" data-filter="view">觀看次數</span>
                        <span id="view" class="vertical-arrows down arrow-up">
                            <img src="/assets/images/front/sort-arrow.svg" class="up arrow" alt="">
                            <img src="/assets/images/front/sort-arrow.svg" class="down arrow">
                        </span>
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
                        <input type="radio" name="country" id="country-jp">
                        <label for="country-jp" style="background-image: url('/assets/images/front/JP.png');"></label>
                        <input type="radio" name="country" id="country-ua">
                        <label for="country-ua" style="background-image: url('/assets/images/front/UA.jpg');"></label>
                        <input type="radio" name="country" id="country-th">
                        <label for="country-th" style="background-image: url('/assets/images/front/TH.jpg');"></label>
                        <input type="radio" name="country" id="country-tw">
                        <label for="country-tw" style="background-image: url('/assets/images/front/TW.png');"></label>
                    </div>
                </div>
            </div>
            <div class="unit_title">
                <h2 class="title-txt">視頻</h2>
            </div>
            <div class="card-content">
                <div class="col-md-12">
                    <div class="row list">
                        <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                            <div class="playlist-item">
                                <div class="model-info">
                                    <a href="/artist/detail">
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v01.jpg">
                                    </div>
                                    <p class="txt-title">陽光沙灘比基尼－魏梔檸 (尤物 ...</p>
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
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v01.jpg">
                                    </div>
                                    <p class="txt-title">陽光沙灘比基尼－魏梔檸 (尤物 ...</p>
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
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v01.jpg">
                                    </div>
                                    <p class="txt-title">陽光沙灘比基尼－魏梔檸 (尤物 ...</p>
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
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v01.jpg">
                                    </div>
                                    <p class="txt-title">陽光沙灘比基尼－魏梔檸 (尤物 ...</p>
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
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v01.jpg">
                                    </div>
                                    <p class="txt-title">陽光沙灘比基尼－魏梔檸 (尤物 ...</p>
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
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v01.jpg">
                                    </div>
                                    <p class="txt-title">陽光沙灘比基尼－魏梔檸 (尤物 ...</p>
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
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v01.jpg">
                                    </div>
                                    <p class="txt-title">陽光沙灘比基尼－魏梔檸 (尤物 ...</p>
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
                                        <img src="/assets/images/front/p01.jpg" class="rounded-circle">
                                        <p>Jessica 羅穎</p>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="imgbox">
                                        <img src="/assets/images/front/v01.jpg">
                                    </div>
                                    <p class="txt-title">陽光沙灘比基尼－魏梔檸 (尤物 ...</p>
                                </a>
                                <div class="info-box">
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
        </div>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script>
        $(function() {
            // 列出所有次分類
            var level2 = [
                {
                    id: 1,
                    category: 1,
                    name: '子分類1'
                },
                {
                    id: 2,
                    category: 2,
                    name: '子分類2'
                },
                {
                    id: 3,
                    category: 3,
                    name: '子分類3'
                },
                {
                    id: 4,
                    category: 4,
                    name: '子分類4'
                }
            ]
            // 會選取 #level1的選單中 data-category 相對應的分類
            $('#level1 li a').on('click', function() {
                var category = $(this).data('category')
                var selectLevel2 = level2.filter(function(item){
                    return item.category === category
                });

                var level2menu = '';
                for (var i=0; i< selectLevel2.length; i++) {
                    level2menu += '<li><a href="javascript:;">'+ selectLevel2[i].name +'</a></li>';
                }
                $('#level2').html(level2menu);
            })
            // 點擊的篩選項目顯示箭頭
            $('.filter-item').on('click', function(){
                $('.vertical-arrows').removeClass('active');
                var selectFilter = $('#'+$(this).data('filter'));
                selectFilter.addClass('active');
            })
            // 箭頭上下切換
            $('.vertical-arrows').on('click', function() {
                if($(this).hasClass('arrow-up')) {
                    $(this).removeClass('arrow-up').addClass('arrow-down');
                    return;
                }
                if($(this).hasClass('arrow-down')) {
                    $(this).removeClass('arrow-down').addClass('arrow-up');
                    return;
                }
            })
        });
    </script>
</body>
</html>