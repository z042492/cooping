<?php

get_header();
echo "<div id=\"container\">";
get_template_part("loop", "fastbox");
echo "<div id=\"contentbox\">";
echo "<div id=\"content\" class=\"content-page\">\r\n            <div id=\"page\" class=\"postbox\">";

if (have_posts()) {
	while (have_posts()) {
		the_post();
		echo "<div id=\"post-header\">\r\n                    <ol class=\"post-crumb\" itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\">\r\n                        <li><i class=\"fa fa-home\"></i>\r\n                            <a href=\"";
		echo get_option("home");
		echo "/\">首页</a></li>\r\n                        <li class=\"active\"><a href=\"";
		echo the_permalink();
		echo "\" rel=\"bookmark\" itemprop=\"url\">本页</a></li>\r\n                    </ol>\r\n                    <h2 id=\"post-title\">";
		echo the_title();
		echo "</h2>  \r\n                <div class=\"post-share\">\r\n                    <div class=\"bdsharebuttonbox\">\r\n                        <a href=\"#\" class=\"bds_weixin\" data-cmd=\"weixin\" title=\"分享到微信\"></a>\r\n                        <a href=\"#\" class=\"bds_sqq\" data-cmd=\"sqq\" title=\"分享到QQ好友\"></a>\r\n                        <a href=\"#\" class=\"bds_qzone\" data-cmd=\"qzone\" title=\"分享到QQ空间\"></a>\r\n                        <a href=\"#\" class=\"bds_tsina\" data-cmd=\"tsina\" title=\"分享到新浪微博\"></a>\r\n                        <a href=\"#\" class=\"bds_renren\" data-cmd=\"renren\" title=\"分享到人人网\"></a>\r\n                        <a href=\"#\" class=\"bds_douban\" data-cmd=\"douban\" title=\"分享到豆瓣网\"></a>\r\n                        <a href=\"#\" class=\"bds_fbook\" data-cmd=\"fbook\" title=\"分享到Facebook\"></a>\r\n                    </div>\r\n                </div>";
		echo "<div id=\"content_adsense_area\">";

		if (wysafe("pure_ads_arttb_b")) {
			echo wysafe("pure_ads_arttb");
		}

		echo "</div></div>";
		echo "<div id=\"post-content\">";
		the_content();
		wp_link_pages(array("before" => "<div class=\"fenye\">分页阅读：", "after" => "", "next_or_number" => "next", "previouspagelink" => "上一页", "nextpagelink" => ""));
		wp_link_pages(array("before" => "", "after" => "", "next_or_number" => "number", "link_before" => "<span>", "link_after" => "</span>"));
		wp_link_pages(array("before" => "", "after" => "</div>", "next_or_number" => "next", "previouspagelink" => "", "nextpagelink" => "下一页"));
		echo "</div><div class=\"clear\"></div><div id=\"content_adsense_area_2\">";

		if (wysafe("pure_ads_artrb_b")) {
			echo wysafe("pure_ads_artrb");
		}

		echo "</div><div class=\"commentbox\">";
		comments_template("", true);
		echo "</div>";
	}
}

echo "<div id=\"content_adsense_area_3\">";

if (wysafe("pure_ads_artcb_b")) {
	echo wysafe("pure_ads_artcb");
}

echo "</div></div></div>";
echo "<div id=\"aside\">";
get_sidebar();
echo "</div></div></div>";
get_footer();

?>
