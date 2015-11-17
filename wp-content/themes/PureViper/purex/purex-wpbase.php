<?php

class hatmore
{
	public $pid = "";
	public $imgoldurl = array();
	public $imgnewurl = array();

	public function upload()
	{
		foreach ($this->imgoldurl as $v ) {
			$pkwall = array("user-agent" => "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0");

			if (!preg_match("/^([^'\"]+)(\.[a-z]{3,4})$\b/i", $v)) {
				$v .= ".png";
			}

			$get = wp_remote_get($v, $pkwall);
			$type = wp_remote_retrieve_header($get, "content-type");
			$mirror = wp_upload_bits(rawurldecode(basename($v)), "", wp_remote_retrieve_body($get));
			$attachment = array("post_title" => basename($v), "post_mime_type" => $type);
			$attach_id = wp_insert_attachment($attachment, $mirror["file"], $this->pid);
			$attach_data = wp_generate_attachment_metadata($attach_id, $v);
			wp_update_attachment_metadata($attach_id, $attach_data);
			set_post_thumbnail($this - pid, $attach_id);
			$this->imgnewurl[] = $mirror[url];
		}
	}
}

function pure_widgets_init()
{
	register_sidebar(array("name" => "首页CMS-上部", "id" => "home-top", "description" => __("添加的小工具会显示在首页.", "pureviper"), "before_widget" => "<div id=\"%1\$s\" class=\"homecms %2\$s clearfix\">", "after_widget" => "</div>", "before_title" => "<h3 class=\"widget-title\"><span>", "after_title" => "</span></h3>"));
	register_sidebar(array("name" => "首页CMS-下部", "id" => "home-bottom", "description" => __("添加的小工具会显示在首页.", "pureviper"), "before_widget" => "<div id=\"%1\$s\" class=\"homecms %2\$s clearfix\">", "after_widget" => "</div>", "before_title" => "<h3 class=\"widget-title\"><span>", "after_title" => "</span></h3>"));
	register_sidebar(array("name" => "侧边栏[不固定部分]", "id" => "sidebar", "description" => __("添加的小工具会显示在侧边栏.", "pureviper"), "before_widget" => "<aside id=\"%1\$s\" class=\"widget %2\$s clearfix\">", "after_widget" => "</aside>", "before_title" => "<h3 class=\"widget-title\"><span>", "after_title" => "</span></h3>"));
	register_sidebar(array("name" => "侧边栏[固定部分]", "id" => "sidebar-bottom", "description" => __("添加的小工具会显示在侧边栏而且固定.", "pureviper"), "before_widget" => "<aside id=\"%1\$s\" class=\"widget %2\$s clearfix\">", "after_widget" => "</aside>", "before_title" => "<h3 class=\"widget-title\"><span>", "after_title" => "</span></h3>"));
}

function wysafe($e)
{
	return stripslashes(get_option($e));
}

function cut_str($string, $sublen, $start = 0, $code = "UTF-8")
{
	if ($code == "UTF-8") {
		$pa = "/[\001-]|[�-�][�-�]|�[�-�][�-�]|[�-�][�-�][�-�]|�[�-�][�-�][�-�]|[�-�][�-�][�-�][�-�]/";
		preg_match_all($pa, $string, $t_string);

		if ($sublen < (count($t_string[0]) - $start)) {
			return join("", array_slice($t_string[0], $start, $sublen)) . "...";
		}

		return join("", array_slice($t_string[0], $start, $sublen));
	}
	else {
		$start = $start * 2;
		$sublen = $sublen * 2;
		$strlen = strlen($string);
		$tmpstr = "";

		for ($i = 0; $i < $strlen; $i++) {
			if (($start <= $i) && ($i < ($start + $sublen))) {
				if (129 < ord(substr($string, $i, 1))) {
					$tmpstr .= substr($string, $i, 2);
				}
				else {
					$tmpstr .= substr($string, $i, 1);
				}
			}

			if (129 < ord(substr($string, $i, 1))) {
				$i++;
			}
		}

		if (strlen($tmpstr) < $strlen) {
			$tmpstr .= "...";
		}

		return $tmpstr;
	}
}

function count_words($text)
{
	global $post;

	if ("" == $text) {
		$text = $post->post_content;

		if (mb_strlen($output, "UTF-8") < mb_strlen($text, "UTF-8")) {
			$output .= "共 " . mb_strlen(preg_replace("/\s/", "", html_entity_decode(strip_tags($post->post_content))), "UTF-8") . "字";
		}

		return $output;
	}
}

function pure_strimwidth($str, $start, $width, $trimmarker)
{
	$output = preg_replace("/^(?:[\\x00-\\x7F]|[\\xC0-\\xFF][\\x80-\\xBF]+){0," . $start . "}((?:[\\x00-\\x7F]|[\\xC0-\\xFF][\\x80-\\xBF]+){0," . $width . "}).*/s", "\1", $str);
	return $output . $trimmarker;
}

function past_date()
{
	global $post;
	$suffix = "前";
	$day = "天";
	$hour = "小时";
	$minute = "分钟";
	$second = "秒";
	$m = 60;
	$h = 3600;
	$d = 86400;
	$post_time = get_post_time("G", true, $post);
	$past_time = time() - $post_time;

	if ($past_time < $m) {
		$past_date = $past_time . $second;
	}
	else if ($past_time < $h) {
		$past_date = $past_time / $m;
		$past_date = floor($past_date);
		$past_date .= $minute;
	}
	else if ($past_time < $d) {
		$past_date = $past_time / $h;
		$past_date = floor($past_date);
		$past_date .= $hour;
	}
	else if ($past_time < ($d * 30)) {
		$past_date = $past_time / $d;
		$past_date = floor($past_date);
		$past_date .= $day;
	}
	else {
		echo get_post_time("n月j日");
		return NULL;
	}

	echo $past_date . $suffix;
}

function most_comm_posts($days = 7, $nums = 10)
{
	global $wpdb;
	$today = date("Y-m-d H:i:s");
	$daysago = date("Y-m-d H:i:s", strtotime($today) - ($days * 24 * 60 * 60));
	$result = $wpdb->get_results("SELECT comment_count, ID, post_title, post_date ,post_type FROM $wpdb->posts WHERE  post_type = 'post' AND post_date BETWEEN '$daysago' AND '$today' ORDER BY comment_count DESC LIMIT 0 , $nums");
	$output = "";

	if (empty($result)) {
		$output = "<li>None data.</li>";
	}
	else {
		foreach ($result as $topten ) {
			$postid = $topten->ID;
			$title = $topten->post_title;
			$commentcount = $topten->comment_count;

			if ($commentcount != 0) {
				$output .= "<li class=\"clearfix\"><a href=\"" . get_permalink($postid) . "\" title=\"" . $title . "\">" . $title . "</a> <span class=\"popularspan\">(" . $commentcount . ")</span></li>";
			}
		}
	}

	echo $output;
}

function feed_copyright()
{
	if (is_single() || is_feed()) {
		$custom_fields = get_post_custom_keys($post_id，，FALSE);
		$blogName = get_bloginfo("name");

		if (!in_array("copyright", $custom_fields)) {
			$content .= "<i class=\"icon-info-sign\"></i>本文为原创文章，唯一地址链接：</font><a rel=\"bookmark\" title=\"" . get_the_title() . "\" href=\"" . get_permalink() . "\" target=\"_blank\">" . get_the_title() . "</a>  转载请注明转自  <a title=\"" . $blogName . "\" href=\" " . get_bloginfo("url") . "\" target=\"_blank\">" . $blogName . "</a>";
		}
		else {
			$custom = get_post_custom($post_id，，FALSE);
			$custom_value = $custom["copyright"];
			$custom_url = $custom["copyrighturl"];
			$content .= "<i class=\"icon-info-sign\"></i>版权信息：文章转自：<a title=\"" . $custom_value[0] . "\" href=\"" . $custom_url[0] . "\" target=\"_blank\">" . $custom_value[0] . "</a>";
			$content .= "<i class=\"icon-info-sign\"></i>本文链接：<a rel=\"bookmark\" title=\"" . get_the_title() . "\" href=\"" . get_permalink() . "\" target=\"_blank\">" . wp_get_shortlink() . "</a>转载请注明出处";
		}
	}

	return $content;
}

function pure_redirect_singlepost()
{
	if (is_tag() || is_search()) {
		global $wp_query;

		if ($wp_query->post_count == 1) {
			wp_redirect(get_permalink($wp_query->posts["0"]->ID));
		}
	}
}

function pure_login_page()
{
	echo "<link rel=\"stylesheet\" href=\"" . get_bloginfo("template_directory") . "/purelogin.css\" type=\"text/css\" media=\"all\" />\n";
}

function pure_admin_bar_remove()
{
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu("wp-logo");
}

function hide_admin_bar($flag)
{
	return false;
}

function pure_author_link()
{
	return home_url("/profile");
}

function pure_seotdk()
{
	if (is_single()) {
		global $post;

		if (!empty($post->post_excerpt)) {
			$text = $post->post_excerpt;
		}
		else {
			$text = $post->post_content;
		}

		$description = trim(str_replace(array("\r\n", "\r", "\n", "　", " "), " ", str_replace("\"", "'", strip_tags($text))));
		$description = pure_strimwidth($description, 0, 220, "");

		if (!$description) {
			$description = $blog_name . "-" . trim(wp_title("", false));
		}

		$keywords = "";
		$tags = wp_get_post_tags($post->ID);

		foreach ($tags as $tag ) {
			$keywords = $keywords . $tag->name . ",";
		}

		echo "<title>";
		echo the_title();
		echo "-";
		echo bloginfo("name");
		echo "</title>";
		echo "\n";
		echo "<meta name=\"description\" content=\"";
		echo trim($description);
		echo "\" />";
		echo "\n";
		echo "\r\n<meta name=\"keywords\" content=\"";
		echo rtrim($keywords, ",");
		echo "\" />";
		echo "\n";
	}

	if (is_page()) {
		global $post;
		$keywords = get_post_meta($post->ID, "关键词", true);
		$description = get_post_meta($post->ID, "描述", true);
		echo "<title>";
		echo the_title();
		echo "-";
		echo bloginfo("name");
		echo "</title>";
		echo "\n";
		echo "<meta name=\"description\" content=\"";
		echo $description;
		echo "\" />";
		echo "\n";
		echo "<meta name=\"keywords\" content=\"";
		echo $keywords;
		echo "\" />";
		echo "\n";
	}

	if (is_category()) {
		echo "<title>";
		echo single_cat_title();
		echo "-";
		echo bloginfo("name");
		echo "</title>";
		echo "\n";
		echo "<meta name=\"description\" content=\"";
		echo category_description($categoryID);
		echo "\" />";
		echo "\n";
	}

	if (is_tag()) {
		if (function_exists("is_tag")) {
			echo "<title>";
			echo single_tag_title("", true);
			echo "|";
			echo bloginfo("name");
			echo "</title>";
			echo "\n";
		}

		echo "<meta name=\"description\" content=\"";
		echo single_tag_title();
		echo "\" />";
		echo "\n";
	}

	if (is_home()) {
		$indexkey = wysafe("pure_keywords");
		$indexdes = wysafe("pure_description");
		echo "<title>";
		echo bloginfo("name");
		echo "-";
		echo bloginfo("description");
		echo "</title>";
		echo "\n";
		echo "<meta name=\"description\" content=\"" . $indexdes . "\" />";
		echo "\n";
		echo "<meta name=\"keywords\" content=\"" . $indexkey . "\" />";
		echo "\n";
	}

	if (is_search()) {
		echo "<title>搜索结果 |  ";
		echo bloginfo("name");
		echo "</title>";
		echo "\n";
	}

	if (is_year()) {
		echo "<title>";
		echo the_time("Y年");
		echo "发布的所有文章 - ";
		echo bloginfo("name");
		echo "</title>";
		echo "\n";
	}

	if (is_month()) {
		echo "<title>";
		echo the_time("Y年n月");
		echo "发布的所有文章 - ";
		echo bloginfo("name");
		echo "</title>";
		echo "\n";
	}

	if (is_author()) {
		echo "<title>";
		echo the_author();
		echo "发表的所有文章 - ";
		echo bloginfo("name");
		echo "</title>";
		echo "\n";
	}

	if (is_404()) {
		echo "<title>404 - 暂时未找到你需要寻找的内容</title>";
		echo "\n";
	}
}

function pure_seo_wl($content)
{
	$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\1[^>]*>";

	if (preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
		if (!empty($matches)) {
			$srcUrl = get_option("siteurl");

			for ($i = 0; $i < count($matches); $i++) {
				$tag = $matches[$i][0];
				$tag2 = $matches[$i][0];
				$url = $matches[$i][0];
				$noFollow = "";
				$pattern = "/target\s*=\s*\"\s*_blank\s*\"/";
				preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);

				if (count($match) < 1) {
					$noFollow .= " target=\"_blank\" ";
				}

				$pattern = "/rel\s*=\s*\"\s*[n|d]ofollow\s*\"/";
				preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);

				if (count($match) < 1) {
					$noFollow .= " rel=\"nofollow\" ";
				}

				$pos = strpos($url, $srcUrl);

				if ($pos === false) {
					$tag = rtrim($tag, ">");
					$tag .= $noFollow . ">";
					$content = str_replace($tag2, $tag, $content);
				}
			}
		}
	}

	$content = str_replace("]]>", "]]>", $content);
	return $content;
}

function pure_comment_add_at($comment_text, $comment = "")
{
	if (0 < @$comment->comment_parent) {
		$comment_text = "@<a href=\"#comment-" . $comment->comment_parent . "\">" . get_comment_author($comment->comment_parent) . "</a> " . $comment_text;
	}

	return $comment_text;
}

function pure_remove_wp_version()
{
	return "";
}

function redirect_logged_user()
{
	if (is_user_logged_in() && (empty($_GET["action"]) || ($_GET["action"] == "login"))) {
		wp_redirect(admin_url());
		exit();
	}
}

function add_nofollow($link, $args, $comment, $post)
{
	return preg_replace("/href='(.*(\?|&)replytocom=(\d+)#respond)/", "href='#comment-\$3", $link);
}

function custom_upload_mimes($existing_mimes = array())
{
	unset($existing_mimes["css"]);
	unset($existing_mimes["js"]);
	unset($existing_mimes["php"]);
	return $existing_mimes;
}

function article_index($content)
{
	$matches = array();
	$ul_li = "";
	$r = "/<h3>([^<]+)<\/h3>/im";

	if (preg_match_all($r, $content, $matches)) {
		foreach ($matches[1] as $num => $title ) {
			$content = str_replace($matches[0][$num], "<h3><a name=\"wy-title-" . $num . "\"></a>" . $title . "</h3>", $content);
			$ul_li .= "<li><a href=\"#wy-title-" . $num . "\" target=\"_self\">" . $title . "</a></li>\n";
		}

		$content .= "\n<div id=\"wysafe-index\">\r\n                <strong>文章目录</strong>  \r\n                <ul id=\"wysafe-ul\">\n" . $ul_li . "</ul>  \r\n            </div>\n";
	}

	return $content;
}

function embed_opaque($c)
{
	$s = array("/<embed(.+?)src=\"(.+?)\"(.+?)\"/i" => "<embed\$1src=\"\$2\" wmode=\"opaque\" \$3");

	foreach ($s as $p => $r ) {
		$c = preg_replace($p, $r, $c);
	}

	return $c;
}

function pureviper()
{
	$myico = get_bloginfo("template_directory") . "/images/pureviper.png";
	echo "<a href=\"http://www.wysafe.com\" title=\"wordpress主题\" rel=\"nofollow\"><img src=\"" . $myico . "\"alt=\"wordpress主题\" /></a>";
}

function colorCloud($text)
{
	$text = preg_replace_callback("|<a (.+?)>|i", "colorCloudCallback", $text);
	return $text;
}

function colorCloudCallback($matches)
{
	$text = $matches[1];
	$color = dechex(rand(0, 16777215));
	$pattern = "/style=('|\”)(.*)('|\”)/i";
	$text = preg_replace($pattern, "style=\"color:#$color;\$2;\"", $text);
	return "<a $text>";
}

function pure_login_logo()
{
	if (wysafe("pure_dashboard_logo_b")) {
		echo "<style  type=\"text/css\"> h1 a {  background-image:url(" . wysafe("pure_logo") . ")  !important; } </style>";
	}
}

function pure_image_alt_tag($content)
{
	global $post;
	preg_match_all("/<img (.*?)\/>/", $content, $images);

	if (!is_null($images)) {
		foreach ($images[1] as $index => $value ) {
			if (!preg_match("/alt=/", $value)) {
				$new_img = str_replace("<img", "<img alt=\"" . get_the_title() . "\"", $images[0][$index]);
				$content = str_replace($images[0][$index], $new_img, $content);
			}
		}
	}

	return $content;
}

function get_post_views($post_id)
{
	$count_key = "views";
	$count = get_post_meta($post_id, $count_key, true);

	if ($count == "") {
		delete_post_meta($post_id, $count_key);
		add_post_meta($post_id, $count_key, "0");
		$count = "0";
	}

	echo number_format_i18n($count);
}

function set_post_views()
{
	global $post;
	@$post_id = $post->ID;
	$count_key = "views";
	$count = get_post_meta($post_id, $count_key, true);
	if (is_single() || is_page()) {
		if ($count == "") {
			delete_post_meta($post_id, $count_key);
			add_post_meta($post_id, $count_key, "0");
		}
		else {
			update_post_meta($post_id, $count_key, $count + 1);
		}
	}
}

function pure_add_editor_buttons($buttons)
{
	$buttons[] = "fontselect";
	$buttons[] = "fontsizeselect";
	$buttons[] = "cleanup";
	$buttons[] = "styleselect";
	$buttons[] = "hr";
	$buttons[] = "del";
	$buttons[] = "sub";
	$buttons[] = "sup";
	$buttons[] = "copy";
	$buttons[] = "paste";
	$buttons[] = "cut";
	$buttons[] = "undo";
	$buttons[] = "image";
	$buttons[] = "anchor";
	$buttons[] = "backcolor";
	$buttons[] = "wp_page";
	$buttons[] = "charmap";
	return $buttons;
}

function pure_default_views($post_ID)
{
	global $wpdb;
	$num = rand(1000, 3000);

	if (!wp_is_post_revision($post_ID)) {
		add_post_meta($post_ID, "views", $num, true);
	}
}

function pure_baiping($post_id)
{
	$baiduXML = "weblogUpdates.extendedPing" . get_option("blogname") . " " . home_url() . " " . get_permalink($post_id) . " " . get_feed_link() . " ";
	$wp_http_obj = new WP_Http();
	$return = $wp_http_obj->post("http://ping.baidu.com/ping/RPC2", array(
	"body"    => $baiduXML,
	"headers" => array("Content-Type" => "text/xml")
	));

	if (isset($return["body"])) {
		if (strstr($return["body"], "0")) {
			$noff_log = "succeeded!";
		}
		else {
			$noff_log = "failed!";
		}
	}
	else {
		$noff_log = "failed!";
	}
}

function pure_noself_ping(&$links)
{
	$home = get_option("home");

	foreach ($links as $l => $link ) {
		if (0 === strpos($link, $home)) {
			unset($links[$l]);
		}
	}
}

function pure_disable_autosave()
{
	wp_deregister_script("autosave");
}

function pure_res_from_email($email)
{
	$wp_from_email = get_option("admin_email");
	return $wp_from_email;
}

function pure_res_from_name($email)
{
	$wp_from_name = get_option("blogname");
	return $wp_from_name;
}

