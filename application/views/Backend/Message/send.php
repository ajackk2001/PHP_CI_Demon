<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="<?=version('assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css');?>" rel="stylesheet" />
        <link href="<?=version('assets/plugins/multiselect/css/multi-select.css');?>"  rel="stylesheet" type="text/css" />
        <link href="<?=version('assets/plugins/select2/css/select2.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?=version('assets/plugins/sweetalert/sweetalert2.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=version('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')?>" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .hide{
                display: none;
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
                                	<form name="send">
	                                	<fieldset class="form-group col-md-8">
	                                        <div>
	                                            <label for="exampleSelect1">????????????</label> 
	                                        </div>
	                                        <div class="row">
	                                        	<div class="radio radio-success col-md-2">
		                                            <input type="radio" class="push_time_type" id="push_time_type_1" name="push_time_type" value="1" checked="" data-parsley-multiple="push_time_type" data-parsley-id="5">
		                                            <label for="push_time_type_1"> ???????????? </label>
		                                        </div>
		                                        <div class="radio radio-success col-md-2">
		                                            <input type="radio" class="push_time_type" id="push_time_type_2" name="push_time_type" value="2" data-parsley-multiple="push_time_type">
		                                            <label for="push_time_type_2"> ???????????? </label>
		                                        </div>   
	                                        </div>
	                                    </fieldset>
	                                    <fieldset>
	                                    	<input type="text" class="form-control col-md-2 push_time hide"  name="push_time" >
	                                    </fieldset>
	                                    <div class="form-group col-md-12">
	                                        <label>??????</label>
	                                        <div class="row">
	                                          <div class="radio radio-danger col-md-2">
	                                              <input type="radio" name="send_type" id="all" value="all" checked="" data-parsley-multiple="group_type" data-parsley-id="12">
	                                              <label for="all">????????????</label>
	                                          </div>
	                                          <!-- <div class="radio radio-danger col-md-2">
	                                              <input type="radio" name="send_type" id="type" value="type" data-parsley-multiple="group_type">
	                                              <label for="type">????????????</label>
	                                          </div>
	                                          <div class="radio radio-danger col-md-2">
	                                              <input type="radio" name="send_type" id="select" value="select" data-parsley-multiple="group_type">
	                                              <label for="select">????????????</label>
	                                          </div> --> 
	                                        </div>
	                                    </div>
	                                    <!-- <div id="member_type_select" class="hide">
		                                    <div class="form-group col-xs-12 col-md-12 col-xl-12">
		                                        <label>??????????????????</label>
		                                        <div>
		                                        	<?php
		                                        		foreach ($types as $type) {
		                                        	?>
		                                        		<div class="checkbox checkbox-success">
			                                                <input id="<?=$type->type_name?>" type="checkbox" value="<?=$type->type_id?>" name="member_type[]">
			                                                <label for="<?=$type->type_name?>"><?=$type->type_name?></label>
			                                            </div>
		                                        	<?php
		                                        		}
		                                        	?>
		                                            
		                                        </div>
		                                    </div>
		                                </div>
		                                <div id="member_select" class="row m-b-2 hide">
		                                    <div class="col-xs-12 col-md-6 col-lg-6">
		                                        <select name="member_select[]" class="multi-select" multiple="" id="my_multi_select3">
		                                        	<?php
		                                        		foreach ($members as $member) {
		                                        	?>
		                                        		<option value="<?=$member->id?>"><?=$member->name?> / <?=$member->cellphone?></option>
		                                        	<?php
		                                        		}
		                                        	?>
		                                        </select>     
		                                    </div>                          
		                                </div>   -->
		                                <fieldset class="form-group col-xs-4">
		                                    <label for="exampleSelect1">????????????</label> <a data-toggle="tooltip" data-html="true" data-placement="top" title="" href="javascript:;" data-original-title="1.???????????????????????????????????????????????????<br/>2.????????????????????????????????????????????????????????????"><i class="ion-information-circled"></i></a>
		                                    <select class="form-control" id="format_type" data-parsley-id="41">
		                                        <option value="">--- ?????????????????? ---</option>
												<?php
		                                    		foreach ($settings as $setting) {
		                                    	?>
		                                    	<option value="<?=$setting->id?>"><?=$setting->title?></option>
		                                    	<?php
		                                    		}
		                                    	?>
											</select>
		                                </fieldset>                                           
		                                <!-- <fieldset class="form-group col-xs-6">
		                                    <label>??????</label>
		                                    <input type="text" class="form-control" id="title" name="title" parsley-trigger="change" required="" data-parsley-id="43">
		                                </fieldset> -->
		                                <fieldset class="form-group col-xs-12 col-md-12 col-lg-12 col-xl-6" required="">
		                                    <label for="exampleTextarea">??????</label>
		                                    <textarea class="form-control" name="content" id="content" rows="5" data-parsley-id="45"></textarea>
		                                    <div class="font-13 m-t-1">?????????????????????<span id="text_num">0</span>????????????<span id="message_num">1</span>??????????????????</div>
		                                </fieldset>
                                        <div class="font-13 text-primary">????????????????????? <span id="point">0</span>??? </div>
                                        <div class="font-13 text-primary">?????????74?????????1??? </div>
		                                <div class="center">
		                                    <button type="submit" class="btn btn-primary">????????????</button>
		                                </div>
		                            </form>
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
        <script type="text/javascript" src="<?=version('assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js')?>"></script>
        <script type="text/javascript" src="<?=version('assets/plugins/multiselect/js/jquery.multi-select.js')?>"></script>
        <script type="text/javascript" src="<?=version('assets/plugins/jquery-quicksearch/jquery.quicksearch.js')?>"></script>
        <script type="text/javascript" src="<?=version('assets/plugins/select2/js/select2.full.min.js')?>"></script>
        <script type="text/javascript" src="<?=version('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')?>"></script>
        <script type="text/javascript" src="<?=version('assets/pages/jquery.formadvanced.init.js')?>"></script>
        <script type="text/javascript" src="<?=version('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')?>"></script>
        <script type="text/javascript" src="<?=version('assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-TW.js')?>"></script>

        <script src="<?=version('assets/js/common.js')?>"></script>
        <script type="text/javascript">
        	$('textarea[name=content]').keyup(function(){
                $('#text_num').text($(this).val().length);
            });
        	$('input[name=push_time]').datetimepicker({format: 'yyyy-mm-dd hh:ii'});
        	var settings	=	<?=json_encode($settings)?>;
        	$('#format_type').change(function(){
        		// $('input[name=title]').val(settings[$(this).val()].title);
                $('textarea[name=content]').val(settings[$(this).val()].content);
        	});
        	var mail_send_ajax	=	'/Backend/Message/Send';
        	$('form[name=send]').submit(function(e){
				e.preventDefault();
        		var form    =   $(this);
                var data    =   form.serialize();
                $.ajax({
                    url:mail_send_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:data,
					beforeSend: function () { waitingDialog.show(); }
				}).always(function () {
					waitingDialog.hide();
				}).done(function(result){
                        ResultData2(result);
                });
        	});

            $('.radio.radio-danger>input').click(function(){
                if($(this).attr('id')=='type'){
                    $('#member_type_select').removeClass('hide')
                    $('#member_select').addClass('hide');
                }else if($(this).attr('id')=='select'){
                    $('#member_select').removeClass('hide')
                    $('#member_type_select').addClass('hide');
                }else{
                    $('#member_select').addClass('hide')
                    $('#member_type_select').addClass('hide');
                }

            })
            $('input[name=push_time_type]').click(function(){
            	if($(this).val()==1){
            		$('.push_time').addClass('hide');
            	}else{
            		$('.push_time').removeClass('hide');
            	}
            })
            function GetPoint(){
                var message_point_ajax  =   '/Message/Check';
                $.ajax({
                    url:message_point_ajax,
                    type:'GET',
                    dataType:'JSON',
					beforeSend: function () { waitingDialog.show(); }
				}).always(function () {
					waitingDialog.hide();
				}).done(function(result){
					$('#point').text(result);
                });
            }
            GetPoint();
        </script>
    </body>
</html>