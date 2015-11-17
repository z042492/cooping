<?php get_header(); ?>
<style type="text/css">
.bd-filter-content {
background: #fff;
-webkit-box-shadow: 0 0 1px #f4f4f4;
-moz-box-shadow: 0 0 1px #f4f4f4;
box-shadow: 0 0 1px #f4f4f4;
border-bottom-left-radius: 4px;
border-bottom-right-radius: 4px;
padding: 8px 0;
}
.bd-filter-section {
position: relative;
padding-left: 48px;
padding-right: 10px;
}
.bd-filter-title {
height: 22px;
line-height: 22px;
font-size: 15px;
position: absolute;
left: 0;
top: 0;
width: 38px;
font-weight: bold;
text-align: right;
display: -moz-inline-box;
-moz-box-orient: vertical;
display: inline-block;
vertical-align: middle;
color: #444;
}
.bd-filter-section a {
padding-left: 5px;
display: -moz-inline-box;
-moz-box-orient: vertical;
display: inline-block;
vertical-align: middle;
text-decoration: none;
margin-right: 5px;
margin-bottom: 8px;
font: 12px \5B8B\4F53,arial;
line-height: 22px;
height: 22px;
color: #444;
}
.bd-filter-section .current {
display: inline-block;
padding-right: 5px;
line-height: 22px;
height: 22px;
cursor: pointer;
}
.bd-filter-section .current {
color: #fff;
background: #01a461;
}
</style>
<?php
//1.1 获取所有province分类,将id放入 $province_id数组
$args = array(
 'taxonomy'=>'province',
 'orderby'=>'id',
 'hide_empty'=>0
);
$province_ob = get_categories( $args );
$province_id = array();
foreach($province_ob as $province){
$province_id[] = $province->term_id;
}
//1.2 获取所有city分类,将id放入 $city_id数组
$args = array(
 'taxonomy'=>'city',
 'orderby'=>'id',
 'hide_empty'=>0
);
$city_ob = get_categories( $args );
$city_id = array();
foreach($city_ob as $city){
$city_id[] = $city->term_id;
}
//1.3 获取所有genre分类,将id放入 $genre_id数组
$args = array(
 'taxonomy'=>'genre',
 'orderby'=>'id',
 'hide_empty'=>0
);
$genre_ob = get_categories( $args );
$genre_id = array();
foreach($genre_ob as $genre){
$genre_id[] = $genre->term_id;
}
//1.4 获取所有price分类,将id放入 $price_id数组
$args = array(
 'taxonomy'=>'price',
 'orderby'=>'id',
 'hide_empty'=>0
);
$price_ob = get_categories( $args );
$price_id = array();
foreach($price_ob as $price){
$price_id[] = $price->term_id;
}
//2 参数处理
//2.1 页码
$wp_query->query_vars['paged'] > 1 ? $pagenum = $wp_query->query_vars['paged'] : $pagenum = 1;
/*2.2 从url中获取参数 即url中 0_0_0_0
*将获取到的四个参数放入 $cons 数组中
*/
global $wp_query;
if( isset($wp_query->query_vars['condition']) && $wp_query->query_vars['condition']!='' ){
$condition = $wp_query->query_vars['condition'];
$conditions = explode('_',$condition);
$cons = array();
 if(isset($conditions[0])){
$conditions[0] = (int)$conditions[0];
 }else{
$conditions[0]=0;
 }
 if(isset($conditions[1])){
$conditions[1] = (int)$conditions[1];
 }else{
$conditions[1]=0;
 }
 if(isset($conditions[2])){
$conditions[2] = (int)$conditions[2];
 }else{
$conditions[2]=0;
 }
 if(isset($conditions[3])){
$conditions[3] = (int)$conditions[3];
 }else{
$conditions[3]=0;
 }
 //从url中获取到的各分类法分类ID是否真实存在
 if( in_array($conditions[0],$province_id) ){
$cons[0]=$conditions[0];
 }else{
$cons[0]=0;
 }
 if( in_array($conditions[1],$city_id) ){
$cons[1]=$conditions[1];
 }else{
$cons[1]=0;
 }
 if( in_array($conditions[2],$genre_id) ){
$cons[2]=$conditions[2];
 }else{
$cons[2]=0;
 }
 if( in_array($conditions[3],$price_id) ){
$cons[3]=$conditions[3];
 }else{
$cons[3]=0;
 }
$sift_link = ashuwp_sift_link().'/'.$cons[0].'_'.$cons[1].'_'.$cons[2].'_'.$cons[3];
}else{
$cons = array(0,0,0,0);
$sift_link = ashuwp_sift_link().'/0_0_0_0';
}
?>
<div class="w1200m">
<div class="sift_query">
<div class="bd-filter-content">
<div class="bd-filter-section">
<h3 class="bd-filter-title">类型：</h3>
<a <?php if($cons[0]==0){ echo 'class="current"'; } ?> href="<?php echo ashuwp_sift_link(); ?>/0_<?php echo $cons[1];?>_<?php echo $cons[2];?>_<?php echo $cons[3];?>/">不限</a>
<?php
foreach( $province_ob as $province ){
?>
<a href="<?php echo ashuwp_sift_link(); ?>/<?php echo $province->term_id; ?>_<?php echo $cons[1]; ?>_<?php echo $cons[2]; ?>_<?php echo $cons[3];?>" <?php if($cons[0] == $province->term_id){ echo 'class="current"'; } ?>><?php echo $province->name; ?></a>
<?php } ?>
</div>
<div class="bd-filter-section"><h3 class="bd-filter-title">地区：</h3><a <?php if($cons[1] == 0){ echo 'class="current"'; } ?> href="<?php echo ashuwp_sift_link(); ?>/<?php echo $cons[0];?>_0_<?php echo $cons[2]; ?>_<?php echo $cons[3];?>/">不限</a>
<?php
foreach( $city_ob as $city ){ ?>
<a href="<?php echo ashuwp_sift_link(); ?>/<?php echo $cons[0]; ?>_<?php echo $city->term_id; ?>_<?php echo $cons[2]; ?>_<?php echo $cons[3];?>" <?php if($cons[1] == $city->term_id){ echo 'class="current"'; } ?>><?php echo $city->name; ?></a>
<?php } ?>
</div>
<div class="bd-filter-section"><h3 class="bd-filter-title">年代：</h3><a <?php if($cons[2] == 0){ echo 'class="current"'; } ?> href="<?php echo ashuwp_sift_link(); ?>/<?php echo $cons[0];?>_<?php echo $cons[1]; ?>_0_<?php echo $cons[3];?>/">不限</a>
<?php
foreach( $genre_ob as $genre ){ ?>
<a href="<?php echo ashuwp_sift_link(); ?>/<?php echo $cons[0]; ?>_<?php echo $cons[1]; ?>_<?php echo $genre->term_id; ?>_<?php echo $cons[3];?>" <?php if($cons[2] == $genre->term_id){ echo 'class="current"'; } ?>><?php echo $genre->name; ?></a>
<?php } ?>
</div>
<div class="bd-filter-section"><h3 class="bd-filter-title">演员：</h3><a <?php if($cons[3] == 0){ echo 'class="current"'; } ?> href="<?php echo ashuwp_sift_link(); ?>/<?php echo $cons[0];?>_<?php echo $cons[1]; ?>_<?php echo $cons[2]; ?>_0/">不限</a>
<?php
foreach( $price_ob as $price ){ ?>
<a href="<?php echo ashuwp_sift_link(); ?>/<?php echo $cons[0]; ?>_<?php echo $cons[1]; ?>_<?php echo $cons[2]; ?>_<?php echo $price->term_id; ?>" <?php if($cons[3] == $price->term_id){ echo 'class="current"'; } ?>><?php echo $price->name; ?></a>
<?php } ?>
</div>
</div>
<?php
//将获取到的参数组合为query_posts的参数
$tax_query = array(
 'relation'=> 'AND',
);
//province
if( $cons[0] != 0 ){
$tax_query[] = array(
 'taxonomy'=>'province',
 'field'=>'id',
 'terms'=>$cons[0]
 );
}
//city
if( $cons[1] != 0 ){
$tax_query[] = array(
 'taxonomy'=>'city',
 'field'=>'id',
 'terms'=>$cons[1]
 );
}
//genre
if( $cons[2] != 0 ){
$tax_query[] = array(
 'taxonomy'=>'genre',
 'field'=>'id',
 'terms'=>$cons[2]
 );
}
//price
if( $cons[3] != 0 ){
$tax_query[] = array(
 'taxonomy'=>'price',
 'field'=>'id',
 'terms'=>$cons[3]
 );
}
$args = array(
 'paged' => $pagenum,
 'tax_query'=> $tax_query
);
global $ashuwp_query;
$ashuwp_query = new WP_Query( $args );
?>
<div class="query_count">共找到<?php echo $ashuwp_query->found_posts;?>个符合条件的内容</div>
</div>
<?php
if($ashuwp_query->have_posts()) : ?>
<div class="index grid">  	
   <ul>
<?php while($ashuwp_query->have_posts()) : $ashuwp_query->the_post(); ?>
<li class="group">
  <div class="item">
    <div class="thumb">
    <a target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
    <img width="280" height="180" src="<?php echo catch_that_image() ?>" class="attachment-medium wp-post-image" alt="<?php the_title(); ?>" /></a>
    </div>
    <div class="meta">
    <div class="title"><h2><a target="_blank" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2></div>
    <div class="extra"><i class="fa fa-bookmark"></i><?php the_category(', ') ?><span><i class="fa fa-fire"></i><?php post_views(' ', ' 次'); ?></span></div>  
      </div>
  </div>
	</li>
<?php endwhile;?>
</div>
</ul>	
<?php endif; ?>
<div id="ashuwp_page">
<?php
$pagination = paginate_links( array(
 'base' => $links.'/page/%#%',
 'format' => '/page/%#%',
 'prev_text' => '上一页',
 'next_text' => '下一页',
 'total' => $ashuwp_query->max_num_pages,
 'current' => $pagenum
) );
if ( $pagination ) {
echo $pagination;
}
?>
</div>
</div>
</div>
</div><!--site-page-->
<?php get_footer(); ?>