function pure_add_checkbox()
{
	echo "<label for=\"comment_mail_notify\" class=\"checkbox inline\" style=\"padding-top:0\"><input type=\"checkbox\" name=\"comment_mail_notify\" id=\"comment_mail_notify\" value=\"comment_mail_notify\" checked=\"checked\"/>有人回复时邮件通知我</label>";
}

function pure_ajax_comment()
{
	if ("POST" != $_SERVER["REQUEST_METHOD"]) {
		header("Allow: POST");
		header("HTTP/1.1 405 Method Not Allowed");
		header("Content-Type: text/plain");
		exit();
	}

	nocache_headers();
	$comment_post_ID = (isset($_POST["comment_post_ID"]) ? (int) $_POST["comment_post_ID"] : 0);
	$post = get_post($comment_post_ID);

	if (empty($post->comment_status)) {
		do_action("comment_id_not_found", $comment_post_ID);
		wp_die(__("Invalid comment status."));
	}

	$status = get_post_status($post);
	$status_obj = get_post_status_object($status);

	if (!comments_open($comment_post_ID)) {
		do_action("comment_closed", $comment_post_ID);
		wp_die(__("Sorry, comments are closed for this item."));
	}
	else if ("trash" == $status) {
		do_action("comment_on_trash", $comment_post_ID);
		wp_die(__("Invalid comment status."));
	}
	else {
		if (!$status_obj->public && !$status_obj->private) {
			do_action("comment_on_draft", $comment_post_ID);
			wp_die(__("Invalid comment status."));
		}
		else if (post_password_required($comment_post_ID)) {
			do_action("comment_on_password_protected", $comment_post_ID);
			wp_die(__("Password Protected."));
		}
		else {
			do_action("pre_comment_on_post", $comment_post_ID);
		}
	}

	$comment_author = (isset($_POST["author"]) ? trim(strip_tags($_POST["author"])) : NULL);
	$comment_author_email = (isset($_POST["email"]) ? trim($_POST["email"]) : NULL);
	$comment_author_url = (isset($_POST["url"]) ? trim($_POST["url"]) : NULL);
	$comment_content = (isset($_POST["comment"]) ? trim($_POST["comment"]) : NULL);
	$user = wp_get_current_user();

	if ($user->exists()) {
		if (empty($user->display_name)) {
			$user->display_name = $user->user_login;
		}

		$comment_author = wp_slash($user->display_name);
		$comment_author_email = wp_slash($user->user_email);
		$comment_author_url = wp_slash($user->user_url);

		if (!isset($user_ID)) {
			$user_ID = $user->ID;
		}

		if (current_user_can("unfiltered_html")) {
			if (wp_create_nonce("unfiltered-html-comment_" . $comment_post_ID) != $_POST["_wp_unfiltered_html_comment"]) {
				kses_remove_filters();
				kses_init_filters();
			}
		}
	}
	else {
		if (get_option("comment_registration") || ("private" == $status)) {
			wp_die(__("Sorry, you must be logged in to post a comment."));
		}
	}

	$comment_type = "";
	if (get_option("require_name_email") && !$user->exists()) {
		if ((strlen($comment_author_email) < 6) || ("" == $comment_author)) {
			wp_die(__("<strong>ERROR</strong>: please fill the required fields (name, email)."));
		}
		else if (!is_email($comment_author_email)) {
			wp_die(__("<strong>ERROR</strong>: please enter a valid email address."));
		}
	}

	if ("" == $comment_content) {
		wp_die(__("<strong>ERROR</strong>: please type a comment."));
	}

	$comment_parent = (isset($_POST["comment_parent"]) ? absint($_POST["comment_parent"]) : 0);
	$commentdata = compact("comment_post_ID", "comment_author", "comment_author_email", "comment_author_url", "comment_content", "comment_type", "comment_parent", "user_ID");
	$comment_id = wp_new_comment($commentdata);
	$comment = get_comment($comment_id);
	do_action("set_comment_cookies", $comment, $user);
	pure_comment($comment, NULL, NULL);
	exit("</li>");
}

function remove_open_sans()
{
	wp_deregister_style("open-sans");
	wp_register_style("open-sans", false);
	wp_enqueue_style("open-sans", "");
}

function pure_head_css()
{
	$styles = "";

	if (wysafe("pure_gray_b")) {
		$styles .= "html{overflow-y:scroll;filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);-webkit-filter: grayscale(100%);}";
	}

	if (wysafe("pure_headcode_b")) {
		$styles .= wysafe("pure_headcode");
	}

	if (wysafe("pure_background_b")) {
		$styles .= "@media screen and (min-width:860px){#wysafe {zoom:1;background: #fff url(\"" . wysafe("pure_background") . "\");background-size: cover;background-attachment: fixed;}#navcontent,#tuijianbox,.article-main,.widget,.snsecbar,.snnav,#footer,#pagemenu li a,.nofound,.pure_textasb a,.commentlist .comment-main,.commentlist .comment-author,.commentlist .comment-body,.pure_textasb a,#footer-comment,.column,.cmsbox,.cms-taber-ul{background: rgba(255,255,255,0.8) !important;}#show-more{background-color:#fff;padding: 10px 0;border: 1px solid #eaeaea;}.is-loading{background-color:#fff;}";
	}

	if (wysafe("pure_bannerpic_b")) {
		$styles .= "@media screen and (min-width:860px){#secnav {background: url(\"" . wysafe("pure_bannerpic") . "\") no-repeat 0 0;height:" . wysafe("pure_bannerwidth") . "px}}";
	}

	if ($styles) {
		echo "<style>" . $styles . "</style>";
	}
}

function pure_wp_head()
{
	pure_head_css();
}

function pure_get_post_thumb($post_id = false)
{
	$noTitle = ($post_id ? true : false);

	if (!$post_id) {
		$post_id = get_the_id();
	}

	if (has_post_thumbnail($post_id)) {
		return get_the_post_thumbnail($post_id, "medium", array("itemprop" => "image", "lazyload" => 1));
	}
	else {
		$cover = get_post_meta($post_id, "cover", true);

		if (!empty($cover)) {
			return "<img src=\"" . $cover . "\" itemprop=\"image\" width=\"300\" alt=\"" . ($noTitle ? "" : the_title_attribute("echo=0")) . "\" lazyload=\"1\" />";
		}
		else {
			return NULL;
		}
	}
}

function pure_lightbox_replace($content)
{
	global $post;
	$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
	$replacement = "<a\$1href=\$2\$3.\$4\$5 class=\"ilightbox\" \$6>\$7</a>";
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}

function add_image_placeholders($content)
{
	if (is_feed() || is_preview() || (function_exists("is_mobile") && is_mobile())) {
		return $content;
	}

	if (false !== strpos($content, "data-original")) {
		return $content;
	}

	$placeholder_image = apply_filters("lazyload_images_placeholder_image", get_template_directory_uri() . "/images/ajaxloader.gif");
	$content = preg_replace("#<img([^>]+?)src=['\"]?([^'\"\s>]+)['\"]?([^>]*)>#", sprintf("<img\${1}src=\"%s\" data-original=\"\${2}\"\${3}><noscript><img\${1}src=\"\${2}\"\${3}></noscript>", $placeholder_image), $content);
	return $content;
}

function pure_cache_nav_menu($args = array())
{
	static $menu_id_slugs = array();
	$defaults = array("menu" => "", "container" => "div", "container_class" => "", "container_id" => "", "menu_class" => "menu", "menu_id" => "", "echo" => true, "fallback_cb" => "wp_page_menu", "before" => "", "after" => "", "link_before" => "", "link_after" => "", "items_wrap" => "<ul id=\"%1\$s\" class=\"%2\$s\">%3\$s</ul>", "depth" => 0, "walker" => "", "theme_location" => "");
	$args = wp_parse_args($args, $defaults);
	$args = apply_filters("wp_nav_menu_args", $args);
	$args = (object) $args;
	$menu = wp_get_nav_menu_object($args->menu);
	if (!$menu && $args->theme_location && ($locations = get_nav_menu_locations()) && isset($locations[$args->theme_location])) {
		$menu = wp_get_nav_menu_object($locations[$args->theme_location]);
	}

	if (!$menu && !$args->theme_location) {
		$menus = wp_get_nav_menus();

		foreach ($menus as $menu_maybe ) {
			if ($menu_items = pure_get_nav_menu_items($menu_maybe->term_id, array("update_post_term_cache" => false))) {
				$menu = $menu_maybe;
				break;
			}
		}
	}

	if ($menu && !is_wp_error($menu) && !isset($menu_items)) {
		$menu_items = pure_get_nav_menu_items($menu->term_id, array("update_post_term_cache" => false));
	}

	if ((!$menu || is_wp_error($menu) || (isset($menu_items) && empty($menu_items) && !$args->theme_location)) && $args->fallback_cb && is_callable($args->fallback_cb)) {
		return call_user_func($args->fallback_cb, (array) $args);
	}

	if (!$menu || is_wp_error($menu) || empty($menu_items)) {
		return false;
	}

	$nav_menu = $items = "";
	$show_container = false;

	if ($args->container) {
		$allowed_tags = apply_filters("wp_nav_menu_container_allowedtags", array("div", "nav"));

		if (in_array($args->container, $allowed_tags)) {
			$show_container = true;
			$class = ($args->container_class ? " class=\"" . esc_attr($args->container_class) . "\"" : " class=\"menu-" . $menu->slug . "-container\"");
			$id = ($args->container_id ? " id=\"" . esc_attr($args->container_id) . "\"" : "");
			$nav_menu .= "<" . $args->container . $id . $class . ">";
		}
	}

	_wp_menu_item_classes_by_context($menu_items);
	$sorted_menu_items = array();

	foreach ((array) $menu_items as $key => $menu_item ) {
		$sorted_menu_items[$menu_item->menu_order] = $menu_item;
	}

	unset($menu_items);
	$sorted_menu_items = apply_filters("wp_nav_menu_objects", $sorted_menu_items, $args);
	$items .= walk_nav_menu_tree($sorted_menu_items, $args->depth, $args);
	unset($sorted_menu_items);

	if (!empty($args->menu_id)) {
		$wrap_id = $args->menu_id;
	}
	else {
		$wrap_id = "menu-" . $menu->slug;

		while (in_array($wrap_id, $menu_id_slugs)) {
			if (preg_match("#-(\d+)$#", $wrap_id, $matches)) {
				$wrap_id = preg_replace("#-(\d+)$#", "-" . ++$matches[1], $wrap_id);
			}
			else {
				$wrap_id = $wrap_id . "-1";
			}
		}
	}

	$menu_id_slugs[] = $wrap_id;
	$wrap_class = ($args->menu_class ? $args->menu_class : "");
	$items = apply_filters("wp_nav_menu_items", $items, $args);
	$items = apply_filters("wp_nav_menu_{$menu->slug}_items", $items, $args);
	$nav_menu .= sprintf($args->items_wrap, esc_attr($wrap_id), esc_attr($wrap_class), $items);
	unset($items);

	if ($show_container) {
		$nav_menu .= "</" . $args->container . ">";
	}

	$nav_menu = apply_filters("wp_nav_menu", $nav_menu, $args);

	if ($args->echo) {
		echo $nav_menu;
	}
	else {
		return $nav_menu;
	}
}

function pure_get_nav_menu_items($menu, $args = array())
{
	$menu = wp_get_nav_menu_object($menu);
	$menu_items = get_transient("pure_cache_nav_menu_" . $menu->term_id);

	if ($menu_items === false) {
		$menu_items = wp_get_nav_menu_items($menu->term_id, $args);
		set_transient("pure_cache_nav_menu_" . $menu->term_id, $menu_items, 3600);
	}

	return $menu_items;
}

function pure_topmenu()
{
	if (has_nav_menu("top-menu")) {
		wp_nav_menu(array("theme_location" => "top-menu", "items_wrap" => "%3\$s", "container" => false, "fallback_cb" => "cmp_nav_fallback", "walker" => new wp_bootstrap_navwalker(), "depth" => 2));
	}
	else {
		echo "<li><a href='" . get_bloginfo("url") . "/wp-admin/nav-menus.php'>还没有设置导航菜单</a></li>";
	}
}

function pure_secmenu()
{
	if (has_nav_menu("sec-menu")) {
		wp_nav_menu(array("theme_location" => "sec-menu", "items_wrap" => "%3\$s", "container" => false, "fallback_cb" => "cmp_nav_fallback", "walker" => new wp_bootstrap_navwalker(), "depth" => 2));
	}
	else {
		echo "<li><a href='" . get_bloginfo("url") . "/wp-admin/nav-menus.php'>还没有设置导航菜单</a></li>";
	}
}

function pure_mobimenu()
{
	if (has_nav_menu("mobi-menu")) {
		wp_nav_menu(array("theme_location" => "mobi-menu", "items_wrap" => "%3\$s", "container" => false, "fallback_cb" => "cmp_nav_fallback", "walker" => new wp_bootstrap_navwalker(), "depth" => 2));
	}
	else {
		echo "<li><a href='" . get_bloginfo("url") . "/wp-admin/nav-menus.php'>还没有设置导航菜单</a></li>";
	}
}

function pure_pagemenu()
{
	if (has_nav_menu("page-menu")) {
		wp_nav_menu(array("theme_location" => "page-menu", "items_wrap" => "%3\$s", "container" => false, "fallback_cb" => "cmp_nav_fallback", "walker" => new wp_bootstrap_navwalker(), "depth" => 2));
	}
	else {
		echo "<li><a href='" . get_bloginfo("url") . "/wp-admin/nav-menus.php'>还没有设置导航菜单</a></li>";
	}
}

function pure_usermenu()
{
	if (has_nav_menu("user-menu")) {
		wp_nav_menu(array("theme_location" => "user-menu", "items_wrap" => "%3\$s", "container" => false, "fallback_cb" => "cmp_nav_fallback", "walker" => new wp_bootstrap_navwalker(), "depth" => 2));
	}
	else {
		echo "<li><a href='" . get_bloginfo("url") . "/wp-admin/nav-menus.php'>还没有设置导航菜单</a></li>";
	}
}

function pure_index_adsense_area()
{
	echo "<div id=\"index_adsense_area\">\r\n";

	if (wysafe("pure_ads_index_b")) {
		echo wysafe("pure_ads_index");
	}

	echo "</div>\r\n";
}

function pure_list_bookmarks($args = "")
{
	$defaults = array("orderby" => "rating", "order" => "DESC", "limit" => -1, "category" => "", "exclude_category" => "", "category_name" => "", "category_orderby" => "id", "category_order" => "ASC");
	$r = wp_parse_args($args, $defaults);
	extract($r, EXTR_SKIP);
	$output = "<script>function _clickTrack(id){new Image().src=\"?open_link_id=\"+id;}</script>";
	$cats = get_terms("link_category", array("name__like" => $category_name, "include" => $category, "exclude" => $exclude_category, "orderby" => $category_orderby, "order" => $category_order, "hierarchical" => 0));

	foreach ((array) $cats as $cat ) {
		$params = array_merge($r, array("category" => $cat->term_id));
		$bookmarks = get_bookmarks($params);

		if (empty($bookmarks)) {
			continue;
		}

		$output .= "<h4 class=\"link_cate_title\">" . $cat->name . "</h4>";
		$output .= "<div id=\"link_cate_" . $cat->term_id . "\">" . pure_walk_bookmarks($bookmarks, $r) . "</div>";
	}

	return $output;
}

function pure_walk_bookmarks($bookmarks, $args = "")
{
	$output = "";

	foreach ((array) $bookmarks as $bookmark ) {
		if (!isset($bookmark->recently_updated)) {
			$bookmark->recently_updated = false;
		}

		$output .= "<span>";
		$the_link = "#";

		if (!empty($bookmark->link_url)) {
			$the_link = esc_url($bookmark->link_url);
		}

		$desc = "[" . $bookmark->link_rating . "] " . esc_attr(sanitize_bookmark_field("link_description", $bookmark->link_description, $bookmark->link_id, "display"));
		$name = esc_attr(sanitize_bookmark_field("link_name", $bookmark->link_name, $bookmark->link_id, "display"));
		$output .= "<a onclick=\"_clickTrack('$bookmark->link_id');return true;\" class=\"link_thumbs\" target=\"_blank\" style=\"background:url(http://free.pagepeeker.com/v2/thumbs.php?size=s&url=$the_link)\" href=\"$the_link\" title=\"$desc\">$name</a>";
		$output .= "</span>";
	}

	return $output;
}

function get_browsers($ua)
{
	$title = "unknow";
	$icon = "unknow";

	if (preg_match("#MSIE ([a-zA-Z0-9.]+)#i", $ua, $matches)) {
		$title = "Internet Explorer " . $matches[1];
		if ((strpos($matches[1], "7") !== false) || (strpos($matches[1], "8") !== false)) {
			$icon = "ie8";
		}
		else if (strpos($matches[1], "9") !== false) {
			$icon = "ie9";
		}
		else if (strpos($matches[1], "10") !== false) {
			$icon = "ie10";
		}
		else {
			$icon = "ie";
		}
	}
	else if (preg_match("#Firefox/([a-zA-Z0-9.]+)#i", $ua, $matches)) {
		$title = "Firefox " . $matches[1];
		$icon = "firefox";
	}
	else if (preg_match("#CriOS/([a-zA-Z0-9.]+)#i", $ua, $matches)) {
		$title = "Chrome for iOS " . $matches[1];
		$icon = "crios";
	}
	else if (preg_match("#Chrome/([a-zA-Z0-9.]+)#i", $ua, $matches)) {
		$title = "Google Chrome " . $matches[1];
		$icon = "chrome";

		if (preg_match("#OPR/([a-zA-Z0-9.]+)#i", $ua, $matches)) {
			$title = "Opera " . $matches[1];
			$icon = "opera15";

			if (preg_match("#opera mini#i", $ua)) {
				$title = "Opera Mini" . $matches[1];
			}
		}
	}
	else if (preg_match("#Safari/([a-zA-Z0-9.]+)#i", $ua, $matches)) {
		$title = "Safari " . $matches[1];
		$icon = "safari";
	}
	else if (preg_match("#Opera.(.*)Version[ /]([a-zA-Z0-9.]+)#i", $ua, $matches)) {
		$title = "Opera " . $matches[2];
		$icon = "opera";

		if (preg_match("#opera mini#i", $ua)) {
			$title = "Opera Mini" . $matches[2];
		}
	}
	else if (preg_match("#Maxthon( |\/)([a-zA-Z0-9.]+)#i", $ua, $matches)) {
		$title = "Maxthon " . $matches[2];
		$icon = "maxthon";
	}
	else if (preg_match("#360([a-zA-Z0-9.]+)#i", $ua, $matches)) {
		$title = "360 Browser " . $matches[1];
		$icon = "360se";
	}
	else if (preg_match("#SE 2([a-zA-Z0-9.]+)#i", $ua, $matches)) {
		$title = "SouGou Browser 2" . $matches[1];
		$icon = "sogou";
	}
	else if (preg_match("#UCWEB([a-zA-Z0-9.]+)#i", $ua, $matches)) {
		$title = "UCWEB " . $matches[1];
		$icon = "ucweb";
	}
	else if (preg_match("#wp-(iphone|android)/([a-zA-Z0-9.]+)#i", $ua, $matches)) {
		$title = "wordpress " . $matches[2];
		$icon = "wordpress";
	}

	return array($title, $icon);
}

