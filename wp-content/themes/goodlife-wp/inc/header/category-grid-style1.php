<?php
	$vars = $wp_query->query_vars;
	$title_position = array_key_exists('thb_category_grids_title_style', $vars) ? $vars['thb_category_grids_title_style'] : 'top-title';
	$overlay_style = array_key_exists('thb_category_grids_overlay_style', $vars) ? $vars['thb_category_grids_overlay_style'] : 'standard';
	$counter = range(0, 100, 3);

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
		'posts_per_page' => 3,
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
<?php $i++; endwhile; // end of the loop. ?>
</div>
</div>
<?php wp_reset_query(); ?>
<!-- End Category Grid -->