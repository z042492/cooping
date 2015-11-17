<?php get_header(); ?>

<div data-role="page">

	<div data-role="header" data-position="fixed">
		<span id='list' class="ui-btn-left nav_btn">
			<a href="#control_panel"><img src='<?php bloginfo('template_url');?>/ui/list.png' /></a>
		</span>
		<span id='login' class="ui-btn-right nav_btn">
			<img src='<?php bloginfo('template_url');?>/ui/login.png' />
		</span>
		<h1><?php bloginfo('name'); ?></h1>
	</div><!-- /header -->

<?php
	$page_mode = $_COOKIE['page_mode'];
	$page_mode = $page_mode ? $page_mode : false;
	// parse_str($query_string);
	$paged = $paged ? $paged : 1;
	if ($page_mode == 'video') {
		$post_formats = array('post-format-video');	//只显示视频类的
	} else {
		$post_formats = array('post-format-image','post-format-video','post-format-aside');
	}
	$tax_query = array( array('taxonomy'=>'post_format', 'field'=>'slug', 'terms'=> $post_formats, 'operator'=>'IN') );
	$query_array = array('paged'=>$paged, 'tax_query'=>$tax_query);
	if ($page_mode == 'hot') {
		query_posts( array_merge($query_array, array('orderby'=>'meta_value_num','meta_key'=>'blueria_vote')) );
	} elseif ($page_mode == 'top') {
		query_posts( array_merge($query_array, array('orderby'=>'meta_value_num', 'meta_key'=>'views')) );
	} else {
		query_posts( $query_array );
	}
	$home = home_url('/');
	$mark_type = "";
