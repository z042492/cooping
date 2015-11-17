<?php 
    /*--------------- [ 网站临时维护 ] -----------------*/
    /*function wp_maintenance_mode(){
        if(!current_user_can('edit_themes') || !is_user_logged_in()){
            wp_die('<meta charset="UTF8" />
网站临时维护中，请稍后...', '网站临时维护中，请稍后...', array('response' => '503'));
        }
    }
    add_action('get_header', 'wp_maintenance_mode');*/
    
    /*--------------- [ wp_head() 的处理 ] -----------------*/

    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 ); //删除短链接shortlink
    remove_action( 'wp_head', 'wp_generator' ); //删除版权
    remove_action( 'wp_head', 'feed_links_extra', 3 ); //删除包含文章和评论的feed
    remove_action( 'wp_head', 'rsd_link' ); //删除外部编辑器
    remove_action( 'wp_head', 'wlwmanifest_link' ); //删除外部编辑器
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); //删除上一篇下一篇
    add_filter('show_admin_bar','__return_false'); //移除admin条
    foreach(array('comment_text','the_content','the_excerpt','the_title') as $xx)
    remove_filter($xx,'wptexturize'); //禁止半角符号自动变全角
    remove_filter('comment_text','capital_P_dangit',31);
    remove_filter('the_content','capital_P_dangit',11);
    remove_filter('the_title','capital_P_dangit',11); //禁止自动把’Wordpress’之类的变成’WordPress’

    /*--------------- [ 自定义登录失败的信息 ] -----------------*/

       /***********************************************
        *                增强网站安全性。
	*  我们知道，当我们输入一个存在的用户名，但是输入错误的密码
        *  wordpress默认会返回的信息是该账户的密码不正确，
        *  这就等于告诉黑客确实存在这样的账户，方便了黑客进行下一步行动。
	***********************************************/

    function failed_login() {
        return 'Incorrect login information.';
    }
    add_filter('login_errors', 'failed_login');
    
    /*--------------- [ 多说 移到底部 ] -----------------*/

   /* add_action('init', 'move_duoshuo_js_to_footer');
    function move_duoshuo_js_to_footer() {
	global $duoshuoPlugin;
	remove_action('wp_print_scripts', array($duoshuoPlugin, 'appendScripts'));
	add_action('wp_footer',array($duoshuoPlugin, 'appendScripts'));
     }*/

    /*--------------- [ 为前后页添加class ] -----------------*/
    add_filter('next_posts_link_attributes','add_next',10,0);
    function add_next(){
        $class = 'class="next"';
        return $class;
    }
    
    add_filter('previous_posts_link_attributes','add_previous',10,0);
    function add_previous(){
        $class = 'class="prev"';
        return $class;
    }
    
    /*--------------- [ 菜单 ] -----------------*/

    add_theme_support('nav-menus');

    if( function_exists('register_nav_menus') )
    {   
        register_nav_menus( array( 'homepage' => __( '主页菜单' ),'friends' => __( '友情链接' )  ) );
    }
	
	
		/*--------------- [ 主题设置 ] -----------------*/
    function new_meta_boxes() {
    global $post, $new_meta_boxes;

    foreach((array)$new_meta_boxes as $meta_box) {
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);

        if($meta_box_value == "")
            $meta_box_value = $meta_box['std'];

        echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

        // 自定义字段标题
        echo'<h4>'.$meta_box['title'].'</h4>';

        // 自定义字段输入框
        echo '<textarea cols="60" rows="1" name="'.$meta_box['name'].'_value">'.$meta_box_value.'</textarea><br />';
    }
}

function create_meta_box() {
    global $theme_name;

    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'new-meta-boxes', '自定义模块', 'new_meta_boxes', 'post', 'normal', 'high' );
    }
}

