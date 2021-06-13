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
        #level2 li{
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <?php $this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <div class="container-fluid photo">
            <div class="row search-area">
                <div class="col-xs-12 col-sm-6">
                    <div class="TagsBox">
                        <ul id="level1" class="level1">
                            <li>
                                <a class="type" href="javascript:;" data-type="">全部</a>
                            </li>
                            <?php foreach ($type as $k => $v): ?>
                                <li>
                                    <a class="type" href="javascript:;" data-type="<?=$v->id?>"><?=$v->title?></a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        <ul id="level2" class="level2">
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="filter-bar">
                        <span>篩選:</span>

                        <span class="filter-item" data-filter="update_time">時間</span>
                        <span id="update_time" class="vertical-arrows down arrow-up ">
                            <img src="/assets/images/front/sort-arrow.svg" class="up arrow" alt="">
                            <img src="/assets/images/front/sort-arrow.svg" class="down arrow">
                        </span>
                        <span class="filter-item" data-filter="points">價格</span>
                        <span id="points" class="vertical-arrows down arrow-up">
                            <img src="/assets/images/front/sort-arrow.svg" class="up arrow" alt="">
                            <img src="/assets/images/front/sort-arrow.svg" class="down arrow">
                        </span>
                        <span class="filter-item" data-filter="ctr">觀看次數</span>
                        <span id="ctr" class="vertical-arrows down arrow-up">
                            <img src="/assets/images/front/sort-arrow.svg" class="up arrow" alt="">
                            <img src="/assets/images/front/sort-arrow.svg" class="down arrow">
                        </span>
                        <div class="btn-group">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">尺度
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:;" data-scale="">全部</a>
                                <?php foreach ($scale as $k => $v): ?>
                                    <a class="dropdown-item" href="javascript:;" data-scale="<?=$v->id?>"><?=$v->title?></a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                    <div class="flag">
                        <span>國籍選擇:</span>
                        <?php foreach ($country as $k => $v): ?>
                            <input type="radio" name="country" id="country-<?=$v->id?>" value="<?=$v->id?>">
                            <label for="country-<?=$v->id?>" style="background-image: url('/<?=$v->img?>');"></label>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="unit_title">
                    <h2 class="title-txt">寫真</h2>
                </div>
                <div class="card-content">
                    <div class="col-md-12">
                        <div class="row paylist-item">
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
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script>
        let type=category=country=scale=filter="";
        var level2 =new Array();
        $(function() {

            // 點擊的篩選項目顯示箭頭
            $('.filter-item').on('click', function(){
                $('.vertical-arrows').removeClass('active');
                var selectFilter = $('#'+$(this).data('filter'));
                selectFilter.addClass('active');
                filter=$(this).data('filter');
                Page.page=1;
                $.LoadTable();
            })
            // 箭頭上下切換
            $('.vertical-arrows').on('click', function() {
                if($(this).hasClass('arrow-up')) {
                    $(this).removeClass('arrow-up').addClass('arrow-down');
                    Page.page=1;
                    $.LoadTable();
                    return;
                }
                if($(this).hasClass('arrow-down')) {
                    $(this).removeClass('arrow-down').addClass('arrow-up');
                    Page.page=1;
                    $.LoadTable();
                    return;
                }
            })
        });
        var ajax_url = '/album_json';
        $.LoadTable=function(){
            var form    =   $('form[name=search]').serialize();
            Page.row=16;
            var orderby="";
            if(filter){
                orderby=($("#"+filter).hasClass('arrow-up'))?[`${filter} desc`]:[`${filter} asc`];
            }
            $.ajax({
                url:ajax_url,
                type:'POST',
                dataType:'JSON',
                data:{page:Page.page, limit:Page.row,type:type,category:category,country:country,scale:scale,orderby:orderby},
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
                             <div class="col-xs-6 col-sm-4 col-lg-3 grid">
                                <div class="playlist-item">
                                    <div class="model-info">
                                        <a href="/artist/detail/${e.member_id}">
                                            <img src="${(e.member_img||'/assets/images/front/member_default.jpg')}" class="rounded-circle">
                                            <p>${e.nickname}</p>
                                        </a>
                                    </div>
                                    <a href="/album/detail/${e.id}">
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
                            </div>
                        `;
                    });

                    level2 = data.category;
                    //$("").html(data.total);
                    Page.DrawPage(data.total);
                    //if(!str)str='<tr><td colspan="9" class="text-center">無作品資料</td></tr>';
                    $('.paylist-item').html(str);
                }

            });
        };
        <?php if ($type_id): ?>
            type='<?=$type_id?>';
            category='<?=$category_id!=0?$category_id:''?>';
            level2 = JSON.parse('<?=json_encode($category)?>');
            type_click();
        <?php else: ?>
            $.LoadTable();
        <?php endif ?>

        function type_click(){
            if(!type)category='';
            var selectLevel2 =new Array();
            level2.forEach(item => {
               if(item.type_id == type){
                    selectLevel2.push(item);
               }
            });
            Page.page=1;

            var level2menu = '';
            for (var i=0; i< selectLevel2.length; i++) {
                level2menu += '<li><a href="javascript:;" data-category="'+selectLevel2[i].id+'">'+ selectLevel2[i].title +'</a></li>';
            }
            $('#level2').html(level2menu);
            $.LoadTable();
        }

        // 會選取 #level1的選單中 data-type 相對應的分類
        $(document).on('click', '#level1 li a', function () {
            type=$(this).data('type');
            type_click();
        });

        // 會選取 #level1的選單中 data-type 相對應的分類
        $(document).on('click', '#level2 li a', function () {
            category=$(this).data('category');
            Page.page=1;
            $.LoadTable();
        });

        $(document).on('click', 'input[name=country]', function () {
            country=$(this).val();
            Page.page=1;
            $.LoadTable();
        });
        $(document).on('click', '.dropdown-item', function () {
            scale=$(this).data('scale');
            Page.page=1;
            $.LoadTable();
        });
    </script>
</body>
</html>