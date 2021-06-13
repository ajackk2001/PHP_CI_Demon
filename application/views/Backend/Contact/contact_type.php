<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
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
                                    <?php if(in_array(13, $this->session->userdata('Manager')->menu_permission) ||$this->issuper): ?>
                                	<button type="button" class="btn btn-custom waves-effect waves-light" data-toggle="modal" data-target=".modal_add">新增詢問類型</button>
                                    <?php endif; ?>
                                    <p></p>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive"> 
                                            <table id="tech-companies-1" class="table table-striped table-bordered data_list" data-tablesaw-sortable data-tablesaw-sortable-switch>
                                                <thead>
                                                    <tr>
                                                        <th width="30" data-tablesaw-sortable-col data-tablesaw-priority="1" data-priority="1">#</th>
                                                        <th width="" class="text-center" data-priority="1">類型名稱</th>
                                                        <th width="70" class="text-center" data-priority="1">數量</th>
                                                        <th width="35" class="text-center" data-priority="1">排序<a id="updateSeq" data-toggle="tooltip" data-placement="top" title="更新排序" href="javascript:;" ><i class="ion-loop"></i></a></th>
                                                        <th width="70" class="text-center" data-priority="1">上架</th>
                                                        <?php if(in_array(14, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th width="70" class="text-center" data-priority="1">編輯</th>
                                                        <?php endif; ?>
                                                        <?php if(in_array(15, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                                        <th width="70" class="text-center" data-priority="1" data-toggle="tooltip" data-placement="left" title="數量大於0，不可刪除">刪除<i class="zmdi zmdi-info-outline text-info"></i></th>
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
                        <?php if(in_array(13, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                        <div class="modal fade bs-example-modal-sm modal_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="mySmallModalLabel">新增詢問類型</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form name="modal_add">
                                        <div class="modal-body">
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">詢問類型名稱</label>
                                                <input type="text" name="title" class="form-control" placeholder="詢問類型名稱">
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
                        <?php endif;?>
                        <?php if(in_array(14, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                        <div class="modal fade bs-example-modal-sm modal_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="mySmallModalLabel">編輯詢問類型</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form name="modal_edit">
                                        <div class="modal-body">
                                            <input type="hidden" name="id">
                                            <fieldset class="form-group">
                                                <label for="exampleInputEmail1">詢問類型名稱</label>
                                                <input type="text" name="title" class="form-control" placeholder="詢問類型名稱">
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
                        <?php endif;?>
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
        <script src="<?=version('assets/js/common.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(() => {
                var json_ajax   =   '/Backend/ContactType/';
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
                                            <td class="text-center vertical-align-middle">${e.counts}</td>
                                            <td class="text-center vertical-align-middle"><input style="width: 50px;text-align: center;margin: 0 auto;" type="text" class="order" name="seq[${e.id}]" value="${e.seq}"></td>
                                            <td class="text-center vertical-align-middle"><input class="status" type="checkbox" ${((e.status==1)?'checked':'')} data-id="${e.id}" data-plugin="switchery" data-color="#64b0f2" data-size="small"></td>
                                            <?php if(in_array(14, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                            <td class="text-center vertical-align-middle"><a href="javascript:void(0);" class="edit" data-id="${e.id}" data-toggle="modal" data-target=".modal_edit"><i class="zmdi zmdi-edit text-info"></i></a></td>
                                            <?php endif; ?>
                                            <?php if(in_array(15, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
                                            <td class="text-center">${((e.counts>0)?`<span data-toggle="tooltip" data-placement="left" title="不可刪除"><i class="ion-minus-round"></i></span>`:`<a href="javascript:;" data-id="${e.id}" class="delete-alert delete"><i class="zmdi zmdi-delete text-danger"></i></a>`)}</td>
                                            <?php endif; ?>
                                        </tr>`;

                            });
                            $('.data_list>tbody').html(str);
                            $.each($('input[data-plugin=switchery]'),function(i,e){
                                new Switchery(e,{color:$('input[data-plugin=switchery]').eq(i).data('color'),size:$('input[data-plugin=switchery]').eq(i).data('size'),});
                            });
                            Page.DrawPage(data.total);
                            $('.table-responsive').responsiveTable('update');
                            $('[data-toggle="tooltip"]').tooltip();
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

                $(document).on('click','#updateSeq',function(){
                    var seq_ajax  =   '/Backend/Contact/UpdateSeq';
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

                var status_ajax  =   '/Backend/Contact/UpdateStatus/type/';
                $(document).on('change','.status',function(){
                    $.ajax({
                        url:status_ajax+$(this).attr('data-id'),
                        type:'POST',
                        dataType:'JSON',
                        data:{'status':(($(this).prop('checked'))?1:0)},
                        beforeSend: function () { waitingDialog.show(); }
                    }).always(function () {
                        waitingDialog.hide();
                    }).done(function(result){
                            ResultData2(result);
                    });
                });

            });

            <?php if(in_array(13, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var add_ajax   =   '/Backend/ContactType/Add';
            $('form[name=modal_add]').submit(function(e){
                e.preventDefault();
                var form    =   $(this);
                var data    =   form.serialize();
                $.ajax({
                    url:add_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:data,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                            form[0].reset();
                            $('.modal_add').modal('hide');
                        }
                });
            });
            <?php endif; ?>
            <?php if(in_array(14, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            var edit_ajax   =   '/Backend/ContactType/Edit/';
            $('form[name=modal_edit]').submit(function(e){
                e.preventDefault();
                var form    =   $(this);
                var data    =   form.serialize();
                var id      =   $('form[name=modal_edit] input[name=id]').val();
                $.ajax({
                    url:edit_ajax+id,
                    type:'POST',
                    dataType:'JSON',
                    data:data,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                            form[0].reset();
                            $('.modal_edit').modal('hide');
                        }
                });
            });
            <?php endif; ?>
            $(document).on('click','.edit',function(){
                var info_ajax  =   '/Backend/ContactType/Edit/';
                $.ajax({
                    url:info_ajax+$(this).attr('data-id'),
                    type:'GET',
                    dataType:'JSON',
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(data){
                        $.each(data,function(key,value){
                            $('form[name=modal_edit] input[name='+key+']').val(value);
                        });
                });
            });
            <?php if(in_array(15, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            $(document).on('click','.delete',function(){
                var delete_ajax  =   '/Backend/ContactType/Delete/';
                var id = $(this).attr('data-id');
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

        </script>
    </body>
</html>