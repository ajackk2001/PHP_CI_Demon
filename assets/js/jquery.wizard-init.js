/**
* Theme: Uplon Admin Template
* Author: Coderthemes
* Form wizard page
*/
    jQuery.validator.addMethod("weblink", function(value, element) {
        if($('input[name=webtitle]').val()&&value){
            var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
            return RegExp.test(value);
        }
        return true;
    }, "請輸入正確的網址");
    jQuery.validator.addMethod("web2", function(value, element) {
        if($('input[name=weblink]').val()&&!value){
            return false;
        }
        return true;
    }, "請輸入相關連結名稱");
    jQuery.validator.addMethod("web", function(value, element) {
        if($('input[name=webtitle]').val()&&!value){
            return false;
        }
        return true;
    }, "請輸入相關連結網址");

    jQuery.validator.addMethod("early_date", function(value, element) {
        if(($('input[name=early_discount]').val()&&$('input[name=early_discount]').val()!=0)&&!value){
            return false;
        }
        return true;
    }, "請輸入早鳥優惠日期");
    jQuery.validator.addMethod("early_discount", function(value, element) {
        if($('input[name=early_date]').val()&&!value){
            return false;
        }
        return true;
    }, "請輸入早鳥優惠折扣金額");
    jQuery.validator.addMethod("group_discount", function(value, element) {
        if($('input[name=group_people]').val()&&!value){
            return false;
        }
        return true;
    }, "請輸入團體優惠折扣金額");
    jQuery.validator.addMethod("group_people", function(value, element) {
        if($('input[name=group_discount]').val()&&!value){
            return false;
        }
        return true;
    }, "請輸入團體優惠人數");
    //
    jQuery.validator.addMethod("check_tracher", function(value, elem){
        var flag = 1;
        $this = $('#'+elem.id).parents('.sessions');
        var id = $('#'+elem.id).data('id');
        var date = $this.find('.date').val();
        var start_time = $this.find('.start_time').val();
        var end_time = $this.find('.end_time').val();
        $.ajax({
            url:'/Backend/Activity/check_teacher/'+id,
            type:'POST',
            dataType:'JSON',
            async:false,
            data:{
                'teacher_id':value,
                'date'      :date,
                'start_time':start_time,
                'end_time'  :end_time,
            },
            success:function(result){
            }
        }).done(function (data) {
            flag =(data.status)? 1:0;
        });
        if(flag == 0){
            return false;
        }else{
            return true;
        }
    },'此時段老師已有行程安排或休假，請更換老師或調整時間');
    jQuery.validator.addMethod("check_deadline", function(value, elem){
        var d1 = value+" 00:00:00";
        $this = $('#'+elem.id).parents('.sessions');
        var d2 = $this.find('.date').val()+" 00:00:00";
        if ( (Date.parse(d1)).valueOf() >= (Date.parse(d2)).valueOf())return false;

        return true;
    },'報名期限日期必須小於開課日期');
    var r=true;
    function check_date() {
        var pathname = location.pathname;
        if(pathname.indexOf("/Backend/Activity/Edit") >= 0 ){
            if($('[name^="date"]').length>=2){
                $('[name^="date"]').each(function (i,v) {
                    var starttime = $('[name="date[0]"]').val() +'T'+$('[name="end_time[0]"]').val();
                    var endtime = $('[name="date['+(i+1)+']"]').val() +'T'+$('[name="start_time['+(i+1)+']"]').val();
                    if(Date.parse(starttime).valueOf() >= Date.parse(endtime).valueOf()){
                        ResultData({
                          msg: '課程時間異常，請重新操作'
                        });
                        r=false;
                        return false;
                    }
                });
            }

        }else{
            if($('[name^="date"]').length>=2){
                $('[name^="date"]').each(function (i,v) {
                    var starttime = $('[name="date['+i+']"]').val() +'T'+$('[name="end_time['+i+']"]').val();
                    var endtime = $('[name="date['+(i+1)+']"]').val() +'T'+$('[name="start_time['+(i+1)+']"]').val();
                    if(Date.parse(starttime).valueOf() >= Date.parse(endtime).valueOf()){
                        ResultData({
                          msg: '課程時間異常，請重新操作'
                        });
                        r=false;
                        return false;
                    }
                });
            }
        }
        return true
    }



