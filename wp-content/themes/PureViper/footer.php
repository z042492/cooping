<?php

echo "<div class=\"clear\"></div>\r\n<div style=\"display:none;\" id=\"rocket-to-top\">\r\n\t<div style=\"opacity:0;display:block;\" class=\"level-2\"></div>\r\n\t<div class=\"level-3\"></div>\r\n</div>";

if (wysafe("pure_footeravatar_b")) {
	pure_fooer_comment();
}

echo "<div id=\"footer\">\r\n\t<div class=\"copyright\">\r\n\t\t    &copy; ";
echo date("Y");
echo "<a href=\"" . bloginfo("url") . "\">" . bloginfo("name") . "</a> &nbsp; - Theme By ";
pureviper();
echo wysafe("pure_beian");
echo "</div>\r\n</div>";
pure_snow();
echo "<!--[if lt IE 9]> \r\n<script src=\"";
echo THEME_URI;
echo "/js/css3-mediaqueries.js\"></script>\r\n<script src=\"";
echo THEME_URI;
echo "/js/html5.js\"></script>\r\n<![endif]--> \r\n<!--[if lt IE 8]>\r\n<script src=\"";
echo THEME_URI;
echo "/js/IE8.js\" type=”text/javascript”></script>\r\n<![endif]--> \r\n<!--[if IE 7]>\r\n<script src=\"";
echo THEME_URI;
echo "/js/IE7.js\" type=”text/javascript”></script>\r\n<![endif]-->\r\n<script>pure = ";
echo json_encode(array("ajaxurl" => admin_url("admin-ajax.php"), "gurl" => ltrim(HOME_URI, "http://"), "turl" => THEME_URI, "cdn" => wysafe("pure_cdn"), "home" => wysafe("pure_cdnori")));
echo "</script>\r\n";

if (wysafe("pure_footcode_b")) {
	echo wysafe("pure_footcode");
}

wp_footer();
echo "</body></html>";

?>
