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
                                    <form name="search">
                                        <div class="form-group">
                                            <select name="action_type" class="custom-select mb-2 mr-sm-2 mb-sm-0 type">
                                                <option value="">全部類型</option>
                                                <option value="LOGIN">登入</option>
                                                <option value="INSERT">新增</option>
                                                <option value="UPDATA">編輯</option>
                                                <option value="DELETE">刪除</option>
                                            </select>
                                        </div>
                                    </form>
                                    <?php if($this->session->userdata('Manager')->permission_type=='superadmin'){ ?>
                                    <button type="button" class="btn btn-sm btn-danger waves-effect waves-light delete-mutiple">刪除選取項目</button>
                                    <?php } ?>
                                    
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered data_list">
                                                <thead>
                                                <tr>
                                                    <?php if($this->session->userdata('Manager')->permission_type=='superadmin'){ ?>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-sortable-default-col="" data-tablesaw-priority="3" class="text-center" data-priority="1"><div class="checkbox checkbox-danger checkbox-single" style="padding:0 0 0 50%"><input class="checkAll" id="checkboxAll" type="checkbox"><label for="checkboxAll" style="margin:0;"></label></div></th>
                                                    <?php } ?>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-sortable-default-col="" data-tablesaw-priority="3" class="text-center" data-priority="1">#</th>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-sortable-default-col="" data-tablesaw-priority="3" class="text-center" data-priority="1">管理員姓名</th>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="2" class="text-center" data-priority="1">管理員帳號</th>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="2" class="text-center" data-priority="1">操作紀錄</th>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="1" class="text-center" data-priority="1">登入IP</th>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="1" class="text-center" data-priority="1" width="200">登入時間</th>
                                                    <?php if($this->session->userdata('Manager')->permission_type=='superadmin'){ ?>
                                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="1" class="text-center" data-priority="1" width="80">刪除</th>
                                                    <?php } ?>
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
        <script type="text/javascript">
            var record_ajax =   '/Backend/Operation/Record';
            Table.DrawTable =   function(){
                var form    =   $('form[name=search]').serialize();
                $.ajax({
                    url:record_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:form+'&page='+Page.page+'&limit='+Page.row,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(data){
                    str =   '';
                    $.each(data.list,function(i,e){
                        str +='<tr>';
                        <?php if($this->session->userdata('Manager')->permission_type=='superadmin'){ ?>
                        str +='<td class="text-center"><div class="checkbox checkbox-danger checkbox-single" style="padding:0 0 0 50%"><input class="multiple" id="checkbox'+i+'" data-id="'+e.id+'" type="checkbox"><label for="checkbox'+i+'" style="margin:0;"></label></div></td>';
                        <?php } ?>
                        str +='<td class="text-center">'+(((Page.page-1)*Page.row)+(i+1))+'</td>';
                        str +='<td class="text-center">'+e.name+'</td>';
                        str +='<td class="text-center">'+e.username+'</td>';
                        str +='<td>'+e.action+'</td>';
                        str +='<td class="text-center">'+e.ip+'</td>';
                        str +='<td class="text-center font-13">'+e.date_add+'</td>';
                        <?php if($this->session->userdata('Manager')->permission_type=='superadmin'){ ?>
                        str +='<td class="text-center"><a href="javascript:;" data-id="'+e.id+'" class="col-md-4 delete"><i class="zmdi zmdi-delete text-danger"></i></a></td>';
                        <?php } ?>
                        str +='</tr>';
                    });
                    $('.data_list>tbody').html(str);
                    Page.DrawPage(data.total);
                    $('.table-responsive').responsiveTable('update');
                    $('#checkboxAll').prop('checked',false);
                });
            }
            $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '焦點', display : '顯示', displayAll: '全部顯示'}});
            Table.LoadTable();
            $('.type').change(function(){
                Table.LoadTable();
            });

            <?php if($this->session->userdata('Manager')->permission_type=='superadmin'){ ?>

            var delete_ajax  =   '/Backend/Operation/RecordDelete';
            $(document).on('click','.delete',function(){
                var id  =   [];
                id.push($(this).attr('data-id'));
                $.ajax({
                    url:delete_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:{'id':id},
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
            $('.delete-mutiple').click(function(){
                var idArr  =   [];
                $('.table-responsive>table .multiple:checked').each(function(){
                        idArr.push($(this).attr('data-id'))
                });
                if(idArr.length>0){
                    var id = idArr.filter(function(element, index, arr){
                    return idArr.indexOf(element) === index;
                     });
                    $.ajax({
                        url:delete_ajax,
                        type:'POST',
                        dataType:'JSON',
                        data:{'id':id},
                        beforeSend: function () { waitingDialog.show(); }
                    }).always(function () {
                        waitingDialog.hide();
                    }).done(function(result){
                        ResultData2(result);
                        if(result.status){
                            Table.LoadTable();
                        }
                    });
                }else{
                    errorMsg = {'status':false,'msg':'請選擇項目'};
                    ResultData2(errorMsg);
                }
            })
            
            $('#checkboxAll').on('change',()=>{
                CheckboxItem = $('.data_list>tbody .checkbox>.multiple');
                if ($('#checkboxAll').prop('checked') === true){
                    CheckboxItem.prop('checked',true);
                }else{
                    CheckboxItem.prop('checked',false);
                }
            });
            <?php } ?>
        </script>
    </body>
</html>