<?php

	add_action( 'after_setup_theme', 'metaportal_fn_setup', 50 );

	function metaportal_fn_setup(){

		// REGISTER THEME MENU
		if(function_exists('register_nav_menus')){
			register_nav_menus(array('main_menu' 	=> esc_html__('Main Menu','metaportal')));
			register_nav_menus(array('left_menu' 	=> esc_html__('Left Menu','metaportal')));
			register_nav_menus(array('mobile_menu' 	=> esc_html__('Mobile Menu','metaportal')));
		}

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_action( 'wp_enqueue_scripts', 'metaportal_fn_scripts', 100 ); 
		add_action( 'wp_enqueue_scripts', 'metaportal_fn_styles', 100 );
		add_action( 'wp_enqueue_scripts', 'metaportal_fn_inline_styles', 150 );
		add_action( 'admin_enqueue_scripts', 'metaportal_fn_admin_scripts' );

		// Actions
		add_action( 'tgmpa_register', 'metaportal_fn_register_required_plugins' );

		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size( 300, 300, true ); 								// Normal post thumbnails
		add_image_size( 'metaportal_fn_thumb-720-9999', 720, 9999, false);			
		add_image_size( 'metaportal_fn_thumb-1200-9999', 1200, 9999, false);			

		//Load Translation Text Domain
		load_theme_textdomain( 'metaportal', get_template_directory() . '/languages' );





		// Firing Title Tag Function
		metaportal_fn_theme_slug_setup();

		add_filter(	'widget_tag_cloud_args', 'metaportal_fn_tag_cloud_args');

		if ( ! isset( $content_width ) ) $content_width = 1170;

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'wp_list_comments' );

		add_editor_style() ;

		
		add_action( 'wp_ajax_nopriv_metaportal_fn_ajax_portfolio', 'metaportal_fn_ajax_portfolio' );
		add_action( 'wp_ajax_metaportal_fn_ajax_portfolio', 'metaportal_fn_ajax_portfolio' );
		
		
		// CONSTANT
		$my_theme 		= wp_get_theme( 'metaportal' );
		$version		= '1.0.0';
		if ( $my_theme->exists() ){
			$version 	= (string)$my_theme->get( 'Version' );
		}
		$version		= 'v'.$version;
		define('METAPORTAL_VERSION', $version);
		define('METAPORTAL_THEME_URL', get_template_directory_uri());
		
		
		/* ------------------------------------------------------------------------ */
		/*  Inlcudes
		/* ------------------------------------------------------------------------ */
		include_once( get_template_directory().'/inc/metaportal_fn_functions.php'); 				// Custom Functions
		include_once( get_template_directory().'/inc/metaportal_fn_googlefonts.php'); 			// Google Fonts Init
		include_once( get_template_directory().'/inc/metaportal_fn_css.php'); 					// Inline CSS
		include_once( get_template_directory().'/inc/metaportal_fn_sidebars.php'); 				// Widget Area
		include_once( get_template_directory().'/inc/metaportal_fn_pagination.php'); 				// Pagination

}







