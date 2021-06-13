<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="<?=version('assets/plugins/ckeditor5/ckeditor-styles.css')?>" rel="stylesheet">
        <style>
            .ck.ck-editor__main {
                min-height: 400px;
            }
            .ck.ck-editor__editable_inline {
                overflow: auto;
                min-height: 400px;
            }
        </style>
    </head>
    <body class="fixed-left">
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
                                <div class="card-box">
                                    <?php if(in_array(24, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                    <div class="clearfix">
                                        <button type="button" class="btn btn-custom waves-effect waves-light add" data-toggle="modal" data-target=".modal_add">新增關於我們</button>
                                    </div>
                                    <?php endif; ?>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered data_list">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="30" data-tablesaw-sortable-col data-tablesaw-priority="1" data-priority="1">#</th>
                                                        <th width="350" class="text-center" data-priority="1">標題</th>
                                                        <th width="35" class="text-center" data-priority="1">排序<a id="updateSeq" data-toggle="tooltip" data-placement="top" title="更新排序" href="javascript:;" ><i class="ion-loop"></i></a></th>
                                                        <?php if(in_array(25, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th width="70" class="text-center" data-priority="1">編輯</th>
                                                        <?php endif; ?>
                                                        <?php if(in_array(26, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th width="70" class="text-center" data-priority="1" data-toggle="tooltip" data-placement="left" title="預設一篇不可刪除">刪除<i class="zmdi zmdi-info-outline text-info"></i></th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
                        <div class="modal fade bs-example-modal-lg modal_add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-focus="false">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form name="modal_add">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">新增關於我們</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <fieldset class="form-group">
                                                <label for="addTitle">標題<span class="text-pink">*</span></label>
                                                <input type="text" name="title" class="form-control" id="addTitle" placeholder="標題" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="addContent">內容<span class="text-pink">*</span></label>
                                                <textarea name="content" id="addContent"></textarea>
                                            </fieldset>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                            <button type="submit" class="btn btn-primary">新增</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-example-modal-lg modal_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-focus="false">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form name="modal_edit">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">編輯關於我們</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id">
                                            <input type="hidden" name="folder">
                                            <fieldset class="form-group">
                                                <label for="editTitle">標題<span class="text-pink">*</span></label>
                                                <input type="text" name="title" class="form-control" id="editTitle" placeholder="標題"  required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="editContent">內容<span class="text-pink">*</span></label>
                                                <textarea name="content" id="editContent"></textarea>
                                            </fieldset>
                                        </div>
                                        <div class="modal-footer">
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
        <script src="<?=version('assets/plugins/ckeditor5/ckeditor.js')?>"></script>
        
        <script>
            //ckeditor5
            var cktoolbarOption = {
                toolbar:{items:["heading","fontSize","fontColor","fontBackgroundColor","removeFormat","|","outdent","indent","alignment","bold","italic","underline","strikethrough","link","bulletedList","numberedList","imageUpload","imageStyle:full","imageStyle:alignLeft","imageStyle:alignCenter","imageStyle:alignRight","mediaEmbed","blockQuote","insertTable","undo","redo"]},
                link: {addTargetToExternalLinks: true}, //自動變成外部連結
                mediaEmbed: {removeProviders: [ 'instagram', 'twitter', 'googleMaps', 'flickr', 'facebook' ]}
            };
            
            ClassicEditor.create( document.querySelector( '#addContent' ),cktoolbarOption ).then( editor => {window.addContent = editor;} ).catch( error => {console.error( error );} );
            ClassicEditor.create( document.querySelector( '#editContent' ),cktoolbarOption ).then( editor => {window.editContent = editor;} ).catch( error => {console.error( error );} );

            $(document).ready(() => {
                $('[data-toggle="tooltip"]').tooltip();

                var json_ajax =   '/Backend/About';
                Table.DrawTable =   function(){
                    var form    =   $('form[name=search]').serialize();
                    $.ajax({
                        url:json_ajax,
                        type:'POST',
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
                                            <td class="vertical-align-middle itemTitle">${e.title}</td>
                                            <td class="text-center vertical-align-middle"><input style="width: 50px;text-align: center;margin: 0 auto;" type="text" class="order" name="seq[${e.id}]" value="${e.seq}"></td>
                                            <?php if(in_array(24, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                            <td class="text-center vertical-align-middle"><a href="javascript:void(0);" class="edit" data-id="${e.id}" data-toggle="modal" data-target=".modal_edit"><i class="zmdi zmdi-edit text-info"></i></a></td>
                                            <?php endif; ?>
                                            <?php if(in_array(25, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                            <td class="text-center">${((i==0)?`<span data-toggle="tooltip" data-placement="left" title="第一篇不可刪除"><i class="ion-minus-round"></i></span>`:`<a href="javascript:;" data-id="${e.id}" class="delete-alert delete"><i class="zmdi zmdi-delete text-danger"></i></a>`)}</td>
                                            <?php endif; ?>
                                        </tr>`;

                            });
                            $('.data_list>tbody').html(str);
                            Page.DrawPage(data.total);
                            $('.table-responsive').responsiveTable('update');
                    });
                }

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

            });

            <?php if(in_array(24, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var add_ajax   =   '/Backend/About/Add';
            $('form[name=modal_add]').submit(function(e){
                e.preventDefault();
                $('.modal_add').modal('hide');
                var form = new FormData(this);
                $.ajax({
                    url         : add_ajax,
                    type        : 'POST',
                    data        : form,
                    dataType    : 'JSON',
                    cache       : false,
                    processData : false,
                    contentType : false,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                            $('form[name=modal_add]')[0].reset();
                            addContent.setData('');
                        }else{
                            $('.modal_add').modal('show');
                        }
                });
            });
            <?php endif; ?>
            <?php if(in_array(25, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var edit_ajax   =   '/Backend/About/Edit/';
            $('form[name=modal_edit]').submit(function(e){
                e.preventDefault();
                $('.modal_edit').modal('hide');
                var form    = new FormData(this);
                var id      = form.get('id');
                $.ajax({
                    url         : edit_ajax+id,
                    type        : 'POST',
                    data        : form,
                    dataType    : 'JSON',
                    cache       : false,
                    processData : false,
                    contentType : false,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                            $('form[name=modal_edit]')[0].reset();
                            editContent.setData('');
                        }else{
                            $('.modal_edit').modal('show');
                        }
                });
            });
            <?php endif; ?>
            $(document).on('click','.edit',function(){
                var info_ajax  =   '/Backend/About/Info/';
                $.ajax({
                    url:info_ajax+$(this).attr('data-id'),
                    type:'GET',
                    dataType:'JSON',
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(data){
                        $.each(data,function(key,value){
                            if(key=='content'){
                                editContent.setData(value);
                            }else{
                                $('form[name=modal_edit] input[name='+key+']').val(value);
                            }
                        });
                });
            });

            <?php if(in_array(26, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            $(document).on('click','.delete',function(){
                var delete_ajax  =   '/Backend/About/Delete/';
                var id  =   $(this).attr('data-id');
                swal({
                    title:'確定刪除?',
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
            <?php endif; ?>
            
            $(document).on('click','#updateSeq',function(){
                var seq_ajax  =   '/Backend/Articles/UpdateSeq';
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

        </script>
    </body>
</html>