?>
	<div data-role="content">
	<?php if ( have_posts() ) : $count = 1; while ( have_posts() ) : the_post();
		$the_id = get_the_ID();
		$author = get_post_meta($post->ID, 'username', true);
		if ( !empty($author) ) {
			$avatar = "<img src='".get_post_meta($post->ID, 'avatar', true)."' />";
		} else {
			$author = get_the_author_meta('nickname');
			$avatar = get_avatar(get_the_author_meta('ID'),32);
		}
		$content = trim( get_the_content() );
		$content2 = strip_tags($content);	//剥去标签计算长度
		$chars = 180;
		if (mb_strlen($content2) > $chars) {
			$content = mb_substr($content2, 0, $chars, 'UTF-8')."<span class='more'>......(查看更多)</span>";
			$mark_type = "mark_more";
		}
		// $first_post = ($paged == 1 && $count == 1) ? "Yes" : "No";
		echo "<article id='article_{$the_id}' class='article_box'>\n";// data-link='".get_permalink()."'
		echo "<div class='author'>{$avatar}<span>{$author}</span></div>\n";
		echo "<div class='content'><a href='".get_permalink()."' data-transition='slideup' class='link'>".wpautop( $content );
		$media_type = get_post_format();
		if ($media_type == 'video') {
			$src = yeti_tpl_url(0).'/TimThumb.php?h=200&src='.get_field('img');
			echo "<img src='{$src}' />";
			$mark_type = "mark_video";
		} elseif ($media_type == 'image') {
			$imgurl = get_post_meta($post->ID, 'imgurl', true);
			$img_type = get_post_meta($post->ID, 'img_type', true);	//后增
			if ( !empty($imgurl) ) {
				$src = yeti_tpl_url(0).'/TimThumb.php?h=200&src='.$imgurl;
			} else {
				$img = wp_get_attachment_image_src(get_field('pic'), 'full');
				$src = yeti_tpl_url(0).'/TimThumb.php?h=200&src='.$img[0];
			}
			echo "<img src='{$src}' />";
			if ($mark_type == 'mark_video') $mark_type = "";
			if (!empty($img_type) && $img_type == 'gif') $mark_type = "mark_gif";
		}
		echo "</a></div>\n";
		$vote = get_post_meta($post->ID, "blueria_vote", true);
		$vote2 = get_post_meta($post->ID, "blueria_vote2", true);
		$vote = $vote ? $vote : 0;
		$vote2 = $vote2 ? $vote2 : 0;
		$voted = $_COOKIE['blueria_vote_'.$the_id] ? "voted":"";
		echo "<div class='toolbar clearfix'>";
		echo "<div class='toolbar_left {$voted}'><a class='vote_up' href='javascript:;' onclick='vote({$the_id},1,this)'>{$vote}</a><a class='vote_down' href='javascript:;' onclick='vote({$the_id},-1,this)'>{$vote2}</a></div>";
		echo "<div class='toolbar_right'><a class='share' href='#shareMenu' onclick='share({$the_id})' data-rel='popup' data-transition='slideup' data-position-to='window'>分享</a></div>";
		echo "</div>\n";
		echo "<div class='mark {$mark_type}'></div>\n";
		echo "</article>\n";
		$mark_type = "";	//复位
	$count++; endwhile; else: ?>
		<article class='article_box'><div class='content'><p>对不起,未找到任何相关内容!</p></div></article>
	<?php endif; ?>
	
	<div class="ui-grid-a" id="pagenav">
		<div class="ui-block-a"><select name="select_page" id="select_page" data-theme='c' data-corners="false" onchange="jumpPage(this, 0)">
		<?php
			$max_pagenum = $wp_query->max_num_pages;
			$max_pagenum = $max_pagenum <= 35 ? $max_pagenum : 35;	//最多显示的页数
			for ($i=1; $i <= $max_pagenum; $i++) {
				$selected = ($i == $paged) ? "selected='selected'" : "";
				echo "<option value='".get_pagenum_link($i)."' $selected>第{$i}页</option>\n";
			}
		?>
		</select></div>
		<?php
			$next_page_link = ($paged < $max_pagenum) ? next_posts(0, false) : $home;
			$next_page_text = ($paged < $max_pagenum) ? '下一页' : '首页';
		?>
		<div class="ui-block-b">
			<a href="<?php echo $next_page_link;?>" data-role="button" data-theme="c" data-corners="false" class="nextpage" data-prefetch="ture"><?php echo $next_page_text;?></a>
		</div>
	</div>
	<?php wp_reset_query(); ?>
	</div><!-- /content -->
	
	<div id="control_panel" data-role="panel" data-position="left" data-display="reveal" data-position-fixed="true">
		<ul data-role="listview" data-inset="true" data-divider-theme="d" class="ui-icon-alt" id="control_list">
			<li class='userinfo'>
				<img src='<?php bloginfo('template_url');?>/ui/user.png' class="ui-li-icon" /><span>用户昵称</span>
			</li>
			<li<?php curr_mode($page_mode, 'new');?>>
				<a href="<?php echo $home;?>" onclick="mode('new')" data-ajax="false"><img src="<?php bloginfo('template_url');?>/ui/paperplane.png" class="ui-li-icon" />最新</a>
			</li>
			<li<?php curr_mode($page_mode, 'hot');?>>
				<a href="<?php echo $home;?>" onclick="mode('hot')" data-ajax="false"><img src="<?php bloginfo('template_url');?>/ui/fire.png" class="ui-li-icon" />热门</a>
			</li>
			<li<?php curr_mode($page_mode, 'top');?>>
				<a href="<?php echo $home;?>" onclick="mode('top')" data-ajax="false"><img src="<?php bloginfo('template_url');?>/ui/leaf.png" class="ui-li-icon" />精华</a>
			</li>
			<li<?php curr_mode($page_mode, 'video');?>>
				<a href="<?php echo $home;?>" onclick="mode('video')" data-ajax="false"><img src="<?php bloginfo('template_url');?>/ui/play.png" class="ui-li-icon" />有视频有真相</a>
			</li>
			<!-- <li>
				<a href="#" onclick="mode(0)"><img src="<?php bloginfo('template_url');?>/ui/spinner.png" class="ui-li-icon" />穿越</a>
			</li> -->
			<?php $wxoid = blueria_get_option('weixin_original_id'); if ($wxoid) : ?>
			<li>
				<a href="weixin://qr/<?php echo $wxoid;?>" data-ajax="false"><img src="<?php bloginfo('template_url');?>/ui/weixin.png" class="ui-li-icon" />关注本站微信</a>
			</li>
			<?php endif; ?>
			<li data-icon="false"><a href="#" class='exit' rel="external">退出</a></li>
		</ul>
	</div><!-- /panel -->
	
	<?php $home_fixed_ad = blueria_get_option('mobi_home_fixed_ad'); if ( !empty($home_fixed_ad) ) : ?>
	<div class="ui-bar ui-bar-c ui-footer-fixed ui-ad">
		<?php echo $home_fixed_ad; ?>
	</div><!-- /footer -->
	<?php endif; ?>
	
	<div data-role="popup" id="shareMenu" data-theme="b">
		<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="b">
			<li data-role="divider" data-theme="a">分享至</li>
			<li><a href="#" class="shareto_sina"><img src="<?php bloginfo('template_url');?>/ui/forward_sina.png" class="ui-li-icon" />新浪微博</a></li>
			<li><a href="#" class="shareto_tencent"><img src="<?php bloginfo('template_url');?>/ui/forward_tencent.png" class="ui-li-icon" />腾讯微博</a></li>
			<li><a href="#" class="shareto_renren"><img src="<?php bloginfo('template_url');?>/ui/forward_renren.png" class="ui-li-icon" />人人网</a></li>
			<li data-role="divider" data-theme="a"></li>
		</ul>
	</div>
</div><!-- /page -->

<?php get_footer(); ?>