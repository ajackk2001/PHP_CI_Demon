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
        <div class="container-fluid models">
            <div class="row search-area">
                <div class="col-xs-12 col-sm-6">
                    <div class="search_box">
                        <input type="text" placeholder="Models 搜尋 :" name="search">
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
                <h2 class="title-txt">Girls</h2>
            </div>
            <div class="card-body">
                <ul class="Partner_List">
                </ul>
            </div>
        </div>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script>

        var ajax_url = '/models_json';
        var country='';
        $.LoadTable=function(){
            Page.row=15;
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
                             <li>
                                <div class="ImgBox">
                                    <a href="/artist/detail/${e.id}">
                                        <img src="${(e.img||'/assets/images/front/member_default.jpg')}">
                                    </a>
                                    <div class="TxtBox">
                                        <h3>${e.nickname}</h3>
                                    </div>
                                </div>
                                <div class="FuncBox">
                                    <p><span class="coin">${e.chat_point}</span>點</p>
                                    <p><a href="javascript:;" class="chat_add" data-id="${e.id}" >聊天</a></p>
                                </div>
                            </li>
                        `;
                    });
                    //$("").html(data.total);
                    //Page.DrawPage(data.total);
                    //if(!str)str='<tr><td colspan="9" class="text-center">無作品資料</td></tr>';
                    $('.Partner_List').html(str);
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


        $(document).on('click','.chat_add',function(){
            var ajax_url='/chat/chat_add/';
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: ajax_url+id,
                dataType: 'json',
                success:function(r){
                    if(r.status){
                        window.location.href='/member/chat';
                    }else{
                        ResultData(r);
                    }
                }

            });
        });


    </script>
</body>
</html>