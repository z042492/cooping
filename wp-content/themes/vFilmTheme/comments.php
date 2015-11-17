<div id="comments"> 
<?php 
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('请勿直接加载此页。谢谢！');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('必须输入密码，才能查看评论！'); ?></p>
	<?php
		return;
	}
?>
<?php if ($comments) : ?>
	<h3 id="comments"><?php comments_number('', '1 条评论', '% 条评论' );?></h3>
	<ol class="commentlist">
	<?php wp_list_comments('type=comment&callback=vfilmtime_comment&end-callback=vfilmtime_end_comment&max_depth=23'); ?>
	</ol>
	<div class="navigation">
		<div class="pagination"><?php paginate_comments_links('prev_text=上一页&next_text=下一页'); ?></div>
	</div>
 <?php else : ?>
	<?php if ('open' == $post->comment_status) : ?>
	<h3 id="comments">暂无评论</h3>
	 <?php else : ?>
	<H3>报歉!评论已关闭。</H3>
	<?php endif; ?>
	<?php endif; ?>
	<?php if ('open' == $post->comment_status) : ?>
	<div id="respond_box">
		<div style="margin:8px 0 8px 0"><h3>发表评论</h3></div>	
	<div id="respond">
				<div class="cancel-comment-reply" style="margin-bottom:5px">
		<div id="real-avatar">
	<?php if(isset($_vfilmtheme['comment_author_email_'.vfilmthemeHASH])) : ?>
		<?php echo get_avatar($comment_author_email, 40);?>
	<?php else :?>
		<?php global $user_email;?><?php echo get_avatar($user_email, 40); ?>
	<?php endif;?>
</div>	
			<small><?php cancel_comment_reply_link(); ?></small>
		</div>
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p><?php print '您必须'; ?><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"> [ 登录 ] </a>才能发表留言！</p>
    <?php else : ?>
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
      <?php if ( $user_ID ) : ?>
      <p><?php print '登录者：'; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>&nbsp;&nbsp;<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="退出"><?php print '退出'; ?></a></p>
	<?php elseif ( '' != $comment_author ): ?>
	<div class="author"><?php printf(__('欢迎回来 <strong style="color: #2CB4BF;">%s</strong>'), $comment_author); ?>
			<a href="javascript:toggleCommentAuthorInfo();" id="toggle-comment-author-info">更改</a></div>
			<script type="text/javascript" charset="utf-8">
				var changeMsg = "更改";
				var closeMsg = "隐藏";
				function toggleCommentAuthorInfo() {
					jQuery('#comment-author-info').slideToggle('slow', function(){
						if ( jQuery('#comment-author-info').css('display') == 'none' ) {
						jQuery('#toggle-comment-author-info').text(changeMsg);
						} else {
						jQuery('#toggle-comment-author-info').text(closeMsg);
				}
			});
		}
				jQuery(document).ready(function($){
					jQuery('#comment-author-info').hide();
				});
			</script>
	<?php endif; ?>
	<?php if ( ! $user_ID ): ?>
	<div id="comment-author-info">
		<p>
			<input type="text" name="author" id="author" class="commenttext" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
			<label for="author">昵称<?php if ($req) echo "（必须）"; ?></label>
		</p>
		<p>
			<input type="text" name="email" id="email" class="commenttext" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
			<label for="email">邮箱<?php if ($req) echo "（必须、保密）"; ?><a id="Get_Gravatar" style="padding-left:10px" title="查看如何申请一个自己的Gravatar全球通用头像" target="_blank" href="http://www.vfilmtime.com/sign-up-gravatar.html">小苏教你设置自己的个性头像</a></label>
		</p>
		<p>
			<input type="text" name="url" id="url" class="commenttext" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
			<label for="url">网址</label>
		</p>
	</div>
      <?php endif; ?>
      <div class="clear"></div>
      <?php include(TEMPLATEPATH . '/includes/smiley.php'); ?>
		<p><textarea name="comment" id="comment" tabindex="4" cols="50" rows="5"></textarea></p>
		<p>
			<input class="submit" name="submit" type="submit" id="submit" tabindex="5" value="提交留言" />
			<input class="reset" name="reset" type="reset" id="reset" tabindex="6" value="<?php esc_attr_e( '重　　写' ); ?>" />
			<?php comment_id_fields(); ?>
		</script>
		<?php do_action('comment_form', $post->ID); ?>
		</p>
    </form>
	<div class="clear"></div>
    <?php endif; ?>
  </div>
  </div>
  <?php endif; ?>
</div>