<!DOCTYPE html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/zzsc.js" ></script>
<!-- 引入字体样式表-->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/fonts/font-awesome/font-awesome.css"  media="all" />
<!-- 引入SEO-->
<?php get_template_part( 'inc/seo' ); ?>
<meta name="viewport" content="width=device-width">
<link rel="shortcut icon" href="/images/fav.ico">
<?php wp_head(); ?>
</head>
<body>
  <div id="header" class="w-1000">
	<div class="wrap">
		<a href="<?php bloginfo('url');?>">
			<h2><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" class="logo" alt="瑞课教育"></h2>
		</a>
		<div class="search-section">
			<form method="get" id="headsearch" action="<?php bloginfo('url');?>">
				<input type="hidden" name="genre" value="" />
				<input class="search-text" type="text" name="s" autocomplete="off" id="web_search_header" placeholder="搜您喜欢的AV" value="" style="padding-right: 55px;">
				<input type="submit" class="search-btn" value="">
			</form>
		</div>
	<?php
							$current_user = wp_get_current_user();
							if ( 0 == $current_user->ID ) {
						?>

		<div class="loginbox">
			<span><a data-sign="0" rel="nofollow" id="user-signin" class="user-login"><?php _e(' 登录','rk'); ?></a></span>
			<em style="padding: 0px 10px">|</em><span><a data-sign="1" rel="nofollow" id="user-reg" class="user-reg"><?php _e('注册','rk'); ?></a></span>
			 <?php
							} else {
						?>

		<div class="loginbox">
			<div class="userMenu"><a href="<?php bloginfo('url'); ?>/wp-admin/profile.php" rel="nofollow"><?php echo $current_user->display_name;?><i class="arrow"></i></a>
				<div class="userMenu-menu"><i class="arrow"></i>
					<ul>
						<li><a href="<?php bloginfo('url'); ?>/author/<?php echo $current_user->user_login;?>">个人主页</a></li>
						<!-- 这里应该在/后面加上你的自定义编辑资料链接-->
						<li><a href="<?php bloginfo('url'); ?>/"><i class="fa fa-cog"></i>编辑资料</a></li>
						<li><a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e('注销登录','rk'); ?>"><i class="fa fa-sign-out"></i><?php _e('退出账号','rk'); ?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
			<?php
							}
						?> 
		</div>
	</div>
</div>
<div class="navpositon">
<div class="w-10002">
    <div id="navbox">
	   <div class="navbox">
			    <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
            <div class="user-need">
                <a href="http://www.ruikeedu.com/bbs">
                <i class="fa fa-star-half-o"></i>
                    <span>求课程</span>
                </a>
                <a href="http://www.ruikeedu.com/zhujiao" rel="nofollow" target="_blank">
                <i class="fa fa-microphone"></i>
                    <span>申请讲师</span>
                </a>
            </div>
	 </div>  
    </div>
</div>
</div>
