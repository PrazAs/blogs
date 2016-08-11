<?php function thb_postgrid_carousel( $atts, $content = null ) {
	
	$atts = vc_map_get_attributes( 'thb_postgrid_carousel', $atts );
	extract( $atts );
	
	$args = array(
		'nopaging' => 0, 
		'post_type'=>'post', 
		'post_status' => 'publish', 
		'ignore_sticky_posts' => 1,
		'no_found_rows' => true,
		'suppress_filters' => 0
	);
	
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
 	$length = $posts->found_posts;
 	switch($style) {
 		case 'style1':
 			$counter = range(0, 100, 3);
 			break;
 		case 'style2':
 		case 'style3':
 			$counter = range(0, 100, 5);
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
 	switch($overlay_style) {
		case 'technology':
			$gradient1 = ' color1-gradient';
			$gradient2 = ' color2-gradient';
			$gradient3 = ' color3-gradient';
			$gradient4 = ' color4-gradient';
			$gradient5 = ' color5-gradient';
			break;
		default:
			$gradient1 = $gradient2 = $gradient3 = $gradient4 = $gradient5 ='';
	}
 	ob_start();
 	$counts = false;
	if ( $posts->have_posts() ) { ?>
			<div class="slick grid <?php if ($pagination == 'true') { echo 'bot-nav'; } ?> <?php echo esc_attr($style . ' ' .$overlay_style. '-style'); ?>" data-columns="1" data-navigation="<?php echo esc_attr($navigation); ?>" data-pagination="<?php echo esc_attr($pagination); ?>" data-autoplay="false">
				<?php $i = 0; while ( $posts->have_posts() ) : $posts->the_post(); ?>
						<?php if ('style1' == $style) { ?>
							<?php 
								if (in_array($i, $counter)) { 
									echo '<div class="row">'; 
										echo '<div class="small-12 medium-12 large-8 columns">';
											set_query_var( 'extra_class', $gradient. $gradient1. " large-padding max-height " . $title_position );
											set_query_var( 'title_size', 'h1' );
											set_query_var( 'image_size', 'grid-8x8' );
											set_query_var( 'image_class', 'no-lazy-load' );
											get_template_part( 'inc/poststyles/grid' );
										echo '</div><div class="small-12 medium-12 large-4 columns"><div class="row">'; 
								} else {
										echo '<div class="small-12 medium-6 large-12 columns">';
											set_query_var( 'extra_class', $gradient. (in_array($i, range(0, 100, 2)) ? $gradient2 : $gradient3). " large-padding max-height " . $title_position );
											set_query_var( 'title_size', 'h4' );
											set_query_var( 'image_size', 'grid-2x2' );
											set_query_var( 'image_class', 'no-lazy-load' );
											get_template_part( 'inc/poststyles/grid' );
										echo '</div>';
								} ?>
							<?php 
								if (in_array($i + 1, $counter)) { 
									echo '</div></div></div>'; 
								} 
							?>
						<?php } else if ('style2' == $style) { ?>
							<?php 
								if (in_array($i, $counter)) { 
									echo '<div class="row"><div class="small-12 columns"><div class="row">'; 
								}
							?>
							<?php
								if (in_array($i, array(0,1,5,6,10,11,15,16,20,21))) { 
									echo '<div class="small-12 large-6 columns">';
										set_query_var( 'extra_class', $gradient. (in_array($i, range(0, 100, 2)) ? $gradient1 : $gradient2). " large-padding max-height " . $title_position );
										set_query_var( 'title_size', 'h3' );
										set_query_var( 'image_size', 'grid-6x6' );
										set_query_var( 'image_class', 'no-lazy-load' );
										get_template_part( 'inc/poststyles/grid' );
									echo '</div>';
								}
							?>
							<?php 
								if (in_array($i, array(1,6,11,16,21))) { 
									echo '</div>'; 
								}
							?>
							<?php 
								if (in_array($i, array(2,7,12,17,22))) { 
									echo '<div class="row">'; 
								}
							?>
							<?php
								if (in_array($i, array(2,3,4,7,8,9,12,13,14,17,18,19,22,23,24))) { 
									switch($i) {
										case 2:
										case 7:
										case 12:
										case 17:
										case 22:
											$gradient_change = $gradient3;
											break;
										case 3:
										case 8:
										case 13:
										case 18:
										case 23:
											$gradient_change = $gradient4;
											break;
										case 4:
										case 9:
										case 14:
										case 19:
										case 24:
											$gradient_change = $gradient5;
											break;
										default:
											$gradient_change = '';
									}
									echo '<div class="small-12 medium-12 large-4 columns">';
										set_query_var( 'extra_class', $gradient. $gradient_change. " large-padding max-height " . $title_position );
										set_query_var( 'title_size', 'h4' );
										set_query_var( 'image_size', 'grid-6x6' );
										set_query_var( 'image_class', 'no-lazy-load' );
										get_template_part( 'inc/poststyles/grid' );
									echo '</div>';
								}
							?>
							<?php 
								if (in_array($i, array(4,9,14,19,24)) || $i + 1 == $posts->post_count) { 
									echo '</div>'; 
								} 
							?>
							<?php 
								if ($i + 1 == $posts->post_count || in_array($i + 1, $counter)) { 
									echo '</div></div>'; 
								} 
							?>
						<?php } else if ('style3' == $style) { ?>
							<?php 
								if (in_array($i, $counter)) { 
									echo '<div class="row"><div class="small-12 columns"><div class="row">'; 
								}
							?>
							<?php 
								if (in_array($i, $counter)) { 
									echo '<div class="small-12 medium-12 large-8 columns">';
										set_query_var( 'extra_class', $gradient. $gradient1." bold-title large-padding " . $title_position );
										set_query_var( 'title_size', 'h1' );
										set_query_var( 'image_size', 'grid-8x2' );
										set_query_var( 'image_class', 'no-lazy-load' );
										get_template_part( 'inc/poststyles/grid' );
									echo '</div>';
								} ?>
								
							<?php 
								if (in_array($i, array(1,6,11,16,21))) { 
									echo '<div class="small-12 medium-12 large-4 columns">';
										set_query_var( 'extra_class', $gradient. $gradient2. " bold-title large-padding max-height " . $title_position );
										set_query_var( 'title_size', 'h3' );
										set_query_var( 'image_size', 'grid-2x2' );
										set_query_var( 'image_class', 'no-lazy-load' );
										get_template_part( 'inc/poststyles/grid' );
									echo '</div></div><div class="row">';
								}
							?>
							<?php 
								if (in_array($i, array(2,3,4,7,8,9,12,13,14,17,18,19,22,23,24))) { 
									switch($i) {
										case 2:
										case 7:
										case 12:
										case 17:
										case 22:
											$gradient_change = $gradient3;
											break;
										case 3:
										case 8:
										case 13:
										case 18:
										case 23:
											$gradient_change = $gradient4;
											break;
										case 4:
										case 9:
										case 14:
										case 19:
										case 24:
											$gradient_change = $gradient5;
											break;
										default:
									}
									echo '<div class="small-12 medium-12 large-4 columns">';
										set_query_var( 'extra_class', $gradient. $gradient_change. " bold-title large-padding max-height " . $title_position );
										set_query_var( 'title_size', 'h3' );
										set_query_var( 'image_size', 'grid-2x2' );
										set_query_var( 'image_class', 'no-lazy-load' );
										get_template_part( 'inc/poststyles/grid' );
									echo '</div>';
								}
							?>
							<?php 
								if (in_array($i + 1, $counter)) { 
									echo '</div></div></div>'; 
								} 
							?>
						<?php } ?>
				<?php $i++; endwhile; // end of the loop. ?>
			</div>
   <?php
	 }
   $out = ob_get_contents();
   if (ob_get_contents()) ob_end_clean();
   
   wp_reset_postdata();
     
  return $out;
}
add_shortcode('thb_postgrid_carousel', 'thb_postgrid_carousel');