<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('front/include/layout_head');?>
    <title><?=$this->web_title?></title>

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/jquery.scrollbar.css">
    <link rel="stylesheet" href="/assets/plugins/adminLTE/css/adminlte.css">
    <link rel="stylesheet" href="<?=version('assets/css/front/style.css')?>">
    <link href="<?=version('assets/css/tooltip.css')?>" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .projects a{
            font-size: 16px;
        }
    </style>
</head>
<body>
    <?php //$this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <section class="member">
            <div class="container-fluid">
                <div class="inner">
                    <div class="content">
                        <div class="callout callout-info">作品上架</div>
                        <div class="card d-none">
                            <form>
                                <div class="card-header">
                                    <div class="float-left">
                                        <h3 class="card-title">作品搜尋</h3>
                                    </div>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">上架狀態：</label>
                                        <div class="input-group col-sm-6">
                                            <select id="inputState" class="form-control">
                                                <option selected>上架中</option>
                                                <option value="01">未上架</option>
                                                <option value="02">已禁止</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">分類選擇：</label>
                                        <div class="input-group col-sm-3">
                                            <select id="categories" class="form-control">
                                                <option disabled selected>請選擇主分類</option>
                                            </select>
                                        </div>
                                        <div class="input-group col-sm-3">
                                            <select id="childCategories" class="form-control">
                                                <option disabled selected>請選擇次分類</option>
                                            </select>
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
                                    <div class="float-left">
                                        <h3 class="col-form-label card-title">作品列表</h3>
                                    </div>
                                    <div class="card-tools">
                                        <button class="btn btn-primary" onclick="javascript:location.href='/member/product/add'"><i class="fa fa-plus-circle" aria-hidden="true"></i><span>新增上架</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <div class="card-header">
                                    <p class="col-form-label">目前筆數：<span id="total">0</span>筆</p>
                                </div>
                                <table class="table table-striped text-nowrap projects" style="">
                                    <thead>
                                        <tr>
                                            <th style="width: 12%;">上架時間</th>
                                            <th style="width: 5%">審核狀態</th>
                                            <th style="width: 10%">封面照片</th>
                                            <th style="width: 10%;">作品分類</th>
                                            <th width="300">作品名稱</th>
                                            <th style="width: 10%;">售價/點數</th>
                                            <th style="width: 10%">上架狀態</th>
                                            <th style="width: 15%">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr>
                                            <td>2020-11-24 12:03</td>
                                            <td><span class="status bg-success"></span>上架中</td>
                                            <td class="imgbox"><img src="/assets/images/front/pointcard-5000.png"></td>
                                            <td>主分類/次分類</td>
                                            <td>V幣5000</td>
                                            <td>$ 10.99 USD/3000p</td>
                                            <td class="project-actions text-left">
                                                <button type="checkbox" class="btn btn-primary btn-sm">
                                                    <span class="ladda-label">重新上架</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2020-11-24 12:03</td>
                                            <td><span class="status bg-gray"></span>未上架</td>
                                            <td class="imgbox"><img src="/assets/images/front/pointcard-10000.png"></td>
                                            <td>主分類/次分類</td>
                                            <td>V幣10000</td>
                                            <td>$ 10.99 USD/3000p</td>
                                            <td class="project-actions text-left">
                                                <button type="checkbox" class="btn btn-primary btn-sm">
                                                    <span class="ladda-label">重新上架</span>
                                                </button>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2020-11-24 12:03</td>
                                            <td><span class="status bg-danger"></span>已禁止</td>
                                            <td class="imgbox"><img src="/assets/images/front/pointcard-10000.png"></td>
                                            <td>主分類/次分類</td>
                                            <td>V幣10000</td>
                                            <td>$ 10.99 USD/3000p</td>
                                            <td class="project-actions text-left">
                                                <button type="checkbox" class="btn btn-primary btn-sm">
                                                    <span class="ladda-label">重新上架</span>
                                                </button>
                                                </span>
                                            </td>
                                        </tr> -->
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
    $(function() {
        // 次分類隨主分類連動，可把分類資料從後端傳入
        var categories = [ // 主分類
            {
                name: '視頻專區',
                value: '01',
            },
            {
                name: '特別企劃區',
                value: '02',
            },
            {
                name: '寫真專區',
                value: '03',
            },
            {
                name: '大尺度寫真',
                value: '04',
            }
        ]
        var childrenCategories = [ // 次分類
            {
                name: '子分類1',
                value: '01',
                parent: '01' // 主分類的value值
            },
            {
                name: '子分類2',
                value: '02',
                parent: '02' // 主分類的value值
            },
            {
                name: '子分類3',
                value: '03',
                parent: '03' // 主分類的value值
            },
        ]
        var options = '<option disabled selected>請選擇主分類</option>';
            for (var i = 0; i < categories.length; i++ ) {
                options += '<option value='+ categories[i].value +'>'+ categories[i].name +'</option>';
            }
            $('#categories').html(options);
        $('#categories').on('change', function() {
            var currentChild = childrenCategories.filter(function(cate){
                return cate.parent === $('#categories').val()
            })

            var childOptions = '<option disabled selected>請選擇次分類</option>';
            for (var i = 0; i < currentChild.length; i++ ) {
                childOptions += '<option value='+ currentChild[i].value +'>'+ currentChild[i].name +'</option>';
            }
            $('#childCategories').html(childOptions);
        })
    })

        var ajax_url = '/member/productShelf_json';
        $.LoadTable=function(){
            var form    =   $('form[name=search]').serialize();
            Page.row=5;
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
                                    <td>${e.update_date}</td>
                                    <td>${review_status(e.review_status)}</td>
                                    <td class="imgbox"><img src="/uploads/item/image/${e.img}" height="100"></td>
                                    <td>${e.type_title}/${e.category_title}</td>
                                    <td style="text-overflow: ellipsis;white-space: nowrap;cursor: default; " title="${e.title}"><a href="javascript:;" style="width: 290px;display: block;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" >${e.title}</a></td>
                                    <td>$ ${e.USD==0?e.USD:e.USD2} USD/${e.points}p</td>
                                    <td>${StatusHtml(e.status)}</td>
                                    <td class="project-actions text-left">
                                        ${data.member_num[e.id]>0?'此作品已有會員購買，無法編輯':`

                                                 <a style="margin-right:5px;" href="javascript:void(0)" data-id="${e.id}" class="icon-edit edit" data-animation="false"  title="編輯作品" onclick="location.href='/member/product/edit/${e.id}'" ><i class="fas fa-pencil-alt"></i>
                                                </a>

                                        `}
                                    </td>
                                </tr>
                        `;
                    });
                    $("#total").html(data.total);
                    Page.DrawPage(data.total);
                    if(!str)str='<tr><td colspan="9" class="text-center">無作品資料</td></tr>';
                    $('.projects tbody').html(str);
                    //$('[data-toggle="tooltip"]').tooltip();
                }

            });
        };
        $.LoadTable();
        function review_status(status){
            switch (status) {
                case '0':
                    return `
                        <button type="button" class="btn btn-warning btn-sm" style="color:#fff">審核中</button>
                    `;
                    break;
                case '1':
                    return '<button type="button" class="btn btn-success btn-sm" style="color:#fff">審核通過</button>';
                    break;
                case '2':
                    return '<button type="button" class="btn btn-danger btn-sm" style="color:#fff">審核未通過</button>';
                    break;
              }
        }
        function StatusHtml(status){
              switch (status) {
                case '0':
                    return '<span class="status bg-gray"></span>未上架';
                    break;
                case '1':
                    return '<span class="status bg-success"></span>上架中';
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