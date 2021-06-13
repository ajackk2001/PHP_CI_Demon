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
    <?php //$this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <section class="member">
            <div class="container-fluid">
                <div class="inner">
                    <div class="content">
                        <div class="card">
                            <div class="InfoBox">
                                <div class="unit_title">
                                    <h3 class="title-txt text-left">收入紀錄</h3>
                                </div>
                                <div class="card-header d-none">
                                    <div class="row ">
                                        <p class="col-form-label col-sm-6">收入 $0 USD</p>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap projects">
                                        <thead>
                                            <tr>
                                                <th width="120">日期</th>
                                                <th width="120">購買人</th>
                                                <th width="100">類型</th>
                                                <th width="">項目</th>
                                                <th width="80">收入金額</th>
                                                <th width="80">備註</th>
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
            </div>
            </div>
        </section>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script>
        var ajax_url = '/member/incomeRecord_json';
        $.LoadTable=function(){
            var form    =   $('form[name=search]').serialize();
            Page.row=10;
            var type        =   {1:'販賣作品',2:'禮物贈送',3:'聊天點數',4:'提領兌現',5:'兌現',6:'扣除'};
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
                                <td>${e.nickname}</td>
                                <td>${type[e.type]}</td>
                                <td>${e.title}</td>
                                <td>$${e.USD}</td>
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