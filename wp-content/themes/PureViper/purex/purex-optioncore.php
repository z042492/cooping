<?php

function mytheme_add_admin()
{
	global $themename;
	global $options;

	if (@$_GET["page"] == basename(__FILE__)) {
		if ("save" == @$_REQUEST["action"]) {
			foreach ($options as $value ) {
				update_option($value, $_REQUEST[$value]);
			}

			header("Location: admin.php?page=purex-optioncore.php&saved=true");
			exit();
		}
	}

	$icon = get_template_directory_uri() . "/purex/style/purex.png";
	add_menu_page($themename . " Options", $themename . "设置", "edit_themes", basename(__FILE__), "mytheme_admin", $icon);
}

function mytheme_admin()
{
	global $themename;
	global $options;
	$i = 0;

	if (@$_REQUEST["saved"]) {
		echo "<div class=\"updated settings-error\"><p>" . $themename . "修改已保存</p></div>";
	}
	function show_id()
	{
		global $wpdb;
		$request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
		$request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
		$request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
		$request .= " ORDER BY term_id asc";
		$categorys = $wpdb->get_results($request);
		echo "<ol class=\"catid\">";

		foreach ($categorys as $category ) {
			$output = "<li>" . $category->name . "&nbsp;［<font color=#0196e3>" . $category->term_id . "</font>］</li>";
			echo $output;
		}

		echo "</ol>";
	}
	function clearval($content)
	{
		$content = mb_ereg_replace("^(　| )+", "", $content);
		$content = mb_ereg_replace("(　| )+\$", "", $content);
		$content = mb_ereg_replace("　　", "\n　　", $content);
		return $content;
	}

	echo "<div class=\"wrap pure_wrap\">\r\n  \r\n\t<link rel=\"stylesheet\" href=\"";
	bloginfo("template_url");
	echo "/purex/style/admin.css\"/>\r\n    <script src=\"";
	bloginfo("template_url");
	echo "/purex/style/jquery-1.8.3.min.js\"></script>\r\n    <script src=\"";
	bloginfo("template_url");
	echo "/purex/style/jquery.tzCheckbox.js\"></script>\r\n    <div class=\"pure_header\">\r\n\t<h2>";
	echo $themename;

	echo "设置\r\n        <span class=\"pure_themedesc\">作者：<a href=\"http://www.wysafe.com\" target=\"_blank\">梦月酱</a> &nbsp;\r\n    </h2>\r\n\t</div>\r\n <form method=\"post\" name=\"pure_form\" class=\"pure_form\" >\r\n\t\t<div class=\"pure_admincontent\">\r\n\t\t<div class=\"pure_tab\">\r\n\t\t\t<ul>\r\n\t\t\t\t<li class=\"pure_tab_on\">基础设置</li>\r\n\t\t\t\t<li>高级设置</li>\r\n                <li>社交设置</li>\r\n\t\t\t\t<li>广告模块</li>\r\n\t\t\t\t<li>垃圾清理</li>\r\n                <li>更新情况</li>\r\n\t\t\t\t<li>授权说明</li>\r\n\t\t\t</ul>\r\n\t\t</div>\r\n\t\t<div class=\"pure_maintab\">\r\n";
	echo "\t\t\r\n\t\t<div class=\"pure_mainbox\" id=\"pure_mainbox_1\">\r\n\t\t\t\t<ul class=\"pure_inner\">\r\n\t\t\t\t<li class=\"pure_li\">\t\t\t\t\t\t\t\t\r\n                    <div class=\"bs-callout bs-callout-info\">\r\n                        <h4>使用须知</h4>\r\n                        注意：不要开启Debug模式。主题使用前请记住先关闭所有插件，当您使用主题设置好之后，确定网站正常运行后再打开插件，主题默认兼容了大多数插件，您可以搭配缓存插件，地图插件等配合使用，如果出现不兼容的问题，请首先检查不兼容的插件，其次检查主机的权限设置。主题默认支援Wordpress 3.5以上版本【3.5以下版本因为函数不完整会报错】，不再对3.5以下版本提供支持。\r\n                    </div>\r\n                </li>\r\n                <li class=\"pure_li\">                                \r\n                    <div class=\"bs-callout bs-callout-info\">\r\n                        <h4>如何CMS化</h4>\r\n                        CMS请前往小工具页面，将需要的内容添加到首页CMS类别下面，记住必须使用对应的首页CMS小工具，至于目录ID可以在本页查看。\r\n                    </div>\r\n                </li>    \r\n                <li class=\"pure_li\">                                \r\n                    <div class=\"bs-callout bs-callout-info\">\r\n                        <h4>导航</h4>\r\n                        主题内置多种导航，分为顶部导航，可以随着网页滚动。主导航，头像右边的那个。手机导航。页面导航。以及只有用户登录后显示的用户导航。请根据需要进行添加。添加导航图标请在导航文字右侧加入&lt;i class=\"图标代码\"&gt;&lt;/i&gt;,代码参考打开<a href=\"http://www.wysafe.com/wp-api/fontawesome/index.html\" target=\"_blank\">图标</a>网页\r\n                    </div>\r\n                </li>   \r\n\t\t\t                    <!--\t\r\n                    <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                使用拓展颜色风格\r\n                            </h3>\r\n\t\t\t\t\t\t\t<div class=\"pure_cotl\">\r\n\t\t\t\t\t\t\t                            <div class=\"pure_cotl\">\r\n\t\t\t\t\t\t\t\t<div class=\"bs-callout bs-callout-info\">\r\n     <h4>如何滑动选项</h4>\r\n     您可以点击选项中滑动部分开启选项或者关闭！\r\n</div>\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_colorboxs_b\" name=\"pure_colorboxs_b\" ";

	if (wysafe("pure_colorboxs_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                            \r\n                            </div>\r\n                    </li>\t\t\t\t\t\t\r\n                    <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                拓展颜色风格\r\n                            </h3>\r\n                            <div class=\"pure_cotl\" style=\"height: 40px;\">\r\n\t\t\t\t\t\t\t";
	$colorboxs = wysafe("pure_colorboxs");
	echo "\t\t\t\t\t\t\t\t\r\n\r\n\t\t\t\t\t\t\t\t";
	echo "\t\r\n\t\t\t\t\t\t\t\t<input type=\"radio\" class=\"colorboxs\" id=\"pure_color_7FA8CB\" value=\"7FA8CB\" name=\"pure_colorboxs\" ";

	if ($colorboxs == "7FA8CB") {
		echo "checked=\"checked\"";
	}

	echo " style=\"display:none\">\r\n\t\t\t\t\t\t\t\t<a style=\"background-color: #7FA8CB; display: inline;\" href=\"javascript:;\" class=\"pure-radio-img-img pure-radio-color ";

	if ($colorboxs == "7FA8CB") {
		echo "pure-radio-img-selected";
	}

	echo "\" onclick=\"document.getElementById('pure_color_7FA8CB').checked=true;\"></a>\r\n\t\t\t\t\t\t\t\t";
	echo "\t\r\n\t\t\t\t\t\t\t\t<input type=\"radio\" class=\"colorboxs\" id=\"pure_color_FF5E52\" value=\"FF5E52\" name=\"pure_colorboxs\" ";

	if ($colorboxs == "FF5E52") {
		echo "checked=\"checked\"";
	}

	echo " style=\"display:none\">\r\n\t\t\t\t\t\t\t\t<a style=\"background-color: #FF5E52; display: inline;\" href=\"javascript:;\" class=\"pure-radio-img-img pure-radio-color ";

	if ($colorboxs == "FF5E52") {
		echo "pure-radio-img-selected";
	}

	echo "\" onclick=\"document.getElementById('pure_color_FF5E52').checked=true;\"></a>\r\n\t\t\t\t\t\t\t\t";
	echo "\t\t\t\t\t\t\t\t<input type=\"radio\" class=\"colorboxs\" id=\"pure_color_F8D0AF\" value=\"F8D0AF\" name=\"pure_colorboxs\" ";

	if ($colorboxs == "F8D0AF") {
		echo "checked=\"checked\"";
	}

	echo " style=\"display:none\">\r\n\t\t\t\t\t\t\t\t<a style=\"background-color: #F8D0AF; display: inline;\" href=\"javascript:;\" class=\"pure-radio-img-img pure-radio-color ";

	if ($colorboxs == "FF5E52") {
		echo "pure-radio-img-selected";
	}

	echo "\" onclick=\"document.getElementById('pure_color_F8D0AF').checked=true;\"></a>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t";
	echo "\t\t\t\t\t\t\t\t<input type=\"radio\" class=\"colorboxs\" id=\"pure_color_3ba354\" value=\"3ba354\" name=\"pure_colorboxs\" ";

	if ($colorboxs == "3ba354") {
		echo "checked=\"checked\"";
	}

	echo " style=\"display:none\">\r\n\t\t\t\t\t\t\t\t<a style=\"background-color: #3ba354; display: inline;\" href=\"javascript:;\" class=\"pure-radio-img-img pure-radio-color ";

	if ($colorboxs == "FF5E52") {
		echo "pure-radio-img-selected";
	}

	echo "\" onclick=\"document.getElementById('pure_color_3ba354').checked=true;\"></a>\r\n\t\t\t\t\t\t\t\t";
	echo "\t\t\t\t\t\t\t\t<input type=\"radio\" class=\"colorboxs\" id=\"pure_color_555555\" value=\"555555\" name=\"pure_colorboxs\" ";

	if ($colorboxs == "555555") {
		echo "checked=\"checked\"";
	}

	echo " style=\"display:none\">\r\n\t\t\t\t\t\t\t\t<a style=\"background-color: #555555; display: inline;\" href=\"javascript:;\" class=\"pure-radio-img-img pure-radio-color ";

	if ($colorboxs == "FF5E52") {
		echo "pure-radio-img-selected";
	}

	echo "\" onclick=\"document.getElementById('pure_color_555555').checked=true;\"></a>\r\n\t\t\t\t\t\t\t\t";
	echo "\t\r\n\t\t\t\t\t\t\t\t<input type=\"radio\" class=\"colorboxs\" id=\"pure_color_B37333\" value=\"B37333\" name=\"pure_colorboxs\" ";

	if ($colorboxs == "B37333") {
		echo "checked=\"checked\"";
	}

	echo " style=\"display:none\">\r\n\t\t\t\t\t\t\t\t<a style=\"background-color: #B37333; display: inline;\" href=\"javascript:;\" class=\"pure-radio-img-img pure-radio-color ";

	if ($colorboxs == "FF5E52") {
		echo "cpure-radio-img-selected";
	}

	echo "\" onclick=\"document.getElementById('pure_color_B37333').checked=true;\"></a>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t";
	echo "\t\r\n\t\t\t\t\t\t\t\t<input type=\"radio\" class=\"colorboxs\" id=\"pure_color_D9534F\" value=\"D9534F\" name=\"pure_colorboxs\" ";

	if ($colorboxs == "D9534F") {
		echo "checked=\"checked\"";
	}

	echo " style=\"display:none\">\r\n\t\t\t\t\t\t\t\t<a style=\"background-color: #D9534F; display: inline;\" href=\"javascript:;\" class=\"pure-radio-img-img pure-radio-color ";

	if ($colorboxs == "FF5E52") {
		echo "pure-radio-img-selected";
	}

	echo "\" onclick=\"document.getElementById('pure_color_D9534F').checked=true;\"></a>\t\t\t\t\t\t\t\t\r\n                            </div>\r\n                        </li>                   \r\n\t\t\t\t\t\t<li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                顶栏固定\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_fixheader_b\" name=\"pure_fixheader_b\" ";

	if (wysafe("pure_fixheader_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                            </div>\r\n                        </li>\r\n                         -->\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                友情链接\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                <a href=\"";
	bloginfo("url");
	echo "/wp-admin/link-manager.php\">点击前往修改友情链接</a>，请通过小工具添加到网站。<a href=\"";
	bloginfo("url");
	echo "/wp-admin/widgets.php\">点击前往小工具</a>。\r\n                            </div>\r\n                        </li>                        \t\r\n\t\t\t\t\t\t<li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                自定义Banner背景图片\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n\t\t\t\t\t\t\t\t<div class=\"bs-callout bs-callout-info\">\r\n\t\t\t\t\t\t\t\t\t<h4>上传自定义图片</h4>\r\n\t\t\t\t\t\t\t\t\t您可以点击<a href=\"";
	bloginfo("url");
	echo "/wp-admin/media-new.php\" id=\"up-button\" class=\"button\" title=\"上传图片\"><span class=\"wp-media-buttons-icon\"></span>添加图片功能</a>,上传你需要自定义的图片获取相应的地址，文件将会上传到网站的uploads目录下,LOGO的PSD地址";
	bloginfo("template_directory");
	echo "/style/psd/logo.psd<br>\r\n\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\r\n                                <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_bannerpic_b\" name=\"pure_bannerpic_b\" ";

	if (wysafe("pure_bannerpic_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                >\r\n\r\n                                <input class=\"ipt-b\" name=\"pure_bannerpic\" id=\"pure_bannerpic\" type=\"text\" value=\"";
	echo wysafe("pure_bannerpic");
	echo "\">\r\n\t\t\t\t\t\t\t\t<span class=\"pure_tip\">\r\n                                    填入需要显示内容的URL地址即可！\r\n                                </span>\r\n\r\n                                <input class=\"ipt-b\" name=\"pure_bannerwidth\" id=\"pure_bannerwidth\" type=\"text\" value=\"";
	echo wysafe("pure_bannerwidth");
	echo "\">\r\n\t\t\t\t\t\t\t\t<span class=\"pure_tip\">\r\n                                    填入最后Banner的高度！\r\n                                </span>\t\t\t\t\t\t\t\t\t\r\n                            </div>\r\n                        </li>\t\t\t\t\t\t\t\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                自定义Logo\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n\t\t\t\t\t\t\t\t<div class=\"bs-callout bs-callout-info\">\r\n     <h4>上传自定义图片</h4>\r\n     您可以点击<a href=\"";
	bloginfo("url");
	echo "/wp-admin/media-new.php\" id=\"up-button\" class=\"button\" title=\"上传图片\"><span class=\"wp-media-buttons-icon\"></span>添加图片功能</a>,上传你需要自定义的图片获取相应的地址，文件将会上传到网站的uploads目录下,LOGO的PSD地址";
	bloginfo("template_directory");
	echo "/style/psd/logo.psd<br>\r\n</div>\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_logo_b\" name=\"pure_logo_b\" ";

	if (wysafe("pure_logo_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                \r\n                                <input class=\"ipt-b\" name=\"pure_logo\" id=\"pure_logo\" type=\"text\" value=\"";
	echo wysafe("pure_logo");
	echo "\">\r\n\t\t\t\t\t\t\t\t<span class=\"pure_tip\">\r\n                                    填入需要显示内容的URL地址即可！\r\n                                </span>\r\n                            </div>\r\n                        </li>\t\t\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                自定义大头像\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                <div class=\"bs-callout bs-callout-info\">\r\n     <h4>上传自定义大头像</h4>\r\n     您可以点击<a href=\"";
	bloginfo("url");
	echo "/wp-admin/media-new.php\" id=\"up-button\" class=\"button\" title=\"上传图片\"><span class=\"wp-media-buttons-icon\"></span>添加图片功能</a>,上传你需要自定义的图片获取相应的地址，文件将会上传到网站的uploads目录下<br>\r\n</div>\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_myavatar_b\" name=\"pure_myavatar_b\" ";

	if (wysafe("pure_myavatar_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                \r\n                                <input class=\"ipt-b\" name=\"pure_myavatar\" id=\"pure_myavatar\" type=\"text\" value=\"";
	echo wysafe("pure_myavatar");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入需要显示内容的URL地址即可！\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                自定义背景\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n\t\t\t\t\t\t\t\t<div class=\"bs-callout bs-callout-info\">\r\n     <h4>上传自定义图片</h4>\r\n     您可以点击<a href=\"";
	bloginfo("url");
	echo "/wp-admin/media-new.php\" id=\"up-button\" class=\"button\" title=\"上传图片\"><span class=\"wp-media-buttons-icon\"></span>添加图片功能</a>,上传你需要自定义的图片获取相应的地址，文件将会上传到网站的uploads目录下<br>\r\n</div>\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_background_b\" name=\"pure_background_b\" ";

	if (wysafe("pure_background_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                \r\n                                <input class=\"ipt-b\" name=\"pure_background\" id=\"pure_background\" type=\"text\" value=\"";
	echo wysafe("pure_background");
	echo "\">\r\n\t\t\t\t\t\t\t\t<span class=\"pure_tip\">\r\n                                    填入需要显示内容的URL地址即可！\r\n                                </span>\r\n                            </div>\r\n                        </li>\t\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                文章目录[ID]\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                ";
	show_id();
	echo "                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                网站最新通知\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_tongzhi_b\" name=\"pure_tongzhi_b\" ";

	if (wysafe("pure_tongzhi_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <input class=\"ipt-b\" type=\"text\" id=\"pure_tongzhi\" name=\"pure_tongzhi\"\r\n                                value=\"";
	echo wysafe("pure_tongzhi");
	echo "\">                                    \r\n\t\t\t\t\t\t\t\t\t<span class=\"pure_tip\">\r\n                                        显示最新的通知信息,让访客知道你要广播的信息！\r\n\t\t\t\t\t\t\t\t\t</span>\r\n                            </div>\r\n                        </li>\t\t\t\t\t\t\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                网站描述\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                <input class=\"ipt-b\" type=\"text\" id=\"pure_description\" name=\"pure_description\"\r\n                                value=\"";
	echo wysafe("pure_description");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                        据说对SEO有好处！\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                网站关键字\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                <input class=\"ipt-b\" type=\"text\" id=\"pure_keywords\" name=\"pure_keywords\"\r\n                                value=\"";
	echo wysafe("pure_keywords");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                        据说对SEO有好处,可是完全感觉不到！\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                网站备案号\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                <input class=\"ipt-b\" type=\"text\" id=\"pure_beian\" name=\"pure_beian\" value=\"";
	echo wysafe("pure_beian");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                        有就写！\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                文章缩略图开关\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_thumb_b\" name=\"pure_thumb_b\" ";

	if (wysafe("pure_thumb_b")) {
		echo "checked=\"checked\"";
	}

	echo ">\r\n                                    <span class=\"pure_tip\">\r\n                                        打开以后对图像进行缩略显示,对网站速度有优化,默认打开！\r\n                                    </span>\r\n                            </div>\r\n                        </li>\t\t\t\t\t\t\t\t\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                流量统计代码\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_track_b\" name=\"pure_track_b\" ";

	if (wysafe("pure_track_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <textarea name=\"pure_track\" id=\"pure_track\" type=\"textarea\" rows=\"4\">";
	echo clearval(wysafe("pure_track"));
	echo "</textarea>\r\n                                <span class=\"pure_tip\">\r\n                                    将统计代码放到此处即可。【默认支持百度统计新版统计代码，老版代码请在自定义Javascript处添加】\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                自定义CSS设置\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_headcode_b\" name=\"pure_headcode_b\" ";

	if (wysafe("pure_headcode_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <textarea name=\"pure_headcode\" id=\"pure_headcode\" type=\"textarea\" rows=\"4\">";
	echo clearval(wysafe("pure_headcode"));
	echo "</textarea>\r\n                                <span class=\"pure_tip\">\r\n                                    您设置的自定义CSS会自动加载到网页面头部（head区域），调整你需要的地方，请尽量通过此处进行修改，这样不影响主题的整体使用。\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                自定义Javascript设置\r\n                            </h3>\r\n                           <div class=\"pure_cotl\">\r\n                                <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_footcode_b\" name=\"pure_footcode_b\" ";

	if (wysafe("pure_footcode_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <textarea name=\"pure_footcode\" id=\"pure_footcode\" type=\"textarea\" rows=\"4\">";
	echo clearval(wysafe("pure_footcode"));
	echo "</textarea>\r\n                                <span class=\"pure_tip\">\r\n                                    您设置的自定义JS会自动加载到网页面底部（body之前的区域），如果使用CNZZ统计代码或者是谷歌统计代码，请将代码添加到此，百度推荐，云推荐亦然。\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                哀悼模式\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_gray_b\" name=\"pure_gray_b\" ";

	if (wysafe("pure_gray_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                            </div>\r\n                        </li>                        \r\n                                            <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                开启用户中心\r\n                            </h3>\r\n    <div class=\"pure_cotl\">\r\n    <div class=\"bs-callout bs-callout-info\">\r\n    <h4>如何增强用户中心</h4>\r\n    用户中心需要搭配用户中心插件使用，插件已经跟随旗舰版安装包附赠。安装插件后请先配置好插件，在开启此功能。否则可能导致不恰当的错误，非旗舰版客户可以通过补齐差价升级到旗舰版开启使用。\r\n    </div>\r\n     <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_user_center_b\" name=\"pure_user_center_b\" ";

	if (wysafe("pure_user_center_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                    <input class=\"ipt-b\" type=\"text\" id=\"pure_usermangerurl\" name=\"pure_usermangerurl\"\r\n                                value=\"";
	echo wysafe("pure_usermangerurl");
	echo "\">\r\n                                 <span class=\"pure_tip\">\r\n                                    请在上面写入管理页面地址，如果没有可以填写你的WP后台地址。\r\n                                </span>\r\n                            <input class=\"ipt-b\" type=\"text\" id=\"pure_userregurl\" name=\"pure_userregurl\"\r\n                                value=\"";
	echo wysafe("pure_userregurl");
	echo "\">\r\n                                 <span class=\"pure_tip\">\r\n                                    请在上面填写注册地址，可以填写插件生成的页面地址，或是站外地址，或是DZ论坛地址。\r\n                                </span>\r\n                                <input class=\"ipt-b\" type=\"text\" id=\"pure_userloginurl\" name=\"pure_userloginurl\"\r\n                                value=\"";
	echo wysafe("pure_userloginurl");
	echo "\">\r\n                                 <span class=\"pure_tip\">\r\n                                   请在上面填写登录地址，如果没有可以填写你的WP后台地址。\r\n                                </span>\r\n                            </div>\r\n                    </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                百度站内搜索\r\n                            </h3>\r\n                           <div class=\"pure_cotl\">\r\n                                <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_zhannei_b\" name=\"pure_zhannei_b\" ";

	if (wysafe("pure_zhannei_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <input class=\"ipt-b\" type=\"text\" id=\"pure_zhannei\" name=\"pure_zhannei\"\r\n                                value=\"";
	echo wysafe("pure_zhannei");
	echo "\">\r\n                                 <span class=\"pure_tip\">\r\n                                   请在上面填写站内搜索ID.\r\n                                </span>                                \r\n                                <input class=\"ipt-b\" type=\"text\" id=\"pure_zhannei_url\" name=\"pure_zhannei_url\"\r\n                                value=\"";
	echo wysafe("pure_zhannei_url");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    请在上面填写站内搜索地址。\r\n                                </span>\r\n                            </div>\r\n                        </li>     \r\n                       <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                七牛CDN加速\r\n                            </h3>\r\n                           <div class=\"pure_cotl\">\r\n                                <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_cdn_b\" name=\"pure_cdn_b\" ";

	if (wysafe("pure_cdn_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <!-- \r\n                                <input class=\"ipt-b\" type=\"text\" id=\"pure_cdn\" name=\"pure_cdn\"\r\n                                value=\"";
	echo wysafe("pure_cdn");
	echo "\">\r\n                                -->\r\n                                 <span class=\"pure_tip\">\r\n                                     如果你使用七牛云存储加速你的网站，请打开。\r\n                                </span>  \r\n                                <!-- \r\n                                <input class=\"ipt-b\" type=\"text\" id=\"pure_cdnori\" name=\"pure_cdnori\"\r\n                                value=\"";
	echo wysafe("pure_cdnori");
	echo "\">\r\n                                -->\r\n                         </div>\r\n                        </li>   \r\n                       <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                Gzip加速\r\n                            </h3>\r\n                           <div class=\"pure_cotl\">\r\n                                <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_gzip_b\" name=\"pure_gzip_b\" ";

	if (wysafe("pure_gzip_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >                              \r\n                            </div>\r\n                        </li>    \r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                评论小尾巴\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                <input class=\"ipt-b\" type=\"text\" id=\"pure_weiba\" name=\"pure_weiba\" value=\"";
	echo wysafe("pure_weiba");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                        就当是广告！\r\n                                </span>\r\n                            </div>\r\n                        </li>                                            \r\n\t\t\t</ul>\r\n\t\t</div>\t\t\r\n";
	echo "\t\t<div class=\"pure_mainbox\" id=\"pure_mainbox_2\" style=\"display:none\">\r\n\t\t\t\t<ul class=\"pure_inner\">\t\t\t\t\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                禁止站内文章Pingback\r\n                            </h3>\r\n                           <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_pingback_b\" name=\"pure_pingback_b\" ";

	if (wysafe("pure_pingback_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        不会发送站内Pingback，建议开启\r\n                                    </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                禁止后台编辑时自动保存\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_autosave_b\" name=\"pure_autosave_b\" ";

	if (wysafe("pure_autosave_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        后台编辑文章时候不会定时保存，有效缩减数据库存储量；但是，一般不建议，除非你的数据库容量很小\r\n                                    </span>\r\n                            </div>\r\n                        </li>\r\n                      <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                开启No Category\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_nocate_b\" name=\"pure_nocate_b\" ";

	if (wysafe("pure_nocate_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        使网站的固定地址变得简介，但是需要伪静态的支持\r\n                                    </span>\r\n                            </div>\r\n                        </li>\t\t\r\n                      <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                开启动态载入特效\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_css3load_b\" name=\"pure_css3load_b\" ";

	if (wysafe("pure_css3load_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        开启动态载入特效，让网站加载更为流畅\r\n                                    </span>\r\n                            </div>\r\n                        </li>                        \r\n                        <!--\t\t\t\t\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                非官方风格后台登录\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_login_b\" name=\"pure_login_b\" ";

	if (wysafe("pure_login_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        将调用非官方版本的后台登录界面，使主题风格更加保持一致性。\r\n                                    </span>\r\n                            </div>\r\n                        </li>\t\t\r\n                        -->\t\t\t\t\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                灯箱开关\r\n                            </h3>\r\n                           <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_lightbox_b\" name=\"pure_lightbox_b\" ";

	if (wysafe("pure_lightbox_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        图片弹出遮罩功能\r\n                                    </span>\r\n                            </div>\r\n                        </li>\r\n                        <!--\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                随机浏览数\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                   <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_default_views_b\" name=\"pure_default_views_b\" ";

	if (wysafe("pure_default_views_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n\t\t\t\t\t\t\t\t\t<span class=\"pure_tip\">\r\n                                        虚拟出很多浏览数，装作很热闹\r\n                                    </span>\r\n                            </div>\r\n                        </li>\r\n                        -->\t\t\t\t\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                全局静态库CDN加速\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_jquerycdn_b\" name=\"pure_jquerycdn_b\" ";

	if (wysafe("pure_jquerycdn_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        使用Staticfile.org的免费CDN服务对全站静态库进行加速。Staticfile采用的是七牛云存储公司提供的免费加速节点。\r\n                                    </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                评论头像CDN加速\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_cdn_avatar_b\" name=\"pure_cdn_avatar_b\"\r\n                                    ";

	if (wysafe("pure_cdn_avatar_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        使用Duoshuo的服务器对评论头像进行免费的CDN加速。因为多说的服务器偶尔也会出现抽风的状况。非特殊情况下，请勿开启。默认已经使用Cn节点的Gravatar。\r\n                                    </span>\r\n                            </div>\r\n                        </li>\t\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                开启图片本地化功能\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_piclocal_b\" name=\"pure_piclocal_b\"\r\n                                    ";

	if (wysafe("pure_piclocal_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        开启图片本地化功能后，可以将远程图片本地化，可直接在编辑文章中调用远程图片。\r\n                                    </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                开启管理员邮件提醒\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_adminmail_b\" name=\"pure_adminmail_b\"\r\n                                    ";

	if (wysafe("pure_adminmail_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        当有人登录后台时通过邮件提醒我。\r\n                                    </span>\r\n                            </div>\r\n                        </li> \r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                列表AJAX加载\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_ajaxpage_b\" name=\"pure_ajaxpage_b\"\r\n                                    ";

	if (wysafe("pure_ajaxpage_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        开启Ajax加载。\r\n                                    </span>\r\n                            </div>\r\n                        </li> \r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                下雪吧\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_snow_b\" name=\"pure_snow_b\"\r\n                                    ";

	if (wysafe("pure_snow_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        开启下雪。\r\n                                    </span>\r\n                            </div>\r\n                        </li>         \r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                底部头像\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_footeravatar_b\" name=\"pure_footeravatar_b\"\r\n                                    ";

	if (wysafe("pure_footeravatar_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        底部头像。\r\n                                    </span>\r\n                            </div>\r\n                        </li>                         \r\n                                     \r\n\t\t\t</ul>\r\n\t\t</div>\t\t\t\t\r\n      ";
	echo "\t\t<div class=\"pure_mainbox\" id=\"pure_mainbox_3\" style=\"display:none\">\r\n\t\t\t\t<ul class=\"pure_inner\">\r\n\t\t\t\t\t<li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                作者介绍\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_author_b\" name=\"pure_author_b\" ";

	if (wysafe("pure_author_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    > &nbsp; &nbsp;\r\n                                    <span class=\"pure_tip\">\r\n                                        显示作者介绍，针对多用户网站,注意:导航上的SNS交互按钮即使不打开这个选项也会显示的!\r\n                                    </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                新浪微博\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_weibo_b\" name=\"pure_weibo_b\" ";

	if (wysafe("pure_weibo_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >                                \r\n                                <input class=\"pure_inp_short\" name=\"pure_weibo\" id=\"pure_weibo\" type=\"text\"\r\n                                value=\"";
	echo wysafe("pure_weibo");
	echo "\">\r\n\t\t\t\t\t\t\t\t<span class=\"pure_tip\">\r\n                                    填入需要显示内容的URL地址即可！\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                QQ空间\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_qzone_b\" name=\"pure_qzone_b\"\r\n                                    ";

	if (wysafe("pure_qzone_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <input class=\"pure_inp_short\" name=\"pure_qzone\" id=\"pure_qzone\"\r\n                                type=\"text\" value=\"";
	echo wysafe("pure_qzone");
	echo "\">\r\n\t\t\t\t\t\t\t\t<span class=\"pure_tip\">\r\n                                    填入需要显示内容的URL地址即可！\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                QQ\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_qq_b\" name=\"pure_qq_b\" ";

	if (wysafe("pure_qq_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <input class=\"pure_inp_short\" name=\"pure_qq\" id=\"pure_qq\" type=\"text\"\r\n                                value=\"";
	echo wysafe("pure_qq");
	echo "\">\r\n\t\t\t\t\t\t\t\t<span class=\"pure_tip\">\r\n                                    填入需要显示内容的URL地址即可！\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                豆瓣地址\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_douban_b\" name=\"pure_douban_b\" ";

	if (wysafe("pure_douban_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <input class=\"pure_inp_short\" name=\"pure_douban\" id=\"pure_douban\" type=\"text\"\r\n                                value=\"";
	echo wysafe("pure_douban");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入需要显示内容的URL地址即可！\r\n                                </span>\r\n                            </div>\r\n                        </li> \r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                百度\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_baidu_b\" name=\"pure_baidu_b\" ";

	if (wysafe("pure_baidu_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <input class=\"pure_inp_short\" name=\"pure_baidu\" id=\"pure_baidu\" type=\"text\"\r\n                                value=\"";
	echo wysafe("pure_baidu");
	echo "\">\r\n\t\t\t\t\t\t\t\t<span class=\"pure_tip\">\r\n                                    填入需要显示内容的URL地址即可！\r\n                                </span>\r\n                            </div>\r\n                        </li>\t\t\t\t\t\t\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                RSS订阅地址\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_rss_b\" name=\"pure_rss_b\" ";

	if (wysafe("pure_rss_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <input class=\"pure_inp_short\" name=\"pure_rss\" id=\"pure_rss\" type=\"text\"\r\n                                value=\"";
	echo wysafe("pure_rss");
	echo "\">\r\n\t\t\t\t\t\t\t\t<span class=\"pure_tip\">\r\n                                    填入需要显示内容的URL地址即可！\r\n                                </span>\r\n                            </div>\r\n                        </li>   \r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                开启快速工具\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_fastbox_b\" name=\"pure_fastbox_b\" ";

	if (wysafe("pure_fastbox_b")) {
		echo "checked=\"checked\"";
	}

	echo ">\r\n                            </div>\r\n                        </li>                           \r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                快速工具调用\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                <input class=\"pure_inp_short\" name=\"pure_fastbox_cloud\" id=\"pure_fastbox_cloud\" type=\"text\"                               value=\"";
	echo wysafe("pure_fastbox_cloud");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入看看我的云的URL地址即可！\r\n                                </span>\r\n                                <input class=\"pure_inp_short\" name=\"pure_fastbox_bookmark\" id=\"pure_fastbox_bookmark\" type=\"text\"                               value=\"";
	echo wysafe("pure_fastbox_bookmark");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入看看我的书签的URL地址即可！\r\n                                </span>\r\n                                <input class=\"pure_inp_short\" name=\"pure_fastbox_cool\" id=\"pure_fastbox_cool\" type=\"text\"                               value=\"";
	echo wysafe("pure_fastbox_cool");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入给力的酷玩意的URL地址即可！\r\n                                </span>\r\n                                <input class=\"pure_inp_short\" name=\"pure_fastbox_download\" id=\"pure_fastbox_download\" type=\"text\"                               value=\"";
	echo wysafe("pure_fastbox_download");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入分享我的百度网盘的URL地址即可！\r\n                                </span>      \r\n                                <input class=\"pure_inp_short\" name=\"pure_fastbox_mail\" id=\"pure_fastbox_mail\" type=\"text\"                               value=\"";
	echo wysafe("pure_fastbox_mail");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入给我发邮件的URL地址即可！\r\n                                </span>\r\n                                <input class=\"pure_inp_short\" name=\"pure_fastbox_music\" id=\"pure_fastbox_music\" type=\"text\"                               value=\"";
	echo wysafe("pure_fastbox_music");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入聆听我的音乐的URL地址即可！\r\n                                </span>                                \r\n                                <input class=\"pure_inp_short\" name=\"pure_fastbox_video\" id=\"pure_fastbox_video\" type=\"text\"                               value=\"";
	echo wysafe("pure_fastbox_video");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入查看我喜欢的视频的URL地址即可！\r\n                                </span>\r\n                                <input class=\"pure_inp_short\" name=\"pure_fastbox_links\" id=\"pure_fastbox_links\" type=\"text\"                               value=\"";
	echo wysafe("pure_fastbox_links");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入分享我所收藏的网页的URL地址即可！\r\n                                </span>\r\n                                <input class=\"pure_inp_short\" name=\"pure_fastbox_wordpress\" id=\"pure_fastbox_wordpress\" type=\"text\"                               value=\"";
	echo wysafe("pure_fastbox_wordpress");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入折腾技巧的URL地址即可！\r\n                                </span>        \r\n                                <input class=\"pure_inp_short\" name=\"pure_fastbox_wpmaster\" id=\"pure_fastbox_wpmaster\" type=\"text\"                               value=\"";
	echo wysafe("pure_fastbox_wpmaster");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入网站技术分享的URL地址即可！\r\n                                </span>\r\n                                <input class=\"pure_inp_short\" name=\"pure_fastbox_wpstore\" id=\"pure_fastbox_wpstore\" type=\"text\"                               value=\"";
	echo wysafe("pure_fastbox_wpstore");
	echo "\">\r\n                                <span class=\"pure_tip\">\r\n                                    填入分享我的资源的URL地址即可！\r\n                                </span>                                                                                                                                                        \r\n                            </div>                           \r\n                        </li>   \r\n                    </table>\r\n\t\t\t\t\t</li>\r\n\t\t\t</ul>\r\n\t\t</div>\t\r\n      ";
	echo "\t\t<div class=\"pure_mainbox\" id=\"pure_mainbox_4\" style=\"display:none\">\r\n\t\t\t\t<ul class=\"pure_inner\">\r\n\t\t\t\t\t<li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                广告：这个是Logo右侧全站的横幅\r\n                            </h3>\r\n                           <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_ads_top_b\" name=\"pure_ads_top_b\" ";

	if (wysafe("pure_ads_top_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <textarea name=\"pure_ads_top\" id=\"pure_ads_top\" type=\"textarea\" rows=\"\">";
	echo clearval(wysafe("pure_ads_top"));
	echo "</textarea>\r\n                                <span class=\"pure_tip\">\r\n                                    建议高度 50px\r\n                                </span>\r\n                                <span class=\"pure_tip\">                                    广告区域，可以放置任意联盟广告和自定义广告的代码，下面也是一样的~~自定义代码如：&#60;a href=\"广告地址\" target=\"_blank\"&#62;&#60;img src=\"广告图片\" alt=\"连接标题\" title=\"连接标题\"&#62;&#60;/a&#62;\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                广告：这个是在全站底部的横幅\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_ads_bottom_b\" name=\"pure_ads_bottom_b\"\r\n                                    ";

	if (wysafe("pure_ads_bottom_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <textarea name=\"pure_ads_bottom\" id=\"pure_ads_bottom\" type=\"textarea\"\r\n                                rows=\"\">";
	echo clearval(wysafe("pure_ads_bottom"));
	echo "</textarea>\r\n                                <span class=\"pure_tip\">\r\n                                    建议高度 50px\r\n                                </span>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                广告：这个是在首页正文之上\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_ads_index_b\" name=\"pure_ads_index_b\" ";

	if (wysafe("pure_ads_index_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <textarea name=\"pure_ads_index\" id=\"pure_ads_index\" type=\"textarea\" rows=\"\">";
	echo clearval(wysafe("pure_ads_index"));
	echo "</textarea>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                广告：这个是在文章页标题下面\r\n                            </h3>\r\n                           <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_ads_arttb_b\" name=\"pure_ads_arttb_b\" ";

	if (wysafe("pure_ads_arttb_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <textarea name=\"pure_ads_arttb\" id=\"pure_ads_arttb\" type=\"textarea\" rows=\"\">";
	echo clearval(wysafe("pure_ads_arttb"));
	echo "</textarea>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                广告：这个是在文章页相关文章下面\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_ads_artrb_b\" name=\"pure_ads_artrb_b\" ";

	if (wysafe("pure_ads_artrb_b")) {
		echo "checked=\"checked\"";
	}

	echo "                                    >\r\n                                <textarea name=\"pure_ads_artrb\" id=\"pure_ads_artrb\" type=\"textarea\" rows=\"\">";
	echo clearval(wysafe("pure_ads_artrb"));
	echo "</textarea>\r\n                            </div>\r\n                        </li>\r\n                        <li class=\"pure_li\">\r\n                            <h3 class=\"pure_tit\">\r\n                                广告：这个是在文章页网友评论下面\r\n                            </h3>\r\n                            <div class=\"pure_cotl\">\r\n                                    <input type=\"checkbox\" data-on=\"开启\" data-off=\"关闭\" id=\"pure_ads_artcb_b\" name=\"pure_ads_artcb_b\" ";

	if (wysafe("pure_ads_artcb_b")) {
		echo "checked=\"checked\"";
	}
	function wp_clean_up($type)
	{
		global $wpdb;

		switch ($type) {
		case "revision":
			$wcu_sql = "DELETE FROM $wpdb->posts WHERE post_type = 'revision'";
			$wpdb->query($wcu_sql);
			break;

		case "draft":
			$wcu_sql = "DELETE FROM $wpdb->posts WHERE post_status = 'draft'";
			$wpdb->query($wcu_sql);
			break;

		case "autodraft":
			$wcu_sql = "DELETE FROM $wpdb->posts WHERE post_status = 'auto-draft'";
			$wpdb->query($wcu_sql);
			break;

		case "moderated":
			$wcu_sql = "DELETE FROM $wpdb->comments WHERE comment_approved = '0'";
			$wpdb->query($wcu_sql);
			break;

		case "spam":
			$wcu_sql = "DELETE FROM $wpdb->comments WHERE comment_approved = 'spam'";
			$wpdb->query($wcu_sql);
			break;

		case "trash":
			$wcu_sql = "DELETE FROM $wpdb->comments WHERE comment_approved = 'trash'";
			$wpdb->query($wcu_sql);
			break;

		case "postmeta":
			$wcu_sql = "DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL";
			$wpdb->query($wcu_sql);
			break;

		case "commentmeta":
			$wcu_sql = "DELETE FROM $wpdb->commentmeta WHERE comment_id NOT IN (SELECT comment_id FROM $wpdb->comments)";
			$wpdb->query($wcu_sql);
			break;

		case "relationships":
			$wcu_sql = "DELETE FROM $wpdb->term_relationships WHERE term_taxonomy_id=1 AND object_id NOT IN (SELECT id FROM $wpdb->posts)";
			$wpdb->query($wcu_sql);
			break;

		case "feed":
			$wcu_sql = "DELETE FROM $wpdb->options WHERE option_name LIKE '_site_transient_browser_%' OR option_name LIKE '_site_transient_timeout_browser_%' OR option_name LIKE '_transient_feed_%' OR option_name LIKE '_transient_timeout_feed_%'";
			$wpdb->query($wcu_sql);
			break;
		}
	}
	function wp_clean_up_count($type)
	{
		global $wpdb;

		switch ($type) {
		case "revision":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'revision'";
			$count = $wpdb->get_var($wcu_sql);
			break;

		case "draft":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'draft'";
			$count = $wpdb->get_var($wcu_sql);
			break;

		case "autodraft":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'auto-draft'";
			$count = $wpdb->get_var($wcu_sql);
			break;

		case "moderated":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '0'";
			$count = $wpdb->get_var($wcu_sql);
			break;

		case "spam":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = 'spam'";
			$count = $wpdb->get_var($wcu_sql);
			break;

		case "trash":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = 'trash'";
			$count = $wpdb->get_var($wcu_sql);
			break;

		case "postmeta":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL";
			$count = $wpdb->get_var($wcu_sql);
			break;

		case "commentmeta":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id NOT IN (SELECT comment_id FROM $wpdb->comments)";
			$count = $wpdb->get_var($wcu_sql);
			break;

		case "relationships":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id=1 AND object_id NOT IN (SELECT id FROM $wpdb->posts)";
			$count = $wpdb->get_var($wcu_sql);
			break;

		case "feed":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->options WHERE option_name LIKE '_site_transient_browser_%' OR option_name LIKE '_site_transient_timeout_browser_%' OR option_name LIKE '_transient_feed_%' OR option_name LIKE '_transient_timeout_feed_%'";
			$count = $wpdb->get_var($wcu_sql);
			break;
		}

		return $count;
	}
	function wp_clean_up_optimize()
	{
		$wcu_sql = "SHOW TABLE STATUS FROM `" . DB_NAME . "`";
		$result = mysql_query($wcu_sql);

		while ($row = mysql_fetch_assoc($result)) {
			$wcu_sql = "OPTIMIZE TABLE " . $row["Name"];
			mysql_query($wcu_sql);
		}
	}

	echo "                                    >\r\n                                <textarea name=\"pure_ads_artcb\" id=\"pure_ads_artcb\" type=\"textarea\" rows=\"\">";
	echo clearval(wysafe("pure_ads_artcb"));
	echo "</textarea>\r\n                            </div>\r\n                        </li>\r\n\t\t\t</ul>\r\n\t\t</div>\t\r\n\t\t      ";
	echo "\t\t<div class=\"pure_mainbox\" id=\"pure_mainbox_5\" style=\"display:none\">\r\n\t\t\t\t<ul class=\"pure_inner\">\r\n\t\t\t\t\t<li class=\"pure_li\">\r\n<div class=\"bs-callout bs-callout-info\">\r\n                        <h4>\r\n                            清理数据库\r\n                        </h4>\r\n                        使用之前请备份数据库，以防止丢失数据\r\n\r\n\t\t\t\t\t\t</div></li>\t<li class=\"pure_li\" style=\"border:none\">\t\t\t\r\n";
	$wcu_message = "";

	if (isset($_POST["wp_clean_up_revision"])) {
		wp_clean_up("revision");
		$wcu_message = __("All revisions deleted!", "WP-Clean-Up");
	}

	if (isset($_POST["wp_clean_up_draft"])) {
		wp_clean_up("draft");
		$wcu_message = __("All drafts deleted!", "WP-Clean-Up");
	}

	if (isset($_POST["wp_clean_up_autodraft"])) {
		wp_clean_up("autodraft");
		$wcu_message = __("All autodrafts deleted!", "WP-Clean-Up");
	}

	if (isset($_POST["wp_clean_up_moderated"])) {
		wp_clean_up("moderated");
		$wcu_message = __("All moderated comments deleted!", "WP-Clean-Up");
	}

	if (isset($_POST["wp_clean_up_spam"])) {
		wp_clean_up("spam");
		$wcu_message = __("All spam comments deleted!", "WP-Clean-Up");
	}

	if (isset($_POST["wp_clean_up_trash"])) {
		wp_clean_up("trash");
		$wcu_message = __("All trash comments deleted!", "WP-Clean-Up");
	}

	if (isset($_POST["wp_clean_up_postmeta"])) {
		wp_clean_up("postmeta");
		$wcu_message = __("All orphan postmeta deleted!", "WP-Clean-Up");
	}

	if (isset($_POST["wp_clean_up_commentmeta"])) {
		wp_clean_up("commentmeta");
		$wcu_message = __("All orphan commentmeta deleted!", "WP-Clean-Up");
	}

	if (isset($_POST["wp_clean_up_relationships"])) {
		wp_clean_up("relationships");
		$wcu_message = __("All orphan relationships deleted!", "WP-Clean-Up");
	}

	if (isset($_POST["wp_clean_up_feed"])) {
		wp_clean_up("feed");
		$wcu_message = __("All dashboard transient feed deleted!", "WP-Clean-Up");
	}

	if (isset($_POST["wp_clean_up_all"])) {
		wp_clean_up("revision");
		wp_clean_up("draft");
		wp_clean_up("autodraft");
		wp_clean_up("moderated");
		wp_clean_up("spam");
		wp_clean_up("trash");
		wp_clean_up("postmeta");
		wp_clean_up("commentmeta");
		wp_clean_up("relationships");
		wp_clean_up("feed");
		$wcu_message = __("All redundant data deleted!", "WP-Clean-Up");
	}

	if (isset($_POST["wp_clean_up_optimize"])) {
		wp_clean_up_optimize();
		$wcu_message = __("Database Optimized!", "WP-Clean-Up");
	}

	if ($wcu_message != "") {
		echo "<div id=\"message\" class=\"updated fade\"><p><strong>" . $wcu_message . "</strong></p></div>";
	}

	echo "<p>\r\n<table class=\"widefat\" style=\"width:419px;\">\r\n\t<thead>\r\n\t\t<tr>\r\n\t\t\t<th scope=\"col\">";
	_e("类型", "WP-Clean-Up");
	echo "</th>\r\n\t\t\t<th scope=\"col\">";
	_e("数量", "WP-Clean-Up");
	echo "</th>\r\n\t\t\t<th scope=\"col\">";
	_e("优化", "WP-Clean-Up");
	echo "</th>\r\n\t\t</tr>\r\n\t</thead>\r\n\t<tbody id=\"the-list\">\r\n\t\t<tr class=\"alternate\">\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	_e("修订版本", "WP-Clean-Up");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	echo wp_clean_up_count("revision");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t<form action=\"\" method=\"post\">\r\n\t\t\t\t\t<input type=\"hidden\" name=\"wp_clean_up_revision\" value=\"revision\" />\r\n\t\t\t\t\t<input type=\"submit\" class=\"";

	if (0 < wp_clean_up_count("revision")) {
		echo "button-primary";
	}
	else {
		echo "button";
	}

	echo "\" value=\"";
	_e("清除", "WP-Clean-Up");
	echo "\" />\r\n\t\t\t\t</form>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	_e("草稿", "WP-Clean-Up");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	echo wp_clean_up_count("draft");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t<form action=\"\" method=\"post\">\r\n\t\t\t\t\t<input type=\"hidden\" name=\"wp_clean_up_draft\" value=\"draft\" />\r\n\t\t\t\t\t<input type=\"submit\" class=\"";

	if (0 < wp_clean_up_count("draft")) {
		echo "button-primary";
	}
	else {
		echo "button";
	}

	echo "\" value=\"";
	_e("清除", "WP-Clean-Up");
	echo "\" />\r\n\t\t\t\t</form>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr class=\"alternate\">\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	_e("自动保存草稿", "WP-Clean-Up");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	echo wp_clean_up_count("autodraft");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t<form action=\"\" method=\"post\">\r\n\t\t\t\t\t<input type=\"hidden\" name=\"wp_clean_up_autodraft\" value=\"autodraft\" />\r\n\t\t\t\t\t<input type=\"submit\" class=\"";

	if (0 < wp_clean_up_count("autodraft")) {
		echo "button-primary";
	}
	else {
		echo "button";
	}

	echo "\" value=\"";
	_e("清除", "WP-Clean-Up");
	echo "\" />\r\n\t\t\t\t</form>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	_e("审核评论", "WP-Clean-Up");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	echo wp_clean_up_count("moderated");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t<form action=\"\" method=\"post\">\r\n\t\t\t\t\t<input type=\"hidden\" name=\"wp_clean_up_moderated\" value=\"moderated\" />\r\n\t\t\t\t\t<input type=\"submit\" class=\"";

	if (0 < wp_clean_up_count("moderated")) {
		echo "button-primary";
	}
	else {
		echo "button";
	}

	echo "\" value=\"";
	_e("清除", "WP-Clean-Up");
	echo "\" />\r\n\t\t\t\t</form>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr class=\"alternate\">\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	_e("Spam评论", "WP-Clean-Up");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	echo wp_clean_up_count("spam");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t<form action=\"\" method=\"post\">\r\n\t\t\t\t\t<input type=\"hidden\" name=\"wp_clean_up_spam\" value=\"spam\" />\r\n\t\t\t\t\t<input type=\"submit\" class=\"";

	if (0 < wp_clean_up_count("spam")) {
		echo "button-primary";
	}
	else {
		echo "button";
	}

	echo "\" value=\"";
	_e("清除", "WP-Clean-Up");
	echo "\" />\r\n\t\t\t\t</form>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	_e("垃圾评论", "WP-Clean-Up");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	echo wp_clean_up_count("trash");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t<form action=\"\" method=\"post\">\r\n\t\t\t\t\t<input type=\"hidden\" name=\"wp_clean_up_trash\" value=\"trash\" />\r\n\t\t\t\t\t<input type=\"submit\" class=\"";

	if (0 < wp_clean_up_count("trash")) {
		echo "button-primary";
	}
	else {
		echo "button";
	}

	echo "\" value=\"";
	_e("清除", "WP-Clean-Up");
	echo "\" />\r\n\t\t\t\t</form>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr class=\"alternate\">\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	_e("孤立的文章元信息", "WP-Clean-Up");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	echo wp_clean_up_count("postmeta");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t<form action=\"\" method=\"post\">\r\n\t\t\t\t\t<input type=\"hidden\" name=\"wp_clean_up_postmeta\" value=\"postmeta\" />\r\n\t\t\t\t\t<input type=\"submit\" class=\"";

	if (0 < wp_clean_up_count("postmeta")) {
		echo "button-primary";
	}
	else {
		echo "button";
	}

	echo "\" value=\"";
	_e("清除", "WP-Clean-Up");
	echo "\" />\r\n\t\t\t\t</form>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	_e("孤立的评论元信息", "WP-Clean-Up");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	echo wp_clean_up_count("commentmeta");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t<form action=\"\" method=\"post\">\r\n\t\t\t\t\t<input type=\"hidden\" name=\"wp_clean_up_commentmeta\" value=\"commentmeta\" />\r\n\t\t\t\t\t<input type=\"submit\" class=\"";

	if (0 < wp_clean_up_count("commentmeta")) {
		echo "button-primary";
	}
	else {
		echo "button";
	}

	echo "\" value=\"";
	_e("清除", "WP-Clean-Up");
	echo "\" />\r\n\t\t\t\t</form>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr class=\"alternate\">\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	_e("孤立的关系信息", "WP-Clean-Up");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	echo wp_clean_up_count("relationships");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t<form action=\"\" method=\"post\">\r\n\t\t\t\t\t<input type=\"hidden\" name=\"wp_clean_up_relationships\" value=\"relationships\" />\r\n\t\t\t\t\t<input type=\"submit\" class=\"";

	if (0 < wp_clean_up_count("relationships")) {
		echo "button-primary";
	}
	else {
		echo "button";
	}

	echo "\" value=\"";
	_e("清除", "WP-Clean-Up");
	echo "\" />\r\n\t\t\t\t</form>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	_e("控制板订阅缓存", "WP-Clean-Up");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t";
	echo wp_clean_up_count("feed");
	echo "\t\t\t</td>\r\n\t\t\t<td class=\"column-name\">\r\n\t\t\t\t<form action=\"\" method=\"post\">\r\n\t\t\t\t\t<input type=\"hidden\" name=\"wp_clean_up_feed\" value=\"feed\" />\r\n\t\t\t\t\t<input type=\"submit\" class=\"";

	if (0 < wp_clean_up_count("feed")) {
		echo "button-primary";
	}
	else {
		echo "button";
	}

	echo "\" value=\"";
	_e("清除", "WP-Clean-Up");
	echo "\" />\r\n\t\t\t\t</form>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</tbody>\r\n</table>\r\n</p>\r\n<p>\r\n<form action=\"\" method=\"post\">\r\n\t<input type=\"hidden\" name=\"wp_clean_up_all\" value=\"all\" />\r\n\t<input type=\"submit\" class=\"button-primary\" value=\"";
	_e("全部清除", "WP-Clean-Up");
	echo "\" />\r\n</form>\r\n</p>\r\n<br />\r\n      \r\n\t\t\t\t\t</li>\r\n\t\t\t</ul>\r\n\t\t</div>\r\n        <div class=\"pure_mainbox\" id=\"pure_mainbox_6\" style=\"display:none\">\r\n                <ul class=\"pure_inner\">\r\n                       <li class=\"pure_li\">\r\n                        <div class=\"bs-callout bs-callout-info\">\r\n                        <h4>\r\n                            PureViper更新情况\r\n                        </h4>\r\n                        <p>\r\n                            <a href=\"http://www.wysafe.com/2015/0205/4107.html\" target=\"_blank\">点击查看</a>\r\n                        </p></div></li>\r\n                </ul>        \r\n        </div>              \r\n\t\t      ";
	echo "\t\t<div class=\"pure_mainbox\" id=\"pure_mainbox_7\" style=\"display:none\">\r\n\t\t\t\t<ul class=\"pure_inner\">\r\n\t\t\t\t\t<li class=\"pure_li\"><div class=\"bs-callout bs-callout-info\">\r\n <h4>\r\n                            PureViper模版介绍\r\n                        </h4>\r\n                        <p>\r\n                            PureViper模版是我个人独立开发完成的一款Wordpress模版，具有CMS和Blog模版双重使用的设计初衷，基于HTML5和CSS3以及Php5.4开发，现在支援Wordpress3.5以上平台。\r\n                            <br>\r\n                            PureViper主题为商业主题，出售的价格仅包括使用的商业授权和为期一个月的主题维护费用。\r\n                            <br>\r\n                            PureViper主题的设计初衷是方便大家做出自己喜爱的CMS网站，所以平台的设计更加倾向于强大的后台自定义功能。\r\n                            <br>\r\n                            主题在稳定版发布之后，将保持版本的稳定和统一，这不但是维护客户网站稳定的要求，也是对于品质的体现，在Wordpress重大新版本之日起会择日更新相应的兼容性升级。\r\n                            <br>\r\n                            Pure系列主题，本人拥有所有版权和解释权，Pure系列主题禁止任何人修改拓展后发布，违反者我就追究相应责任。\r\n                            <br>\r\n                        </p></div></li><li class=\"pure_li\">\r\n                    <div class=\"bs-callout bs-callout-info\">\r\n                        <h4>\r\n                            作者介绍\r\n                        </h4>\r\n                        <br>\r\n                        本人昵称：梦月酱\r\n                        <br>\r\n                        有任何问题，请加我的QQ与我联系：670742182\r\n                        <br>\r\n                        官网：http://www.wysafe.com 所有购买信息以及授权协议可以直接前去官网查看\r\n\t\t\t\t\t\t<br>\r\n                    </div></li><li class=\"pure_li\">\r\n                    <div class=\"bs-callout bs-callout-danger\">\r\n                        <h4>\r\n                             PureViper主题 最终用户授权协议\r\n                        </h4>\r\n                         <br>\r\n                        <p>\r\n感谢您选择PureViper主题增强您的网站，PureViper主题是目前国内最强大、最稳定的Wordpress中小型网站中文商业CMS主题，基于 PHP + MySQL 的技术开发，源代码对于商业授权客户进行开放。\r\n<br>\r\n&nbsp;\r\n<br>\r\nPureViper主题 的官方网址是： <span style=\"color: #ff0000;\">www.wysafe.com</span>\r\n<br>\r\n&nbsp;\r\n<br>\r\n为了使您正确并合法的使用本软件，请您在使用前务必阅读清楚下面的协议条款：\r\n<br>\r\n&nbsp;\r\n<br>\r\n<strong>一、本授权协议适用且仅适用于 PureViper主题 所有商业发行 版本，PureViper主题官方制作者对本授权协议拥有最终解释权。</strong>\r\n<br>\r\n&nbsp;\r\n<br>\r\n<strong>二、协议许可的权利</strong>\r\n<br>\r\n&nbsp;\r\n<br>\r\n1、您可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途，但需支付软件版权授权费用。<br>\r\n2、您可以在协议规定的约束和限制范围内修改 PureViper主题 源代码或界面风格以适应您的网站要求。<br>\r\n3、您拥有使用本软件构建的网站全部内容所有权，并独立承担与这些内容的相关法律义务。\r\n<br>\r\n4、获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持内容，即自购买时刻起30日内，在技术支持期限内拥有通过指定的方式如邮件和即时通讯获得指定范围内的技术支持服务，但考虑到安全问题等，远程协助和登录相应网站代为维护修复不在技术服务内容内，也不会提供相应的服务。商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。<br>\r\n5、获得的商业授权是当时购买的主题软件发行版本，可在主题的使用界面查看，当主题内容完善和稳定后，后期的更新将只会跟随Wordpress的重大新版本维护兼容性。<br>\r\n6、主题不会进行大规模的版面调整，如果只是您的个人需要，您可以购买商业的二次开发服务，费用根据每小时150元进行计算。<br>\r\n7、主题根据测试后的稳定程度发放，我们会对绝大多数使用功能进行兼容，但极少数功能开发者没有一定去兼容的承诺或保证。<br>\r\n\r\n\r\n\r\n<strong>三、协议规定的约束和限制</strong>\r\n\r\n<br>\r\n\r\n1、任何使用PureViper主题的用户请遵守所在地的法律条款，同时PureViper主题只是网站的主题程序并不介入任何内容的产生以及网站管理的运营，所以任何网站管理者的操作均与主题及开发者无关。<br>\r\n2、未经官方许可，不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。<br>\r\n3、不管您的网站是否整体使用 PureViper主题 ，还是部份栏目使用 PureViper主题，在您使用了 PureViper主题 的网站中均需要遵守使用条例。<br>\r\n4、未经官方许可，禁止在 Wysafe 的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。<br>\r\n5、如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应责任。<br>\r\n\r\n\r\n\r\n<strong>四、有限担保和免责声明</strong><br>\r\n\r\n\r\n\r\n1、本软件及所附带的文件属于一次性交易性质的虚拟物品，不提供任何退款服务。<br>\r\n\r\n2、用户出于自愿而使用本软件，您必须了解使用本软件的所带来的一切后果，在尚未购买独立的二次开发技术服务之前，我们不承诺对用户提供任何形式的二次开发技术支持、修改技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。<br>\r\n\r\n3、电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的效力。您一旦开始确认本协议并安装PureViper主题，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。<br>\r\n4、如果本软件带有其它软件的整合API示范例子包，这些文件版权不属于本软件官方，并且这些文件是没经过授权发布的，请参考相关软件的使用许可合法的使用。<br>\r\n\r\n\r\n\r\n<strong>版权所有 (c)2011-2015，www.wysafe.com 保留所有权利。 </strong><br>\r\n<strong>协议发布时间：2013年 By www.wysafe.com</strong>\r\n                        </p>\r\n                    </div>\t\t\t\t\t\r\n\t\t\t\t\t</li>\r\n\t\t\t</ul>\r\n\t\t</div>\t\t\t\r\n</div>\r\n<div class=\"clearfix\"></div>\r\n </div>                       \r\n\r\n\t\r\n        <div>\r\n            <div class=\"pure_desc\">\r\n                <input class=\"button-primary\" name=\"save\" type=\"submit\" value=\"保存设置\">\r\n            </div>\r\n            <input type=\"hidden\" name=\"action\" value=\"save\">\r\n        </div>\r\n    </form>\r\n</div>\t\r\n<script>\r\n\t$('.pure_mainbox:eq(0)').show();\r\n\t$('.pure_tab ul li').each(function(i) {\r\n\t\t$(this).click(function(){\r\n\t\t\t$(this).addClass('pure_tab_on').siblings().removeClass('pure_tab_on');\r\n\t\t\t$($('.pure_mainbox')[i]).show().siblings('.pure_mainbox').hide();\r\n\t\t})\r\n\t});\r\nvar aaa = []\r\njQuery('.pure_wrap input, .pure_wrap textarea').each(function(e){\r\n    if( jQuery(this).attr('id') ) aaa.push( jQuery(this).attr('id') )\r\n})\r\nconsole.log( aaa )\r\n$(document).ready(function(){\r\n\tvar rgb = $('#wpadminbar').css('background');\r\n$('.pure_wrap h2').css('background',rgb);\r\n$('.pure_desc').css('background',rgb);\r\n$('#wpwrap').css('background',rgb);\r\n$('input[type=checkbox]').tzCheckbox({labels:['Enable','Disable']});\r\n});\r\n$('.pure-radio-img-img').click(function(){\r\n\t\t$(this).parent().parent().find('.pure-radio-img-img').removeClass('pure-radio-img-selected');\r\n\t\t$(this).addClass('pure-radio-img-selected');\t\t\r\n});\r\n\t\t\r\n$('.pure-radio-img-label').hide();\r\n$('.pure-radio-img-img').show();\r\n$('.pure-radio-img-radio').hide();\r\n\r\n\r\n</script>\r\n";
}

$themename = $purename . "主题";
$options = array("pure_colorboxs_b", "pure_colorboxs", "pure_gray_b", "pure_fixheader_b", "pure_bannerpic_b", "pure_bannerpic", "pure_bannerwidth", "pure_logo_b", "pure_logo", "pure_myavatar_b", "pure_myavatar", "pure_background_b", "pure_background", "pure_tongzhi_b", "pure_tongzhi", "pure_description", "pure_keywords", "pure_beian", "pure_thumb_b", "pure_track_b", "pure_track", "pure_headcode_b", "pure_headcode", "pure_footcode_b", "pure_footcode", "pure_user_center_b", "pure_userloginurl", "pure_userregurl", "pure_usermangerurl", "pure_zhannei_b", "pure_zhannei", "pure_zhannei_url", "pure_cdn_b", "pure_cdn", "pure_cdnori", "pure_gzip_b", "pure_weiba", "pure_pingback_b", "pure_autosave_b", "pure_nocate_b", "pure_login_b", "pure_lightbox_b", "pure_default_views_b", "pure_baiping_b", "pure_jquerycdn_b", "pure_cdn_avatar_b", "pure_piclocal_b", "pure_adminmail_b", "pure_ajaxpage_b", "pure_snow_b", "pure_css3load_b", "pure_footeravatar_b", "pure_author_b", "pure_weibo_b", "pure_weibo", "pure_qzone_b", "pure_qzone", "pure_qq_b", "pure_qq", "pure_baidu_b", "pure_baidu", "pure_rss", "pure_rss_b", "pure_douban_b", "pure_douban", "pure_fastbox_b", "pure_fastbox_cloud", "pure_fastbox_bookmark", "pure_fastbox_cool", "pure_fastbox_download", "pure_fastbox_mail", "pure_fastbox_music", "pure_fastbox_video", "pure_fastbox_links", "pure_fastbox_wordpress", "pure_fastbox_wpmaster", "pure_fastbox_wpstore", "pure_ads_top_b", "pure_ads_top", "pure_ads_bottom_b", "pure_ads_bottom", "pure_ads_index_b", "pure_ads_index", "pure_ads_arttb_b", "pure_ads_arttb", "pure_ads_artrb_b", "pure_ads_artrb", "pure_ads_artcb_b", "pure_ads_artcb");
add_action("admin_menu", "mytheme_add_admin");

?>
