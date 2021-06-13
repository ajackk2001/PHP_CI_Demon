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
        input.error,input:focus.error , textarea.error,textarea:focus.error,select.error,select:focus.error{
            background: rgb(251, 227, 228);
            border: 1px solid #fbc2c4;
            color: #8a1f11;
        }
        label.error {
            color: #8a1f11;
            display: block;
            margin-left: 10px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php //$this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <section class="edit-page">
            <div class="container">
                <div class="unit_title">
                    <h3 class="title-txt text-left">收入提領</h3>
                    <p>一次僅可兌現一筆，處理中不可再申請</p>
                </div>
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-info-tab" data-toggle="pill" href="#custom-tabs-info" role="tab" aria-controls="custom-tabs-info" aria-selected="false">帳戶設定</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-cash-tab" data-toggle="pill" href="#custom-tabs-cash" role="tab" aria-controls="custom-tabs-cash" aria-selected="true">提領申請</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-type-tab" data-toggle="pill" href="#custom-tabs-type" role="tab" aria-controls="custom-tabs-type" aria-selected="false">提領紀錄</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-info" role="tabpanel" aria-labelledby="custom-tabs-info-tab">
                            <div class="card-body">
                                <div class="custom-control custom-radio">
                                    <form id="editMember" name="editMember">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label class="col-form-label">國家</label>
                                                <select name="bank_country" class="form-control">
                                                <?php foreach ($country as $k => $v): ?>
                                                    <option value="<?=$v->id?>" <?=(($member->bank_country==$v->id)?'selected':'')?>><?=$v->title?></option>
                                                <?php endforeach ?>
                                            </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">銀行</label>
                                                <input type="text" class="form-control" placeholder="輸入文字" name="bank_name" value="<?=$member->bank_name?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label class="col-form-label">帳號</label>
                                                <input type="text" class="form-control" placeholder="輸入文字" name="bank_cc" value="<?=$member->bank_cc?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">戶名</label>
                                                <input type="text" class="form-control" placeholder="輸入文字" name="bank_username" value="<?=$member->bank_username?>">
                                            </div>
                                        </div>
                                        <div class="btn-box text-center pay-btn-area"> <button class="btn btn-send" type="submit" >儲存設定</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-cash" role="tabpanel" aria-labelledby="custom-tabs-cash-tab">
                            <div class="card-body">
                                <p>收入 <span>$<?=round($cashTotal*10)/10?></span> USD</p>
                                <form action="" name="cash" id="cash">
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label class="col-form-label">輸入要兌換的現金</label>
                                            <input type="text" class="form-control" placeholder="輸入提領金額" min="100" max="<?=$cashTotal?>" name="USD">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label">發送驗證信</label> <button class="btn btn-sm btn-send MailSend" style="font-size: 0.875rem;" type="button">送出驗證信</button>
                                            <input type="text" class="form-control" placeholder="請輸入驗證碼" required name="captcha">
                                        </div>
                                    </div>
                                    <div class="btn-box text-center pay-btn-area"> <button class="btn btn-send" type="submit" onclick="location.href='#'" type="button">送出</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-type" role="tabpanel" aria-labelledby="custom-tabs-type-tab">
                            <div class="card-body table-responsive">
                                <table class="table table-hover text-nowrap projects">
                                    <thead>
                                        <tr>
                                            <th>提領時間</th>
                                            <th>提領</th>
                                            <th>審核狀態</th>
                                            <th>審核時間</th>
                                            <th style="width: 20%">備註</th>
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
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="/assets/plugins/jquery-validation/src/localization/messages_zh_TW.js" type="text/javascript"></script>
    <script type="text/javascript">
        /**修改會員資訊-表單傳送**/
        $('form[name=editMember]').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            swal({
                title: '確定要更新帳戶設定嗎？',
                text: "",
                type: 'warning',
                cancelButtonColor: '#d33',
                showCancelButton: true,
                confirmButtonText: '確定',
                cancelButtonText: '取消',
                reverseButtons: true,
            }).then(function (isConfirm) {
                if (isConfirm.value) {
                  var edit_ajax  = '/member/bank_edit';
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

        $('form[name=cash]').validate({
            rules: {
                USD: {
                    required: true,
                    digits: true,
                },
            },
            messages: {
                USD: {
                    digits:$.validator.format("提領金額只能輸入正整數"),
                    max: $.validator.format("提領金額不可超過收入金額"),
                    min: $.validator.format("提領最低金額不可小於 ${0} USD")
                },
            }
        });


        $('.MailSend').on('click',  function(event) {
            let email = $('#inputEmail').val();
            if($('input[name="USD"]').valid()){
                var message_captcha_ajax  = '/Mail/cashCaptcha';
                $.ajax({
                    url:message_captcha_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:{USD:$('input[name="USD"]').val()},
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
                        }else{
                            ResultData(result);
                        }
                    }
                });
            }
        });


        $('form[name=cash]').submit(function () {
            var form = $(this);
            var data    =   form.serialize();
            if(!form.valid())return false;
            swal({
                title: '確定送出申請?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: '確定',
                cancelButtonText: '取消',
                allowOutsideClick:false,
                reverseButtons: true,
            }).then((isConfirm) => {
                if (isConfirm.value) {
                    $.ajax({
                        url:'/member/cash_add',
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
                }
            });
            return false;
        });

        var ajax_url = '/member/exchangeCash_json';
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
                                <td>${e.create_date}</td>
                                <td>$${Math.abs(e.USD)} USD</td>
                                <td>${payTypeTag(e.status)}</td>
                                <td>${e.result_date?e.result_date:''}</td>
                                <td>${e.remark?e.remark:''}</td>
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
        function payTypeTag(payTypeNumber){
              switch (payTypeNumber) {
                case '0':
                    return '待處理';
                    break;
                case '1':
                    return '已處理';
                    break;
                case '2':
                    return '已退回';
                    break;
              }
        }
    </script>
</body>
</html>