<?php get_header(); ?>
<div class="w1200m">
<div class="index_top clearfix">
<!--目前暂无后台设置请手动修改链接-->
<div class="banner" style="width:520px;float: left;">
	<div class="banner-btn">
		<a href="javascript:;" class="prevBtn"><i></i></a>
		<a href="javascript:;" class="nextBtn"><i></i></a>
	</div>
	<ul class="banner-img">
		<li><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/1.jpg"></a></li>
		<li><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/2.jpg"></a></li>
		<li><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/3.jpg"></a></li>
		<li><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/4.jpg"></a></li>
		<li><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/5.jpg"></a></li>
		<li><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/6.jpg"></a></li>
	</ul>
	<ul class="banner-circle"></ul>
</div>
<!--这里是置顶推荐-->
<div class="grid" style="width:680px;float: right;overflow: hidden;">  	
   <ul>
 <?php $sticky = get_option('sticky_posts'); rsort( $sticky );  
 $sticky = array_slice( $sticky, 0, 2);query_posts( array( 'post__in' => $sticky, 'caller_get_posts' => 1 ) );   
                if (have_posts()) :while (have_posts()) : the_post();       
            ?>   
  <li class="group">
  <div class="item">
    <div class="thumb">
    <a target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
    <img width="280" height="180" src="<?php echo catch_that_image() ?>" class="attachment-medium wp-post-image" alt="<?php the_title(); ?>" /></a>
    </div>
    <div class="meta">
    <div class="title"><h2><a target="_blank" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2></div>
    <div class="extra"><i class="fa fa-bookmark"></i><?php the_category(', ') ?><span><i class="fa fa-fire"></i><?php post_views(' ', ' 次'); ?></span></div>  
      </div>
  </div>
	</li>
	 <?php endwhile; endif; ?>  
</ul>
</div>
</div>
<!--这里是注意写自定义筛选分类链接-->
<div class="categories" monkey="categorySum">
<div class="type-item-list" static="bl=normal_classify&stp=type" style="width:20%;">
<div class="type-item">
<h3>按类型<a class="more" href="#" target="_blank" >更多</a></h3>
<ul>
<li><a target="_blank" href="#">喜剧</a></li>
<li><a target="_blank" href="#">动作</a></li>
<li><a target="_blank" href="#">恐怖</a></li>
<li><a target="_blank" href="#">惊悚</a></li>
<li><a target="_blank" href="#">战争</a></li>
<li><a target="_blank" href="#">科幻</a></li>
<li><a target="_blank" href="#">剧情</a></li>
<li><a target="_blank" href="#">古装</a></li>
<li><a target="_blank" href="#">武侠</a></li>
<li><a target="_blank" href="#">动画</a></li>
</ul>
</div>
</div>
<div class="type-item-list" static="bl=normal_classify&stp=area" style="width:20%;">
<div class="type-item">
<h3>按地区<a class="more" href="#" target="_blank" >更多</a></h3>
<ul>
<li><a target="_blank" href="#">内地</a></li>
<li><a target="_blank" href="#">香港</a></li>
<li><a target="_blank" href="#">台湾</a></li>
<li><a target="_blank" href="#">美国</a></li>
<li><a target="_blank" href="#">法国</a></li>
<li><a target="_blank" href="#">英国</a></li>
<li><a target="_blank" href="#">其他</a></li>
<li><a target="_blank" href="#">欧洲</a></li>
<li><a target="_blank" href="#">东南亚</a></li>
</ul>
</div>
</div>
<div class="type-item-list" static="bl=normal_classify&stp=year" style="width:20%;">
<div class="type-item">
<h3>按年代<a class="more" href="#" target="_blank" >更早</a></h3>
<ul>
<li><a target="_blank" href="#">2015</a></li>
<li><a target="_blank" href="#">2014</a></li>
<li><a target="_blank" href="#">2013</a></li>
<li><a target="_blank" href="#">2012</a></li>
<li><a target="_blank" href="#">00年代</a></li>
<li><a target="_blank" href="#">90年代</a></li>
<li><a target="_blank" href="#">全部</a></li>
</ul>
</div>
</div>
<div class="type-item-list" static="bl=normal_classify&stp=star" style="width:20%;">
<div class="type-item">
<h3>按明星<a class="more" href="#" target="_blank" >更多</a></h3>
<ul>
<li><a target="_blank" href="#">范冰冰</a></li>
<li><a target="_blank" href="#">张柏芝</a></li>
<li><a target="_blank" href="#">徐熙媛</a></li>
<li><a target="_blank" href="#">刘亦菲</a></li>
<li><a target="_blank" href="#">张曼玉</a></li>
<li><a target="_blank" href="#">林心如</a></li>
<li><a target="_blank" href="#">姚晨</a></li>
<li><a target="_blank" href="#">林志玲</a></li>
</ul>
</div>
</div>
<div class="type-item-list" static="bl=normal_classify&stp=search" style="width:20%;">
<div class="type-item">
<h3>热搜</h3>
<ul>
<li><a target="_blank" href="#">侏罗纪公园</a></li>
<li><a target="_blank" href="#">万物生长</a></li>
<li><a target="_blank" href="#">澳门风云2</a></li>
<li><a target="_blank" href="#">钟馗伏魔</a></li>
<li><a target="_blank" href="#">何以笙箫默</a></li>
<li><a target="_blank" href="#">我是女王</a></li>
</ul>
</div>
</div>
</div>
<div class="w800m-left grid">
<div class="index-title mb15">
<h2 class="index-title-bd">动漫专区</h2>
<span class="tip_t">
<i class="tip_outer"></i>
<i class="tip_outer"></i>
</span>
</h2>
</div>
<div class="index grid">
    <ul>
	<!--这里是8是文章数量cat代表哪个分类-->
