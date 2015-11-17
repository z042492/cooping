<!-- sidebar begin-->
<div class="sidebar-right">
<div class="index-title mb15">
<h2 class="index-title-bd">月榜推荐</h2>
<span class="tip_t">
<i class="tip_outer"></i>
<i class="tip_outer"></i>
</span>
</h2>
</div>	
<div class="c_titr">
<?php $cmntCnt = 1; ?>
<?php 
function mostmonth($where = '') {
    //获取最近30天文章
    $where .= " AND post_date > '" . date('Y-m-d', strtotime('-700 days')) . "'";
    return $where;
}
add_filter('posts_where', 'mostmonth'); ?>
<ul>
<?php query_posts("v_sortby=views&caller_get_posts=1&orderby=date&v_orderby=desc&showposts=10") ?>
<?php while (have_posts()) : the_post(); ?>
<li>
<a href="<?php the_permalink() ?>">
<span class="top-num"><?php echo($cmntCnt++); ?></span>
<span class="top-title"><?php the_title(); ?></span>
<span class="top-playnum"><?php post_views(' ', ' 次'); ?></span>
</a>
</li>
<?php endwhile; ?>
</ul>
</div>  
<div class="index-title mb15">
<h2 class="index-title-bd">周榜推荐</h2>
<span class="tip_t">
<i class="tip_outer"></i>
<i class="tip_outer"></i>
</span>
</h2>
</div>
<div class="c_titr">
<?php $cmntCnt = 1; ?>
<ul>
<?php query_posts("showposts=5&cat=1")?>
<?php while (have_posts()) : the_post(); ?>
<li class="top-first">
<a href="<?php the_permalink() ?>">
<img src="<?php echo catch_that_image() ?>" alt="<?php the_title(); ?>">
<span class="gradient-bg"></span>
<span class="top-num"><?php echo($cmntCnt++); ?></span>
<span class="top-title"><?php the_title(); ?></span>
<span class="top-playnum"><?php post_views(' ', ' 次'); ?></span>
</a>
</li>
<?php endwhile; ?>
</ul> 
</div>