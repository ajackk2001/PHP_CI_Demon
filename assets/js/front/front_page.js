	/*
	 * 前台頁碼製作
	     * page ul need class name pagination
	     * show total div need id datatable_info
	**/
	var Page = {
			page : 1,
			row  : 10,
			cookie_name  : '',
			tag :'',
			total_page:0,
			DrawPage:function(total){
				var total_page  = Math.ceil(total/Page.row) == 0 ? 1 : Math.ceil(total/Page.row);
				Page.total_page=total_page;
		        var span_u      = 0;
		        var str         = '';
		        str+=`<li class="page-item">
				        <a class="page-link ${(Page.page == 1 ? 'disabled' : '')}" href="javascript:void(0);" data-p="next"  aria-label="Previous">
				        <span aria-hidden="true">&laquo;</span>
				        </a>
				      </li>`;
		        if(Page.page<=3||total_page<=4){
		        	var t=(total_page<=4)?total_page:4;
		        	for(var i=1;i<=t;i++){
		        	 	str+='<li class="page-item '+((i==Page.page)?'active':'')+'" aria-current="page"><a class="page-link" href="javascript:;" data-p="'+i+'">'+i+'</a></li>';
		        	}
		        	if(total_page>4)str+='<li><span>...</span></li>';
		        	if(total_page>4)str+='<li aria-current="page"><a class="page-link" href="javascript:;" data-p="'+total_page+'">'+total_page+'</a></li>';
		        }else if(Page.page>=4&&(total_page-2)>4&&(total_page-Page.page)>2){
		        	str+='<li class="page-item" aria-current="page"><a class="page-link" href="javascript:;" data-p="1">1</a></li>';
		        	str+='<li class="page-item" aria-current="page"><span>...</span></li>';
		        	str+='<li class="page-item" aria-current="page"><a class="page-link" href="javascript:;" data-p="'+(parseInt(Page.page)-1)+'">'+(parseInt(Page.page)-1)+'</a></li>';
		        	str+='<li class="page-item" aria-current="page"><a class="page-link current" href="javascript:;" data-p="'+Page.page+'">'+Page.page+'</a></li>';
		        	str+='<li class="page-item" aria-current="page"><a class="page-link" href="javascript:;" data-p="'+(parseInt(Page.page)+1)+'">'+(parseInt(Page.page)+1)+'</a></li>';
		        	str+='<li class="page-item" aria-current="page"><span>...</span></li>';
		        	str+='<li class="page-item" aria-current="page"><a class="page-link" href="javascript:;" data-p="'+total_page+'">'+total_page+'</a></li>';
		        }else if((total_page-Page.page)<=2){
		        	str+='<li class="page-item" aria-current="page"><a class="page-link" href="javascript:;" data-p="1">1</a></li>';
		        	str+='<li class="page-item" aria-current="page"><span>...</span></li>';
		        	for(var i=total_page-3;i<=total_page;i++){
		        	 	str+='<li class="page-item" aria-current="page"><a class="page-link '+((i==Page.page)?'current':'')+'" href="javascript:;" data-p="'+i+'">'+i+'</a></li>';
		        	}
		        }
		        str +=`<li class="page-item" aria-label="Next">
				        <a class="page-link ${(Page.page == total_page ? 'disabled' : '')}" href="javascript:;" data-p="last" >
				        	<span aria-hidden="true">&raquo;</span>
				        </a>
				        </li>`;
		        $('.pagination').html(str);

		        $('ul.pagination a.page-link').click(function(){
		            if ($(this).data('p') == Page.page) return false;
		            switch($(this).data('p')) {
		                case 'next': Page.page = parseInt(Page.page) - 1; break;
		                case 'last': Page.page = parseInt(Page.page) + 1; break;
		                default: Page.page = parseInt($(this).data('p'));
		            }
		            if(Page.page==0)Page.page=1;
		            if(Page.page>total_page)Page.page=total_page;
		            if(Page.cookie_name)$.cookie(Page.cookie_name, Page.page, { path: '/' });
		            $.LoadTable();
		        });
			}
	};