/* ----------------------------------------------------------------------------------- */
/*  ENQUEUE STYLES AND SCRIPTS
/* ----------------------------------------------------------------------------------- */
	function metaportal_fn_scripts() {
		wp_enqueue_script('modernizr-custom', get_template_directory_uri() . '/framework/js/modernizr.custom.js', array('jquery'), METAPORTAL_VERSION, FALSE);
		wp_enqueue_script('isotope', get_template_directory_uri() . '/framework/js/isotope.js', array('jquery'), METAPORTAL_VERSION, TRUE);
		wp_enqueue_script('waypoints', get_template_directory_uri() . '/framework/js/waypoints.js', array('jquery'), METAPORTAL_VERSION, TRUE);
		wp_enqueue_script('ripple', get_template_directory_uri() . '/framework/js/ripple.js', array('jquery'), METAPORTAL_VERSION, TRUE);
		wp_enqueue_script('particle', get_template_directory_uri() . '/framework/js/particle.js', array('jquery'), METAPORTAL_VERSION, TRUE);
		
		wp_enqueue_script('metaportal-fn-init', get_template_directory_uri() . '/framework/js/init.js', array('jquery'), METAPORTAL_VERSION, TRUE);
		
		wp_localize_script(
			'metaportal-fn-init',
			'MetaPortalAjaxObject',
			array( 
				'ajax_url' 			=> admin_url( 'admin-ajax.php' ),
				'siteurl'			=> home_url(),
				'nonce'				=> wp_create_nonce('metaportal-secure'),
				'clear_all_text'	=> esc_html__('Clear All', 'metaportal'),
				'read_more_nft'		=> esc_html__('Read More', 'metaportal'),
				'cancel_svg'		=> get_template_directory_uri() . '/framework/svg/cancel.svg',
				'list_limit'		=> 4
			)
		);
		
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	}
	
	function metaportal_fn_admin_scripts() {
		wp_enqueue_script('metaportal-fn-widget-upload', get_template_directory_uri() . '/framework/js/widget.upload.js', array('jquery'), METAPORTAL_VERSION, FALSE);
		wp_enqueue_style('metaportal-fn-fontello', get_template_directory_uri().'/framework/css/fontello.css', array(), METAPORTAL_VERSION, 'all');
		wp_enqueue_style('metaportal-fn-admin-style', get_template_directory_uri().'/framework/css/admin.style.css', array(), METAPORTAL_VERSION, 'all');
	}

	function metaportal_fn_styles(){
		wp_enqueue_style('metaportal-fn-font-url', metaportal_fn_font_url(), array(), null );
		wp_enqueue_style('fontello', get_template_directory_uri().'/framework/css/fontello.css', array(), METAPORTAL_VERSION, 'all');
		wp_enqueue_style('metaportal-fn-base', get_template_directory_uri().'/framework/css/base.css', array(), METAPORTAL_VERSION, 'all');
		wp_enqueue_style('metaportal-fn-skeleton', get_template_directory_uri().'/framework/css/skeleton.css', array(), METAPORTAL_VERSION, 'all');
		wp_enqueue_style('metaportal-fn-wp-core', get_template_directory_uri().'/framework/css/import/wp-core.css', array(), METAPORTAL_VERSION, 'all');
		wp_enqueue_style('metaportal-fn-theme-base', get_template_directory_uri().'/framework/css/import/theme-base.css', array(), METAPORTAL_VERSION, 'all');
		wp_enqueue_style('metaportal-fn-widgets', get_template_directory_uri().'/framework/css/import/widgets.css', array(), METAPORTAL_VERSION, 'all');
		wp_enqueue_style('metaportal-fn-stylesheet', get_stylesheet_uri(), array(), METAPORTAL_VERSION, 'all' ); // Main Stylesheet
	}





/* ----------------------------------------------------------------------------------- */
/*  Title tag: works WordPress v4.1 and above
/* ----------------------------------------------------------------------------------- */
	function metaportal_fn_theme_slug_setup() {
		add_theme_support( 'title-tag' );
	}
/* ----------------------------------------------------------------------------------- */
/*  Tagcloud widget
/* ----------------------------------------------------------------------------------- */
	
	function metaportal_fn_tag_cloud_args($args)
	{
		
		$my_args = array('smallest' => 14, 'largest' => 14, 'unit'=>'px', 'orderby'=>'count', 'order'=>'DESC' );
		$args = wp_parse_args( $args, $my_args );
		return $args;
	}

	
/*-----------------------------------------------------------------------------------*/
/*	TGM Plugin Activation
/*-----------------------------------------------------------------------------------*/

require_once get_template_directory().'/plugin/class-tgm-plugin-activation.php';

function metaportal_fn_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin bundled with a theme.
		array(
			'name'               => 'MetaPortal Core', // The plugin name.
			'slug'               => 'metaportal-core', // The plugin slug (typically the folder name).
			'source'             => 'https://frenify.com/work/envato/frenify/wp/metaportal/files/metaportal-core.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => 'Elementor', // The plugin name.
			'slug'               => 'elementor', // The plugin slug (typically the folder name).
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => 'Contact Form 7', // The plugin name.
			'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => 'Redux Vendor Support', // The plugin name.
			'slug'               => 'redux-vendor-support-master', // The plugin slug (typically the folder name).
			'source'             => 'https://github.com/reduxframework/redux-vendor-support/archive/master.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'metaportal',          	 	 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}



?>