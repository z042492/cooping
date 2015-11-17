<div id="footer">

	<div id="bottom">
	
		<?php if(is_home()) { ?>
		<div class="link_footer">
			<h2>友情链接</h2>
			<?php wp_list_bookmarks('title_li=&categorize=0&category_before=&category_after='); ?>
		</div>
		<?php ; } else { ?>
		<div class="random">
			<h2>随便看看</h2>
			<ul>
				<?php random_posts(); ?>
			</ul>
		</div>
		<?php ; } ?>
		<div class="tag">
			<h2>热门标签</h2>
			<ul>
				<?php wp_tag_cloud('smallest=12&largest=12&unit=px&number=22&order=DESC'); ?>
			</ul>
		</div>


<?php dynamic_sidebar('widget_vfilmtheme'); ?>

</div>
		
		<div id="copyright"><strong>每天2、3篇值得一看到文章..</strong> &copy; 2013 <a href="<?php bloginfo('home'); ?>/" title="<?php bloginfo('name'); ?>">微影时光网</a> &nbsp;|&nbsp;
                    <a href="http://www.miitbeian.gov.cn" rel="external nofollow" target="_blank"> <?php echo get_option('vfilmtheme_cat05'); ?></a>&nbsp;|&nbsp;Theme By
					 <a href="http://vfilmtime.com" target="_blank" title="微影时光网 ">小苏</a>& <a href="http://banri.me/" target="_blank">Banri</a>&nbsp;|&nbsp;图片储存<a href="http://www.moke8.com/wordpress/" target="_blank">wordpress主题</a>提供 &nbsp;|&nbsp;<?php echo get_option('vfilmtheme_cat06'); ?>
		</div> 
	
	
		
		
	</div>
	<div id="totop">▲</div>
</div>
<script src="<?php bloginfo('template_url'); ?>/common.js"></script>
<!-- Baidu Button BEGIN -->
<script type="text/javascript" id="bdshare_js" data="type=slide&amp;img=3&amp;pos=right&amp;uid=6530053" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
</script>
<!-- Baidu Button END -->


<?php wp_footer(); ?>
</body>
</html>