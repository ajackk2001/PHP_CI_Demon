$(document).ready(function() {
    //選單
    $('.navbar-toggle, #toggle').click(function() {
        $(this).toggleClass('active');
        $('#overlay').toggleClass('open');
    });
    $('ul.unit-menu li.dropdown').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });
    $('#accordion a.item').click(function(e) {
        //remove all the "Over" class, so that the arrow reset to default
        $('#accordion a.item').not(this).each(function() {
            if ($(this).attr('rel') != '') {
                $(this).removeClass($(this).attr('rel') + 'Over');
            }
            $(this).siblings('ul').slideUp("slow");
        });
        //showhide the selected submenu
        $(this).siblings('ul').slideToggle("slow");
        //addremove Over class, so that the arrow pointing downup
        $(this).toggleClass($(this).attr('rel') + 'Over');
        e.preventDefault();
    });
    //18禁瀏灠過一次後就不再顯示
    $(".bt-right").on("click", function () {
        $(".cover18").hide();
    });
    $('#over18').on('click', function() {
        $(".cover18").hide();
    })
    $('#under18').on('click', function() {
        window.location.href="https://www.google.com.tw/"
    })
});