<?php
/*
	Template Name: Collection Page
*/
get_header();

global $post;
$metaportal_fn_option 		= metaportal_fn_theme_option();

// QUERY ARGUMENTS
if(isset($metaportal_fn_option['nft_perpage'])){
	$portfolio_perpage		= $metaportal_fn_option['nft_perpage'];
}else{
	$portfolio_perpage 		= 12;
}

if(is_front_page()) { $paged = (get_query_var('page')) ? get_query_var('page') : 1;	} else { $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;}
$query_args = array(
	'post_type' 			=> 'frenify-nft', 
	'paged' 				=> $paged, 
	'posts_per_page' 		=> $portfolio_perpage,
	'post_status' 			=> 'publish',
);
// QUERY WITH ARGUMENTS
$loop 			= new WP_Query($query_args);

$nft_filter_animation 		= 'disabled';
if(isset($metaportal_fn_option['nft_filter_animation'])){
	$nft_filter_animation	= $metaportal_fn_option['nft_filter_animation'];
}

// CHeck if page is password protected	
if(post_password_required($post)){
	$protected = metaportal_fn_protectedpage();
	echo wp_kses($protected, 'post');
}
else
{
?>
<div class="metaportal_fn_nfts">
	<?php metaportal_fn_get_page_title(); ?>
	
	<!-- Collection Page -->
	<div class="metaportal_fn_collectionpage">
		<div class="container wide">

			<div class="metaportal_fn_collection ready" data-scroll-top="<?php echo esc_attr($nft_filter_animation);?>">
				
				
				<!-- Filters -->
				<?php echo wp_kses(metaportal_fn_nft_filters(),'post'); ?>
				<!-- !Filters -->

				<div class="metaportal_fn_clist">


					<!-- Result Box -->
					<div class="metaportal_fn_result_box">
						<div class="filter_count">
							<?php esc_html_e('Filters','metaportal'); ?> <span>0</span>
						</div>
					</div>
					<!-- !Result Box -->

					<!-- Result List -->
					<div class="metaportal_fn_result_list">
						<div class="metaportal_fn_drops">
							<ul class="collection_masonry_list grid">
								<?php 
									echo wp_kses(metaportal_fn_get_nft_items($loop),'post'); 
								?>
							</ul>
						</div>

						<?php metaportal_fn_pagination($loop->max_num_pages,1,0,4); wp_reset_postdata();?>
					</div>
					<!-- !Result List -->

				</div>

			</div>

		</div>			
	</div>
	<!-- !Collection Page -->
	
	
	
	
	<!-- PORTFOLIO CONTENT -->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="collection_content">
			<div class="fn-container">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endwhile; endif;?>
	<!-- PORTFOLIO /CONTENT -->

</div>
<?php } ?>

<?php get_footer(); ?>  