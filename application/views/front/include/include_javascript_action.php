<!-- <script src="/assets/js/front/jquery-1.12.4.min.js"></script> -->
<script src="/assets/js/front/jquery-3.4.1.js"></script>
<script src="/assets/js/front/popper.min.js"></script>
<script src="/assets/js/front/bootstrap.js"></script>
<script src="<?=version('assets/plugins/sweetalert/sweetalert2.js')?>"></script>
<script type="text/javascript" src="<?=version('assets/js/front/common.js')?>"></script>
<script type="text/javascript" src="<?=version('assets/js/front/loading_front.js')?>"></script>
<script async charset="utf-8" src="<?=version('assets/plugins/ckeditor5/platform.js');?>"></script>
<script async charset="utf-8" src="<?=version('assets/plugins/ckeditor5/oembedUrl.js');?>"></script>
<script src="<?=version('assets/js/front/front_page.js')?>"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- google analysis -->
<?=@$this->web_ga;?>

<script>
    $(function(){
        var isSignin = false;

        $("#AwardBox").dialog({autoOpen: false});
        $('.dailySignin').on('click', function(){
            $('#AwardBox').show();
            $("#AwardBox").dialog('open');
            $.ajax({
                type: 'POST',
                url: '/give_away_points_add',
                data:{},
                dataType: 'json',
                beforeSend: function () {
                  waitingDialog.show();
                },
                complete: function () {
                  waitingDialog.hide();
                },
                success: function (result) {
                    if(result.status){
                        setTimeout(function(){
                            // 簽到第幾天
                            $('#'+result.title).find('.btn-tick').fadeIn('slow')
                            setTimeout(function(){
                               ResultData(result)
                            }, 1000)
                        }, 500)
                    }else{
                        ResultData(result);
                    }
                }
            });
            event.preventDefault();
        })
    })
</script>