<?php query_posts('showposts=8&cat=1'); ?> 
<?php while (have_posts()) : the_post(); ?>
    <li class="group">
  <div class="item">
    <div class="thumb">
        <a target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                  <img width="280" height="180" src="<?php echo catch_that_image() ?>" class="attachment-medium wp-post-image" alt="<?php the_title(); ?>" /></a>
    </div>
    <div class="meta">
          <div class="title"><h2><a target="_blank" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2></div>
                    <div class="extra">
              <i class="fa fa-bookmark"></i><?php the_category(', ') ?> <span><i class="fa fa-fire"></i><?php post_views(' ', ' 次'); ?></span>
          </div>  
      </div>
      <div class="data">
        <time class="time"><?php echo date('Y-m-j',get_the_time('U'));?></time>
         <span class="comment-num">
         		 <a href="<?php comments_link(); ?>" class="comments-link" ><i class="fa fa-comment"></i><?php comments_popup_link('0', '1', '%', '', '0'); ?></a></span>
         <span class="heart-num"><i class="fa fa-user"></i><?php echo get_the_author() ?></span>
      </div>
  </div>
	</li>
	<?php endwhile; wp_reset_query(); ?>
</ul>
</div>
<!-- 第二屏-->
<div class="index grid">
<div class="index-title mb15">
<h2 class="index-title-bd">电影专区</h2>
<span class="tip_t">
<i class="tip_outer"></i>
<i class="tip_outer"></i>
</span>
</h2>
</div>
    <ul>
<?php query_posts('showposts=8&cat=1'); ?> 
<?php while (have_posts()) : the_post(); ?>
    <li class="group">
  <div class="item">
    <div class="thumb">
        <a target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                  <img width="280" height="180" src="<?php echo catch_that_image() ?>" class="attachment-medium wp-post-image" alt="<?php the_title(); ?>" /></a>
    </div>
    <div class="meta">
          <div class="title"><h2><a target="_blank" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2></div>
                    <div class="extra">
              <i class="fa fa-bookmark"></i><?php the_category(', ') ?> <span><i class="fa fa-fire"></i><?php post_views(' ', ' 次'); ?></span>
          </div>  
      </div>
      <div class="data">
        <time class="time"><?php echo date('Y-m-j',get_the_time('U'));?></time>
         <span class="comment-num">
         		 <a href="<?php comments_link(); ?>" class="comments-link" ><i class="fa fa-comment"></i><?php comments_popup_link('0', '1', '%', '', '0'); ?></a></span>
         <span class="heart-num"><i class="fa fa-user"></i><?php echo get_the_author() ?></span>
      </div>
  </div>
	</li>
	<?php endwhile; wp_reset_query(); ?>
</ul>
</div>
</div>
<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>
 