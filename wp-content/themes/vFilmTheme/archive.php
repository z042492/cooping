<?php get_header(); ?>
<div class="category_mbx">
	  <?php if (function_exists('get_breadcrumbs')){get_breadcrumbs(); } ?>
</div>	
<div class="banner_ad">
	<a href="<?php echo get_option('vfilmtheme_ad02'); ?>" target="_blank"><img src="<?php echo get_option('vfilmtheme_ad01'); ?>"/></a>
</div>
<div class="topnews">
	<span>最新动态</span>
	<div class="topnews_note">
	<span class="topnews-left"></span>
	<p><?php echo get_option('vfilmtheme_cat01'); ?></p>
	<span class="topnews-right"></span>
	</div>
</div>
<div class="category_main"></div>
<div id="main">
	
		<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
		<div class="loop">
			<div class="content">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">		
					<?php post_thumbnail(340,180); ?>
				</a>
				
			</div>
			<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo mb_strimwidth(strip_tags(get_the_title()), 0, 37,"..."); ?></a></h2>
			<p><?php echo mb_strimwidth(strip_tags(get_the_content()), 0, 155,"..."); ?><span class="more"><a href="<?php the_permalink(); ?>" title="阅读全文">阅读全文»</a></span></p>
			<div class="date">
				<?php the_time('Y-n-j') ?>
				<div class="num">
					<a href="<?php the_permalink(); ?>#comments" title="评论"><span class="com"></span><?php comments_popup_link( __( ' 0', 'vfilmTheme' ) , __( ' 1', 'vfilmTheme' ), __( ' %', 'vfilmTheme' ) ); ?></a>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
		<div id="page">
			<?php par_pagenavi(3); ?>
		</div>
		<?php endif; ?>
	</div>	
<?php get_footer(); ?>