<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('front/include/layout_head');?>
    <title><?=$this->web_title?></title>

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/front/jquery.scrollbar.css">
    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/assets/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/assets/js/front/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/assets/plugins/adminLTE/css/adminlte.css">

    <link rel="stylesheet" href="<?=version('assets/css/front/style.css')?>">
    <style type="text/css">
        #chatmessage div{padding: 3px 0;}
        .from{
            color: #1265e8;
            font-weight: bold;
        }
        .file_class{
            opacity: 0;
            z-index: 10000;
            left: -7px;
            position: absolute;
            width: 45px;
        }
        .i_class{
                position: absolute;
            top: 5px;
            z-index: 0;
            left: 2px;
        }

        .to{
            color: #e82612;
            font-weight: bold;
        }
        .imgBoxContainer{
            height: 200px;
            position: relative;
        }
        .imgBoxContent{
            width: 150px;
            text-align: center;
            position: relative;
            top: 25%;
            transform: translateY(-50%);
        }
        .imgBoxContent i{
            font-size: 26px;
            color: #999;
        }
        .imgBoxText{
            margin-top: 10px;
            font: normal 16px 'Century Gothic', '微軟正黑體';
            color: #333;
        }
    </style>
</head>
<body>
    <?php //$this->load->view('front/include/include_cover18');?>
    <?php $this->load->view('front/include/include_header');?>
    <main>
        <section class="message_page">
            <div class="Messenger">
                <p class="messenger_p">聯絡人</p>
                <div class="left_menu_loader">
                    <a href="#"></a>
                </div>
                <ul class="scroll-hide chat_meta_list">
                </ul>
            </div>
            <div class="Messenge_content">
                <p class="Messenge_content_p to_member_title">
                </p>
                <div class="message_content_box">
                    <div class="message_content_scrollable" id="chatmessage">
                    </div>
                    <div class="message-input-box d-none">
                        <a href="javascript:;" style="position: relative;">
                            <input name="progressbarTW_img" type="file" class="file_class" accept="image/gif, image/jpeg, image/png">
                            <i class="fas fa-plus-circle i_class"></i>
                        </a>
                        <textarea id="msgbox" class="message-input" type="text" placeholder=""></textarea>
                        <a href="javascript:;" id="send-btn"><i class="fab fa-telegram-plane"></i></a>
                    </div>
                </div>
                <div class="mediaSelector"></div>
            </div>
        </section>
    </main>
    <?php $this->load->view('front/include/include_footer'); ?>
    <?php $this->load->view('front/include/include_javascript_action'); ?>
    <script src="/assets/js/front/jquery.scrollbar.min.js"></script>
    <script src="<?=version('/assets/js/front/main.js')?>"></script>
    <script>
        function scrollToBottom () { //控制滾動條一直顯示在底部
            var height = document.getElementById('chatmessage').scrollHeight;
            if (height > $('#chatmessage').scrollTop()) {
                $('#chatmessage').scrollTop(height);
            }
        }
        var page = 0;//初始資料
        var row = 1;//預設產出資料筆數
        var room_key='';
        var member_id= '<?=$member_id;?>';
        var ajax_url = '/admin/chat_json/'+member_id;
        var ajax_url2 = '/chat_get_json/'+member_id;
        var member_list=[];
        var name = '<?=$name;?>';
        var to_member_id= '';
        $.LoadTable=function(){
            var form    =   $('form[name=search]').serialize();
            //Page.row=10;
            //Page.cookie_name='activity_page';
            //Page.page=($.cookie(Page.cookie_name))?$.cookie(Page.cookie_name):Page.page;
            $.ajax({
                url:ajax_url,
                type:'POST',
                dataType:'JSON',
                async:false,
                beforeSend: function () {
                  waitingDialog.show();
                },
                complete: function () {
                  waitingDialog.hide();
                },
                success:function(data){//<img src="${(e.img||'/assets/images/front/member_default.jpg')}">
                    str='';
                    var to_member=(data.to_member)?data.to_member:'';
                    $.each(data.list,function(i,e){
                        str +=`
                            <li>
                                <a href="javascript:;" class="chat_add" data-id="${e.to_user}" data-key="${e.room_key}">
                                    <div class="Messenger_pic">
                                            <img src="${(e.img||'/assets/images/front/member_default.jpg')}">
                                    </div>
                                    ${e.nickname}
                                </a>
                            </li>
                        `;
                    });
                    $('.chat_meta_list').html(str);
                    var str2='';
                    if(to_member){
                        $('#chatmessage').html('');
                        $('.to_member_title').html(`<a href="javascript:;"><img src="${(to_member.img||'/assets/images/front/member_default.jpg')}">${to_member.nickname}</a>`);
                        $.each(data.chat_meta,function(i,e){
                            var message=(e.type==1)?e.message:`<img src="${e.message}">`;
                            str2 +=(member_id==e.from_user&&e.message)?`
                                <div><span class="from">${name}</span> : <span class="user_message">${message}</span></div>
                            `:`<div><span class="to">${to_member.nickname}</span> : <span class="user_message">${message}</span></div>`;
                        });
                        var tt =(to_member.type==2)?`以 ${to_member.chat_point}傳送訊息`:"提交...";
                            $('#msgbox').attr('placeholder',tt);
                        $('#chatmessage').append(str2);
                        setTimeout(function(){scrollToBottom();}, 500);
                        to_member_id=to_member.to_user;
                        room_key=to_member.room_key;
                        page=data.total+1;
                       //console.log(page);
                    }

                }

            });
        };
        $(function() {
            var x=1;
            $.LoadTable();

            setInterval(function(){ chat_get() },2000);

            $.LoadTable2=function(key){
                $.ajax({
                    url:ajax_url2,
                    type:'POST',
                    dataType:'JSON',
                    data:{'room_key':key},
                    async:false,
                    beforeSend: function () {
                        $('#chatmessage').html('');
                        var top = $('#chatmessage').offset().top;
                        $('#chatmessage').scrollTop(top);
                        waitingDialog.show();
                    },
                    complete: function () {
                        waitingDialog.hide();
                    },
                    success:function(data){//<img src="${(e.img||'/assets/images/front/member_default.jpg')}">
                        var to_member= data.to_member;
                        var str2='';
                        $('#chatmessage').html('');
                        $('.to_member_title').html(`<a href="javascript:;"><img src="${(to_member.img||'/assets/images/front/member_default.jpg')}">${to_member.nickname}</a>`);
                        $.each(data.list,function(i,e){
                            var message=(e.type==1)?e.message:`<img src="${e.message}">`;
                            str2 +=(member_id==e.from_user&&e.message)?`
                                <div><span class="from">${name}</span> : <span class="user_message">${message}</span></div>
                            `:`<div><span class="to">${to_member.nickname}</span> : <span class="user_message">${message}</span></div>`;
                        });
                        var tt =(to_member.type==2)?`以 ${to_member.chat_point}傳送訊息`:"提交...";
                        $('#msgbox').attr('placeholder',tt);
                        $('#chatmessage').append(str2);
                        setTimeout(function(){scrollToBottom();}, 150);
                        to_member_id=to_member.to_user;
                        room_key=to_member.room_key;
                        page=data.total+1;

                    }

                });
            }




            function chat_get(){
                //console.log(page);
                if(page>0){
                    $.ajax({
                        url:'/chat_get',
                        type:'POST',
                        dataType:'JSON',
                        data:{'page':page,'limit':row,'room_key':room_key,'member_id':member_id},
                        async:false,
                        success:function(data){//<img src="${(e.img||'/assets/images/front/member_default.jpg')}">
                            if(data.list[0]){
                               // var umsg=replace_em(umsg);//QQ表情 字串轉換
                                var uname = data.list[0].from_name; //user name
                                var umsg = data.list[0].message; //message text
                                var message=(data.list[0].type==1)?umsg:`<img src="${umsg}">`;
                                $('#chatmessage').append("<div><span class=\""+data.list[0].class+"\">"+uname+"</span> : <span class=\"user_message\">"+message+"</span></div>");
                                setTimeout(function(){scrollToBottom();}, 150);
                                page+=1;
                            }
                        }

                    });
                }
            }



            $('#send-btn').click(function(){ //use clicks message send button
                if(!$('#msgbox').val().trim()||$('#msgbox').val().trim()==''){
                    $('#msgbox').val('')
                    return false;
                }
                message_send();
            });
            $('#msgbox').keypress(function(event){ //按下Enter 自動送出訊息
                if(event.keyCode==13){
                    if(!$('#msgbox').val().trim()||$('#msgbox').val().trim()==''){
                        $('#msgbox').val('')
                        return false;
                    }
                    message_send();
                }
            });
            var f = true;
            function message_send(){
                var mymessage = $('#msgbox').val(); //get message text
                var myname = '<?=$name;?>'; //get user name
                var member_id = '<?=$member_id;?>'; //get user name
                var msg = {
                    type : 'usermsg',
                    message: mymessage,
                    name: myname,
                    member_id: member_id,
                    to_member: to_member_id,
                    color : ''
                };
                var ajax_url='/chat/chat_list_add/';
                if(f){
                    f=false;
                    $.ajax({
                        type: 'POST',
                        url: ajax_url,
                        data:msg,
                        dataType: 'json',
                        success:function(r){
                            if(r.status&&r.chat_data){
                               $('#chatmessage').append("<div><span class='from'>"+r.chat_data.name+"</span> : <span class=\"user_message\">"+r.chat_data.message+"</span></div>");
                                var ler=$('#chatmessage').scrollTop()+30;
                                $('#chatmessage').scrollTop(ler)
                                $('#msgbox').val('');
                                if(r.type==2)$('#member_point').html(r.points);
                            }else{
                                ResultData(r);
                                $('#msgbox').val('');
                            }
                            f=true;
                        }

                    });
                }
                //convert and send data to server (連接傳送數據)
                //
            }


            $("input[name='progressbarTW_img']").on("change", function() {
                //產生 FormData 物件
                var file_data = new FormData(),
                    file_name = $(this)[0].files[0]['name'],
                    save_path = "uploads/chat_image/";
                if(!check(file_name)){
                    swal({
                        title:'請上傳圖片檔',
                        type:'warning',
                        allowOutsideClick:false,
                    });
                    return false;
                }
                var member_id = '<?=$member_id;?>'; //get user name
                var myname = '<?=$name;?>'; //get user name
                //FormData 新增剛剛選擇的檔案
                file_data.append("file", $(this)[0].files[0]);
                file_data.append("save_path", save_path);
                file_data.append("member_id", member_id);
                file_data.append("to_member", to_member_id);
                file_data.append("room_key", room_key);
                file_data.append("name",  myname);

                //console.log($(this)[0].files);
                // return false;
                //透過ajax傳資料
                $.ajax({
                    type : 'POST',
                    url : '/chat/upload_image',
                    data : file_data,
                    cache : false, //因為只有上傳檔案，所以不要暫存
                    processData : false, //因為只有上傳檔案，所以不要處理表單資訊
                    contentType : false, //送過去的內容，由 FormData 產生了，所以設定false
                    dataType : 'JSON',
                    beforeSend: function () {
                        var str2=`<div class="imgBoxContent">
                                <i class="fas fa-spinner fa-pulse"></i>
                                <div class="imgBoxText">
                                    檔案上傳中...
                                </div>
                            </div>`;
                        $('#chatmessage').append(str2);
                    },
                    complete: function () {
                      $(".imgBoxContent").remove();
                    },
                    success:function(result){
                        if(result.status){
                            $('#chatmessage').append("<div><span class='from'>"+result.chat_data.name+"</span> : <span class=\"user_message\"><img src='"+result.chat_data.message+"'></span></div>");
                            setTimeout(function(){scrollToBottom();}, 150);
                        }else{
                            if(result.msg=='停留此頁面時間過久，請重新登入')result.redirect='/member/login';
                            ResultData(result);
                        }
                    },

                }).done(function(result) {

                }).fail(function(jqXHR, textStatus, errorThrown) {
                });
            });


        })

        function inArray(needle,array,bool){
            if(typeof needle=="string"||typeof needle=="number"){ 
                for(var i in array){
                    if(needle===array[i]){
                        if(bool){
                            return i;
                        }
                        return true;
                    }
                }
                return false;
            }
        }

        $(document).on('click','.chat_add',function(){
            var id = $(this).data('id');
            var key = $(this).data('key');
            $.LoadTable2(key);
        });



        function check(picture) {
            const regex = /^.+\.(jpe?g|gif|png)$/i;
            if (regex.test(picture)) {
                return true;
            } else {
                return false;
            }
        }





    </script>
</body>
</html>