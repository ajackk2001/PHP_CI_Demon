	//日期格式化
    Date.prototype.Format = function (fmt) { //author: meizz
      var o = {
          "M+": this.getMonth() + 1, //月份
          "d+": this.getDate(), //日
          "h+": this.getHours(), //小时
          "m+": this.getMinutes(), //分
          "s+": this.getSeconds(), //秒
          "q+": Math.floor((this.getMonth() + 3) / 3), //季度
          "S": this.getMilliseconds() //毫秒
      };
      if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
      for (var k in o)
      if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
      return fmt;
    }
    function dateFormat(dateObject,str){
    	var d = new Date(dateObject);var dd = d.Format(str);return dd;
    }
	//过滤HTML标签
    function removeHTMLTag(str) {
        str = str.replace(/<\/?[^>]*>/g, ''); //去除HTML tag
        str = str.replace(/[ | ]*\n/g, '\n'); //去除行尾空白
        //str = str.replace(/\n[\s| | ]*\r/g,'\n'); //去除多余空行
        str = str.replace(/ /ig, ''); //去掉
        return str;
    }

	/**驗證Email**/
    function checkEmail(email) {
      var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if(!regex.test(email)) {
          return false;
      }else{
          return true;
      }
    }

    /**驗證台灣手機號碼**/
    function checkPhone(phone) {
      if (!(/^09\d{8}$/).test(phone) && !(/^9\d{8}$/).test(phone)) {
        return false;
      } else {
        return true;
      }
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
					$('.modal').modal('hide');				}
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
					type:'success'
				}).then(function(){
					if(result.redirect){
						location.href=result.redirect;
					}
				});
			}else{
				if(result.redirect){
					location.href=result.redirect;
				}
			}
		}else{
			if(typeof result.msg == 'object'){
				error	=	'';
				$.each(result.msg,function(i,message){
					error	+=	message+'\n';
				});
			}else if(result.msg){
				error	=	result.msg;
			}else{
				error	=	'未知的錯誤';
			}
			swal({
				title:error,
				text:(result.text)?result.text:'',
				type:'warning',
			}).then(function(){
				if(result.redirect){
					location.href=result.redirect;
				}
			});
		}
	}

	function ImgHandle(name,img){
        $(name).attr('src','/_upload/images/'+img);
    }

    $(document).on('click','.captcha',function(){
		$('.captcha').attr('src','/Captcha/Captcha?'+Math.random());
    });

    function BindHandle(result){
		result	=	jQuery.parseJSON(result);
		if(result.status=='success'){
			location.href	=	result.redirect;
		}else{
			swal({
			  	title: result.msg,
			  	type: result.status,
			});
		}
	}

	var has_active = '';
	$(document).on('click','div.weui-tabbar a.weui-tabbar__item.app',function(){
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$('div.weui-tabbar a:eq('+has_active+')').addClass('active');
		} else {
			has_active = $('div.weui-tabbar a.active').index();
			$('div.weui-tabbar a').removeClass('active');
			$(this).addClass('active');
		}
    });

	// $(document).on('click','a.btn.more',function(){
	// 	var id = $(this).data('type');
	// 	$(this).hide();
	// 	$.ajax({
 //            url         : '/front/member/get_msg/'+id,
 //            type        : 'GET',
 //            dataType    : 'JSON',
 //            data        : {},
 //            success : function(result){
 //            	var url 	= '#';
 //            	var tab_id 	= 'remind';
 //            	var i_class = 'icon-publishsystem';
 //            	var str 	= '';
 //            	if (id == 1) {
 //            		url 	= '/front/member/collections';
 //            		tab_id 	= 'remind2';
 //            		i_class = 'icon-lightpay';
 //            	} else if (id == 2) {
 //            		url 	= '/front/member/order';
 //            		tab_id 	= 'remind3';
 //            		i_class = 'icon-lightpay';
 //            	}
 //            	if (result.length > 0) {
 //            		$.each(result,function(i,b){
 //            			str += '<li>';
	// 					str += '<a href="'+url+'">';
	// 					str += '<i class="iconfont '+i_class+'"></i>';
	// 					str += '<span>'+b.msg+'</span>';
	// 					if (id == 1 || id == 2) {
	// 						str += '<span class="date">'+b.create_time+'</span>';
	// 					}
	// 					str += '</a>';
	// 					str += '</li>';
 //            		});
 //            		$('#'+tab_id+' ul.push').html(str);
 //            	}
 //            }
 //        });
 	//    });

    $(document).on('click','.tab',function(){
    	var t = $(this);
		var id = $(this).data('type');
		$.ajax({
            url         : '/front/read_ajax/'+id,
            type        : 'GET',
            dataType    : 'JSON',
            data        : {},
            success : function(result){
            	if(result.status){
            		t.children('.msgNew').hide();
            		if(result.msg==0)$('.redDot').hide();
            	}
            }
        });
    });

    $("#over18").click(function(){
	    $.post("/over18",{
	    },
	    function(data,status){
	    });
	});


 	//var header_search = $('input.header_search').val();
	// $(document).on('keypress','input.header_search',function(){
	// 	if(event.keyCode == 13){ 
	// 		if ($(this).val() != '' || $(this).val() != header_search)
	// 			location.href = '/?search=' + $(this).val();
	// 	}
	// });
	// $(document).on('keydown','input.header_search',function(){
	// 	if(event.keyCode == 13){ 
	// 		if ($(this).val() != '' || $(this).val() != header_search)
	// 			location.href = '/?search=' + $(this).val();
	// 	}
	// });
	// $(document).on('blur','input.header_search',function(){
	// 	if ($(this).val() != header_search)
 //   			location.href = '/?search=' + $(this).val();
	// });
	// $(document).on('click','#searchCancel',function(){
	// 	if (header_search != '')
	// 		location.href = '/';
	// });
	
