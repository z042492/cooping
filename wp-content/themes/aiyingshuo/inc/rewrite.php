<?php

//获取筛选页面的Url
function ashuwp_sift_link(){
 return home_url()."/sift";
}
/*
*添加query变量
*/
function ashuwp_query_vars($public_query_vars) {
$public_query_vars[] = 'ashuwp_page';
$public_query_vars[] = 'condition';
 return $public_query_vars;
}
/*
*sift页面的重写规则,三种url：
*xxxx.com/sift xxx.com/sift/0_0_0_0/ xxxx.com/sift/0_0_0_0/page/2
*/
function ashuwp_rewrite_rules( $wp_rewrite ){
$new_rules = array(
 'sift/?$' => 'index.php?ashuwp_page=sift',
 'sift/([^/]+)/?$' => 'index.php?ashuwp_page=sift&condition='.$wp_rewrite->preg_index(1),
 'sift/([^/]+)/page/?([0-9]{1,})/?$' => 'index.php?ashuwp_page=sift&condition='.$wp_rewrite->preg_index(1).'&paged='.$wp_rewrite->preg_index(2)
 );
$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
/*
*载入模板规则
*用page-sift.php作为筛选页面的模板文件
*/
function ashuwp_template_redirect(){
 global $wp,$wp_query,$wp_rewrite;
 if( !isset($wp_query->query_vars['ashuwp_page']) )
 return;
$reditect_page = $wp_query->query_vars['ashuwp_page'];
 if ($reditect_page == "sift"){
include(get_template_directory().'/page-sift.php');
 die();
 }
}
/*
*更新重写规则
*激活主题的时候
*/
function ashuwp_flush_rewrite_rules() {
 global $pagenow, $wp_rewrite;
 if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
$wp_rewrite->flush_rules();
}
add_action( 'load-themes.php', 'ashuwp_flush_rewrite_rules' );
add_action('generate_rewrite_rules', 'ashuwp_rewrite_rules' );
add_action('query_vars', 'ashuwp_query_vars');
add_action("template_redirect", 'ashuwp_template_redirect');

?>