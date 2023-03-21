<?php 
	$metaportal_fn_option = metaportal_fn_theme_option();

	if(has_nav_menu('left_menu')){
		$menu = wp_nav_menu( array('theme_location'  => 'left_menu','menu_class' => 'left_nav', 'echo' => false, 'link_before' => '<span class="creative_link">'.metaportal_fn_getSVG_theme('down'), 'link_after' => '</span>') );
	}else{
		$menu = '<ul><li><a href=""><span class="creative_link">'.esc_html__('No menu assigned', 'metaportal').'</span></a></li></ul>';
	}
?>

<!-- Left Navigation -->
<div class="metaportal_fn_leftnav_closer ready"></div>
<div class="metaportal_fn_leftnav ready">
	<a href="#" class="fn__closer"><span></span></a>
	<div class="navbox">
		<?php echo wp_kses(metaportal_fn_get_nav_nfts(),'post');?>
		
		
		<div class="nav_holder">
			
			<!-- For JS -->
			<span class="icon">
				<?php echo wp_kses(metaportal_fn_getSVG_theme('down'), 'post'); ?>
			</span>
			<!-- For JS -->
			
			<?php echo wp_kses($menu, 'post'); ?>
		</div>
		<div class="info_holder">
			<div class="copyright">
				<p>
					<?php 
					if(isset($metaportal_fn_option['nav__copyright'])){
						echo wp_kses($metaportal_fn_option['nav__copyright'], 'post');
					}else{
						$linkS = '<a href="https://themeforest.net/user/frenify/portfolio" target="_blank">';
						$linkE = '</a>';
						$copyright = sprintf( esc_html__( 'Copyright 2022 - Designed &amp; Developed by %1$sFrenify%2$s', 'metaportal' ), $linkS, $linkE );
						echo wp_kses($copyright, 'post');
					}?>
				</p>
			</div>
			<?php echo wp_kses(metaportal_fn_getSocialList(),'post');?>
		</div>
	</div>
</div>
<!-- !Left Navigation -->