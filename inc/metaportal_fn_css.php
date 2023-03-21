<?php

function metaportal_fn_inline_styles() {
	
	$metaportal_fn_option = metaportal_fn_theme_option();
	
	
	
	wp_enqueue_style('metaportal_fn_inline', get_template_directory_uri().'/framework/css/inline.css', array(), METAPORTAL_THEME_URL, 'all');
	/************************** START styles **************************/
	$metaportal_fn_custom_css 		= "";
	
	
	
	/* Page Spacing */
	$margin_top 	= 100;
	$margin_bottom 	= 100;
	$margin 		= 0;

	if(function_exists('rwmb_meta')){
		if(isset(get_post_meta(get_the_ID())['metaportal_fn_page_margin_top'])){
			$margin_top = get_post_meta(get_the_ID(), 'metaportal_fn_page_margin_top', true);
		}
		if(isset(get_post_meta(get_the_ID())['metaportal_fn_page_margin_bottom'])){
			$margin_bottom = get_post_meta(get_the_ID(), 'metaportal_fn_page_margin_bottom', true);
		}
		$margin += (int)$margin_top + (int)$margin_bottom;
	}
	$metaportal_fn_custom_css .= "
		.metaportal_fn_full_page_in{padding-top:{$margin_top}px;}
		.metaportal_fn_full_page_in{padding-bottom:{$margin_bottom}px;}";
	if($margin_top > 100){$margin_top = 100;}
	if($margin_bottom > 100){$margin_bottom = 100;}
	$metaportal_fn_custom_css .= "
		@media(max-width: 1040px){
			.metaportal_fn_full_page_in{padding-top:{$margin_top}px;}
			.metaportal_fn_full_page_in{padding-bottom:{$margin_bottom}px;}
		}
	";
	
	
	
	
	
	
	// Magic Cursor
	$mcursor_color 		= '#fff';
	if(isset($metaportal_fn_option['mcursor_color'])){
		$mcursor_color 	= $metaportal_fn_option['mcursor_color'];
	}
	$mcursor_5 			= metaportal_fn_hex2rgba($mcursor_color,0.5);
	$mcursor_1	 		= metaportal_fn_hex2rgba($mcursor_color,0.1);
	$metaportal_fn_custom_css .= "
		.cursor-inner.cursor-slider.cursor-hover span:after,
		.cursor-inner.cursor-slider.cursor-hover span:before{
			background-color: {$mcursor_color};
		}
		.cursor-outer .fn-cursor,.cursor-inner.cursor-slider:not(.cursor-hover) .fn-cursor{
			border-color: {$mcursor_5};
		}
		.cursor-inner .fn-cursor,.cursor-inner .fn-left:before,.cursor-inner .fn-left:after,.cursor-inner .fn-right:before,.cursor-inner .fn-right:after{
			background-color: {$mcursor_5};
		}
		.cursor-inner.cursor-hover .fn-cursor{
			background-color: {$mcursor_1};
		}
	";
	
	/* Main Color #1 */
	$main_color_1 = '#cc00ff';
	if(isset($metaportal_fn_option['main_color_1'])){
		$main_color_1 = $metaportal_fn_option['main_color_1'];
	}
	
	/* Main Color #2 */
	$main_color_2 = '#7000ff';
	if(isset($metaportal_fn_option['main_color_2'])){
		$main_color_2 = $metaportal_fn_option['main_color_2'];
	}
	
	/* Heading Color */
	$heading_color = '#fff';
	if(isset($metaportal_fn_option['heading_color'])){
		$heading_color = $metaportal_fn_option['heading_color'];
	}
	
	/* Heading Hover Color */
	$heading_hover_color = '#cc00ff';
	if(isset($metaportal_fn_option['heading_hover_color'])){
		$heading_hover_color = $metaportal_fn_option['heading_hover_color'];
	}
	
	/* Body Color */
	$body_color = '#9ba0b8';
	if(isset($metaportal_fn_option['body_color'])){
		$body_color = $metaportal_fn_option['body_color'];
	}
	
	$metaportal_fn_custom_css .= "
		:root{
			--mc1: {$main_color_1};
			--mc2: {$main_color_2};
			--hc: {$heading_color};
			--bc: {$body_color};
		}
	";
	
	$nav__width = 'contained';
	if(isset($metaportal_fn_option['nav__width'])){
		$nav__width = $metaportal_fn_option['nav__width'];
	}
	if($nav__width == 'full'){
		$metaportal_fn_custom_css .= '.metaportal_fn_nav{width: 100%;}';
	}
	
	$nav__bg_image = '';
	if(isset($metaportal_fn_option['nav__bg_image']['url'])){
		$nav__bg_image = $metaportal_fn_option['nav__bg_image']['url'];
	}
	if($nav__bg_image != ''){
		$metaportal_fn_custom_css .= '.metaportal_fn_nav .nav_bg_img{background-image: url('.$nav__bg_image.');}';
	}
	
	$nav__speed = 'medium';
	if(isset($metaportal_fn_option['nav__speed'])){
		$nav__speed = $metaportal_fn_option['nav__speed'];
	}
	if($nav__speed == 'normal'){
		$metaportal_fn_custom_css .= '
			.metaportal_fn_nav,
			.metaportal_fn_nav.go,
			.nav_overlay,
			.nav_overlay.go{
				transition-duration: 1s;
				transition-delay: 0s;
			}
		';
	}
	
	if(isset($metaportal_fn_option['bg__gradient']) && isset($metaportal_fn_option['bg__gradient']['to']) && isset($metaportal_fn_option['bg__gradient']['from']) && $metaportal_fn_option['bg__gradient']['to'] != '' & $metaportal_fn_option['bg__gradient']['from'] != ''){
		$degree = '90deg';
		$to = $metaportal_fn_option['bg__gradient']['to'];
		$from = $metaportal_fn_option['bg__gradient']['from'];
		$metaportal_fn_custom_css .= '
			.metaportal_fn_mobnav,
			body,
			.header.active{
				background: -moz-linear-gradient('.$degree.', '.$from.' 0%, '.$to.' 100%);
				background: -webkit-linear-gradient('.$degree.', '.$from.' 0%, '.$to.' 100%);
				background: linear-gradient('.$degree.', '.$from.' 0%, '.$to.' 100%);
				background-color: '.$from.';
			}
		';
	}else{
		$metaportal_fn_custom_css .= '
			.header.active,
			.metaportal_fn_mobnav,
			.metaportal-fn-wrapper{
				background: none;
				background-color: #1b121d;
			}
			.metaportal-fn-wrapper{
				position: relative;
				z-index: 1;
			}
			.metaportal-fn-wrapper:after{
				content: "";
				position: fixed;
				width: 270px;
				height: 270px;
				top: 42.8%;
				right: 25%;
				background-color: var(--mc2);
				border-radius: 100%;
				-webkit-filter: blur(150px);
				-o-filter: blur(150px);
				filter: blur(150px);
				backface-visibility: hidden;
				pointer-events: none;
				z-index: -1;
			}
			.metaportal-fn-wrapper:before{
				content: "";
				position: fixed;
				width: 270px;
				height: 270px;
				top: 27.5%;
				left: 23.9%;
				background-color: var(--mc1);
				border-radius: 100%;
				-webkit-filter: blur(150px);
				-o-filter: blur(150px);
				filter: blur(150px);
				backface-visibility: hidden;
				pointer-events: none;
				z-index: -1;
			}
		';
	}
	// since v1.0.5
	$metaportal_fn_custom_css .= "
		@media(max-width: 600px){
			#wpadminbar{position: fixed;}
		}
	";
	// since v1.0.8
	if(isset($metaportal_fn_option['logo_size']['width'])){
		$width = (int)$metaportal_fn_option['logo_size']['width'];
		$metaportal_fn_custom_css .= "
			.desktop_logo, .retina_logo{max-width: {$width}px;}
		";
	}
	if(isset($metaportal_fn_option['logo_size']['height'])){
		$height = (int)$metaportal_fn_option['logo_size']['height'];
		$metaportal_fn_custom_css .= "
			.desktop_logo, .retina_logo{max-height: {$height}px;}
		";
	}
	
	/****************************** END styles *****************************/
	if(isset($metaportal_fn_option['custom_css'])){
		$metaportal_fn_custom_css .= "{$metaportal_fn_option['custom_css']}";	
	}

	wp_add_inline_style( 'metaportal_fn_inline', $metaportal_fn_custom_css );

			
}

?>