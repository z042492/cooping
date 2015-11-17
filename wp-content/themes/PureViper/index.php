<?php

get_header();
echo "<div id=\"container\">";
get_template_part("loop", "fastbox");
echo "<div id=\"contentbox\" class=\"home\">";
echo "<div id=\"content\">";
if (is_home() && !is_paged()) {
	echo "<div class=\"homecmsbox wysafetop\">";

	if (is_dynamic_sidebar()) {
		dynamic_sidebar("首页CMS-上部");
	}

	echo "<div class=\"clearfix\"></div></div><div class=\"clearfix\"></div>";
}

echo "<div class=\"clearfix\"></div>";
echo "<div class=\"listbox\">";
get_template_part("loop", "content");
echo "</div>";
if (is_home() && !is_paged()) {
	echo "<div class=\"homecmsbox wysafebottom\">";

	if (is_dynamic_sidebar()) {
		dynamic_sidebar("首页CMS-下部");
	}

	echo "<div class=\"clearfix\"></div></div><div class=\"clearfix\"></div>";
}

echo "</div>";
echo "<div id=\"aside\">";
get_sidebar();
echo "</div></div></div>";
get_footer();

?>