function get_os($ua)
{
	$title = "unknow";
	$icon = "unknow";

	if (preg_match("/win/i", $ua)) {
		if (preg_match("/Windows NT 6.1/i", $ua)) {
			$title = "Windows 7";
			$icon = "windows_win7";
		}
		else if (preg_match("/Windows NT 5.1/i", $ua)) {
			$title = "Windows XP";
			$icon = "windows";
		}
		else if (preg_match("/Windows NT 6.2/i", $ua)) {
			$title = "Windows 8";
			$icon = "windows_win8";
		}
		else if (preg_match("/Windows NT 6.3/i", $ua)) {
			$title = "Windows 8.1";
			$icon = "windows_win8";
		}
		else if (preg_match("/Windows NT 6.0/i", $ua)) {
			$title = "Windows Vista";
			$icon = "windows_vista";
		}
		else if (preg_match("/Windows NT 5.2/i", $ua)) {
			if (preg_match("/Win64/i", $ua)) {
				$title = "Windows XP 64 bit";
			}
			else {
				$title = "Windows Server 2003";
			}

			$icon = "windows";
		}
		else if (preg_match("/Windows Phone/i", $ua)) {
			$matches = explode(";", $ua);
			$title = $matches[2];
			$icon = "windows_phone";
		}
	}
	else if (preg_match("#iPod.*.CPU.([a-zA-Z0-9.( _)]+)#i", $ua, $matches)) {
		$title = "iPod " . $matches[1];
		$icon = "iphone";
	}
	else if (preg_match("#iPhone OS ([a-zA-Z0-9.( _)]+)#i", $ua, $matches)) {
		$title = "Iphone " . $matches[1];
		$icon = "iphone";
	}
	else if (preg_match("#iPad.*.CPU.([a-zA-Z0-9.( _)]+)#i", $ua, $matches)) {
		$title = "iPad " . $matches[1];
		$icon = "ipad";
	}
	else if (preg_match("/Mac OS X.([0-9. _]+)/i", $ua, $matches)) {
		if (1 < count(explode(7, $matches[1]))) {
			$matches[1] = "Lion " . $matches[1];
		}
		else if (1 < count(explode(8, $matches[1]))) {
			$matches[1] = "Mountain Lion " . $matches[1];
		}

		$title = "Mac OSX " . $matches[1];
		$icon = "macos";
	}
	else if (preg_match("/Macintosh/i", $ua)) {
		$title = "Mac OS";
		$icon = "macos";
	}
	else if (preg_match("/CrOS/i", $ua)) {
		$title = "Google Chrome OS";
		$icon = "chrome";
	}
	else if (preg_match("/Linux/i", $ua)) {
		$title = "Linux";
		$icon = "linux";

		if (preg_match("/Android.([0-9. _]+)/i", $ua, $matches)) {
			$title = $matches[0];
			$icon = "android";
		}
		else if (preg_match("#Ubuntu#i", $ua)) {
			$title = "Ubuntu Linux";
			$icon = "ubuntu";
		}
		else if (preg_match("#Debian#i", $ua)) {
			$title = "Debian GNU/Linux";
			$icon = "debian";
		}
		else if (preg_match("#Fedora#i", $ua)) {
			$title = "Fedora Linux";
			$icon = "fedora";
		}
	}

	return array($title, $icon);
}

function get_useragent($ua)
{
	$url = get_bloginfo("template_directory") . "/images/ua/";
	$browser = get_browsers($ua);
	$os = get_os($ua);
	echo "<span class=\"ua\"><img src=\"" . $url . $browser[1] . ".png\" title=\"" . $browser[0] . "\" alt=\"" . $browser[0] . "\"><img src=\"" . $url . $os[1] . ".png\" title=\"" . $os[0] . "\" alt=\"" . $os[0] . "\"></span>";
}

function get_author_class($comment_author_email, $user_id)
{
	global $wpdb;
	$author_count = count($wpdb->get_results("SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "));

	if ($author_count < 20) {
		echo "<a class=\"vip1 vip\" title=\"评论达人 LV.1\">1</a>";
	}
	else {
		if ((20 <= $author_count) && ($author_count < 40)) {
			echo "<a class=\"vip2 vip\" title=\"评论达人 LV.2\">2</a>";
		}
		else {
			if ((40 <= $author_count) && ($author_count < 80)) {
				echo "<a class=\"vip3 vip\" title=\"评论达人 LV.3\">3</a>";
			}
			else {
				if ((80 <= $author_count) && ($author_count < 160)) {
					echo "<a class=\"vip4 vip\" title=\"评论达人 LV.4\">4</a>";
				}
				else {
					if ((160 <= $author_count) && ($author_count < 320)) {
						echo "<a class=\"vip5 vip\" title=\"评论达人 LV.5\">5</a>";
					}
					else {
						if ((320 <= $author_count) && ($author_count < 640)) {
							echo "<a class=\"vip6 vip\" title=\"评论达人 LV.6\">6</a>";
						}
						else if (640 <= $author_count) {
							echo "<a class=\"vip7 vip\" title=\"评论达人 LV.7\">7</a>";
						}
					}
				}
			}
		}
	}
}

function update_today()
{
	$args = array(
		"date_query"          => array(
			array("year" => date("Y"), "month" => date("m"), "day" => date("d"))
			),
		"ignore_sticky_posts" => 1
		);
	$postslist = get_posts($args);

	if ($postslist) {
		echo "今日更新" . count($postslist) . "篇文章。";
	}
	else {
		return false;
	}
}

function get_the_link_items($id = NULL)
{
	$bookmarks = get_bookmarks("orderby=date&category=" . $id);
	$output = "";

	if (!empty($bookmarks)) {
		$output .= "<ul class=\"link-items fontSmooth\">";

		foreach ($bookmarks as $bookmark ) {
			$output .= "<li class=\"link-item\"><a class=\"link-item-inner shake\" href=\"" . $bookmark->link_url . "\" title=\"" . $bookmark->link_description . "\" target=\"_blank\" ><img class=\"favicon\" data-original=\"" . $bookmark->link_url . "/favicon.ico\" src=\"" . get_template_directory_uri() . "/images/ajaxloader.gif\" /><span class=\"sitename\">" . $bookmark->link_name . "</span></a></li>";
		}

		$output .= "</ul>";
	}

	return $output;
}

function get_link_items()
{
	$result = "";
	$linkcats = get_terms("link_category");

	if (!empty($linkcats)) {
		foreach ($linkcats as $linkcat ) {
			$result .= "<h3 class=\"link-title\">" . $linkcat->name . "</h3>";

			if ($linkcat->description) {
				$result .= "<div class=\"link-description\">" . $linkcat->description . "</div>";
			}

			$result .= get_the_link_items($linkcat->term_id);
		}
	}
	else {
		$result = get_the_link_items();
	}

	return $result;
}

function add_my_custom_button($context)
{
	$img = "<img src=\"" . get_bloginfo("template_url") . "/purex/admin/ddm.png\" width=\"15\" height=\"15\" />添加短代码";
	$context .= "<a href=\"#\" id=\"ddm-button\" class=\"button\" title=\"短代码\" class=\"thickbox\">" . $img . "</a>";
	return $context;
}

function media_upload_for_upyun()
{
	echo "<div id=\"ddm-lay\">\r\n</div>\r\n<div id=\"ddm-box\">\r\n    <div id=\"ddm-content\" class=\"cfx\">\r\n        <ul id=\"ddm-cate\">\r\n            <li>\r\n                <a href=\"#\" class=\"current\">\r\n                    扁平化面板\r\n                </a>\r\n            </li>\r\n            <li>\r\n                <a href=\"#\">\r\n                    拟物化面板\r\n                </a>\r\n            </li>\r\n            <li>\r\n                <a href=\"#\">\r\n                    按钮\r\n                </a>\r\n            </li>\r\n            <li>\r\n                <a href=\"#\">\r\n                    视频播放\r\n                </a>\r\n            </li>\r\n        </ul>\r\n        <ul id=\"ddm-ddm\">\r\n            <li class=\"cfx current\">\r\n                <p>\r\n                    扁平化面板\r\n                </p>\r\n                <a href=\"1\">\r\n                    红色火爆面板\r\n                </a>\r\n                <a href=\"2\">\r\n                    黄色提醒面板\r\n                </a>\r\n                <a href=\"3\">\r\n                    灰色项目面板\r\n                </a>\r\n                <a href=\"4\">\r\n                    绿色购买面板\r\n                </a>\r\n                <a href=\"5\">\r\n                    粉色爱心面板\r\n                </a>\r\n                <a href=\"6\">\r\n                    紫色钥匙面板\r\n                </a>\r\n            </li>\r\n            <li class=\"cfx\">\r\n                <p>\r\n                    拟物化面板\r\n                </p>\r\n                <a href=\"7\">\r\n                    下载面板\r\n                </a>\r\n                <a href=\"8\">\r\n                    警告面板\r\n                </a>\r\n                <a href=\"9\">\r\n                    介绍面板\r\n                </a>\r\n                <a href=\"10\">\r\n                    文本面板\r\n                </a>\r\n                <a href=\"11\">\r\n                    教程面板\r\n                </a>\r\n                <a href=\"12\">\r\n                    项目面板\r\n                </a>\r\n                <a href=\"13\">\r\n                    错误面板\r\n                </a>\r\n                <a href=\"14\">\r\n                    提问面板\r\n                </a>\r\n                <a href=\"15\">\r\n                    链接面板\r\n                </a>\r\n                <a href=\"16\">\r\n                    代码面板\r\n                </a>\r\n            </li>\r\n            <li class=\"cfx\">\r\n                <a href=\"17\">\r\n                    下载按钮\r\n                </a>\r\n                <a href=\"18\">\r\n                    预览按钮\r\n                </a>        \r\n            </li>\r\n            <li class=\"cfx\">\r\n                <a href=\"19\">\r\n                    B站视频\r\n                </a>\r\n                <a href=\"20\">\r\n                    A站视频\r\n                </a>\r\n            </li>           \r\n        </ul>\r\n        <a id=\"ddm-close\" href=\"#\">\r\n            X\r\n        </a>\r\n    </div>\r\n</div>\r\n<link rel=\"stylesheet\" href=\"";
	bloginfo("template_url");
	echo "/purex/admin/ddm.css\" type=\"text/css\" media=\"all\">\r\n<script type=\"text/javascript\" src=\"";
	bloginfo("template_url");
	echo "/purex/admin/jquery.ddm.js\"></script>\r\n";
}

function firebox($atts, $content = NULL, $code = "")
{
	$return = "<div class=\"fire shortcodestyle\">";
	$return .= $content;
	$return .= "</div>";
	return $return;
}

function remindbox($atts, $content = NULL, $code = "")
{
	$return = "<div class=\"remind shortcodestyle\">";
	$return .= $content;
	$return .= "</div>";
	return $return;
}

function buybox($atts, $content = NULL, $code = "")
{
	$return = "<div class=\"buy shortcodestyle\">";
	$return .= $content;
	$return .= "</div>";
	return $return;
}

function taskbox($atts, $content = NULL, $code = "")
{
	$return = "<div class=\"task shortcodestyle\">";
	$return .= $content;
	$return .= "</div>";
	return $return;
}

function keybox($atts, $content = NULL, $code = "")
{
	$return = "<div class=\"key shortcodestyle\">";
	$return .= $content;
	$return .= "</div>";
	return $return;
}

function lovebox($atts, $content = NULL, $code = "")
{
	$return = "<div class=\"love shortcodestyle\">";
	$return .= $content;
	$return .= "</div>";
	return $return;
}

function downbox($atts, $content = NULL, $code = "")
{
	$return = "<div class='down codei'><div class='box-content'>";
	$return .= $content;
	$return .= "</div></div>";
	return $return;
}

function warningbox($atts, $content = NULL, $code = "")
{
	$return = "<div class='warning codei'><div class='box-content'>";
	$return .= $content;
	$return .= "</div></div>";
	return $return;
}

function authorbox($atts, $content = NULL, $code = "")
{
	$return = "<div class='panelauthor codei'><div class='box-content'>";
	$return .= $content;
	$return .= "</div></div>";
	return $return;
}

function textbox($atts, $content = NULL, $code = "")
{
	$return = "<div class='texticon codei'><div class='box-content'>";
	$return .= $content;
	$return .= "</div></div>";
	return $return;
}

function teachbox($atts, $content = NULL, $code = "")
{
	$return = "<div class='tutorial codei'><div class='box-content'>";
	$return .= $content;
	$return .= "</div></div>";
	return $return;
}

function projectbox($atts, $content = NULL, $code = "")
{
	$return = "<div class='project codei'><div class='box-content'>";
	$return .= $content;
	$return .= "</div></div>";
	return $return;
}

function errorbox($atts, $content = NULL, $code = "")
{
	$return = "<div class='error codei'><div class='box-content'>";
	$return .= $content;
	$return .= "</div></div>";
	return $return;
}

function questionbox($atts, $content = NULL, $code = "")
{
	$return = "<div class='question codei'><div class='box-content'>";
	$return .= $content;
	$return .= "</div></div>";
	return $return;
}

function blinkbox($atts, $content = NULL, $code = "")
{
	$return = "<div class='blink codei'><div class='box-content'>";
	$return .= $content;
	$return .= "</div></div>";
	return $return;
}

function codeebox($atts, $content = NULL, $code = "")
{
	$return = "<div class='codee codei'><div class='box-content'>";
	$return .= $content;
	$return .= "</div></div>";
	return $return;
}

function doubanplayer($atts, $content = NULL)
{
	extract(shortcode_atts(array("auto" => "0"), $atts));
	return "<embed src=\"" . get_bloginfo("template_url") . "/style/swf/doubanplayer.swf?url=" . $content . "&amp;autoplay=" . $auto . "\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" allowscriptaccess=\"always\" width=\"400\" height=\"30\">";
}

function downlink($atts, $content = NULL)
{
	extract(shortcode_atts(array("href" => "http://"), $atts));
	return "<a class=\"sc_down\" href=\"" . $href . "\" target=\"_blank\" rel=\"nofollow\"><span class=\"file_title\">" . $content . "</span><span>点击进行下载</span></a>";
}

function hrefnow($atts, $content = NULL)
{
	extract(shortcode_atts(array("href" => "http://"), $atts));
	return "<a class=\"sc_href\" href=\"" . $href . "\" target=\"_blank\" rel=\"nofollow\"><span class=\"file_title\">" . $content . "</span><span>有问题请留言</span></a>";
}

function bilibililink($atts, $content = NULL)
{
	return "<embed id=\"STK_137722048114034\" width=\"778\" height=\"400\" wmode=\"transparent\" quality=\"high\" allowfullscreen=\"true\" flashvars=\"playMovie=true&auto=1\" pluginspage=\"http://get.adobe.com/cn/flashplayer/\" allowscriptaccess=\"never\" src=\"http://static.hdslb.com/miniloader.swf?aid=" . $content . "&page=1\" type=\"application/x-shockwave-flash\" style=\"visibility: visible;\">";
}

function acfunlink($atts, $content = NULL)
{
	return "<embed id=\"STK_138508801747452\" width=\"778\" height=\"400\" wmode=\"transparent\" type=\"application/x-shockwave-flash\" src=\"http://www.acfun.tv/player/ac" . $content . "\" quality=\"high\" allowfullscreen=\"true\" flashvars=\"playMovie=true&auto=1\" pluginspage=\"http://get.adobe.com/cn/flashplayer/\" style=\"visibility: visible;\" allowscriptaccess=\"never\">";
}

function pure_newcomments($limit, $outpost, $outer)
{
	global $wpdb;
	if (!$outer || ($outer == 0)) {
		$outer = 1111111;
	}

	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved,comment_author_email, comment_type,comment_author_url, SUBSTRING(comment_content,1,100) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_post_ID!='" . $outpost . "' AND user_id!='" . $outer . "' AND comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $limit";
	$comments = $wpdb->get_results($sql);

	foreach ($comments as $comment ) {
		@$output .= "<li><a href=\"" . get_permalink($comment->ID) . "#comment-" . $comment->comment_ID . "\" title=\"" . $comment->post_title . "上的评论\">" . pure_get_the_avatar(@$user_id = $comment->user_id, $user_email = $comment->comment_author_email) . " <strong>" . $comment->comment_author . "</strong> " . pure_get_time_ago($comment->comment_date_gmt) . "说：<br>" . str_replace(" src=", " data-original=", convert_smilies(strip_tags($comment->com_excerpt))) . "</a></li>";
	}

	echo $output;
}

function pure_posts_list($orderby, $limit, $cat, $img)
{
	$args = array("order" => "DESC", "cat" => $cat, "orderby" => $orderby, "showposts" => $limit, "ignore_sticky_posts" => 1);
	query_posts($args);

	while (have_posts()) {
		the_post();
		echo "<li><a";
		echo " href=\"";
		the_permalink();
		echo "\">";

		if ($img) {
			echo "<span class=\"thumbnail\">";
			pure_thumbnail(90, 70, 1, 0);
			echo "</span>";
		}
		else {
			$img = "";
		}

		echo "<span class=\"text\">";
		the_title();
		echo "</span><span class=\"muted\">";
		the_time("Y-m-d");
		echo "</span><span class=\"muted\">";
		echo "评论(";
		echo comments_number("", "1", "%");
		echo ")";
		echo "</span></a></li>\r\n";
	}

	wp_reset_query();
}

function pure_avatar($userid, $size = "40")
{
	$userimg = get_user_meta($userid, "userapi", true);
	$username = get_user_meta($userid, "nickname", true);

	if (!$userimg) {
		$userimg = THEME_URI . "/avatar/default.jpg";
	}
	else {
		$userimg = $userimg["userimg"];
	}

	$img = "<img width=\"" . $size . "\" height=\"" . $size . "\" class=\"avatar\" src=\"" . $userimg . "\" alt=\"" . $username . "\">";
	return $img;
}

function example_remove_dashboard_widgets()
{
	global $wp_meta_boxes;
	unset($wp_meta_boxes["dashboard"]["normal"]["core"]["dashboard_incoming_links"]);
	unset($wp_meta_boxes["dashboard"]["normal"]["core"]["dashboard_plugins"]);
	unset($wp_meta_boxes["dashboard"]["side"]["core"]["dashboard_recent_drafts"]);
	unset($wp_meta_boxes["dashboard"]["side"]["core"]["dashboard_primary"]);
	unset($wp_meta_boxes["dashboard"]["side"]["core"]["dashboard_secondary"]);
	unset($wp_meta_boxes["dashboard"]["normal"]["core"]["dashboard_right_now"]);
}

function get_page_slug_link($page_name)
{
	global $wpdb;
	$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '" . $page_name . "' AND post_status = 'publish' AND post_type = 'page'");
	$pageurl = get_page_link($page_id);
	return $pageurl;
}

