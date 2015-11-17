<?php

if (post_password_required()) {
	return NULL;
}

echo "\r\n<div id=\"comments\">\r\n\r\n\t";

if (comments_open()) {
	echo "\t\t<h3 id=\"comments-title\">\r\n\t\t\t";
	comments_number("发表评论", "1 条评论", "% 条评论");
	echo "\t\t</h3>\r\n\r\n\t\t<div id=\"respond\">\r\n\t\t\t";
	if (get_option("comment_registration") && !is_user_logged_in()) {
		echo "\t\t\t\t<div id=\"commentform\">\r\n\t\t\t\t\t<p class=\"comment-form-comment must-log-in\">\r\n\t\t\t\t\t\t";
		echo sprintf(__("You must be <a href=\"%s\">logged in</a> to post a comment."), wp_login_url(apply_filters("the_permalink", get_permalink($post->ID))));
		echo "\t\t\t\t\t</p>\r\n\t\t\t\t</div>\r\n\t\t\t";
	}
	else {
		echo "\t\t\t\t";
		cancel_comment_reply_link();
		echo "\t\t\t\t<form action=\"";
		echo site_url("/wp-comments-post.php");
		echo "\" method=\"post\" id=\"commentform\">\r\n\t\t\t\t\t";
		$useremail = ($user_ID ? get_the_author_meta("user_email", $user_ID) : $comment_author_email);
		echo "\t\t\t\t\t<img id=\"real-time-gravatar\" class=\"avatar avatar-50\" src=\"http://cn.gravatar.com/avatar/";
		echo md5($useremail);
		echo "?s=50&d=identicon&r=G\" alt=\"gravatar\" height=\"50\" width=\"50\" />\t\t\t\t\t\r\n\t\t\t\t\t<div id=\"comment-settings\">\r\n\t\t\t\t\t";

		if (is_user_logged_in()) {
			echo "\t\t\t\t\t\t";
			echo "<div class=\"logged-in-as\">" . sprintf(__("Logged in as <a href=\"%1\$s\">%2\$s</a>. <a href=\"%3\$s\" title=\"Log out of this account\">Log out?</a>"), get_edit_user_link(), $user_identity, wp_logout_url(get_permalink($post->ID))) . "</div>";
			echo "\t\t\t\t\t";
		}
		else {
			echo "\t\t\t\t\t\t<div class=\"comment-fields\">\r\n\t\t\t\t\t\t\t<div class=\"comment-form-author\">\r\n\t\t\t\t\t\t\t\t<label for=\"author\"><i class=\"fa fa-user\"></i>昵称</label><input id=\"author\" name=\"author\" type=\"text\" value=\"";
			echo $comment_author;
			echo "\" size=\"30\" ";

			if (get_option("require_name_email")) {
				echo "required title=\"必填项\"";
			}

			echo ">\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t<div class=\"comment-form-email\">\r\n\t\t\t\t\t\t\t\t<label for=\"email\"><i class=\"fa fa-envelope-o\"></i>邮箱</label><input id=\"email\" name=\"email\" type=\"email\" value=\"";
			echo $comment_author_email;
			echo "\" size=\"30\" ";

			if (get_option("require_name_email")) {
				echo "required title=\"必填项\"";
			}

			echo ">\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t<div class=\"comment-form-url\">\r\n\t\t\t\t\t\t\t\t<label for=\"url\"><i class=\"fa fa-home\"></i>网址</label><input id=\"url\" name=\"url\" type=\"text\" value=\"";
			echo $comment_author_url;
			echo "\" size=\"30\">\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t</div>\r\n\t\t\t\t\t";
		}

		echo "\t\t\t\t\t\t<div class=\"comment-more\">\r\n\t\t\t\t\t\t\t";
		do_action("comment_form", $post->ID);
		echo "\t\r\n\t\t\t\t\t\t</div>\r\n\t\t\t\t\t</div>\r\n\t\t\t\t\t<p class=\"comment-form-comment\">\r\n\t\t\t\t\t\t<label for=\"comment\">";
		echo get_option("pure_comment_placeholder");
		echo "</label><textarea id=\"comment\" name=\"comment\" cols=\"45\" rows=\"8\" onfocus=\"this.previousSibling.style.display='none'\" onblur=\"this.previousSibling.style.display=this.value==''?'block':'none'\" required></textarea>\r\n\t\t\t\t\t</p>\r\n\r\n\t\t\t\t\t<footer class=\"comment-form-footer\">\r\n\t\t\t\t\t\t  <div class=\"comment-tools\">\r\n\t\t\t\t\t\t\t<div class=\"smilies\" id=\"wp-smiles\">\r\n\t\t\t\t\t\t\t\t<a class=\"btn-coms\"><i class=\"fa fa-smile-o\"></i>表情</a>\r\n\t\t\t\t\t\t\t\t<div class=\"smiliepad\" id=\"smiliepad\">\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t";
		echo pure_get_wpsmiliestrans();
		echo "\t\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t<div class=\"signnow\" id=\"btn_sign\">\r\n\t\t\t\t\t\t\t\t<a class=\"btn-coms\"><i class=\"fa fa-gavel\"></i>签到</a>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t      </div>\r\n\t\t\t\t\t\t<input name=\"submit\" type=\"submit\" id=\"submit\" value=\"发表评论\" />\r\n\t\t\t\t\t\t";

		if (is_user_logged_in()) {
			echo "\t\t\t\t\t\t<div class=\"comment-settings-toggle\"><span class=\"name\">";
			echo $user_identity;
			echo "</span><i class=\"fa fa-arrow\">&#9660;</i></div>\r\n\t\t\t\t\t\t";
		}
		else {
			echo "\t\t\t\t\t\t<div class=\"comment-settings-toggle required\">\r\n\t\t\t\t\t\t\t<span class=\"name\"><i class=\"fa fa-user\"></i>昵称</span>\r\n\t\t\t\t\t\t\t<i class=\"arrow\">&#9660;</i>\r\n\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t";
		}

		echo "\t\t\t\t\t</footer>\r\n\t\t\t\t\t";
		comment_id_fields($post->ID);
		echo "\t\t\t\t</form>\r\n\t\t\t";
	}

	echo "\t\t</div>\r\n\t\t";
	do_action("comment_form_after");
	echo "\r\n\t\t";

	if (!have_comments()) {
		echo "\t\t\t<p class=\"no-comments\" onclick=\"document.getElementById('explorer').scrollIntoView();document.getElementById('comment').focus();\">沙发空缺中，还不快抢~</p>\r\n\t\t";
	}

	echo "\r\n\t";
}
else {
	echo "\t\t<p id=\"comments-title\" class=\"nocomments\">评论已关闭</p>\r\n\t";
}

echo "\r\n\t";

if (have_comments()) {
	echo "\t\t<ol class=\"commentlist\">\r\n\t\t\t";
	wp_list_comments(array("style" => "ol", "short_ping" => true, "callback" => "pure_comment", "reverse_top_level" => true, "reverse_children" => false));
	echo "\t\t</ol>\r\n\r\n\t\t";
	if ((1 < get_comment_pages_count()) && get_option("page_comments") && get_previous_comments_link()) {
		echo "<div class=\"navigation\">" . str_replace("<a", "<a class=\"loadmore\" role=\"navigation\"", get_previous_comments_link("更多评论")) . "</div>";
	}

	echo "\t";
}

echo "\r\n</div>";

?>
