var ajaxBinded = false;

var addComment={moveForm:function(a,b,c,d){var e,f=this,g=f.I(a),h=f.I(c),i=f.I("cancel-comment-reply-link"),j=f.I("comment_parent"),k=f.I("comment_post_ID");if(g&&h&&i&&j){f.respondId=c,d=d||!1,f.I("wp-temp-form-div")||(e=document.createElement("div"),e.id="wp-temp-form-div",e.style.display="none",h.parentNode.insertBefore(e,h)),g.parentNode.insertBefore(h,g.nextSibling),k&&d&&(k.value=d),j.value=b,i.style.display="",i.onclick=function(){var a=addComment,b=a.I("wp-temp-form-div"),c=a.I(a.respondId);if(b&&c)return a.I("comment_parent").value="0",b.parentNode.insertBefore(c,b),b.parentNode.removeChild(b),this.style.display="none",this.onclick=null,!1};try{f.I("comment").focus()}catch(l){}return!1}},I:function(a){return document.getElementById(a)}};

function dispatch() {
    var q = $("#gurl");
    if (q.value != "") {
        var url = 'http://www.google.com/search?q=site:' + pure.gurl + '%20' + q.value;
        if (navigator.userAgent.indexOf('iPad') > -1 || navigator.userAgent.indexOf('iPhone') > -1 || navigator.userAgent.indexOf('iPhone') > -1) {
            location.href = url;
        } else {
            window.open(url, "_blank");
        }
        return false;
    } else {
        return false;
    }
}