function save_postdata( $post_id ) {
    global $post, $new_meta_boxes;

    foreach((array)$new_meta_boxes as $meta_box) {
        if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) ))  {
            return $post_id;
        }

        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ))
                return $post_id;
        } 
        else {
            if ( !current_user_can( 'edit_post', $post_id ))
                return $post_id;
        }

        $data = $_POST[$meta_box['name'].'_value'];

        if(get_post_meta($post_id, $meta_box['name'].'_value') == "")
            add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
        elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
            update_post_meta($post_id, $meta_box['name'].'_value', $data);
        elseif($data == "")
            delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
    }
}

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');

/*--------------- [ 以上为主题设置 ] -----------------*/

//注册控制面板
require_once(TEMPLATEPATH . '/control.php');


    /*---------------- [ 获取缩略图 ]------------------*/
    
	//缩略图设置
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(340, 180, true); 

add_theme_support( 'post-thumbnails' );
if ( ! function_exists( 'post_thumbnail' ) ) :
function post_thumbnail() {  
	global $post;  
	if ( has_post_thumbnail() ) {   
		$domsxe = simplexml_load_string(get_the_post_thumbnail());
		$thumbnailsrc = $domsxe->attributes()->src;  
		echo '<img src="'.$thumbnailsrc.'" alt="'.trim(strip_tags( $post->post_title )).'" />';
	} else {
		$content = $post->post_content;  
		preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);  
		$n = count($strResult[1]);  
		if($n > 0){
			echo '<img src="'.$strResult[1][0].'" alt="'.trim(strip_tags( $post->post_title )).'" />';  
		}else {
			echo '<img src="'.get_bloginfo('template_url').'/img/default.png" alt="'.trim(strip_tags( $post->post_title )).'" />';  
		}  
	}  
}
endif;


     /*---------------- [ 随机文章 ]------------------*/
    function random_posts($posts_num=5,$before='<li>',$after='</li>'){
        global $wpdb;
        $sql = "SELECT ID, post_title,guid
                FROM $wpdb->posts
                WHERE post_status = 'publish' ";
        $sql .= "AND post_title != '' ";
        $sql .= "AND post_password ='' ";
        $sql .= "AND post_type = 'post' ";
        $sql .= "ORDER BY RAND() LIMIT 0 , $posts_num ";
        $randposts = $wpdb->get_results($sql);
        $output = '';
        foreach ($randposts as $randpost) {
            $post_title = stripslashes($randpost->post_title);
            $permalink = get_permalink($randpost->ID);
            $output .= $before.'<a href="'
                . $permalink . '"  rel="bookmark" title="';
            $output .= $post_title . '">' . $post_title . '</a>';
            $output .= $after;
        }
        echo $output;
    }

    function wp_pagenavi( $p = 3 ) {
          if ( is_singular() ) return;
          global $wp_query, $paged;
          $max_page = $wp_query->max_num_pages;
          if ( $max_page == 1 ) return;
          if ( empty( $paged ) ) $paged = 1;
          echo '<div class="wp-pagenavi pagination pull-center"><ul>';
          if ( $paged > 4 ) p_link( 1, '|<' );
          if ( $paged > 1 ) p_link( $paged-1, '«' );
          for( $i = $paged - $p ; $i <= $paged + $p ; $i++ ) {
            if ( $i > 0 && $i <= $max_page ) 
                $i == $paged ? print "<li><span class='current'>{$i}</span></li> " : p_link( $i );
          }
          if ( $paged < $max_page ) p_link( $paged+1, '»' );
          if ( $paged < $max_page-3 ) p_link( $max_page, '>|' );
          echo '</ul></div>';
    };
    function p_link( $i, $title = '' ) {
          if ( $title == '' ) $title = "{$i}";
          echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "'>{$title}</a></li>";
    };

	
	/*激活友情链接后台*/
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
	
	
	/*面包屑导航*/
