
function share(id) {
	if ( isNaN(id) || id <= 0 ) return false;
	var post = $("#article_"+id);
	var img = post.find(".content img:first").attr('src');
	var _pic = encodeURIComponent(img);
	var desc = post.find('.content').clone();	//对副本进行处理
	desc.find("*").each(function(){
		var part = $(this).text();
		$(this).replaceWith(part+' ');	//去掉所有的html标签 用空格隔开
	});
	var _t = encodeURI(desc.html());
	var url = post.find('.content .link').attr('href');

	$("#shareMenu .shareto_sina, #shareMenu2 .shareto_sina").attr({'href': "http://service.weibo.com/share/share.php?title="+_t+"&url="+url+"&source=bookmark&pic="+_pic});
	$("#shareMenu .shareto_tencent, #shareMenu2 .shareto_tencent").attr({'href': 'http://v.t.qq.com/share/share.php?title='+_t+'&pic='+_pic+'&url='+url});
	$("#shareMenu .shareto_renren, #shareMenu2 .shareto_renren").attr({'href': "http://widget.renren.com/dialog/share?resourceUrl="+url+"&title=&pic="+_pic+"&description="+_t});
}

function mode(s) {
	if (s != 'new' && s != 'hot' && s != 'top' && s != 'video' && s !== 0) return null;
	setCookie('page_mode', s, 7*24*3600);
}


function jumpPage(selObj,restore){
	window.location.href= selObj.options[selObj.selectedIndex].value;
	if (restore) selObj.selectedIndex = 0;
} 

function getCookie( name ) {
	var start = document.cookie.indexOf( name + "=" );
	var len = start + name.length + 1;

	if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) ) return null;
	if ( start == -1 ) return null;

	var end = document.cookie.indexOf( ';', len );
	if ( end == -1 ) end = document.cookie.length;
	return unescape( document.cookie.substring( len, end ) );
}
function setCookie(name, value, keeptime) {
	var expires = parseInt(keeptime);
	expires = (expires > 0) ? (expires * 1000) : -10000;
	var date = new Date();
	date.setTime(date.getTime() + expires);
	document.cookie = name + '=' + value + ';expires=' + date.toGMTString() + ';path=/';
}
function isCookieEnable() {
	setCookie('blueria_cookie_test','test',60);
	var cookieEnable = (getCookie('blueria_cookie_test') == 'test') ?  true : false;
	setCookie('blueria_cookie_test','',-1);	//删除cookie
	return cookieEnable;
}



var shoujian = false;	//防止重复点击
function vote(post_id, doit, btn) {
	if ( isNaN(post_id) ) return;
	if ( !isCookieEnable() ) return;
	if ( getCookie( "blueria_vote_" + post_id ) != null ) return;	//已经投过票了
	if ( shoujian === true ) return;	//数据没写进去

	if (doit === 1) {
		doit = 'up';
	} else if (doit === -1) {
		doit = 'down';
	} else return;

	shoujian = true;
	var vote = $(btn);
	$.post(ajaxurl, {'action':'blueria_vote', 'post_ID':post_id, 'doit':doit}, function(result, stat) {
		if ( 'success' != stat ) return false;
		if ( 0 == result ) return false;
		if (result == -1) {alert('非法操作!!!');return false;}

		var val = parseInt(vote.html());
		if (doit == 'up') vote.html(val + 1);
		if (doit == 'down') vote.html(val - 1);
		vote.parent().addClass("voted");
		shoujian = false;
	});
}

function pps_player(key) {
	document.write('<script type="text/javascript" async="false" src="http://active.v.pps.tv/ugc/ajax/aj_html5_url.php?url_key='+key+'&callback=pps_cb"></script>');
}
function pps_cb(result) {
	src = result[0].path;
	$("video").attr('src', src);
}

function qq_player(key) {
	document.write('<script type="text/javascript" async="false" src="http://vv.video.qq.com/geturl?otype=json&vid='+key+'&charge=0&callback=qq_cb"></script>');
}
function qq_cb(result) {
	src = result.vd.vi[0].url;
	$("video").attr('src', src);
}

function pptv_player(key) {
	document.write('<script type="text/javascript" async="false" src="http://web-play.pptv.com/webplay3-0-'+key+'.xml?version=4&type=m3u8.web.pad&cb=pptv_cb"></script>');
}
function pptv_cb(Z) {
	var ab, ae, ac, ad;
	console.log(Z);
	for (var aa in Z.childNodes) {
		var W = Z.childNodes[aa];
		if (W.tagName === "channel") {
			for (var Y in W.childNodes) {
				var V = W.childNodes[Y];
				if (V.tagName === "file" || V.tagName === "stream") {
					var ag = (V.tagName === "file") ? V.cur : V.cft;
					for (var X in V.childNodes) {
						var af = V.childNodes[X];
						if (af.ft === ag) {ab = ag; ae = af.rid; break;}
					}
				}
				if (ab) break;
			}
		} else {
			if (W.tagName === "dt" && W.ft == ab) {
				for (var Y in W.childNodes) {
					var l = W.childNodes[Y];
					if (l.tagName === "sh") ac = l.childNodes[0];
					else if (l.tagName === "key") ad = l.childNodes[0];
				}
			}
		}
	}
	if (ab != undefined && ae && ac) {
		var m3u8;
		ae = ae.replace(".mp4","");
		if (ad) {
			m3u8 = "http://"+ac+"/"+ae+".m3u8?type=m3u8.web.pad&k="+ad;
		} else {
			m3u8 = "http://"+ac+"/"+ae+".m3u8?type=m3u8.web.pad";
		}
		$("video").attr('src', m3u8);
	}
}