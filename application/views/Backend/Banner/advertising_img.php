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
                            <div class="col-md-12">
                                <div class="card-box" >
                                    <div class="clearfix">
                                        <button type="button" class="btn btn-custom waves-effect waves-light add" data-toggle="modal" data-target=".modal_add">新增首頁廣告</button>
                                    </div>

                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered data_list">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="30" data-tablesaw-sortable-col data-tablesaw-priority="1" data-priority="1">#</th>
                                                        <th width="150" class="text-center" data-priority="1">更新時間</th>
                                                        <th width="150" class="text-center" data-priority="1">圖片1</th>
                                                        <th width="150" class="text-center" data-priority="1">圖片2</th>
                                                        <th width="150" class="text-center" data-priority="1">圖片3</th>
                                                        <th width="150" class="text-center" data-priority="1">圖片4</th>
                                                        <th width="70" class="text-center" data-priority="1">啟用</th>
                                                        <!-- <th width="150" class="text-center" data-priority="1">瀏覽數</th> -->
                                                        <th width="70" class="text-center" data-priority="1">編輯</th>
                                                        <th width="70" class="text-center" data-priority="1">刪除</th>
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
                                            <h5 class="modal-title" id="mySmallModalLabel">新增主題圖片</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <h5 class="m-b-20"><i class="ion-ios7-pricetag"></i> 圖片1<span class="text-danger">*</span> </h5>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for=""><small class="text-info">建議尺寸 955*634</small></label>
                                                        <input type="file" name="slim[]" id="addSlim" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addWeblink">圖片1連結網址<span class="text-danger"></span></label>
                                                        <input type="url" name="weblink1" class="form-control" placeholder="" >
                                                    </fieldset>
                                                </div>
                                                <h5 class="m-b-20"><i class="ion-ios7-pricetag"></i> 圖片2<span class="text-danger">*</span> </h5>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for=""><small class="text-info">建議尺寸 955*314</small></label>
                                                        <input type="file" name="slim[]" id="addSlim2" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addWeblink">圖片2連結網址<span class="text-danger"></span></label>
                                                        <input type="url" name="weblink2" class="form-control" placeholder="" >
                                                    </fieldset>
                                                </div>

                                                <h5 class="m-b-20"><i class="ion-ios7-pricetag"></i> 圖片3<span class="text-danger">*</span> </h5>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for=""><small class="text-info">建議尺寸 472*314</small></label>
                                                        <input type="file" name="slim[]" id="addSlim3" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addWeblink">圖片3<span class="text-danger"></span></label>
                                                        <input type="url" name="weblink3" class="form-control" placeholder="" >
                                                    </fieldset>
                                                </div>

                                                <h5 class="m-b-20"><i class="ion-ios7-pricetag"></i> 圖片4<span class="text-danger">*</span> </h5>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for=""><small class="text-info">建議尺寸 472*314</small></label>
                                                        <input type="file" name="slim[]" id="addSlim4" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addWeblink">圖片4<span class="text-danger"></span></label>
                                                        <input type="url" name="weblink4" class="form-control" placeholder="" >
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
                                            <h5 class="modal-title" id="mySmallModalLabel">編輯主題圖片</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <h5 class="m-b-20"><i class="ion-ios7-pricetag"></i> 圖片1<span class="text-danger">*</span> </h5>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for=""><small class="text-info">建議尺寸 955*634</small></label>
                                                        <input type="file" name="slim[]" id="editSlim" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addWeblink">圖片1連結網址<span class="text-danger"></span></label>
                                                        <input type="url" name="weblink1" class="form-control" placeholder="" >
                                                    </fieldset>
                                                </div>
                                                <h5 class="m-b-20"><i class="ion-ios7-pricetag"></i> 圖片2<span class="text-danger">*</span> </h5>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for=""><small class="text-info">建議尺寸 955*314</small></label>
                                                        <input type="file" name="slim[]" id="editSlim2" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addWeblink">圖片2連結網址<span class="text-danger"></span></label>
                                                        <input type="url" name="weblink2" class="form-control" placeholder="" >
                                                    </fieldset>
                                                </div>

                                                <h5 class="m-b-20"><i class="ion-ios7-pricetag"></i> 圖片3<span class="text-danger">*</span> </h5>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for=""><small class="text-info">建議尺寸 472*314</small></label>
                                                        <input type="file" name="slim[]" id="editSlim3" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addWeblink">圖片3<span class="text-danger"></span></label>
                                                        <input type="url" name="weblink3" class="form-control" placeholder="" >
                                                    </fieldset>
                                                </div>

                                                <h5 class="m-b-20"><i class="ion-ios7-pricetag"></i> 圖片4<span class="text-danger">*</span> </h5>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for=""><small class="text-info">建議尺寸 472*314</small></label>
                                                        <input type="file" name="slim[]" id="editSlim4" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addWeblink">圖片4<span class="text-danger"></span></label>
                                                        <input type="url" name="weblink4" class="form-control" placeholder="" >
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
            let slimOption = {
                forceSize: {
                    width: <?=$img_width1;?>,
                    height: <?=$img_height1;?>,
                },
                label:'圖片1',
                maxFileSize:'8'
            };

            let slimOption2 = {
                forceSize: {
                    width: <?=$img_width2;?>,
                    height: <?=$img_height2;?>,
                },
                label:'圖片2',
                maxFileSize:'8'
            };

            let slimOption3 = {
                forceSize: {
                    width: <?=$img_width3;?>,
                    height: <?=$img_height3;?>,
                },
                label:'圖片3',
                maxFileSize:'8'
            };

            let slimOption4 = {
                forceSize: {
                    width: <?=$img_width3;?>,
                    height: <?=$img_height3;?>,
                },
                label:'圖片4',
                maxFileSize:'8'
            };

            let addSlim = new Slim(document.getElementById('addSlim'),slimOption);
            let addSlim2 = new Slim(document.getElementById('addSlim2'),slimOption2);
            let addSlim3 = new Slim(document.getElementById('addSlim3'),slimOption3);
            let addSlim4 = new Slim(document.getElementById('addSlim4'),slimOption4);
            let editSlim = new Slim(document.getElementById('editSlim'),slimOption);
            let editSlim2 = new Slim(document.getElementById('editSlim2'),slimOption2);
            let editSlim3 = new Slim(document.getElementById('editSlim3'),slimOption3);
            let editSlim4 = new Slim(document.getElementById('editSlim4'),slimOption4);

            $(document).ready(() => {

                $('.modal').on('hide.bs.modal', function (e) {
                    $('form[name=modal_edit]')[0].reset();

                    editSlim.remove();
                })

                var json_ajax =   '/Backend/Add_img/List';
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
                                            <td class="text-center vertical-align-middle">${e.update_time}</td>
                                            <td class="text-center vertical-align-middle"><a href="${e.weblink1?e.weblink1:"javascript:"}" target="_blank"><span class="text-muted"><img src="/${e.img1}" height="60"></span></a></td>
                                            <td class="text-center vertical-align-middle"><a href="${e.weblink2?e.weblink2:"javascript:"}" target="_blank"><span class="text-muted"><img src="/${e.img2}" height="60"></span></a></td>
                                            <td class="text-center vertical-align-middle"><a href="${e.weblink3?e.weblink3:"javascript:"}" target="_blank"><span class="text-muted"><img src="/${e.img3}" height="60"></span></a></td>
                                            <td class="text-center vertical-align-middle"><a href="${e.weblink4?e.weblink4:"javascript:"}" target="_blank"><span class="text-muted"><img src="/${e.img4}" height="60"></span></a></td>
                                            <td class="text-center vertical-align-middle"><input class="status" type="checkbox" ${((e.status==1)?'checked':'')} data-id="${e.id}" data-plugin="switchery" data-color="#64b0f2" data-size="small"></td>
                                            <td class="text-center vertical-align-middle">
                                                <a href="javascript:void(0);" class="edit" data-id="${e.id}" data-toggle="modal" data-target=".modal_edit"><i class="zmdi zmdi-edit text-info"></i></a>
                                            </td>
                                            <td class="text-center vertical-align-middle">
                                                <a href="javascript:;" data-id="${e.id}" class="delete-alert delete"><i class="zmdi zmdi-delete text-danger"></i></a>
                                            </td>
                                        </tr>`;
                                        // <td class="text-center vertical-align-middle">${e.ctr}</td>
                            });
                            if(str=='')str=' <tr><td colspan="20" class="text-center" data-org-colspan="1" data-priority="1" data-columns="tech-companies-1-col-0" style="background-color: rgba(0,0,0,.05);">無內容</td></tr>';
                            $('.data_list>tbody').html(str);
                            $.each($('input[data-plugin=switchery]'),function(i,e){
                                new Switchery(e,{color:$('input[data-plugin=switchery]').eq(i).data('color'),size:$('input[data-plugin=switchery]').eq(i).data('size'),});
                            });
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
                    var seq_ajax  =   '/Backend/Add_img/UpdateSeq';
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

                var status_ajx  =   '/Backend/Add_img/UpdateStatus/';
                $(document).on('change','.status',function(){
                    $.ajax({
                        url:status_ajx+$(this).attr('data-id'),
                        type:'POST',
                        dataType:'JSON',
                        data:{'status':(($(this).prop('checked'))?1:0)},
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
                $.post('/Backend/Add_img/LastSeq',{},(result)=>{
                    seq = parseInt(result)+1;
                    $('form[name=modal_add] input[name=seq]').val(seq);
                });
            });

            var add_ajax   =   '/Backend/Add_img/Add';
            $('form[name=modal_add]').submit(function(e){
                e.preventDefault();
                var msg = {};
                if(!addSlim.data.input.name||!addSlim2.data.input.name||!addSlim3.data.input.name||!addSlim4.data.input.name){
                    msg.banner = "尚有圖片未上傳"
                }
                if (Object.keys(msg).length != 0) {
                    ResultData({
                        msg: msg
                    });
                    return false;
                }
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
                            $('.modal_add').modal('hide');
                            Table.LoadTable();
                            $('form[name=modal_add]')[0].reset();
                            addSlim.remove();
                            addSlim2.remove();
                            addSlim3.remove();
                            addSlim4.remove();
                        }
                });
            });

            var edit_ajax   =   '/Backend/Add_img/Edit/';
            $('form[name=modal_edit]').submit(function(e){
                e.preventDefault();
                var msg = {};
                if(!editSlim.data.input.name||!editSlim2.data.input.name||!editSlim3.data.input.name||!editSlim4.data.input.name){
                    msg.banner = "尚有圖片未上傳"
                }
                if (Object.keys(msg).length != 0) {
                    ResultData({
                        msg: msg
                    });
                    return false;
                }
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
                var info_ajax  =   '/Backend/Add_img/Info/';
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
                                if (key == 'img1'){
                                    editSlim.load(value);
                                }else if (key == 'img2'){
                                    editSlim2.load(value);
                                }else if (key == 'img3'){
                                    editSlim3.load(value);
                                }else if (key == 'img4'){
                                    editSlim4.load(value);
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
                var delete_ajax  =   '/Backend/Add_img/Delete/';
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
        </script>
    </body>
</html>