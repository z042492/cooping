<?php
//瑞课出品
//范叔开发出品的第一个完全WP自学模版
//很多代码都做了注解对您的学习更加容易
?>
<?php  
//载入筛选模版文件
include "inc/taxonomy.php";
include "inc/rewrite.php";

 //去除评论feed
remove_action( 'wp_head', 'feed_links_extra', 3 ); 
 //去除文章feed
remove_action( 'wp_head', 'feed_links', 2 );
//针对Blog的远程离线编辑器接口
remove_action( 'wp_head', 'rsd_link' ); 
//Windows Live Writer接口
remove_action( 'wp_head', 'wlwmanifest_link' ); 
//移除当前页面的索引
remove_action( 'wp_head', 'index_rel_link' );
//移除rel_canonical
//remove_action( 'wp_head', 'rel_canonical' );
//移除后面文章的url
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); 
//移除最开始文章的url
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); 
//自动生成的短链接
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
//移除相邻文章的url
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); 
//移除版本号
remove_action( 'wp_head', 'wp_generator' ); 
//emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//特色图片
//add_theme_support( 'post-thumbnails' );
//禁用修订版本
remove_action('post_updated', 'wp_save_post_revision',10,1);
//禁用自动保存，所以编辑长文章前请注意手动保存。
add_action( 'admin_print_scripts', create_function( '$a', "wp_deregister_script('autosave');" ) );
// WordPress 3.8测试有效
function keep_id_continuous(){
  global $wpdb;
  // 删掉自动草稿和修订版
  $wpdb->query("DELETE FROM `$wpdb->posts` WHERE `post_status` = 'auto-draft' OR `post_type` = 'revision'");
  // 自增值小于现有最大ID，MySQL会自动设置正确的自增值
  $wpdb->query("ALTER TABLE `$wpdb->posts` AUTO_INCREMENT = 1");  
}
add_filter( 'load-post-new.php', 'keep_id_continuous' );
add_filter( 'load-media-new.php', 'keep_id_continuous' );
add_filter( 'load-nav-menus.php', 'keep_id_continuous' );
//禁用谷歌字体
    function remove_open_sans() {
        wp_deregister_style( 'open-sans' );
        wp_register_style( 'open-sans', false );
        wp_enqueue_style('open-sans','');
    }
add_action( 'init', 'remove_open_sans' );
    //取消工具栏
add_filter( 'show_admin_bar', '__return_false' );	
  
/////////
function email_address_login($username) {
$user = get_user_by_email($username);
if(!empty($user->user_login))
$username = $user->user_login;
return $username;
}
add_action('wp_authenticate','email_address_login');

/*********用户评论******/
function user_comments_list( $comment, $args, $depth ){
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<a href="<?php echo get_permalink($comment->comment_post_ID);?>">
		<?php comment_text(); ?>
		</a>
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
			break;
	endswitch;
}
/*********获取用户************/
function wpuf_list_users() {
    if ( function_exists( 'get_users' ) ) {
        $users = get_users();
    } else {
        ////wp 3.1 fallback
        $users = get_users_of_blog();
    }

    $list = array();

    if ( $users ) {
        foreach ($users as $user) {
            $list[$user->ID] = $user->display_name;
        }
    }

    return $list;
}
/*************获取用户的评论总数*******************/
function get_user_comments_count($user_id){
	global $wpdb;
	$user_id = (int)$user_id;
	$sql = "select count(*) from {$wpdb->comments} where user_id='$user_id' and comment_approved = 1";
	$coo = $wpdb->get_var($sql);
	if($coo)
	return $coo;
	else
	return 0;
}

//获取第一张图片
function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];
 
  if(empty($first_img)){ //Defines a default image
    $first_img = "/wp-content/themes/aidianying/images/default.jpg";
  }
  return $first_img;
}
 // 自定义菜单
    register_nav_menus(
    array(
    'header-menu' => __( '导航自定义菜单' ),
    'anli-menu' => __( '案例自定义菜单' )
    )
    ); 
	
	
