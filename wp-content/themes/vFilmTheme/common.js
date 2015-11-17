$(function() {
    var win_width = $(window).width();
    var wrap_width = $('#wrap').width();
    var totop_width = $('#totop').width();
    var totop_posi = ([win_width - wrap_width] / 3 - totop_width);
    $('#totop').css({
        'right': totop_posi
    });
    $(window).scroll(function() {
        if ($(window).scrollTop() >= 200)
        {
            $('#totop').slideDown(200);
        } else
        {
            $('#totop').slideUp(200);
        }
    });
    $('#totop').click(function() {
        $('body,html').animate({
            scrollTop: 0
        },
        300)
    });
})

window.onload=function(){
	$(window).scroll(function(){
		var posi = $("#main").height()-$("#menu").height()-10;
		if($(document).scrollTop()>=posi){
			$('#menu').css({'position':'absolute','top':posi});
		}else{
			$('#menu').css({'position':'fixed','top':0});
		}
	});
}