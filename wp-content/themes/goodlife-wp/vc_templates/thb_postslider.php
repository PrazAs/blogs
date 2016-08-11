<?php function thb_postslider( $atts, $content = null ) {
  $atts = vc_map_get_attributes( 'thb_postslider', $atts );
  extract( $atts );
  
 	ob_start();
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
 	}
 	$posts = new WP_Query( $args );

 	switch($style) {
		case 'style1':
			$class = 'fashion-slider';
			break;
		case 'style2':
			$class = 'grid';
			break;
	}
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
 	if ( $posts->have_posts() ) { ?>
	<div class="slick <?php echo esc_attr($class); ?> post-slider" data-columns="1" data-pagination="<?php echo esc_attr($pagi); ?>" data-navigation="<?php echo esc_attr($nav); ?>">
		<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
			<?php if ($style == 'style2') { ?>
				<?php 
					set_query_var( 'extra_class', $gradient. " large-padding no-margin " . $title_position );
					set_query_var( 'title_size', $title_size );
					set_query_var( 'image_size', 'gallery' );
					set_query_var( 'image_class', 'no-lazy-load' );
					get_template_part( 'inc/poststyles/grid' );
				?>
			<?php } else { ?>
				<?php 
					set_query_var( 'extra_class', "offset-title capital-title" );
					set_query_var( 'title_size', 'h1');
					set_query_var( 'image_size', 'gallery' );
					set_query_var( 'excerpt', false );
					set_query_var( 'image_class', 'no-lazy-load' );
					get_template_part( 'inc/poststyles/fashion' );
				?>
			<?php } ?>
		<?php endwhile; ?>
	</div>
	<?php }
	$out = ob_get_contents();
	if (ob_get_contents()) ob_end_clean();
	wp_reset_postdata();
  return $out;
}
add_shortcode('thb_postslider', 'thb_postslider');
