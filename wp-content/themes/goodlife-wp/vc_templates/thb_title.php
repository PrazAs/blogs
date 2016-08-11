<?php function thb_title( $atts, $content = null ) {
  $atts = vc_map_get_attributes( 'thb_title', $atts );
  extract( $atts );
	
	$icon = $style == 'style2' ? '<i class="'.$icon.'"></i> ' : '';
	$style = $style == 'style2' ? 'simple' : '';
	$out = '<aside class="category_title no-border '.esc_attr($style).'"><h4>'.$icon.esc_attr($title).'</h4></aside>';
  
  return $out;
}
add_shortcode('thb_title', 'thb_title');
