<?php 
	require_once dirname(__FILE__) . '/../includes/snippets.php'; 
	require_once ABSPATH . '/wp-load.php';
?>

<div>
	<div class="vq-bloc">
		<input type="hidden" name="£appreciationId£" value="%%appreciationId%%" />
		<h3><?php _e("Less than", 'wpvq'); ?> : 
		<input type="text" name="£scoreCondition£" class="vq-scoreCondition-label" placeholder="<?php _e('x', 'wpvq'); ?>" value="%%scoreCondition%%" style="width:70px;text-align:center;" /> <?php _e("points", 'wpvq'); ?> <?php _e("(excluded)", 'wpvq'); ?></h3>
		<div class="vq-content">
			<label for="">
				<strong><?php _e("Appreciation :", 'wpvq'); ?></strong><br />
				<textarea name="£appreciationContent£" id="£appreciationContent£" rows="10" style="width:100%;">%%appreciationContent%%</textarea>
			</label>
			<!-- HTML tags allowed -->
			<div style="text-align:right;">
				<span class="vq-badge vq-badge-neutral"><span class="dashicons dashicons-yes"></span><?php _e("[shortcodes] allowed", 'wpvq'); ?></span> 
			</div>
		</div>
		<hr />
		<div class="vq-actions">
			<span class="vq-delete-label delete-appreciation-button" data-appreciationId="%%appreciationId%%" onClick="return confirm('<?php _e('Do you really want to delete it ?', 'wpvq'); ?>');"><?php _e("Delete this appreciation", 'wpvq'); ?></span>
		</div>
	</div>
</div>