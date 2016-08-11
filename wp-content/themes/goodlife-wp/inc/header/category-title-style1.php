<?php
	if (is_category()) {
		$cat = get_queried_object();
		$cat_id = $cat->term_id;
		$current_category = get_category($cat_id);
		$category_siblings = ot_get_option('category_siblings', 'on'); 
	}
?>
<!-- Start Archive title -->
<div class="category-title style1">
	<div class="category-header cat-<?php echo esc_attr($cat_id); ?>">
		<?php echo '<h1>'.single_cat_title('', false).'</h1>'; ?>
		<?php echo category_description(); ?> 
	</div>
	<?php if ($category_siblings !== 'off') { ?>
	<div class="subcategory_container">
			<?php do_action( 'thb_Sibling_Categories', $current_category ); ?>
	</div>
	<?php } ?>
</div>
<!-- End Archive title -->