function get_breadcrumbs()  
{  
    global $wp_query;  
    
    if ( !is_home() ){  
    
        // Start the UL  
        echo '<ul class="breadcrumbs">';  
        // Add the Home link  
        echo '<li><a href="'. get_settings('home') .'">'. get_bloginfo('name') .'</a></li>';  
    
        if ( is_category() )  
        {  
            $catTitle = single_cat_title( "", false );  
            $cat = get_cat_ID( $catTitle );  
            echo "<li> &raquo; ". get_category_parents( $cat, TRUE, " &raquo; " ) ."</li>";  
        }  
        elseif ( is_archive() && !is_category() )  
        {  
            echo "<li> &raquo; Archives</li>";  
        }  
        elseif ( is_search() ) {  
    
            echo "<li> &raquo; Search Results</li>";  
        }  
        elseif ( is_404() )  
        {  
            echo "<li> &raquo; 404 Not Found</li>";  
        }  
        elseif ( is_single() )  
        {  
            $category = get_the_category();  
            $category_id = get_cat_ID( $category[0]->cat_name );  
    
            echo '<li> &raquo; '. get_category_parents( $category_id, TRUE, " &raquo; " );  
            echo the_title('','', FALSE) ."</li>";  
        }  
        elseif ( is_page() )  
        {  
            $post = $wp_query->get_queried_object();  
    
            if ( $post->post_parent == 0 ){  
    
                echo "<li> &raquo; ".the_title('','', FALSE)."</li>";  
    
            } else {  
                $title = the_title('','', FALSE);  
                $ancestors = array_reverse( get_post_ancestors( $post->ID ) );  
                array_push($ancestors, $post->ID);  
    
                foreach ( $ancestors as $ancestor ){  
                    if( $ancestor != end($ancestors) ){  
                        echo '<li> &raquo; <a href="'. get_permalink($ancestor) .'">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</a></li>';  
                    } else {  
                        echo '<li> &raquo; '. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</li>';  
                    }  
                }  
            }  
        }  
    
        // End the UL  
        echo "</ul>";  
    }  
}  

// 分页代码
function par_pagenavi($range = 3){  
    global $paged, $wp_query;  
    if ( !$max_page ) {$max_page = $wp_query->max_num_pages;}  
    if($max_page > 1){if(!$paged){$paged = 1;}  
    if($paged != 1){echo "<a href='" . get_pagenum_link(1) . "' class='extend' title='跳转到首页'>首页</a>";}  
    if($max_page > $range){  
        if($paged < $range){for($i = 1; $i <= ($range + 1); $i++){echo "<a href='" . get_pagenum_link($i) ."'";  
        if($i==$paged)echo " class='current'";echo ">$i</a>";}}  
    elseif($paged >= ($max_page - ceil(($range/2)))){  
        for($i = $max_page - $range; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";  
        if($i==$paged)echo " class='current'";echo ">$i</a>";}}  
    elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){  
        for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){echo "<a href='" . get_pagenum_link($i) ."'";if($i==$paged) echo " class='current'";echo ">$i</a>";}}}  
    else{for($i = 1; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";  
    if($i==$paged)echo " class='current'";echo ">$i</a>";}}  
    next_posts_link(' 下页 ');  
    if($paged != $max_page){echo "<a href='" . get_pagenum_link($max_page) . "' class='extend' title='跳转到最后一页'> 尾页 </a>";}}  
}  

// 开启背景功能，需要替换所有文件内的<body>为<body class="custom-background"> 
add_custom_background();

//添加HTML编辑器自定义快捷标签按钮
add_action('after_wp_tiny_mce', 'bolo_after_wp_tiny_mce');
function bolo_after_wp_tiny_mce($mce_settings) {
?>
<script type="text/javascript">
QTags.addButton( 'h3', 'H3', "<h3>", "</h3>" );
QTags.addButton( 'download', '文件下载', "[download]", "[/download]" );
QTags.addButton( 'music', '音乐试听', "[music]", "[/music]" );
QTags.addButton( 'music2', '音乐auto', "[music auto=1]", "[/music]" );

function bolo_QTnextpage_arg1() {
}
</script>
<?php
}
//增加在线观影短代码
  function vfilmtheme_zxk($atts, $content = null)
    {

     return '<div class="zxk"><a href="'.$content.'" target="_blank" rel="nofollow">在线观影</a></div>';
    }
    add_shortcode("zxk", "vfilmtheme_zxk");
	
