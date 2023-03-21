<!DOCTYPE html >
<html <?php language_attributes(); ?>>

<head>
<?php global $post; ?>

<meta charset="<?php esc_attr(bloginfo( 'charset' )); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<?php wp_head(); ?>

</head>
<?php 
	$metaportal_fn_option 	= metaportal_fn_theme_option();
	// get all options
	$core_ready				= 'core_absent';
	$footerSticky			= 'disabled';
	if(isset($metaportal_fn_option)){
		$core_ready 		= 'core_ready';
	}
	$nav__speed				= 'medium';
	if(isset($metaportal_fn_option['nav__speed'])){
		$nav__speed			= $metaportal_fn_option['nav__speed'];
	}
?>
<body <?php body_class();?>>
	<?php wp_body_open(); ?>
	
	<!-- Preloader -->
	<div class="metaportal_fn_preloader">
		<div class="loading-container">
			<div class="loading">
				<div class="l1">
					<div></div>
				</div>
				<div class="l2">
					<div></div>
				</div>
				<div class="l3">
					<div></div>
				</div>
				<div class="l4">
					<div></div>
				</div>
			</div>
		</div>
	</div>
	<!-- !Preloader -->
	

	<!-- HTML starts here -->
	<div class="metaportal-fn-wrapper <?php echo esc_attr($core_ready); ?>" data-footer-sticky="<?php echo esc_attr($footerSticky);?>" data-nav-speed="<?php echo esc_attr($nav__speed);?>">


		<!-- Left bar starts here -->
		<?php get_template_part( 'inc/templates/left-bar' );?>
		<!-- Left bar ends here -->

		<!-- Right bar starts here -->
		<?php get_template_part( 'inc/templates/right-bar' );?>
		<!-- Right bar ends here -->

		<!-- Header starts here -->
		<?php get_template_part( 'inc/templates/desktop-navigation' );?>
		<!-- Header ends here -->

		<!-- Header starts here -->
		<?php get_template_part( 'inc/templates/mobile-navigation' );?>
		<!-- Header ends here -->

		<div class="metaportal_fn_content">
			<div class="metaportal_fn_pages">
				<div class="metaportal_fn_page_ajax">