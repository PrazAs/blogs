<?php 
	$cat = get_queried_object();
	$cat_id = $cat->term_id;
	$cat_style = get_term_meta( $cat_id, 'thb_listing_style', true );
	 
	$category_title_style = ot_get_option('category_title_style', 'style1');
	$category_list_style = $cat_style ? $cat_style : ot_get_option('category_list_style', 'style2'); 
	$category_grid_style = ot_get_option('category_grids_'. $cat_id);
	$category_grids_title_style = ot_get_option('category_grids_title_'. $cat_id);
	$category_grids_overlay_style = ot_get_option('category_grids_overlay_'. $cat_id);
	
	
?>
<?php get_header(); ?>

<div class="row top-padding" data-equal=">.equal" data-row-detection="true">
	<header class="small-12 columns">
		<?php get_template_part( 'inc/header/category-title-'.$category_title_style ); ?>
	</header>
	<?php if ($category_grid_style !=='') { 
		set_query_var( 'thb_category_grids_title_style', $category_grids_title_style );
		set_query_var( 'thb_category_grids_overlay_style', $category_grids_overlay_style );
		get_template_part( 'inc/header/category-grid-'.$category_grid_style ); 
	} ?>
	<section class="small-12 medium-8 columns equal">
		
	  <?php $i = 0; if (have_posts()) :  while (have_posts()) : the_post(); ?>
			<?php 
				if ($category_list_style == 'style2') {
				get_template_part( 'inc/poststyles/'.$category_list_style ); 
				} else if ($category_list_style == 'style3') {
					if ($i == 0) { echo '<div class="row posts">'; }
					echo '<div class="small-12 medium-6 columns">';
					get_template_part( 'inc/poststyles/'.$category_list_style ); 
					echo '</div>';
					if ($i + 1 == $wp_query->post_count) { echo '</div>'; }
				}
			?>
	  <?php $i++; endwhile; ?>
	  <?php the_posts_pagination(array(
	  	'prev_text' 	=> '<span>'.esc_html__( "&larr;", 'goodlife' ).'</span>',
	  	'next_text' 	=> '<span>'.esc_html__( "&rarr;", 'goodlife' ).'</span>',
	  	'mid_size'		=> 2
	  )); ?>
	  <?php else : ?>
	    <?php get_template_part( 'inc/loop/notfound' ); ?>
	  <?php endif; ?>
	</section>
	<?php get_sidebar('category'); ?>
</div>
<?php get_footer(); ?>