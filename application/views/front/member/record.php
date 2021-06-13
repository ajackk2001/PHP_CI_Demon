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
                                    <h3 class="title-txt text-left">點數紀錄</h3>
                                </div>
                                <div class="card-header">
                                    <div class="row">
                                        <p class="col-form-label col-sm-6">目前剩餘點數：<span><?=number_format($this->points_total)?></span>點</p>
                                        <div class="col-sm-6 text-right">
                                            <button class="btn btn-primary" onclick="javascript:location.href='/pointPlan'"><i class="fa fa-plus-circle" aria-hidden="true"></i><span>購買點數</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap projects">
                                        <thead>
                                            <tr>
                                                <th width="80">編號</th>
                                                <th width="150">日期</th>
                                                <th width="300">項目</th>
                                                <th>點數</th>
                                                <th>備註</th>
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
        var ajax_url = '/member/point_json';
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
                                <td>${i+1}</td>
                                <td>${e.create_date}</td>
                                <td style="text-overflow: ellipsis;white-space: nowrap;cursor: default; " title="${e.remark}">${e.item_id?`<a href="/album/detail/${e.item_id}" style="width: 250px;display: block;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" target="_blank">${e.remark}</a>`:e.remark}</td>
                                <td>${e.points}點</td>
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
    </script>
</body>
</html>