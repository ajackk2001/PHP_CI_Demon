<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="<?=version('assets/plugins/sweetalert/sweetalert2.min.css')?>" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .modal-dialog {max-width: 950px;}
            .label{font-size: 12px;}
            .font-13 {font-size: 14px;}
            .radio-inline, .checkbox-inline {position: relative;display: inline-block;padding-left: 1.25rem;margin-bottom: 0;font-weight: normal;vertical-align: middle;cursor: pointer;}
            .radio {padding-left: 10px;}
            .radio.radio-inline {margin-top: 0;}
            .center {text-align: center;}
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
                                    <div class="table-rep-plugin">
                                            <div class="table-responsive">
                                                <table id="tech-companies-1" class="table table-striped table-bordered type_list">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" data-priority="1" width="80"><a href="javascript:checkboxAll('memberV');">??????</a></th>
                                                            <th class="text-center" data-priority="1" width="140">????????????</th>
                                                            <th class="text-center" data-priority="1">???????????? / ?????? / ??????</th>
                                                            <th class="text-center" data-priority="1"  width="180">????????????(USD)</th>
                                                            <th class="text-center" data-priority="1" width="120">????????????</th>
                                                            <th class="text-center" data-priority="1"  width="120">??????????????????</th>
                                                            <th class="text-center" data-priority="1" width="80">??????</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                    <div class="row m-t-20">
                                        <div style="margin: 0 auto;" class="">
                                            <form name="News_add">
                                                <button style="width: 120px;cursor: pointer;" type="button" id="add_submit" class="btn btn-primary ">?????????(??????)</button>
                                                <button id="export" style="width: 120px;margin-right:5px;cursor: pointer; " type="button" class="btn btn-warning" >????????????</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Row -->

                        <div class="modal fade bs-example-modal-sm news_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form name="News_edit">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mySmallModalLabel">????????????????????????</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-2">
                                                <div class="col-3 text-muted text-line-height" style="line-height: 25px;">????????????</div>
                                                <div class="col-9" id="name" style="line-height: 25px;">1234</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-3 text-muted" style="line-height: 25px;">????????????</div>
                                                <div class="col-9" id="country_title" style="line-height: 25px;"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-3 text-muted" style="line-height: 25px;">????????????</div>
                                                <div class="col-9" id="bank_username" style="line-height: 25px;"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-3 text-muted" style="line-height: 25px;">????????????</div>
                                                <div class="col-9" id="bank_name" style="line-height: 25px;"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-3 text-muted">????????????(???????????????????????????)</div>
                                                <div class="col-9" id="bank_cc" style="line-height: 25px;"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">??????</button>
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
        <script src="<?=version('assets/plugins/sweetalert/sweetalert2.js')?>"></script>
        <script src="<?=version('assets/js/common.js')?>"></script>
        <script type="text/javascript">
            var type_ajax =   '/Backend/Cash/redeemcash_exchange_pending';
            var list = [];
            var member_sn = [];
            var fee = 0;
            Table.DrawTable =   function(){
                var form    =   $('form[name=search]').serialize();
                $.ajax({
                    url:type_ajax,
                    type:'POST',
                    dataType:'JSON',
                    success:function(data){
                        str =   '';
                        list = data.list;
                        fee = data.fee;
                        var str =DrawTr(list);
                        // $.each($('input[data-plugin=switchery]'),function(i,e){
                        //     new Switchery(e,{color:$('input[data-plugin=switchery]').eq(i).data('color'),size:$('input[data-plugin=switchery]').eq(i).data('size'),});
                        // });
                        //Page.DrawPage(data.total);
                        if(str=='')str=' <tr><td colspan="20" class="text-center" data-org-colspan="1" data-priority="1" data-columns="tech-companies-1-col-0" style="background-color: rgba(0,0,0,.05);">?????????</td></tr>';
                        $('.type_list>tbody').html(str);
                        $('[data-toggle="tooltip"]').tooltip();
                        $('.table-responsive').responsiveTable('update');
                    }
                });
            }
            $('.table-responsive').responsiveTable({addFocusBtn:false,i18n: {focus : '??????', display : '??????', displayAll: '????????????'}});
            Table.LoadTable();

            function DrawTr(list){
                var html ='';
                $.each(list,function(i,e){
                    var price = e.points -e.fee;
                    html +=`
                        <tr>
                            <td class="text-center" data-org-colspan="1" data-priority="1" data-columns="tech-companies-1-col-0" colspan="1"><input type="checkbox" data-parsley-multiple="groups" name="memberV" value="${e.id}"></td>
                            <td class="text-center" data-org-colspan="1" data-priority="1" data-columns="tech-companies-1-col-1" colspan="1">${e.date_add}</td>
                            <td class="text-center" data-org-colspan="1" data-priority="1" data-columns="tech-companies-1-col-1" colspan="1">${e.username+' / '+e.name+' / '+e.nickname}</td>
                            <td class="text-center" data-org-colspan="1" data-priority="1" data-columns="tech-companies-1-col-1" colspan="1"><span class="text-success">$${Math.abs(e.USD)}</span></td>
                            <td class="text-center" data-org-colspan="1" data-priority="1" data-columns="tech-companies-1-col-1" colspan="1">?????????</td>
                            <td class="text-center"><a href="javascript:void(0);" class="edit" data-id="${e.member_id}" ><i class="zmdi zmdi-assignment-account text-info"></i></a></td>
                            <td class="text-center" data-org-colspan="1" data-priority="1" data-columns="tech-companies-1-col-1" colspan="1"><a href="javascript:;" data-toggle="tooltip" data-animation="false" data-placement="left" title="??????"><i class="zmdi zmdi-minus-square zmdi-hc-fw text-danger break" data-member_id="${e.member_id}" data-id="${e.id}"></i></a></td>

                        </tr>
                        `;
                });
                return html;
            }

            $(document).on('click','.edit',function(){
                var news_info_ajax  =   '/Backend/Cash/bank_info/';
                $.ajax({
                    url:news_info_ajax+$(this).data('id'),
                    type:'GET',
                    dataType:'JSON',
                    success:function(data){
                        $.each(data,function(key,v){
                            if(key=='bank_code'){
                                $('#'+key).html(v+' '+data.bankname);
                            }else if(key=='branch_code'){
                                $('#'+key).html(v+' '+data.branch_name);
                            }else if(key=='bank_img'){
                                $('#'+key).html(`<img style="width: 90%;" src="/uploads/member/bank/${v}" height="">`);
                            }else{
                                $('#'+key).html(v);
                            }
                        });
                        $('.news_edit').modal('show');
                    }
                });
            });

            $(document).on('click','i.break',function() {
                var ajax_edit   = '/Backend/Cash/redeemcash_exchange_pending_edit/';
                var id          = $(this).data('id');
                var member_id          = $(this).data('member_id');
                swal({
                    title: '?????????????????????',
                    text: '??????????????????????????????????????????!',
                    input: 'text',
                    showCancelButton    : true,
                    confirmButtonText   : '??????',
                    cancelButtonText    : '??????',
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url         : ajax_edit + id,
                            type        : 'POST',
                            dataType    : 'JSON',
                            data        : {status : 2,remark : result.value,member_id : member_id},
                            success:function(result){
                                ResultData(result);
                                if(result.status)Table.LoadTable();
                            }
                        });
                    }else if(!result.dismiss){
                        swal({
                          type:'warning',
                          title: "?????????????????????",
                          confirmButtonText: '??????',
                        });
                        return false;
                    }
                });
            });

            //????????? ??? ?????????
            function checkboxAll(id){
                checkboxs=$('input[name="'+id+'"]');
                checkboxs.prop('checked',!checkboxs.prop("checked"));
            }

            $('#date-range').datepicker({
                toggleActive: true,
                format: 'yyyy-mm-dd',
            });

            $('.reset').click(function(){
                Table.LoadTable();
            });
            var id_sn;
            $("#add_submit").click(function(){
                var arr = {};
                var i=0;
                $("#tech-companies-1 input[name='memberV']").each(function() {
                    if($(this).prop('checked')){
                        id=$(this).val();
                        arr[i] =  id;
                        i++;
                    }
                });
                id_sn = arr;
                if(JSON.stringify(arr) === '{}'){
                    swal({
                      type:'warning',
                      title: "?????????????????????????????????",
                      confirmButtonText: '??????',
                    });
                    return false;
                }
                swal({
                    title:'????????????????',
                    text:'??????????????????????????????????????????!',
                    type:'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '??????',
                    cancelButtonText: '??????',
                }).then(function(result){
                    if(result.value){
                       $('form[name=News_add]').submit();
                    }
                });
            });

            var news_add_ajax   =   '/Backend/Cash/redeemcash_exchange_pending_edit2/';
            $('form[name=News_add]').submit(function(){
                $.ajax({
                    url:news_add_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:id_sn,
                    beforeSend:function(){//????????????????????????
                        waitingDialog.show();
                    },
                    complete: function () {
                      waitingDialog.hide();
                    },
                    success:function(result){
                        if(result.status){
                            //result.text='???????????????????????????????????????????????????';
                            Table.LoadTable();
                        }
                        ResultData(result);
                    }
                });
                return false;
            });

            //??????????????????
            $('button#export').click(function(){
                var arr = [];
                var i=0;
                $("#tech-companies-1 input[name='memberV']").each(function() {
                    if($(this).prop('checked')){
                        id=$(this).val();
                        arr[i] =  id;
                        i++;
                    }
                });
                if(arr.length==0){
                    swal({
                      type:'warning',
                      title: "?????????????????????????????????",
                      confirmButtonText: '??????',
                    });
                    return false;
                }
                var form = $("<form method='post'></form>");
                form.attr({'action':'/Backend/Export/ExportAjax'});
                form.append($("<input type='hidden'>").attr("name", "action").val('redeemcash'));
                form.append($("<input type='hidden'>").attr("name", "id_sn").val(arr));
                $("body").append($(form));
                form.submit();
            });

        </script>
    </body>
</html>
