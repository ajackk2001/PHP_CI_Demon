<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link rel="stylesheet" href="/assets/plugins/slim/slim/slim.min.css">
    </head>
    <body class="fixed-left popoverLg">
        <!-- Begin page -->
        <div id="wrapper">
            <?php $this->load->view('Backend/layouts/topbar');?>
            <?php $this->load->view('Backend/layouts/menu');?>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <?php $this->load->view('Backend/layouts/nav');?>
                        <div class="row">
                            <div class="col-sm-6 center">
                                <form enctype="multipart/form-data" method="post" id="addForm1" name="addForm1" action="" target="" data-parsley-validate novalidate>
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                <h5>每日簽到設定</h5><hr>
                                                <table class="tablesaw table m-b-30 settable">
                                                    <thead>
                                                        <tr>
                                                            <th>名稱</th>
                                                            <th width="70">啟用</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>每日簽到</td>
                                                            <td>
                                                                <input class="status set" type="checkbox"
                                                                <?=$set->give_away_point==1?'checked':''?> data-plugin="switchery" data-color="#64b0f2" data-size="small">
                                                            </td>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box" >

                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered data_list">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="30" data-tablesaw-sortable-col data-tablesaw-priority="1" data-priority="1">#</th>
                                                        <th width="100" class="text-center" data-priority="1">圖片</th>
                                                        <th width="250" class="text-center" data-priority="1">標題</th>
                                                        <th width="120" class="text-center" data-priority="1">點數</th>
                                                        <!-- <th width="150" class="text-center" data-priority="1">瀏覽數</th> -->
                                                        <th width="70" class="text-center" data-priority="1">編輯</th>
                                                    </tr>
                                                </thead>
                                                <tbody><!-- 依照日期做排序 -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row m-t-20">
                                        <div class="col-md-5">
                                            <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">
                                                總共 0 筆中第 0 - 0 筆
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination justify-content-end">
                                                    <li class="page-item disabled">
                                                        <a class="page-link" href="#" tabindex="-1">«</a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="#">»</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Row -->
                        <div class="modal fade bs-example-modal-sm modal_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form name="modal_add" enctype="multipart/form-data" >
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mySmallModalLabel">新增禮物</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addSeq">排序<span class="text-danger">*</span></label>
                                                        <input type="text" name="seq" class="form-control" id="addSeq" value="0" required><!-- 先預設為最末位 -->
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addTitle">標題<span class="text-danger">*</span></label>
                                                        <input type="text" name="title" class="form-control" id="addTitle" placeholder="標題" required>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addTitle">點數<span class="text-danger">*</span></label>
                                                        <input type="text" onKeyUp="value=this.value.replace(/\D+/g,'')"  name="points" class="form-control" id="addTitle" placeholder="點數" required>
                                                    </fieldset>
                                                </div>
                                                <div class="col-6">
                                                    <fieldset class="form-group">
                                                        <label for="">圖片 <span class="text-danger">*</span> <small class="text-info">建議尺寸 <?=$img_width;?>*<?=$img_height;?></small></label>
                                                        <input type="file" name="slim" id="addSlim" />
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                            <button type="submit" class="btn btn-primary">新增</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-example-modal-sm modal_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form name="modal_edit" enctype="multipart/form-data" >
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mySmallModalLabel">編輯每日簽到</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="editTitle">標題<span class="text-danger">*</span></label>
                                                        <input type="text" name="title" class="form-control" id="editTitle" readonly placeholder="標題" value="" required>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addTitle">點數<span class="text-danger">*</span></label>
                                                        <input type="text" onKeyUp="value=this.value.replace(/\D+/g,'')"  name="points" class="form-control" id="" placeholder="點數" required>
                                                    </fieldset>
                                                </div>
                                                <div class="col-4">
                                                    <fieldset class="form-group">
                                                        <label for="editSlim">圖片 <span class="text-danger">*</span> <small class="text-info">建議尺寸 <?=$img_width;?>*<?=$img_height;?></small></label>
                                                        <input type="file" name="slim" id="editSlim"/>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="id">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                            <button type="submit" class="btn btn-primary">修改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container -->
                </div> <!-- content -->
            </div>
            <!-- End content-page -->
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
            <!-- Right Sidebar -->
            <?php $this->load->view('Backend/layouts/right_sidebar');?>
            <!-- /Right-bar -->
            <?php $this->load->view('Backend/layouts/footer');?>
        </div>
        <!-- END wrapper -->
        <?php $this->load->view('Backend/layouts/script');?>
        <script src="/assets/plugins/slim/slim/slim.kickstart.min.js" type="text/javascript"></script>
        <script>
            // slim setting
             // slim setting
            let slimOption = {
                forceSize: {
                    width: <?=$img_width;?>,
                    height: <?=$img_height;?>,
                },
                label:'簽到圖片',
                maxFileSize:'8'
            };

            let addSlim = new Slim(document.getElementById('addSlim'),slimOption);
            let editSlim = new Slim(document.getElementById('editSlim'),slimOption);

            $(document).ready(() => {

                $('.modal').on('hide.bs.modal', function (e) {
                    $('form[name=modal_add]')[0].reset();
                    $('form[name=modal_edit]')[0].reset();
                    addSlim.remove();
                    editSlim.remove();
                })

                var json_ajax =   '/Backend/Give_away_point/List';
                Table.DrawTable =   function(){
                    var form    =   $('form[name=search]').serialize();
                    $.ajax({
                        url:json_ajax,
                        type:'GET',
                        dataType:'JSON',
                        data:form+'&page='+Page.page+'&limit='+Page.row,
                        beforeSend: function () { waitingDialog.show(); }
                    }).always(function () {
                        waitingDialog.hide();
                    }).done(function(data){
                            str =   '';
                            $.each(data.list,function(i,e){
                                str +=` <tr>
                                            <td class="text-center vertical-align-middle">${(((Page.page-1)*Page.row)+(i+1))}</td>
                                            <td class="text-center vertical-align-middle"><span class="text-muted"><img src="/${e.img}" height="60"></span></td>
                                            <td class="vertical-align-middle itemTitle text-center">${e.title}</td>
                                            <td class="vertical-align-middle text-center">${e.points}</td>
                                            <?php if(in_array(66, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                            <td class="text-center vertical-align-middle">
                                                <a href="javascript:void(0);" class="edit" data-id="${e.id}" data-toggle="modal" data-target=".modal_edit"><i class="zmdi zmdi-edit text-info"></i></a>
                                            </td>
                                            <?php endif; ?>
                                        </tr>`;
                                        // <td class="text-center vertical-align-middle">${e.ctr}</td>
                            });
                            if(str=='')str=' <tr><td colspan="20" class="text-center" data-org-colspan="1" data-priority="1" data-columns="tech-companies-1-col-0" style="background-color: rgba(0,0,0,.05);">無內容</td></tr>';
                            $('.data_list>tbody').html(str);
                            $.each($('input[data-plugin=switchery]'),function(i,e){
                                new Switchery(e,{color:$('input[data-plugin=switchery]').eq(i).data('color'),size:$('input[data-plugin=switchery]').eq(i).data('size'),});
                            });
                            $('.settable').find('span').eq(1).hide();
                            Page.DrawPage(data.total);
                            $('[data-toggle="tooltip"]').tooltip();
                            $('.table-responsive').responsiveTable('update');
                    });
                }

                $(document).on('change','.searchChange',function(){
                    Page.page=1;
                    Table.LoadTable();
                });

                $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '焦點', display : '顯示', displayAll: '全部顯示'}});
                Table.LoadTable();
                $('.search').click(function(){
                    Page.page=1;
                    Table.LoadTable();
                });
                $('.reset').click(function(){
                    $('form[name=search]')[0].reset();
                    Table.LoadTable();
                });

                $(document).on('click','#updateSeq',function(){
                    var seq_ajax  =   '/Backend/Give_away_point/UpdateSeq';
                    var form           =    $('#tech-companies-1 input').serialize(); //因Responsive Tables jquery 會多產生一個table，只抓table id裡沒有clone 的input
                    swal({
                        title:'確定更新排序?',
                        type:'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '確定更新',
                        cancelButtonText: '取消',
                    }).then(function(result){
                        if(result.value){
                            $.ajax({
                                url         : seq_ajax,
                                type        : 'POST',
                                data        : form,
                                dataType    : 'JSON',
                                beforeSend: function () { waitingDialog.show(); }
                            }).always(function () {
                                waitingDialog.hide();
                            }).done(function(result){
                                    ResultData2(result);
                                    Table.LoadTable();
                            });
                        }
                    });
                });

                var status_ajx  =   '/Backend/Give_away_point/UpdateStatus/';
                $(document).on('change','.set',function(){
                    $.ajax({
                        url:status_ajx,
                        type:'POST',
                        dataType:'JSON',
                        data:{'give_away_point':(($(this).prop('checked'))?1:0)},
                        beforeSend: function () { waitingDialog.show(); }
                    }).always(function () {
                        waitingDialog.hide();
                    }).done(function(result){
                            ResultData2(result);
                            if(result.status){
                                Table.LoadTable();
                            }
                    });
                });

            });

            $(document).on('click','.add',function(){
                $.post('/Backend/Give_away_point/LastSeq',{},(result)=>{
                    seq = parseInt(result)+1;
                    $('form[name=modal_add] input[name=seq]').val(seq);
                });
            });

            var add_ajax   =   '/Backend/Give_away_point/Add';
            $('form[name=modal_add]').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url         : add_ajax,
                    type        : 'POST',
                    data        : formData,
                    dataType    : 'JSON',
                    processData: false,
                    contentType: false,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                            $('form[name=modal_add]')[0].reset();
                            $('.modal_add').modal('hide');
                        }
                });
            });

            var edit_ajax   =   '/Backend/Give_away_point/Edit/';
            $('form[name=modal_edit]').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var id      = $('form[name=modal_edit] input[name=id]').val();
                $.ajax({
                    url         : edit_ajax+id,
                    type        : 'POST',
                    data        : formData,
                    dataType    : 'JSON',
                    processData: false,
                    contentType: false,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                            $('form[name=modal_edit]')[0].reset();
                            $('.modal_edit').modal('hide');
                        }
                });
            });

            $(document).on('click','.edit',function(){
                var info_ajax  =   '/Backend/Give_away_point/Info/';
                $.ajax({
                    url:info_ajax+$(this).attr('data-id'),
                    type:'GET',
                    dataType:'JSON',
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(data){
                        if (Object.keys(data).length > 0){
                            $.each(data,function(key,value){
                                if (key == 'img'){
                                    editSlim.load(value);
                                }else if(key=='type_id'){
                                    $('form[name=modal_edit] select[name='+key+']').val(value);
                                    $('form[name=modal_edit] select[name=type_id]').change();
                                    $(`form[name=modal_edit] select[name=category_id]`).val(data.category_id);
                                }else{
                                    $('form[name=modal_edit] input[name='+key+']').val(value);
                                }
                            });

                        }else{
                            $('.modal_edit').modal('hide');
                            swal({
                                title:'查無資訊',
                                type:'warning'
                            })
                        }
                });
            });

            $(document).on('click','.delete',function(){
                var delete_ajax  =   '/Backend/Give_away_point/Delete/';
                var $this = $(this);
                var id = $this.attr('data-id');
                var title = $this.closest('tr').find('.itemTitle').text();
                swal({
                    title: '是否刪除' + title,
                    text: "刪除後不可回復",
                    type:'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定刪除',
                    cancelButtonText: '取消',
                }).then(function(result){
                    if(result.value){
                        $.ajax({
                            url:delete_ajax+id,
                            type:'POST',
                            dataType:'JSON',
                            beforeSend: function () { waitingDialog.show(); }
                        }).always(function () {
                            waitingDialog.hide();
                        }).done(function(result){
                            ResultData2(result);
                            Table.LoadTable();
                        });
                    }
                });
            });

            //主分類
            $('[name=type_id]').change((e)=>{
                //$('[name=city]').val(e.target.value);

                $('[name=category_id] option').remove();
                console.log(e.target.value);
                var options = (e.target.value)?$("#category_id").find(`option[data-type_id=0],option[data-type_id='${e.target.value}']`).clone():$("#category_id").find(`option:first`).clone();
                $(`[name=category_id]`).append(options);
                $(`[name=category_id]`).find('option').eq(0).prop("selected",true);
            });

        </script>
    </body>
</html>