function selfURL()
{
	$pageURL = "http";
	$pageURL .= (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on") ? "s" : "");
	$pageURL .= "://";
	$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	return $pageURL;
}

function uc_pagenavi($range = 9)
{
	global $paged;
	global $wp_query;

	if (!$max_page) {
		$max_page = $wp_query->max_num_pages;
	}

	if (1 < $max_page) {
		if (!$paged) {
			$paged = 1;
		}

		if ($paged != 1) {
			echo "<a href='" . get_pagenum_link(1) . "' class='extend' title='跳转到首页'> 首页 </a>";
		}

		previous_posts_link(" 上一页 ");

		if ($range < $max_page) {
			if ($paged < $range) {
				for ($i = 1; $i <= $range + 1; $i++) {
					echo "<a href='" . get_pagenum_link($i) . "'";

					if ($i == $paged) {
						echo " class='current'";
					}

					echo ">$i</a>";
				}
			}
			else if (($max_page - ceil($range / 2)) <= $paged) {
				for ($i = $max_page - $range; $i <= $max_page; $i++) {
					echo "<a href='" . get_pagenum_link($i) . "'";

					if ($i == $paged) {
						echo " class='current'";
					}

					echo ">$i</a>";
				}
			}
			else {
				if (($range <= $paged) && ($paged < ($max_page - ceil($range / 2)))) {
					for ($i = $paged - ceil($range / 2); $i <= $paged + ceil($range / 2); $i++) {
						echo "<a href='" . get_pagenum_link($i) . "'";

						if ($i == $paged) {
							echo " class='current'";
						}

						echo ">$i</a>";
					}
				}
			}
		}
		else {
			for ($i = 1; $i <= $max_page; $i++) {
				echo "<a href='" . get_pagenum_link($i) . "'";

				if ($i == $paged) {
					echo " class='current'";
				}

				echo ">$i</a>";
			}
		}

		next_posts_link(" 下一页 ");

		if ($paged != $max_page) {
			echo "<a href='" . get_pagenum_link($max_page) . "' class='extend' title='跳转到最后一页'> 尾页 </a>";
		}
	}
}

function utf8_strlen($string = NULL)
{
	preg_match_all("/./us", $string, $match);
	return count($match[0]);
}

function pure_add_page($title, $slug, $page_template = "")
{
	$allPages = get_pages();
	$exists = false;

	foreach ($allPages as $page ) {
		if (strtolower($page->post_name) == strtolower($slug)) {
			$exists = true;
		}
	}

	if ($exists == false) {
		$new_page_id = wp_insert_post(array("post_title" => $title, "post_type" => "page", "post_name" => $slug, "comment_status" => "closed", "ping_status" => "closed", "post_content" => "", "post_status" => "publish", "post_author" => 1, "menu_order" => 0));
		if ($new_page_id && ($page_template != "")) {
			update_post_meta($new_page_id, "_wp_page_template", $page_template);
		}
	}
}

function pure_reg()
{
	global $wpdb;
	$userinfo = get_userdata(get_current_user_id());

	if (@$_GET["action"] == "pure_post") {
		switch ($userinfo->roles[0]) {
		case "administrator":
		case "editor":
		case "author":
		case "Super Admin":
		case "contributor":
			$post_status = "publish";
			break;

		case "subscriber":
			$post_status = "pending";
			break;
		}

		$title = strip_tags(trim($_POST["post_title"]));
		$content = stripslashes(trim($_POST["post_content"]));
		$categorys = $_POST["post_category"];
		$tags = preg_split("#\s+#", $_POST["post_tags"]);
		global $wpdb;
		$db = "SELECT post_title FROM $wpdb->posts WHERE post_title = '$title' LIMIT 1";

		if ($wpdb->get_var($db)) {
			$info = array("info" => "发现有相同标题的文章，请检查是否已经发布过或者修改标题", "status" => "n");
			echo json_encode($info);
			exit();
		}
		else {
			if (($title == "") || ($title == "请输入文章标题")) {
				$info = array("info" => "标题不能为空", "status" => "n");
				echo json_encode($info);
				exit();
			}
			else if ($content == "") {
				$info = array("info" => "内容不能为空", "status" => "n");
				echo json_encode($info);
				exit();
			}
			else {
				$submitdata = array("post_title" => $title, "post_content" => $content, "tags_input" => $tags, "post_category" => $categorys, "post_status" => $post_status);
				$post_id = wp_insert_post($submitdata);

				if (is_wp_error($post_id)) {
					echo $user_id->get_error_message();
				}
				else {
					$info = array("info" => "文章发布成功", "status" => "y", "q" => "pure", "url" => get_page_slug_link("profile"));
					echo json_encode($info);
					exit();
				}
			}
		}
	}

	if (@$_GET["action"] == "pure_info") {
		$infoname = strip_tags(trim($_POST["pure_name"]));
		$infoemail = strip_tags(trim($_POST["pure_email"]));
		$infourl = strip_tags(trim($_POST["pure_url"]));
		$infodes = strip_tags(trim($_POST["pure_des"]));

		if (140 < utf8_strlen($infodes)) {
			$info = array("info" => "描述不能超过140字", "status" => "n");
			echo json_encode($info);
			exit();
		}

		$art = array("ID" => $userinfo->ID, "display_name" => $infoname, "user_email" => $infoemail, "user_url" => $infourl, "description" => $infodes);
		$user_id = wp_update_user($art);

		if (is_wp_error($user_id)) {
			echo $user_id->get_error_message();
		}
		else {
			$info = array("info" => "资料修改成功", "status" => "y");
			echo json_encode($info);
			exit();
		}
	}

	if (@$_GET["action"] == "pure_pass") {
		$pass = strip_tags(trim($_POST["pure_pw"]));

		if (strlen($pass) < 6) {
			$info = array("info" => "密码不能小于6位", "status" => "n");
			echo json_encode($info);
			exit();
		}

		if (16 < strlen($pass)) {
			$info = array("info" => "密码不能大于16位", "status" => "n");
			echo json_encode($info);
			exit();
		}

		$user_id = wp_set_password($pass, $userinfo->ID);

		if (is_wp_error($user_id)) {
			$info = array("info" => $user_id->get_error_message(), "status" => "n");
			echo json_encode($info);
			exit();
		}
		else {
			$info = array("info" => "密码修改成功", "status" => "y");
			echo json_encode($info);
			exit();
		}
	}

	if (@$_GET["action"] == "pure") {
		if (!wp_verify_nonce($_POST["random_pass"], "pure_pass")) {
			$info = array("info" => "快！用力！", "status" => "n");
			echo json_encode($info);
			exit();
		}

		$login_name = strip_tags(trim($_POST["reg_login_name"]));
		$display_name = strip_tags(trim($_POST["reg_name"]));
		$pass = strip_tags(trim($_POST["reg_pw"]));
		$tpass = strip_tags(trim($_POST["reg_tpw"]));
		$reg_email = strip_tags(trim($_POST["reg_email"]));
		$reg_url = strip_tags(trim($_POST["reg_url"]));
		$reg_des = strip_tags(trim($_POST["reg_des"]));
		$userdata = array("ID" => "", "user_login" => $login_name, "display_name" => $display_name, "user_pass" => $pass, "user_email" => $reg_email, "user_url" => $reg_url, "description" => $reg_des, "role" => "subscriber", "first_name" => $display_name);

		if (preg_match("/[-�]/", $login_name)) {
			$info = array("info" => "登录名不能含有中文", "status" => "n");
			echo json_encode($info);
			exit();
		}

		if (strlen($pass) < 6) {
			$info = array("info" => "密码不能小于6位", "status" => "n");
			echo json_encode($info);
			exit();
		}

		if (16 < strlen($pass)) {
			$info = array("info" => "密码不能大于16位", "status" => "n");
			echo json_encode($info);
			exit();
		}

		if (140 < utf8_strlen($reg_des)) {
			$info = array("info" => "描述不能超过140字", "status" => "n");
			echo json_encode($info);
			exit();
		}

		$user_id = wp_insert_user($userdata);

		if (is_wp_error($user_id)) {
			$info = array("info" => $user_id->get_error_message(), "status" => "n");
			echo json_encode($info);
			exit();
		}
		else {
			wp_set_auth_cookie($user_id, true, false);
			$info = array("info" => "注册成功！请用新帐号登录", "status" => "y", "q" => "pure", "url" => get_page_slug_link("profile"));
			echo json_encode($info);
			exit();
		}
	}

	if (@$_POST["action"] == "comment") {
		$post_content = $_POST["con"];
		$nonce = $_POST["nonce"];
		$comment_post_ID = $_POST["postid"];
		$user_ID = get_current_user_id();
		$comment_parent = $_POST["replyid"];
		$comment_author_IP = getip();
		$comment_approved = get_option("comment_moderation");

		if (!is_user_logged_in()) {
			$info = array("info" => "请登录后再操作！", "status" => "n");
			echo json_encode($info);
			exit();
		}
		else if (!wp_verify_nonce($nonce, "pure_comment" . $comment_post_ID)) {
			$info = array("info" => "出错了 ，请稍后再试！", "status" => "n");
			echo json_encode($info);
			exit();
		}
		else if (empty($post_content)) {
			$info = array("info" => "内容不能为空！", "status" => "n");
			echo json_encode($info);
			exit();
		}
		else {
			$comment_content = preg_replace("/<[img|IMG].*?src=['|\\\"](.*?(?:[\.gif|\.jpg|\.png]))['|\\\"].*?[\/]?>/", "[img=\$1]", stripslashes($post_content));
			$commentdata = compact("comment_approved", "comment_post_ID", "comment_author_IP", "comment_content", "comment_parent", "user_ID");
			$comment_id = wp_new_comment($commentdata);

			if (is_wp_error($comment_id)) {
				$info = array("info" => $comment_id->get_error_message(), "status" => "n");
				echo json_encode($info);
				exit();
			}
			else {
				$info = array("info" => "感谢您的评论!", "status" => "y");
				echo json_encode($info);
				exit();
			}
		}
	}
}

function pure_snow()
{
	if (wysafe("pure_snow_b")) {
		echo "<div style=\"position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 999;\" class=\"snow-container\"></div>";
	}
}

function pure_smilies_src($img_src, $img, $siteurl)
{
	$img = rtrim($img, "gif");
	return THEME_URI . "/images/tieba/" . $img . "png";
}

function pure_smilies_custom_button($context)
{
	$context .= "<style>.smilies-wrap{background:#fff;border: 1px solid #ccc;box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.24);padding: 10px;position: absolute;top: 60px;width: 400px;display:none}.smilies-wrap img{height:24px;width:24px;cursor:pointer;margin-bottom:5px} .is-active.smilies-wrap{display:block}</style><a id=\"insert-media-button\" style=\"position:relative\" class=\"button insert-smilies add_smilies\" title=\"添加表情\" data-editor=\"content\" href=\"javascript:;\">\r\n<span class=\"dashicons dashicons-admin-users\"></span>\r\n添加表情\r\n</a><div class=\"smilies-wrap\">" . pure_get_wpsmiliestrans() . "</div><script>jQuery(document).ready(function(){jQuery(document).on(\"click\", \".insert-smilies\",function() { if(jQuery(\".smilies-wrap\").hasClass(\"is-active\")){jQuery(\".smilies-wrap\").removeClass(\"is-active\");}else{jQuery(\".smilies-wrap\").addClass(\"is-active\");}});jQuery(document).on(\"click\", \".add-smily\",function() { send_to_editor(\" \" + jQuery(this).data(\"smilies\") + \" \");jQuery(\".smilies-wrap\").removeClass(\"is-active\");return false;});});</script>";
	return $context;
}

function pure_get_wpsmiliestrans()
{
	global $wpsmiliestrans;
	$wpsmilies = array_unique($wpsmiliestrans);
	$output = "";

	foreach ($wpsmilies as $alt => $src_path ) {
		$src_path = rtrim($src_path, ".gif");
		$output .= "<a class=\"add-smily\" data-smilies=\"" . $alt . "\"><img class=\"wp-smiley\" src=\"" . THEME_URI . "/images/tieba/" . $src_path . ".png\" /></a>";
	}

	return $output;
}

function pure_add_smilies_to_comment_form($default)
{
	$commenter = wp_get_current_commenter();
	$default["comment_field"] .= "<p class=\"comment-form-smilies\">" . pure_get_wpsmiliestrans() . "</p>";
	return $default;
}

function wp_login_notify()
{
	date_default_timezone_set("PRC");
	$admin_email = get_bloginfo("admin_email");
	$to = $admin_email;
	$subject = "你的博客空间登录提醒";
	$message = "<p>你好！你的博客空间(" . get_option("blogname") . ")有登录！</p><p>请确定是您自己的登录，以防别人攻击！登录信息如下：</p><p>登录名：" . $_POST["log"] . "<p><p>登录密码：" . $_POST["pwd"] . "<p><p>登录时间：" . date("Y-m-d H:i:s") . "<p><p>登录IP：" . $_SERVER["REMOTE_ADDR"] . "<p>";
	$wp_email = "no-reply@" . preg_replace("#^www\.#", "", strtolower($_SERVER["SERVER_NAME"]));
	$from = "From: \"" . get_option("blogname") . "\" <$wp_email>";
	$headers = "{$from}\nContent-Type: text/html; charset=" . get_option("blog_charset") . "\n";
	wp_mail($to, $subject, $message, $headers);
}

function wp_login_failed_notify()
{
	date_default_timezone_set("PRC");
	$admin_email = get_bloginfo("admin_email");
	$to = $admin_email;
	$subject = "你的博客空间登录错误警告";
	$message = "<p>你好！你的博客空间(" . get_option("blogname") . ")有登录错误！</p><p>请确定是您自己的登录失误，以防别人攻击！登录信息如下：</p><p>登录名：" . $_POST["log"] . "<p><p>登录密码：" . $_POST["pwd"] . "<p><p>登录时间：" . date("Y-m-d H:i:s") . "<p><p>登录IP：" . $_SERVER["REMOTE_ADDR"] . "<p>";
	$wp_email = "no-reply@" . preg_replace("#^www\.#", "", strtolower($_SERVER["SERVER_NAME"]));
	$from = "From: \"" . get_option("blogname") . "\" <$wp_email>";
	$headers = "{$from}\nContent-Type: text/html; charset=" . get_option("blog_charset") . "\n";
	wp_mail($to, $subject, $message, $headers);
}

function duoshuo_avatar($avatar)
{
	$avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "gravatar.duoshuo.com", $avatar);
	return $avatar;
}

function get_cn_avatar($avatar)
{
	$avatar = preg_replace("/.*\/avatar\/(.*)\?s=([\d]+)&.*/", "<img src=\"http://cn.gravatar.com/avatar/\$1?s=\$2\" class=\"avatar avatar-\$2\" height=\"\$2\" width=\"\$2\">", $avatar);
	return $avatar;
}

function my_avatar($avatar)
{
	$tmp = strpos($avatar, "http");
	$g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
	$tmp = strpos($g, "avatar/") + 7;
	$f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);
	$e = THEME_URI . "/avatar/" . $f . ".jpg";
	$t = 604800;

	if (empty($default)) {
		$default = THEME_URI . "/avatar/default.jpg";
	}

	if (!is_file($e) || ($t < (time() - filemtime($e)))) {
		copy(htmlspecialchars_decode($g), $e);
	}
	else {
		$avatar = strtr($avatar, array($g => THEME_URI . "/avatar/" . $f . ".jpg"));
	}

	if (filesize($e) < 500) {
		copy($default, $e);
	}

	return $avatar;
}

function newbody($post_ID)
{
	$reg = "/<img[^>]+src=['\"]([^'\"]+)['\"][^>]*>/i";
	$temp1 = array();
	$temp2 = array();
	remove_action("publish_post", "newbody");
	$body = get_post($post_ID);
	preg_match_all($reg, $body->post_content, $temp1);

	if (!empty($temp1)) {
		$temp2 = array_unique($temp1[1]);
	}

	if (!empty($temp2)) {
		foreach ($temp2 as $k => $v ) {
			if (!strpos($v, $_SERVER["HTTP_HOST"]) === false) {
				unset($temp2[$k]);
			}
		}
	}

	$img = new hatmore();
	$img->pid = $post_ID;
	$img->imgoldurl = $temp2;

	if (!empty($img->imgoldurl)) {
		$img->upload();
		$tag = array_combine($img->imgoldurl, $img->imgnewurl);
		$newbody = strtr($body->post_content, $tag);
		wp_update_post(array("ID" => $post_ID, "post_content" => $newbody));
	}

	add_action("publish_post", "newbody");
}

function pure_postlike($id = NULL)
{
	$id = ($id ? $id : get_the_id());
	$done = "";
	$like_num = (get_post_meta($id, "_post_like", true) ? get_post_meta($id, "_post_like", true) : 0);

	if (isset($_COOKIE["_post_like_" . $id])) {
		$done = " done";
	}

	echo "<a href=\"javascript:;\" data-action=\"ding\" data-id=\"" . $id . "\" class=\"recommend favorite" . $done . "\"><i class=\"fa fa-heart\"></i> 赞 <span class=\"count\">" . $like_num . "</span>\r\n            </a>";
}

function pure_zancallback()
{
	global $wpdb;
	global $post;
	$id = $_POST["um_id"];
	$action = $_POST["um_action"];

	if ($action == "ding") {
		$_rating_raters = get_post_meta($id, "_post_like", true);
		$expire = time() + 99999999;
		$domain = ($_SERVER["HTTP_HOST"] != "localhost" ? $_SERVER["HTTP_HOST"] : false);
		setcookie("_post_like_" . $id, $id, $expire, "/", $domain, false);
		if (!$_rating_raters || !is_numeric($_rating_raters)) {
			update_post_meta($id, "_post_like", 1);
		}
		else {
			update_post_meta($id, "_post_like", $_rating_raters + 1);
		}

		echo get_post_meta($id, "_post_like", true);
	}

	exit();
}

function pure_add_ratings_fields($post_ID)
{
	global $wpdb;

	if (!wp_is_post_revision($post_ID)) {
		add_post_meta($post_ID, "_rating_raters", 0, true);
		add_post_meta($post_ID, "_rating_average", 0, true);
	}
}

function pure_delete_ratings_fields($post_ID)
{
	global $wpdb;

	if (!wp_is_post_revision($post_ID)) {
		delete_post_meta($post_ID, "_rating_raters");
		delete_post_meta($post_ID, "_rating_average");
	}
}

function pure_rating($post_id = NULL)
{
	global $wpdb;
	global $post;
	$out_put = "";
	if (is_null($post_id) || ($post_id == 0)) {
		$post_id = get_the_id();
	}

	$out_put .= pure_rating_custom($post_id);
	return $out_put;
}

function add_ratings_display($post_id = 0)
{
	return "<div class=\"rating-combo\" data-post-id=\"" . $post_id . "\"><a class=\"rating-toggle\" href=\"javascript:;\" rel=\"nofollow\"><i class=\"fa fa-star-half-o\"></i>评价</a><ul><li><a data-rating=\"5\" rel=\"nofollow\"><span class=\"rating-star\"><i class=\"star-5-0\"></i></span></a></li><li><a data-rating=\"4\" rel=\"nofollow\"><span class=\"rating-star\"><i class=\"star-4-0\"></i></span></a></li><li><a data-rating=\"3\" rel=\"nofollow\"><span class=\"rating-star\"><i class=\"star-3-0\"></i></span></a></li><li><a data-rating=\"2\" rel=\"nofollow\"><span class=\"rating-star\"><i class=\"star-2-0\"></i></span></a></li><li><a data-rating=\"1\" rel=\"nofollow\"><span class=\"rating-star\"><i class=\"star-1-0\"></i></span></a></li></ul></div><meta content=\"5\" itemprop=\"bestRating\"><meta content=\"1\" itemprop=\"worstRating\">";
}

function widget_rating_custom($post_id = NULL)
{
	global $wpdb;
	$out_put = "";
	$get_rating_info = pure_get_rating_info($post_id);
	$out_put .= "<div class=\"rate-holder clearfix\"><div class=\"post-rate\"><div class=\"rating-stars\" title=\"评分 " . $get_rating_info["average"] . ", 满分 5 星\" style=\"width:" . $get_rating_info["percent"] . "%\">评分 " . $get_rating_info["average"] . ", 满分 5 星</div></div><div class=\"piao\">" . $get_rating_info["raters"] . " 票</div></div>";
	return $out_put;
}

