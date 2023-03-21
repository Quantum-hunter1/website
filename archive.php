<?php
get_header();
?>
        
	<?php metaportal_fn_get_page_title(); ?>

	<div class="metaportal_fn_content_archive">
		<div class="container">
			<div class="metaportal_fn_bloglist">
				<ul class="bloglist fn__masonry">
					<?php get_template_part( 'inc/templates/posts' );?>
				</ul>
			</div>
		</div>
		<?php metaportal_fn_pagination(); ?>
	</div>
        
<?php get_footer(); ?> 