jQuery(document).ready(function() {
if($('#cssload').length > 0){
$("#cssload").fadeOut("1000");
}

if($('.bdsharebuttonbox').length > 0){
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
}

$('#wysafe a').each(function(i) {
		if (this.title) {var imgTitle = this.title;
			var x = 30;
			var y = 30;
			$(this).mouseover(function(e) {
				this.title = '';
				$('body').append('<div id="tooltip">' + imgTitle + '</div>');
				$('#tooltip').css({
					'left': (e.pageX) + 'px',
					'top': (e.pageY + y) + 'px'
				}).fadeIn(500)
			}).mouseout(function() {
				this.title = imgTitle;
				$('#tooltip').remove()
			}).mousemove(function(e) {
				$('#tooltip').css({
					'left': (e.pageX) + 'px',
					'top': (e.pageY + y) + 'px'
				})
			})
		}
});

$("img").lazyload({effect:"fadeIn"});

if($('.post-share').length > 0){
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
}

if($('.pure_widget_tabber').length > 0){
$('#tab-title span').click(function(){
  $(this).addClass("selected").siblings().removeClass();
  $("#tab-content > ul").slideUp('1500').eq($('#tab-title span').index(this)).slideDown('1500');
});
}

$(function(){$(".navbar ul li").hover(function(){$(this).children("ul").show();$(this).addClass("li01")},function(){$(this).children("ul").hide();$(this).removeClass("li01")})

if($('.cms-taber').length >0){
$('.cms-taber-title div').click(function(){
  $(this).addClass("selected").siblings().removeClass();
  $(".cms-taber-ul > ul").slideUp('1500').eq($('.cms-taber-title div').index(this)).slideDown('1500');
})
}	

$(document).on("click", "#show-more",
function() {
    if ($(this).hasClass('is-loading')) {
        return false;
    }
     else {
        var paged = $(this).data("paged"),
        total = $(this).data("total"),
        category = $(this).data("cate"),
        tag = $(this).data("tag"),
        search = $(this).data("search"),
        author = $(this).data("author");
        var ajax_data = {
            action: "ajax_index_post",
            paged: paged,
            total: total,
            category:category,
            author:author,
            tag:tag,
            search:search
        };
        $(this).html('AJAX Loading').addClass('is-loading')
         $.post(pure.ajaxurl, ajax_data,
        function(data) {
            $('#show-more').remove();
            $(".listbox").append(data);
            $("img").lazyload({effect:"fadeIn"});
        });
        return false;
    }
});

if($('.listbox').length > 0){
$(".article-tags").hover(function(){$(this).addClass("active")},function(){$(this).removeClass("active")});
}
	
if($('.listbox').length > 0){   
var $sidebar=$("#stick"),$window=$(window),offset=$sidebar.offset(),topPadding=80;$window.scroll(function(){if($window.scrollTop()>offset.top){$sidebar.stop().animate({marginTop:$window.scrollTop()-offset.top+topPadding})}else{$sidebar.stop().animate({marginTop:0})}});   
}  

if($('.flexslider').length > 0){
$('.flexslider').flexslider({selector:".gallery > li",animation:'slide',controlNav:false,directionNav:true,slideshow:true,slideshowSpeed:4000,animationSpeed:300,smoothHeight:true,prevText:"&larr;",nextText:"&rarr;",});
}

$.fn.postLike=function(){if($(this).hasClass('done')){return false}else{$(this).addClass('done');var id=$(this).data("id"),action=$(this).data('action'),rateHolder=$(this).children('.count');var ajax_data={action:"pure_zancallback",um_id:id,um_action:action};$.post(pure.ajaxurl,ajax_data,function(data){$(rateHolder).html(data)});return false}};$(document).on("click",".favorite",function(){$(this).postLike()});

$(document).on("click", ".rating-combo .rating-toggle",
function(e) {
	e.preventDefault();
	if ($(this).parent().hasClass('combo-open'))
	 {
		$(this).parent().removeClass('combo-open')
		 $(this).next().hide();
	}
	 else
	 {
		$(this).parent().addClass('combo-open')
		 $(this).next().show();
	}
	return false;
});
$(document).on("click", ".rating-combo ul li a",
function() {
	var score = $(this).data("rating");
	var id = $(this).parent().parent().parent().data("post-id");
	var rateHolder = $(this).parent().parent().parent().parent();
	var history = rateHolder.html();
	var ajax_data = {
		action: "pure_rate",
		um_id: id,
		um_score: score
	};
	$(rateHolder).html('loading..');
	$.ajax({
			url: pure.ajaxurl,
			type: "POST",
			data: ajax_data,
			dataType: "json",
			success: function(data) {
				if (data.status == 200) {

					var item = new Object();
					item = data.data;
						$(rateHolder).html('<div class="post-rate"><span class="rating-stars" title="评分 ' + item.average + ', 满分 5 星" style="width:' + item.percent + '%"></span></div><div class="piao">' + item.raters + ' 票</div>');
					
					
				} else {
					$(rateHolder).html(history);
					console.log(data.status);
				}
			}
		});

	return false;
});

var is_rtl = ($('html').attr('dir') == 'rtl' ? true : false);

if($('.carousel').length>0){$('.carousel').flexslider({animation:'slide',animationLoop:false,itemWidth:214,itemMargin:30,minItems:3,maxItems:4,controlNav:false,slideshow:false,rtl:is_rtl});$(".flex-direction-nav li a").attr("target","_blank")}
			
$(".snnav ul li").hover(function(){$(this).children("ul").show();$(this).addClass("li01")},function(){$(this).children("ul").hide();$(this).removeClass("li01")})

$(".menu-button").click(function(){$("#mobinav").toggleClass("openall");$(".menu-button").toggleClass("active")});

var e=$("#rocket-to-top"),t=$(document).scrollTop(),n,r,i=!0;$(window).scroll(function(){var t=$(document).scrollTop();t==0?e.css("background-position")=="0px 0px"?e.fadeOut("slow"):i&&(i=!1,$(".level-2").css("opacity",1),e.delay(100).animate({marginTop:"-1000px"},"normal",function(){e.css({"margin-top":"-125px",display:"none"}),i=!0})):e.fadeIn("slow")}),e.hover(function(){$(".level-2").stop(!0).animate({opacity:1})},function(){$(".level-2").stop(!0).animate({opacity:0})}),$(".level-3").click(function(){function t(){var t=e.css("background-position");if(e.css("display")=="none"||i==0){clearInterval(n),e.css("background-position","0px 0px");return}switch(t){case"0px 0px":e.css("background-position","-298px 0px");break;case"-298px 0px":e.css("background-position","-447px 0px");break;case"-447px 0px":e.css("background-position","-596px 0px");break;case"-596px 0px":e.css("background-position","-745px 0px");break;case"-745px 0px":e.css("background-position","-298px 0px")}}if(!i)return;n=setInterval(t,50),$("html,body").animate({scrollTop:0},"slow")});

});

if($('#fbshow').length>0){$('#fbshow').click(function(){$('.fball').toggle(1000)})}

$('#avanow').click(function(){$('#avatar-menu').toggle(1000)})

if($('#page-archives').length > 0){
var old_top=$("#page-archives").offset().top,_year=parseInt($(".year:first").attr("id").replace("year-",""));$(".year:first, .year .month:first").addClass("selected");$(".month.monthed").click(function(){var _this=$(this),_id="#"+_this.attr("id").replace("mont","arti");if(!_this.hasClass("selected")){var _stop=$(_id).offset().top-10,_selected=$(".month.monthed.selected");_selected.removeClass("selected");_this.addClass("selected");$("body, html").scrollTop(_stop)}});$(".year-toogle").click(function(e){e.preventDefault();var _this=$(this),_thisp=_this.parent();if(!_thisp.hasClass("selected")){var _selected=$(".year.selected"),_month=_thisp.children("ul").children("li").eq(0);_selected.removeClass("selected");_thisp.addClass("selected");_month.click()}});$(window).scroll(function(){var _this=$(this),_top=_this.scrollTop();if(_top>=old_top+10){$(".archive-nav").css({top:10})}else{$(".archive-nav").css({top:old_top+10-_top})}$(".archive-title").each(function(){var _this=$(this),_ooid=_this.attr("id"),_newyear=parseInt(_ooid.replace(/arti-(\d*)-\d*/,"$1")),_offtop=_this.offset().top-40,_oph=_offtop+_this.height();if(_top>=_offtop&&_top<_oph){if(_newyear!=_year){$("#year-"+_year).removeClass("selected");$("#year-"+_newyear).addClass("selected");_year=_newyear}var _id=_id="#"+_ooid.replace("arti","mont"),_selected=$(".month.monthed.selected");_selected.removeClass("selected");$(_id).addClass("selected")}})});
}

if($('#comments').length > 0 ){

$(function() {
function e(e){
var t=$("a",p)
g = isNaN(e) ? v - 1 > g ? g + 1 : 0 : e, t.clone().addClass("temp").appendTo(p).fadeOut(function() {
	$(this).remove()
})
}
function t() {
	M > 0 ? (N.val("发表成功(" + M--+")"), setTimeout(t, 1e3)) : (N.val("发表评论").prop("disabled", !1), M = 15)
}
function n(e) {
	e && (j = e, o.stop().animate({
		scrollTop: j.offset().top - 85
	}, 500))
}
var i = $("html"),
	a = $(window),
	s = $(document),
	o = $("html, body"),
	l = $("#s")
	var b = $("#comments")
b.on("click", ".loadmore", function() {
	var e = $(this)
	return e.hasClass("loading") ? !1 : (e.attr("title", "正在加载…").addClass("loading"), $.get(e.attr("href"), function(t) {
		e.parent().remove(), b.append($(t).find(".commentlist").addClass("fadein").find("img.lazy").lazyload({
			effect: "fadeIn"
		}).end()).append($(t).find(".navigation"))
	}), !1)
})
var x = $("#commentform"),
	T = $("#comment"),
	I = $("#comments-title"),
	L = $("#comment-settings"),
	E = $(".comment-settings-toggle"),
	S = $("span", E),
	q = $("#author"),
	N = $("#submit")
	E.click(function() {
	L.hasClass("show") || (L.addClass("show"), $(this).removeClass("required"), q.focus(), setTimeout(function() {
		s.on("click.comment", function(e) {
			L.find(e.target).length || e.target == L[0] || (L.removeClass("show"), s.off("click.comment"))
		})
	}, 100))
}),
	q.on("change input", function() {
	S.text($(this).val())
}), T.keydown(function(e) {
	if (e.ctrlKey && 13 == e.keyCode) x.trigger("submit")
	else if (9 == e.keyCode) return E.click(), !1
}), $(".comments-link").click(T.focus), $("#respond input").add(T).on("invalid", function() {
	$(this).one("input change", function() {
		$(this).parent().removeClass("invalid")
	}).parent().addClass("invalid"), $(this)[0] != T[0] && E.click()
}), $(".commentlist").eq(0).children().length < 10 && $("#comments .loadmore").length && $("#comments .loadmore").trigger("click")
	var z, _, M = 15
x.submit(function() {
	return $.ajax({
		type: $(this).attr("method"),
		url: pure.ajaxurl,
		data: $(this).serialize() + "&action=pure_ajax_comment",
		beforeSend: function() {
			_ = $("#comment_parent").val(), N.val("正在提交.").prop("disabled", !0), T.prop("disabled", !0), z = window.setInterval(function() {
				N.val("正在提交..." == N.val() ? "正在提交." : N.val() + ".")
			}, 700)
		},
		success: function(e) {
			window.clearInterval(z), /<\/li>/.test(e) ? ($(".commentlist").length > 0 ? ("0" == _ ? $("<div style='display:none'>" + e + "</div>").prependTo($(".commentlist").eq(0)).fadeIn() : $("<ol class='children' style='display:none'>" + e + "</ol>").insertAfter($("#comment-" + _)).fadeIn(), I.text(parseInt(I.text().match(/\d/g).join("")) + 1 + " 条评论")) : ($(".no-comments").replaceWith($("<ol class='commentlist' style='display:none'>" + e + "</ol>").fadeIn()), I.text("1 条评论")), T.prop("disabled", !1).val(""), t()) : (alert($("<div>" + e + "</div>").text()), N.prop("disabled", !1).val("发表评论"), T.prop("disabled", !1))
		},
		error: function() {
			window.clearInterval(z), alert("遇到点小问题，请重新提交评论。"), N.prop("disabled", !1).val("发表评论"), T.prop("disabled", !1)
		}
	}), !1
})
})

var myDate=new Date();var mytime=myDate.toLocaleTimeString();var myField;$("#btn_sign").click(function(){if(document.getElementById('comment')&&document.getElementById('comment').type=='textarea'){myField=document.getElementById('comment')}else{return false}myField.value+='<blockquote>签到成功！签到时间:'+mytime+'每日打卡，生活更精彩哦~</blockquote>'});

$("#wp-smiles").click(function(){$("#smiliepad").toggle('2000')});

$(document).on("click",".add-smily",function(){var myField;tag=' '+$(this).data("smilies")+' ';if(document.getElementById('comment')&&document.getElementById('comment').type=='textarea'){myField=document.getElementById('comment')}else{return false}if(document.selection){myField.focus();sel=document.selection.createRange();sel.text=tag;myField.focus()}else if(myField.selectionStart||myField.selectionStart=='0'){var startPos=myField.selectionStart;var endPos=myField.selectionEnd;var cursorPos=endPos;myField.value=myField.value.substring(0,startPos)+tag+myField.value.substring(endPos,myField.value.length);cursorPos+=tag.length;myField.focus();myField.selectionStart=cursorPos;myField.selectionEnd=cursorPos}else{myField.value+=tag;myField.focus()}return false});
}
});

if("console" in window){var c=console,s="font:2em/2 'Helvetica Neue',Helvetica,'Lucida Grande',Arial,'Hiragino Sans GB','Microsoft YaHei'";c.log("%c","background:url('http://www.wysafe.com/wp-content/uploads/2015/02/23.jpg');padding-right:600px;font-size:95px;font-family:sans-serif");c.log("%c原创 WordPress 主题 PureViper 限时特价……",s);c.log("%c✓HTML5 ✓响应式设计 ✓CMS风格 ✓用户中心 ✓AJAX  ✓风格各异 ✓更多特性",s+";font-size:1.3em");c.log("%c了解详情：http://www.wysafe.com/2015/0121/4030.html","color:#0086e3;font-size:1.2em;line-height:1.6")}