jQuery(document).ready(function($){
	var arrs = [
		'梦月酱。。。。。',                 
		'[fire]这里写内容[/fire]',         // 1
		'[remind]这里写内容[/remind]',
		'[task]这里写内容[/task]',
		'[buy]这里写内容[/buy]',
		'[love]这里写内容[/love]', 
		'[key]这里写内容[/key]',   // 6
		'[down]这里输入内容[/down]',
		'[warning]这里输入内容[/warning]',
		'[author]这里输入内容[/author]',
		'[text]这里输入内容[/text]',
		'[tutorial]这里写内容[/tutorial]',  
		'[project]这里写内容[/project]',
		'[error]这里写内容[/error]',
		'[question]这里写内容[/question]',
		'[blink]这里写内容[/blink]',
		'[codee]这里写内容[/codee]',   // 16
		'[Downlink href="http://www.xxx.com/xxx.zip"]download xxx.zip[/Downlink]',
		'[HrefNow href="http://www.xxx.com/xxx.zip"]打开XXXX网页[/HrefNow]',
		'[bilibili]填写B站的视频av号[/bilibili]',
		'[acfun]填写A站的视频av号[/acfun]' // 20
	];
	$('#ddm-button').click(function(e){
		e.preventDefault();
		$('#ddm-lay,#ddm-box').fadeIn();
		return false;
	});
	$('#ddm-close').click(function(e){
		e.preventDefault();
		$('#ddm-lay,#ddm-box').hide();
		return false;
	});
	$('#ddm-cate li a').click(function(e){
		e.preventDefault();
		if($(this).hasClass('current')) return false;
		var _this = $(this),
			_n = $('#ddm-cate li a').index(_this),
			_cateACurrrent = $('#ddm-cate li a.current'),
			_ddmCurrent = $('#ddm-ddm li.current'),
			_ddmNext = $('#ddm-ddm li').eq(_n);
		_cateACurrrent.removeClass('current');
		_ddmCurrent.removeClass('current');
		_this.addClass('current');
		_ddmNext.addClass('current');
		return false;
	});
	$('#ddm-ddm li a').click(function(e){
		e.preventDefault();
		var _this = $(this),
			_n = _this.attr('href'),
			_ddm = arrs[_n];
		if( $('#content').is(":visible") ){
			var _t = $('#content').val();
			send_to_editor(" " + _ddm + " ");
			//$('#content').val( _t + _ddm ).focus();
		}else{
			//var _ele = $('#content_ifr').contents().find("#tinymce"),
			//	_t = _ele.html();
			send_to_editor(" " + _ddm + " ");				
			//_ele.html(_t + _ddm).focus();
		}
		$('#ddm-close').click();
		return false;
	});
});