function pure_rating_custom($post_id = NULL)
{
	global $wpdb;
	$out_put = "";
	$get_rating_info = pure_get_rating_info($post_id);

	if (is_singular()) {
		$out_put .= "<div class=\"rate-holder clearfix\" itemtype=\"http://schema.org/AggregateRating\" itemscope=\"\" itemprop=\"aggregateRating\"><div class=\"post-rate\"><div class=\"rating-stars\" title=\"评分 " . $get_rating_info["average"] . ", 满分 5 星\" style=\"width:" . $get_rating_info["percent"] . "%\">评分 <span class=\"average\" itemprop=\"ratingValue\">" . $get_rating_info["average"] . "</span>, 满分 <span>5 星</span></div></div><div class=\"piao\"><span itemprop=\"ratingCount\">" . $get_rating_info["raters"] . "</span> 票</div>";
	}
	else {
		$out_put .= "<div class=\"rate-holder clearfix\"><div class=\"post-rate\"><div class=\"rating-stars\" title=\"评分 " . $get_rating_info["average"] . ", 满分 5 星\" style=\"width:" . $get_rating_info["percent"] . "%\">评分 " . $get_rating_info["average"] . ", 满分 5 星</div></div><div class=\"piao\">" . $get_rating_info["raters"] . " 票</div>";
	}

	if (!isset($_COOKIE["pure_" . $post_id]) && is_singular()) {
		$out_put .= add_ratings_display($post_id);
	}

	$out_put .= "</div>";
	return $out_put;
}

function pure_ratingnow($post_id = NULL)
{
	if (is_null($post_id) || ($post_id == 0)) {
		$post_id = get_the_id();
	}

	echo pure_rating_custom($post_id);
}

function pure_get_rating_info($post_id = NULL)
{
	if (is_null($post_id) || ($post_id == 0)) {
		$post_id = get_the_id();
	}

	global $wpdb;
	global $post;
	$_rating_raters = get_post_meta($post_id, "_rating_raters", true);
	$_rating_average = get_post_meta($post_id, "_rating_average", true);
	$out_put = array();
	if (!$_rating_raters || ($_rating_raters == "") || ($_rating_raters == 0) || !is_numeric($_rating_raters) || !$_rating_average || ($_rating_average == "") || !is_numeric($_rating_average)) {
		$out_put["raters"] = 0;
		$out_put["average"] = 0;
		$out_put["percent"] = 0;
	}
	else {
		$out_put["raters"] = $_rating_raters;
		$out_put["average"] = number_format_i18n(round($_rating_average, 2), 2);
		$rating_per = $out_put["average"] * 20;
		$out_put["percent"] = round($rating_per, 2);
	}

	$out_put["max_rates"] = 5;
	return $out_put;
}

function pure_rate()
{
	global $wpdb;
	global $post;
	$id = $_POST["um_id"];
	$scores = $_POST["um_score"];
	$expire = time() + 99999999;
	$domain = ($_SERVER["HTTP_HOST"] != "localhost" ? $_SERVER["HTTP_HOST"] : false);
	setcookie("pure_" . $id, $id, $expire, "/", $domain, false);
	$_rating_raters = get_post_meta($id, "_rating_raters", true);
	$_rating_average = get_post_meta($id, "_rating_average", true);
	if (!$_rating_raters || ($_rating_raters == "") || !is_numeric($_rating_raters)) {
		update_post_meta($id, "_rating_raters", 1);
		update_post_meta($id, "_rating_average", $scores);
	}
	else {
		if (!$_rating_average || ($_rating_average == "") || !is_numeric($_rating_average)) {
			update_post_meta($id, "_rating_raters", 1);
			update_post_meta($id, "_rating_average", $scores);
		}
		else {
			update_post_meta($id, "_rating_raters", $_rating_raters + 1);
			$new_average = round((($_rating_raters * $_rating_average) + $scores) / ($_rating_raters + 1), 3);
			update_post_meta($id, "_rating_average", $new_average);
		}
	}

	$get_rating_info = pure_get_rating_info($id);
	$data = array();
	$average = $get_rating_info["average"];
	$percent = $get_rating_info["percent"];
	$raters = $get_rating_info["raters"];
	$data = array(
		"status" => 200,
		"data"   => array("average" => $average, "percent" => $percent, "raters" => $raters)
		);
	echo json_encode($data);
	exit();
}

function ajax_index_post()
{
	$cat_id = "";
	$author = "";
	$tag = "";
	$search = "";
	$paged = @$_POST["paged"];
	$total = @$_POST["total"];
	$category = @$_POST["category"];
	$author = @$_POST["author"];
	$tag = @$_POST["tag"];
	$search = @$_POST["search"];
	$the_query = new WP_Query(array("posts_per_page" => get_option("posts_per_page"), "cat" => $category, "tag" => $tag, "author" => $author, "post_status" => "publish", "post_type" => "post", "paged" => $paged, "s" => $search));

	while ($the_query->have_posts()) {
		$the_query->the_post();
		get_template_part("loop", "scroll");
	}

	wp_reset_postdata();
	$nav = "";

	if ($category) {
		$cat_id = " data-cate=\"" . $category . "\"";
	}

	if ($author) {
		$author = " data-author=\"" . $author . "\"";
	}

	if ($tag) {
		$tag = " data-tag=\"" . $tag . "\"";
	}

	if ($search) {
		$search = " data-search=\"" . $search . "\"";
	}

	if ($paged < $total) {
		$nav = "<a id=\"show-more\" href=\"javascript:;\"" . $cat_id . $author . $search . " data-total=\"" . $total . "\" data-paged = \"" . ($paged + 1) . "\" class=\"show-more m-feed--loader\">显示更多</a>";
	}

	echo $nav;
	exit();
}

function ajax_show_more_button()
{
	$cat_id = "";
	$author = "";
	$tag = "";
	$search = "";
	global $wp_query;

	if ($GLOBALS["wp_query"]->max_num_pages < 2) {
		return NULL;
	}

	if (is_category()) {
		$cat_id = " data-cate=\"" . get_query_var("cat") . "\"";
	}

	if (is_author()) {
		$author = " data-author=\"" . get_query_var("author") . "\"";
	}

	if (is_tag()) {
		$tag = " data-tag=\"" . get_query_var("tag") . "\"";
	}

	if (is_search()) {
		$search = " data-search=\"" . get_query_var("s") . "\"";
	}

	echo "<a id=\"show-more\" href=\"javascript:;\"" . $cat_id . " data-paged = \"2\"" . $author . $tag . $search . " data-total=\"" . $GLOBALS["wp_query"]->max_num_pages . "\" class=\"show-more m-feed--loader\">显示更多</a>";
}

function pure_homeflashlists()
{
	register_widget("pure_homeflashlist");
}

function pure_home_flashlists($orderby, $limit, $cat)
{
	$args = array("cat" => $cat, "orderby" => $orderby, "showposts" => $limit, "ignore_sticky_posts" => 1);
	query_posts($args);

	while (have_posts()) {
		the_post();
		echo "<li><a href=\"";
		the_permalink();
		echo "\" title=\"";
		the_title();
		echo "\">";
		pure_thumbnail(818, 298, 1, 0);
		echo "</a></li>\r\n";
	}

	wp_reset_query();
}

function pure_homepostlists()
{
	register_widget("pure_homepostlist");
}

function pure_home_postlists($orderby, $limit, $cat)
{
	$args = array("cat" => $cat, "orderby" => $orderby, "showposts" => $limit, "ignore_sticky_posts" => 1);
	query_posts($args);

	while (have_posts()) {
		the_post();
		echo "<li>";
		pure_thumbnail(100, 55, 1);
		echo "<a href=\"";
		the_permalink();
		echo "\" title=\"";
		the_title();
		echo "\">";
		the_title();
		echo "</a></li>\r\n";
	}

	wp_reset_query();
}

function pure_theme_gzip()
{
	if (strstr($_SERVER["REQUEST_URI"], "/js/tinymce")) {
		return false;
	}

	if ((ini_get("zlib.output_compression") == "On") || (ini_get("zlib.output_compression_level") < 0) || (ini_get("output_handler") == "ob_gzhandler")) {
		return false;
	}

	if (extension_loaded("zlib") && !ob_start("ob_gzhandler")) {
		ob_start();
	}
}

function pure_get_time_ago($ptime)
{
	$ptime = strtotime($ptime);
	$etime = time() - $ptime;

	if ($etime < 1) {
		return "刚刚";
	}

	$interval = array(12 * 30 * 24 * 60 * 60 => "年前 (" . date("Y-m-d", $ptime) . ")", 30 * 24 * 60 * 60 => "个月前 (" . date("m-d", $ptime) . ")", 7 * 24 * 60 * 60 => "周前 (" . date("m-d", $ptime) . ")", 24 * 60 * 60 => "天前", 60 * 60 => "小时前", 60 => "分钟前", 1 => "秒前");

	foreach ($interval as $secs => $str ) {
		$d = $etime / $secs;

		if (1 <= $d) {
			$r = round($d);

			return $r . $str;
		}
	}
}

function pure_get_user_avatar($user_id = "")
{
	if (!$user_id) {
		return false;
	}

	$avatar = get_user_meta($user_id, "avatar");

	if ($avatar) {
		return $avatar;
	}
	else {
		return false;
	}
}

function pure_get_the_avatar($user_id = "", $user_email = "", $src = false, $size = 50)
{
	$user_avtar = pure_get_user_avatar($user_id);

	if ($user_avtar) {
		$attr = "data-src";

		if ($src) {
			$attr = "src";
		}

		return "<img class=\"avatar avatar-" . $size . " photo\" width=\"" . $size . "\" height=\"" . $size . "\" " . $attr . "=\"" . $user_avtar . "\">";
	}
	else {
		$avatar = get_avatar($user_email, $size, THEME_URI . "/avatar/default.jpg");
		return $avatar;
	}
}

function footer_newcomments($limit, $outpost, $outer)
{
	global $wpdb;
	if (!$outer || ($outer == 0)) {
		$outer = 1111111;
	}

	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved,comment_author_email, comment_type,comment_author_url, SUBSTRING(comment_content,1,100) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_post_ID!='" . $outpost . "' AND user_id!='" . $outer . "' AND comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $limit";
	$comments = $wpdb->get_results($sql);

	foreach ($comments as $comment ) {
		@$output .= "<li><a href=\"" . get_permalink($comment->ID) . "#comment-" . $comment->comment_ID . "\" title=\"" . $comment->comment_author . " - " . strip_tags($comment->com_excerpt) . "\">" . pure_get_the_avatar(@$user_id = $comment->user_id, $user_email = $comment->comment_author_email) . "</a></li>";
	}

	echo $output;
}

function pure_fooer_comment()
{
	echo "<div id=\"footer-comment\"><div class=\"ft-body\"><ul>";
	footer_newcomments(16, 1, 1);
	echo "</ul></div></div>";
}

function pure_homecmslists()
{
	register_widget("pure_homecmslist");
}

function pure_home_cmslists($orderby, $limit, $cat)
{
	$args = array("cat" => $cat, "orderby" => $orderby, "showposts" => $limit, "ignore_sticky_posts" => 1);
	query_posts($args);

	while (have_posts()) {
		the_post();
		echo "<li><a href=\"";
		the_permalink();
		echo "\" title=\"";
		the_title();
		echo "\" target=\"_blank\"><i class=\"fa fa-list-alt\"></i>";
		the_title();
		echo "</a><span><i class=\"fa fa-clock-o\"></i>";
		the_time("m-d");
		echo "</span></li>\r\n";
	}

	wp_reset_query();
}

function pure_homephotos()
{
	register_widget("pure_homephoto");
}

function pure_home_photos($orderby, $limit, $cat)
{
	$args = array("cat" => $cat, "orderby" => $orderby, "showposts" => $limit, "ignore_sticky_posts" => 1);
	query_posts($args);
	$i = 1;

	while (have_posts()) {
		the_post();
		echo "<div class=\"cms_photo cmp-";
		echo $i;
		echo "\"><div class=\"cmp-image\">";
		pure_thumbnail(220, 220, 1);
		echo "</div><div class=\"cmp-info\"><div class=\"cmpi-title\">";
		the_title();
		echo "</div><div class=\"cmpi-time\"><i class=\"fa fa-paper-plane\"></i> ";
		echo get_the_time("Y-m-d");
		echo "</div></div><a class=\"cmp-a\" href=\"";
		the_permalink();
		echo "\" rel=\"nofollow\" target=\"_blank\"></a></div>\r\n";
		$i++;
	}

	wp_reset_query();
}

function pure_homecmtlists()
{
	register_widget("pure_homecmtlist");
}

function pure_home_cmtlists($orderby, $limit, $cat)
{
	$args = array("cat" => $cat, "orderby" => $orderby, "showposts" => $limit, "ignore_sticky_posts" => 1);
	query_posts($args);

	while (have_posts()) {
		the_post();
		echo "<li><a href=\"";
		the_permalink();
		echo "\" title=\"";
		the_title();
		echo "\" target=\"_blank\"><i class=\"fa fa-chevron-right\"></i>";
		the_title();
		echo "</a></li>\r\n";
	}

	wp_reset_query();
}

function pure_webapp()
{
	echo "\r\n<!-- Set render engine for 360 browser -->\r\n<meta name=\"renderer\" content=\"webkit\">\r\n<!-- No Baidu Siteapp-->\r\n<meta http-equiv=\"Cache-Control\" content=\"no-transform\"/>\r\n<meta http-equiv=\"Cache-Control\" content=\"no-siteapp\"/>\r\n<link rel=\"icon\" type=\"image/png\" href=\"" . THEME_URI . "/images/app/favicon.png\">";
	echo "\r\n<!-- Add to homescreen for Chrome on Android -->\r\n<meta name=\"mobile-web-app-capable\" content=\"yes\">\r\n<link rel=\"icon\" sizes=\"192x192\" href=\"" . THEME_URI . "/images/app/app-icon72x72@2x.png\">";
	echo "\r\n<!-- Add to homescreen for Safari on iOS -->\r\n<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">\r\n<meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black\">";
	echo "\r\n<meta name=\"apple-mobile-web-app-title\" content=\"";
	echo bloginfo("name");
	echo "\"/>";
	echo "\n";
	echo "<link rel=\"apple-touch-icon-precomposed\" href=\"" . THEME_URI . "/images/app/app-icon72x72@2x.png\">";
	echo "<link rel=\"apple-touch-startup-image\" media=\"(device-width: 320px) and (-webkit-device-pixel-ratio: 2)\" href=\"" . THEME_URI . "/images/app/startup-640x1096.png\">\r\n<!-- Tile icon for Win8 (144x144 + tile color) -->\r\n<meta name=\"msapplication-TileImage\" content=\"" . THEME_URI . "/images/app/app-icon72x72@2x.png\">\r\n<meta name=\"msapplication-TileColor\" content=\"#61b3e6\">\r\n<!-- DNS -->\r\n<link href=\"http://cdn.staticfile.org/\" rel=\"dns-prefetch\">";
}

remove_action("wp_head", "wp_generator");
remove_action("wp_head", "wlwmanifest_link");
remove_action("wp_head", "rsd_link");
remove_action("wp_head", "adjacent_posts_rel_link_wp_head", 10, 0);
remove_action("wp_head", "feed_links", 2);
remove_action("wp_head", "feed_links_extra", 3);
remove_action("wp_head", "wp_shortlink_wp_head", 10, 0);
add_filter("pre_option_link_manager_enabled", "__return_true");

if (function_exists("register_nav_menus")) {
	register_nav_menus(array("top-menu" => __("顶部导航"), "sec-menu" => __("主导航"), "mobi-menu" => __("手机导航"), "page-menu" => __("页面侧边导航"), "user-menu" => __("用户侧边导航")));
}

add_action("widgets_init", "pure_widgets_init");
add_filter("past_date", "past_date");
add_action("template_redirect", "pure_redirect_singlepost");
add_action("login_enqueue_scripts", "pure_login_page");
add_action("wp_before_admin_bar_render", "pure_admin_bar_remove", 0);
add_filter("show_admin_bar", "hide_admin_bar");
add_filter("author_link", "pure_author_link");
add_filter("the_content", "pure_seo_wl");
add_filter("comment_text", "pure_comment_add_at", 20, 2);
add_filter("the_generator", "pure_remove_wp_version");
add_action("login_init", "redirect_logged_user");
add_filter("comment_reply_link", "add_nofollow", 420, 4);
add_filter("upload_mimes", "custom_upload_mimes");
if (is_admin() && (!defined("DOING_AJAX") || !DOING_AJAX)) {
	$current_user = wp_get_current_user();

	if ($current_user->roles[0] == get_option("default_role")) {
		wp_safe_redirect(home_url());
		exit();
	}
}

add_filter("the_content", "article_index");
add_filter("the_content", "embed_opaque");
add_filter("wp_tag_cloud", "colorCloud", 1);
add_action("login_head", "pure_login_logo");
add_action("get_header", "set_post_views");
add_filter("mce_buttons_3", "pure_add_editor_buttons");

if (wysafe("pure_default_views_b")) {
	add_action("publish_post", "pure_default_views");
}

if (wysafe("pure_baiping_b")) {
	add_action("publish_post", "pure_baiping");
}

if (!function_exists("pure_paging")) {
	function pure_paging()
	{
		$p = 4;

		if (is_singular()) {
			return NULL;
		}

		global $wp_query;
		global $paged;
		$max_page = $wp_query->max_num_pages;

		if ($max_page == 1) {
			return NULL;
		}

		echo "<div class=\"pagination\"><ul>";

		if (empty($paged)) {
			$paged = 1;
		}

		echo "<li class=\"prev-page\">";
		previous_posts_link("上一页");
		echo "</li>";

		if (($p + 1) < $paged) {
			p_link(1, "<li>第一页</li>");
		}

		if (($p + 2) < $paged) {
			echo "<li><span>···</span></li>";
		}

		for ($i = $paged - $p; $i <= $paged + $p; $i++) {
			if ((0 < $i) && ($i <= $max_page)) {
				$i == $paged ? print("<li class=\"active\"><span>$i</span></li>") : p_link($i);
			}
		}

		if ($paged < ($max_page - $p - 1)) {
			echo "<li><span> ... </span></li>";
		}

		echo "<li class=\"next-page\">";
		next_posts_link("下一页");
		echo "</li>";
		echo "</ul></div>";
	}
	function p_link($i, $title = "")
	{
		if ($title == "") {
			$title = "第 $i 页";
		}

		echo "<li><a href='";
		echo esc_html(get_pagenum_link($i));
		echo "'>$i</a></li>";
	}
}

if (wysafe("pure_pingback_b")) {
	add_action("pre_ping", "pure_noself_ping");
}

if (wysafe("pure_autosave_b")) {
	add_action("wp_print_scripts", "pure_disable_autosave");
	remove_action("pre_post_update", "wp_save_post_revision");
}

add_action("wp_ajax_pure_ajax_comment", "pure_ajax_comment");
add_action("wp_ajax_nopriv_pure_ajax_comment", "pure_ajax_comment");
add_action("init", "remove_open_sans");

