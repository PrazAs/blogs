<?php 
	$pageskin = ot_get_option('thb_ads_pageskin');
	
	if ($pageskin) { 
	?>
		
		<aside class="post pageskin">
			<div class="post-content">
				<?php echo do_shortcode(wp_kses_post($pageskin)); ?>
			</div>
		</aside>
		
	<?php 
	}
?>