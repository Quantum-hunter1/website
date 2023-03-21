<?php

get_header();

global $post;
$style = 'full';

if(function_exists('rwmb_meta')){
	if(isset(get_post_meta(get_the_ID())['metaportal_fn_page_style'])){
		$style 	= get_post_meta(get_the_ID(),'metaportal_fn_page_style', true);
	}
}

if($style == 'ws' && !metaportal_fn_if_has_sidebar()){
	$style	= 'full';
}


// Check if page is password protected	
if(post_password_required($post)){
	$protected = metaportal_fn_protectedpage();
	echo wp_kses($protected, 'post');
}else{
?>
<div class="metaportal_fn_single" data-style="<?php echo esc_attr($style);?>">
	<?php get_template_part( 'inc/templates/single-post-template', '', array('has_sidebar' => $style) );?>
</div>
<?php } ?>

<?php get_footer(); ?>  