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
    <?php $this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <section class="search">
            <div class="container-fluid author">
                <div class="row search-area">
                    <div class="col-xs-12 col-sm-6">
                        <div class="search_box">
                            <input type="text" placeholder="創作者 搜尋 :" name="search">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="flag">
                            <span>國籍選擇:</span>
                            <?php foreach ($country as $k => $v): ?>
                                <input type="radio" name="country" id="country-<?=$v->id?>" value="<?=$v->id?>">
                                <label for="country-<?=$v->id?>" style="background-image: url('/<?=$v->img?>');"></label>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="unit_title">
                    <h2 class="title-txt">創作者</h2>
                </div>
                <div class="card-body">
                    <div class="row popular-list">
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
        var ajax_url = '/creator_json';
        var country='';
        $.LoadTable=function(){
            var form    =   $('form[name=search]').serialize();
            Page.row=36;
            //Page.cookie_name='activity_page';
            //Page.page=($.cookie(Page.cookie_name))?$.cookie(Page.cookie_name):Page.page;
            $.ajax({
                url:ajax_url,
                type:'POST',
                dataType:'JSON',
                data:{page:Page.page, limit:Page.row ,country:country,search:$("input[name=search]").val()},
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
                            <div class="col-3 col-md-1"><a href="/artist/detail/${e.id}">
                                <img src="${(e.img||'/assets/images/front/member_default.jpg')}" class="rounded-circle">
                                <p class="name">${e.nickname}</p><a>
                            </div>
                        `;
                    });
                    //$("").html(data.total);
                    //Page.DrawPage(data.total);
                    //if(!str)str='<tr><td colspan="9" class="text-center">無作品資料</td></tr>';
                    $('.popular-list').html(str);
                }

            });
        };
        $.LoadTable();

        $(document).on('click', 'input[name=country]', function () {
            country=$(this).val();
            Page.page=1;
            $.LoadTable();
        });

        $(document).on('blur', 'input[name=search]', function () {
            Page.page=1;
            $.LoadTable();
        });

    </script>
</body>
</html>