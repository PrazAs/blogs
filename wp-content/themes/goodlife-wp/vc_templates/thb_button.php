<?php function thb_button( $atts, $content = null ) {
  $atts = vc_map_get_attributes( 'thb_button', $atts );
  extract( $atts );
	
	$full_width = $full_width == "true" ? 'full' : '';
	
	
	$link = ( $link == '||' ) ? '' : $link;
	$link = vc_build_link( $link  );
	
	$link_to = $link['url'];
	$a_title = $link['title'];
	$a_target = $link['target'];	
	
	if($icon) { $a_title = '<span class="icon"><i class="'.$icon.'"></i></span> '.$a_title; }
	$out = '<a class="btn '.$color.' '.$animation.' '.$full_width.'" href="'.esc_attr($link_to).'" target="'.esc_attr( $a_target ).'" role="button" title="'.esc_attr( $a_title ).'">' .$a_title. '</a>';
  
  return $out;
}
add_shortcode('thb_button', 'thb_button');