!function($) {
    "use strict";

    var FormWizard = function() {};

    FormWizard.prototype.createBasic = function($form_container) {
        $form_container.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onFinishing: function (event, currentIndex) {
                //NOTE: Here you can do form validation and return true or false based on your validation logic
                console.log("Form has been validated!");
                return true;
            },
            onFinished: function (event, currentIndex) {
               //NOTE: Submit the form, if all validation passed.
                console.log("Form can be submitted using submit method. E.g. $('#basic-form').submit()"); 
                $("#basic-form").submit();

            }
        });
        return $form_container;
    },
    //creates form with validation
    FormWizard.prototype.createValidatorForm = function($form_container) {
        $form_container.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.after(error);
            },
            ignore: [],
            rules: {
                'teacher_id[]': { //
                    required: true
                },
                'type': { //
                    required: true
                },
                content: { //
                    required: true
                },
                price: { //
                    required: true,
                    digits: true
                },
                all_discount: { //
                    digits: true,
                },
                early_discount: { //
                    digits: true,
                    early_discount:true
                },
                group_discount: { //
                    digits: true,
                    group_discount:true
                },
                group_people: { //
                    digits: true,
                    group_people:true
                },
                webtitle: {
                    web2: true,
                },
                weblink: {
                    web: true,
                    weblink: true,
                },
                early_date: {
                    early_date: true,
                },
            },
            messages: {
                type: {
                    required: "請選擇活動類型",
                },
                price: {
                    required: "請輸入票卷金額",
                },
            }
        });
        $form_container.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex) {
                $('form[name=Add] textarea[name=content]').val(CKEDITOR.instances.content.getData());
                var data = new FormData(document.forms['Add']);
                var api = $.fileuploader.getInstance($('input[name="files[]"]'));
                var fileList = api.getFileList();
                var _list = [];
                var _editor = [];
                var msg ={};
                //var fileList = api.getFileList();
                if (!Slim.find(document.getElementsByClassName('slim')[0]).data.input.name){
                   msg.slim = "要求含有 活動封面 欄位";
                }
                if (fileList.length === 0) {
                  msg.carousel = "要求含有 活動圖片 欄位";
                }
                if ($('form[name=Add] textarea[name=content]').val() == '') {
                  msg.content = "要求含有 內容 欄位";
                }

                if (Object.keys(msg).length > 0) {
                    ResultData({
                      msg: msg
                    });
                    return false;
                }
                $form_container.validate().settings.ignore = ":disabled,:hidden";
                r = $form_container.valid();
                if(r)check_date();
                return r;
            },
            onFinishing: function (event, currentIndex) {
                $form_container.validate().settings.ignore = ":disabled";
                return $form_container.valid();
            },
            onFinished: function (event, currentIndex) {
                swal({
                    title:'確定上傳?',
                    type:'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定',
                    cancelButtonText: '取消',
                }).then(function(result){
                    if(result.value){
                        $('form[name=Add]').submit();
                    }

                });
            },
            labels: {
                cancel: "Cancel",
                current: "current step:",
                pagination: "Pagination",
                finish: "上傳",
                next: "下一步",
                previous: "上一步",
                loading: "Loading ..."
            }
        });

        return $form_container;
    },
    //creates vertical form
    FormWizard.prototype.createVertical = function($form_container) {
        $form_container.steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "fade",
            stepsOrientation: "vertical"
        });
        return $form_container;
    },
    FormWizard.prototype.init = function() {
        //initialzing various forms

        //basic form
        this.createBasic($("#basic-form"));

        //form with validation
        this.createValidatorForm($("#wizard-validation-form"));

        //vertical form
        this.createVertical($("#wizard-vertical"));
    },
    //init
    $.FormWizard = new FormWizard, $.FormWizard.Constructor = FormWizard
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    //$.FormWizard.init()
}(window.jQuery);