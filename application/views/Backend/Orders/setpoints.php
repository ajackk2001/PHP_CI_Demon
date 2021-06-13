<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
    </head>
    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">
            <?php $this->load->view('Backend/layouts/topbar');?>
            <?php $this->load->view('Backend/layouts/menu');?>
            <!-- Left Sidebar End -->
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
                        <?php $this->load->view('Backend/layouts/nav');?>
                        <!-- end row -->

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-sm-8 center">
                                <form enctype="multipart/form-data" method="post" id="addForm1" name="addForm1" action="" target="" data-parsley-validate novalidate>
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                <h5>金額點數換算</h5><hr>
                                                <table class="tablesaw table m-b-30 ">
                                                    <thead>
                                                        <tr>
                                                            <th>名稱</th>
                                                            <th width="180" class="text-center">台幣 <a data-toggle="tooltip" data-placement="left" title="設定1美金換算台幣的金額" href="javascript:;" ><i class="ion-information-circled"></i></a></th>
                                                            <th width="180" class="text-center">點數 <a data-toggle="tooltip" data-placement="left" title="設定1美金可兌換多少點數" href="javascript:;" ><i class="ion-information-circled"></i></a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-size: 15px;font-weight: bold;">1美金兌換</td>
                                                            <td class="text-center">
                                                                <div class=" d-inline-flex align-items-center">
                                                                    <input type="text" class="form-control w-75 mr-1 text-center" name="NTD" value="<?=$set->NTD?>" parsley-trigger="change" required> <span> NTD</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class=" d-inline-flex align-items-center">
                                                                    <input type="text" class="form-control w-75 mr-1 text-center" name="points" value="<?=$set->points?>" parsley-trigger="change" required> <span> 點</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                <h5>送禮、聊天、作品分潤比例</h5><hr>
                                                <table class="tablesaw table m-b-30 ">
                                                    <thead>
                                                        <tr>
                                                            <th>名稱</th>
                                                            <th width="180" class="text-center">比例(%)<a data-toggle="tooltip" data-placement="left" title="設定比例(%),最高100%" href="javascript:;" ><i class="ion-information-circled"></i></a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-size: 15px;font-weight: bold;">
                                                                送禮、聊天、作品要給  模特兒/創作者  的分潤比例
                                                            </td>
                                                            <td class="text-center">
                                                                <div class=" d-inline-flex align-items-center">
                                                                    <input type="text" class="form-control w-75 mr-1 text-center" name="plus" value="<?=$set->plus?>"  required> <span>%</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-t-30 m-b-30">
                                        <button type="submit" class="btn btn-primary">確認送出</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- End of Row -->


                    </div> <!-- container -->

                </div> <!-- content -->
            </div>
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
        <script src="<?=version('assets/plugins/sweetalert/sweetalert2.js')?>"></script>
        <script src="<?=version('assets/js/common.js')?>"></script>
        <script type="text/javascript">
            $(document).on("submit","#addForm1",function(e){
                    e.preventDefault();
                    var form =  $(this).serialize();
                    if(!$(this).valid()){
                        return false;
                    }
                    swal({
                        title:'確定送出嗎?',
                        type:'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '確定',
                        cancelButtonText: '取消',
                    }).then(function(dismiss){
                        if (dismiss.value) {
                            $.ajax({
                                url:'/Backend/SetPoint',
                                type:'POST',
                                dataType:'JSON',
                                data:form,
                                beforeSend:function(){//表單發送前做的事
                                    waitingDialog.show();
                                },
                                complete: function () {
                                  waitingDialog.hide();
                                },
                                success:function(result){
                                    ResultData(result);
                                }
                            });
                        }
                    });
                    return false;
                });
        </script>
    </body>
</html>