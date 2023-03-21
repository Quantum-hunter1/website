<?php 

$post_type				= get_post_type();
if (have_posts()) : while (have_posts()) : the_post();
	$post_ID 			= get_the_id();
	$post_title			= '';
	if(get_the_title() !== ''){
		$post_title 	= '<h3 class="fn__title">'.get_the_title().'</h3>';
	}
	$post_thumbnail_id 	= get_post_thumbnail_id( $post_ID );
	$src 				= wp_get_attachment_image_src( $post_thumbnail_id, 'full');
	$image_URL 			= '';
	$has_image			= 0;
	if(isset($src[0])){
		$image_URL 		= $src[0];
	}
	if($image_URL != ''){
		$has_image		= 1;
	}
	

	$commentSidebar		= 0;
	if(is_active_sidebar( 'comment-sidebar')){
		$commentSidebar = 1;
	}
	$mainSidebar		= 0;
	if(is_active_sidebar( 'main-sidebar')){
		$mainSidebar = 1;
	}
?>



<!-- Single Background -->
<div class="single_bg" data-has-image="<?php echo esc_attr($has_image);?>"></div>
<!-- !Single Background -->

<!-- Single Content -->
<div class="single_content">
	<div id="roadmap-single-content">
		<div class="container">
			<?php echo wp_kses(metaportal_fn_sharepost(),'post'); ?>

			<?php metaportal_fn_breadcrumbs(); ?>

			<div class="single_img" data-content="<?php echo esc_attr($has_image);?>">
				<img src="<?php echo esc_attr($image_URL);?>" alt="<?php esc_attr_e('Blog Image', 'metaportal');?>">
			</div>
			
			<!-- Mini Items  -->
			<?php echo wp_kses(metaportal_fn_meta__roadmap($post_ID),'post'); ?>
			<!-- !Mini Items  -->

			<!-- Single Title -->
			<div class="single_title">
				<?php echo wp_kses($post_title,'post'); ?>
				<?php echo wp_kses(metaportal_fn_get_categories($post_ID,$post_type),'post');?>
			</div>
			<!-- !Single Title -->
			
		</div>
		<div class="roadmap_content">
			<?php the_content(); ?>
		</div>	
			
	</div>
</div>
<!-- !Single Content -->
	
	
	
	
<?php endwhile; endif;wp_reset_postdata();?>