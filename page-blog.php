<?php
/*
	Template Name: Blog Page
*/
get_header();

global $post;
$metaportal_fn_option = metaportal_fn_theme_option();

// CHeck if page is password protected	
if(post_password_required($post)){
	$protected = metaportal_fn_protectedpage();
	echo wp_kses($protected, 'post');
}
else
{
	$seo_page_title 			= 'h3';
	if(isset($metaportal_fn_option['seo_page_title'])){
		$seo_page_title 		= $metaportal_fn_option['seo_page_title'];
	}
	$seo_page_title__start 		= sprintf( '<%1$s class="fn__title">', $seo_page_title );
	$seo_page_title__end 		= sprintf( '</%1$s>', $seo_page_title );
	
	$pageContent 				= get_the_content();
	$hasContent = 0; if($pageContent != ''){$hasContent = 1;}
	
	metaportal_fn_get_page_title(); ?>

	<div class="fn_page_blog">
		<div class="container">
		
			<div class="metaportal_fn_bloglist">
				<ul class="bloglist metaportal_fn_masonry">
					<?php get_template_part( 'inc/templates/posts' );?>
				</ul>
				<div class="clearfix"></div>
				<?php metaportal_fn_pagination(); ?>
			</div>
			
		</div>
	</div>



	<div class="metaportal_fn_blog_content" data-content="<?php echo esc_attr($hasContent);?>">
		<div class="container">
			<div class="blog_content">
				<?php echo wp_kses($pageContent,'post');?>
			</div>
		</div>
	</div>	


<?php } ?>

<?php get_footer(); ?>  