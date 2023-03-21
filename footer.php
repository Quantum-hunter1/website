<?php 
$metaportal_fn_option 	= metaportal_fn_theme_option();

// magic cursor options
$magic_cursor 		= array();
if(isset($metaportal_fn_option['magic_cursor'])){
	$magic_cursor 	= $metaportal_fn_option['magic_cursor'];
}
$mcursor__count		= 0;
$mcursor__default 	= 'no';
$mcursor__link 		= 'no';
$mcursor__slider 	= 'no';
if(!empty($magic_cursor)){
	$mcursor__count = count($magic_cursor);
	foreach($magic_cursor as $key => $value) {
		if($value == 'default'){$mcursor__default 	= 'yes';}
		if($value == 'link'){$mcursor__link 		= 'yes';}
		if($value == 'slider'){$mcursor__slider 	= 'yes';}
	}
}
if(isset($_GET['remove_mcursor'])){
	$mcursor__count = 0;
}

// totop switcher
$totop_switcher = 'enable';
if(isset($metaportal_fn_option['totop_switcher'])){
	$totop_switcher = $metaportal_fn_option['totop_switcher'];
}

// search switcher
$nav__search = 'enable';
if(isset($metaportal_fn_option['nav__search'])){
	$nav__search = $metaportal_fn_option['nav__search'];
}

?>
			</div>
			
			<!-- Footer -->
			<footer id="footer">
				<div class="container wide">
					<div class="footer">
						<div class="left_part">
							<p>
								<?php 
									if(isset($metaportal_fn_option['footer__copyright'])){
										echo wp_kses($metaportal_fn_option['footer__copyright'], 'post');
									}else{
										$linkS = '<a href="https://themeforest.net/user/frenify/portfolio" target="_blank">';
										$linkE = '</a>';
										$copyright = sprintf( esc_html__( 'Copyright 2022 - Designed &amp; Developed by %1$sFrenify%2$s', 'metaportal' ), $linkS, $linkE );
										echo wp_kses($copyright, 'post');
									}
								?>
							</p>
						</div>
						<?php if ( is_active_sidebar( 'footer-bottom-widget' )){ ?>
						<div class="right_part">
							<?php dynamic_sidebar( 'footer-bottom-widget' ); ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</footer>
			<!-- !Footer -->

		</div>
			
	</div>
	<!-- All website content ends here -->
	
	
	<?php if($mcursor__count > 0){ ?>
	<div class="frenify-cursor cursor-outer" data-default="<?php echo esc_attr($mcursor__default);?>" data-link="<?php echo esc_attr($mcursor__link);?>" data-slider="<?php echo esc_attr($mcursor__slider);?>"><span class="fn-cursor"></span></div>
	<div class="frenify-cursor cursor-inner" data-default="<?php echo esc_attr($mcursor__default);?>" data-link="<?php echo esc_attr($mcursor__link);?>" data-slider="<?php echo esc_attr($mcursor__slider);?>"><span class="fn-cursor"><span class="fn-left"></span><span class="fn-right"></span></span></div>
	<?php } ?>

</div>
<!-- HTML ends here -->
			
			
<?php if($totop_switcher != 'disable'){ ?>
<!-- Totop -->
<a href="#" class="metaportal_fn_totop">
	<span class="totop_inner">
		<span class="icon">
			<?php echo wp_kses(metaportal_fn_getSVG_theme('down'),'post');?>
		</span>
		<span class="text"><?php esc_html_e('Scroll To Top', 'metaportal');?></span>
	</span>
</a>
<!-- /Totop -->
<?php } ?>


<?php if($nav__search != 'disable'){ ?>
<!-- Searchbox Popup -->
<div class="metaportal_fn_search_closer"></div>
<div class="metaportal_fn_searchbox">
	<div class="container small">
		<div class="searchbox">
			<form action="<?php echo esc_url(home_url('/')); ?>" method="get" >
				<input type="text" placeholder="<?php esc_attr_e('Search here...', 'metaportal');?>" name="s" autocomplete="off" />
				<input type="submit" class="pe-7s-search" value="" />
				<a href="#"><?php echo wp_kses_post(metaportal_fn_getSVG_theme('loupe'));?></a>
			</form>
		</div>
	</div>
</div>
<!-- !Searchbox Popup -->
<?php } ?>

<?php 
	$socialList = metaportal_fn_getSocialList('abbr');
	if($socialList != ''){
?>
<!-- Social List -->
<div id="social">
	<div class="social">
		<h4 class="title"><?php esc_html_e('Follow Us:','metaportal'); ?></h4>
		<?php echo wp_kses($socialList,'post');?>
	</div>
</div>
<!-- !Social List -->
<?php } ?>

<?php if($nav__search != 'disable'){ ?>
<!-- Search Button -->
<a href="#" class="metaportal_fn_search">
	<span class="icon">
		<?php echo wp_kses(metaportal_fn_getSVG_theme('loupe'),'post');?>
	</span>
</a>
<!-- !Search Button -->
<?php } ?>


<?php wp_footer(); ?>
</body>
</html>