if (!function_exists("pure_comment")) {
	function pure_comment($comment, $args, $depth)
	{
		$GLOBALS["comment"] = $comment;
		global $commentcount;

		if (!$commentcount) {
			$page = get_query_var("cpage") - 1;
			$cpp = get_option("comments_per_page");
			$commentcount = $cpp * $page;
		}

		switch ($comment->comment_type) {
		case "pingback":
		case "trackback":
			echo "\t<li class=\"pingback\">\r\n\t\t<p>Pingback: ";
			comment_author_link();
			echo "</p>\r\n\t";
			break;

		default:
			echo "\t<li ";
			comment_class();
			echo " id=\"li-comment-";
			comment_id();
			echo "\">\r\n\t\t<div id=\"comment-";
			comment_id();
			echo "\" class=\"comment-body\">\r\n\r\n\t\t\t<div class=\"comment-author vcard\">\r\n        <div class=\"comment-avatar\">\r\n\t\t\t\t";
			$avatar = get_avatar($comment, !$comment->comment_parent ? 100 : 100);
			$avatar = str_replace(array("src=", "avatar avatar-"), array("src=\"" . get_template_directory_uri() . "/images/ajaxloader.gif\" data-original=", "lazy avatar avatar-"), $avatar);
			echo $avatar;
			echo "        </div>\r\n\t\t\t\t<div class=\"comment-info\">\r\n          <a id=\"commentauthor-";
			comment_id();
			echo "\" class=\"commentauthor\" href=\"";
			comment_author_url();
			echo "\" rel=\"external nofollow\" target=\"_blank\">";
			echo $comment->comment_author;
			echo "</a>\r\n          ";
			get_author_class($comment->comment_author_email, $comment->user_id);
			echo " \r\n        </div>\r\n\r\n\t\t\t</div>\r\n      <div class=\"comment-main\">\r\n\t\t\t<div class=\"comment-content\">";
			comment_text();
			echo "</div>\r\n      <div class=\"comment-floor\"><!-- 主评论楼层号 -->\r\n      ";

			if (!$parent_id = $comment->comment_parent) {
				printf("#%1\$s楼", ++$commentcount);
			}

			echo "<!-- 当前页每个主评论自动+1 -->\r\n      </div>\r\n\t\t\t";
			if (($comment->comment_approved != "0") && ($args != NULL) && ($depth != NULL)) {
				echo "\t\t\t<footer class=\"comment-footer\">\r\n        <div class=\"comment-state\">\r\n          ";

				if ($comment->comment_approved == "0") {
					echo "            <em class=\"comment-awaiting-moderation\">初次评论需要等待审核</em>\r\n          ";
				}
				else {
					echo "            <time>\r\n            ";

					if ((current_time("timestamp") - get_comment_time("U")) < 2592000) {
						echo human_time_diff(get_comment_time("U"), current_time("timestamp")) . "前";
					}
					else {
						echo comment_time("Y-n-j H:i");
					}

					echo "            </time>\r\n            ";
					get_useragent($comment->comment_agent);
					echo "          ";
				}

				echo "          \r\n        </div>\r\n\t\t\t\t";
				comment_reply_link(array_merge($args, array("depth" => $depth, "max_depth" => $args["max_depth"])));
				echo "\t\t\t\t";

				if (function_exists("mailtocommenter_button")) {
					mailtocommenter_button();
				}

				echo "        <div class=\"comment-sign\">\r\n          ";
				echo wysafe("pure_weiba");
				echo "        </div>\r\n\t\t\t\t";
				edit_comment_link();
				echo "\t\t\t</footer>\r\n\t\t\t";
			}

			echo "      </div>\r\n\t\t</div>\r\n\r\n\t";
			break;
		}
	}
}

add_action("wp_head", "pure_wp_head");

if (!function_exists("wpex_mce_buttons")) {
	function wpex_mce_buttons($buttons)
	{
		array_unshift($buttons, "fontselect");
		array_unshift($buttons, "fontsizeselect");
		return $buttons;
	}
}

add_filter("mce_buttons_2", "wpex_mce_buttons");

if (!function_exists("wpex_mce_text_sizes")) {
	function wpex_mce_text_sizes($initArray)
	{
		$initArray["fontsize_formats"] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}
}

add_filter("tiny_mce_before_init", "wpex_mce_text_sizes");
add_image_size("thumbnail", 400, 200, true);
add_theme_support("post-thumbnails");

if (!function_exists("pure_thumbnail")) {
	function pure_thumbnail($width = 400, $height = 200, $echo = 1, $lazyload = 1)
	{
		global $post;
		$title = $post->post_title;
		$dir = get_bloginfo("template_directory");
		$post_img = "";

		if (has_post_thumbnail()) {
			$timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full");
			$src = $timthumb_src[0];

			if (wysafe("pure_cdn_b")) {
				$post_img_src = "$src?imageView2/1/w/$width/h/$height/q/70";
			}
			else if (wysafe("pure_thumb_b")) {
				$post_img_src = THEME_URI . "/timthumb.php&#63;src=$src&#38;w=$width&#38;h=$height&#38;zc=1&#38;q=100";
			}
			else {
				$post_img_src = $src;
			}
		}
		else {
			ob_start();
			ob_end_clean();
			$output = preg_match_all("/\<img.+?src=\"(.+?)\".*?\/>/is", $post->post_content, $matches, PREG_SET_ORDER);
			$cnt = count($matches);

			if (0 < $cnt) {
				$src = $matches[0][1];
			}
			else {
				$mad = rand(1, 5);
				$src = "$dir/images/thumb/thumbnail$mad.jpg";
			}

			if (wysafe("pure_cdn_b")) {
				$post_img_src = "$src?imageView2/1/w/$width/h/$height/q/70";
			}
			else if (wysafe("pure_thumb_b")) {
				$post_img_src = THEME_URI . "/timthumb.php&#63;src=$src&#38;w=$width&#38;h=$height&#38;zc=1&#38;q=100";
			}
			else {
				$post_img_src = $src;
			}
		}

		$lazyloadimg = THEME_URI . "/images/ajaxloader.gif";

		if ($lazyload == 1) {
			$post_img = "<img data-original='$post_img_src' src='$lazyloadimg' alt='$title' width='$width' height='$height' /><noscript><img src='$post_img_src' alt='$title' width='$width' height='$height' /></noscript>";
		}
		else {
			$post_img = "<img src='$post_img_src' alt='$title' width='$width' height='$height' />";
		}

		if ($echo == 1) {
			echo $post_img;
		}
		else {
			return $post_img;
		}
	}
}

if (wysafe("pure_lightbox_b")) {
	add_filter("the_content", "pure_lightbox_replace");
}
class wp_bootstrap_navwalker extends Walker_Nav_Menu
{
	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
	{
		global $wp_query;
		$indent = ($depth ? str_repeat("\t", $depth) : "");

		if (strcasecmp($item->title, "divider") == 0) {
			$output .= $indent . "<li class=\"divider\">";
		}
		else if (strcasecmp($item->title, "nav-header") == 0) {
			$output .= $indent . "<li class=\"nav-header\">" . esc_attr($item->attr_title);
		}
		else {
			$class_names = $value = "";
			$classes = (empty($item->classes) ? array() : (array) $item->classes);
			$classes[] = ($item->current ? "active" : "");
			$classes[] = "menu-item-" . $item->ID;
			$class_names = join(" ", apply_filters("nav_menu_css_class", array_filter($classes), $item, $args));
			if ($args->has_children && ($depth === 0)) {
				$class_names .= " submenu";
			}

			$class_names = ($class_names ? " class=\"" . esc_attr($class_names) . "\"" : "");
			$id = apply_filters("nav_menu_item_id", "menu-item-" . $item->ID, $item, $args);
			$id = ($id ? " id=\"" . esc_attr($id) . "\"" : "");
			$output .= $indent . "<li" . $id . $value . $class_names . ">";
			$attributes = (!empty($item->target) ? " target=\"" . esc_attr($item->target) . "\"" : "");
			$attributes .= (!empty($item->xfn) ? " rel=\"" . esc_attr($item->xfn) . "\"" : "");
			$attributes .= (!empty($item->url) ? " href=\"" . esc_attr($item->url) . "\"" : "");
			$attributes .= (!empty($item->description) ? " title=\"" . esc_attr($item->description) . "\"" : "");
			$item_output = $args->before;

			if (!empty($item->attr_title)) {
				$item_output .= "<a" . $attributes . "><i class=\"" . esc_attr($item->attr_title) . "\"></i>";
			}
			else {
				$item_output .= "<a" . $attributes . ">";
			}

			$item_output .= $args->link_before . apply_filters("the_title", $item->title, $item->ID) . $args->link_after;
			$item_output .= ($args->has_children && ($depth == 0) ? " <span class=\"sign\"></span></a>" : "</a>");
			$item_output .= $args->after;
			$output .= apply_filters("walker_nav_menu_start_el", $item_output, $item, $depth, $args);
		}
	}

	public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
	{
		if (!$element) {
			return NULL;
		}

		$id_field = $this->db_fields["id"];

		if (is_array($args[0])) {
			$args[0]["has_children"] = !empty($children_elements[$element->$id_field]);
		}
		else if (is_object($args[0])) {
			$args[0]->has_children = !empty($children_elements[$element->$id_field]);
		}

		$cb_args = array_merge(array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, "start_el"), $cb_args);
		$id = $element->$id_field;
		if ((($max_depth == 0) || (($depth + 1) < $max_depth)) && isset($children_elements[$id])) {
			foreach ($children_elements[$id] as $child ) {
				if (!isset($newlevel)) {
					$newlevel = true;
					$cb_args = array_merge(array(&$output, $depth), $args);
					call_user_func_array(array(&$this, "start_lvl"), $cb_args);
				}

				$this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
			}

			unset($children_elements[$id]);
		}

		if (isset($newlevel) && $newlevel) {
			$cb_args = array_merge(array(&$output, $depth), $args);
			call_user_func_array(array(&$this, "end_lvl"), $cb_args);
		}

		$cb_args = array_merge(array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, "end_el"), $cb_args);
	}
}

class pure_RandomLinks extends WP_Widget
{
	public function __construct()
	{
		parent::__construct("pure_randomlinks", "[侧边栏]友情链接", array("description" => "随机显示" . __("Your blogroll"), "classname" => "widget_links"));
	}

	public function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);
		$onlyhome = (isset($instance["onlyhome"]) ? $instance["onlyhome"] : 0);
		$category = (isset($instance["category"]) ? $instance["category"] : false);
		$title = apply_filters("widget_title", empty($instance["title"]) ? "随机链接" : $instance["title"], $instance, $this->id_base);
		$limit = (isset($instance["limit"]) ? $instance["limit"] : 30);
		$target = (isset($instance["newwin"]) ? "" : " target=\"_blank\"");
		if (!$onlyhome || ($onlyhome && is_home())) {
			echo $before_widget;
			echo $before_title . "<i class=\"fa fa-link\"></i>" . $title . $after_title;
			echo "<ul class=\"xoxo blogroll\">";
			wp_list_bookmarks(apply_filters("widget_links_args", "title_li=&categorize=0&orderby=rand&category=" . $instance["category"] . "&limit=" . $instance["limit"]));
			echo apply_filters("widget_text", empty($instance["addto"]) ? "" : $instance["addto"], $instance);
			echo "</ul>";
			echo $after_widget;
		}
	}

	public function update($new_instance, $old_instance)
	{
		$new_instance = (array) $new_instance;
		$instance = array("title" => "", "category" => false, "limit" => 30, "onlyhome" => false, "addto" => "");
		$instance["title"] = strip_tags($new_instance["title"]);
		$instance["category"] = intval($new_instance["category"]);
		$instance["limit"] = (!empty($new_instance["limit"]) ? intval($new_instance["limit"]) : 30);
		$instance["onlyhome"] = (isset($new_instance["onlyhome"]) ? 1 : 0);
		$instance["addto"] = $new_instance["addto"];
		return $instance;
	}

	public function form($instance)
	{
		$instance = wp_parse_args((array) $instance, array("title" => "", "category" => false, "limit" => 30, "onlyhome" => false, "addto" => ""));
		$title = strip_tags($instance["title"]);
		$addto = esc_textarea($instance["addto"]);

		if (!$limit = intval($instance["limit"])) {
			$limit = 30;
		}

		$link_cats = get_terms("link_category");
		echo "    <p><label for=\"";
		echo $this->get_field_id("title");
		echo "\">";
		_e("Title:");
		echo "</label>\r\n    <input class=\"widefat\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $title;
		echo "\" /></p>\r\n    \r\n    <p><label for=\"";
		echo $this->get_field_id("category");
		echo "\">";
		_e("Select Link Category:");
		echo "</label>\r\n    <select class=\"widefat\" id=\"";
		echo $this->get_field_id("category");
		echo "\" name=\"";
		echo $this->get_field_name("category");
		echo "\"></p>\r\n    \r\n    <p><option value=\"\">所有链接</option>\r\n    ";

		foreach ($link_cats as $link_cat ) {
			echo "<option value=\"" . intval($link_cat->term_id) . "\"" . selected($instance["category"], $link_cat->term_id, false) . ">" . $link_cat->name . "</option>\n";
		}

		echo "    </select></p>\r\n    \r\n    <p><label for=\"";
		echo $this->get_field_id("limit");
		echo "\">";
		_e("Number of links to show:");
		echo "</label>\r\n    <input id=\"";
		echo $this->get_field_id("limit");
		echo "\" name=\"";
		echo $this->get_field_name("limit");
		echo "\" type=\"text\" value=\"";
		echo $limit == 10 ? "" : intval($limit);
		echo "\" size=\"3\" /></p>\r\n\r\n    <p><label for=\"";
		echo $this->get_field_id("addto");
		echo "\">追加链接：</label>\r\n    <textarea class=\"widefat\" rows=\"6\" cols=\"20\" id=\"";
		echo $this->get_field_id("addto");
		echo "\" name=\"";
		echo $this->get_field_name("addto");
		echo "\">";
		echo $addto;
		echo "</textarea>\r\n    <small>链接格式：</small><br /><code>&lt;li&gt;&lt;a href=&quot;地址&quot;&gt;名称&lt;/a&gt;&lt;/li&gt;</code></p>\r\n    \r\n    <p><input class=\"checkbox\" type=\"checkbox\" ";
		checked($instance["onlyhome"], true);
		echo " id=\"";
		echo $this->get_field_id("onlyhome");
		echo "\" name=\"";
		echo $this->get_field_name("onlyhome");
		echo "\" />\r\n    <label for=\"";
		echo $this->get_field_id("onlyhome");
		echo "\">仅在首页显示</label></p>\r\n";
	}
}

class pure_MailSubscription extends WP_Widget
{
	public function __construct()
	{
		parent::__construct("pure_mailsubscription", "[侧边栏]邮件订阅", array("description" => "QQ邮件列表订阅工具"));
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = (!empty($instance["title"]) ? $instance["title"] : "邮件订阅");
		$title = apply_filters("widget_title", $title, $instance, $this->id_base);
		$nid = (empty($instance["nid"]) ? "" : $instance["nid"]);
		$info = (empty($instance["info"]) ? "订阅精彩内容" : $instance["info"]);
		$placeholder = (empty($instance["placeholder"]) ? "your@email.com" : $instance["placeholder"]);
		$output = $before_widget;

		if ($title) {
			$output .= $before_title . $title . $after_title;
		}

		$output .= "<form action=\"http://list.qq.com/cgi-bin/qf_compose_send\" target=\"_blank\" method=\"post\"><h3 class=\"info\">" . $info . "</h3><input type=\"hidden\" name=\"t\" value=\"qf_booked_feedback\" /><input type=\"hidden\" name=\"id\" value=\"" . $nid . "\" /><input type=\"email\" name=\"to\" class=\"rsstxt\" placeholder=\"" . $placeholder . "\" value=\"\" required /><input type=\"submit\" class=\"rssbutton\" value=\"订阅\" /></form>";
		$output .= $after_widget;
		echo $output;
	}

	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance["title"] = strip_tags($new_instance["title"]);
		$instance["nid"] = strip_tags($new_instance["nid"]);
		$instance["info"] = strip_tags($new_instance["info"]);
		$instance["placeholder"] = strip_tags($new_instance["placeholder"]);
		return $instance;
	}

	public function form($instance)
	{
		$title = (isset($instance["title"]) ? esc_attr($instance["title"]) : "");
		$nid = esc_attr($instance["nid"]);
		$info = esc_attr($instance["info"]);
		$placeholder = esc_attr($instance["placeholder"]);
		echo "    <p><label for=\"";
		echo $this->get_field_id("title");
		echo "\">";
		_e("Title:");
		echo "</label>\r\n    <input class=\"widefat\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $title;
		echo "\" /></p>\r\n\r\n    <p><label for=\"";
		echo $this->get_field_id("nid");
		echo "\">nId：</label>\r\n    <input class=\"widefat\" id=\"";
		echo $this->get_field_id("nid");
		echo "\" name=\"";
		echo $this->get_field_name("nid");
		echo "\" type=\"text\" value=\"";
		echo $nid;
		echo "\" /></p>\r\n    \r\n    <p><label for=\"";
		echo $this->get_field_id("info");
		echo "\">提示文字：</label>\r\n    <input class=\"widefat\" id=\"";
		echo $this->get_field_id("info");
		echo "\" name=\"";
		echo $this->get_field_name("info");
		echo "\" type=\"text\" value=\"";
		echo $info;
		echo "\" /></p>\r\n    \r\n    <p><label for=\"";
		echo $this->get_field_id("placeholder");
		echo "\">占位文字：</label>\r\n    <input class=\"widefat\" id=\"";
		echo $this->get_field_id("placeholder");
		echo "\" name=\"";
		echo $this->get_field_name("placeholder");
		echo "\" type=\"text\" value=\"";
		echo $placeholder;
		echo "\" /></p>\r\n    \r\n    <p class=\"description\">本工具基于 <a href=\"http://list.qq.com/\" target=\"_blank\">QQ邮件列表</a> 服务。</p>\r\n\r\n";
	}
}

class pure_Ad extends WP_Widget
{
	public function __construct()
	{
		parent::__construct("pure_ad", "[侧边栏]图片广告", array("description" => "广告位，显示图片广告。"));
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_title", empty($instance["title"]) ? "" : $instance["title"], $instance, $this->id_base);
		$code = apply_filters("widget_text", empty($instance["code"]) ? "" : $instance["code"], $instance);
		$mo = "";
		echo $before_widget;
		echo $before_title . "<i class=\"fa fa-magic\"></i>" . $mo . $title . $after_title;
		echo "<div class=\"wads\">" . $code . "</>";
		echo $after_widget;
	}

	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance["title"] = strip_tags($new_instance["title"]);

		if (current_user_can("unfiltered_html")) {
			$instance["code"] = $new_instance["code"];
		}
		else {
			$instance["code"] = stripslashes(wp_filter_post_kses(addslashes($new_instance["code"])));
		}

		return $instance;
	}

	public function form($instance)
	{
		$instance = wp_parse_args((array) $instance, array("title" => "", "code" => ""));
		$title = strip_tags($instance["title"]);
		$code = esc_textarea($instance["code"]);
		echo "    <p><label for=\"";
		echo $this->get_field_id("title");
		echo "\">";
		_e("Title:");
		echo "</label>\r\n    <input class=\"widefat\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo esc_attr($title);
		echo "\" /></p>\r\n\r\n    <p><label for=\"";
		echo $this->get_field_id("code");
		echo "\">代码：</label>\r\n    <textarea class=\"widefat\" rows=\"16\" cols=\"20\" id=\"";
		echo $this->get_field_id("code");
		echo "\" name=\"";
		echo $this->get_field_name("code");
		echo "\">";
		echo $code;
		echo "</textarea>\r\n    <small>推荐广告尺寸：250 x 250 - 方形</small></p>\r\n";
	}
}

