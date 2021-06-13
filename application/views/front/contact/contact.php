<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('front/include/layout_head');?>
    <title><?=$this->web_title?></title>
    <link rel="stylesheet" type="text/css" href="/assets/css/front/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/jquery.scrollbar.css">
    <link rel="stylesheet" href="<?=version('assets/css/front/style.css')?>">
    <style type="text/css">
        #rand-img {
            position: absolute;
            right: 10px;
            bottom: 1px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php $this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <section class="edit-page contact">
            <div class="container">
                <div class="unit_title">
                    <h2 class="title-txt">聯絡我們</h2>
                    <p>希望您填寫詳細資訊，並簡述您的內容，我們將會通知相關人員與您聯繫，謝謝。</p>
                </div>
                <form id="contactForm" name="contactForm" method="post" action="" target="" enctype="multipart/form-data" data-parsley-validate novalidate>
                    <div class="content formBox">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class=" col-form-label"><span class="redtxt">※</span>姓名</label>
                                <input type="text" class="form-control" placeholder="" value="<?=$this->session->userdata('user')['name']?>" name="name" required>
                            </div>
                            <div class="col-sm-6">
                                <label class=" col-form-label">連絡電話</label>
                                <input type="text" class="form-control" placeholder="" name="company">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class=" col-form-label">行動電話</label>
                                <input type="text" class="form-control" placeholder="" name="phone">
                            </div>
                            <div class="col-sm-6">
                                <label class=" col-form-label"><span class="redtxt">※</span>電子信箱</label>
                                <input type="email" class="form-control" placeholder="" value="<?=$this->session->userdata('user')['username']?>" name="email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label class="col-form-label"><span class="redtxt">※</span>需求說明</label>
                                <textarea type="text" class="form-control" placeholder="" data-note="需求說明" name="content" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class=" col-form-label"><span class="redtxt">※</span>驗證號碼</label>
                               <input data-parsley-type="number" class="form-control" type="tel" name="captcha" placeholder="請填入右側六位數" maxlength="6" onKeyUp="value=this.value.replace(/\D+/g,'')" name="captcha">
                                <img class="rand-img captcha" id="rand-img" src="/Captcha/Captcha?<?=time()?>" alt="驗證碼" />
                            </div>
                        </div>
                        <div class="btn-box"> <button class="btn btn-send w-50" type="submit">確認送出</button> </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script type="text/javascript">
        //驗證碼點選更換圖片
        $('.captcha').click(function (event) {
          $(this).attr('src', '/Captcha/Captcha?' + Math.random());
        });


    var ajax_url = '/contact/form';
    var f = false;
    $('form[name=contactForm]').submit(function(){
        if (f) return false;
        var form = new FormData(this);
        swal({
            title: '確定要送出嗎？',
            text: "",
            type: 'warning',
            cancelButtonColor: '#d33',
            showCancelButton: true,
            confirmButtonText: '確定',
            cancelButtonText: '取消',
            reverseButtons: true,
        }).then(function (isConfirm) {
            if (isConfirm.value) {
                $.ajax({
                  url         : ajax_url,
                  type        : 'POST',
                  dataType    : 'JSON',
                  data        : form,
                  processData : false,
                  contentType : false,
                  beforeSend:function(){//表單發送前做的事
                    waitingDialog.show();
                  },
                  complete: function () {
                    waitingDialog.hide();
                  },
                  success : function(result){
                    $('.captcha').attr('src','/Captcha/Captcha?'+Math.random());
                    if(result.status){
                      result.text='客服人員將會在最短時間內與您聯絡';
                    }
                    ResultData(result);
                    f = false;
                  }

                });
            }
        });
        return false;
    });
    </script>
</body>
</html>