//根据作者ID获取该作者的文章数量
 function num_of_author_posts($authorID=''){ //根据作者ID获取该作者的文章数量
     if ($authorID) {
         $author_query = new WP_Query( 'posts_per_page=-1&author='.$authorID );
         $i=0;
         while ($author_query->have_posts()) : $author_query->the_post(); ++$i; endwhile; wp_reset_postdata();
         return $i;
     }
     return false;
 }
 function mun_of_author_comment($authorID=''){
	 if ($authorID) {
	$args = array(
    'user_id' => $authorID, // use user_id
        'count' => true //return only the count
	 );
	 $comments = get_comments($args);
	 return $comments;
	 }
     return false;
 }	
if ( !is_admin() )
{
    function add_scripts() {
        wp_deregister_script( 'jquery' ); 
        wp_register_script( 'jquery', 'http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js'); 
        wp_enqueue_script( 'jquery' ); 
    } 
  
    add_action('wp_enqueue_scripts', 'add_scripts');
}
/**
 *Load Scripts and Styles 
 */
function janezen_scripts_styles() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'janezen_scripts_styles' );


/* 访问计数 */
function record_visitors()
{
	if (is_singular())
	{
	  global $post;
	  $post_ID = $post->ID;
	  if($post_ID)
	  {
		  $post_views = (int)get_post_meta($post_ID, 'views', true);
		  if(!update_post_meta($post_ID, 'views', ($post_views+1)))
		  {
			add_post_meta($post_ID, 'views', 1, true);
		  }
	  }
	}
}
add_action('wp_head', 'record_visitors');
 
/// 函数名称：post_views
/// 函数作用：取得文章的阅读次数
function post_views($before = '(点击 ', $after = ' 次)', $echo = 1)
{
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  if ($echo) echo $before, number_format($views), $after;
  else return $views;
}

/* 时间显示方式xx以前
/* -------------------- */
function time_ago( $type = 'commennt', $day = 7 ) {

  $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';

  if (time() - $d('U') > 60*60*24*$day) return;

  echo human_time_diff($d('U'), strtotime(current_time('mysql', 0))), '前';

}

