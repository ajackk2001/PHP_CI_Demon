
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Coderthemes">

        <!-- App Favicon -->
        <?php /*
        <!-- <link rel="shortcut icon" href="<?=version($this->web_icon)?>"> -->
        */?>

        <!-- App title -->
        <title>系統維護中</title>

        <!-- Bootstrap CSS -->
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- App CSS -->
        <link href="/assets/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css" />
        <link href="/assets/css/style.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="/assets/js/modernizr.min.js"></script>
        <style type="text/css">
            .account-pages{
                background: center center url('/assets/images/background/login_bg.jpg');
                background-size:cover;
            }
            .lockWebsiteBg{
                background: rgba(0,0,0,0.7);
                position: absolute;
                top: 0;
                bottom: 0;
                right: 0;
                left: 0;
            }
            .lockWebsiteContainer{
                color: #fff;
                position: absolute;
                top: 50%;
                width: 100%;
                transform: translateY(-50%);

            }
            .lockWebsiteContainer h2{
                letter-spacing: 2px;
            }
            .lockWebsiteContainer p{
                font: normal 16px 'Century Gothic', '微軟正黑體';
                letter-spacing: 1px;
                line-height: 30px;
            }
            .lockWebsiteContainer button{
                font: normal 16px 'Century Gothic', '微軟正黑體';
            }
        </style>
    </head>


    <body>

        <div class="account-pages"></div>
        <div class="lockWebsiteBg"></div>
        <div class="lockWebsiteContainer">
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-6">
                        <div class="row justify-content-center m-b-30">
                            <div class="col-6 col-sm-6 col-md-6">
                                <img class="img-fluid" src="/assets/images/front/logo.png" alt="">
                            </div>
                        </div>
                        <h2 class="text-center m-b-20">網站維護中</h2>
                        <p class=" m-b-20">
                            親愛的客人：<br>
                            為了能夠提供更好的服務品質，系統目前進行站台維護作業，維護期間系統需全面停止使用，我們會盡快將系統恢復運作，造成不便的地方還請您多見諒，有任何問題請洽詢客服人員。或者聯繫客服中心&nbsp;0972237232&nbsp;，由專員為您服務。
                        </p>
                        <div class="row justify-content-end">
                            <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                <button class="btn btn-info btn-block waves-effect waves-light lockWebsiteBtn" type="submit">解鎖</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end wrapper page -->



        <!-- jQuery  -->
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/tether.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>

        <!-- App js - ->

        <script src="/assets/js/jquery.core.js"></script>
        <script src="/assets/js/jquery.app.js"></script> -->
        <script src="/assets/plugins/sweetalert/sweetalert2.min.js"></script>
        <script>
            $('.lockWebsiteBtn').click(function(event) {
                swal({
                  title: '管理員解鎖',
                  text: '請輸入密碼進入觀看網站',
                  showCancelButton: true,
                  input: 'text',
                  inputPlaceholder: '解鎖密碼'
                })
            });
        </script>
    </body>
</html>