//增加文件下载短代码
  function vfilmtheme_download($atts, $content = null)
    {

     return '<div class="download"><a href="'.$content.'" target="_blank" rel="nofollow">文件下载</a></div>';
    }
    add_shortcode("download", "vfilmtheme_download");
	
//音乐播放器  
function doubanplayer($atts, $content=null){  
    extract(shortcode_atts(array("auto"=>'0'),$atts));  
    return '<embed src="'.get_bloginfo("template_url").'/shortcode/doubanplayer.swf?url='.$content.'&amp;autoplay='.$auto.'" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" width="400" height="30">';  
    }  
add_shortcode('music','doubanplayer');  
   
   /*小工具*/
if( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => '底部小工具（注意：最多放2个小工具）',
		'id'            => 'widget_vfilmtheme',
		'before_widget' => '<div class="sidebox">', // widget 的开始标签
		'after_widget' => '</div>', // widget 的结束标签
		'before_title' => '<h2>', // 标题的开始标签
		'after_title' => '</h2>' // 标题的结束标签
	));
	
}
//激活小工具
include('widgets/index.php');

 // 屏蔽WordPress默认小工具
add_action( 'widgets_init', 'my_unregister_widgets' );   
function my_unregister_widgets() {   
    unregister_widget( 'WP_Widget_Archives' );   
    unregister_widget( 'WP_Widget_Calendar' );   
    unregister_widget( 'WP_Widget_Categories' );   
    unregister_widget( 'WP_Widget_Links' );   
    unregister_widget( 'WP_Widget_Meta' );   
    unregister_widget( 'WP_Widget_Pages' );   
    unregister_widget( 'WP_Widget_Recent_Comments' );   
    unregister_widget( 'WP_Widget_Recent_Posts' );   
    unregister_widget( 'WP_Widget_RSS' );   
    unregister_widget( 'WP_Widget_Search' );   
    unregister_widget( 'WP_Widget_Tag_Cloud' );   

    unregister_widget( 'WP_Nav_Menu_Widget' );   
}  

add_filter( 'avatar_defaults', 'fb_addgravatar' );
function fb_addgravatar( $avatar_defaults ) {
$myavatar = get_bloginfo('template_directory') . '/img/gravatar.png';
  $avatar_defaults[$myavatar] = '自定义头像';
  return $avatar_defaults;
}

function vfilmtime_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    global $commentcount,$wpdb, $post;
    if(!$commentcount) {
    $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_type = '' AND comment_approved = '1' AND !comment_parent");
    $cnt = count($comments);
    $page = get_query_var('cpage');
    $cpp=get_option('comments_per_page');
    if (ceil($cnt / $cpp) == 1 || ($page > 1 && $page  == ceil($cnt / $cpp))) {
    $commentcount = $cnt + 1;
    } else {
    $commentcount = $cpp * $page + 1;
    }
    }
?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
   <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
      <?php $add_below = 'div-comment'; ?>
        <div class="comment-author"><?php if (get_option('vfilmtime_localavatar') == 'Display') { ?>
            <?php
                $p = 'avatar/';
                $f = md5(strtolower($comment->comment_author_email));
                $a = $p . $f .'.png';
                $e = ABSPATH . $a;
                if (!is_file($e)){ 
                $d = get_bloginfo('wpurl'). '/avatar/default.png';
                $s = '40';
                $r = get_option('avatar_rating');
                $g = 'http://www.gravatar.com/avatar/'.$f.'.jpg?s='.$s.'&d='.$d.'&r='.$r;
                $avatarContent = file_get_contents($g);
                file_put_contents($e, $avatarContent);
                if ( filesize($e) == 0 ){ copy($d, $e); }
                };
            ?>
            <img src='<?php bloginfo('wpurl'); ?>/<?php echo $a ?>' alt='' class='avatar' />
                <?php { echo ''; } ?>
            <?php } else { ?><?php echo get_avatar( $comment, 40 ); ?><?php } ?>
