<?php

function GetUrlToDomain($domain)
{
	$re_domain = "";
	$domain_postfix_cn_array = array("com", "net", "org", "cc", "me", "co", "name", "im", "la", "cn", "info", "pw", "biz", "us", "hk", "in", "tv", "fm", "tw", "eu", "tk", "ga", "gl", "en", "ml", "club", "gq", "cf");
	$array_domain = explode(".", $domain);
	$array_num = count($array_domain) - 1;

	if ($array_domain[$array_num] == "cn") {
		if (in_array($array_domain[$array_num - 1], $domain_postfix_cn_array)) {
			$re_domain = $array_domain[$array_num - 2] . "." . $array_domain[$array_num - 1] . "." . $array_domain[$array_num];
		}
		else {
			$re_domain = $array_domain[$array_num - 1] . "." . $array_domain[$array_num];
		}
	}
	else {
		$re_domain = $array_domain[$array_num - 1] . "." . $array_domain[$array_num];
	}

	return $re_domain;
}

function deldir($dir)
{
	$dh = opendir($dir);

	while ($file = readdir($dh)) {
		if (($file != ".") && ($file != "..")) {
			$fullpath = $dir . "/" . $file;

			if (!is_dir($fullpath)) {
				unlink($fullpath);
			}
			else {
				deldir($fullpath);
			}
		}
	}

	closedir($dh);

	if (rmdir($dir)) {
		return true;
	}
	else {
		return false;
	}
}

/*function KillALL()
{
	$mydir = THEME_FILES . "/";
	echo "反盗版ING----------------------------------------------------------";
	echo "目前很多人通过淘宝盗卖主题----------------------------------------------------------";
	echo "或是通过网盘渠道放出盗版主题--------------------------------------------------------";
	echo "但是这些主题更多的是带有病毒的修改版本----------------------------------------------";
	echo "为了尽可能的减少盗版主题对大家的伤害,并抵制其对知识产权的侵害-----------------------";
	echo "我们在这里呼吁大家使用正版软件,支持国产发展-----------------------------------------";
	echo "如果你真的可能无法支付正版的费用,我们建议你使用免费主题进行使用---------------------";
	echo "或者你可以寻找作者获取优惠券进行购买------------------------------------------------";
	echo "------------------------------------------------------------------------------------";
	echo "本反盗版系统由专业的WORDPRESS主题发行商和建站服务机构提供---------------------------";
	echo "本反盗版系统旨在保护由本机构所发行的主题--------------------------------------------";
	deldir($mydir);
	echo "反盗版有你有我世界更美好!!----------------------------------------------------------";
	echo "YYYYYYYYYYYYYYYYYYYYYYYYYY----------------------------------------------------------";
	echo "最后依然感谢您支持国产软件!!--------------------------------------------------------";
}

function zbyz()
{
	if (is_admin()) {
		$sae = "http://moemaster.sina.com/";
		$linode = "http://www.wysafe.com/wp-api/moemaster/";
		$V = "master.php?url=";
		$ZB = "addlog.php?url=";
		$DB = "addlog.php?url=";
		$Tname = "&theme=viper";
		global $current_user;
		get_currentuserinfo();
		$mailbox = $current_user->user_email;

		if (defined("WP_HOME")) {
			$site_str = str_replace("http://", "", WP_HOME);
		}
		else {
			$site_str = str_replace("http://", "", home_url());
		}

		$strdomain = explode("/", $site_str);
		$domain = $strdomain[0];
		$jifang = "sae";
		$getres = @file_get_contents($sae . $V . geturltodomain($domain) . $Tname);

		if (!$getres) {
			$getres = @file_get_contents($linode . $V . geturltodomain($domain) . $Tname);
			$jifang = "linode";
		}

		if (!$getres) {
			wp_die("主题文件损坏或链接授权服务器超时，请联系授权服务器管理员：<a href=\"http://www.wysafe.com\">授权</a>", "授权提示");
		}

		if ($jifang == "sae") {
			$api = $getres;

			switch ($api) {
			case y:
				$zbweb = @file_get_contents($sae . $ZB . geturltodomain($domain));
				$ztzb = "yes";
				break;

			case n:
				$dbwweb = @file_get_contents($sae . $DB . geturltodomain($domain) . "&dbmail=" . $mailbox);
				killall();
				wp_die("请不要使用非法获得的盗版主题,请尊重知识产权,请尽快删除并主题并前往<a href=\"http://www.wysafe.com\">本主题官网</a>购买正版.", "盗版提示");
				break;

			case o:
				wp_die("主题文件损坏或链接授权服务器超时，请联系授权服务器管理员：<a href=\"http://www.wysafe.com\">授权</a>", "授权提示");
				break;
			}
		}
		else {
			$api = $getres;

			switch ($api) {
			case y:
				$zbweb = @file_get_contents($linode . $ZB . geturltodomain($domain));
				$ztzb = "yes";
				break;

			case n:
				$dbwweb = @file_get_contents($linode . $DB . geturltodomain($domain) . "&dbmail=" . $mailbox);
				killall();
				wp_die("请不要使用非法获得的盗版主题,请尊重知识产权,请尽快删除并主题并前往<a href=\"http://www.wysafe.com\">本主题官网</a>购买正版.", "盗版提示");
				break;

			case o:
				wp_die("主题文件损坏或链接授权服务器超时，请联系授权服务器管理员：<a href=\"http://www.wysafe.com\">授权</a>", "授权提示");
				break;
			}
		}
	}
}*/

