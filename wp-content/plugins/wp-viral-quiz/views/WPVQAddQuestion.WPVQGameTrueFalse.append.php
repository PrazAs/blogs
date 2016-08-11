<?php 
	require_once dirname(__FILE__) . '/../includes/snippets.php'; 
	require_once ABSPATH . '/wp-load.php';
?>

<?php 
	$options 		=  get_option('wpvq_settings');
	$showMiniature 	=  (isset($options['wpvq_checkbox_backoffice_miniature'])) ? true:false;
?>

<div>
	<div class="vq-bloc wpvq-uniq-question" data-questionIndex="">

		<div class="wpvq-window-options">
			<span class="wpvq-window-options-minimize"><i class="fa fa-minus-square"></i></span>
		</div>

		<input type="hidden" name="£questionId£" value="%%questionId%%" />
		<h3>
			<?php _e('Question', '', 'wpvq'); ?> #<span class="vq-questionNum">%%questionIndex%%</span> :<br />
			<textarea name="£questionLabel£" class="vq-question-label" placeholder="<?php _e('Is it ..... ?', '', 'wpvq'); ?>">%%questionLabel%%</textarea>

			<!-- HTML tags allowed -->
			<div style="text-align:right;">
				<span class="vq-badge vq-badge-neutral"><span class="dashicons dashicons-yes"></span><?php _e("HTML tags + [shortcodes] allowed", 'wpvq'); ?></span> 
			</div>
		</h3>
		
		<div class="wpvq-window-content">
			<div class="vq-content">
				<div class="vq-image-bloc">
					<div class="vq-image-bloc-button">
						<label for="upload_image">
						    <button class="vq-upload_image_button button" type="button" data-questionIndex=""><?php _e('Add a cover image to illustrate this question', '', 'wpvq'); ?></button>
						</label>
					</div>
					<div class="vq-image-bloc-picture">
						<span class="wpvq-delete-picture-question" data-questionIndex="" data-answerIndex="0" style="%%showDeletePictureLabel%%"><?php _e("Delete this picture", 'wpvq'); ?></span>
						<?php if ($showMiniature): ?>
							<a href="%%questionPictureUrl%%" target="_blank" class="wpvq-picture-url-link" data-questionIndex="" data-answerIndex="0">%%questionPictureUrl%%</a>
						<?php else : ?>
							<img src="%%questionPictureUrl%%" alt="" class="vq-pictureUploaded" data-questionIndex="" data-answerIndex="0" />
						<?php endif; ?>
					</div>
					<input type="hidden" name="£pictureId£" class="pictureId" value="%%questionPictureId%%" data-questionIndex="" data-answerIndex="0" />
				</div>

				<div class="vq-answers" data-questionIndex="">%%answers%%</div>
				<div style="text-align: center;">
					<div class="vq-add-answer" data-questionIndex="">+ <strong><?php _e("Add a new answer", 'wpvq'); ?></strong> <?php _e("to this question", 'wpvq'); ?></div>
				</div>
			</div>
			
			<hr style="" />

			<!-- Add a page after -->
			<div class="vq-page-after-bloc">
				<h4 class="vq-page-after">
					<label>
						<input type="checkbox" class="vq-pageAfter-checkbox" name="£pageAfterCheckbox£" data-questionIndex="" %%pageAfterChecked%%> 
						<?php _e("Do you want to add a page after this question ?", 'wpvq'); ?>
					</label>
				</h4>
			</div>

			<!-- Explain the question -->
			<div class="vq-explain-bloc">
				<h4 class="vq-explain-answer">
					<label>
						<input type="checkbox" class="vq-explain-checkbox" name="£questionContentCheckbox£" data-questionIndex="" %%explainChecked%%> 
						<?php _e("Do you want to give an explaination when people answer?", 'wpvq'); ?>
					</label>
				</h4>
				<div class="hide-the-editor" style="%%styleEditor%%">
					<textarea name="£questionContent£" id="£questionContent£" class="vq-explain-textarea" data-questionIndex="" style="width:100%;">%%questionContent%%</textarea>
				</div>
			</div>
			
			<hr  style="margin-bottom:0px;" />
		</div> <!-- windows-content -->
		
		<div class="vq-actions">
			<span class="vq-delete-label delete-question-button" data-questionId="%%questionId%%" onClick="return confirm('<?php _e('Do you really want to delete it ?', '', 'wpvq'); ?>');">
				<?php _e("Delete this question", 'wpvq'); ?>
			</span>
			<div class="vq-position-label">
				<?php _e("Ranking", 'wpvq'); ?> : 
				<input type="text" class="questionContent" name="£questionPosition£" id="£questionPosition£" value="%%questionPosition%%" data-questionIndex="" />
				/ <span class="total-uniq-question">%%totalUniqQuestions%%</span>
			</div>
			<hr style="clear:both;border:0px;">
		</div>

	</div>
	<hr style="border:0px; border-bottom:4px dashed #dedede;margin:25px 0;">

</div>