class pure_tag extends WP_Widget
{
	public function pure_tag()
	{
		$control_ops = "";
		$widget_ops = array("classname" => "widget_tag", "description" => "显示热门标签");
		$this->WP_Widget("pure_tag", "[侧边栏]标签云", $widget_ops, $control_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_name", $instance["title"]);
		$count = $instance["count"];
		$offset = $instance["offset"];
		$more = $instance["more"];
		$link = $instance["link"];
		$mo = "";
		if (($more != "") && ($link != "")) {
			$mo = "<a class=\"btn btn-primary\" href=\"" . $link . "\">" . $more . "</a>";
		}

		echo $before_widget;
		echo $before_title . "<i class=\"fa fa-tags\"></i>" . $mo . $title . $after_title;
		echo "<div class=\"widget_tags\"><ul class=\"widget_tags_inner\">";
		$tags_list = get_tags("orderby=count&order=DESC&number=" . $count . "&offset=" . $offset);

		if ($tags_list) {
			foreach ($tags_list as $tag ) {
				echo "<li><a href=\"" . get_tag_link($tag) . "\" data-original-title=\"" . $tag->count . "个话题\">" . $tag->name . "</a></li>";
			}
		}
		else {
			echo "<li><a>暂无标签！</a></li>";
		}

		echo "</ul></div>";
		echo $after_widget;
	}

	public function form($instance)
	{
		echo "    <p>\r\n      <label>\r\n        名称：\r\n        <input id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $instance["title"];
		echo "\" class=\"widefat\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        显示数量：\r\n        <input id=\"";
		echo $this->get_field_id("count");
		echo "\" name=\"";
		echo $this->get_field_name("count");
		echo "\" type=\"number\" value=\"";
		echo $instance["count"];
		echo "\" class=\"widefat\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        去除前几个：\r\n        <input id=\"";
		echo $this->get_field_id("offset");
		echo "\" name=\"";
		echo $this->get_field_name("offset");
		echo "\" type=\"number\" value=\"";
		echo $instance["offset"];
		echo "\" class=\"widefat\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        More 显示文字：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("more");
		echo "\" name=\"";
		echo $this->get_field_name("more");
		echo "\" type=\"text\" value=\"";
		echo $instance["more"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        More 链接：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("link");
		echo "\" name=\"";
		echo $this->get_field_name("link");
		echo "\" type=\"url\" value=\"";
		echo $instance["link"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n";
	}
}

class pure_comments extends WP_Widget
{
	public function pure_comments()
	{
		$widget_ops = array("classname" => "pure_comments", "description" => "显示网友最新评论。");
		$this->WP_Widget("pure_comments", "[侧边栏]最新评论", $widget_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_name", $instance["title"]);
		$limit = $instance["limit"];
		$outer = $instance["outer"];
		$outpost = @$instance["outpost"];
		echo $before_widget;
		echo $before_title . "<i class=\"fa fa-comments\"></i>" . $title . $after_title;
		echo "<ul>";
		echo pure_newcomments($limit, $outpost, $outer);
		echo "</ul>";
		echo $after_widget;
	}

	public function form($instance)
	{
		$defaults = array("title" => "最新评论", "limit" => 8, "outer" => "1");
		$instance = wp_parse_args((array) $instance, $defaults);
		echo "\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t标题：\r\n\t\t\t\t<input class=\"widefat\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $instance["title"];
		echo "\" />\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t显示数目：\r\n\t\t\t\t<input class=\"widefat\" id=\"";
		echo $this->get_field_id("limit");
		echo "\" name=\"";
		echo $this->get_field_name("limit");
		echo "\" type=\"number\" value=\"";
		echo $instance["limit"];
		echo "\" />\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t排除某用户ID：\r\n\t\t\t\t<input class=\"widefat\" id=\"";
		echo $this->get_field_id("outer");
		echo "\" name=\"";
		echo $this->get_field_name("outer");
		echo "\" type=\"number\" value=\"";
		echo $instance["outer"];
		echo "\" />\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t排除某文章ID：\r\n\t\t\t\t<input class=\"widefat\" id=\"";
		echo $this->get_field_id("outpost");
		echo "\" name=\"";
		echo $this->get_field_name("outpost");
		echo "\" type=\"number\" value=\"";
		echo $instance["outpost"];
		echo "\" />\r\n\t\t\t</label>\r\n\t\t</p>\r\n\r\n";
	}
}

class pure_posts extends WP_Widget
{
	public function pure_posts()
	{
		$widget_ops = array("classname" => "pure_posts", "description" => "图文展示，在侧边栏显示你需要展示的文章内容。");
		$this->WP_Widget("pure_posts", "[侧边栏]文章聚合", $widget_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_name", $instance["title"]);
		$limit = $instance["limit"];
		$cat = @$instance["cat"];
		$orderby = $instance["orderby"];
		$img = @$instance["img"];
		$style = "";

		if (!$img) {
			$style = " class=\"nopic\"";
		}

		echo $before_widget;
		echo $before_title . "<i class=\"fa fa-database\"></i>" . $title . $after_title;
		echo "<ul" . $style . ">";
		echo pure_posts_list($orderby, $limit, $cat, $img);
		echo "</ul>";
		echo $after_widget;
	}

	public function form($instance)
	{
		$defaults = array("title" => "热门文章", "limit" => 6, "orderby" => "comment_count", "img" => "");
		$instance = wp_parse_args((array) $instance, $defaults);
		echo "\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t标题：\r\n\t\t\t\t<input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $instance["title"];
		echo "\" />\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t排序：\r\n\t\t\t\t<select style=\"width:100%;\" id=\"";
		echo $this->get_field_id("orderby");
		echo "\" name=\"";
		echo $this->get_field_name("orderby");
		echo "\" style=\"width:100%;\">\r\n\t\t\t\t\t<option value=\"comment_count\" ";
		selected("comment_count", $instance["orderby"]);
		echo ">评论数</option>\r\n\t\t\t\t\t<option value=\"date\" ";
		selected("date", $instance["orderby"]);
		echo ">发布时间</option>\r\n\t\t\t\t\t<option value=\"rand\" ";
		selected("rand", $instance["orderby"]);
		echo ">随机</option>\r\n\t\t\t\t</select>\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t分类限制：\r\n\t\t\t\t<a style=\"font-weight:bold;color:#f60;text-decoration:none;\" href=\"javascript:;\" title=\"格式：1,2 &nbsp;表限制ID为1,2分类的文章&#13;格式：-1,-2 &nbsp;表排除分类ID为1,2的文章&#13;也可直接写1或者-1；注意逗号须是英文的\">？</a>\r\n\t\t\t\t<input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("cat");
		echo "\" name=\"";
		echo $this->get_field_name("cat");
		echo "\" type=\"text\" value=\"";
		echo @$instance["cat"];
		echo "\" size=\"24\" />\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t显示数目：\r\n\t\t\t\t<input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("limit");
		echo "\" name=\"";
		echo $this->get_field_name("limit");
		echo "\" type=\"number\" value=\"";
		echo $instance["limit"];
		echo "\" size=\"24\" />\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t<input style=\"vertical-align:-3px;margin-right:4px;\" class=\"checkbox\" type=\"checkbox\" ";
		checked($instance["img"], "on");
		echo " id=\"";
		echo $this->get_field_id("img");
		echo "\" name=\"";
		echo $this->get_field_name("img");
		echo "\">显示图片\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t\r\n\t";
	}
}

class pure_widget_tabber extends WP_Widget
{
	public function pure_widget_tabber()
	{
		$widget_ops = array("classname" => "pure_widget_tabber", "description" => "可切换展示最新文章，近期热评，热门标签。");
		$this->WP_Widget("pure_widget_tabber", "[侧边栏]可切换挂件", $widget_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		echo $before_widget;
		echo "          <div id=\"sidebar-tab\"> \r\n          <div id=\"tab-title\"> \r\n          <h4><span class=\"selected\">博主信息</span><span>最新文章</span><span>近期热评</span><span>热门标签</span></h4> \r\n          </div> \r\n          <div id=\"tab-content\"> \r\n          <ul>\r\n        ";

		if (wysafe("pure_myavatar_b")) {
			echo "        <a href=\"";
			bloginfo("url");
			echo "\" title=\"\"><img class=\"avatar\" src=\"";
			echo wysafe("pure_myavatar");
			echo "\" width=\"100px\" height=\"100px\" /></a>\r\n        ";
		}
		else {
			echo "      \r\n        <a href=\"";
			bloginfo("url");
			echo "\" title=\"\"><img class=\"avatar\" src=\"";
			bloginfo("template_directory");
			echo "/images/avatar.gif\" width=\"100px\" height=\"100px\" /></a>\r\n        ";
		}

		echo "  \r\n          <p><i class=\"fa fa-child\"></i>";
		the_author_meta("description");
		echo "</p>\r\n          <p><i class=\"fa fa-bell\"></i>";

		if (wysafe("pure_tongzhi_b")) {
			echo wysafe("pure_tongzhi");
		}
		else {
			echo "欢迎来到我的博客做客,如果你想和我交流,可以给我留言哦!";
		}

		echo "</p>\r\n          </ul>\r\n          <ul class=\"hide pure_posts\">";
		echo pure_posts_list("date", "3", "", "1");
		echo "</ul> \r\n          <ul class=\"hide pure_comments\">";
		echo pure_newcomments("3", "", "");
		echo "</ul> \r\n          <ul class=\"hide pure_widget_tags\">";
		wp_tag_cloud("number=15");
		echo "</ul> \r\n          </div> \r\n          </div> \r\n              ";
		echo $after_widget;
		echo "        ";
	}

	public function update($new_instance, $old_instance)
	{
		return $new_instance;
	}

	public function form($instance)
	{
		$title = esc_attr(@$instance["title"]);
		echo "            <p><label for=\"";
		echo $this->get_field_id("title");
		echo "\">";
		_e("Title:");
		echo " <input class=\"widefat\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $title;
		echo "\" /></label></p>\r\n        ";
	}
}

class pure_widget_google extends WP_Widget
{
	public function pure_widget_google()
	{
		$widget_ops = array("classname" => "pure_widget_google", "description" => "通过谷歌搜索站内文章。");
		$this->WP_Widget("pure_widget_google", "[侧边栏]谷歌搜索", $widget_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_name", $instance["title"]);
		echo $before_widget;
		echo $before_title . "<i class=\"fa fa-terminal\"></i>" . $title . $after_title;
		echo "<ul class=\"googlesearch\">";
		echo "<form class=\"site-search-form\" onsubmit=\"return dispatch()\"\">\r\n    <input id=\"gurl\" class=\"search_input\" name=\"q\" type=\"text\" placeholder=\"输入关键字搜索\" value>\r\n    <button class=\"search_button\" type=\"submit\"><i class=\"fa fa-search\"></i></button>\r\n    </form>";
		echo "</ul>";
		echo $after_widget;
	}

	public function update($new_instance, $old_instance)
	{
		return $new_instance;
	}

	public function form($instance)
	{
		$title = esc_attr(@$instance["title"]);
		echo "            <p><label for=\"";
		echo $this->get_field_id("title");
		echo "\">";
		_e("Title:");
		echo " <input class=\"widefat\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $title;
		echo "\" /></label></p>\r\n        ";
	}
}

class pure_statistics extends WP_Widget
{
	public function pure_statistics()
	{
		$widget_ops = array("classname" => "pure_statistics", "description" => "显示网站统计信息，展示网站具体访问情况。");
		$this->WP_Widget("pure_statistics", "[侧边栏]网站统计", $widget_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_name", $instance["title"]);
		$code = @$instance["code"];
		echo $before_widget;
		echo $before_title . "<i class=\"fa fa-dashboard\"></i>" . $title . $after_title;
		echo "<ul>";
		global $wpdb;

		if ($instance["post"]) {
			$count_posts = wp_count_posts();
			echo "<li><strong>日志总数：</strong>" . $count_posts->publish . "</li>";
		}

		if ($instance["comment"]) {
			$comments = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");
			echo "<li><strong>评论总数：</strong>" . $comments . "</li>";
		}

		if ($instance["tag"]) {
			echo "<li><strong>标签总数：</strong>" . wp_count_terms("post_tag") . "</li>";
		}

		if ($instance["page"]) {
			$count_pages = wp_count_posts("page");
			echo "<li><strong>页面总数：</strong>" . $count_pages->publish . "</li>";
		}

		if ($instance["cat"]) {
			echo "<li><strong>分类总数：</strong>" . wp_count_terms("category") . "</li>";
		}

		if ($instance["link"]) {
			$links = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links WHERE link_visible = 'Y'");
			echo "<li><strong>链接总数：</strong>" . $links . "</li>";
		}

		if ($instance["user"]) {
			$users = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
			echo "<li><strong>用户总数：</strong>" . $users . "</li>";
		}

		if ($instance["last"]) {
			$last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");
			$last = date("Y-m-d", strtotime($last[0]->MAX_m));
			echo "<li><strong>最后更新：</strong>" . $last . "</li>";
		}

		echo "</ul>";
		echo $after_widget;
	}

	public function form($instance)
	{
		$defaults = array("title" => "网站统计", "post" => "", "comment" => "", "tag" => "", "page" => "", "cat" => "", "link" => "", "user" => "", "last" => "");
		$instance = wp_parse_args((array) $instance, $defaults);
		echo "\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t标题：\r\n\t\t\t\t<input id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $instance["title"];
		echo "\" class=\"widefat\" />\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t<input style=\"vertical-align:-3px;margin-right:4px;\" class=\"checkbox\" type=\"checkbox\" ";
		checked($instance["post"], "on");
		echo " id=\"";
		echo $this->get_field_id("post");
		echo "\" name=\"";
		echo $this->get_field_name("post");
		echo "\">显示日志总数\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t<input style=\"vertical-align:-3px;margin-right:4px;\" class=\"checkbox\" type=\"checkbox\" ";
		checked($instance["comment"], "on");
		echo " id=\"";
		echo $this->get_field_id("comment");
		echo "\" name=\"";
		echo $this->get_field_name("comment");
		echo "\">显示评论总数\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t<input style=\"vertical-align:-3px;margin-right:4px;\" class=\"checkbox\" type=\"checkbox\" ";
		checked($instance["tag"], "on");
		echo " id=\"";
		echo $this->get_field_id("tag");
		echo "\" name=\"";
		echo $this->get_field_name("tag");
		echo "\">显示标签总数\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t<input style=\"vertical-align:-3px;margin-right:4px;\" class=\"checkbox\" type=\"checkbox\" ";
		checked($instance["page"], "on");
		echo " id=\"";
		echo $this->get_field_id("page");
		echo "\" name=\"";
		echo $this->get_field_name("page");
		echo "\">显示页面总数\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t<input style=\"vertical-align:-3px;margin-right:4px;\" class=\"checkbox\" type=\"checkbox\" ";
		checked($instance["cat"], "on");
		echo " id=\"";
		echo $this->get_field_id("cat");
		echo "\" name=\"";
		echo $this->get_field_name("cat");
		echo "\">显示分类总数\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t<input style=\"vertical-align:-3px;margin-right:4px;\" class=\"checkbox\" type=\"checkbox\" ";
		checked(@$instance["link"], "on");
		echo " id=\"";
		echo $this->get_field_id("link");
		echo "\" name=\"";
		echo $this->get_field_name("link");
		echo "\">显示链接总数\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t<input style=\"vertical-align:-3px;margin-right:4px;\" class=\"checkbox\" type=\"checkbox\" ";
		checked($instance["user"], "on");
		echo " id=\"";
		echo $this->get_field_id("user");
		echo "\" name=\"";
		echo $this->get_field_name("user");
		echo "\">显示用户总数\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t<input style=\"vertical-align:-3px;margin-right:4px;\" class=\"checkbox\" type=\"checkbox\" ";
		checked($instance["last"], "on");
		echo " id=\"";
		echo $this->get_field_id("last");
		echo "\" name=\"";
		echo $this->get_field_name("last");
		echo "\">显示最后更新\r\n\t\t\t</label>\r\n\t\t</p>\r\n";
	}
}

class pure_textads extends WP_Widget
{
	public function pure_textads()
	{
		$widget_ops = array("classname" => "pure_textasb", "description" => "如果没有什么图片可以展示，可以考虑使用文字广告。");
		$this->WP_Widget("pure_textads", "[侧边栏]文字广告", $widget_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_name", $instance["title"]);
		$tag = $instance["tag"];
		$content = $instance["content"];
		$link = $instance["link"];
		$blank = @$instance["blank"];
		$lank = "";

		if ($blank) {
			$lank = " target=\"_blank\"";
		}

		echo $before_widget;
		echo $before_title . "<i class=\"fa fa-life-ring\"></i>" . $tag . $after_title;
		echo "<a class=\"\" href=\"" . $link . "\"" . $lank . ">";
		echo "<h2>" . $title . "</h2>";
		echo "<p>" . $content . "</p>";
		echo "</a>";
		echo $after_widget;
	}

	public function form($instance)
	{
		$defaults = array("title" => "PureViper主题", "tag" => "值得买的WP主题", "content" => "如果你还没有购买本主题，那么希望你尝试一下这样独特的选择...", "link" => "http://www.wysafe.com/", "style" => "style02");
		$instance = wp_parse_args((array) $instance, $defaults);
		echo "\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t名称：\r\n\t\t\t\t<input id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $instance["title"];
		echo "\" class=\"widefat\" />\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t描述：\r\n\t\t\t\t<textarea id=\"";
		echo $this->get_field_id("content");
		echo "\" name=\"";
		echo $this->get_field_name("content");
		echo "\" class=\"widefat\" rows=\"3\">";
		echo $instance["content"];
		echo "</textarea>\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t标签：\r\n\t\t\t\t<input id=\"";
		echo $this->get_field_id("tag");
		echo "\" name=\"";
		echo $this->get_field_name("tag");
		echo "\" type=\"text\" value=\"";
		echo $instance["tag"];
		echo "\" class=\"widefat\" />\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t链接：\r\n\t\t\t\t<input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("link");
		echo "\" name=\"";
		echo $this->get_field_name("link");
		echo "\" type=\"url\" value=\"";
		echo $instance["link"];
		checked(@$instance["blank"], "on");
		echo "\" class=\"widefat\" />\r\n\t\t\t</label>\r\n\t\t</p>\r\n\t\t<p>\r\n\t\t\t<label>\r\n\t\t\t\t新打开浏览器窗口：\r\n\t\t\t\t<input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("blank");
		echo "\" name=\"";
		echo $this->get_field_name("blank");
		echo "\">\r\n\t\t\t</label>\r\n\t\t</p>\r\n";
	}
}


add_filter("the_content", "add_image_placeholders", 99);
add_action("media_buttons_context", "add_my_custom_button");
add_action("media_buttons_context", "add_my_custom_button");
add_action("admin_footer", "media_upload_for_upyun");
add_shortcode("fire", "firebox");
add_shortcode("remind", "remindbox");
add_shortcode("buy", "buybox");
add_shortcode("task", "taskbox");
add_shortcode("key", "keybox");
add_shortcode("love", "lovebox");
add_shortcode("down", "downbox");
add_shortcode("warning", "warningbox");
add_shortcode("author", "authorbox");
add_shortcode("text", "textbox");
add_shortcode("tutorial", "teachbox");
add_shortcode("project", "projectbox");
add_shortcode("error", "errorbox");
add_shortcode("question", "questionbox");
add_shortcode("blink", "blinkbox");
add_shortcode("codee", "codeebox");
add_shortcode("music", "doubanplayer");
add_shortcode("Downlink", "downlink");
add_shortcode("HrefNow", "hrefnow");
add_shortcode("bilibili", "bilibililink");
add_shortcode("acfun", "acfunlink");
add_action("widgets_init", create_function("", "return register_widget(\"pure_RandomLinks\");"));
add_action("widgets_init", create_function("", "return register_widget(\"pure_MailSubscription\");"));
add_action("widgets_init", create_function("", "return register_widget(\"pure_Ad\");"));
add_action("widgets_init", create_function("", "return register_widget(\"pure_tag\");"));
add_action("widgets_init", create_function("", "return register_widget(\"pure_comments\");"));
add_action("widgets_init", create_function("", "return register_widget(\"pure_posts\");"));
add_action("widgets_init", create_function("", "return register_widget(\"pure_widget_tabber\");"));
add_action("widgets_init", create_function("", "return register_widget(\"pure_widget_google\");"));
add_action("widgets_init", create_function("", "return register_widget(\"pure_statistics\");"));
add_action("widgets_init", create_function("", "return register_widget(\"pure_textads\");"));
add_action("wp_dashboard_setup", "example_remove_dashboard_widgets");
add_action("init", "pure_reg");
add_filter("smilies_src", "pure_smilies_src", 1, 10);
add_action("media_buttons_context", "pure_smilies_custom_button");
add_filter("comment_form_defaults", "pure_add_smilies_to_comment_form");

if (wysafe("pure_adminmail_b")) {
	add_action("wp_login", "wp_login_notify");
	add_action("wp_login_failed", "wp_login_failed_notify");
}

$default_avatar = THEME_URI . "/avatar/default.jpg";

if (wysafe("pure_cdn_avatar_b")) {
	add_filter("get_avatar", "duoshuo_avatar", 10, 3);
}
else if (is_file($default_avatar)) {
	add_filter("get_avatar", "my_avatar");
}
else {
	add_filter("get_avatar", "get_cn_avatar");
}

if (wysafe("pure_piclocal_b")) {
	add_action("publish_post", "newbody");
}
class pure_homeflashlist extends WP_Widget
{
	public function pure_homeflashlist()
	{
		$control_ops = "";
		$widget_ops = array("classname" => "pure_homeflashlist", "description" => "首页CMS，只可以放置在首页的CMS小工具，功能为幻灯片，可以显示最新文章+热门文章+随机文章。");
		$this->WP_Widget("pure_homeflashlist", "[首页CMS]-幻灯片", $widget_ops, $control_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_name", $instance["title"]);
		$limit = $instance["limit"];
		$cat = $instance["cat"];
		$orderby = $instance["orderby"];
		echo "<div id=\"flashbox\" class=\"flexslider\">";
		echo "<ul class=\"slides gallery\">";
		echo pure_home_flashlists($orderby, $limit, $cat);
		echo "</ul></div>";
	}

	public function form($instance)
	{
		echo "    <p>\r\n      <label>\r\n        标题：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $instance["title"];
		echo "\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        排序：\r\n        <select style=\"width:100%;\" id=\"";
		echo $this->get_field_id("orderby");
		echo "\" name=\"";
		echo $this->get_field_name("orderby");
		echo "\" style=\"width:100%;\">\r\n          <option value=\"comment_count\" ";
		selected("comment_count", $instance["orderby"]);
		echo ">评论数</option>\r\n          <option value=\"date\" ";
		selected("date", $instance["orderby"]);
		echo ">发布时间</option>\r\n          <option value=\"rand\" ";
		selected("rand", $instance["orderby"]);
		echo ">随机</option>\r\n        </select>\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        分类限制：\r\n        <a style=\"font-weight:bold;color:#f60;text-decoration:none;\" href=\"javascript:;\" title=\"格式：1,2 &nbsp;表限制ID为1,2分类的文章&#13;格式：-1,-2 &nbsp;表排除分类ID为1,2的文章&#13;也可直接写1或者-1；注意逗号须是英文的\">？</a>\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("cat");
		echo "\" name=\"";
		echo $this->get_field_name("cat");
		echo "\" type=\"text\" value=\"";
		echo $instance["cat"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        显示数目：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("limit");
		echo "\" name=\"";
		echo $this->get_field_name("limit");
		echo "\" type=\"number\" value=\"";
		echo $instance["limit"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n    \r\n  ";
	}
}

class pure_homepostlist extends WP_Widget
{
	public function pure_homepostlist()
	{
		$control_ops = "";
		$widget_ops = array("classname" => "pure_homepostlist", "description" => "首页CMS，只可以放置在首页的CMS小工具，功能为图文展示，可以显示最新文章+热门文章+随机文章。");
		$this->WP_Widget("pure_homepostlist", "[首页CMS]-聚合文章", $widget_ops, $control_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_name", $instance["title"]);
		$limit = $instance["limit"];
		$cat = $instance["cat"];
		$orderby = $instance["orderby"];
		echo "<div id=\"tuijianbox\">";
		echo "<div class=\"tj-title\"><i class=\"fa fa-heart\"></i>" . $title . "</div>";
		echo "<ul>";
		echo pure_home_postlists($orderby, $limit, $cat);
		echo "</ul></div>";
	}

	public function form($instance)
	{
		echo "    <p>\r\n      <label>\r\n        标题：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $instance["title"];
		echo "\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        排序：\r\n        <select style=\"width:100%;\" id=\"";
		echo $this->get_field_id("orderby");
		echo "\" name=\"";
		echo $this->get_field_name("orderby");
		echo "\" style=\"width:100%;\">\r\n          <option value=\"comment_count\" ";
		selected("comment_count", $instance["orderby"]);
		echo ">评论数</option>\r\n          <option value=\"date\" ";
		selected("date", $instance["orderby"]);
		echo ">发布时间</option>\r\n          <option value=\"rand\" ";
		selected("rand", $instance["orderby"]);
		echo ">随机</option>\r\n        </select>\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        分类限制：\r\n        <a style=\"font-weight:bold;color:#f60;text-decoration:none;\" href=\"javascript:;\" title=\"格式：1,2 &nbsp;表限制ID为1,2分类的文章&#13;格式：-1,-2 &nbsp;表排除分类ID为1,2的文章&#13;也可直接写1或者-1；注意逗号须是英文的\">？</a>\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("cat");
		echo "\" name=\"";
		echo $this->get_field_name("cat");
		echo "\" type=\"text\" value=\"";
		echo $instance["cat"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        显示数目：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("limit");
		echo "\" name=\"";
		echo $this->get_field_name("limit");
		echo "\" type=\"number\" value=\"";
		echo $instance["limit"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n    \r\n  ";
	}
}


add_action("wp_ajax_nopriv_pure_zancallback", "pure_zancallback");
add_action("wp_ajax_pure_zancallback", "pure_zancallback");
add_action("publish_post", "pure_add_ratings_fields");
add_action("publish_page", "pure_add_ratings_fields");
add_action("delete_post", "pure_delete_ratings_fields");
add_action("delete_page", "pure_delete_ratings_fields");
add_action("wp_ajax_nopriv_pure_rate", "pure_rate");
add_action("wp_ajax_pure_rate", "pure_rate");
add_action("wp_ajax_nopriv_ajax_index_post", "ajax_index_post");
add_action("wp_ajax_ajax_index_post", "ajax_index_post");
add_action("widgets_init", "pure_homeflashlists");
add_action("widgets_init", "pure_homepostlists");
add_filter("use_default_gallery_style", "__return_false");

if (wysafe("pure_gzip_b")) {
	if (!is_admin()) {
		add_action("wp_loaded", "pure_theme_gzip");
	}
}
class pure_homecmslist extends WP_Widget
{
	public function pure_homecmslist()
	{
		$control_ops = "";
		$widget_ops = array("classname" => "pure_homecmslist", "description" => "首页CMS，只可以放置在首页的CMS小工具，功能为CMS文章列表，可以显示最新文章+热门文章+随机文章。");
		$this->WP_Widget("pure_homecmslist", "[首页CMS]-CMS文章列表", $widget_ops, $control_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_name", $instance["title"]);
		$limit = $instance["limit"];
		$cat = $instance["cat"];
		$orderby = $instance["orderby"];
		$ii = 1;
		$display_categories = explode(",", $cat);

		foreach ($display_categories as $category ) {
			query_posts("cat=$category");
			echo "<div class=\"column cat-";
			echo $ii;
			echo "\"><div class=\"cms-title\"><i class=\"fa fa-th-large\"></i><a href=\"";
			echo get_category_link($category);
			echo "\">";
			single_cat_title();
			echo "</a>";
			echo "</div><div class=\"col-lists\">";
			echo "<ul>";
			echo pure_home_cmslists($orderby, $limit, $category);
			echo "</ul></div></div>";
			$ii++;
		}
	}

	public function form($instance)
	{
		echo "    <p>\r\n      <label>\r\n        标题：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $instance["title"];
		echo "\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        排序：\r\n        <select style=\"width:100%;\" id=\"";
		echo $this->get_field_id("orderby");
		echo "\" name=\"";
		echo $this->get_field_name("orderby");
		echo "\" style=\"width:100%;\">\r\n          <option value=\"comment_count\" ";
		selected("comment_count", $instance["orderby"]);
		echo ">评论数</option>\r\n          <option value=\"date\" ";
		selected("date", $instance["orderby"]);
		echo ">发布时间</option>\r\n          <option value=\"rand\" ";
		selected("rand", $instance["orderby"]);
		echo ">随机</option>\r\n        </select>\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        分类限制：\r\n        <a style=\"font-weight:bold;color:#f60;text-decoration:none;\" href=\"javascript:;\" title=\"格式：1,2 &nbsp;表限制ID为1,2分类的文章&#13;格式：-1,-2 &nbsp;表排除分类ID为1,2的文章&#13;也可直接写1或者-1；注意逗号须是英文的; \">？</a>\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("cat");
		echo "\" name=\"";
		echo $this->get_field_name("cat");
		echo "\" type=\"text\" value=\"";
		echo $instance["cat"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        显示数目：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("limit");
		echo "\" name=\"";
		echo $this->get_field_name("limit");
		echo "\" type=\"number\" value=\"";
		echo $instance["limit"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n    \r\n  ";
	}
}

class pure_home_links extends WP_Widget
{
	public function __construct()
	{
		parent::__construct("pure_home_links", "[首页CMS]友情链接", array("description" => "随机显示" . __("Your blogroll"), "classname" => "widget_links"));
	}

	public function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);
		$onlyhome = (isset($instance["onlyhome"]) ? $instance["onlyhome"] : 0);
		$category = (isset($instance["category"]) ? $instance["category"] : false);
		$title = apply_filters("widget_title", empty($instance["title"]) ? "随机链接" : $instance["title"], $instance, $this->id_base);
		$limit = (isset($instance["limit"]) ? $instance["limit"] : 30);
		$target = (isset($instance["newwin"]) ? "" : " target=\"_blank\"");
		echo "<div class=\"cmsbox\"><div class=\"cms-title\"><i class=\"fa fa-link\"></i> 友情链接</div><ul class=\"cb_links\">";
		wp_list_bookmarks(apply_filters("widget_links_args", "title_li=&categorize=0&orderby=rand&category=" . $instance["category"] . "&limit=" . $instance["limit"]));
		echo apply_filters("widget_text", empty($instance["addto"]) ? "" : $instance["addto"], $instance);
		echo "<div class=\"clearfix\"></div></ul></div>";
	}

	public function update($new_instance, $old_instance)
	{
		$new_instance = (array) $new_instance;
		$instance = array("title" => "", "category" => false, "limit" => 30, "onlyhome" => false, "addto" => "");
		$instance["title"] = strip_tags($new_instance["title"]);
		$instance["category"] = intval($new_instance["category"]);
		$instance["limit"] = (!empty($new_instance["limit"]) ? intval($new_instance["limit"]) : 30);
		$instance["onlyhome"] = (isset($new_instance["onlyhome"]) ? 1 : 0);
		$instance["addto"] = $new_instance["addto"];
		return $instance;
	}

	public function form($instance)
	{
		$instance = wp_parse_args((array) $instance, array("title" => "", "category" => false, "limit" => 30, "onlyhome" => false, "addto" => ""));
		$title = strip_tags($instance["title"]);
		$addto = esc_textarea($instance["addto"]);

		if (!$limit = intval($instance["limit"])) {
			$limit = 30;
		}

		$link_cats = get_terms("link_category");
		echo "    <p><label for=\"";
		echo $this->get_field_id("title");
		echo "\">";
		_e("Title:");
		echo "</label>\r\n    <input class=\"widefat\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $title;
		echo "\" /></p>\r\n    \r\n    <p><label for=\"";
		echo $this->get_field_id("category");
		echo "\">";
		_e("Select Link Category:");
		echo "</label>\r\n    <select class=\"widefat\" id=\"";
		echo $this->get_field_id("category");
		echo "\" name=\"";
		echo $this->get_field_name("category");
		echo "\"></p>\r\n    \r\n    <p><option value=\"\">所有链接</option>\r\n    ";

		foreach ($link_cats as $link_cat ) {
			echo "<option value=\"" . intval($link_cat->term_id) . "\"" . selected($instance["category"], $link_cat->term_id, false) . ">" . $link_cat->name . "</option>\n";
		}

		echo "    </select></p>\r\n    \r\n    <p><label for=\"";
		echo $this->get_field_id("limit");
		echo "\">";
		_e("Number of links to show:");
		echo "</label>\r\n    <input id=\"";
		echo $this->get_field_id("limit");
		echo "\" name=\"";
		echo $this->get_field_name("limit");
		echo "\" type=\"text\" value=\"";
		echo $limit == 10 ? "" : intval($limit);
		echo "\" size=\"3\" /></p>\r\n\r\n    <p><label for=\"";
		echo $this->get_field_id("addto");
		echo "\">追加链接：</label>\r\n    <textarea class=\"widefat\" rows=\"6\" cols=\"20\" id=\"";
		echo $this->get_field_id("addto");
		echo "\" name=\"";
		echo $this->get_field_name("addto");
		echo "\">";
		echo $addto;
		echo "</textarea>\r\n    <small>链接格式：</small><br /><code>&lt;li&gt;&lt;a href=&quot;地址&quot;&gt;名称&lt;/a&gt;&lt;/li&gt;</code></p>\r\n    \r\n    <p><input class=\"checkbox\" type=\"checkbox\" ";
		checked($instance["onlyhome"], true);
		echo " id=\"";
		echo $this->get_field_id("onlyhome");
		echo "\" name=\"";
		echo $this->get_field_name("onlyhome");
		echo "\" />\r\n    <label for=\"";
		echo $this->get_field_id("onlyhome");
		echo "\">仅在首页显示</label></p>\r\n";
	}
}

class pure_homephoto extends WP_Widget
{
	public function pure_homephoto()
	{
		$control_ops = "";
		$widget_ops = array("classname" => "pure_homephoto", "description" => "首页CMS，只可以放置在首页的CMS小工具,只能放置在上下通栏,功能为CMS图片列表，可以显示最新文章+热门文章+随机文章。");
		$this->WP_Widget("pure_homephoto", "[首页CMS]-CMS图片列表", $widget_ops, $control_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_name", $instance["title"]);
		$limit = $instance["limit"];
		$cat = $instance["cat"];
		$orderby = $instance["orderby"];
		echo "<div class=\"cms-photos\">";
		echo pure_home_photos($orderby, $limit, $cat);
		echo "</div><div class=\"clearfix\"></div>";
	}

	public function form($instance)
	{
		echo "    <p>\r\n      <label>\r\n        标题：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $instance["title"];
		echo "\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        排序：\r\n        <select style=\"width:100%;\" id=\"";
		echo $this->get_field_id("orderby");
		echo "\" name=\"";
		echo $this->get_field_name("orderby");
		echo "\" style=\"width:100%;\">\r\n          <option value=\"comment_count\" ";
		selected("comment_count", $instance["orderby"]);
		echo ">评论数</option>\r\n          <option value=\"date\" ";
		selected("date", $instance["orderby"]);
		echo ">发布时间</option>\r\n          <option value=\"rand\" ";
		selected("rand", $instance["orderby"]);
		echo ">随机</option>\r\n        </select>\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        分类限制：\r\n        <a style=\"font-weight:bold;color:#f60;text-decoration:none;\" href=\"javascript:;\" title=\"格式：1,2 &nbsp;表限制ID为1,2分类的文章&#13;格式：-1,-2 &nbsp;表排除分类ID为1,2的文章&#13;也可直接写1或者-1；注意逗号须是英文的; \">？</a>\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("cat");
		echo "\" name=\"";
		echo $this->get_field_name("cat");
		echo "\" type=\"text\" value=\"";
		echo $instance["cat"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        显示数目：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("limit");
		echo "\" name=\"";
		echo $this->get_field_name("limit");
		echo "\" type=\"number\" value=\"";
		echo $instance["limit"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n    \r\n  ";
	}
}

class pure_homecmtlist extends WP_Widget
{
	public function pure_homecmtlist()
	{
		$control_ops = "";
		$widget_ops = array("classname" => "pure_homecmtlist", "description" => "首页CMS，只可以放置在首页的CMS小工具，功能为CMS文章列表Tab聚合，可以显示最新文章+热门文章+随机文章。");
		$this->WP_Widget("pure_homecmtlist", "[首页CMS]-CMS文章列表Tab聚合", $widget_ops, $control_ops);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters("widget_name", $instance["title"]);
		$limit = $instance["limit"];
		$cat = $instance["cat"];
		$orderby = $instance["orderby"];
		echo "<div class=\"cms-taber\"><div class=\"cms-taber-title\">";
		$ii = 1;
		$display_categories = explode(",", $cat);

		foreach ($display_categories as $category ) {
			query_posts("cat=$category");
			echo "<div class=\"cmt-cate cmtcate-" . $ii . "\">";
			single_cat_title();
			echo "</div>";
			$ii++;
		}

		echo "</div>";
		echo "<div class=\"cms-taber-ul\">";
		$ii = 1;

		foreach ($display_categories as $category ) {
			echo "<ul class=\"cmt-ul cmtul-" . $ii . "\">";
			echo pure_home_cmtlists($orderby, $limit, $category);
			echo "</ul>";
			$ii++;
		}

		echo "</div></div><div class=\"clearfix\"></div>";
	}

	public function form($instance)
	{
		echo "    <p>\r\n      <label>\r\n        标题：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("title");
		echo "\" name=\"";
		echo $this->get_field_name("title");
		echo "\" type=\"text\" value=\"";
		echo $instance["title"];
		echo "\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        排序：\r\n        <select style=\"width:100%;\" id=\"";
		echo $this->get_field_id("orderby");
		echo "\" name=\"";
		echo $this->get_field_name("orderby");
		echo "\" style=\"width:100%;\">\r\n          <option value=\"comment_count\" ";
		selected("comment_count", $instance["orderby"]);
		echo ">评论数</option>\r\n          <option value=\"date\" ";
		selected("date", $instance["orderby"]);
		echo ">发布时间</option>\r\n          <option value=\"rand\" ";
		selected("rand", $instance["orderby"]);
		echo ">随机</option>\r\n        </select>\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        分类限制：\r\n        <a style=\"font-weight:bold;color:#f60;text-decoration:none;\" href=\"javascript:;\" title=\"格式：1,2 &nbsp;表限制ID为1,2分类的文章&#13;\">？</a>\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("cat");
		echo "\" name=\"";
		echo $this->get_field_name("cat");
		echo "\" type=\"text\" value=\"";
		echo $instance["cat"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n    <p>\r\n      <label>\r\n        显示数目：\r\n        <input style=\"width:100%;\" id=\"";
		echo $this->get_field_id("limit");
		echo "\" name=\"";
		echo $this->get_field_name("limit");
		echo "\" type=\"number\" value=\"";
		echo $instance["limit"];
		echo "\" size=\"24\" />\r\n      </label>\r\n    </p>\r\n    \r\n  ";
	}
}


add_action("widgets_init", "pure_homecmslists");
add_action("widgets_init", create_function("", "return register_widget(\"pure_home_links\");"));
add_action("widgets_init", "pure_homephotos");
add_action("widgets_init", "pure_homecmtlists");

?>
