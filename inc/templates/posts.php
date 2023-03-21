<?php 
$key = 0;
$postType	= 'post';
$list 		= '';
if(is_front_page()) {
	$paged = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
if(!is_search() && !is_archive() && !is_home()){
	query_posts('posts_per_page=&paged='.esc_html($paged));
}


$from_page			= 'blog';
if (isset($args['from_page'])) {
	$from_page 		= $args['from_page'];
}
$per_page = (int)get_option( 'posts_per_page' );
$key = ((int)$paged - 1) * $per_page;
$call_back_thumb	= metaportal_fn_callback_thumbs(650,422);
if (have_posts()) : while (have_posts()) : the_post();
	$key++;
	$postID 		= get_the_id();
	$permalink 		= get_the_permalink();
	$postClasses  	= 'class="'.implode(' ', get_post_class()).' post_item mas__in"';
	$extraMeta		= metaportal_fn_get_date($postID);

	$post_title		= '';
	if(get_the_title() !== ''){
		$post_title = '<div class="title"><h3><a href="'.$permalink.'">'.get_the_title().'</a></h3></div>';
	}

	$post_header 	= '<li '.$postClasses.' id="post-'.$postID.'"><div class="blog__item">';
	$post_footer 	= '</div></li>';

	
	$myKey = ($key < 10) ? '0' . $key : $key;
	$img_holder    	= '<div class="image"><a href="'.$permalink.'"><img src="'.get_the_post_thumbnail_url($postID,'full').'" alt="'.esc_html__('Post Image', 'metaportal').'" /></a></div>';
	// echo
	$list .= $post_header;
		$list .= '<div class="counter"><span class="cc"><span>'.$myKey.'</span></span></div>';
		$list .= metaportal_fn_metas($postID,'list');
		$list .= $post_title;
		$list .= $img_holder;
		$list .= '<div class="read_more"><a href="'.$permalink.'"><span>'.esc_html__('Read More', 'metaportal').'</span></a></div>';
	$list .= $post_footer;

endwhile; endif; wp_reset_postdata();
echo wp_kses($list, 'post');
?>