<div style="float:right"><span class="floor">
<?php
 if(!$parent_id = $comment->comment_parent){
   switch ($commentcount){
     case 2 :echo "沙发";--$commentcount;break;
     case 3 :echo "板凳";--$commentcount;break;
     case 4 :echo "地板";--$commentcount;break;
     default:printf('%1$s楼', --$commentcount);
   }
 }
 ?></span><span class="datetime"><?php comment_date('Y-m-d') ?> <?php comment_time() ?></span><span class="reply"><?php comment_reply_link(array_merge( $args, array('reply_text' => '回复', 'add_below' =>$add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span></div>
<?php comment_author_link() ?>
 </div>
        <?php if ( $comment->comment_approved == '0' ) : ?>
            <span style="color:#2CB4BF; font-size: 14px;">您的评论正在等待审核中...</span>
            <br />          
        <?php endif; ?>
        <?php comment_text() ?>
        </div>
        <div class="clear"></div>
  
<?php
}
function vfilmtime_end_comment() {
        echo '</li>';
}



//评论邮件自动通知
function comment_mail_notify($comment_id) {
  $admin_email = get_bloginfo ('admin_email');
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  $to = $parent_id ? trim(get_comment($parent_id)->comment_author_email) : '';
  $spam_confirmed = $comment->comment_approved;
  if (($parent_id != '') && ($spam_confirmed != 'spam') && ($to != $admin_email) && ($comment_author_email == $admin_email)) {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 發出點, no-reply 可改為可用的 e-mail.
    $subject = '您在 [' . get_option("blogname") . '] 的评论有新的回复';
    $message = '
    <div style="font: 13px Microsoft Yahei;padding: 0px 20px 0px 20px;border: #ccc 1px solid;border-left-width: 4px; max-width: 600px;margin-left: auto;margin-right: auto;">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您曾在 [' . get_option("blogname") . '] 的文章 《' . get_the_title($comment->comment_post_ID) . '》 上发表评论：<br />'
       . nl2br(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 给您的回复如下:<br>'
       . nl2br($comment->comment_content) . '</p>
      <p style="color:#f00">您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment'))) . '">查看回复的完整內容</a></p>
      <p style="color:#f00">欢迎再次光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p style="color:#999">(此邮件由系统自动发出，请勿回复。)</p>
    </div>';
    $message = convert_smilies($message);
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
  }
}
//自定义评论表情
add_action('comment_post', 'comment_mail_notify');
add_filter('smilies_src','custom_smilies_src',1,10);
 function custom_smilies_src ($img_src, $img, $siteurl){
     return get_bloginfo('template_directory').'/img/bobo/'.$img;
 }

if ( !isset( $wpsmiliestrans ) ) {
        $wpsmiliestrans = array(
':bobo_bulini:' => 'bobo_bulini.gif',
':bobo_buyaoa:' => 'bobo_buyaoa.gif',
':bobo_chifan:' => 'bobo_chifan.gif',
':bobo_chijing:' => 'bobo_chijing.gif',
':bobo_chixigua:' => 'bobo_chixigua.gif',
':bobo_feiwen:' => 'bobo_feiwen.gif',
':bobo_gongxi:' => 'bobo_gongxi.gif',
':bobo_hi:' => 'bobo_hi.gif',
':bobo_jiujie:' => 'bobo_jiujie.gif',
':bobo_mobai:' => 'bobo_mobai.gif',
':bobo_ok:' => 'bobo_ok.gif',
':bobo_paomeiyan:' => 'bobo_paomeiyan.gif',
':bobo_paopaotang:' => 'bobo_paopaotang.gif',
':bobo_paoqian:' => 'bobo_paoqian.gif',
':bobo_ren:' => 'bobo_ren.gif',
':bobo_shengmenqi:' => 'bobo_shengmenqi.gif',
':bobo_tiaopi:' => 'bobo_tiaopi.gif',
':bobo_toukan:' => 'bobo_toukan.gif',
':bobo_weiqu:' => 'bobo_weiqu.gif',
':bobo_xianhua:' => 'bobo_xianhua.gif',
':bobo_yiwen:' => 'bobo_yiwen.gif',
':bobo_zhuakuang:' => 'bobo_zhuakuang.gif',
        );
}
?>