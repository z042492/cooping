<?php
get_header();
$url = get_post_meta($post->ID, "url_value", true); 
?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/ruike/ruike.js"></script>
<div class="w1200m">
<?php while ( have_posts() ) : the_post(); ?>
<div class="player">
			  <div id="a1">
 <script type="text/javascript">
	var flashvars={
		f:'<?php bloginfo('template_url');?>/ruike/deng.php?v=<?php echo $url; ?>',
		s:2,
		c:0,
		e:'5',
		loaded:'loadedHandler',
        my_url:encodeURIComponent(window.location.href)
        };
	var params={bgcolor:'#FFF',allowFullScreen:true,allowScriptAccess:'always'};
	CKobject.embedSWF('<?php bloginfo('template_url');?>/ruike/ruikebf.swf','a1','ckplayer_a1','100%','500px',flashvars,params);
  </script>
</div>
</div>
<div class="player_list">
<div id="ztbox">
  <div id="left"></div>
  <div id="conter">
    <ul>
	<?php $studys = get_post_meta($post->ID,"mmxx", $single = false); ?>
	<?php foreach( array_reverse($studys) as $study ) { ?>
	<?php 
	$str = $study;
	$arr = explode("|",$str);
	//unset($arr[0]);
	list($name,$time,$video) = $arr;
	$num++;
	?>
<li><a href="<?php echo $video; ?>"><img src="<?php echo catch_that_image() ?>" /></a></li>
   <?php } ?>
    </ul>
	<div id="scroll"> <span></span> </div>
  </div>
  <div id="right"></div>
</div>
</div>
<div class="wrapper-left">  
<div class="the_content">  
<?php the_content(); ?>
</div>
<?php comments_template( '', true ); ?>
</div>
<div class="wrapper-right">
<div class="bc-box">
	<h3>视频编辑</h3>
      <div class="info clearfix">
        <div class="author avatar-70"><?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?></div>
        <div class="infor-text"><?php echo get_the_author() ?><span class="group_name">这里是等级</span>
          <p>QQ:921387003</p>
        </div>
      </div>
      <p class="detail">
        <?php if($curauth->description){ echo $curauth->description; }else{ echo '这头小猪连个人介绍都没有';}?>
      </p>
    </div>
</div>
<?php endwhile; ?>
</div>
<?php get_footer(); ?>