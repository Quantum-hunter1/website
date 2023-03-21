<?php

get_header();

global $post;

// Check if page is password protected	
if(post_password_required($post)){
	$protected = metaportal_fn_protectedpage();
	echo wp_kses($protected, 'post');
}else{
?>
<div class="metaportal_fn_single">
	<div class="metaportal_fn_nft_single">
		<?php get_template_part( 'inc/templates/single-nft-template');?>
	</div>
</div>
<?php } ?>

<?php get_footer(); ?>  