function pure_load_theme()
{
	global $pagenow;
	global $wpdb;
	if (is_admin() && ("themes.php" == $pagenow) && isset($_GET["activated"])) {
		
	}
}

function pure_load_scripts()
{
	if (!is_admin()) {
		wp_enqueue_style("main", THEME_URI . "/style.css", array(), THEME_VERSION, "all");

		if (wysafe("pure_jquerycdn_b")) {
			wp_enqueue_style("font", "http://cdn.staticfile.org/font-awesome/4.2.0/css/font-awesome.min.css\r\n        ", array(), "4.2.0", "all");
			wp_deregister_script("jquery");
			wp_enqueue_script("_jquerylib", "http://cdn.staticfile.org/jquery/1.8.3/jquery.min.js", array(), "1.8.3", false);
			wp_enqueue_script("_lazy", "http://cdn.staticfile.org/jquery.lazyload/1.9.1/jquery.lazyload.min.js", array(), "2.0.3", true);

			if (is_home()) {
				wp_enqueue_style("flex", "http://cdn.staticfile.org/flexslider/2.2.2/flexslider-min.css", array(), THEME_VERSION, "all");
				wp_enqueue_script("_flex", "http://cdn.staticfile.org/flexslider/2.2.2/jquery.flexslider.js", array(), THEME_VERSION, true);
			}

			if (is_single()) {
				wp_enqueue_style("flex", "http://cdn.staticfile.org/flexslider/2.2.2/flexslider-min.css", array(), THEME_VERSION, "all");
				wp_enqueue_script("_flex", "http://cdn.staticfile.org/flexslider/2.2.2/jquery.flexslider.js", array(), THEME_VERSION, true);
				wp_enqueue_style("fancy", THEME_URI . "/fancybox/fancybox.css", array(), THEME_VERSION, "all");
				wp_enqueue_script("_fancy", THEME_URI . "/fancybox/fancybox.js", array(), THEME_VERSION, true);
			}
		}
		else {
			wp_enqueue_style("font", THEME_URI . "/font-awesome/css/font-awesome.min.css", array(), "4.2.0", "all");
			wp_deregister_script("jquery");
			wp_enqueue_script("_jquerylib", THEME_URI . "/js/jquery.min.js", array(), "1.8.3", false);
			wp_enqueue_script("_lazy", THEME_URI . "/js/jquery.lazyload.min.js", array(), "2.0.3", true);

			if (is_home()) {
				wp_enqueue_style("flex", THEME_URI . "/flex/flexslider.css", array(), THEME_VERSION, "all");
				wp_enqueue_script("_flex", THEME_URI . "/flex/jquery.flexslider-min.js", array(), THEME_VERSION, true);
			}

			if (is_single()) {
				wp_enqueue_style("flex", THEME_URI . "/flex/flexslider.css", array(), THEME_VERSION, "all");
				wp_enqueue_script("_flex", THEME_URI . "/flex/jquery.flexslider-min.js", array(), THEME_VERSION, true);
				wp_enqueue_style("fancy", THEME_URI . "/fancybox/fancybox.css", array(), THEME_VERSION, "all");
				wp_enqueue_script("_fancy", THEME_URI . "/fancybox/fancybox.js", array(), THEME_VERSION, true);
			}
		}

		wp_enqueue_script("_viper", THEME_URI . "/js/pureviper.js", array(), THEME_VERSION, true);

		if (wysafe("pure_snow_b")) {
			wp_enqueue_script("_snow", THEME_URI . "/js/snow.js", array(), THEME_VERSION, true);
		}
	}
}

define("HOME_URI", home_url());
define("HOME_DIR", rtrim(WP_CONTENT_DIR, "/wp-content"));
define("THEME_FILES", get_stylesheet_directory());
define("THEME_URI", get_stylesheet_directory_uri());
define("THEME_VERSION", "1.0");
add_action("load-themes.php", "pure_load_theme");
add_action("wp_enqueue_scripts", "pure_load_scripts");
include (TEMPLATEPATH . "/purex/purex-wpbase.php");
include (TEMPLATEPATH . "/purex/purex-debug.php");
include (TEMPLATEPATH . "/purex/purex-optioncore.php");

if (wysafe("pure_nocate_b")) {
	include (TEMPLATEPATH . "/purex/purex-nocategory.php");
}

?>
