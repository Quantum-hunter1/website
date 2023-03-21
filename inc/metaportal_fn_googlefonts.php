<?php
function metaportal_fn_fonts() {
	$metaportal_fn_option = metaportal_fn_theme_option();
	$customfont = '';
	
	$default = array(
					'arial',
					'verdana',
					'trebuchet',
					'georgia',
					'times',
					'tahoma',
					'helvetica');
	$bodyFont = $navFont = $navMobFont = $headingFont = $blockquoteFont = $extraFont = '';
	if(isset($metaportal_fn_option['body_font']['font-family'])){$bodyFont = $metaportal_fn_option['body_font']['font-family'];}
	if(isset($metaportal_fn_option['nav_font']['font-family'])){$navFont = $metaportal_fn_option['nav_font']['font-family'];}
	if(isset($metaportal_fn_option['nav_mob_font']['font-family'])){$navMobFont = $metaportal_fn_option['nav_mob_font']['font-family'];}
	if(isset($metaportal_fn_option['heading_font']['font-family'])){$headingFont = $metaportal_fn_option['heading_font']['font-family'];}
	if(isset($metaportal_fn_option['blockquote_font']['font-family'])){$blockquoteFont = $metaportal_fn_option['blockquote_font']['font-family'];}
	if(isset($metaportal_fn_option['extra_font']['font-family'])){$extraFont = $metaportal_fn_option['extra_font']['font-family'];}
	
	$googlefonts = array(
					$bodyFont,
					$navFont,
					$navMobFont,
					$headingFont,
					$blockquoteFont,
					$extraFont,
					);
				
	foreach($googlefonts as $getfonts) {
		if(!in_array($getfonts, $default) && $getfonts != '') {
			$customfont = str_replace(' ', '+', $getfonts). ':400,400italic,500,500italic,600,600italic,700,700italic|' . $customfont;
		}
	}
	
	if($customfont != '' && isset($metaportal_fn_option)){
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'metaportal_fn_googlefonts', "$protocol://fonts.googleapis.com/css?family=" . substr_replace($customfont ,"",-1) . "&subset=latin,cyrillic,greek,vietnamese" );
	}	
}
add_action( 'wp_enqueue_scripts', 'metaportal_fn_fonts' );
?>