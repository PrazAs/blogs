<?php function thb_postcarousel( $atts, $content = null ) {
  $atts = vc_map_get_attributes( 'thb_postcarousel', $atts );
  extract( $atts );
	
	ob_start();
	switch($title_position) {
		case 'top-title':
			$gradient = 'top-gradient';
			break;
		case 'bottom-title':
			$gradient = 'bottom-gradient';
			break;
		default:
			$gradient = '';
	}
	switch($columns) {
		case '5':
			$title_size = 'h5';
			break;
		case '4':
			$title_size = 'h5';
			break;
		case '3':
			$title_size= 'h4';
			break;
	}
	$pagi = ($pagination == 'true' ? 'true' : 'false');
	$nav = ($navigation == 'true' ? 'true' : 'false');
	
	$args = array(
		'nopaging' => 0, 
		'post_type'=>'post', 
		'post_status' => 'publish', 
		'ignore_sticky_posts' => 1,
		'no_found_rows' => true,
		'suppress_filters' => 0
	);
	if ($offset) {
		$args = wp_parse_args( 
			array(
				'offset' => $offset,
			)
		, $args );
	}
	if ($source == 'most-recent') {
		$excluded_tag_ids = explode(',',$excluded_tag_ids);
		$excluded_cat_ids = explode(',',$excluded_cat_ids);
		
		$args = wp_parse_args( 
			array(
				'posts_per_page' => $item_count,
				'tag__not_in' => $excluded_tag_ids,
				'category__not_in' => $excluded_cat_ids
			)
		, $args );
	} else if ($source == 'by-category') {
	 	if (!empty($cat)) {
	 		$cats = explode(',',$cat);
	 		$args = wp_parse_args( 
	 			array(
	 				'posts_per_page' => $item_count,
	 				'category__in' => $cats
	 			)
	 		, $args );	
	 	}
	} else if ($source == 'by-id') {
		$post_id_array = explode(',', $post_ids);
		$args = wp_parse_args( 
			array(
				'post__in' => $post_id_array,
				'posts_per_page' => 99,
				'orderby' => 'post__in'
			)
		, $args );	
	} else if ($source == 'by-tag') {
		$post_tag_array = explode(',', $tag_slugs);
		$args = wp_parse_args( 
			array(
				'posts_per_page' => $item_count,
				'tag_slug__in' => $post_tag_array
			)
		, $args );	
	} else if ($source == 'by-share') {
		$args = wp_parse_args( 
			array(
				'posts_per_page' => $item_count,
				'meta_key' => 'thb_pssc_counts',  
				'orderby' => 'meta_value_num'
			)
		, $args );	
	} else if ($source == 'by-author') {
		$post_author_array = explode(',', $author_ids);
		
		$args = wp_parse_args( 
			array(
				'posts_per_page' => $item_count,
				'author__in' => $post_author_array
			)
		, $args );	
	} else if ($source == 'top-reviews') {

		$args = wp_parse_args( 
			array(
				'posts_per_page' => $item_count,
				'meta_key' => 'post_ratings_average',
				'orderby' => 'meta_value_num'
			)
		, $args );	
	} else if ($source == 'latest-reviews') {
	
		$args = wp_parse_args( 
			array(
				'posts_per_page' => $item_count,
				'meta_key' => 'post_ratings_average'
			)
		, $args );	
	}
	$posts = new WP_Query( $args );
	$counts = 0;
	if ( $posts->have_posts() ) { ?>
		<div class="slick row<?php if ($margin !== 'true') { echo ' grid'; } ?> <?php echo esc_attr($color); ?>" data-columns="<?php echo esc_attr($columns); ?>" data-pagination="<?php echo esc_attr($pagi); ?>" data-navigation="<?php echo esc_attr($nav); ?>">
			<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
				<?php 
					if ($source == 'by-share') { 
						$counts++; 
						set_query_var( 'counts', $counts ); 
					} else {
						set_query_var( 'counts', false ); 
					}
				
				?>
				<div class="columns">
				<?php
					set_query_var( 'extra_class', $gradient. " large-padding " . $title_position );
					set_query_var( 'title_size', $title_size );
					set_query_var( 'image_size', 'gallery-vertical' );
					set_query_var( 'image_class', 'no-lazy-load' );
					get_template_part( 'inc/poststyles/grid' );
				?>
				</div>
			<?php endwhile; ?>
		</div>
	<?php }
 $out = ob_get_contents();
 if (ob_get_contents()) ob_end_clean();
return $out;
}
add_shortcode('thb_postcarousel', 'thb_postcarousel');
