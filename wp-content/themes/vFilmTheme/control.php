<?php
$themename = "vfilmtheme主题";   
$shortname = "vfilmtheme"; 
$options = array (
    array("name" => "SEO设置","type" => "heading","desc" => ""),
	array("name" => "首页关键词 keywords","id" => $shortname."_keywords","std" => "","type" => "text"),
	array("name" => "首页描述 description","id" => $shortname."_description","std" => "","type" => "text"),
	array("name" => "LOGO设置","type" => "heading","desc" => ""),
	array("name" => "头部LOGO图片地址","id" => $shortname."_logo","std" => "","type" => "text"),
	array("name" => "归档页广告图","type" => "heading","desc" => "图片大小：宽740px，高90px"),
	array("name" => "广告图片地址","id" => $shortname."_ad01","std" => "","type" => "text"),
	array("name" => "广告链接","id" => $shortname."_ad02","std" => "","type" => "text"),
	
	array("name" => "动态设置","type" => "heading","desc" => ""),
	array("name" => "最新动态","id" => $shortname."_cat01","std" => "","type" => "text"),
	
	array("name" => "其他设置","type" => "heading","desc" => ""),
	array("name" => "备案号","id" => $shortname."_cat05","std" => "","type" => "text"),
	array("name" => "网站统计","id" => $shortname."_cat06","std" => "","type" => "text"),
	array("name" => "SNS设置","type" => "heading","desc" => ""),
	array("name" => "新浪微博地址","id" => $shortname."_wbdz","std" => "","type" => "text"),
	array("name" => "微信图片地址","id" => $shortname."_wxtp","std" => "","type" => "text"),
	
);
function mytheme_add_admin() {
    global $themename, $shortname, $options;
    if ( $_GET['page'] == basename(__FILE__) ) {
        if ( 'save' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
            update_option( $value['id'], stripslashes($_REQUEST[ $value['id'] ]) ); }
            foreach ($options as $value) {
            if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], stripslashes($_REQUEST[ $value['id'] ])  ); } else { delete_option( $value['id'] ); } }
            header("Location: themes.php?page=control.php&saved=true");    //这里的 control.php 就是这个文件的名称
            die;
        } else if( 'reset' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                delete_option( $value['id'] );
                update_option( $value['id'], $value['std'] );
            }
            header("Location: themes.php?page=control.php&reset=true");    //这里的 control.php 就是这个文件的名称
            die;
        }
    }
    add_theme_page($themename." Options", "$themename 设置", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}
function mytheme_admin() {
    global $themename, $shortname, $options;
    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' 设置已保存。</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' 设置已重置。</strong></p></div>';
?>
    <style type="text/css">
    th{text-align:left;}
    textarea{width:600px;}
    input {width: 100%;}
    .submit{width:100px;padding:0;}
    .defaultbutton{padding-left:745px;}
    </style>
    <div class="wrap">
        <h2><b><?php echo $themename; ?> 设置</b>
		 <span style="font-size:12px !important;">Theme By&nbsp;<a href="http://vfilmtime.com/" target="_blank">小苏</a> & <a href="http://banri.me/" target="_blank" rel="nofollow">Banzi</a> &nbsp;&nbsp; <a href="http://vfilmtime.com/" target="_blank">访问<?php echo $themename; ?>主页</a></span>
		</h2>
        <form method="post">
         
            <table class="optiontable" >
                <?php foreach ($options as $value) {
                    if ($value['type'] == "text") { ?>
                        <tr align="left">
                            <th scope="row"><?php echo $value['name']; ?>:</th>
                            <td>
                                <!--input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" size="40" /-->
                                <textarea rows="2" cols="100" id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>"><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea>
                            </td>
                        </tr>
                    <?php } elseif ($value['type'] == "heading") { ?>
                        <tr valign="top">
                            <td colspan="2" style="text-align: left;">
                            <h2><?php echo $value['name']; ?></h2></td>
                            <tr><td colspan=2> <p style="color:#000; margin:0 0;" > <?php echo $value['desc']; ?> </P> <hr /></td></tr>
                        </tr>
					<?php } ?>
                    <?php
                }
                ?>
            </table>
            <hr />
            <div class="submit">
                <input style="font-size:12px !important;" name="save" type="submit" value="保存设置" />   
                <input type="hidden" name="action" value="save" />
            </div>
        </form>
		<form method="post" class="defaultbutton">
            <div class="submit">
                <input style="font-size:12px !important;" name="reset" type="submit" value="还原默认设置" />
                <input type="hidden" name="action" value="reset" />
            </div>
        </form>
        
    </div>
    <?php
}
add_action('admin_menu', 'mytheme_add_admin');
?>