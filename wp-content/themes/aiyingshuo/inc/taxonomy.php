<?php
add_action('init', 'ashu_post_type');
function ashu_post_type() {
register_taxonomy(
 'province',
 'post',
array(
 'label' => '类型',
 'rewrite' => array( 'slug' => 'province' ),
 'hierarchical' => true
 )
 );
register_taxonomy(
 'city',
 'post',
array(
 'label' => '地区',
 'rewrite' => array( 'slug' => 'city' ),
 'hierarchical' => true
 )
 );
register_taxonomy(
 'genre',
 'post',
array(
 'label' => '年代',
 'rewrite' => array( 'slug' => 'genre' ),
 'hierarchical' => true
 )
 );
register_taxonomy(
 'price',
 'post',
array(
 'label' => '演员',
 'rewrite' => array( 'slug' => 'price' ),
 'hierarchical' => true
 )
 );
}
?>