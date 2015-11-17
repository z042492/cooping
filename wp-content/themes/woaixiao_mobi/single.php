<?php get_header(); ?>

<div data-role="page">

	<div data-role="header" data-position="fixed">
		<span id='home' class="ui-btn-left nav_btn">
			<a href="<?php echo home_url();?>" data-transition="slideup" id='home_btn'>
				<img src='<?php bloginfo('template_url');?>/ui/home.png' />
			</a>
		</span>
		<span id='add' class="ui-btn-right nav_btn"></span>
		<h1><?php the_title();?></h1>
	</div><!-- /header -->

	<div data-role="content">
		<?php $post_top_ad = blueria_get_option('mobi_post_top_ad'); if ( !empty($post_top_ad) ) : ?>
			<div class='ad_box'><?php echo $post_top_ad; ?></div>
		<?php endif; ?>
		
		<?php if ( have_posts() ) while ( have_posts() ) : the_post();
			$the_id = get_the_ID();
			$author = get_post_meta($post->ID, 'username', true);
			if ( !empty($author) ) {
				$avatar = "<img src='".get_post_meta($post->ID, 'avatar', true)."' />";
			} else {
				$author = get_the_author_meta('nickname');
				$avatar = get_avatar(get_the_author_meta('ID'),32);
			}
			echo "<article id='article_{$the_id}' class='article_box'>\n";
			echo "<div class='author'>{$avatar}<span>{$author}</span></div>\n";
			echo "<div class='content'>".wpautop( get_the_content() );
			$media_type = get_post_format();
			if ($media_type == 'video') {
				$src = get_field('img');
				// $swf = checkVideo( get_field('videourl') );
				$swf = get_field('videourl');	//有待斟酌
				echo "<img src='{$src}' class='vdo_thumb' alt='".get_the_title()."' />";
				echo html5player($swf);
			} elseif ($media_type == 'image') {
				$imgurl = get_post_meta($post->ID, 'imgurl', true);
				if ( !empty($imgurl) ) {
					$src = $imgurl;
				} else {
					$img = wp_get_attachment_image_src(get_field('pic'), 'full');
					$src = $img[0];
				}
				echo "<img src='{$src}' />";
			}
			echo "</div>\n";
			$vote = get_post_meta($post->ID, "blueria_vote", true);
			$vote2 = get_post_meta($post->ID, "blueria_vote2", true);
			$vote = $vote ? $vote : 0;
			$vote2 = $vote2 ? $vote2 : 0;
			$voted = $_COOKIE['blueria_vote_'.$the_id] ? "voted":"";
			echo "<div class='toolbar clearfix'>";
			echo "<div class='toolbar_left {$voted}'><a class='vote_up' href='javascript:;' onclick='vote({$the_id},1,this)'>{$vote}</a><a class='vote_down' href='javascript:;' onclick='vote({$the_id},-1,this)'>{$vote2}</a></div>";
			echo "<div class='toolbar_right'></div>";
			echo "</div>\n";
			echo "</article>\n";
		?>
			<div class="comments">
				<?php remove_all_filters('comments_template', 0);comments_template();?>
			</div>
		<?php endwhile;?>
		
		<?php $post_bottom_ad = blueria_get_option('mobi_post_bottom_ad'); if ( !empty($post_bottom_ad) ) : ?>
			<div class='ad_box'><?php echo $post_bottom_ad; ?></div>
		<?php endif; ?>
	</div><!-- /content -->

	<div data-role="footer" data-position="fixed">
		<div data-role="navbar" data-iconpos="left" id="foot_nav">
			<ul>
				<li><a href="#" data-rel="back"><img src='<?php bloginfo('template_url');?>/ui/back.png' />返回</a></li>
				<li><a href="#shareMenu2" id="sharebtn" onclick="share(<?php echo $post->ID;?>)" data-rel="popup" data-transition="slideup"  data-position-to="window">
					<img src='<?php bloginfo('template_url');?>/ui/share.png' />分享</a>
				</li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->
	
	<div data-role="popup" id="shareMenu2" data-theme="b">
		<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="b">
			<li data-role="divider" data-theme="a">分享至</li>
			<li id="wxbtn" style='display:none;'><a href="#wxshare" class="shareto_weixin" data-rel='popup' data-transition='slideup' data-position-to='#home'>
				<img src="<?php bloginfo('template_url');?>/ui/forward_weixin.png" class="ui-li-icon" />微信</a>
			</li>
			<li><a href="#" class="shareto_sina"><img src="<?php bloginfo('template_url');?>/ui/forward_sina.png" class="ui-li-icon" />新浪微博</a></li>
			<li><a href="#" class="shareto_tencent"><img src="<?php bloginfo('template_url');?>/ui/forward_tencent.png" class="ui-li-icon" />腾讯微博</a></li>
			<li><a href="#" class="shareto_renren"><img src="<?php bloginfo('template_url');?>/ui/forward_renren.png" class="ui-li-icon" />人人网</a></li>
			<li data-role="divider" data-theme="a"></li>
		</ul>
	</div>
	<div data-role="popup" id="wxshare" data-theme="none">
		<img src="<?php bloginfo('template_url');?>/ui/wxshare.png" />
	</div>
</div><!-- /page -->

<?php get_footer(); ?>