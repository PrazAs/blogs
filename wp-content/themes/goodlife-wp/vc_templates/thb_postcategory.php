<?php function thb_postcategory( $atts, $content = null ) {
  $atts = vc_map_get_attributes( 'thb_postcategory', $atts );
	extract( $atts );
	
	$ppp = $item_count;
	switch($style) {
		case 'style1':
			$ppp = 6;
			break;
		case 'style2':
			$ppp = 7;
			break;
		case 'style3':
			$ppp = 10;
			break;
		case 'style4':
			$ppp = 5;
			break;
		case 'style5':
			$ppp = 3;
			break;
		case 'style6':
			$ppp = max(3, intval($item_count));
			break;
		case 'style6-fashion':
			$ppp = max(3, intval($item_count));
			break;
		case 'style7':
			$ppp = max(9, intval($item_count));
			break;
	}
	$args = array(
		'cat' => $cat,
		'posts_per_page' => $ppp,
		'ignore_sticky_posts' => 1,
		'no_found_rows' => true
	);
	if ($offset) {
		$args = wp_parse_args( 
			array(
				'offset' => $offset,
			)
		, $args );
	}
	if ($excluded_tag_ids) {
		$excluded_tag_ids = explode(',',$excluded_tag_ids);
		
		$args = wp_parse_args( 
			array(
				'tag__not_in' => $excluded_tag_ids
			)
		, $args );
	}
	$posts = new WP_Query( $args );
 	$rand = rand(0,1000);
 	ob_start();
 	$counts = false;
 	$postmeta = false;
	if ( $posts->have_posts() ) { ?>
		<div class="category-element-holder <?php echo esc_attr($style); ?>">
		<?php if($title == "true") { ?>
			<?php if ($style == 'style4') { ?>
				<div class="category_title cat-<?php echo esc_attr($cat); ?> simple">
					<h4><?php echo get_cat_name( $cat ); ?></h4>
				</div>
			<?php } else if ($style == 'style6' || $style == 'style6-fashion') { ?>
				<div class="category_title cat-<?php echo esc_attr($cat); ?>">
					<h4><?php echo get_cat_name( $cat ); ?></h4>
				</div>
			<?php } else { ?>
				<div class="category_title cat-<?php echo esc_attr($cat); ?>">
					<div class="row">
						<div class="small-6 medium-4 columns">
							<h4><?php echo get_cat_name( $cat ); ?></h4>
						</div>
						<div class="small-6 medium-8 columns">
							<div class="subcategory_container small">
									<?php do_action( 'thb_Sibling_Categories', get_category($cat) ); ?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>	
			
		<?php } ?>
  		<?php $i = 0; while ( $posts->have_posts() ) : $posts->the_post(); ?>
  			<?php if ($style == 'style1') { ?>
	  			<?php 
	  				if (in_array($i, array(0))) { 
	  					echo '<div class="row"><div class="small-12 large-6 columns">'; 
	  						get_template_part( 'inc/poststyles/style3-large-image' );
	  					echo '</div>'; 
	  				} 
	  			?>
	  			<?php 
	  				if (in_array($i, array(1))) { 
	  						echo '<div class="small-12 large-6 columns"><ul class="no-list">'; 
	  				} 
	  			?>
	  			<?php 
	  				if (in_array($i, array(1,2,3,4,5))) {
	  						set_query_var( 'counts', $counts);
	  						set_query_var( 'postmeta', $postmeta );
	  						get_template_part( 'inc/poststyles/thumbnail-listing' );
	  				} 
	  			?>
	  			<?php 
	  				if (in_array($i, array(5)) || ($i > 0 && $i + 1 == $posts->post_count)) { 
	  						echo '</ul></div>'; 
	  				} 
	  			?>
	  			<?php 
	  				if ($i + 1 == $posts->post_count) {
	  					echo '</div>';
	  				} 
	  			?>
  			<?php } else if ($style == 'style2') { ?>
  				<?php 
  					if (in_array($i, array(0))) { 
  						echo '<div class="row grid"><div class="small-12 columns">'; 
  							set_query_var( 'extra_class', "bottom-gradient large-padding" );
  							set_query_var( 'title_size', 'h3');
  							set_query_var( 'image_size', 'grid-8x2' );
  							set_query_var( 'counts', false );
  							get_template_part( 'inc/poststyles/grid' );
  						echo '</div>'; 
  					} 
  				?>
	  				<?php 
	  					if (in_array($i, array(1,2))) { 
	  						echo '<div class="small-12 large-6 columns">'; 
	  							set_query_var( 'extra_class', "bottom-gradient large-padding" );
	  							set_query_var( 'title_size', 'h4');
	  							set_query_var( 'image_size', 'post-style1' );
	  							set_query_var( 'counts', false );
	  							get_template_part( 'inc/poststyles/grid' );
	  						echo '</div>'; 
	  					} 
	  				?>
  				<?php 
  					if (in_array($i, array(2))) { 
  							echo '<aside class="gap" style="height: 28px;"></aside>'; 
  					} 
  				?>
  				<?php 
  					if (($i + 1 == $posts->post_count && $i < 4) || in_array($i, array(2))) { 
  							echo '</div>'; 
  					} 
  				?>
  				<?php 
  					if (in_array($i, array(3))) { 
  							echo '<div class="row endcolumn">'; 
  					} 
  				?>
  					<?php 
  						if (in_array($i, array(3,4,5,6))) { 
  							echo '<div class="small-12 medium-6 large-3 columns">'; 
  								get_template_part( 'inc/poststyles/style1-meta' );
  							echo '</div>'; 
  						} 
  					?>
  				<?php 
  					if ($i + 1 == $posts->post_count && $i > 2) {
  						echo '</div>';
  					} 
  				?>
  			<?php } else if ($style == 'style3') { ?>
					<?php 
						if (in_array($i, array(0))) { 
								echo '<div class="row endcolumn"><div class="small-12 large-9 columns">'; 
								set_query_var( 'extra_class', "top-gradient bold-title large-padding top-title max-height" );
								set_query_var( 'title_size', 'h3');
								set_query_var( 'image_size', 'latest-short' );
								set_query_var( 'counts', $counts);
								get_template_part( 'inc/poststyles/grid' );
						} 
					?>
					<?php 
						if (in_array($i, array(1))) { 
								echo '<div class="row">'; 
						} 
					?>
					<?php 
						if (in_array($i, array(1,2,3))) { 
							echo '<div class="small-12 medium-4 columns">'; 
								get_template_part( 'inc/poststyles/style1-meta' );
							echo '</div>'; 
						} 
					?>
					<?php 
						if (in_array($i, array(3))) { 
								echo '</div></div>'; 
						} 
					?>
					<?php 
						if (in_array($i, array(4))) { 
								echo '<div class="small-12 large-3 columns"><ul class="point-list">'; 
						} 
					?>
					<?php 
						if (in_array($i, array(4,5,6,7,8,9))) { 
								get_template_part( 'inc/poststyles/listing' );
						} 
					?>
					<?php 
						if (in_array($i, array(9)) || $i + 1 == $posts->post_count) { 
								echo '</ul></div>'; 
						} 
					?>
					<?php 
						if ($i + 1 == $posts->post_count) {
							echo '</div>';
						} 
					?>
  			<?php } else if ($style == 'style4') { ?>
	  				<?php 
	  					if (in_array($i, array(0))) { 
	  						echo '<div class="row endcolumn"><div class="small-12 large-3 columns">'; 
	  					}
	  				?>
	  				<?php 
	  					if (in_array($i, array(0,1))) { 
	  							set_query_var( 'extra_class', "text-center smaller-padding" );
	  							set_query_var( 'title_size', 'h5');
	  							set_query_var( 'image_size', 'grid-2x2' );
	  							set_query_var( 'excerpt', false );
	  							get_template_part( 'inc/poststyles/fashion' );
	  					} 
	  				?>
	  				<?php 
	  					if (in_array($i, array(1))) { 
	  							echo '</div>'; 
	  					} 
	  				?>
						<?php 
							if (in_array($i, array(2))) { 
									echo '<div class="small-12 large-6 columns">'; 
									set_query_var( 'extra_class', "offset-title bottom-title text-center" );
									set_query_var( 'title_size', 'h4');
									set_query_var( 'image_size', 'grid-8x8' );
									set_query_var( 'excerpt', true );
									get_template_part( 'inc/poststyles/fashion' );
									echo '</div>'; 
							} 
						?>
						<?php 
							if (in_array($i, array(3))) { 
									echo '<div class="small-12 large-3 columns">'; 
							} 
						?>
						<?php 
							if (in_array($i, array(3,4))) { 
									set_query_var( 'extra_class', "text-center smaller-padding" );
									set_query_var( 'title_size', 'h5');
									set_query_var( 'image_size', 'grid-2x2' );
									set_query_var( 'excerpt', false );
									get_template_part( 'inc/poststyles/fashion' );
							} 
						?>
						<?php 
							if (in_array($i, array(4))) { 
									echo '</div>'; 
							} 
						?>
						<?php 
							if ($i + 1 == $posts->post_count) {
								echo '</div>';
							} 
						?>
				<?php } else if ($style == 'style5') { ?>
					<?php 
						if (in_array($i, array(0))) { 
								set_query_var( 'extra_class', "large-padding center-title max-height" );
								set_query_var( 'title_size', 'h3');
								set_query_var( 'counts', $counts);
								set_query_var( 'image_size', 'latest-short' );
								get_template_part( 'inc/poststyles/grid' );
						} 
					?>
					<?php 
						if (in_array($i, array(1))) { 
								echo '<aside class="gap" style="height: 30px;"></aside>'; 
								echo '<div class="row">'; 
						} 
					?>
					<?php 
						if (in_array($i, array(1,2))) { 
								echo '<div class="small-12 medium-6 columns">'; 
								get_template_part( 'inc/poststyles/style3' );
								echo '</div>';
						} 
					?>
					<?php 
						if ($i + 1 == $posts->post_count) {
							echo '</div>';
						} 
					?>
  			<?php } else if ($style == 'style6') { ?>
  				<?php 
  					if (in_array($i, array(0))) { 
  							get_template_part( 'inc/poststyles/style3' );
  					} 
  				?>
  				<?php 
  					if (in_array($i, array(1))) { 
  							echo '<ul class="no-list">'; 
  					} 
  				?>
  					<?php 
  						if (!in_array($i, array(0))) { 
  								set_query_var( 'counts', $counts);
  								set_query_var( 'postmeta', $postmeta );
  								get_template_part( 'inc/poststyles/thumbnail-listing' );
  						} 
  					?>
  				<?php 
  					if ($i + 1 == $posts->post_count) {
  						echo '</ul>';
  					} 
  				?>
  			<?php } else if ($style == 'style6-fashion') { ?>
  				<?php 
  					if (in_array($i, array(0))) { 
  							get_template_part( 'inc/poststyles/style3' );
  					} 
  				?>
  				<?php 
  					if (in_array($i, array(1))) { 
  							echo '<ul class="no-list">'; 
  					} 
  				?>
  					<?php 
  						if (!in_array($i, array(0))) { 
  								set_query_var( 'counts', $counts);
  								set_query_var( 'postmeta', $postmeta );
  								get_template_part( 'inc/poststyles/thumbnail-listing' );
  						} 
  					?>
  				<?php 
  					if ($i + 1 == $posts->post_count) {
  						echo '</ul>';
  					} 
  				?>
  			<?php } else if ($style == 'style7') { ?>
  				<?php 
  					if (in_array($i, array(0))) { 
  							
  							set_query_var( 'extra_class', "large-padding top-title max-height" );
  							set_query_var( 'title_size', 'h3');
  							set_query_var( 'image_size', 'grid-8x2' );
  							set_query_var( 'counts', $counts);
  							get_template_part( 'inc/poststyles/grid' );
  					} 
  				?>
  				<?php 
  					if (in_array($i, array(1))) { 
  							echo '<ul class="no-list double-side">'; 
  					} 
  				?>
  					<?php 
  						if (!in_array($i, array(0))) { 
  								set_query_var( 'counts', $counts);
  								set_query_var( 'postmeta', $postmeta );
  								get_template_part( 'inc/poststyles/thumbnail-listing' );
  						} 
  					?>
  				<?php 
  					if ($i + 1 == $posts->post_count) {
  						echo '</ul>';
  					} 
  				?>
  			<?php } else if ($style == 'style8') { ?>
 					<?php 
 						
 						if (in_array($i, array(0))) { 
 							echo '<div class="row grid"><div class="small-12 columns">'; 
 								set_query_var( 'extra_class', "center-title large-padding" );
 								set_query_var( 'title_size', 'h3');
 								set_query_var( 'image_size', 'grid-8x2' );
 								set_query_var( 'counts', false );
 								get_template_part( 'inc/poststyles/grid' );
 							echo '</div></div>';
 						} 
 						
 					?>
 					<?php 
 						if (in_array($i, array(1))) { 
 								echo '<aside class="gap" style="height: 28px;"></aside>'; 
 								echo '<div class="row endcolumn">'; 
 						} 
 					?>
 						<?php 
 							if (in_array($i, array(1,2,3,4))) { 
 								echo '<div class="small-12 medium-6 large-3 columns">'; 
 									get_template_part( 'inc/poststyles/style1-meta' );
 								echo '</div>'; 
 							} 
 						?>
 					<?php 
 						if ($i + 1 == $posts->post_count && $i > 0) {
 							echo '</div>';
 						} 
 					?>
  			<?php } ?>
  		<?php $i++; endwhile; // end of the loop. ?>
  		</div>
	<?php }

   $out = ob_get_contents();
   if (ob_get_contents()) ob_end_clean();
   
   wp_reset_postdata();
     
  return $out;
}
add_shortcode('thb_postcategory', 'thb_postcategory');
