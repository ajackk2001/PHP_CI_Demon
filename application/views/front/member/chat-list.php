<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('front/include/layout_head');?>
    <title><?=$this->web_title?></title>

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/jquery.scrollbar.css">
    <link rel="stylesheet" href="/assets/js/front/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/assets/plugins/adminLTE/css/adminlte.css">
    <link rel="stylesheet" href="<?=version('assets/css/front/style.css')?>">
</head>
<body>
    <?php //$this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <section class="member">
            <div class="container-fluid">
                <div class="inner">
                    <div class="card d-none">
                        <div class="card-header">
                            <div class="float-left">
                                <h3 class="card-title">列表篩選</h3>
                            </div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">列表日期：</label>
                                    <div class="input-group col-sm-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control float-right" id="reservation">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">類別選擇：</label>
                                    <div class="input-group col-sm-6">
                                        <select id="inputState" class="form-control">
                                            <option selected>聊天</option>
                                            <option value="01">禮物</option>
                                            <option value="02">照片</option>
                                            <option value="03">影片</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">關鍵字：</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="uname" placeholder="名稱" name="uname" required>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer">
                            <div class="card-tools">
                                <button type="button" class="btn btn-default btn-sm float-left">查詢</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="card-header">
                                <form id="editMember" name="editMember">
                                    <p class="col-form-label">聊天點數設定：</p>
                                    <div class="row">
                                        <div class="col-12 col-sm-3" style="margin-bottom: 8px;">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="輸入聊天點數設定" name="chat_point" onKeyUp="value=this.value.replace(/\D+/g,'')" value="<?=$chat_point?>">
                                                <span class="input-group-text">點</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <button class="btn btn-send" type="submit">儲存</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap projects">
                                    <thead>
                                        <tr>
                                            <th width="150">時間</th>
                                            <th width="">項目</th>
                                            <th width="150" style="text-align: right;">收入金額(USD)</th>
                                            <th width="100">其他</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
            </div>
        </section>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <!-- daterangepicker -->
    <script src="/assets/js/front/moment/moment.min.js"></script>
    <script src="/assets/js/front/daterangepicker/daterangepicker.js"></script>



    <script src="<?=version('/assets/js/front/main.js')?>"></script>

    <script>
        //Date range picker
        $('#reservation').daterangepicker()

        var ajax_url = '/member/chat_list_json';
        $.LoadTable=function(){
            var form    =   $('form[name=search]').serialize();
            Page.row=10;
            //Page.cookie_name='activity_page';
            //Page.page=($.cookie(Page.cookie_name))?$.cookie(Page.cookie_name):Page.page;
            $.ajax({
                url:ajax_url,
                type:'POST',
                dataType:'JSON',
                data:form+'&page='+Page.page+'&limit='+Page.row,
                async:false,
                beforeSend: function () {
                  waitingDialog.show();
                },
                complete: function () {
                  waitingDialog.hide();
                },
                success:function(data){
                    str='';
                    $.each(data.list,function(i,e){
                        str +=`
                            <tr>
                                <td>${e.date_add}</td>
                                <td style="text-overflow: ellipsis;white-space: nowrap;cursor: default; " title="${e.title}">${e.title}</td>
                                <td style="text-align: right;">$ ${e.USD}</td>
                                <td></td>
                            </tr>
                        `;
                    });
                    Page.DrawPage(data.total);
                    if(!str)str='<tr><td colspan="9" class="text-center">無資料</td></tr>';
                    $('.projects tbody').html(str);
                }

            });
        };
        $.LoadTable();
        /**修改會員資訊-表單傳送**/
        $('form[name=editMember]').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            swal({
                title: '確定要更新聊天點數設定嗎？',
                text: "",
                type: 'warning',
                cancelButtonColor: '#d33',
                showCancelButton: true,
                confirmButtonText: '確定',
                cancelButtonText: '取消',
                reverseButtons: true,
            }).then(function (isConfirm) {
                if (isConfirm.value) {
                  var edit_ajax  = '/member/chat_point_edit';
                  $.ajax({
                    type: 'POST',
                    url: edit_ajax,
                    data : formData,
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                      waitingDialog.show();
                    },
                    complete: function () {
                      waitingDialog.hide();
                    },
                    success: function (result) {
                      ResultData(result);
                    }
                  });
                }
            });
            return false;
        });
        function payTypeTag(payTypeNumber){
              switch (payTypeNumber) {
                case '0':
                    return '待付款';
                    break;
                case '1':
                    return '已付款';
                    break;
                // case '3':
                //     return '<div class="status payCash"><i class="iconfont icon-okc"></i>Punkcoco抵扣</div>';
                // case '5':
                //     return '<div class="status payCash"><i class="iconfont icon-okc"></i>退貨</div>';
                //     break;
              }
        }
    </script>
</body>
</html>