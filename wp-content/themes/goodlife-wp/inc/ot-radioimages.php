<?php

function thb_filter_radio_images( $array, $field_id ) {
  
  /* only run the filter where the field ID is my_radio_images */
  if ( $field_id == 'sidebar_position' ) {
    $array = array(
      array(
        'value'   => 'left-sidebar',
        'label'   => esc_html__( 'Left Sidebar', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/left-sidebar.png'
      ),
      array(
        'value'   => 'right-sidebar',
        'label'   => esc_html__( 'Right Sidebar', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/right-sidebar.png'
      )
    );
  }
  if ( $field_id == 'footer_columns' ) {
    $array = array(
      array(
        'value'   => 'fourcolumns',
        'label'   => esc_html__( 'Four Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/four-columns.png'
      ),
      array(
        'value'   => 'threecolumns',
        'label'   => esc_html__( 'Three Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/three-columns.png'
      ),
      array(
        'value'   => 'twocolumns',
        'label'   => esc_html__( 'Two Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/two-columns.png'
      ),
      array(
        'value'   => 'doubleleft',
        'label'   => esc_html__( 'Double Left Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/doubleleft-columns.png'
      ),
      array(
        'value'   => 'doubleright',
        'label'   => esc_html__( 'Double Right Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/doubleright-columns.png'
      ),
      array(
        'value'   => 'fivecolumns',
        'label'   => esc_html__( 'Five Columns', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/five-columns.png'
      ),
      array(
        'value'   => 'onecolumns',
        'label'   => esc_html__( 'Single Column', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/one-columns.png'
      )
      
    );
  }
	if ( $field_id == 'standard-post-detail-style' ) {
	  $array = array(
	    array(
	      'value'   => 'style1',
	      'label'   => esc_html__( 'Classic with Sidebar', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/news-classic.png'
	    ),
	    array(
	      'value'   => 'style2',
	      'label'   => esc_html__( 'Full Cover', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/news-full-big-image.png'
	    ),
	    array(
	      'value'   => 'style3',
	      'label'   => esc_html__( 'Standard Cover', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/news-big-image.png'
	    ),
	    array(
	      'value'   => 'style5',
	      'label'   => esc_html__( 'Full Small Cover', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/news-cover-bg.png'
	    ),
	    array(
	      'value'   => 'style4',
	      'label'   => esc_html__( 'Center', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/news-center.png'
	    )
	    
	  );
	}
  if ( $field_id == 'gallery-post-detail-style' ) {
    $array = array(
      array(
        'value'   => 'style1',
        'label'   => esc_html__( 'Horizontal Image with Sidebar', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/gallery-full-width-with-sidebar.png'
      ),
      array(
        'value'   => 'style2',
        'label'   => esc_html__( 'Vertical Image with Sidebar', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/gallery-half-width-sidebar.png'
      ),
      array(
        'value'   => 'style3',
        'label'   => esc_html__( 'Horizontal Image without Sidebar', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/gallery-full-width.png'
      ),
      array(
        'value'   => 'style4',
        'label'   => esc_html__( 'Vertical Image without Sidebar', 'option-tree' ),
        'src'     => THB_THEME_ROOT . '/assets/img/admin/gallery-half-width.png'
      )
      
    );
	}
	
	if ( $field_id == 'video-post-detail-style' ) {
	  $array = array(
	    array(
	      'value'   => 'style1',
	      'label'   => esc_html__( 'Large Video Player', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/video-full-width-light.png'
	    ),
	    array(
	      'value'   => 'style2',
	      'label'   => esc_html__( 'Small Video Play', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/video-half-width-light.png'
	    )
	  );
	}
	
	if ( $field_id == 'demo-select' ) {
	  $array = array(
	    array(
	      'value'   => '0',
	      'label'   => esc_html__( 'GoodLife', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/demos/goodlife.jpg'
	    ),
	    array(
	      'value'   => '1',
	      'label'   => esc_html__( 'GoodMusic', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/demos/goodmusic.jpg'
	    ),
	    array(
	      'value'   => '2',
	      'label'   => esc_html__( 'GoodGame', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/demos/goodgame.jpg'
	    ),
	    array(
	      'value'   => '3',
	      'label'   => esc_html__( 'GoodSport', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/demos/goodsport.jpg'
	    ),
	    array(
	      'value'   => '4',
	      'label'   => esc_html__( 'GoodLook', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/demos/goodlook.jpg'
	    ),
	    array(
	      'value'   => '5',
	      'label'   => esc_html__( 'GoodTech', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/demos/goodtech.jpg'
	    ),
	    array(
	      'value'   => '6',
	      'label'   => esc_html__( 'GoodBlog', 'option-tree' ),
	      'src'     => THB_THEME_ROOT . '/assets/img/admin/demos/goodblog.jpg'
	    )
	    
	  );
	}
  return $array;
  
}
add_filter( 'ot_radio_images', 'thb_filter_radio_images', 10, 2 );

function thb_filter_options_name() {
	return __('<a href="http://fuelthemes.net">Fuel Themes</a>', 'goodlife');
}
add_filter( 'ot_header_version_text', 'thb_filter_options_name', 10, 2 );


function thb_filter_upload_name() {
	return esc_html__('Send to Theme Options', 'goodlife');
}
add_filter( 'ot_upload_text', 'thb_filter_upload_name', 10, 2 );

function thb_header_list() {
	echo '<li class="theme_link"><a href="http://fuelthemes.ticksy.com/" target="_blank">Support Forum</a></li>';
	echo '<li class="theme_link right"><a href="http://wpeng.in/fuelt/" target="_blank">Recommended Hosting</a></li>';
	echo '<li class="theme_link right"><a href="https://wpml.org/?aid=85928&affiliate_key=PIP3XupfKQOZ" target="_blank">Purchase WPML</a></li>';
}
add_filter( 'ot_header_list', 'thb_header_list' );

function thb_filter_ot_recognized_font_families( $array, $field_id ) {
	$array['helveticaneue'] = '"Helvetica Neue", Helvetica, Roboto, Arial, sans-serif';
	ot_fetch_google_fonts( true, false );
	$ot_google_fonts = wp_list_pluck( get_theme_mod( 'ot_google_fonts', array() ), 'family' );
  $array = array_merge($array,$ot_google_fonts);
  
  foreach ($array as $font => $value) {
		$thb_font_array[$value] = $value;
  }
  return $thb_font_array;
}
add_filter( 'ot_recognized_font_families', 'thb_filter_ot_recognized_font_families', 10, 2 );

function thb_filter_typography_fields( $array, $field_id ) {

   if ( $field_id == "title_type" ) {
      $array = array( 'font-family');
   }

   return $array;

}

add_filter( 'ot_recognized_typography_fields', 'thb_filter_typography_fields', 10, 2 );

function thb_filter_typography_fields2( $array, $field_id ) {
	
   $fields = array('menu_left_type', 'menu_right_type', 'menu_left_submenu_type');
   if ( in_array($field_id, $fields )) {
      $array = array('font-family', 'font-size', 'font-style', 'font-variant', 'font-weight', 'text-decoration', 'text-transform', 'line-height', 'letter-spacing');
   }

   return $array;

}

add_filter( 'ot_recognized_typography_fields', 'thb_filter_typography_fields2', 10, 2 );