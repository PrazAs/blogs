<?php $fixed = ot_get_option('article_fixed_sidebar', 'on') == 'on' ? 'fixed-me' : ''; ?>
<aside class="sidebar small-12 medium-4 columns equal" role="complementary">
	<div class="sidebar_inner <?php echo esc_attr($fixed); ?>">
	<?php 
	
		##############################################################################
		# Single Sidebar
		##############################################################################
	
	 	?>
	<?php dynamic_sidebar('single'); ?>
	</div>
</aside>