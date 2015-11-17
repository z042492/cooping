<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1" />
<title><?php bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="shortcut icon" type="image/x-icon" href="<?php yeti_tpl_url();?>/favicon.ico" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="<?php bloginfo('template_url');?>/base.js"></script>
<script type="text/javascript">
$(document).bind('pageinit', function(){
	chkDuoshuo();
	$("#login img").on('click', function(e){e.stopPropagation();moreLogin();});
	$("#shareMenu, #shareMenu2, #wxshare").popup({ history: false });	//不产生浏览历史
	$("#sharebtn").on('click', function(){
		if (inWeixin()) $("#wxbtn").show();
	});
	// $("article[post-link]").on('click', function(){
	// 	$.mobile.changePage($(this).attr("post-link"), { transition: "slideup" });
	// });
});
$(document).bind( 'mobileinit', function(){
	$('select').selectmenu({ corners: false });
});
function chkDuoshuo() {
	try {
		if (typeof DUOSHUO == 'undefined') {
			setTimeout("chkDuoshuo()", 800);
			return null;
		}
		var s = DUOSHUO.visitor.data.user_id;
		if (s === 0) dsLogin(0);
		else dsLogin(1);
	} catch(e) {
		if ( (/DUOSHUO.visitor/i).test(e.message) )
			setTimeout("chkDuoshuo()", 800);
	}
}
function entities(str) {	//转义<>防止xss攻击
	return str.replace(/\</g, "&#x3c;").replace(/\>/g, "&#x3e;");
}
function moreLogin() {
	return DUOSHUO.openDialog('<div class="ds-dialog-left"><h2>社交帐号登录</h2>' + DUOSHUO.templates.serviceList() + DUOSHUO.templates.additionalServices() + "</div>")
	.el.find(".ds-dialog").css("width", "220px");
}
function dsLogin(s) {
	if (s == 1) {
		$(".userinfo img").attr({'src': DUOSHUO.visitor.data.avatar_url});
		$(".userinfo span").html( entities(DUOSHUO.visitor.data.name) );
		$(".exit").attr({'href': DUOSHUO.templates.logoutUrl()});
		$('#control_list').listview('refresh');
		$("#login").hide();
	} else {
		$(".exit").html("关闭").on("tap",function(){ $("#control_panel").panel("close"); });
	}
}
function inWeixin() {
	if (typeof WeixinJSBridge == 'undefined') return false;
	else return true;
}
</script>
<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
<?php wp_head(); ?>
</head>



<body> 