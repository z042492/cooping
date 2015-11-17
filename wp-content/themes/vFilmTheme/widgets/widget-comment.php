<?php  

//widget vfilmtime_comment

add_action('widgets_init', create_function('', 'return register_widget("vfilmtime_comment");'));

class vfilmtime_comment extends WP_Widget {
	function vfilmtime_comment() {
		$this->WP_Widget('vfilmtime_comment', 'vfilm最新评论 ', array( 'description' => '显示网友最新评论（名称+评论）' ));
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = apply_filters('widget_name', $instance['title']);
		$limit = $instance['limit'];

		echo $before_title.$title.$after_title; 
		echo '<div class="w_comment"><ul>';
		echo vfilmtime_newcomments( $limit );
		echo '</ul></div>';
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		return $instance;
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => '最新评论',
			'limit' => '5',
			) 
		);
		$limit = strip_tags($instance['title']);
		$limit = strip_tags($instance['limit']);

?>
		<p>
			<label>
				标题：
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label>
				显示数目：
				<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" />
			</label>
		</p>

<?php
	}
}

function vfilmtime_newcomments( $limit ){
global $wpdb;
$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email, SUBSTRING(comment_content,1,15) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND user_id='0' ORDER BY comment_date_gmt DESC LIMIT $limit";
$comments = $wpdb->get_results($sql);
$output = $pre_HTML;
foreach ($comments as $comment) {
$output .= "<li><a href=\"" . get_permalink($comment->ID) . "#comment-" . $comment->comment_ID . "\" title=\"" . $comment->post_title . "上的评论\"><em>&gt;</em>". "<strong>". strip_tags($comment->comment_author) ."：</strong>". strip_tags($comment->com_excerpt) ."</a></li>";
}
$output .= $post_HTML;
$output = convert_smilies($output);
echo $output;
};

?>