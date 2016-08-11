<?php function thb_instagram( $atts, $content = null ) {
  $atts = vc_map_get_attributes( 'thb_instagram', $atts );
  extract( $atts );
	switch($columns) {
		case 2:
			$col = 'small-6 medium-6';
			break;
		case 3:
			$col = 'small-6 medium-4';
			break;
		case 4:
			$col = 'small-6 medium-6 large-3';
			break;
		case 5:
			$col = 'small-6 thb-five';
			break;
		case 6:
			$col = 'small-6 medium-4 large-2';
			break;
	  }
 	$out ='';
 	$nopadding = $column_padding ? 'no-padding ' : ''; 
	$username = strtolower($username);
	ob_start();
	if (false === ($instagram = get_transient('instagram-media-'.sanitize_title_with_dashes($username)))) {

		$remote = wp_remote_get('http://instagram.com/'.trim($username));

		if (is_wp_error($remote))
			return new WP_Error('site_down', esc_html__('Unable to communicate with Instagram.', 'goodlife'));

		if ( 200 != wp_remote_retrieve_response_code( $remote ) )
			return new WP_Error('invalid_response', esc_html__('Instagram did not return a 200.', 'goodlife'));

		$shards = explode('window._sharedData = ', $remote['body']);
		$insta_json = explode(';</script>', $shards[1]);
		$insta_array = json_decode($insta_json[0], TRUE);
		
		if (!$insta_array)
			return new WP_Error('bad_json', esc_html__('Instagram has returned invalid data.', 'goodlife'));


		$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
		
		$instagram = array();

		foreach ($images as $image) {
				$image['link'] = $image['code'];
				$image['display_src'] = $image['display_src'];

				$instagram[] = array(
					'link'          => $image['link'],
					'large'         => $image['display_src']
				);
		} 

		$instagram = serialize( $instagram );
		set_transient('instagram-media-'.sanitize_title_with_dashes($username), $instagram, apply_filters('null_instagram_cache_time', HOUR_IN_SECONDS*2));
	} else {
		$instagram = get_transient('instagram-media-'.sanitize_title_with_dashes($username));
	}

	$instagram = unserialize( $instagram );
	
	$media_array = array_slice($instagram, 0, $number);
	?>
	<div class="row <?php echo esc_attr($nopadding); ?>"><?php
				foreach ($media_array as $item) {
					echo '<figure class="'.$col.' columns">';
						echo '<a href="https://instagram.com/p/'. $item['link'] .'" target="_blank">';
						echo '<img src="'. esc_url($item['large']) .'" />';
						echo '</a>';
					echo '</figure>';
				}
				?>
	</div>
	<?php
	
	$out = ob_get_contents();
	if (ob_get_contents()) ob_end_clean();
	   
	return $out;
}
add_shortcode('thb_instagram', 'thb_instagram');
