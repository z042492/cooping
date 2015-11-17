<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php if (is_single() || is_page() || is_archive() || is_search()) { ?><?php wp_title('',true); ?> - <?php } bloginfo('name'); ?><?php if ( is_home() ){ ?> - <?php bloginfo('description'); ?><?php } ?><?php if ( is_paged() ){ ?> - <?php printf( __('Page %1$s of %2$s', ''), intval( get_query_var('paged')), $wp_query->max_num_pages); ?><?php } ?></title>
   
    <?php 
	if (is_home()){ 
		$description     = get_option('vfilmtheme_description');
		$keywords = get_option('vfilmtheme_keywords');
	} elseif (is_single() || is_page()){    
		$description1 =  $post->post_excerpt ;
		$description2 = mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 200, "…");
		$description = $description1 ? $description1 : $description2;
		$keywords = "";        
		$tags = wp_get_post_tags($post->ID);
		foreach ($tags as $tag ) {
			$keywords = $keywords . $tag->name . ", ";
		}
	} elseif(is_category()){
		$description     = strip_tags(category_description());
		$current_category = single_cat_title("", false);
		$keywords =  $current_category;
	}
	?>
	<meta name="keywords" content="<?php echo $keywords ?>" />
	<meta name="description" content="<?php echo $description ?>" />

<link rel="Shortcut Icon" href="<?php bloginfo('template_url');?>/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/style.css"/>
<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>

<script type="text/javascript">
	!window.jQuery && document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"><\/script>');
</script>
<!--[if IE 6]>
	<script src="//letskillie6.googlecode.com/svn/trunk/2/zh_CN.js"></script>
<![endif]-->

<script src="<?php bloginfo('template_url'); ?>/js/js.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/site.js"></script>




	
<?php wp_head(); ?>

</head>
<body class="custom-background"> 
<div id="wrap">
	<div id="menu">
		<a href="<?php bloginfo('url'); ?>"/>
		<?php if (get_option('vfilmtheme_logo')) { ?>
		<img src="<?php echo get_option('vfilmtheme_logo'); ?>" width="250" height="100" alt="<?php bloginfo('name'); ?>"/>
		<?php }else{ ?>
		<img src="<?php bloginfo('template_url'); ?>/img/logo.png" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" />
		<?php }?></a>
		
		<?php 
		  		wp_nav_menu(
							  array(	
							  			'theme_location'   => 'homepage',
										'sort_column'      => 'menu_order',
										'menu_class'       => 'out',
										'link_before'      => '<span class="line">',
										'link_after'       => '</span>',
										'depth'           => 0,
										
									) 
					 		); 
		?>
		
		<div class="lianxi">
		<div id="coder" href="javascript:;"><id='weixin' name="weixin"/><a class="rss">订阅我们的微信公众平台</a></div>
				
		<?php if (get_option('vfilmtheme_wbdz')) { ?>
		<a class="mark" href="<?php echo get_option('vfilmtheme_wbdz'); ?>" rel="external nofollow" title="关注我们的新浪微博" target="_blank">关注我们的新浪微博</a>
		<?php }else{ ?>
		<a class="mark" href="http://weibo.com/345990994" rel="external nofollow" title="关注我们的新浪微博" target="_blank">关注我们的新浪微博</a>
		<?php }?>
		
		</div>
		<div id="qr_code">
		<?php if (get_option('vfilmtheme_wxtp')) { ?>
		<img src="<?php echo get_option('vfilmtheme_wxtp'); ?>" width="130" height="130" alt="<?php bloginfo('name'); ?>"/>
		<?php }else{ ?>
		<img src="<?php bloginfo('template_url'); ?>/img/weixinpic.jpg" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" width="130" height="130" />
		<?php }?>
		</div>
		<form id="search" method="get" action="<?php bloginfo('url'); ?>">
			<input type="text" name="s"  placeholder="Search"  />
		</form>

	</div>
	