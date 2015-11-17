<?php get_header(); ?>
  <div class="category_mbx">
	  <?php if (function_exists('get_breadcrumbs')){get_breadcrumbs(); } ?>
</div>	
   <div class="topnews">
	<span>最新动态</span>
	<div class="topnews_note">
	<span class="topnews-left"></span>
	<p><?php echo get_option('vfilmtheme_cat01'); ?></p>
	<span class="topnews-right"></span>
	</div>
    </div>

    <div id="main">
	
		<div id="post">
			<div id="page_title">
				<?php if(have_posts()): ?><?php while(have_posts()):the_post();  ?>
				<h2><?php the_title(); ?></h2>
				
			</div>
			
			
			<div class="post">
				<?php the_content(); ?>
			</div>
			<?php endwhile ?>
		</div>
		<?php if ( comments_open() ) comments_template(); ?>
		<?php endif ?>
    </div>

<?php get_footer(); ?>