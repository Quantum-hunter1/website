<?php 

get_header();
$metaportal_fn_option 		= metaportal_fn_theme_option();



// SEO
$seo_404_number 			= 'h2';
if(isset($metaportal_fn_option['seo_404_number'])){
	$seo_404_number 		= $metaportal_fn_option['seo_404_number'];
}
$seo_404_number__start 		= sprintf( '<%1$s class="fn__gradient_title">', $seo_404_number );
$seo_404_number__end 		= sprintf( '</%1$s>', $seo_404_number );

$seo_404_not_found 			= 'h3';
if(isset($metaportal_fn_option['seo_404_not_found'])){
	$seo_404_not_found 		= $metaportal_fn_option['seo_404_not_found'];
}
$page_not_found				= esc_html__('Page Not Found', 'metaportal');
$seo_404_not_found__start 	= sprintf( '<%1$s class="fn__maintitle" data-text="%2$s" data-align="center">', $seo_404_not_found, $page_not_found );
$seo_404_not_found__end 	= sprintf( '</%1$s>', $seo_404_not_found );

$seo_404_desc 				= 'p';
if(isset($metaportal_fn_option['seo_404_desc'])){
	$seo_404_desc 			= $metaportal_fn_option['seo_404_desc'];
}
$seo_404_desc__start 		= sprintf( '<%1$s class="fn__desc">', $seo_404_desc );
$seo_404_desc__end 			= sprintf( '</%1$s>', $seo_404_desc );
?>
          	
<!-- ERROR PAGE -->
<div class="metaportal_fn_404">
	<div class="container">
		<div class="message_holder">
			<div class="title_holder">
				<?php echo wp_kses($seo_404_number__start,'post'); ?>
				<?php esc_html_e('404', 'metaportal'); ?>
				<?php echo wp_kses($seo_404_number__end,'post'); ?>
				<?php echo wp_kses($seo_404_not_found__start,'post'); ?>
				<?php echo esc_html($page_not_found); ?>
				<?php echo wp_kses($seo_404_not_found__end,'post'); ?>
				<?php echo wp_kses($seo_404_desc__start,'post'); ?>
				<?php esc_html_e('Sorry, but the page you are looking for was moved, removed, renamed or might never existed...', 'metaportal'); ?>
				<?php echo wp_kses($seo_404_desc__end,'post'); ?>
			</div>
			<div class="container-custom">
				<form action="<?php echo esc_url(home_url('/')); ?>" method="get" >
					<input type="text" placeholder="<?php esc_attr_e('Search here...', 'metaportal');?>" name="s" autocomplete="off" />
					<input type="submit" class="pe-7s-search" value="" />
					<a class="metaportal_fn_button" href="#"><?php echo wp_kses_post(metaportal_fn_getSVG_theme('searching'));?></a>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /ERROR PAGE -->

        
<?php get_footer(); ?>