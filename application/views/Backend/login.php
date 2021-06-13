<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Coderthemes">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="<?=version($this->web_icon)?>">

        <!-- App title -->
        <title><?=$this->web_title?></title>

        <!-- Bootstrap CSS -->
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- App CSS -->
        <link href="/assets/css/style.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="/assets/js/modernizr.min.js"></script>
        <style type="text/css">
            .captcha{
                cursor: pointer;
            }
            .account-pages{
                background: url('/assets/images/background/login_bg.jpg');
                background-size:cover;
            }
        </style>
    </head>


    <body>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">

        	<div class="account-bg">
                <div class="card-box mb-0">
                    <div class="m-t-10 p-20">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h4 class="text-muted text-uppercase m-b-0 m-t-0"><b><?=$this->web_title?></b></h4>
                                <h4 class="text-muted text-uppercase m-b-0 m-t-0"><b>後台管理系統</b></h4>
                            </div>
                        </div>
                        <form class="m-t-20" action="?" id="loginform">
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="text" required="" name="account" placeholder="請輸入帳號">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="password" required="" name="password" placeholder="請輸入密碼">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="input-group">
                                        <input class="form-control" type="text" required="" name="captcha" placeholder="請輸入驗證碼"><span class="input-group-addon"><img class="captcha" src="/Backend/Captcha/Captcha?<?=time()?>" width="80" height="30" /></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center row m-t-10">
                                <div class="col-12">
                                    <button class="btn btn-success btn-block waves-effect waves-light" type="submit">登入</button>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>

        </div>
        <!-- end wrapper page -->


        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/tether.min.js"></script><!-- Tether for Bootstrap -->
        <script src="/assets/js/bootstrap.min.js"></script>
        <!-- <script src="/assets/js/detect.js"></script>
        <script src="/assets/js/fastclick.js"></script>
        <script src="/assets/js/jquery.blockUI.js"></script>
        <script src="/assets/js/waves.js"></script>
        <script src="/assets/js/jquery.nicescroll.js"></script>
        <script src="/assets/js/jquery.scrollTo.min.js"></script>
        <script src="/assets/js/jquery.slimscroll.js"></script>
        <script src="/assets/plugins/switchery/switchery.min.js"></script>

        <!-- App js - ->
        <script src="/assets/js/jquery.core.js"></script>
        <script src="/assets/js/jquery.app.js"></script> -->
        <script type="text/javascript">
            $(function(){
                $('#loginform').submit(function(e){
                    e.preventDefault();
                    var data = $(this).serialize();
                    $.post('Login',data,function(e){
                        if(e.status){
                            window.location = e.data;
                        }else{
                            alert(e.msg);
                            location.reload();
                        }
                    },'json')
                })
                $('.captcha').click(function(event) {
                    $(this).attr('src','/Backend/Captcha/Captcha?'+Math.random());
                });
            })
        </script>
    </body>
</html>