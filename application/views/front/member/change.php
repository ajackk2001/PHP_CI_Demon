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
    <?php //$this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <section class="member">
            <div class="container-fluid">
                <div class="inner">
                    <div class="content">
                        <div class="row">    
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="InfoBox">
                                        <div class="unit_title">
                                            <h3 class="title-txt text-left">密碼變更</h3>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label class=" col-form-label"><span class="redtxt">請輸入密碼</label>
                                                <input type="text" class="form-control" placeholder="8-12碼英數字">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class=" col-form-label">再次確認</label>
                                                <input type="text" class="form-control" placeholder="再次確認輸入">
                                            </div>
                                        </div>
                                        <div class="btn-box"> <button class="btn btn-send" type="submit" onclick="location.href='#'" type="button">確認送出</button> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script>
    $('.member a.item').click(function(e) {
        //remove all the "Over" class, so that the arrow reset to default
        $('.member a.item').not(this).each(function() {
            if ($(this).attr('rel') != '') {
                $(this).removeClass($(this).attr('rel') + 'Over');
            }
            $(this).siblings('ul').slideUp("slow");
        });
        //showhide the selected submenu
        $(this).siblings('ul').slideToggle("slow");
        //addremove Over class, so that the arrow pointing downup
        $(this).toggleClass($(this).attr('rel') + 'Over');
        e.preventDefault();
    });
    </script>
</body>
</html>