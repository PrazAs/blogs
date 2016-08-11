<?php 
	$cat = get_queried_object();
	$cat_id = $cat->term_id;
	$sidebar = ot_get_option('category_sidebars_'. $cat_id); 
	$cat_sidebar = $sidebar ? $sidebar : 'category';
?>
<aside class="sidebar small-12 medium-4 columns equal" role="complementary">
	<div class="sidebar_inner fixed-me">
	<?php 
	
		##############################################################################
		# Category Sidebar
		##############################################################################
	
	 	?>
	<?php dynamic_sidebar($cat_sidebar); ?>
	</div>
</aside>