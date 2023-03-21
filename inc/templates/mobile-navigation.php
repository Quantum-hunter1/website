<?php 
	$default_logo = metaportal_fn_getLogo();

	$logo  = '<div class="fn_logo">';
		$logo .= '<a href="'.esc_url(home_url('/')).'">';
			$logo .= '<img class="retina_logo" src="'.esc_url($default_logo[0]).'" alt="'.esc_attr__('logo', 'metaportal').'" />';
			$logo .= '<img class="desktop_logo" src="'.esc_url($default_logo[1]).'" alt="'.esc_attr__('logo', 'metaportal').'" />';
		$logo .= '</a>';
	$logo .= '</div>';


	if(has_nav_menu('mobile_menu')){
		$menu = wp_nav_menu( array('theme_location'  => 'mobile_menu','menu_class' => 'metaportal_fn_main_nav', 'echo' => false, 'link_before' => '<span class="creative_link">', 'link_after' => '</span>') );
	}else{
		$menu = '<ul class="metaportal_fn_main_nav"><li><a href=""><span class="creative_link">'.esc_html__('No menu assigned', 'metaportal').'</span></a></li></ul>';
	}

?>

<!-- Mobile Navigation -->
<div class="metaportal_fn_mobnav">

	<?php if(has_nav_menu('left_menu')){ ?>
	<div class="mob_top">
		<div class="social_trigger">
			<div class="trigger">
				<span></span>
			</div>
			<div class="social">
				<?php echo wp_kses(metaportal_fn_getSocialList('abbr'),'post');?>
			</div>
		</div>
		<div class="wallet">
			<a href="#" class="metaportal_fn_button wallet_opener"><span>Wallet</span></a>
		</div>
	</div>
	<?php } ?>
	
	<div class="mob_mid">
		<div class="logo">
			<?php echo wp_kses($logo, 'post'); ?>
		</div>
		
		<?php if(has_nav_menu('mobile_menu')){ ?>
		<div class="trigger">
			<span></span>
		</div>
		<?php } ?>
	</div>
	<div class="mob_bot">
		<?php echo wp_kses($menu, 'post'); ?>
	</div>
</div>
<!-- !Mobile Navigation -->