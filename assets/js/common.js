	// 验证url
    function isURL(str_url) {
        var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        return RegExp.test(str_url);

    }

	function FormHandle(name,data){
		$.each(data,function(i,e){
			$('form[name='+name+'] [name='+i+']').val(e);
		});
	}

	function ResultHandle(result,close=true,target=null){
		if(result.status){
			GetList();
			alert(result.msg);
			if(close){
				if(target){
					$(target).modal('hide');	
				}else{
					$('.modal').modal('hide');		
				}
			}
		}else{
			if(typeof result.msg == 'object'){
				error	=	'';
				$.each(result.msg,function(i,message){
					error	+=	message+'\n';
				});	
			}else{
				error	=	result.msg;
			}
			alert(error);
		}
	}

	function ResultData(result){
		if(result.status){
			if(result.msg){
				swal({
					title:result.msg,
					text:(result.text)?result.text:'',
					type:'success',
					allowOutsideClick:false,
				}).then(() => {
	                if(result.redirect){
						location.href=result.redirect;
					}
	            });
			}
		}else{
			if(typeof result.msg == 'object'){
				error	=	'';
				$.each(result.msg,function(i,message){
					error	+=	message+'\n';
				});	
			}else{
				error	=	result.msg;
			}
			swal({
				title:error,
				type:'error',
				allowOutsideClick:false,
			}).then(() => {
                if(result.redirect){
					location.href=result.redirect;
				}
            });
		}
	}

	function ResultData2(result){
		if(result.status){
			if(result.msg){
				swal({
					title:result.msg,
					type:'success'
				}).then(function(){
					if(result.redirect){
						location.href=result.redirect;	
					}
				});
			}
		}else{
			if(typeof result.msg == 'object'){
				error	=	'';
				$.each(result.msg,function(i,message){
					error	+=	message+'\n';
				});	
			}else{
				error	=	result.msg;
			}
			swal({
				title:error,
				type:'error'
			});
		}
	}

	function ImgHandle(name,img){
        $(name).attr('src','/_upload/images/'+img);
    }

    /*
     * 後台頁碼製作
     * page ul need class name pagination
     * show total div need id datatable_info
    **/
    var Page = {
		page : 1,
		row  : 10,
		DrawPage:function(total){
			var total_page  = Math.ceil(total/Page.row) == 0 ? 1 : Math.ceil(total/Page.row);
	        var span_u      = 0;
	        var str         = '';
	        str += '<li class="page-item '+(Page.page == 1 ? 'disabled' : '')+'"><a class="page-link" data-p="next" href="javascript:void(0);">«</a></li>';
	        if(Page.page<=3||total_page<=4){
	        	var t=(total_page<=4)?total_page:4;
	        	for(var i=1;i<=t;i++){
	        	 	str+='<li class="page-item '+(Page.page == i ? 'active' : '')+'"><a  class="page-link"  href="javascript:;" data-p="'+i+'">'+i+'</a></li>';
	        	}
	        	if(total_page>5)str+='<li class="page-item"><span style="display: inline-block;user-select: none;padding: .6em .8em;">...</span></li>';
	        	if(total_page>4)str+='<li class="page-item"><a class="page-link" href="javascript:;" data-p="'+total_page+'">'+total_page+'</a></li>';
	        }else if(Page.page>=4&&(total_page-2)>4&&(total_page-Page.page)>2){
	        	str+='<li class="page-item"><a class="page-link" href="javascript:;" data-p="1">1</a></li>';
	        	if((parseInt(Page.page)-2)>2)str+='<li class="page-item"><span style="display: inline-block;user-select: none;padding: .6em .8em;">...</span></li>';
	        	str+='<li class="page-item"><a class="page-link" href="javascript:;" data-p="'+(parseInt(Page.page)-2)+'">'+(parseInt(Page.page)-2)+'</a></li>';
	        	str+='<li class="page-item"><a class="page-link" href="javascript:;" data-p="'+(parseInt(Page.page)-1)+'">'+(parseInt(Page.page)-1)+'</a></li>';
	        	str+='<li class="page-item active"><a class="page-link current" href="javascript:;" data-p="'+Page.page+'">'+Page.page+'</a></li>';
	        	str+='<li class="page-item"><a class="page-link" href="javascript:;" data-p="'+(parseInt(Page.page)+1)+'">'+(parseInt(Page.page)+1)+'</a></li>';
	        	str+='<li class="page-item"><a class="page-link" href="javascript:;" data-p="'+(parseInt(Page.page)+2)+'">'+(parseInt(Page.page)+2)+'</a></li>';
	        	if((parseInt(Page.page)+3)!=total_page)str+='<li class="page-item"><span style="display: inline-block;user-select: none;padding: .6em .8em;">...</span></li>';
	        	str+='<li class="page-item"><a class="page-link" href="javascript:;" data-p="'+total_page+'">'+total_page+'</a></li>';
	        }else if((total_page-Page.page)<=2){
	        	str+='<li class="page-item"><a class="page-link" href="javascript:;" data-p="1">1</a></li>';
	        	str+='<li class="page-item"><span style="display: inline-block;user-select: none;padding: .6em .8em;">...</span></li>';
	        	for(var i=total_page-3;i<=total_page;i++){
	        	 	str+='<li class="page-item '+(Page.page == i ? 'active' : '')+'"><a class="page-link" href="javascript:;" data-p="'+i+'">'+i+'</a></li>';
	        	}
	        }

	        str += '<li class="page-item '+(Page.page == total_page ? 'disabled' : '')+'"><a class="page-link" data-p="last" href="javascript:void(0);">»</a></li>';
	        $('#datatable_info').text('總共 '+total+' 筆中第 '+((parseInt(Page.page)-1)*parseInt(Page.row)+1)+' - '+parseInt(Page.page)*parseInt(Page.row)+' 筆')
	        $('ul.pagination').html(str);
	        $('ul.pagination a.page-link').click(function(){
	            if ($(this).data('p') == Page.page) return false;
	            switch($(this).data('p')) {
	                case 'next': Page.page = parseInt(Page.page) - 1; break;
	                case 'last': Page.page = parseInt(Page.page) + 1; break;
	                default: Page.page = parseInt($(this).data('p'));
	            }
	            Table.LoadTable();
	        });
		}
	};

	/*
     * 表格製作
     * div need class name table-responsive
     * result has result.data and result.total
    **/
    var Table = {
    	ajax_url  : 10,
		s         : {},
		ajax_type : 'get',
		LoadTable:function(i,v){
			Table.GetFormData();
			if (Table.ajax_type == 'post') {
				Table.DrawTablePost();
			} else {
				Table.DrawTable();
			}
            
		},
		GetFormData:function(i,v){
			Table.s = {};
			return Table.s;
		},
		DrawTable:function(){
			$.get(Table.ajax_url+'/'+Page.page+'-'+Page.row, Table.s, function(result) {
                var str = '';
		        if (result.data.length > 0) {
		            $.each(result.data, function(i,v) {
		                str += Table.DrawTableList(i,v);
		            });
		        } else {
		            str+='<tr><td colspan="'+($('.table-responsive table thead tr th').length)+'" align="center">没有资料</td></tr>';
		        }
		        Page.DrawPage(result.total);
		        $('.table-responsive table tbody').html(str);
		        $('.table-responsive').responsiveTable('update');
		        Table.Reload();
            });
		},
		DrawTablePost:function(){
			$.post(Table.ajax_url, Table.s, function(result) {
                var str = '';
		        if (result.data.length > 0) {
		            $.each(result.data, function(i,v) {
		                str += Table.DrawTableList(i,v);
		            });
		        } else {
		            str+='<tr><td colspan="'+($('.table-responsive table thead tr th').length)+'" align="center">没有资料</td></tr>';
		        }
		        Page.DrawPage(result.total);
		        $('.table-responsive table tbody').html(str);
		        $('.table-responsive').responsiveTable('update');
		        Table.Reload();
            });
		},
		DrawTableList:function(i,v){
			var str = '<tr><td colspan="'+($('.table-responsive table thead tr th').length)+'" align="center">没有资料</td></tr>';
            return str;
		},
		Reload:function(){
			return true;	
		}
	};

	/*
     * 新表格製作
     * div need class name table-responsive
     * result has result.data and result.total
    **/

    var NewPage = {
		page : 1,
		row  : 10,
		DrawPage:function(total,ClassName,Object){
			var total_page  = Math.ceil(total/Object.page.row) == 0 ? 1 : Math.ceil(total/Object.page.row);
	        var span_u      = 0;
	        var str         = '';
	        str += '<li class="page-item '+(Object.page.page == 1 ? 'disabled' : '')+'"><a class="page-link '+ClassName+'" data-p="next" href="javascript:void(0);">«</a></li>';
	        for (var i=1;i<=total_page;i++) {
	            // if (
	            //     (i == 1) || (i == total_page) || (page <= 4 && i <= 4) ||
	            //     (page > total_page - 4 && i > total_page - 4) || (i > page-2 && i < page+2)
	            // ) {
	                str += '<li class="page-item '+(Object.page.page == i ? 'active' : '')+'"><a class="page-link '+ClassName+'" data-p="'+i+'" href="#">'+i+'</a></li>';
	            // } else {
	            //     if (span_u != i - 1) { str += '<li><span>...</span></li>'; }
	            //     span_u = i;
	            // }
	        }
	        str += '<li class="page-item '+(Object.page.page == total_page ? 'disabled' : '')+'"><a class="page-link '+ClassName+'" data-p="last" href="javascript:void(0);">»</a></li>';
	        $('.dataTables_info.'+ClassName).text('總共 '+total+' 筆中第 '+((parseInt(Object.page.page)-1)*parseInt(Object.page.row)+1)+' - '+parseInt(Object.page.page)*parseInt(Object.page.row)+' 筆')
	        $('ul.pagination.'+ClassName,).html(str);
	        $('ul.pagination a.page-link.'+ClassName,).click(function(){
	            if ($(this).data('p') == Object.page.page) return false;
	            switch($(this).data('p')) {
	                case 'next': Object.page.page = parseInt(Object.page.page) - 1; break;
	                case 'last': Object.page.page = parseInt(Object.page.page) + 1; break;
	                default: Object.page.page = parseInt($(this).data('p'));
	            }
	            Object.LoadTable(ClassName,Object);
	        });
		}
	};

    var NewTable = {
    	ajax_url : 10,
		s        : {},
		LoadTable:function(ClassName,Object){
            Object.DrawTable(ClassName,Object);
		},
		DrawTable:function(ClassName,Object){
			$.get(Object.ajax_url+'/'+Object.page.page+'-'+Object.page.row, Object.s, function(result) {
                var str = '';
		        if (result.data.length > 0) {
		            $.each(result.data, function(i,v) {
		                str += Object.DrawTableList(i,v);
		            });
		        } else {
		            str+='<tr><td colspan="'+($('.table-responsive table thead tr th').length)+'" align="center">没有资料</td></tr>';
		        }
		        Object.page.DrawPage(result.total,ClassName,Object);
		        $('.table-responsive.'+ClassName+' table tbody').html(str);
		        $('.table-responsive.'+ClassName).responsiveTable('update');
		        Object.Reload();
            });
		},
		DrawTableList:function(i,v){
			var str = '<tr><td colspan="'+($('.table-responsive table thead tr th').length)+'" align="center">没有资料</td></tr>';
            return str;
		},
		Reload:function(){
			return true;	
		},
		page:NewPage
	};

	$('form.changepw').submit(function(){
    	var form = new FormData(this);
    	$.ajax({
    		url 		: '/Backend/Admin/ChangePW',
    		type 		: 'POST',
    		dataType 	: 'JSON',
    		data 		: form,
    		processData : false,
            contentType : false,
    		success : function(result){
    			ResultData(result);
    			if (result.status) {
    				$('#changepassword button.closs').click();
    				$('#changepassword input').val('');
    			}
    		}
    	});
    	return false;
    });

    $.fn.modal.Constructor.prototype._enforceFocus = function (){
	    var $modalElement = this.$element;
	    $(document).on('focusin.modal', function (e) {
	        var $parent = $(e.target.parentNode);
	        if (typeof $modalElement != "undefined"&&$modalElement[0] !== e.target && !$modalElement.has(e.target).length
	            // add whatever conditions you need here:
	            &&
	            !$parent.hasClass('cke_dialog_ui_input_select') && !$parent.hasClass('cke_dialog_ui_input_text')) {
	            $modalElement.focus()
	        }
	    });
	};