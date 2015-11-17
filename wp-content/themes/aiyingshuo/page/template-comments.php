<?php 
/*
Template Name: 我的评论
*/
if(!is_user_logged_in())
{
	echo "<script>window.location.href='".wp_login_url()."';</script>";
}
global $wpdb, $post, $wp_query,$current_user,$userdata;
get_currentuserinfo();
$query_vars = $wp_query->query_vars;
//$pagenum = isset($query_vars['paged']) ? $query_vars['paged'] : 1;
$pagenum = isset( $_GET['pagenum'] ) ? intval( $_GET['pagenum'] ) : 1;
$comments_total = get_user_comments_count($userdata->ID);
$total_page = ceil($comments_total/20);
$current = ($pagenum-1)*20;
$args = array(
	'user_id' => get_current_user_id(),
	'status' => 'approve',
	'number' => 20,
	'offset' => $current
);
$coments_query = get_comments( $args );
 get_header(); 
 ?>
<div class="w1200m">
<div class="profile">
<div class="profile-left">
<div class="with-padding">
<h3 class="with-padding">用户中心</h3>
<div id="aside">
<?php wp_nav_menu( array( 'theme_location' => 'anli-menu' ) ); ?>
</div>
</div>
</div>
<div class="profile-right">
<div class="dashboard-main">
<h4>我的评论</h4>
<hr class="oneuser-title-hr">
<?php wp_list_comments( array('callback'=>'user_comments_list'), $coments_query );?>
<?php
$pagination = paginate_links( array(
	'base' => add_query_arg( 'pagenum', '%#%' ),
	'format' => '',
	'prev_text' => '上一页',
	'next_text' => '下一页',
	'total' => $total_page,
	'current' => $pagenum
	)
);
if ( $pagination ) {
	echo $pagination;
}
?>
</div>
</div>
</div>
</div>
<?php get_footer(); ?>