<?php

echo "<!DOCTYPE html>\r\n<html ";
language_attributes();
echo " class=\"pc\">\r\n<head>\r\n<meta charset=\"UTF-8\" />\r\n<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"/>\r\n<meta name = \"viewport\" content =\"initial-scale=1.0,user-scalable=no\">";
pure_seotdk();
pure_webapp();
wp_head();

if (is_home()) {
	echo "<link rel=\"canonical\" href=\"";
	echo bloginfo("url");
	echo "\" />";
}

if (wysafe("pure_track_b")) {
	echo wysafe("pure_track");
	echo "\n";
}

echo "\r\n<body>";

if (wysafe("pure_css3load_b")) {
	echo "<div id=\"cssload\">\r\n\t\t<div class=\"loader1\">\r\n\t        \t<i></i><i></i>\r\n\t    </div>\r\n\t</div>";
}

echo "<div id=\"wysafe\">\r\n\t<div id=\"topnav\">\r\n\t\t<div id=\"navcontent\">\r\n\t\t\t<div id=\"navlogo\">";

if (wysafe("pure_logo_b")) {
	echo "<a class=\"shake\" href=\"";
	echo bloginfo("url");
	echo "/\" title=\"\"><img src=\"";
	echo wysafe("pure_logo");
	echo "\" width=\"150px\" height=\"50px\" alt=\"";
	echo bloginfo("url");
	echo "\" /></a>";
}
else {
	echo "<a class=\"shake\" href=\"";
	echo bloginfo("url");
	echo "/\" title=\"\"><img src=\"";
	echo THEME_URI;
	echo "/images/logo.png\" width=\"150px\" height=\"50px\" alt=\"";
	echo bloginfo("url");
	echo "\"  /></a>";
}

echo "</div>\r\n\t\t\t<div class=\"navbar\">\r\n\t\t\t\t<div class=\"menu-button\"><i class=\"menu-ico\"></i></div>\r\n\t\t\t\t<ul id=\"menu-all-pages\" class=\"menu\">";
pure_topmenu();
echo "</ul>\r\n\t\t\t</div>\r\n\t\t\t<div class=\"navct\">\r\n\t\t\t\t<div class=\"navuser\">";

if (is_user_logged_in()) {
	echo "<a rel=\"nofollow\" class=\"btn btn-primary btn-sm\" id=\"navbar_signnow\" href=\"";
	echo wysafe("pure_usermangerurl");
	echo "\"><i class=\"fa fa-gears\"></i>管理</a>\r\n\t \t\t\t\t<a rel=\"nofollow\" class=\"btn btn-default btn-sm\" id=\"navbar_signout\" href=\"";
	echo wp_logout_url(selfURL());
	echo "\"><i class=\"fa fa-power-off\"></i>注销</a>";
}
else if (wysafe("pure_user_center_b")) {
	echo "<a rel=\"nofollow\" class=\"btn btn-primary btn-sm\" id=\"navbar_signup\" href=\"";
	echo wysafe("pure_userregurl");
	echo "\"><i class=\"fa fa-edit\"></i>注册</a>\r\n\t \t\t\t\t<a rel=\"nofollow\" class=\"btn btn-default btn-sm\" id=\"navbar_signin\" href=\"";
	echo wysafe("pure_userloginurl");
	echo "\"><i class=\"fa fa-user\"></i>登录</a>";
}
else {
	echo "<style>.navct {width: 165px;}</style>";
}

echo "</div><div class=\"navsearch\">";

if (wysafe("pure_zhannei_b")) {
	echo "<form method=\"get\" action=\"";
	echo wysafe("pure_zhannei_url");
	echo "\" class=\"search-form\">\r\n\t\t\t\t\t\t\t<input type=\"hidden\" name=\"s\" value=\"";
	echo wysafe("pure_zhannei");
	echo "\"> \r\n\t\t\t\t\t\t\t<input type=\"hidden\" name=\"entry\" value=\"1\">\t\t\t\t    \t\r\n\t\t\t\t\t\t\t<input class=\"search_input\" type=\"text\" value=\"输入内容搜索\" name=\"q\" onfocus=\"if (this.value == '输入内容搜索') this.value ='';\" onblur=\"if (this.value == '') this.value = '输入内容搜索';\">\r\n\t\t\t\t\t\t\t<button class=\"search_button\" type=\"submit\"><i class=\"fa fa-search\"></i></button>\r\n\t\t\t\t\t</form>";
}
else {
	echo "<form method=\"get\" action=\"";
	echo bloginfo("url");
	echo "/index.php\" class=\"search-form\">\r\n\t\t\t\t\t\t\t<input class=\"search_input\" type=\"text\" value=\"输入内容搜索\" name=\"s\" onfocus=\"if (this.value == '输入内容搜索') this.value =  '';\" onblur=\"if (this.value ==  '') this.value = '输入内容搜索';\">\r\n\t\t\t\t\t\t\t<button class=\"search_button\" type=\"submit\"><i class=\"fa fa-search\"></i></button>\r\n\t\t\t\t\t</form>";
}

