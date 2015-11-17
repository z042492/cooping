<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC');

//head部输出处理方案
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
//顶部28px的空白处理方案
add_filter( 'show_admin_bar' , '__return_false');//margin-top: 28px
define('YETI_THEME_DIR', get_theme_root().'/'.get_option('template').'/');



include_once YETI_THEME_DIR.'config.php';
include_once YETI_THEME_DIR.'common.php';


function blueria_get_option($option, $default = false) {	//代替原生的get_option()
	$option = isset($GLOBALS[$option]) ? $GLOBALS[$option] : $default;
	$option = maybe_unserialize( $option );
	return $option;
}

function checkVideo($url) {		//检测是否是56的视频
	global $player56, $union56id;
	preg_match("/(pps\.tv|56\.com)/", $url, $matches);
	if ($matches[1] == '56.com') {
		preg_match("#v\_(\w+)#", $url, $key);
		if ( !empty($union56id) ) {
			return "{$url}/{$union56id}.swf";
		} else {
			return $player56."?vid=".$key[1];	//用这个地址才会自动播放
		}
		return null;
	} elseif ($matches[1] == 'pps.tv') {
		preg_match("#sid\/(\w+)#", $url, $key);
		return "http://player.pps.tv/static/vs/v1.0.0/v/swf/flvplay_s.swf?url_key=".$key[1];
	} else {
		return $url;
	}
}


function curr_mode($page_mode, $mode) {
	if (!$page_mode && $mode == 'new') echo " data-theme='b'";
	if ($page_mode == $mode) echo " data-theme='b'";
}

function yeti_tpl_url($echo=true) {
	$url = get_theme_root_uri() ."/". get_option('template');
	if ($echo) echo $url;
	else return $url;
}

//评论模板
function yeti_theme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
	
	global $commentcount;
	if(!$commentcount) {
		$page = get_query_var('cpage') - 1;
		// $cpp = get_option('comments_per_page');
		$cpp = get_query_var('comments_per_page');
		$commentcount = $cpp * $page;
	}

	echo "<li class='comment_bar clearfix' id='comment-{$comment->comment_ID}'>";
	echo "<span class='info'>";
	echo "#".++$commentcount." "; 	//当前页每个主评论自动+1
	$avatar_url = get_comment_meta( $comment->comment_ID, 'avatar', true );
	if ( !empty($avatar_url) ) $avatar = '<img class="avatar avatar-20 photo" width="20" height="20" src="'.$avatar_url.'" alt="">';
	else $avatar = get_avatar( $comment, $args['avatar_size'] );
	echo $avatar;
	echo " ".get_comment_author($comment->comment_ID)."　</span>";
	echo ($comment->comment_approved == '0') ? "<span class='moderation'>评论正在等待审核 ...</span>" : get_comment_text();
	echo "</li>";

}




?>