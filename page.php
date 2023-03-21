<?php 

get_header();

global $post;
$metaportal_fn_option 		= metaportal_fn_theme_option();
$style 	= '';

if(function_exists('rwmb_meta')){
	$style 	= get_post_meta(get_the_ID(),'metaportal_fn_page_style', true);
}

if($style == 'ws' && !metaportal_fn_if_has_sidebar()){
	$style	= 'full';
}

// CHeck if page is password protected	
if(post_password_required($post)){
	$protected = metaportal_fn_protectedpage();
	echo wp_kses($protected, 'post');
}
else
{
 	
?>




<div class="metaportal_fn_full_page_template">
	
	<?php metaportal_fn_get_page_title(); ?>
				
	<!-- ALL PAGES -->		
	<div class="metaportal_fn_full_page_in">

		<?php if($style != 'ffull'){ ?>
		<div class="container">
		<?php } ?>
		<!-- PAGE -->
		<div class="full_content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php the_content(); ?>

			<?php wp_link_pages(
				array(
					'before'      => '<div class="metaportal_fn_pagelinks"><span class="title">' . esc_html__( 'Pages:', 'metaportal' ). '</span>',
					'after'       => '</div>',
					'link_before' => '<span class="number">',
					'link_after'  => '</span>',
				)); 
			?>
		</div>
		<!-- /PAGE -->

		<?php if($style != 'ffull'){ ?>	
		</div>
		<?php } ?>	

	</div>

	<?php if ( comments_open() || get_comments_number()){?>
	<div class="metaportal_fn_comment_wrapper">
		<div class="container">
			<div class="metaportal_fn_comments" id="comments">
				<?php comments_template(); ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php endwhile; endif; ?>
</div>





<?php } ?>

<?php get_footer(); ?>  