<?php 
	require_once dirname(__FILE__) . '/../includes/snippets.php'; 
	require_once ABSPATH . '/wp-load.php';
?>

<div class="wpvq-multiplier-section-parent">
	<div class="wpvq-multiplier-section">
		<span class="wpvq-personality-label">%%personalityLabel%%</span>
		<select name="£answerMultiplier£" class="wpvq-multiplier-selector" data-personalityId="%%personalityId%%" data-questionIndex="" data-answerIndex="">
			<option value="%%multiplierValue%%"><?php _e("Current:", 'wpvq'); ?> %%multiplierValue%%</option>
			<option value="0">0 <?php _e("point", 'wpvq'); ?></option>
			<option value="1">1 <?php _e("point", 'wpvq'); ?></option>
			<option value="2">2 <?php _e("points", 'wpvq'); ?></option>
			<option value="3">3 <?php _e("points", 'wpvq'); ?></option>
			<option value="4">4 <?php _e("points", 'wpvq'); ?></option>
			<option value="5">5 <?php _e("points", 'wpvq'); ?></option>
			<option value="0">—</option>
			<option value="-1">-1 <?php _e("point", 'wpvq'); ?></option>
			<option value="-2">-2 <?php _e("points", 'wpvq'); ?></option>
			<option value="-3">-3 <?php _e("points", 'wpvq'); ?></option>
			<option value="-4">-4 <?php _e("points", 'wpvq'); ?></option>
			<option value="-5">-5 <?php _e("points", 'wpvq'); ?></option>
			<?php do_action('wpvq_add_options_select_multipliers'); ?>
		</select>
		<hr style="clear:both;float:left;" />
	</div>
</div>