<?php

get_header();

$metaportal_fn_option 		= metaportal_fn_theme_option();



$seo_page_title 			= 'h3';
if(isset($metaportal_fn_option['seo_page_title'])){
	$seo_page_title 		= $metaportal_fn_option['seo_page_title'];
}
$seo_page_title__start 		= sprintf( '<%1$s class="fn__title fn_animated_text" data-wait="1000" data-speed="8">', $seo_page_title );
$seo_page_title__end 		= sprintf( '</%1$s>', $seo_page_title );


// SEO

$seo_404_not_found 			= 'h3';
if(isset($metaportal_fn_option['seo_404_not_found'])){
	$seo_404_not_found 		= $metaportal_fn_option['seo_404_not_found'];
}
$nothing_found				= esc_html__('Nothing found', 'metaportal');;
$seo_404_not_found__start 	= sprintf( '<%1$s class="fn__maintitle" data-align="center" data-text="%2$s">', $seo_404_not_found, $nothing_found );
$seo_404_not_found__end 	= sprintf( '</%1$s>', $seo_404_not_found );

$seo_404_desc 				= 'p';
if(isset($metaportal_fn_option['seo_404_desc'])){
	$seo_404_desc 			= $metaportal_fn_option['seo_404_desc'];
}
$seo_404_desc__start 		= sprintf( '<%1$s class="fn__desc">', $seo_404_desc );
$seo_404_desc__end 			= sprintf( '</%1$s>', $seo_404_desc );

?>
	
<div class="metaportal_fn_searchlist">

	<?php 
		if(have_posts()){
			metaportal_fn_get_page_title();
		}
	?>

	<div class="metaportal_fn_searchpagelist">
		<?php if(have_posts()){ ?>
		<div class="container">
		<?php } ?>
		<?php if(have_posts()){ ?>
			<div class="metaportal_fn_bloglist">
				<ul class="bloglist fn__masonry">
					<?php get_template_part( 'inc/templates/posts', '', array('from_page' => 'search')  );?>
				</ul>
			</div>
			<div class="clearfix"></div>
			<?php metaportal_fn_pagination(); ?>
			<?php }else{ ?>
			<div class="metaportal_fn_protected">
				<div class="container">
					<div class="message_holder">
						<span class="icon">
							<?php echo wp_kses_post(metaportal_fn_getSVG_theme('browser'));?>
						</span>
						<?php 
							echo wp_kses($seo_404_not_found__start,'post');
							echo esc_html($nothing_found);
							echo wp_kses($seo_404_not_found__end,'post');
						?>
						<?php 
							echo wp_kses($seo_404_desc__start,'post');
							esc_html_e('Sorry, no content matched your criteria. Try searching for something else.', 'metaportal');
							echo wp_kses($seo_404_desc__end,'post');
						?>
						<div class="container-custom">
							<form action="<?php echo esc_url(home_url('/')); ?>" method="get" >
								<input type="text" placeholder="<?php esc_attr_e('Search here...','metaportal');?>" name="s" autocomplete="off" />
								<span class="submit"><input type="submit" class="pe-7s-search" value="Search" /></span>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		<?php if(have_posts()){ ?>
		</div>
		<?php } ?>
	</div>

	<?php wp_reset_postdata(); ?>
</div>
<!-- /SEARCH --> 
        
<?php get_footer('null'); ?>   