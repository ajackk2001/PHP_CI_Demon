<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <!-- version 用來做 cache busting -->
        <!-- 正式上線請考慮使用 .min -->
        <link href="<?= version('assets/plugins/hopscotch/css/hopscotch.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= version('assets/plugins/fileuploader2.2/dist/font/font-fileuploader.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= version('assets/plugins/fileuploader2.2/dist/jquery.fileuploader.min.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= version('assets/plugins/fileuploader2.2/css/jquery.fileuploader-theme-thumbnails.css') ?>" rel="stylesheet" type="text/css">
        <style type="text/css" media="screen">
            .reference {
                font-size: 0.4em;
                vertical-align: super;
            }
        </style>
    </head>
    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">
            <?php $this->load->view('Backend/layouts/topbar');?>
            <?php $this->load->view('Backend/layouts/menu');?>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <?php $this->load->view('Backend/layouts/nav');?>

                        <div class="card-box">
                            <h2 class="h5" id="zipcode">匯入縣市、鄉鎮市區<a href="javascript:;"  onclick="tour(zipcode_tour)"><i class="ion-help-circled"></i></a></h2>
                            <div class="col-4 mb-4">
                                <form method="POST" action="/Backend/Zipcode/Import" enctype="multipart/form-data" class="form-inline" id="import-zipcode">
                                    <div class="form-group">
                                        <input type="file" name="zipcode" class="form-control mr-2" required>
                                        <button class="btn btn-primary" type="submit">匯入</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
            <!-- End content-page -->
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
            <!-- Right Sidebar -->
            <?php $this->load->view('Backend/layouts/right_sidebar');?>
            <!-- /Right-bar -->
            <?php $this->load->view('Backend/layouts/footer');?>
        </div>
        <!-- END wrapper -->
        <?php $this->load->view('Backend/layouts/script');?>
        <!-- version 用來做 cache busting -->
        <!-- 正式上線請考慮使用 .min -->
        <script src="<?=version('assets/plugins/hopscotch/js/hopscotch.min.js')?>"></script>
        <script>
            $('form').on('submit', ()=>{waitingDialog.show()});
            /* 說明 */
            function tour(which) {
                hopscotch.startTour(which);
            }

            var zipcode_tour = {
                id: "zipcode",
                steps: [
                    {
                        target: "zipcode",
                        title: "csv 下載處",
                        content: "政府資料開放平台/3+2碼郵遞區號<br />https://data.gov.tw/dataset/5948",
                        placement: 'top',
                    },
                    {
                        target: document.querySelector("#import-zipcode button"),
                        title: "請先自行清除資料表資料",
                        content: "為避免誤操作，匯入時不會清除原資料表中的資料",
                        placement: 'top',
                    },
                ],
            };

        </script>
    </body>
</html>
