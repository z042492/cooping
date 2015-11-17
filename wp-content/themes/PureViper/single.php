<?php

get_header();
echo "<div id=\"container\">";
get_template_part("loop", "fastbox");
echo "<div id=\"contentbox\">";
echo "<div id=\"content\" class=\"content-post\">";
echo "<div id=\"post\" class=\"postbox\">";

if (have_posts()) {
	while (have_posts()) {
		the_post();
		echo "<div id=\"post-header\"><ol class=\"post-crumb\" itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\">\r\n                        <li><i class=\"fa fa-home\"></i><a href=\"";
		echo get_option("home");
		echo "/\">首页</a></li><li>";
		the_category(", ");
		echo "</li><li class=\"active\"><a href=\"";
		the_permalink();
		echo "\" rel=\"bookmark\" itemprop=\"url\">本页</a></li></ol><h2 id=\"post-title\">";
		the_title();
		echo "</h2><div class=\"post-meta\"><span><i class=\"fa fa-user\"></i>";
		echo get_the_author();
		echo "</span><span><i class=\"fa fa-list-alt\"></i>";
		the_category(" | ");
		echo "</span><span><i class=\"fa fa-eye\"></i>";
		get_post_views($post->ID);
		echo "</span><span><i class=\"fa fa-clock-o\"></i>";
		the_time("y年m月j日");
		echo "</span></div><div id=\"content_adsense_area\">";

		if (wysafe("pure_ads_arttb_b")) {
			echo wysafe("pure_ads_arttb");
		}

		echo "</div></div><div id=\"post-content\">";
		the_content();
		wp_link_pages(array("before" => "<div class=\"fenye\">分页阅读：", "after" => "", "next_or_number" => "next", "previouspagelink" => "上一页", "nextpagelink" => ""));
		wp_link_pages(array("before" => "", "after" => "", "next_or_number" => "number", "link_before" => "<span>", "link_after" => "</span>"));
		wp_link_pages(array("before" => "", "after" => "</div>", "next_or_number" => "next", "previouspagelink" => "", "nextpagelink" => "下一页"));
		echo "</div><div class=\"post-point\"><div class=\"post-rating\">";
		pure_ratingnow();
		echo "<div class=\"clearfix\"></div></div><div class=\"post-zan\">";
		pure_postlike();
		echo "</div><div class=\"clearfix\"></div></div>\r\n                <div id=\"post-share\" class=\"post-share\">\r\n                    <i class=\"fa fa-share-alt\"></i> 看完收藏一下,下次也能找得到\r\n                    <div class=\"bdsharebuttonbox\">\r\n                        <a href=\"#\" class=\"bds_weixin\" data-cmd=\"weixin\" title=\"分享到微信\"></a>\r\n                        <a href=\"#\" class=\"bds_sqq\" data-cmd=\"sqq\" title=\"分享到QQ好友\"></a>\r\n                        <a href=\"#\" class=\"bds_qzone\" data-cmd=\"qzone\" title=\"分享到QQ空间\"></a>\r\n                        <a href=\"#\" class=\"bds_tsina\" data-cmd=\"tsina\" title=\"分享到新浪微博\"></a>\r\n                        <a href=\"#\" class=\"bds_renren\" data-cmd=\"renren\" title=\"分享到人人网\"></a>\r\n                        <a href=\"#\" class=\"bds_douban\" data-cmd=\"douban\" title=\"分享到豆瓣网\"></a>\r\n                        <a href=\"#\" class=\"bds_fbook\" data-cmd=\"fbook\" title=\"分享到Facebook\"></a>\r\n                    </div>\r\n                </div>                    \r\n                <div class=\"post-tags\">标签：";
		echo the_tags("", "");
		echo "</div><div class=\"post-author\"></div><div class=\"post-about\"><ul>\r\n        <li>版权声明：本文基于《知识共享署名-相同方式共享 3.0 中国大陆许可协议》发布，转载请遵循本协议</li>     \r\n        <li>文章链接：<a href=\"";
		the_permalink();
		echo "\">";
		the_permalink();
		echo "</a> [<a href=\"#\" onclick=\"";
		echo "copy_code('";
		the_permalink();
		echo "'); ";
		echo "return false;\">复制</a>] (转载时请注明本文出处及文章链接)</li>\r\n                    </ul> \r\n                    <div class=\"clear\"></div>\r\n                </div>\r\n                <div class=\"post-releated\">\r\n                    <h4 class=\"related-title\">相关文章</h2>\r\n                    <div class=\"tuijian-posts\">\r\n                        <ul>";
		$post_num = 5;
		global $post;
		$tmp_post = $post;
		$tags = "";
		$i = 0;

		if (get_the_tags($post->ID)) {
			foreach (get_the_tags($post->ID) as $tag ) {
				$tags .= $tag->name . ",";
			}

			$tags = strtr(rtrim($tags, ","), " ", "-");
			$myposts = get_posts("numberposts=" . $post_num . "&tag=" . $tags . "&exclude=" . $post->ID);

			foreach ($myposts as $post ) {
				setup_postdata($post);
				echo "<li><a href=\"";
				echo the_permalink();
				echo "\">";
				echo the_title();
				echo "</a></li>";
			}
		}
		else {
			echo "<li>本文无相关文章</li>";
		}

		$post = $tmp_post;
		setup_postdata($post);
		echo "\r\n</ul></div><div class=\"releated-posts\">";
		$category = wysafe("pure_listcat");
		query_posts(array("showposts" => "2", "cat" => $category));
		echo "<ul>";

		while (have_posts()) {
			the_post();
			echo "<li><a href=\"";
			echo the_permalink();
			echo "\" title=\"";
			echo the_title();
			echo "\">";
			pure_thumbnail(197, 102, 1);
			echo "<h3>" . the_title() . "</h3></a></li>";
		}

		wp_reset_query();
		echo "</ul>";
		echo "<div class=\"clear\"></div></div><div class=\"clear\"></div></div>\r\n        <div class=\"post-nav\"><div class=\"post-previous\">上一篇：";

		if (get_previous_post()) {
			previous_post_link("%link", "%title");
		}

		echo "</div><div class=\"post-next\">";

		if (get_next_post()) {
			next_post_link("%link", "%title");
		}

		echo "：下一篇</div><div class=\"clear\"></div></div><div class=\"clear\"></div><div id=\"content_adsense_area_2\">";

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

echo "</div></div>";
echo "</div><div id=\"aside\">";
get_sidebar();
echo "</div></div></div>";
get_footer();

?>
