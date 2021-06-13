<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link rel="stylesheet" href="/assets/plugins/slim/slim/slim.min.css">
        <style type="text/css">
            .form-control:disabled, .form-control[readonly] {
                background-color: #fff;
                opacity: 1;
            }
        </style>
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
                                        <button type="button" class="btn btn-custom waves-effect waves-light add" data-toggle="modal" data-target=".modal_add">新增點數方案</button>
                                    </div>

                                    <div class="table-rep-plugin">
                                        <div class="table-responsive">
                                            <table id="tech-companies-1" class="table table-striped table-bordered data_list">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="30" data-tablesaw-sortable-col data-tablesaw-priority="1" data-priority="1">#</th>
                                                        <th width="" class="text-center" data-priority="1">美金金額(USD)/賣場顯示的金額</th>
                                                        <th width="" class="text-center" data-priority="1">優惠%數</th>
                                                        <th width="" class="text-center" data-priority="1">換算點數</th>
                                                        <th width="" class="text-center" data-priority="1">換算台幣(NTD)</th>
                                                        <th width="150" class="text-center" data-priority="1">更新時間</th>
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
                                            <h5 class="modal-title" id="mySmallModalLabel">新增點數方案</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addUSD">請輸入美金金額(USD)<span class="text-danger">*</span></label>
                                                        <input id="addUSD" type="text" name="USD" class="form-control addpoint" value="" required placeholder="請輸入美金金額"><!-- 先預設為最末位 -->
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="">優惠(%)<span class="text-danger"></span></label>
                                                        <input type="text" name="discount" class="form-control addpoint" id="" placeholder="請輸入整數" digits>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addTitle">點數換算<span class="text-danger"></span></label>
                                                        <input type="text"  class="form-control point_total"  placeholder="輸入美金金額後會自動換算" readonly>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addTitle">台幣換算<span class="text-danger"></span></label>
                                                        <input type="text"  class="form-control ntd_total"  placeholder="輸入美金金額後會自動換算" readonly>
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
                                            <h5 class="modal-title" id="mySmallModalLabel">編輯點數方案</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="editUSD">請輸入美金金額(USD)<span class="text-danger">*</span></label>
                                                        <input type="text" name="USD" class="form-control editpoint" id="editUSD" value="" placeholder="請輸入美金金額"><!-- 先預設為最末位 -->
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="">優惠(%)<span class="text-danger"></span></label>
                                                        <input type="text" name="discount" class="form-control editpoint" id="" placeholder="請輸入整數" digits>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addTitle">點數換算<span class="text-danger"></span></label>
                                                        <input type="text"  class="form-control point_total"  placeholder="輸入美金金額後會自動換算" readonly>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">
                                                    <fieldset class="form-group">
                                                        <label for="addTitle">台幣換算<span class="text-danger"></span></label>
                                                        <input type="text"  class="form-control ntd_total"  placeholder="輸入美金金額後會自動換算" readonly>
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
            jQuery.validator.addMethod("err_point", function(value, element) {
                if($('.points_total').val()=='NaN'||$('.point_total').val()==0){
                    return false;
                }
                return true;
            }, "請輸入正確的金額");
            $('form[name=modal_add]').validate({
                rules: {
                    USD: {
                        required: true,
                        digits: true,
                        err_point: true,
                    },
                    discount: {
                        digits: true,
                    },
                },
                messages: {
                    discount: {
                        digits:$.validator.format("請輸入整數"),
                    },
                }
            });

            $('form[name=modal_edit]').validate({
                rules: {
                    USD: {
                        required: true,
                        digits: true,
                        err_point: true,
                    },
                    discount: {
                        digits: true,
                    },
                },
                messages: {
                    discount: {
                        digits:$.validator.format("請輸入整數"),
                    },
                }
            });

            $(document).ready(() => {

                $('.modal').on('hide.bs.modal', function (e) {
                    $('form[name=modal_add]')[0].reset();
                    $('form[name=modal_edit]')[0].reset();
                    $('.point_total').val('');
                    $('.ntd_total').val('');
                })

                var json_ajax =   '/Backend/PointsProgram/Show';
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
                                            <td class="text-center vertical-align-middle">${e.USD} / ${e.USD2}</td>
                                            <td class="text-center">${e.discount}%</td>
                                            <td class="text-center vertical-align-middle">${e.points}點</td>
                                            <td class="text-center vertical-align-middle">${e.NTD}</td>
                                            <td class="text-center vertical-align-middle">${e.update_time}</td>
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
                    var seq_ajax  =   '/Backend/PointsProgram/UpdateSeq';
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

                var status_ajx  =   '/Backend/PointsProgram/UpdateStatus/';
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


            let points = parseInt('<?=$set->points?>');
            let NTD = parseInt('<?=$set->NTD?>');

            $(document).on('input','.addpoint',function(){
                let USD =  Math.round($('form[name=modal_add] [name=USD]').val());
                let discount = $('form[name=modal_add] [name=discount]').val()?parseInt($('form[name=modal_add] [name=discount]').val())*0.01: 0;
                let point_total=Math.round(USD*points*(1+discount));
                let ntd_total=Math.round(USD*NTD);
                $('.point_total').val(point_total);
                $('.ntd_total').val(ntd_total);
            });

            $(document).on('input','.editpoint',function(){
                let USD =  Math.round($('form[name=modal_edit] [name=USD]').val());
                let discount = $('form[name=modal_edit] [name=discount]').val()?parseInt($('form[name=modal_edit] [name=discount]').val())*0.01: 0;
                let point_total=Math.round(USD*points*(1+discount));
                let ntd_total=Math.round(USD*NTD);
                $('.point_total').val(point_total);
                $('.ntd_total').val(ntd_total);
            });


            var add_ajax   =   '/Backend/PointsProgram/Add';
            $('form[name=modal_add]').submit(function(e){
                e.preventDefault();
                if(!$(this).valid()){
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
                            Table.LoadTable();
                            $('form[name=modal_add]')[0].reset();
                            $('.modal_add').modal('hide');
                        }
                });
            });

            var edit_ajax   =   '/Backend/PointsProgram/Edit/';
            $('form[name=modal_edit]').submit(function(e){
                e.preventDefault();
                if(!$(this).valid()){
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
                var info_ajax  =   '/Backend/PointsProgram/Info/';
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
                            if (key == 'points'){
                                $('.point_total').val(value);
                            }else if (key == 'NTD'){
                                $('.ntd_total').val(value);
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
                var delete_ajax  =   '/Backend/PointsProgram/Delete/';
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