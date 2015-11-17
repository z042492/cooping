<?php
/**
 */
if ( post_password_required() )
	return;
?>
<div id="comments" class="comments-area">
	
	<?php // You can start editing here -- including this comment! ?>
	<?php if ( have_comments() ) : ?>
		<div class="comments-title clearfix"> 
			<a class="on">文章评论</a>
			<?php
				printf( _n( '<a>已有 1 人参与</a>', '<a>已有 %1$s 人参与</a>', get_comments_number(), 'janezen' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		  </div>
	<?php endif; // have_comments() ?>
	<?php comment_form(array(
        'fields'               =>  array(
    'author' => '<p class="comment-form-author"><input type="text" aria-required="true" size="30" value="'.$comment_author.'" name="author" id="author"><label for="author">昵称(必填)</label></p>',
    'email' => '<p class="comment-form-email"><input type="text" aria-required="true" size="30" value="'.$comment_author_email.'" name="email" id="email"><label for="email">邮箱(必填)</label></p>'
    ),
        'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
        'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
        'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
        'comment_notes_before' => '<p class="comment-notes">' . __( '电子邮件地址不会被公开，用作信息回复；<a href="www.ruikeedu.com">登录</a>更快捷。' ) . ( $req ? $required_text : '' ) . '</p>',
        'comment_notes_after'  => '',
        'id_form'              => 'commentform',
        'id_submit'            => 'submit',
        'title_reply'          => __( 'Leave a Reply' ),
        'title_reply_to'       => __( 'Leave a Reply to %s' ),
        'cancel_reply_link'    => __( 'Cancel reply' ),
        'label_submit'         => __( 'Post Comment' ),
    )); ?>
	<?php if ( have_comments() ) : ?>	
		<nav id="comment-nav-below" class="comments-nav" role="navigation">
		<?php paginate_comments_links('prev_text=上一页&next_text=下一页');?>
		</nav>
		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'janezen_comment', 'style' => 'ol' ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comments-nav" role="navigation">
		<?php paginate_comments_links('prev_text=上一页&next_text=下一页');?>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'janezen' ); ?></p>
		<?php endif; ?>
	<?php endif; // have_comments() ?>
</div><!-- #comments .comments-area -->