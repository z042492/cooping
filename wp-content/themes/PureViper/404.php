<?php

get_header();
echo "<div id=\"container\">";
get_template_part("loop", "fastbox");
echo "<div id=\"contentbox\">";
echo "<div id=\"content\" class=\"nofound\">\t\r\n\t\t\t<div id=\"notfound\">\t\t\t\r\n\t\t\t\t<h1>Error 404!看看别的吧!</h1>\r\n\t\t\t\t<p><img src=\"";
echo bloginfo("template_directory");
echo "/images/404.jpg\"  /></p>\r\n\t\t\t\t<h2>别的也很精彩的</h2>";
query_posts(array("showposts" => 10));
echo "<ul>";

while (have_posts()) {
	the_post();
	echo "<li><a href=\"";
	echo the_permalink();
	echo "\" title=\"";
	echo the_title();
	echo "\">";
	echo the_title();
	echo "</a></li>";
}

wp_reset_query();
echo "</div></div>";
echo "<div id=\"aside\">";
get_sidebar();
echo "</div></div></div>";
get_footer();

?>
