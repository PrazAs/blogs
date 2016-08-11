<?php

/*-----------------------------------------------------------------------------------

	Here we have all the custom functions for the theme
	Please be extremely cautious editing this file.
	You have been warned!

-------------------------------------------------------------------------------------*/

// Define Theme Name for localization
define('THB_THEME_ROOT', get_template_directory_uri());
define('THB_THEME_ROOT_ABS', get_template_directory());

// Option-Tree Theme Mode
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
add_filter( 'ot_override_forced_textarea_simple', '__return_true' );
require get_template_directory() .'/inc/ot-radioimages.php';
require get_template_directory() .'/inc/ot-metaboxes.php';
require get_template_directory() .'/inc/ot-themeoptions.php';
require get_template_directory() .'/inc/ot-functions.php';

if ( ! class_exists( 'OT_Loader' ) ) {
	require get_template_directory() .'/admin/ot-loader.php';
}

// Script Calls
require get_template_directory() .'/inc/script-calls.php';

// Excerpts
require get_template_directory() .'/inc/excerpts.php';

// Ajax
require get_template_directory() .'/inc/ajax.php';

// TGM Plugin Activation Class
if ( is_admin() ) {
	require get_template_directory() .'/inc/class-tgm-plugin-activation.php';
	require get_template_directory() .'/inc/plugins.php';
}

// Category Settings
require get_template_directory() .'/inc/category-settings.php';

// Add Menu Support
require get_template_directory() .'/inc/wp3menu.php';

// Enable Sidebars
require get_template_directory() .'/inc/sidebar.php';

// Misc 
require get_template_directory() .'/inc/misc.php';

// Widgets
require get_template_directory() .'/inc/widgets.php';

// CSS Output of Theme Options
require get_template_directory() .'/inc/selection.php';

// WPML Support
require get_template_directory() .'/inc/wpml.php';

// Twitter oAuth
require get_template_directory() .'/inc/TwitterAPIExchange.php';

// Visual Composer Integration
require get_template_directory() .'/inc/visualcomposer.php';

// Share Counts
require get_template_directory() .'/inc/posts-social-shares-count/posts-share-count.php';
require get_template_directory() .'/inc/post-social.php';

// Post Views
require get_template_directory() .'/inc/post-views.php';

// Post Reviews
require get_template_directory() .'/inc/post-reviews.php';

// WordPress Importer
if ( is_admin() ) {
	require get_template_directory() . '/inc/import.php';
	require get_template_directory() . '/inc/one-click-demo-import/one-click-demo-import.php';
}