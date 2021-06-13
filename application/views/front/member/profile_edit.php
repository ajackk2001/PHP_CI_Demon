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
    <link rel="stylesheet" href="/assets/plugins/slim/slim/slim.min.css">
    <link rel="stylesheet" href="<?=version('assets/css/daterangepicker/daterangepicker.css')?>">
    <style type="text/css">
        .BirthInput[readonly] {
            background-color: #fff;
        }
        .slim-btn-group button{
            display:inline-block;
        }
        .edit{
          cursor: pointer;
        }
        .bannerModal .modal-dialog img{
            max-width: 100%;
        }
        .redtxt {
            color: #e61f6e;
            padding-right: 5px;
        }
    </style>
</head>
<body>
    <?php //$this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <?php if (!empty($member->banner_img)&&file_exists($member->banner_img)): ?>
        <div id="banner" class="edit" style="background: url(/<?=$member->banner_img?>) center center / cover;"></div>
    <?php else: ?>
        <div class="profile-banner edit">
            <div class="setbanner ">設定封面</div>
        </div>
    <?php endif ?>
    <main>
        <section class="profile_edit">
            <div class="container-fluid">
                <div class="row">
                    <div class="TopBox col-12 col-md-3">
                        <div class="Avatar">
                            <?php //若是使用者沒有圖片，則採用這張預設會員圖片?>
                            <input type="file" name="slim" id="addSlim" form="editMember" class="rounded-circle"/>
                        </div>
                        <div class="UserInfo">
                            <h1><?=$this->session->userdata('user')['nickname']?></h1>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <form id="editMember" name="editMember">
                            <div class="row ">
                                <div class="col-12 col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-10">
                                            <label class="col-form-label">Email</label>
                                            <input type="text" class="form-control"  readonly value="<?=$member->username?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label"><span class="redtxt">※</span>姓名</label>
                                            <input type="text" class="form-control"  value="<?=$member->name?>" name="name" required placeholder="姓名">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label"><span class="redtxt">※</span>暱稱</label>
                                            <input type="text" class="form-control"  value="<?=$member->nickname?>" name="nickname" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label">性別</label>
                                            <select name="sex" class="form-control">
                                                <option>選擇</option>
                                                <option value="1" <?=(($member->sex==1)?'selected':'')?>>男生</option>
                                                <option value="2" <?=(($member->sex==2)?'selected':'')?>>女生</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label">生日</label>
                                            <input type="text" class="form-control BirthInput" placeholder="你的生日"  readonly name="birthday"  value="<?=$member->birthday=='0000-00-00'?'':$member->birthday?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label class="col-form-label">身高</label>
                                            <input type="text" value="<?=$member->height?>" name="height"  class="form-control" placeholder="ex: 168">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label">三圍</label>
                                            <input type="text" name="measurement" value="<?=$member->measurement?>" class="form-control" placeholder="ex: 32/24/30">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label class="col-form-label">國籍</label>
                                            <select name="country" class="form-control">
                                                <?php foreach ($country as $k => $v): ?>
                                                    <option value="<?=$v->id?>" <?=(($member->country==$v->id)?'selected':'')?>><?=$v->title?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label">職業</label>
                                            <input type="text" name="profession" class="form-control" placeholder="ex: 模特" value="<?=$member->profession?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Facebook</label>
                                        <input type="text" name="Facebook_path" class="form-control" placeholder="你的Facebook" value="<?=$member->Facebook_path?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Instagram</label>
                                        <input type="text" name="Instagram" class="form-control" placeholder="你的Instagram" value="<?=$member->Instagram?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Youtube</label>
                                        <input type="text" name="Youtube" class="form-control" placeholder="你的Youtube頻道" value="<?=$member->Youtube?>">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                   <!--  <div class="form-group">
                                        <label class="col-form-label">行動電話號碼</label>
                                        <p>+886900000000</p>
                                    </div> -->
                                    <div class="form-group">
                                        <label class="col-form-label">簡介</label>
                                        <textarea name="desc" class="profile-edit-box" rows="10" ><?=$member->desc?></textarea>
                                    </div>
                                    <div class="btn-box">
                                        <button type="submit" class="btn btn-primary btn-sm float-right">儲存</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="modal fade bs-example-modal-sm modal_edit bannerModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form name="modal_edit" enctype="multipart/form-data" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="mySmallModalLabel">設定封面</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <label for="editSlim"><small class="text-info">建議尺寸 1014*184</small></label>
                                    <input type="file" name="slim" id="editSlim"/>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                        <button type="button" class="btn btn-primary edit-btn">修改</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="/assets/plugins/slim/slim/slim.kickstart.min.js" type="text/javascript"></script>
    <script src="<?=version('assets/js/front/main.js')?>"></script>
      <!-- daterangepicker -->
    <script src="/assets/js/front/moment/moment.min.js"></script>
    <script src="/assets/js/front/daterangepicker/daterangepicker.js"></script>
    <script>
    let slimOption = {
        forceSize: {
            width: 500,
            height: 500,
        },
        label:'',
        maxFileSize:'8'
    };

    let slimBannerOption = {
        forceSize: {
            width: 1014,
            height: 184,
        },
        label:'圖片拖移至此，請上傳最佳尺寸 寬1014px * 高 184px，可上傳後裁切。',
        maxFileSize:'8'
    };

    let addSlim = new Slim(document.getElementById('addSlim'),slimOption);
    let editSlim = new Slim(document.getElementById('editSlim'),slimBannerOption);
    <?php if (!empty($member->img)): ?>
        let img_path="<?=$member->img?>";
    <?php else: ?>
        let img_path="/assets/images/front/member_default.jpg";
    <?php endif ?>
    addSlim.load(img_path);

    $('.BirthInput').daterangepicker({
        locale: {
            format: "YYYY/MM/DD",
            daysOfWeek: ['日', '一', '二', '三', '四', '五', '六'],
            monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
        },
        showDropdowns: true,
        singleDatePicker: true,
        opens: "center",
    });
    $(function() {
       <?php if (empty($member->birthday)||$member->birthday=='0000-00-00'): ?>
        $('.BirthInput').val('');
        <?php endif ?>
    });


    /**修改會員資訊-表單傳送**/
    $('form[name=editMember]').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('slim', $('input[name="slim"]').val());
        var name = $('input[name=name]').val();
        if(name==null){
            swal({
              type:'warning',
              title: "請輸入姓名",
              confirmButtonText: '關閉',
            });
            return false;
        }

        swal({
            title: '確定要儲存更新個人資料嗎？',
            text: "",
            type: 'warning',
            cancelButtonColor: '#d33',
            showCancelButton: true,
            confirmButtonText: '確定',
            cancelButtonText: '取消',
            reverseButtons: true,
        }).then(function (isConfirm) {
            if (isConfirm.value) {
              var edit_ajax  = '/member/edit';
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

    $(document).on('click','.edit',function(){
        var info_ajax  =   '/member/info';
        $.ajax({
            url:info_ajax,
            type:'GET',
            dataType:'JSON',
        }).always(function () {
        }).done(function(data){
            if (Object.keys(data).length > 0){
                $.each(data,function(key,value){
                    if (key == 'banner_img'){
                        if(value&&value!='/'){
                            editSlim.load(value);
                        }
                    }else{
                        $('form[name=modal_edit] input[name='+key+']').val(value);
                    }
                });
                $('.modal_edit').modal('show');
            }else{
                $('.modal_edit').modal('hide');
                swal({
                    title:'查無資訊',
                    type:'warning'
                })
            }
        });
        return false;
    });
    $(".edit-btn").click(function(){
        $('.modal_edit').modal('hide');
        $('form[name=modal_edit]').submit();
    });

    var edit_ajax   =   '/member/banner_edit';
    $('form[name=modal_edit]').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url         : edit_ajax,
            type        : 'POST',
            data        : formData,
            dataType    : 'JSON',
            processData: false,
            contentType: false,
            beforeSend:function(){//表單發送前做的事
                waitingDialog.show();
            },
            complete: function () {
              waitingDialog.hide();
            },
        }).always(function () {
        }).done(function(result){
            ResultData(result);
            if(!result.status){
                $(".swal2-confirm").click(function(){
                    setTimeout(function(){$('.modal_edit').modal('show'); }, 300);
                });
            }
        });
    });

    </script>
</body>
</html>