<?php
	if (is_category()) {
		$cat = get_queried_object();
		$cat_id = $cat->term_id;
		$current_category = get_category($cat_id);
		$category_siblings = ot_get_option('category_siblings', 'on'); 
	}
?>
<!-- Start Archive title -->
<div class="category-title style2">
	<div class="category-header">
		<div class="row">
			<div class="small-6 medium-5 columns">
				<?php echo '<h1>'.single_cat_title('', false).'</h1>'; ?>
			</div>
			<div class="small-6 medium-7 columns">
				<?php if ($category_siblings !== 'off') { ?>
				<div class="subcategory_container">
					<?php do_action( 'thb_Sibling_Categories', $current_category ); ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php echo category_description(); ?> 
</div>
<!-- End Archive title -->