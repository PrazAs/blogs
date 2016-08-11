<?php function thb_posttrendingbar( $atts, $content = null ) {
  $atts = vc_map_get_attributes( 'thb_posttrendingbar', $atts );
  extract( $atts );
    
	$args = array(
		'post_type'=>'post', 
		'post_status' => 'publish', 
		'ignore_sticky_posts' => 1
	);

	if ($offset) {
		$args = wp_parse_args( 
			array(
				'offset' => $offset,
			)
		, $args );
	}
	if ($source == 'most-recent') {
		$paged = is_front_page() ? get_query_var( 'page', 1 ) : get_query_var( 'paged', 1 );

		$args = wp_parse_args( 
			array(
				'posts_per_page' => $item_count,
				'paged' => $paged
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
	$posts = query_posts( $args );
 	ob_start();
 	
	if ( have_posts() ) { ?>
		<div class="trending-bar">
			<aside><?php _e('TRENDING NEWS', 'goodlife'); ?></aside>
			<div class="slick trending" data-columns="1" data-navigation="true" data-pagination="false" data-autoplay="true" data-fade="true">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'inc/poststyles/trending' ); ?>
			<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	<?php }

   $out = ob_get_contents();
   if (ob_get_contents()) ob_end_clean();
   wp_reset_query();
   wp_reset_postdata();
     
  return $out;
}
add_shortcode('thb_posttrendingbar', 'thb_posttrendingbar');
