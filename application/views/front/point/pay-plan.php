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
</head>
<body>
    <?php $this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <section class="edit-page">
            <div class="container">
                <div class="unit_title">
                    <h2 class="title-txt">購買方案</h2>
                </div>
                <div class="content pay-plan">
                    <ul class="list">
                        <?php foreach ($points_program as $k => $v): ?>
                            <li>
                                <a href="javascript:;">
                                    <div class="ImgBox">
                                        <div class="point"><i class="fas fa-gem" style="font-size: 0.7em;margin-right:10px;"></i><?=$v->points?></div>
                                        <div class="text"><?=$v->discount>0?"優惠{$v->discount}%":""?></div>
                                        <div class="text"><?=$v->USD2?> USD</div>
                                    </div>
                                    <div class="InfoBox">
                                        <p class="add_point" data-points_program_id="<?=$v->id?>">我要購買</p>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach ?>
                        <!-- <li><a href="/payment">
                                <div class="ImgBox">
                                    <div class="point"><i class="fas fa-gem" style="font-size: 0.7em;margin-right:10px;"></i>4500</div>
                                    <div class="text">優惠11%</div>
                                    <div class="text">9.99 USD</div>
                                </div>
                                <div class="InfoBox">
                                    <select class="form-control d-none">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                    <p>我要購買</p>
                                </div>
                            </a>
                        </li>
                        <li><a href="/payment">
                                <div class="ImgBox">
                                    <div class="point"><i class="fas fa-gem" style="font-size: 0.7em;margin-right:10px;"></i>4500</div>
                                    <div class="text">優惠11%</div>
                                    <div class="text">9.99 USD</div>
                                </div>
                                <div class="InfoBox">
                                    <select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                    <p>我要購買</p>
                                </div>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </section>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script type="text/javascript">
         $(document).on('click','.add_point',function(){
            var points_program_id = $(this).data('points_program_id');
            var form = $("<form method='post'></form>");
            form.attr({"action":'/payment'});
            $("body").append($(form));
            var str =`
                <input type="hidden" name="points_program_id" value="${points_program_id}">
            `;
            form.html(str);
            form.submit();
            return false;
        });
    </script>
</body>
</html>