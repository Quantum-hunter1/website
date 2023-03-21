<?php 
	$default_logo = metaportal_fn_getLogo();

	$logo  = '<div class="fn_logo">';
		$logo .= '<a href="'.esc_url(home_url('/')).'">';
			$logo .= '<img class="retina_logo" src="'.esc_url($default_logo[0]).'" alt="'.esc_attr__('logo', 'metaportal').'" />';
			$logo .= '<img class="desktop_logo" src="'.esc_url($default_logo[1]).'" alt="'.esc_attr__('logo', 'metaportal').'" />';
		$logo .= '</a>';
	$logo .= '</div>';


	if(has_nav_menu('main_menu')){
		$menu = wp_nav_menu( array('theme_location'  => 'main_menu','menu_class' => 'metaportal_fn_main_nav', 'echo' => false, 'link_before' => '<span class="creative_link">', 'link_after' => '</span>') );
	}

?>

<!-- Header -->
<header id="header">
	<div class="header">
		<div class="header_in">

			<div class="trigger_logo">
				<?php if(has_nav_menu('left_menu')){ ?>
				<div class="trigger">
					<span></span>
				</div>
				<?php } ?>
				<div class="logo">
					<?php echo wp_kses($logo, 'post'); ?>
				</div>
			</div>
			
			<?php if(has_nav_menu('main_menu')){ ?>
			<div class="nav">
				<?php echo wp_kses($menu, 'post'); ?>
			</div>
			<?php } ?>
			
			<?php if(0){ ?>
			<div class="wallet">
				<a href="#" class="metaportal_fn_button wallet_opener"><span><?php esc_html_e('Connect To Wallet', 'metaportal'); ?></span></a>
			</div>
			<?php } ?>
			
		</div>
	</div>
</header>
<!-- !Header -->


<!-- More Categories -->
<div class="metaportal_fn_hidden more_cats">
 	<div class="metaportal_fn_more_categories">
		<a href="#" data-more="<?php esc_attr_e('Show More','metaportal'); ?>" data-less="<?php esc_attr_e('Show Less','metaportal');?>">
			<span class="text"><?php esc_html_e('Show More','metaportal'); ?></span>
			<span class="fn_count"></span>
		</a>
	</div>
</div>
<!-- !More Categories -->


<div class="metaportal_fn_product_preloader">
	<div class="spinner"></div>
</div>







<!-- Product Modal -->
<div class="metaportal_fn_modal product_modal">
	<div class="modal_in">
		<div class="modal_closer">
			<a href="#">
				<?php echo wp_kses(metaportal_fn_getSVG_theme('cancel'),'post'); ?>
			</a>
		</div>
		<div class="modal_content">
			<div class="metaportal_fn_product_modal">
				<div class="img_item">
					<!-- here comes product's image -->
				</div>
				<div class="content_item">
					<div class="metaportal_fn_title" data-align="left">
						<h3 class="fn_title fn__maintitle" data-text=""><!-- here comes product's title --></h3>
						<div class="fn_cs_divider" data-align="left"><div class="divider"></div></div>
					</div>

					<div class="desc">
						<p><!-- here comes product's description --></p>
					</div>
					
					
					<div class="view_on">
						<!-- here comes product's buttons -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal_ux_closer"></div>
</div>
<!-- !Product Modal -->