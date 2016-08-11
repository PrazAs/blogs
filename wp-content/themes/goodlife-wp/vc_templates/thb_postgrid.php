<?php function thb_postgrid( $atts, $content = null ) {
  $atts = vc_map_get_attributes( 'thb_postgrid', $atts );
  extract( $atts );
    
  $featured_index = empty($featured_index) ? array() : explode(',',$featured_index);
	$args = array(
		'post_type'=>'post', 
		'post_status' => 'publish', 
		'ignore_sticky_posts' => 1
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
 	$rand = rand(0,1000);
 	ob_start();
 	
	if ( have_posts() ) { ?>

			<div class="row posts endcolumn <?php if ($source == 'most-recent' && $pagination == 'style1') { echo 'ajaxify-pagination'; } ?>"<?php if ($source == 'most-recent' && $pagination == 'style2') { echo 'data-loadmore="#loadmore-'. esc_attr($rand).'"'; } ?><?php if ($style == 'style2') { echo ' data-equal=">.columns:not(.small-12)"'; } ?>>
				<?php $i = 1; while ( have_posts() ) : the_post(); ?>
				
					<?php if ($style == 'style1') { ?>
						<div class="small-12 columns">
							<?php 
								if (in_array($i, $featured_index )) {
									get_template_part( 'inc/poststyles/style1-featured' );
								} else {
									get_template_part( 'inc/poststyles/style2' );
								}
							?>
						</div>
					<?php } else if ($style == 'style2') { ?>
						<div class="<?php echo esc_attr($col); ?> columns">
							<?php 
								set_query_var( 'thb_excerpts', $thb_excerpts );
								get_template_part( 'inc/poststyles/style3' ); 
								
							?>
						</div>
					<?php } else if ($style == 'style3') { ?>
						<div class="small-12 columns">
						<?php 
							if (in_array($i, $featured_index )) {
								get_template_part( 'inc/poststyles/style1-featured' );
							} else {
								get_template_part( 'inc/poststyles/style4' );
							}
						?>
						</div>
					<?php } ?>
				<?php $i++; endwhile; // end of the loop. ?>
				<?php 
					if ($source == 'most-recent' && !$offset) {
						if ($pagination == 'style1') { 
							echo '<div class="small-12 columns">';
							the_posts_pagination(array(
								'prev_text' 	=> '<span>'.esc_html__( "&larr;", 'goodlife' ).'</span>',
								'next_text' 	=> '<span>'.esc_html__( "&rarr;", 'goodlife' ).'</span>',
								'mid_size'		=> 2
							));
							echo '</div>';
						}
					}
				?> 
			</div>
			<?php 
				if ($source == 'most-recent' && !$offset) {
					if ($pagination == 'style2') {
						echo '<aside class="text-center"><a href="#" class="button" id="loadmore-'.$rand.'" data-columns="'.$columns.'" data-count="'.$item_count.'" data-page="'.($paged + 1).'" data-style="'.esc_attr($style).'" data-nomore="'.esc_html__('NO POSTS FOUND', 'goodlife').'" data-loading="'.esc_html__('LOADING', 'goodlife').'" data-excerpts="'.esc_attr($thb_excerpts).'">'.esc_html__('LOAD MORE NEWS', 'goodlife').'</a></aside>';
					}
				}
			?> 
	<?php }

   $out = ob_get_contents();
   if (ob_get_contents()) ob_end_clean();
   wp_reset_query();
   wp_reset_postdata();
     
  return $out;
}
add_shortcode('thb_postgrid', 'thb_postgrid');