function timeago( $ptime ) {

	date_default_timezone_set ('ETC/GMT');

    $ptime = strtotime($ptime);

    $etime = time() - $ptime;

    if($etime < 1) return '刚刚';

    $interval = array (

        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',

        30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',

        7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',

        24 * 60 * 60            =>  '天前',

        60 * 60                 =>  '小时前',

        60                      =>  '分钟前',

        1                       =>  '秒前'

    );

    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

/*
*面包屑
*/
    function get_breadcrumbs()
    {
    global $wp_query;

    if ( !is_home() ){

    // Start the UL
    echo '<div class="nei_url">';
	echo '当前位置：';
    // Add the Home link
    echo '<a href="'. get_settings('home') .'">'.get_bloginfo('name').'</a> &raquo; ';

    if ( is_category() )
    {
    $catTitle = single_cat_title( "", false );
    $cat = get_cat_ID( $catTitle );
    echo "". get_category_parents( $cat, FALSE, FALSE ) ."";
	
    }
    elseif ( is_author() && !is_category() )
    {
     echo ''.wp_title('','', FALSE) .'"的个人主页';
    }
    elseif ( is_search() ) {

    echo "Search Results";
    }
    elseif ( is_404() )
    {
    echo "404 Not Found";
    }
    elseif ( is_single() )
    {
    $category = get_the_category();
    $category_id = get_cat_ID( $category[0]->cat_name );

    echo ''. get_category_parents( $category_id, TRUE, " &raquo; " );
    echo ''.the_title('','', FALSE) ."";
    }
    elseif ( is_page() )
    {
    $post = $wp_query->get_queried_object();

    if ( $post->post_parent == 0 ){

    echo "".the_title('','', FALSE)."";

    } else {
    $title = the_title('','', FALSE);
    $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
    array_push($ancestors, $post->ID);

    foreach ( $ancestors as $ancestor ){
    if( $ancestor != end($ancestors) ){
    echo '<a href="'. get_permalink($ancestor) .'">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</a> &raquo; ';
    } else {
    echo ''. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'';
    }
    }
    }
    }

    // End the UL
    echo "</ul></div>";
    }
    }
//
/**
* WordPress集成Auto-highslide图片灯箱（按需加载&无需插件）
*/
add_filter('the_content', 'addhighslideclass_replace');
function addhighslideclass_replace ($content)
{   global $post;
 $pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
    $replacement = '<a$1href=$2$3.$4$5 class="highslide-image" onclick="return hs.expand(this);"$6>$7</a>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
//评论添加验证码
   /* 评论必须有中文和禁止某些字段出现 */    
   function lianyue_comment_post( $incoming_comment ) {    
   $pattern = '/[一-龥]/u';    
   $http = '/[<|=|.|友|夜|KTV|ッ|の|ン|優|業|グ|貿|]/u';  
    // 禁止全英文评论  
   if(!preg_match($pattern, $incoming_comment['comment_content'])) {  
  wp_die( "您的评论中必须包含汉字，否则将被视为发贴机!" );  
  }elseif(preg_match($http, $incoming_comment['comment_content'])) {  
  wp_die( "万恶的发贴机，这里不允许放链接，如需交换链接请联系站长!" );    
  }    
   return( $incoming_comment );    
  }    
  add_filter('preprocess_comment', 'lianyue_comment_post');   

add_filter( 'get_avatar' , 'my_custom_avatar' , 1 , 5 );
function my_custom_avatar( $avatar, $id_or_email, $size, $default, $alt) {
	$user_id  = (int) $id_or_email;
    $file ="/wp-content/uploads/avatars/".md5($user_id).".jpg";
	
    return '<img src="'.$file.'" onerror="javascript:this.src=\'/wp-content/uploads/avatars/avatar.jpg\'"  height='.$size.' width='.$size.' class="avatar"/>';
}


//去除分类标志代码
    add_action( 'load-themes.php',  'no_category_base_refresh_rules');
    add_action('created_category', 'no_category_base_refresh_rules');
    add_action('edited_category', 'no_category_base_refresh_rules');
    add_action('delete_category', 'no_category_base_refresh_rules');
    function no_category_base_refresh_rules() {
        global $wp_rewrite;
        $wp_rewrite -> flush_rules();
    }
    // register_deactivation_hook(__FILE__, 'no_category_base_deactivate');
    // function no_category_base_deactivate() {
    //  remove_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
    //  // We don't want to insert our custom rules again
    //  no_category_base_refresh_rules();
    // }
    // Remove category base
    add_action('init', 'no_category_base_permastruct');
    function no_category_base_permastruct() {
        global $wp_rewrite, $wp_version;
        if (version_compare($wp_version, '3.4', '<')) {
            // For pre-3.4 support
            $wp_rewrite -> extra_permastructs['category'][0] = '%category%';
        } else {
            $wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
        }
    }
    // Add our custom category rewrite rules
    add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
    function no_category_base_rewrite_rules($category_rewrite) {
        //var_dump($category_rewrite); // For Debugging
        $category_rewrite = array();
        $categories = get_categories(array('hide_empty' => false));
        foreach ($categories as $category) {
            $category_nicename = $category -> slug;
            if ($category -> parent == $category -> cat_ID)// recursive recursion
                $category -> parent = 0;
            elseif ($category -> parent != 0)
                $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
            $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
			$category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
            $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
        }
        // Redirect support from Old Category Base
        global $wp_rewrite;
        $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
        $old_category_base = trim($old_category_base, '/');
        $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';
        //var_dump($category_rewrite); // For Debugging
		return $category_rewrite;
    }
    // Add 'category_redirect' query variable
    add_filter('query_vars', 'no_category_base_query_vars');
    function no_category_base_query_vars($public_query_vars) {
        $public_query_vars[] = 'category_redirect';
        return $public_query_vars;
    }
    // Redirect if 'category_redirect' is set
    add_filter('request', 'no_category_base_request');
    function no_category_base_request($query_vars) {
        //print_r($query_vars); // For Debugging
        if (isset($query_vars['category_redirect'])) {
            $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
			status_header(301);
            header("Location: $catlink");
            exit();
        }
        return $query_vars;
    }
add_filter('user_contactmethods', 'my_user_contactmethods');

function my_user_contactmethods($user_contactmethods){
  $user_contactmethods['user_qq'] = 'QQ帐号';
  $user_contactmethods['user_weibo'] = '新浪微博';
  return $user_contactmethods;
}	
	
     /*
    *给评论作者的链接新窗口打开
    */
    //function yundanran_get_comment_author_link($url)
   // {
  ///  $return=$url;
  ///  $p1="/^<a .*/i";
  ///  $p2="/^<a ([^>]*)>(.*)/i";
  //  if(preg_match($p1,$return))
  //  {
   /// $return=preg_replace($p2,"<a $1 target='_blank'>$2",$return);
   /// }
  //  return $return;
  //  }
  //  add_filter('get_comment_author_link','yundanran_get_comment_author_link');


if ( ! function_exists( 'janezen_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own janezen_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function janezen_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'janezen' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'janezen' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-meta comment-author vcard">
				
				<?php
				if($comment->user_id!=0){
					$author_posts_url=get_author_posts_url($comment->user_id);
					$author_posts_url='<a style="background: #cecece none repeat scroll 0 0;border-radius: 3px;padding:0 2px;" target=\'_blank\' href="'.$author_posts_url.'">';
				}else{
					$author_posts_url='<a>';
				}
					echo get_avatar( $comment->user_id, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						$author_posts_url.get_comment_author( $commentdata['comment_parent'] ).'</a>',
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( '本文作者', 'janezen' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'janezen' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'janezen' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'janezen' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '回复', 'janezen' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;
	
	
	/*
	*
	评论添加@，by Ludou
	*/
function ludou_comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
  }

  return $comment_text;
}
add_filter( 'comment_text' , 'ludou_comment_add_at', 20, 2);


/* comment_mail_notify v1.0 by janezen. (所有回复都发邮件) */



//smtp
add_action('phpmailer_init', 'mail_smtp');
function mail_smtp( $phpmailer ) {
$phpmailer->FromName = '运营笔记(系统)'; //发信人名称
$phpmailer->Host = 'smtp.exmail.qq.com'; //smtp服务器
$phpmailer->Port = 465;  //端口
$phpmailer->Username = 'service@xxxxx.com';//邮箱帐号  
$phpmailer->Password = 'xxxxxx';//邮箱密码
$phpmailer->From = 'service@xxxxxxx.com'; //邮箱帐号
$phpmailer->SMTPAuth = true;  
$phpmailer->SMTPSecure = 'ssl'; //tls or ssl （port=25留空，465为ssl）
$phpmailer->IsSMTP();
}
//评论回复邮件
function comment_mail_notify($comment_id){
    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $spam_confirmed = $comment->comment_approved;
    if(($parent_id != '') && ($spam_confirmed != 'spam')){
    $wp_email = 'webmaster@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '你在 [' . get_option("blogname") . '] 的留言有了回应';
    $message = '
    <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-style: solid; border-width: 1;" bordercolor="#85C1DF" width="700" height="251" id="AutoNumber1" align="center">
          <tr>
            <td width="520" height="28" bgcolor="#F5F9FB"><font color="#1A65B6" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<b>留言回复通知 | <a href="http://www.ccoooo.com" targe="blank">运营笔记(www.ccoooo.com)</a></b></font></td>
          </tr>
          <tr>
            <td width="800" height="210" bgcolor="#FFffff" valign="top" style=" padding:8px;">&nbsp;&nbsp;<span class="STYLE2"><strong >' . trim(get_comment($parent_id)->comment_author) . '</strong>, 你好!</span>
              <p>&nbsp;&nbsp;<span class="STYLE2">你曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />&nbsp;&nbsp;--->'
        . trim(get_comment($parent_id)->comment_content) . '<br /><br />
              &nbsp;&nbsp; ' . trim($comment->comment_author) . ' 给你的回复:<br />&nbsp;&nbsp;--->'
        . trim($comment->comment_content) . '</span></p>
        <p > &nbsp;&nbsp;<Strong>你可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回复完整内容</a></Strong></p>
              <p><span class="STYLE2"> &nbsp;&nbsp;<strong>感谢你对 <a href="' . get_option('home') . '" target="_blank">' . get_option('blogname') . '</a> 的关注！</p>
            </td>
          </tr>
          <tr>
            <td width="800" height="16" bgcolor="#85C1DF" bordercolor="#008000"><div align="center"><font color="#fff"><a href="http://www.ccoooo.com">运营笔记(www.ccoooo.com)</a></font></div></td>
          </tr>
  </table>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
  }
}
add_action('comment_post', 'comment_mail_notify');


?>
