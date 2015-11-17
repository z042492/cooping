<?php

if (wysafe("pure_fastbox_b")) {
	echo "<div id=\"fastbox\">\r\n<div class=\"fbquick\">\r\n<div id=\"fbshow\" class=\"fqbtn\">\r\n\t<a class=\"fq-show shake\" title=\"打开或关闭快速导航\" target=\"_blank\"></a>\r\n</div>\r\n<div class=\"fball\">";

	if (wysafe("pure_fastbox_cloud")) {
		echo "<div id=\"fbcloud\" class=\"fqbtn\"><a class=\"fq-cloud shake\" href=\"" . wysafe("pure_fastbox_cloud") . "\" title=\"看看我的云\" target=\"_blank\"></a></div>";
	}

	if (wysafe("pure_fastbox_bookmark")) {
		echo "<div id=\"fbbookmark\" class=\"fqbtn\"><a class=\"fq-bookmark shake\" href=\"" . wysafe("pure_fastbox_bookmark") . "\" title=\"看看我的书签\" target=\"_blank\"></a></div>";
	}

	if (wysafe("pure_fastbox_cool")) {
		echo "<div id=\"fbcool\" class=\"fqbtn\"><a class=\"fq-cool shake\" href=\"" . wysafe("pure_fastbox_cool") . "\" title=\"给力的酷玩意\" target=\"_blank\"></a></div>";
	}

	if (wysafe("pure_fastbox_download")) {
		echo "<div id=\"fbdownload\" class=\"fqbtn\"><a class=\"fq-download shake\"  href=\"" . wysafe("pure_fastbox_download") . "\" title=\"分享我的百度网盘\" target=\"_blank\"></a></div>";
	}

	if (wysafe("pure_fastbox_mail")) {
		echo "<div id=\"fbmail\" class=\"fqbtn\"><a class=\"fq-mail shake\" href=\"" . wysafe("pure_fastbox_mail") . "\" title=\"给我发邮件\" target=\"_blank\"></a></div>";
	}

	if (wysafe("pure_fastbox_music")) {
		echo "<div id=\"fbmusic\" class=\"fqbtn\"><a class=\"fq-music shake\" href=\"" . wysafe("pure_fastbox_music") . "\" title=\"聆听我的音乐\" target=\"_blank\"></a></div>";
	}

	if (wysafe("pure_fastbox_video")) {
		echo "<div id=\"fbvideo\" class=\"fqbtn\"><a class=\"fq-video shake\" href=\"" . wysafe("pure_fastbox_video") . "\" title=\"查看我喜欢的视频\" target=\"_blank\"></a></div>";
	}

	if (wysafe("pure_fastbox_links")) {
		echo "<div id=\"fblinks\" class=\"fqbtn\"><a class=\"fq-links shake\" href=\"" . wysafe("pure_fastbox_links") . "\" title=\"分享我所收藏的网页\" target=\"_blank\"></a></div>";
	}

	if (wysafe("pure_fastbox_wordpress")) {
		echo "<div id=\"fbwordpress\" class=\"fqbtn\"><a class=\"fq-wordpress shake\" href=\"" . wysafe("pure_fastbox_wordpress") . "\" title=\"折腾技巧\" target=\"_blank\"></a></div>";
	}

	if (wysafe("pure_fastbox_wpmaster")) {
		echo "<div id=\"fbwpmaster\" class=\"fqbtn\"><a class=\"fq-wpmaster shake\" href=\"" . wysafe("pure_fastbox_wpmaster") . "\" title=\"网站技术分享\" target=\"_blank\"></a></div>";
	}

	if (wysafe("pure_fastbox_wpstore")) {
		echo "<div id=\"fbwpstore\" class=\"fqbtn\"><a class=\"fq-wpstore shake\" href=\"" . wysafe("pure_fastbox_wpstore") . "\" title=\"分享我的资源\" target=\"_blank\"></a></div>";
	}

	echo "</div></div></div>";
}

?>
