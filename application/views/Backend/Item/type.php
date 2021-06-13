<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="<?=version('assets/plugins/sweetalert/sweetalert2.min.css')?>" rel="stylesheet" type="text/css" />
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
                                	<div class="clearfix">
                                        <button type="button" class="btn btn-custom waves-effect waves-light m-b-20 add" data-toggle="modal" data-target=".type_add">新增主分類</button>
                                    </div>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered type_list">
                                                <thead>
                                                <tr>
                                                    <th width="50" class="text-center" data-priority="1">#</th>
                                                    <th class="text-center" data-priority="1">主分類標題</th>
                                                    <th class="text-center" data-priority="1">更新時間</th>
                                                    <th width="72" class="text-center" data-priority="1">作品數量</th>
                                                    <th width="72" class="text-center" data-priority="1">次分類數量</th>
                                                    <th width="72" class="text-center" data-priority="1">主題連結數量</th>
                                                    <th width="72" class="text-center" data-priority="1">熱門分類數量</th>
                                                    <th width="80" class="text-center" data-priority="1">排序<a id="updateOrder" href="javascript:;" title="更新排序" data-toggle="tooltip" data-placement="top"><i class="ion-loop"></i></a></th>
                                                    <th width="60" class="text-center" data-priority="1">上架</th>
                                                    <th width="60" class="text-center" data-priority="1">編輯</th>
                                                    <th width="60" class="text-center" data-priority="1">刪除</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal fade bs-example-modal-sm type_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form name="Type_add">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="mySmallModalLabel">新增主分類</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <fieldset class="form-group">
                                                            <label for="addSeq">排序<span class="text-danger">*</span></label>
                                                            <input type="text" name="seq" class="form-control" id="addSeq" value="0" required><!-- 先預設為最末位 -->
                                                        </fieldset>
                                                        <fieldset class="form-group">
                                                            <label for="exampleInputEmail1">主分類標題<span class="text-danger">*</span></label>
                                                            <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="主分類標題" required>
                                                        </fieldset>
                                                        <fieldset class="form-group">
                                                            <label for="exampleInputEmail1">分類狀態</label>
                                                            <select class="form-control" name="status">
                                                                <option value="1">啟用</option>
                                                                <option value="0">停用</option>
                                                            </select>
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

                                    <div class="modal fade bs-example-modal-sm type_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form name="Type_edit">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="mySmallModalLabel">編輯主分類</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id">
                                                        <fieldset class="form-group">
                                                            <label for="exampleInputEmail1">主分類標題</label>
                                                            <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="主分類標題">
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
        <script src="<?=version('assets/plugins/sweetalert/sweetalert2.js')?>"></script>
        <script src="<?=version('assets/js/common.js')?>"></script>
        <script type="text/javascript">
            var type_ajax =   '/Backend/ItemType/Item';
            Table.DrawTable =   function(){
                $.ajax({
                    url:type_ajax,
                    type:'POST',
                    dataType:'JSON',
                    //data:'title='+$('[name=search_text]').val(),
                    success:function(data){
                        str =   '';
                        $.each(data.list,function(i,e){
                            var quantity=0;
                            var item_quantity=(!data.item_quantity[e.id])?0:data.item_quantity[e.id];
                            var category_quantity=(!data.category_quantity[e.id])?0:data.category_quantity[e.id];
                            var theme_quantity=(!data.theme_quantity[e.id])?0:data.theme_quantity[e.id];
                            var popular_quantity=(!data.popular_quantity[e.id])?0:data.popular_quantity[e.id];
                            str +='<tr>';
                            str +='<td class="text-center">'+(((Page.page-1)*Page.row)+(i+1))+'</td>';
                            str +='<td class="text-center">'+e.title+'</td>';
                            str +='<td class="text-center">'+(e.update_time=='0000-00-00 00:00:00'?e.create_time:e.update_time)+'</td>';
                            str +='<td class="text-center">'+item_quantity+'</td>';
                            str +='<td class="text-center">'+category_quantity+'</td>';
                            str +='<td class="text-center">'+theme_quantity+'</td>';
                            str +='<td class="text-center">'+popular_quantity+'</td>';
                            str +='<td class="text-center">'+`<input class="seq form-control form-control-sm text-center px-0" name="seq[${e.id}]" value="${e.seq}">`+'</td>';
                            str +=(item_quantity==0&&category_quantity==0&&theme_quantity==0&&popular_quantity==0)?'<td class="text-center"><input class="status" type="checkbox" '+((e.status==1)?'checked':'')+' data-id="'+e.id+'" data-plugin="switchery" data-color="#64b0f2" data-size="small"></td>':'<td class="text-center"><a href="javascript:;" data-toggle="tooltip" data-animation="false" data-placement="left" title="此分類已使用，不得下架">---</a></td>';
                            str +='<td class="text-center"><a href="javascript:void(0);" class="edit" data-id="'+e.id+'"><i class="zmdi zmdi-edit text-info"></i></a></td>';

                            str +=(item_quantity==0&&category_quantity==0&&theme_quantity==0&&popular_quantity==0)?'<td class="text-center"><a href="javascript:;" data-id="'+e.id+'" class="delete-alert delete"><i class="zmdi zmdi-delete text-danger"></i></a></td>':'<td class="text-center"><a href="javascript:;" data-toggle="tooltip" data-animation="false" data-placement="left" title="此分類已使用，不得刪除">---</a></td>';
                            str +='</tr>';
                        });
                        if(str=='')str=' <tr><td colspan="20" class="text-center" data-org-colspan="1" data-priority="1" data-columns="tech-companies-1-col-0" style="background-color: rgba(0,0,0,.05);">無內容</td></tr>';
                        $('.type_list>tbody').html(str);
                        $.each($('input[data-plugin=switchery]'),function(i,e){
                            new Switchery(e,{color:$('input[data-plugin=switchery]').eq(i).data('color'),size:$('input[data-plugin=switchery]').eq(i).data('size'),});
                        });
                        $('[data-toggle="tooltip"]').tooltip();
                        $('.table-responsive').responsiveTable('update');
                    }
                });
            }
            $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '焦點', display : '顯示', displayAll: '全部顯示'}});
            Table.LoadTable();

            var type_add_ajax   =   '/Backend/ItemType/Add';
            $('form[name=Type_add]').submit(function(){
                var form    =   $(this);
                var data    =   form.serialize();
                $.ajax({
                    url:type_add_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:data,
                    beforeSend:function(){//表單發送前做的事
                        waitingDialog.show();
                    },
                    complete: function () {
                      waitingDialog.hide();
                    },
                    success:function(result){
                        ResultData(result);
                        if(result.status){
                            Table.LoadTable();
                            form[0].reset();
                            $('.type_add').modal('hide');
                        }
                    }
                });
                return false;
            });

            $(document).on('click','.add',function(){
                $.post('/Backend/ItemType/LastSeq',{},(result)=>{
                    seq = parseInt(result)+1;
                    $('form[name=Type_add] input[name=seq]').val(seq);
                });
            });

            var type_edit_ajax   =   '/Backend/ItemType/Edit/';
            $('form[name=Type_edit]').submit(function(){
                var form    =   $(this);
                var data    =   form.serialize();
                var id      =   $('form[name=Type_edit] input[name=id]').val();
                $.ajax({
                    url:type_edit_ajax+id,
                    type:'POST',
                    dataType:'JSON',
                    data:data,
                    beforeSend:function(){//表單發送前做的事
                        waitingDialog.show();
                    },
                    complete: function () {
                      waitingDialog.hide();
                    },
                    success:function(result){
                        ResultData(result);
                        if(result.status){
                            Table.LoadTable();
                            $('.type_edit').modal('hide');
                        }
                    }
                });
                return false;
            });
            $(document).on('click','.edit',function(){
                var type_info_ajax  =   '/Backend/ItemType/Edit/';
                $.ajax({
                    url:type_info_ajax+$(this).data('id'),
                    type:'GET',
                    dataType:'JSON',
                    success:function(data){
                        $.each(data,function(key,value){
                            $('form[name=Type_edit] input[name='+key+']').val(value);
                            $('form[name=Type_edit] select[name='+key+']').val(value);
                        });
                        $('.type_edit').modal('show');
                    }
                });
            });
            $(document).on('change','.status',function(){
                var type_edit_ajax2  =   '/Backend/ItemType/Edit2/';
                $.ajax({
                    url:type_edit_ajax2+$(this).data('id'),
                    type:'POST',
                    dataType:'JSON',
                    data:{'status':(($(this).prop('checked'))?1:0)},
                    success:function(result){
                        ResultData(result);
                    }
                });
            });

            $(document).on('click','.delete',function(){
                var type_delete_ajax  =   '/Backend/ItemType/Delete/';
                var id 	=	$(this).data('id');
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
		                    url:type_delete_ajax+id,
		                    type:'POST',
		                    dataType:'JSON',
                            beforeSend:function(){//表單發送前做的事
                                waitingDialog.show();
                            },
                            complete: function () {
                              waitingDialog.hide();
                            },
		                    success:function(result){
		                        ResultData(result);
		                        Table.LoadTable();
		                    }
		                });
		            }
                });
            });


            $('#updateOrder').click(function(){
                swal({
                    title:'確定更新排序嗎?',
                    type:'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定',
                    cancelButtonText: '取消',
                }).then(function(result){
                    if(result.value){
                        $.ajax({
                            url: '/Backend/ItemType/updateSeq',
                            type:'POST',
                            dataType:'JSON',
                            data: $('#tech-companies-1 .seq').serialize(),
                            beforeSend:function(){//表單發送前做的事
                                waitingDialog.show();
                            },
                            complete: function () {
                              waitingDialog.hide();
                            },
                            success:function(result){
                                ResultData(result);
                                if(result.status){
                                    Table.LoadTable();
                                }
                            }
                        });
                    }
                    return false;
                });
            });

            $('button#btn_search').click(function(){
                Page.page = 1;
                Table.LoadTable();
            });

            $('button#btn_clear').click(function(){
                $('input,select').val('');
                Table.LoadTable();
            });
        </script>
    </body>
</html>