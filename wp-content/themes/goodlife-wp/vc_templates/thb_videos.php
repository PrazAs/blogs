<?php function thb_videos( $atts, $content = null ) {
  $atts = vc_map_get_attributes( 'thb_videos', $atts );
  extract( $atts );

	$args = array(
		'post_type'=>'post', 
		'post_status' => 'publish', 
		'ignore_sticky_posts' => 1,
		'tax_query' => array(
		    array(                
		        'taxonomy' => 'post_format',
		        'field' => 'slug',
		        'terms' => array(
		            'post-format-video'
		        ),
		        'operator' => 'IN'
		    )
		)
	);

	if ($offset) {
		$args = wp_parse_args( 
			array(
				'offset' => $offset,
			)
		, $args );
	}
	if ($source == 'most-recent') {
		$args = wp_parse_args( 
			array(
				'posts_per_page' => $item_count
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
	$video_posts = new WP_Query( $args );
	global $wp_embed;
	       
 	ob_start();
	if ( $video_posts->have_posts() ) { ?>
		<div class="video_playlist <?php echo esc_attr($color); ?>-color <?php echo esc_attr($style); ?>">
			<div class="row" <?php if ($style == 'style1') { ?>data-equal=">.columns" data-row-detection="true"<?php } ?>>
				
					<?php $i = 1; while ( $video_posts->have_posts() ) : $video_posts->the_post(); ?>
						<?php if ($style == 'style1') { ?>
							<?php if ($i == 1) { ?>
								<div class="small-12 large-8 columns video-side">
										<?php
											$embed = get_post_meta(get_the_ID() , 'post_video', TRUE);
											echo $wp_embed->run_shortcode('[embed]'.$embed.'[/embed]'); 
										?>
								</div>
								<div class="small-12 large-4 columns">
									<div class="vertical-video slick" data-pagination="false" data-navigation="true" data-vertical="true" data-columns="4" data-autoplay="false">
							<?php } ?>
								<?php 
									$active = $i == 1 ? 'video-active' : false;
									set_query_var( 'active', $active);
									set_query_var( 'color', $color);
									set_query_var( 'image_class', 'no-lazy-load' );
									get_template_part( 'inc/poststyles/playlist' );
								?>
							<?php if ($i == $video_posts->post_count) { ?>
									</div>
								</div>
							<?php } ?>
						<?php } else if ($style == 'style2') { ?>
							<?php if ($i == 1) { ?>
								<div class="small-12 columns video-side">
										<?php
											$embed = get_post_meta(get_the_ID() , 'post_video', TRUE);
											echo $wp_embed->run_shortcode('[embed]'.$embed.'[/embed]'); 
										?>
								</div>
								<aside class="gap" style="height: 30px;"></aside>
								<div class="small-12 columns">
									<div class="slick row <?php echo esc_attr($color); ?>" data-pagination="false" data-navigation="true" data-columns="<?php echo esc_attr($columns); ?>" data-autoplay="false" data-center="<?php echo ($item_count > $columns ? 'true' : 'false'); ?>" data-disablepadding="true">
										<?php } ?>
											<div class="columns">
											<?php 
												$active = $i == 1 ? 'video-active' : false;
												set_query_var( 'active', $active);
												set_query_var( 'color', $color);
												set_query_var( 'image_class', 'no-lazy-load' );
												get_template_part( 'inc/poststyles/playlist-vertical' );
											?>
											</div>
										<?php if ($i == $video_posts->post_count) { ?>
									</div>
								</div>
							<?php } ?>
						<?php } ?>
					<?php $i++; endwhile; // end of the loop. ?>
			</div>
		</div>
	<?php }

   $out = ob_get_contents();
   if (ob_get_contents()) ob_end_clean();
   wp_reset_query();
   wp_reset_postdata();
     
  return $out;
}
add_shortcode('thb_videos', 'thb_videos');
