<?php
	$vars = $wp_query->query_vars;
	$title_position = array_key_exists('thb_category_grids_title_style', $vars) ? $vars['thb_category_grids_title_style'] : 'top-title';
	$overlay_style = array_key_exists('thb_category_grids_overlay_style', $vars) ? $vars['thb_category_grids_overlay_style'] : 'standard';
	$counter = range(0, 100, 5);

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
	
	$cat = get_queried_object();
	$cat_id = $cat->term_id;
	$args = array(
		'posts_per_page' => 5,
		'cat' => $cat_id
	);
	$cat_posts = new WP_Query( $args );
	$length = $cat_posts->found_posts;
?>
<!-- Start Category Grid -->
<div class="small-12 columns category-grid">
<div class="slick grid <?php echo esc_attr($style . ' ' .$overlay_style. '-style'); ?>" data-columns="1" data-navigation="false" data-pagination="false" data-autoplay="false">
<?php $i = 0; while ( $cat_posts->have_posts() ) : $cat_posts->the_post(); ?>
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
	if (in_array($i, array(4,9,14,19,24)) || $i + 1 == $cat_posts->post_count) { 
		echo '</div>'; 
	} 
?>
<?php 
	if ($i + 1 == $cat_posts->post_count || in_array($i + 1, $counter)) { 
		echo '</div></div>'; 
	} 
?>
<?php $i++; endwhile; // end of the loop. ?>
</div>
</div>
<?php wp_reset_query(); ?>
<!-- End Category Grid -->