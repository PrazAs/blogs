<?php
add_action("wp_ajax_nopriv_thb_listing", "thb_listing");
add_action("wp_ajax_thb_listing", "thb_listing");

function thb_listing() {
	$count = $_POST['count'];
	$type = $_POST['type'];
	$time = $_POST['time'];
	
	if ($type == 'comments') {
	  $args = array(
	  		'post_type'=>'post', 
	  		'post_status' => 'publish', 
	  		'ignore_sticky_posts' => 1,
	  		'no_found_rows' => true,
	  		'posts_per_page' => $count,
	  		'orderby' => 'comment_count', 
	  		'order'=> 'DESC'
	  	);
	  if ($time == '7') {
	  	$args['date_query'] = array(
	  		array(
	  			'after' => '1 week ago'
	  		)
	  	);
	  } else if ($time == '30') {
	  	$args['date_query'] = array(
	  		array(
	  			'after' => '1 month ago'
	  		)
	  	);
	  } else if ($time == '365') {
	  	$args['date_query'] = array(
	  		array(
	  			'after' => '1 year ago'
	  		)
	  	);
	  }
	  $postmeta = array(false,false,false,true,false);
	} else {
		$args = array(
			'post_type'=>'post', 
			'post_status' => 'publish', 
			'ignore_sticky_posts' => 1,
			'no_found_rows' => true,
			'post__in' => thb_most_viewed($time, $count),
			'orderby' => 'post__in'
		);
		$postmeta = array(false,false,false,false,true);
	}
	
	$query = new WP_Query( $args );
	
	if (!$query->found_posts) {
		$discussed_posts = new WP_Query(array(
			'post_type'=>'post', 
			'post_status' => 'publish', 
			'ignore_sticky_posts' => 1,
			'no_found_rows' => true,
			'posts_per_page' => $count
			));
	}
	$counts = 0;
	if ($query->have_posts()) :  while ($query->have_posts()) : $query->the_post();
			$counts++;
			set_query_var( 'counts', $counts);
			set_query_var( 'postmeta', $postmeta );
			get_template_part( 'inc/poststyles/thumbnail-listing' );
	endwhile; else : 
		get_template_part( 'inc/loop/notfound-list' );
	endif; 
	wp_die();
}
add_action("wp_ajax_thb-parse-embed", "thb_ajax_parse_embed", 1);
add_action("wp_ajax_nopriv_thb-parse-embed", "thb_ajax_parse_embed", 1);

function thb_ajax_parse_embed() {
	global $post, $wp_embed;
	if ( ! $post = get_post( (int) $_POST['post_ID'] ) ) {
		wp_send_json_error();
	}
	if ( empty( $_POST['shortcode'] ) ) {
		wp_send_json_error();
	}
	$shortcode = wp_unslash( $_POST['shortcode'] );
	preg_match( '/' . get_shortcode_regex() . '/s', $shortcode, $matches );
	$atts = shortcode_parse_atts( $matches[3] );
	if ( ! empty( $matches[5] ) ) {
		$url = $matches[5];
	} elseif ( ! empty( $atts['src'] ) ) {
		$url = $atts['src'];
	} else {
		$url = '';
	}
	$parsed = false;
	setup_postdata( $post );
	$wp_embed->return_false_on_fail = true;
	if ( is_ssl() && 0 === strpos( $url, 'http://' ) ) {
		// Admin is ssl and the user pasted non-ssl URL.
		// Check if the provider supports ssl embeds and use that for the preview.
		$ssl_shortcode = preg_replace( '%^(\\[embed[^\\]]*\\])http://%i', '$1https://', $shortcode );
		$parsed = $wp_embed->run_shortcode( $ssl_shortcode );
		if ( ! $parsed ) {
			$no_ssl_support = true;
		}
	}
	if ( $url && ! $parsed ) {
		$parsed = $wp_embed->run_shortcode( $shortcode );
	}
	if ( ! $parsed ) {
		wp_send_json_error( array(
			'type' => 'not-embeddable',
			'message' => sprintf( esc_html__( '%s failed to embed.', 'goodlife' ), '<code>' . esc_html( $url ) . '</code>' ),
		) );
	}
	if ( has_shortcode( $parsed, 'audio' ) || has_shortcode( $parsed, 'video' ) ) {
		$styles = '';
		$mce_styles = wpview_media_sandbox_styles();
		foreach ( $mce_styles as $style ) {
			$styles .= sprintf( '<link rel="stylesheet" href="%s"/>', $style );
		}
		$html = do_shortcode( $parsed );
		global $wp_scripts;
		if ( ! empty( $wp_scripts ) ) {
			$wp_scripts->done = array();
		}
		ob_start();
		wp_print_scripts( 'wp-mediaelement' );
		$scripts = ob_get_clean();
		$parsed = $styles . $html . $scripts;
	}
	if ( ! empty( $no_ssl_support ) || ( is_ssl() && ( preg_match( '%<(iframe|script|embed) [^>]*src="http://%', $parsed ) ||
		preg_match( '%<link [^>]*href="http://%', $parsed ) ) ) ) {
		// Admin is ssl and the embed is not. Iframes, scripts, and other "active content" will be blocked.
		wp_send_json_error( array(
			'type' => 'not-ssl',
			'message' => esc_html__( 'This preview is unavailable in the editor.', 'goodlife' ),
		) );
	}
	wp_send_json_success( array(
		'body' => $parsed,
		'attr' => $wp_embed->last_attr
	) );
}

