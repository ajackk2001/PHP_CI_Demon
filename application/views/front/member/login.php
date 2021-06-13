<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('front/include/layout_head');?>
    <title><?=$this->web_title?></title>
    <link rel="stylesheet" type="text/css" href="/assets/css/front/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/jquery.scrollbar.css">
    <link rel="stylesheet" href="<?=version('assets/css/front/style.css')?>">
    <link rel="stylesheet" href="<?=version('assets/css/front/loading.css')?>">
</head>
<body>
    <?php //$this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <section class="login">
            <div class="content">
                <div class="unit_title">
                    <h2 class="title-txt">會員登入</h2>
                </div>
                <hr>
                <form class="form-signin" name="login">
                    <button class="btn btn-google btn-block api" type="button" data-url="/Google/Login">
                        <div class="row">
                            <div class="col-3 col-md-3"><img src="/assets/images/front/icon-google.png"></div><span class="col-9 col-md-9 col-form-label">使用 Google 帳號登入</span>
                        </div>
                    </button>
                    <button class="btn btn-fb btn-block api" type="button" data-url="/Facebook/Login">
                        <div class="row">
                            <div class="col-3 col-md-3"><img src="/assets/images/front/icon-fb.png"></div><span class="col-9 col-md-9 col-form-label">使用 Facebook 帳號登入</span>
                        </div>
                    </button>
                    <button class="btn btn-line btn-block api" type="button" data-url="/Line/Login">
                        <div class="row">
                            <div class="col-3 col-md-3"><img src="/assets/images/front/icon-line.png"></div><span class="col-9 col-md-9 col-form-label">使用 LINE 帳號登入</span>
                        </div>
                    </button>
                    <hr>
                    <div class="EmailBox loginMailSend">
                        <p class="text-left">使用 E-mail 登入會員</p>
                        <input type="email" id="inputEmail" class="form-control" placeholder="請輸入Email" >
                        <div class="text-right">
                            <button class="btn btn-send"  type="button">送出驗證信</button>
                        </div>
                    </div>
                    <div class="login_div d-none">
                        <input type="text"  class="form-control" placeholder="請輸入驗證碼" required autocomplete="off" name="captcha">
                        <input type="hidden" name="email" value="">
                        <button class="btn btn-login btn-block" type="submit">登入</button>
                    </div>
                    <p class="text-left mt-4">完成登入即表示已閱讀瞭解並同意接受「 <a href="/terms">服務條款</a> 」之所有政策內容，也完全接受現有及未來可能衍生的服務項目及內容。</p>
                </form>
            </div>
        </section>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script type="text/javascript">
        $('.api').click(function(){
            location.href=$(this).data('url');
        });
        $('.loginMailSend button').on('click',  function(event) {
            let email = $('#inputEmail').val();
            if(checkEmail(email)){
                var message_captcha_ajax  = '/Mail/loginCaptcha';
                $.ajax({
                    url:message_captcha_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:{email:email},
                    beforeSend: function () {
                      waitingDialog.show();
                    },
                    complete: function () {
                      waitingDialog.hide();
                    },
                    success:function(result){
                        if(result.status){
                            swal(
                              '發送成功',
                              '驗證碼已傳送到您的信箱',
                              'success',
                            );
                            $('.loginMailSend').addClass('send');
                            $('.loginMailSend').find('input').attr('disabled', true);
                            $('.loginMailSend').find('button').attr('disabled', true)
                            $('.login_div').removeClass('d-none');
                            $('[name="email"]').val(email);
                        }else{
                            ResultData(result);
                        }
                    }
                });
            }else{
                swal(
                   'Email格式有誤，請重新輸入。',
                   '',
                   'error',
                );
            }
        });

        $('form[name=login]').submit(function () {
            var form = $(this);
            var data    =   form.serialize();
            $.ajax({
                url:'/member/login_ajax',
                type:'POST',
                dataType:'JSON',
                data:data ,
                beforeSend: function () {
                  waitingDialog.show();
                },
                complete: function () {
                  waitingDialog.hide();
                },
                success:function(result){
                    ResultData(result);
                }
            });
            return false;
        });

        /**驗證Email**/
        function checkEmail(email) {
          var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if(!regex.test(email)) {
              return false;
          }else{
              return true;
          }
        }
        <?php if ($this->session->userdata('login')): ?>
            let result = JSON.parse('<?=json_encode($this->session->userdata('login'))?>');
            //console.log(result);
            <?php $this->session->unset_userdata('login');?>
            ResultData(result);
        <?php endif ?>
    </script>
</body>
</html>