echo "</div>\r\n\t\t\t</div>\r\n\t\t</div>\r\n\t\t<div id=\"mobinav\">\r\n\t\t\t<div class=\"mobi-scroller\">\r\n\t\t\t<ul class=\"mobi-menu\">";
pure_mobimenu();
echo "</ul>\r\n\t\t</div>\r\n\t\t</div>\r\n\t</div>\r\n\t<div id=\"secnav\">\r\n\t\t<div id=\"seccontent\">\r\n\t\t<div id=\"snavatar\">";

if (wysafe("pure_myavatar_b")) {
	echo "<a href=\"#\" title=\"查看全站导航\" id=\"avanow\"><img class=\"avatar\" src=\"";
	echo wysafe("pure_myavatar");
	echo "\" width=\"100px\" height=\"100px\" /></a>";
}
else {
	echo "<a href=\"#\" title=\"查看全站导航\" id=\"avanow\"><img class=\"avatar\" src=\"";
	echo THEME_URI;
	echo "/images/avatar.gif\" width=\"100px\" height=\"100px\" /></a>";
}

echo "<div id=\"avatar-menu\">\r\n\t\t\t\t\t\t\t<div class=\"avatarm-content\">\r\n\t\t\t\t\t\t\t\t<div class=\"avatarm-title\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"avatarm-text\">随机推荐</span>\r\n\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t<div class=\"avatarm-tuijian\">\r\n\t\t\t\t\t\t\t\t\t<ul class=\"tuijian-ul\">";
pure_home_postlists("rand", "5", "");
echo "</ul>\r\n\t\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t\t<div class=\"avatarm-title\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"avatarm-text\">所有分类</span>\r\n\t\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t\t<ul class=\"avatarm-categories\">";
$limit = "9";
$categories = get_categories();

foreach ($categories as $val ) {
	echo "<li><a href=\"" . get_category_link($val->cat_ID) . "\">" . $val->cat_name . "</a></li>";
}

echo "</ul>\r\n\t\t\t\t\t\t\t\t<div class=\"avatarm-title\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"avatarm-text\">热门标签</span>\r\n\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t<div class=\"avatarm-tags\">";
wp_tag_cloud(array("unit" => "px", "smallest" => 6, "largest" => 9, "number" => $limit, "format" => "flat", "orderby" => "count", "order" => "DESC"));
echo "</div>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t</div>\t\t\t\t  \t\t  \r\n\t\t</div>\r\n\t\t<div class=\"snbar\">\r\n\t\t\t<div class=\"snnav\">\r\n\t\t\t\t<ul class=\"menu\">";
pure_secmenu();
echo "</ul>\r\n\t\t\t</div>\r\n\t\t\t<div class=\"snsecbar\">\r\n\t\t\t\t<div class=\"sninfo\">\r\n\t\t\t\t\t<p>\r\n\t\t\t\t\t\t<i class=\"fa fa-bell\"></i>";

if (wysafe("pure_tongzhi_b")) {
	echo wysafe("pure_tongzhi");
}
else {
	echo "欢迎来到我的博客做客,如果你想和我交流,可以给我留言哦!";
}

update_today();
echo "</p></div><div class=\"snsns\">";

if (wysafe("pure_weibo_b")) {
	echo "<a class=\"snsbtn weibobtn shake\" href=\"" . wysafe("pure_weibo") . "\"></a>";
}

if (wysafe("pure_qzone_b")) {
	echo "<a class=\"snsbtn qzonebtn shake\" href=\"" . wysafe("pure_qzone") . "\"></a>";
}

if (wysafe("pure_qq_b")) {
	echo "<a class=\"snsbtn qqbtn shake\" href=\"" . wysafe("pure_qq") . "\"></a>";
}

if (wysafe("pure_baidu_b")) {
	echo "<a class=\"snsbtn baidubtn shake\" href=\"" . wysafe("pure_baidu") . "\"></a>";
}

if (wysafe("pure_douban_b")) {
	echo "<a class=\"snsbtn doubanbtn shake\" href=\"" . wysafe("pure_douban") . "\"></a>";
}

if (wysafe("pure_rss_b")) {
	echo "<a class=\"snsbtn rssbtn shake\" href=\"" . wysafe("pure_rss") . "\"></a>";
}

echo "</div>\r\n\t\t\t</div>\r\n\t\t</div>\r\n\t\t<div class=\"clear\"></div>\r\n\t</div>\r\n</div>";

?>
