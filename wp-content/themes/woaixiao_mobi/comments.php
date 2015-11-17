<?php if ( have_comments() ) : ?>
	<div class="comment_title">评论列表</div>
	<ul class="commentlist">
		<?php wp_list_comments('style=ul&type=comment&per_page=-1&avatar_size=20&callback=yeti_theme_comment'); ?>
	</ul><!-- .commentlist -->
<?php endif; // have_comments() ?>