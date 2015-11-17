<?php

get_header();
echo "<div id=\"container\">";
get_template_part("loop", "fastbox");
echo "<div id=\"contentbox\">";
echo "<div id=\"content\" class=\"content-page\">\r\n          <div id=\"page\" class=\"postbox\">";

if (have_posts()) {
	while (have_posts()) {
		the_post();
		echo "<div id=\"post-header\">\r\n                    <ol class=\"post-crumb\" itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\">\r\n                        <li><i class=\"fa fa-home\"></i>\r\n                            <a href=\"";
		echo get_option("home");
		echo "/\">首页</a></li>\r\n                        <li class=\"active\"><a href=\"";
		echo the_permalink();
		echo "\" rel=\"bookmark\" itemprop=\"url\">本页</a></li>\r\n                    </ol>\r\n                    <h2 id=\"post-title\">";
		echo the_title();
		echo "</h2>";
		echo "<div id=\"content_adsense_area\">";

		if (wysafe("pure_ads_arttb_b")) {
			echo wysafe("pure_ads_arttb");
		}

		echo "</div></div>";
		the_content();
		echo "<div class=\"clear\"></div><div id=\"content_adsense_area_2\">";

		if (wysafe("pure_ads_artrb_b")) {
			echo wysafe("pure_ads_artrb");
		}

		echo "</div>";
	}
}

echo "</div></div>";
echo "<div id=\"aside\">";
echo "<ul id=\"pagemenu\">";
pure_usermenu();
echo "</ul>";
echo "</div></div></div>";
get_footer();

?>