add_action("wp_ajax_nopriv_thb_posts", "thb_posts");
add_action("wp_ajax_thb_posts", "thb_posts");

function thb_posts() {
	$count = $_POST['count'];
	$style = $_POST['style'];
	$page = $_POST['page'];
	$columns = $_POST['columns'];
	$thb_excerpts = $_POST['excerpts'];
	$args = array(
		'post_type'=>'post', 
		'post_status' => 'publish', 
		'ignore_sticky_posts' => 1,
		'posts_per_page' => $count,
		'paged' => $page
	);
	switch($columns) {
		case 2:
			$col = 'small-6';
			break;
		case 3:
			$col = 'small-6 medium-4 large-4';
			break;
		case 4:
			$col = 'small-6 medium-6 large-3';
			break;
	}
	$query = new WP_Query( $args );
	if ($query->have_posts()) :  while ($query->have_posts()) : $query->the_post();
	?><?php if ($style == 'style1') { ?><div class="small-12 columns"><?php get_template_part( 'inc/poststyles/style2' ); ?></div><?php } else if ($style == 'style2') { ?><div class="<?php echo esc_attr($col); ?> columns"><?php set_query_var( 'thb_excerpts', $thb_excerpts ); get_template_part( 'inc/poststyles/style3' ); ?></div><?php } else if ($style == 'style3') { ?><div class="small-12 columns"><?php get_template_part( 'inc/poststyles/style4' ); ?></div><?php } ?><?php
	endwhile; else : get_template_part( 'inc/loop/notfound' ); endif; 
	wp_die();
}

add_action("wp_ajax_nopriv_thb_infinite_ajax", "thb_infinite_ajax");
add_action("wp_ajax_thb_infinite_ajax", "thb_infinite_ajax");

function thb_infinite_ajax() {
	global $post;
	$id = isset($_POST['post_id']) ? $_POST['post_id'] : false;
	
  $post = get_post( $id );
	$previous_post = get_previous_post();
	
	if ($id) {
		$args = array(
		    'p' => $previous_post->ID,
		    'no_found_rows' => true,
		    'posts_per_page' => 1,
		    'post_status' => 'publish'
		);
		$query = new WP_Query($args);
		ob_start();
		do_action("thb_vc_ajax");
		if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
			$id = get_the_ID();
			$format = get_post_format();
			set_query_var( 'thb_ajax', true );
			
			if ($format == 'video' ){
				$post_style = get_post_meta($id, 'video-post-detail-style', true) ? get_post_meta($id, 'video-post-detail-style', true) : 'style1';
				get_template_part( 'inc/post-detail-styles/'.$format.'-'.$post_style );
			} else if ($format == 'gallery' ){
				$post_style = get_post_meta($id, 'gallery-post-detail-style', true) ? get_post_meta($id, 'gallery-post-detail-style', true) : 'style1';
				get_template_part( 'inc/post-detail-styles/'.$format.'-'.$post_style );
			} else {
				$post_style = get_post_meta($id, 'standard-post-detail-style', true) ? get_post_meta($id, 'standard-post-detail-style', true) : 'style1';
				get_template_part( 'inc/post-detail-styles/'.$post_style );
			}
		endwhile; else : endif;
		$out = ob_get_contents();
		if (ob_get_contents()) ob_end_clean();
		echo $out;
	}
	wp_die();
}
?>