<?php

echo "<article class=\"article\">\r\n          <div class=\"article-main\">\r\n            <div class=\"article-thumb\">\r\n                 <a href=\"";
echo the_permalink();
echo "\" title=\"";
echo the_title();
echo "\">";
pure_thumbnail(220, 150, 1);
echo "</a>\r\n            </div>\r\n            \r\n            <div class=\"article-bd\">\r\n            <header class=\"article-hd\">\r\n              <div class=\"article-title\">\r\n                <h2><a href=\"";
echo the_permalink();
echo "\" title=\"";
echo the_title();
echo "\">";
echo the_title();
echo "</a></h2>\r\n              </div>\r\n              <div class=\"article-actions\">\r\n              </div>\r\n            </header> \r\n              <div class=\"article-meta\">\r\n                <span><i class=\"fa fa-user\"></i>";
echo get_the_author();
echo "</span> \r\n                <span><i class=\"fa fa-list-alt\"></i>";
the_category(" | ");
echo "</span><span><i class=\"fa fa-clock-o\"></i>";
echo get_the_time("Y-m-d");
echo "</span><span><i class=\"fa fa-eye\"></i>";
get_post_views(get_the_ID());
echo "</span>                \r\n              </div>               \r\n            <div class=\"article-p\">";
echo pure_strimwidth(strip_tags(apply_filters("the_content", $post->post_content)), 0, 180, "...");
echo "</div>\r\n            <div class=\"article-tags\">";

if (get_the_tags()) {
	the_tags("", "", "");
}
else {
	echo "<a>博文</a>";
}

echo "<span><i class=\"fa fa-tags\"></i></span></div>           \r\n            </div>\r\n           </div>               \t\t    \t\t\r\n</article>";

?>
