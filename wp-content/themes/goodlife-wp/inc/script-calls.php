<?php
// Main Styles
function thb_main_styles() {

		 // Register 
		 wp_register_style('foundation', THB_THEME_ROOT . '/assets/css/foundation.min.css', null, null);
	 	 wp_register_style("fa", THB_THEME_ROOT . '/assets/css/font-awesome.min.css', null, null);
		 wp_register_style('thb-app', THB_THEME_ROOT .  "/assets/css/app.css", null, null);
		 
		 // Enqueue
		 wp_enqueue_style('foundation');
		 wp_enqueue_style('fa');
		 wp_enqueue_style('thb-app');
		 wp_enqueue_style('style', get_stylesheet_uri(), null, null);	
		 
		 wp_enqueue_style( 'thb-google-fonts', thb_google_webfont() );
		 wp_add_inline_style( 'thb-app', thb_selection() );
}

add_action('wp_enqueue_scripts', 'thb_main_styles');


// Main Scripts
function thb_register_js() {
	
	if (!is_admin()) {
		global $wp_scripts;

		// Register 
		wp_register_script('thb-vendor', THB_THEME_ROOT . '/assets/js/vendor.min.js', array('jquery'), null, TRUE);
		wp_register_script('thb-app', THB_THEME_ROOT . '/assets/js/app.min.js', array('jquery'), null, TRUE);
		
		wp_register_script('html5-shiv', 'https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js', false, null, FALSE);
		$wp_scripts->add_data( 'html5-shiv', 'conditional', 'lt IE 9' );
		
		// Enqueue
		wp_enqueue_script('html5-shiv');
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script('comment-reply');
		}
		wp_enqueue_script('thb-vendor');
		wp_enqueue_script('thb-app');
		wp_localize_script( 'thb-app', 'themeajax', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
		
		
	}
}
add_action('wp_enqueue_scripts', 'thb_register_js');

// Admin Scripts
function thb_admin_scripts() {
	wp_register_script('thb-admin-meta', THB_THEME_ROOT .'/assets/js/admin-meta.min.js', array('jquery'));
	wp_enqueue_script('thb-admin-meta');
	
	wp_register_style("thb-admin-css", THB_THEME_ROOT . "/assets/css/admin.css");
	wp_enqueue_style('thb-admin-css'); 
	if (class_exists('WPBakeryVisualComposerAbstract')) {
		wp_enqueue_style( 'vc_extra_css', THB_THEME_ROOT . '/assets/css/vc_extra.css' );
	}
	
	wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'thb_admin_scripts');
?>