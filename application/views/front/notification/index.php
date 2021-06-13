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
        .padding {
            padding: 5px 0;
        }
        .notify {
            color: #444;
            height: 100%;
        }
    </style>
</head>
<body>

    <?php $this->load->view('front/include/include_header');?>
    <main>
        <div class="container notify">
            <div class="row no-gutters padding">
                <div class="col-12 border-bottom" style="padding-bottom: 15px;">
                    通知
                </div>
            </div>
            <div class="msg-list">
            </div>
            <div class="card-footer" style="background-color: #FFF;">
                <nav aria-label="Contacts Page Navigation">
                    <ul class="pagination justify-content-center m-0">

                    </ul>
                </nav>
            </div>
        </div>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script type="text/javascript">
        var ajax_url = '/notification/show';
        $.LoadTable=function(){
            //var form    =   $('form[name=search]').serialize();
            Page.row=10;
            //Page.cookie_name='activity_page';
            //Page.page=($.cookie(Page.cookie_name))?$.cookie(Page.cookie_name):Page.page;
            $.ajax({
                url:ajax_url,
                type:'POST',
                dataType:'JSON',
                data:'page='+Page.page+'&limit='+Page.row,
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
                            <div class="row no-gutters padding">
                                <div class="col-9">
                                    <a href="${e.mag_url?e.mag_url:''}">
                                        <span class="text-primary">${e.msg}</span>
                                    </a>
                                </div>
                                <div class="col-3 text-right">
                                    ${e.create_time}
                                </div>
                            </div>
                        `;
                    });
                    Page.DrawPage(data.total);
                    //if(!str)str='<tr><td colspan="9" class="text-center">無資料</td></tr>';
                    $('.msg-list').html(str);
                }

            });
        };
        $.LoadTable();
    </script>
</body>
</html>