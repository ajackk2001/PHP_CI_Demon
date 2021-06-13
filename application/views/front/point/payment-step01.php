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
        <section class="edit-page">
            <div class="container">
                <div class="unit_title">
                    <h3 class="title-txt text-left">付款明細</h3>
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap projects">
                                    <thead>
                                        <tr>
                                            <th>訂單日期</th>
                                            <th>項目</th>
                                            <th>價格</th>
                                            <th>狀態</th>
                                            <th>其他</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?=date("Y年m月d日")?></td>
                                            <td><?=$points->title?></td>
                                            <td><?=$points->USD2?></td>
                                            <td>待付款</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <nav aria-label="Contacts Page Navigation">
                                    <ul class="pagination justify-content-center m-0">

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-info-tab" data-toggle="pill" href="#custom-tabs-info" role="tab" aria-controls="custom-tabs-info" aria-selected="false">信用卡付款</a>
                            </li>
                            <li class="nav-item d-none">
                                <a class="nav-link" id="custom-tabs-img-tab" data-toggle="pill" href="#custom-tabs-img" role="tab" aria-controls="custom-tabs-img" aria-selected="true">ATM付款</a>
                            </li>
                            <li class="nav-item d-none">
                                <a class="nav-link" id="custom-tabs-type-tab" data-toggle="pill" href="#custom-tabs-type" role="tab" aria-controls="custom-tabs-type" aria-selected="false">便利商店繳費</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-info" role="tabpanel" aria-labelledby="custom-tabs-info-tab">
                            <div class="card-body">
                                <div class="custom-control custom-radio">
                                    <input id="atm" name="pay01" type="radio" class="custom-control-input" required>
                                    <p>使用新的信用卡或簽帳金融卡<br>
                                    付款成功後請稍待約 10 分鐘系統入帳</p>
                                </div>
                            </div>
                            <div class="btn-box text-center pay-btn-area create_order"> <button class="btn btn-send" type="button" data-payment_type="Credit">信用卡付款</button> </div>
                            <p style="text-align:center">輕觸「信用卡付款」即表示您接受以下服務條款：《<a href="/terms" target="_blank">TAIHOT 服務條款</a>》 《<a href="/privacy" target="_blank">TAIHOT 隱私權條款</a>》 。</p>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-img" role="tabpanel" aria-labelledby="custom-tabs-img-tab">
                            <div class="card-body">
                                <p>僅限台灣地區<br>付款後請稍待約 1 小時系統入帳</p>
                            </div>
                            <div class="btn-box text-center pay-btn-area create_order"> <button class="btn btn-send" type="button" data-payment_type="ATM">ATM付款</button>
                            </div>
                            <p style="text-align:center">輕觸「ATM付款」即表示您接受以下服務條款：《<a href="/terms" target="_blank">TAIHOT 服務條款</a>》 《<a href="/privacy" target="_blank">TAIHOT 隱私權條款</a>》 。</p>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-type" role="tabpanel" aria-labelledby="custom-tabs-type-tab">
                            <div class="card-body">
                                <p>僅限台灣地區<br>付款後請稍待約 1 小時系統入帳</p>
                            </div>
                            <div class="btn-box text-center pay-btn-area create_order"> <button class="btn btn-send" type="button" data-payment_type="CVS">便利商店繳費</button>
                            </div>
                            <p style="text-align:center">輕觸「便利商店繳費」即表示您接受以下服務條款：《<a href="/terms" target="_blank">TAIHOT 服務條款</a>》 《<a href="/privacy" target="_blank">TAIHOT 隱私權條款</a>》 。</p>
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
    <script type="text/javascript">
        $(document).on('click','.create_order',function(){
            var payment_type = $(this).find('button').data('payment_type');
            //$('input[name="contact_address"]').val(addr);
            if(true){
                var form = $(this);
                var data    =   form.serialize();
                swal({
                    title: '確定送出訂單?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定',
                    cancelButtonText: '取消',
                    allowOutsideClick:false,
                    reverseButtons: true,
                }).then((result) => {
                    if (result.value) {
                        var form = $("<form method='post'></form>");
                        form.attr({"action":'<?=$pay_url?>'});
                        $("body").append($(form));
                        var str =`
                            <input type="hidden" name="payment_type" value="${payment_type}">
                        `;
                        form.html(str);
                        form.submit();
                    }
                });
            }
            return false;
        });

    </script>
</body>
</html>