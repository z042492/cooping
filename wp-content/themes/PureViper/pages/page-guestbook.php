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
		echo "</div>";
		$output = "";
		$admin_mail = get_option("admin_email");
		$query = "SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 24 MONTH ) AND user_id='0' AND comment_author_email != '.$admin_mail.' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT 10";
		$wall = $wpdb->get_results($query);
		$maxNum = $wall[0]->cnt;

		foreach ($wall as $comment ) {
			$width = round(40 / $maxNum / $comment->cnt, 2);

			if ($comment->comment_author_url) {
				$url = $comment->comment_author_url;
			}
			else {
				$url = "#";
			}

			$tmp = "<li><a target=\"_blank\" rel=\"nofollow\" href=\"" . $comment->comment_author_url . "\"><span class=\"pic\" style=\"background: url(http://cn.gravatar.com/avatar/" . md5(strtolower($comment->comment_author_email)) . "?s=48&d=monsterid&r=G) no-repeat;\">pic</span><span class=\"num\">" . $comment->cnt . "</span><span class=\"name\">" . $comment->comment_author . "</span></a><div class='active-bg'><div class='active-degree' style='width:" . $width . "px'></div></div></li>";
			$output .= $tmp;
		}

		$output = "<div class=\"readerwall\"><ul>" . $output . "</ul><div class=\"clear\"></div></div>";
		echo $output;
		echo "<div class=\"clear\"></div><div id=\"content_adsense_area_2\">";

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
