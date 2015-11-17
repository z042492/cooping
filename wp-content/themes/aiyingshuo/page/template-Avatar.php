<?php
/*
Template Name: 修改头像
*/
// 以下代码判断是否登录
if ( !is_user_logged_in() ) wp_redirect( get_bloginfo('url') );
// 以下代码查询用户
global $wp_query;
$curauth = wp_get_current_user();

// 以上代码更新用户资料
if(isset($_POST['picSubmit'])){
//创建一个数组，用来判断上传来的图片是否合法
$uptypes    = array(
                    'image/jpg',
                    'image/jpeg'
                );
$files     = $_FILES["uppic"];
if($files["size"] > 2097152){
   $success_msg =  "上传图片不能大于2M";
    exit;
}
$ftype    = $files["type"];
if(!in_array($ftype,$uptypes)){
    $success_msg = "上传的图片文件格式不正确";
    exit;
}
$fname    = $files["temp_name"];

$name    = $files["name"];
$str_name    = pathinfo($name);
$extname    = strtolower($str_name["extension"]);
$upload_dir    = "wp-content/uploads/avatars/";
$file_name    =  md5($current_user->ID).".".$extname;
$str_file    = $upload_dir.$file_name;
if(!file_exists($upload_dir)){
    mkdir($upload_dir);
}
if(!move_uploaded_file($files["tmp_name"],$str_file)){
    $success_msg = "图片上传失败";
    exit;
}else{
    $success_msg = "图片上传成功";   
}
//调整上传图片的大小
$width=180; 
$height=180; 
$size=getimagesize($str_file); 
if($size[2]==1)
$im_in=imagecreatefromgif($str_file);  
if($size[2]==2)
$im_in=imagecreatefromjpeg($str_file);  
if($size[2]==3)
$im_in=imagecreatefrompng($str_file); 
$im_out=imagecreatetruecolor($width,$height); 
imagecopyresampled($im_out,$im_in,0,0,0,0,$width,$height,$size[0],$size[1]); 
imagejpeg($im_out,$str_file);
imagedestroy($im_in); 
imagedestroy($im_out);
}
get_header(); 
?>
<div class="w1200m">
<div class="profile">
<div class="profile-left">
<div class="with-padding">
<h3 class="with-padding">用户中心</h3>
<div id="aside">
<?php wp_nav_menu( array( 'theme_location' => 'anli-menu' ) ); ?>
</div>
</div>
</div>
<div class="profile-right">
<div class="dashboard-main">
<h4>我的资料</h4>
<hr class="oneuser-title-hr">
<div class="setFormContent">
						<fieldset>
							<legend>基本资料：<?php if(isset($success_msg)){
								echo $success_msg;}else{echo '修改您的个人头像'; };?>
							</legend>
						<div class="setFormRow">
							<img src="<?php bloginfo('url'); ?>/wp-content/uploads/avatars/<?php if($curauth->ID){ echo md5($curauth->ID); }?>.jpg" onerror="javascript:this.src='<?php bloginfo('url'); ?>/wp-content/uploads/avatars/avatar.jpg'" />
						</div>
						<form action="" enctype="multipart/form-data" method="post" >
												<div class="setFormRow">
    <input type="file" name="uppic" class="setFormSubmit" id="uppic"/>	</div>
	<div class="setFormRow">
<button class="setFormSubmit" name="picSubmit" type="submit">确认修改头像</button>
</div>
</form>	</fieldset>
								</div>
				</div>


</div>
</div>
</div>
</div>
<?php get_footer(); ?>