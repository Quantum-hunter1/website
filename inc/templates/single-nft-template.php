<?php 

$metaportal_fn_option 	= metaportal_fn_theme_option();

if (have_posts()) : while (have_posts()) : the_post();
	$post_ID 			= get_the_id();
	$post_title 		= '<div class="post_title"><h3 class="fn__title">'.get_the_title().'</h3></div>';

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

	$categories			= metaportal_fn_nft_item__categories();
	
	$similar_items		= metaportal_fn_nft_item__similiar();
?>

<div class="metaportal_fn_mintpage">
	<div class="container small">

		<!-- Mint Top -->
		<div class="metaportal_fn_mint_top">
			<div class="mint_left">
				<div class="img">
					<div class="img_in" data-bg-img="<?php echo esc_url($image_URL);?>">
						<img src="<?php echo esc_url(get_template_directory_uri().'/framework/img/thumb/square.jpg');?>" alt="">
					</div>
				</div>
			</div>
			<div class="mint_right">
				<?php echo wp_kses(metaportal_fn_sharepost(),'post'); ?>
				<?php metaportal_fn_breadcrumbs(); ?>
				<h3 class="fn__maintitle" data-text="<?php echo esc_attr(get_the_title()); ?>" data-align="left"><?php the_title(); ?></h3>
				<div class="desc">
					<?php the_content(); ?>
				</div>
				<?php echo wp_kses(metaportal_fn_nft_item__buttons(), 'post'); ?>
			</div>
		</div>
		<!-- !Mint Top -->

	
		<!-- NFT Categories -->
		<?php echo wp_kses($categories, 'post'); ?>
		<!-- !NFT Categories -->
		
		
		<?php if($similar_items !== ''){ ?>
		<div class="metaportal_fn_similar">
			<h3 class="fn__maintitle" data-text="<?php esc_attr_e('Similar Items', 'metaportal'); ?>"><?php esc_html_e('Similar Items', 'metaportal'); ?></h3>
			<div class="fn_cs_divider">
				<div class="divider">
					<span></span>
					<span></span>
				</div>
			</div>
			<div class="metaportal_fn_drops">
				<ul class="grid">
					<?php echo wp_kses($similar_items, 'post'); ?>
				</ul>
			</div>
		</div>
		<?php } ?>


	</div>


</div>


<?php if ( comments_open() || get_comments_number()){?>
<!-- POST COMMENT -->
<div class="metaportal_fn_comment_wrapper">
	<div class="metaportal_fn_comment" id="comments">
		<div class="comment_in">
			<?php comments_template(); ?>
		</div>
	</div>
</div>
<!-- /POST COMMENT -->
<?php } ?>
	
<?php endwhile; endif;wp_reset_postdata();?>