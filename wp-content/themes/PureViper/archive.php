<?php

get_header();
echo "<div id=\"container\">";
get_template_part("loop", "fastbox");
echo "<div id=\"contentbox\">";
echo "\r\n<div class=\"pageheader\">\r\n\t<div class=\"container\">\r\n        <div class=\"share bdsharebuttonbox\">\r\n                        <a href=\"#\" class=\"bds_weixin\" data-cmd=\"weixin\" title=\"分享到微信\"></a>\r\n                        <a href=\"#\" class=\"bds_sqq\" data-cmd=\"sqq\" title=\"分享到QQ好友\"></a>\r\n                        <a href=\"#\" class=\"bds_qzone\" data-cmd=\"qzone\" title=\"分享到QQ空间\"></a>\r\n                        <a href=\"#\" class=\"bds_tsina\" data-cmd=\"tsina\" title=\"分享到新浪微博\"></a>\r\n                        <a href=\"#\" class=\"bds_renren\" data-cmd=\"renren\" title=\"分享到人人网\"></a>\r\n                        <a href=\"#\" class=\"bds_douban\" data-cmd=\"douban\" title=\"分享到豆瓣网\"></a>\r\n                        <a href=\"#\" class=\"bds_fbook\" data-cmd=\"fbook\" title=\"分享到Facebook\"></a>\r\n        </div>\r\n\t  \t<h1>";
single_cat_title();
echo "</h1>\r\n\t  \t<div class=\"note\">" . category_description() . "</div>\r\n\t</div>\r\n</div>";
echo "<div id=\"content\">";
echo "<div class=\"listbox\">";
get_template_part("loop", "content");
echo "</div>";
echo "</div>";
echo "<div id=\"aside\">";
get_sidebar();
echo "</div></div></div>";
get_footer();

?>
