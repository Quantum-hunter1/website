<?php 

$post_type				= get_post_type();
$has_sidebar			= 'full';
if (isset($args['has_sidebar'])) {
	$has_sidebar 		= $args['has_sidebar'];
}
if (have_posts()) : while (have_posts()) : the_post();
	$post_ID 			= get_the_id();
	$post_title			= '';
	$title				= get_the_title();
	if($title !== ''){
		$post_title 	= '<h3 class="fn__maintitle" data-align="left" data-text="'.$title.'">'.$title.'</h3>';
		if($title != strip_tags($title)) {
			$post_title = '<h3 class="fn__maintitle"  data-align="left">'.$title.'</h3>';
		}
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

	$links = wp_link_pages(
		array(
			'before'      	=> '<div class="metaportal_fn_pagelinks"><span class="title">' . esc_html__( 'Pages:', 'metaportal' ). '</span>',
			'after'       	=> '</div>',
			'link_before' 	=> '<span class="number">',
			'link_after'  	=> '</span>',
			'echo'			=> 0
		)
	);
?>


<div class="metaportal_fn_blog_single">
	<div class="blog_top">
		<div class="container">
			
			<?php if($has_image == 1){ ?>
			<?php echo wp_kses(metaportal_fn_sharepost(),'post'); ?>
			<?php metaportal_fn_breadcrumbs(); ?>
			<?php } ?>
			
			<?php if($has_image == 1){ ?>
			<div class="single_img" data-content="<?php echo esc_attr($has_image);?>">
				<img src="<?php echo esc_attr($image_URL);?>" alt="<?php esc_attr_e('Blog Image', 'metaportal');?>">
			</div>
			<?php } ?>
			
			<?php if($has_image == 1){ ?>
			<!-- Mini Items  -->
			<?php echo wp_kses(metaportal_fn_meta($post_ID),'post'); ?>
			<!-- !Mini Items  -->
			<?php } ?>
			
			<?php if($has_sidebar == 'ws'){ ?>
			<div class="metaportal_fn_wsidebar">
				<div class="sidebar_left">
			<?php } ?>
					
					<?php if($has_image == 0){ ?>
					<?php echo wp_kses(metaportal_fn_sharepost(),'post'); ?>
					<?php metaportal_fn_breadcrumbs(); ?>
					<?php } ?>
					
					<?php if($has_image == 0){ ?>
					<!-- Mini Items  -->
					<?php echo wp_kses(metaportal_fn_meta($post_ID),'post'); ?>
					<!-- !Mini Items  -->
					<?php } ?>
				
					<!-- Single Title -->
					<div class="single_title">
						<?php echo wp_kses($post_title,'post'); ?>
						<?php echo wp_kses(metaportal_fn_get_categories($post_ID,'single'),'post');?>
					</div>
					<!-- !Single Title -->
					
					<!-- Single Description -->
					<div class="single_desc" data-content="<?php echo (get_the_content() == '') ? 0: 1;?>">
						<?php the_content(); ?>
					</div>
					<!-- !Single Description -->

					<!-- Author Information Box -->
					<?php echo wp_kses(metaportal_get_author_info(), 'post');?>
					<!-- !Author Information Box -->
					
					<!-- Tags -->
					<?php if(has_tag()){ ?>
						<div class="metaportal_fn_tags">
							<h4 class="label"><?php the_tags(esc_html_e('Tags:', 'metaportal').'</h4>', '<span>,</span>'); ?>
						</div>
					<?php } ?>
					<!-- !Tags -->
					
					<!-- WordPress Link Pages -->
					<?php echo wp_kses($links, 'post');?>
					<!-- !WordPress Link Pages -->
					
			<?php if($has_sidebar == 'ws'){ ?>		
				</div>
				<div class="sidebar_right">
					<?php dynamic_sidebar('main-sidebar'); ?>
				</div>
			</div>
			<?php } ?>
			
			
		</div>
	</div>
	
	<!-- Previous & Next Box -->
	<?php echo wp_kses(metaportal_fn_postprevnext(), 'post');?>
	<!-- !Previous & Next Box -->
	
	<div class="blog_bottom">
		<div class="container">
			<?php if ( comments_open() || get_comments_number()){?>
				<div class="metaportal_fn_comments" id="comments">
					<?php comments_template(); ?>
				</div>
			<?php } ?>
		</div>
	</div>
	
</div>
	
<?php endwhile; endif;wp_reset_postdata();?>