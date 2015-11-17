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
			<div id="title">
				<?php if(have_posts()): ?><?php while(have_posts()):the_post();  ?>
				<h2><?php the_title(); ?></h2>
				<div class="post_icon">
				<span class="postauthor"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"><?php echo get_the_author() ?></a></span>
				<span class="posttime"><?php the_time('Y-n-j') ?></span>
				<span class="postcat"><?php the_category(' '); ?></span>
				<span class="postcomm">
					<a href="<?php the_permalink(); ?>" title="评论"><?php comments_popup_link( __( ' 0', 'vfilmtheme' ) , __( ' 1', 'vfilmtheme' ), __( ' %', 'vfilmtheme' ) ); ?></a>
				</span>
					<?php edit_post_link('[编辑]'); ?>
				</div>
			</div>
			
				
			<div class="clear"></div>
			<div class="post">
				<?php the_content(); ?>
				<div class="clear"></div>
				<div id="share">
				<!-- Baidu Button BEGIN -->
				<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
					<span class="bdmore">分享：</span>
					<a class="bds_qzone"></a>
					<a class="bds_tsina"></a>
					<a class="bds_tqq"></a>
					<a class="bds_renren"></a>
					<a class="bds_tieba"></a>
					<span class="bds_more">更多</span>
				</div>
				<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6530053"></script>
				<script type="text/javascript" id="bdshell_js"></script>
				<script type="text/javascript">
				document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
				</script>
				<!-- Baidu Button END -->
				</div>
			</div>
			<div class="clear"></div>
			<h3 class="related_about">相关文章</h3>
            <ul class="related_img">
                <?php
                $post_num = 8;
                $exclude_id = $post->ID;
                $posttags = get_the_tags(); $i = 0;
                if ( $posttags ) {
	            $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->term_id . ',';
	            $args = array(
	         	'post_status' => 'publish',
	        	'tag__in' => explode(',', $tags),
	        	'post__not_in' => explode(',', $exclude_id),
	        	'caller_get_posts' => 1,
	        	'orderby' => 'comment_date',
        		'posts_per_page' => $post_num
        	);
	        query_posts($args);
	        while( have_posts() ) { the_post(); ?>
	      	<li class="related_box"  >
		        <div class="r_pic">
		        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank">
		        <?php post_thumbnail(140,100); ?>
		        </a>
		       </div>
		    <div class="r_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank" rel="bookmark"><?php echo mb_strimwidth(strip_tags(get_the_title()), 0, 38,"..."); ?></a></div>
		    </li>
	        <?php
	     	$exclude_id .= ',' . $post->ID; $i ++;
        	} wp_reset_query();
            }
            if ( $i < $post_num ) {
	        $cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
	        $args = array(
		        'category__in' => explode(',', $cats),
		        'post__not_in' => explode(',', $exclude_id),
		        'caller_get_posts' => 1,
	         	'orderby' => 'comment_date',
	        	'posts_per_page' => $post_num - $i
         	);
	        query_posts($args);
	        while( have_posts() ) { the_post(); ?>
	        <li class="related_box"  >
	     	<div class="r_pic">
	        	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank">
				<?php post_thumbnail(140,100); ?>
	        	</a>
	    	</div>
	    	<div class="r_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank" rel="bookmark"><?php echo mb_strimwidth(strip_tags(get_the_title()), 0, 38,"..."); ?></a></div>
	       </li>
	    <?php $i++;
	    } wp_reset_query();
        }
        if ( $i  == 0 )  echo '<div class="r_title">没有相关文章!</div>';
        ?>
        </ul>
		</div>
		<?php comments_template(); ?>
		<?php endwhile; ?>
    </div>
    <?php endif; ?>
	
    
<?php get_footer(); ?>