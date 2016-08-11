<?php 
function thb_ocdi_import_files() {
    return array(
        array(
            'import_file_name'       => 'GoodLife',
            'import_file_url'        => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodlife/democontent.xml",
            'import_widget_file_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodlife/widget_data.json",
            'import_theme_options_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodlife/theme-options.txt"
        ),
        array(
            'import_file_name'       => 'GoodMusic',
            'import_file_url'        => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodmusic/democontent.xml",
            'import_widget_file_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodmusic/widget_data.json",
            'import_theme_options_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodmusic/theme-options.txt"
        ),
        array(
            'import_file_name'       => 'GoodGame',
            'import_file_url'        => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodgame/democontent.xml",
            'import_widget_file_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodgame/widget_data.json",
            'import_theme_options_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodgame/theme-options.txt"
        ),
        array(
            'import_file_name'       => 'GoodSport',
            'import_file_url'        => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodsport/democontent.xml",
            'import_widget_file_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodsport/widget_data.json",
            'import_theme_options_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodsport/theme-options.txt"
        ),
        array(
            'import_file_name'       => 'GoodLook',
            'import_file_url'        => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodlook/democontent.xml",
            'import_widget_file_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodlook/widget_data.json",
            'import_theme_options_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodlook/theme-options.txt"
        ),
        array(
            'import_file_name'       => 'GoodTech',
            'import_file_url'        => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodtech/democontent.xml",
            'import_widget_file_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodtech/widget_data.json",
            'import_theme_options_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodtech/theme-options.txt"
        ),
        array(
            'import_file_name'       => 'GoodBlog',
            'import_file_url'        => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodblog/democontent.xml",
            'import_widget_file_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodblog/widget_data.json",
            'import_theme_options_url' => "http://themes.fuelthemes.net/theme-demo-files/goodlife/goodblog/theme-options.txt"
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'thb_ocdi_import_files' );

function thb_ocdi_before_widgets_import( $selected_import, $selected_import_files ) {

  $options_import_data = $selected_import_files;

	$options = unserialize( ot_decode( $options_import_data ) );
	
	/* get settings array */
	$settings = get_option( ot_settings_id() );
	
	/* has options */
	if ( is_array( $options ) ) {
	  
	  /* validate options */
	  if ( is_array( $settings ) ) {
	  
	    foreach( $settings['settings'] as $setting ) {
	    
	      if ( isset( $options[$setting['id']] ) ) {
	        
	        $content = ot_stripslashes( $options[$setting['id']] );
	        
	        $options[$setting['id']] = ot_validate_setting( $content, $setting['type'], $setting['id'] );
	        
	      }
	    
	    }
	  
	  }
	  
	  /* update the option tree array */
	  update_option( ot_options_id(), $options );
	}
}
add_action( 'pt-ocdi/before_widgets_import', 'thb_ocdi_before_widgets_import', 2, 2 );

function thb_ocdi_after_import( $selected_import ) {
	
	/* Set Pages */
	update_option( 'show_on_front', 'page' );
	
	$home = get_page_by_title('Home');
	
	update_option( 'page_on_front', $home->ID );
	
	/* Set Menus */
	$navigation = get_term_by('name', 'navigation', 'nav_menu');
	$top_menu = get_term_by('name', 'subheader-menu', 'nav_menu');
	
	set_theme_mod( 'nav_menu_locations' , array('nav-menu' => $navigation->term_id, 'mobile-menu' => $navigation->term_id, 'subheader-menu' => $top_menu->term_id ) );
}
add_action( 'pt-ocdi/after_import', 'thb_ocdi_after_import' );