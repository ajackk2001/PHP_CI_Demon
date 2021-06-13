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
            <!-- Left Sidebar End -->
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
                        <?php $this->load->view('Backend/layouts/nav');?>
                        <!-- end row -->

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                    <?php if(in_array(34, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                    <div class="clearfix">
                                        <button type="button" class="btn btn-custom waves-effect waves-light m-b-20" data-toggle="modal" data-target=".mail_add">新增格式</button>
                                    </div>
                                    <?php endif; ?>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered mail_list">
                                                <thead>
                                                    <tr>
                                                        <th width="50" data-priority="1" class="text-center">#</th>
                                                        <th width="200" class="text-center" data-priority="1">標題</th>
                                                        <th width="400" class="text-center" data-priority="1">內容</th>
                                                        <th width="200" class="text-center" data-priority="1">更新時間</th>
                                                        <?php if(in_array(35, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th width="80" class="text-center" data-priority="1">編輯</th>
                                                        <?php endif; ?>
                                                        <?php if(in_array(36, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th width="80" class="text-center" data-priority="1">刪除</th>
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
                                    <div class="modal fade bs-example-modal-lg mail_add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-focus="false">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <form name="Mail_add">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">新增郵件格式</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <fieldset class="form-group">
                                                            <label for="addTitle">郵件標題</label>
                                                            <input type="text" name="title" class="form-control" id="addTitle" placeholder="">
                                                        </fieldset>
                                                        <fieldset class="form-group">
                                                            <label for="addContent">郵件內容</label>
                                                            <textarea class="editorContent" id="addContent" name="content" placeholder=""></textarea>
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
                                    <div class="modal fade bs-example-modal-lg mail_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-focus="false">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <form name="Mail_edit">
                                                    <input type="hidden" name="id">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">編輯郵件格式</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <fieldset class="form-group">
                                                            <label for="editTitle">郵件標題</label>
                                                            <input type="text" name="title" class="form-control" id="editTitle" placeholder="">
                                                        </fieldset>
                                                        <fieldset class="form-group">
                                                            <label for="editContent">郵件內容</label>
                                                            <textarea class="editorContent" name="content" id="editContent"></textarea>
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
                                </div>
                            </div>
                        </div>
                        <!-- End of Row -->


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

        <script type="text/javascript">
            //ckeditor5
            var cktoolbarOption = {
                toolbar:{items:["heading","fontSize","fontColor","fontBackgroundColor","removeFormat","|","outdent","indent","alignment","bold","italic","underline","strikethrough","link","bulletedList","numberedList","imageUpload","imageStyle:full","imageStyle:alignLeft","imageStyle:alignCenter","imageStyle:alignRight","mediaEmbed","blockQuote","insertTable","undo","redo"]},
                link: {addTargetToExternalLinks: true}, //自動變成外部連結
                mediaEmbed: {removeProviders: [ 'instagram', 'twitter', 'googleMaps', 'flickr', 'facebook' ]}
            };

            ClassicEditor.create( document.querySelector( '#addContent' ),cktoolbarOption ).then( editor => {window.addContent = editor;} ).catch( error => {console.error( error );} );
            ClassicEditor.create( document.querySelector( '#editContent' ),cktoolbarOption ).then( editor => {window.editContent = editor;} ).catch( error => {console.error( error );} );

            var reTag = /<(?:.|\s)*?>/g;
            var mail_ajax =   '/Backend/Mail/Setting';
            Table.DrawTable =   function(){
                $.ajax({
                    url:mail_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:'page='+Page.page+'&limit='+Page.row,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(data){
                        str =   '';
                        $.each(data.list,function(i,e){
                            str +=`<tr>
                            <td class="text-center">${(((Page.page-1)*Page.row)+(i+1))}</td>
                            <td class="text-center">${e.title}</td>
                            <td class="text-center"><div class="td_content">${e.content.replace(reTag,"")}</div></td>
                            <td class="text-center font-13">${((e.update_time!=null)?e.update_time:'')}</td>
                            <?php if(in_array(35, $this->session->userdata('Manager')->menu_permission)||$this->issuper):  
                                $dinj_edit = ($this->session->userdata('Manager')->username == 'dinjseo')? true:false;
                            ?>
                            <td class="text-center">${((e.lock==1 && !<?=$dinj_edit; ?>)?`<i class="zmdi zmdi-minus"></i>`:`<a href="javascript:void(0);" class="edit" data-id="${e.id}"><i class="zmdi zmdi-edit text-info"></i></a>`)}</td>
                            <?php endif; ?>
                            <?php if(in_array(36, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                            <td class="text-center">${((e.lock==1)?`<i class="zmdi zmdi-minus"></i>`:`<a href="javascript:;" data-id="${e.id}" class="delete-alert delete"><i class="zmdi zmdi-delete text-danger"></i></a>`)}</td>
                            <?php endif; ?>
                            </tr>`;
                        });
                        $('.mail_list>tbody').html(str);
                        Page.DrawPage(data.total);
                        $('.table-responsive').responsiveTable('update');
                });
            }
            $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '焦點', display : '顯示', displayAll: '全部顯示'}});
            Table.LoadTable();

                        
            <?php if(in_array(34, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var mail_add_ajax   =   '/Backend/Mail/AddSetting';
            $('form[name=Mail_add]').submit(function(e){
                e.preventDefault();
                var form = new FormData(this);
                $.ajax({
                    url:mail_add_ajax,
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
                            $('form[name=Mail_add]')[0].reset();
                            addContent.setData('');
                            $('.mail_add').modal('hide');
                        }
                });
            });
            <?php endif; ?>
            <?php if(in_array(35, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var mail_edit_ajax   =   '/Backend/Mail/EditSetting/';
            $('form[name=Mail_edit]').submit(function(e){
                e.preventDefault();
                var form    = new FormData(this);
                var id      = form.get('id');
                $.ajax({
                    url:mail_edit_ajax+id,
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
                        $('form[name=Mail_edit]')[0].reset();
                        editContent.setData('');
                        $('.mail_edit').modal('hide');
                    }
                });
            });

            $(document).on('click','.edit',function(){
                var mail_info_ajax  =   '/Backend/Mail/EditSetting/';
                $.ajax({
                    url:mail_info_ajax+$(this).attr('data-id'),
                    type:'GET',
                    dataType:'JSON',
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(data){
                        $.each(data,function(key,value){
                            if(key=='lock'){
                                if(value=='1'){
                                   $('#editTitle').attr('disabled',true); 
                                }else{
                                    $('#editTitle').attr('disabled',false); 
                                }
                            }else if(key=='content'){
                                editContent.setData(value);
                            }else{
                                $('form[name=Mail_edit] input[name='+key+']').val(value);
                            }
                        });
                        $('.mail_edit').modal('show');
                });
            });
            <?php endif; ?>
            <?php if(in_array(36, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            $(document).on('click','.delete',function(){
                var mail_delete_ajax  =   '/Backend/Mail/DeleteSetting/';
                var id                      =   $(this).attr('data-id');
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
                            url:mail_delete_ajax+id,
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
        </script>
    </body>
</html>