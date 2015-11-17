<?php 
/*
Template Name: 我的文章
*/
?>
<?php

if(!is_user_logged_in())
{
	echo "<script>window.location.href='".wp_login_url()."';</script>";
}
global $wpdb, $post, $wp_query,$userdata, $wp_http_referer;
$query_vars = $wp_query->query_vars;
//$pagenum = isset($query_vars['paged']) ? $query_vars['paged'] : 1;
$pagenum = isset( $_GET['pagenum'] ) ? intval( $_GET['pagenum'] ) : 1;
$args = array(
	'author' => get_current_user_id(),
	'post_status' => array('publish'),
	//'post_type' => 'detail',
	'posts_per_page' => 8,
	'paged' => $pagenum
);
$dashboard_query = new WP_Query( $args );
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
<h4>我的文章</h4>
<hr class="oneuser-title-hr">
<div class="grid">
<?php if( $dashboard_query->have_posts() ) : ?>
    <ul>
<?php while ( $dashboard_query->have_posts() ) : $dashboard_query->the_post(); ?>
    <li class="group">
    <div class="item">
    <div class="thumb">
        <a target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
         <img width="280" height="180" src="<?php echo catch_that_image() ?>" class="attachment-medium wp-post-image" alt="<?php the_title(); ?>" /></a>
    </div>
    <div class="meta">
          <div class="title"><h2><a target="_blank" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2></div>
                    <div class="extra">
              <i class="fa fa-bookmark"></i> <?php the_category(', ') ?><span><i class="fa fa-fire"></i></span>
          </div>
      </div>
      <div class="data">
        <time class="time"></time>
         <span class="comment-num">
         		 <a href="<?php comments_link(); ?>" class="comments-link" ><i class="fa fa-comment"></i></a></span>
         <span class="heart-num"><i class="fa fa-user"></i><?php echo get_the_author() ?></span>
      </div>
  </div>
	</li>
	<?php endwhile;?>  
</ul>
<?php
endif;
?>
<?php
$pagination = paginate_links( array(
	'base' => add_query_arg( 'pagenum', '%#%' ),
	'format' => '',
	'prev_text' => '上一页',
	'next_text' => '下一页',
	'total' => $dashboard_query->max_num_pages,
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
</div>
<?php get_footer(); ?>