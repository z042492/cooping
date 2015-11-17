$(document).ready(function(){   
$('ul.out li').hover(function(){   
$(this).find('ul:first').slideDown(300);//显示二级菜单，括号中的数字表示下拉菜单完全显示出来需要200毫秒。   
$(this).addClass("hover");   
},function(){   
$(this).find('ul').css('display','none');   
$(this).removeClass("hover");   
});   
function hide_submenu(){   
$('ul.out li').find('ul').css('display','none');   
}   
$('ul.out li li:has(ul)').find("a:first").append(" &raquo; ");   
document.onclick = hide_submenu;   
});  