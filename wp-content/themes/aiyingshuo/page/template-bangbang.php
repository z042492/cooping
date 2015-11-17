<?php 
/*
Template Name: 个人资料
*/
// 以下代码判断是否登录
if ( !is_user_logged_in() ) wp_redirect( get_bloginfo('url') );
// 以下代码查询用户
global $wp_query;
$curauth = wp_get_current_user();

// 以上代码更新用户资料
if(isset($_POST['submit_personal'])){
	if ( is_user_logged_in() ) {
		$art=array(
			  'ID' => $current_user->ID,
			  'nickname'=> strip_tags(trim($_POST["displayName"])),
			  'display_name' => strip_tags(trim($_POST["displayName"])),
			  'user_email' => strip_tags(trim($_POST["userEmail"])),
			  'user_url' => strip_tags(trim($_POST["userUrl"])),
			  'user_qq' => strip_tags(trim($_POST["userQq"])),
			  'user_weibo' => strip_tags(trim($_POST["userWeibo"])),
			  'description' => strip_tags(trim($_POST["description"]))
			  
			);
			$user_id=wp_update_user($art);
		if($user_id){
			$success_msg = '个人信息更新成功！';
			//echo "<script language=\"JavaScript\">alert(\"个人信息更新成功！\");</script>"; 
		}else{
			$success_msg = '个人信息更新失败！';
		}
	}else{
		wp_redirect( home_url() ); exit; 
	}
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
								echo $success_msg;}else{echo '修改您的个人资料'; };?></legend>
										<form action="" method="post" name="authorInfoMeta">
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">昵称</label>:</div>
											<div class="setFormWidget">
												<input title="请输入昵称" placeholder="请输入昵称" value="<?php if($curauth->display_name){ echo $curauth->display_name; } ?>" name="displayName" class="setFormRequired">
											</div>
										</div>
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">邮箱</label>:</div>
											<div class="setFormWidget">
												<input title="请输入用户邮箱" placeholder="请输入用户邮箱"  value="<?php if($curauth->user_email){ echo $curauth->user_email; } ?>" name="userEmail" class="setFormRequired">
											</div>
										</div>
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">网址</label>:</div>
											<div class="setFormWidget">
												<input title="请输入个人网站或博客" placeholder="请输入个人网站或博客" value="<?php if($curauth->user_url){ echo $curauth->user_url; } ?>" name="userUrl" class="setFormRequired">
											</div>
										</div>
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">QQ</label>:</div>
											<div class="setFormWidget">
												<input title="请输入个人QQ" placeholder="请输入个人QQ"  value="<?php if($curauth->user_qq){ echo $curauth->user_qq; } ?>" name="userQq" class="setFormRequired">
											</div>
										</div>
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">微博地址</label>:</div>
											<div class="setFormWidget">
												<input title="请输入微博个性域名" placeholder="请输入微博个性域名"   value="<?php if($curauth->user_weibo){ echo $curauth->user_weibo; } ?>" name="userWeibo"class="setFormRequired">
											</div>
										</div>
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">个人介绍</label>:</div>
											<div class="setFormWidget">
												<textarea placeholder="请输入个人介绍" name="description" class="setFormRequired"><?php if($curauth->description){ echo $curauth->description; } ?></textarea>
											</div>
										</div>
										<div class="setFormRow">
										<button type="submit" name="submit_personal" class="setFormSubmit">确认修改资料</button>
												</div>
										</form>
									</fieldset>
								</div>
				</div>
</div>
</div>
</div>
</div>
<?php get_footer(); ?>