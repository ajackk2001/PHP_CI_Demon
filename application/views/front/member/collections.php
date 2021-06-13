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
                                    <h3 class="title-txt text-left">最愛收藏</h3>
                                </div>
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" name="search" class="form-control" placeholder="請輸入關鍵字篩選">
                                                <div class="input-group-append">
                                                    <button class="btn btn-send" type="button">搜尋</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-form-label col-sm-4 total"> </div>
                                    </div>
                                </div>
                                <div class="row playlist-box">
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
        </section>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script>
        var ajax_url = '/member/collection_json';
        $.LoadTable=function(){
            var form    =   $('form[name=search]').serialize();
            Page.row=8;
            //Page.cookie_name='activity_page';
            //Page.page=($.cookie(Page.cookie_name))?$.cookie(Page.cookie_name):Page.page;
            $.ajax({
                url:ajax_url,
                type:'POST',
                dataType:'JSON',
                data:{page:Page.page,limit:Page.row,search:$('[name=search]').val()},
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
                            <div class="col-xs-6 col-sm-3 grid playlist-item">
                                <div class="model-info">
                                    <a href="/artist/detail/${e.member_id}">
                                        <img src="${(e.member_img||'/assets/images/front/member_default.jpg')}" class="rounded-circle">
                                        <p>${e.nickname}</p>
                                    </a>
                                </div>
                                <a href="/album/detail/${e.id}" target="_blank">
                                    <div class="imgbox">
                                        <img src="/uploads/item/image/${e.img}">
                                    </div>
                                    <p class="txt-title">${e.title}</p>
                                </a>
                                <div class="info-box">
                                    <p class="original-price">$${e.USD==0?e.USD:e.USD2}</p>
                                    <p class="view-times"><i class="fa fa-eye"></i>${e.ctr}</p>
                                    ${(e.video_total_length?`<div class="preview-length">${e.video_total_length}</div>`:'')}
                                    ${(e.img_num?`<div class="preview-length">${e.img_num} P</div>`:'')}
                                </div>
                            </div>

                        `;
                    });
                    Page.DrawPage(data.total);
                    $(".total").html(`共有 <span>${data.total}</span> 筆，目前在 <span>${Page.page}/${Page.total_page}</span> 頁`);
                    //if(!str)str='<tr><td colspan="9" class="text-center">無作品資料</td></tr>';
                    $('.playlist-box').html(str);
                }

            });
        };
        $.LoadTable();
        $('.btn-send').click(function(){
            Page.page=1;
            $.LoadTable();
            return false;
        });
    </script>
</body>
</html>