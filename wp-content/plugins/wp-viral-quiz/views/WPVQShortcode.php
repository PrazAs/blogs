<?php 

	// Default configuration
	require_once dirname(__FILE__) . '/../wpvq-settings-page.php';
	if (!class_exists('Mobile_Detect')) {
		require_once dirname(__FILE__) . '/../includes/Mobile_Detect.php';
	}

	global $wpdata;
	$quiz = $wpdata['quiz'];

	// Offline Answers Table
	if ($quiz->getNiceType() == 'TrueFalse') {
		$wpvq_answersTable = $quiz->getAnswersTable();
	}

	// Quiz General Settings
	$wpvq_options 				=  get_option( 'wpvq_settings' );
	$wpvq_facebookAppID 		=  (isset($wpvq_options['wpvq_text_field_facebook_appid'])) ? $wpvq_options['wpvq_text_field_facebook_appid']:'' ;
	$wpvq_dont_use_FBAPI 		=  (isset($wpvq_options['wpvq_checkbox_facebook_no_api'])) ? true:false;
	$wpvq_API_already_loaded 	=  (isset($wpvq_options['wpvq_checkbox_facebook_already_api'])) ? true:false;

	// General Settings
	$wpvq_autoscroll 		   	=  (isset($wpvq_options['wpvq_checkbox_autoscroll_next'])) ? 'true':'false';
	$wpvq_scrollSpeed 		   	=  (isset($wpvq_options['wpvq_input_scroll_speed'])) ? $wpvq_options['wpvq_input_scroll_speed']:WPVQ_SCROLL_SPEED;
	
	// Multipages quiz (deprecated option since v1.60)
	if (isset($wpvq_options['wpvq_select_show_progressbar'])) {
		$wpvq_display_progressbar = $wpvq_options['wpvq_select_show_progressbar'];
	} else {
		$wpvq_display_progressbar = isset($options['wpvq_checkbox_show_progressbar']) ? 'below':'hide';
	}

	$wpvq_content_progressbar  	=  (isset($wpvq_options['wpvq_select_content_progressbar'])) ? $wpvq_options['wpvq_select_content_progressbar']:'percentage';
	$wpvq_progressbar_color    	=  (isset($wpvq_options['wpvq_input_progressbar_color'])) ? $wpvq_options['wpvq_input_progressbar_color']:WPVQ_PROGRESSBAR_COLOR;
	$wpvq_wait_trivia_page	 	=  (isset($wpvq_options['wpvq_input_wait_trivia_page'])) ? $wpvq_options['wpvq_input_wait_trivia_page']:WPVQ_WAIT_TRIVIA_PAGE;
	$wpvq_refresh_page	 		=  ($quiz->_extraOptionIsTrue('refreshBrowser'));
	$wpvq_force_continue_button	=  ($quiz->_extraOptionIsTrue('forceContinueButton'));
	
	// Display a squeeze page with a start button
	$wpvq_squeeze_page	=  ($quiz->_extraOptionIsTrue('squeezePage'));

	// Global Ads Settings
	$wpvq_textarea_ads_top 				=  do_shortcode((isset($wpvq_options['wpvq_textarea_ads_top'])) ? $wpvq_options['wpvq_textarea_ads_top']:'');
	$wpvq_textarea_ads_bottom 			=  do_shortcode((isset($wpvq_options['wpvq_textarea_ads_bottom'])) ? $wpvq_options['wpvq_textarea_ads_bottom']:'');
	$wpvq_textarea_ads_results_above 	=  do_shortcode((isset($wpvq_options['wpvq_textarea_ads_results_above'])) ? $wpvq_options['wpvq_textarea_ads_results_above']:'');
	$wpvq_textarea_ads_results_content 	=  do_shortcode((isset($wpvq_options['wpvq_textarea_ads_results_content'])) ? $wpvq_options['wpvq_textarea_ads_results_content']:'');
	$wpvq_textarea_no_ads 				=  explode(',', (isset($wpvq_options['wpvq_textarea_no_ads'])) ? $wpvq_options['wpvq_textarea_no_ads']:'');
	$wpvq_display_ads 					=  !(in_array($q->getId(), $wpvq_textarea_no_ads));

	// Specific Ads Settings
	// Global Ads Settings
	$wpvq_textarea_ads_top_specific 			=  do_shortcode(stripslashes($quiz->_getExtraOption('adscontentBefore')));
	$wpvq_textarea_ads_bottom_specific 			=  do_shortcode(stripslashes($quiz->_getExtraOption('adscontentAfter')));
	$wpvq_textarea_ads_results_above_specific 	=  do_shortcode(stripslashes($quiz->_getExtraOption('adscontentAboveResult')));
	$wpvq_textarea_ads_results_content_specific =  do_shortcode(stripslashes($quiz->_getExtraOption('adscontentIntoResult')));

	// If auto-refresh on new page
	// Fetch answers if browser change URL parameter (wpvqas [i.e. answerStatus] base64 serialized)
	// wpvqas['wpvqas'] = array of value — wpvqas['wpvqn'] = current browser page (int)
	$wpvq_browser_page 		= 0;
	$wpvq_count_questions   = 'false';
	$wpvq_answersStatus 	= '[]'; // empty js array
	
	// esc_url replaces & by #038;, and it breaks everything
	$wpvq_refresh_url 		= str_replace('#038;', '&', esc_url('//' . $_SERVER['HTTP_HOST'] . add_query_arg(array('wpvqas'=>'%%wpvqas%%'), remove_query_arg(array('playAgain'))))); 

	if ($wpvq_refresh_page && isset($_GET['wpvqas']))
	{
		$wpvq_getAnswersStatus = array();
		parse_str(urldecode(base64_decode($_GET['wpvqas'])), $wpvq_getAnswersStatus);

		// echo "<pre>";
		// echo "— DEBUG —";
		// print_r($wpvq_getAnswersStatus);
		// echo "</pre>";

		$wpvq_browser_page 		=  intval($wpvq_getAnswersStatus['wpvqn']);
		$wpvq_count_questions 	=  intval($wpvq_getAnswersStatus['wpvqcq']);

		// Can be empty on TrueFalse, if we don't transmit true answers
		if (isset($wpvq_getAnswersStatus['wpvqas'])) {
			$wpvq_answersStatus = json_encode($wpvq_getAnswersStatus['wpvqas']);
		}
	}

	// Social Share Box 
	// —— PERSO
	$wpvq_share_perso_local 	=  (isset($wpvq_options['wpvq_text_field_share_local_PERSO']) && !empty($wpvq_options['wpvq_text_field_share_local_PERSO'])) ? $wpvq_options['wpvq_text_field_share_local_PERSO'] : WPVQ_SHARE_PERSO_LOCAL;
	$wpvq_share_perso_simple 	=  (isset($wpvq_options['wpvq_text_field_share_simple_PERSO']) && !empty($wpvq_options['wpvq_text_field_share_simple_PERSO'])) ? $wpvq_options['wpvq_text_field_share_simple_PERSO'] : WPVQ_SHARE_PERSO_SIMPLE;
	$wpvq_share_perso_fb_title 	=  (isset($wpvq_options['wpvq_text_field_share_facebook_title_PERSO']) && !empty($wpvq_options['wpvq_text_field_share_facebook_title_PERSO'])) ? $wpvq_options['wpvq_text_field_share_facebook_title_PERSO'] : WPVQ_SHARE_PERSO_FB_TITLE;
	$wpvq_share_perso_fb_desc 	=  (isset($wpvq_options['wpvq_text_field_share_facebook_desc_PERSO']) && !empty($wpvq_options['wpvq_text_field_share_facebook_desc_PERSO'])) ? $wpvq_options['wpvq_text_field_share_facebook_desc_PERSO'] : WPVQ_SHARE_PERSO_FB_DESC;
	// —— TRIVIA
	$wpvq_share_trivia_local 	=  (isset($wpvq_options['wpvq_text_field_share_local_TRIVIA']) && !empty($wpvq_options['wpvq_text_field_share_local_TRIVIA'])) ? $wpvq_options['wpvq_text_field_share_local_TRIVIA'] : WPVQ_SHARE_TRIVIA_LOCAL;
	$wpvq_share_trivia_simple 	=  (isset($wpvq_options['wpvq_text_field_share_simple_TRIVIA']) && !empty($wpvq_options['wpvq_text_field_share_simple_TRIVIA'])) ? $wpvq_options['wpvq_text_field_share_simple_TRIVIA'] : WPVQ_SHARE_TRIVIA_SIMPLE;
	$wpvq_share_trivia_fb_title =  (isset($wpvq_options['wpvq_text_field_share_facebook_title_TRIVIA']) && !empty($wpvq_options['wpvq_text_field_share_facebook_title_TRIVIA'])) ? $wpvq_options['wpvq_text_field_share_facebook_title_TRIVIA'] : WPVQ_SHARE_TRIVIA_FB_TITLE;
	$wpvq_share_trivia_fb_desc 	=  (isset($wpvq_options['wpvq_text_field_share_facebook_desc_TRIVIA']) && !empty($wpvq_options['wpvq_text_field_share_facebook_desc_TRIVIA'])) ? $wpvq_options['wpvq_text_field_share_facebook_desc_TRIVIA'] : WPVQ_SHARE_TRIVIA_FB_DESC;

	// Under the hood
	$wpvq_noresize_gif  	   	=  (isset($wpvq_options['wpvq_checkbox_noresize_gif']));
	$wpvq_textarea_custom_css	=  (isset($wpvq_options['wpvq_textarea_custom_css'])) ? $wpvq_options['wpvq_textarea_custom_css']:'';

	// Scroll offset (mobile and desktop)
	$detect = new Mobile_Detect;
	if ( $detect->isMobile() )
	{
		$wpvq_scroll_top_offset		=  (isset($wpvq_options['wpvq_input_scroll_top_offset_mobile'])) ? $wpvq_options['wpvq_input_scroll_top_offset_mobile']:0;
	}
	else
	{
		$wpvq_scroll_top_offset		=  (isset($wpvq_options['wpvq_input_scroll_top_offset'])) ? $wpvq_options['wpvq_input_scroll_top_offset']:0;	
	}
	
	// Redirect User at the end
	$wpvq_redirection_page 		=  $quiz->getMeta('redirectionPage');

	// Social Options
	$wpvq_twitter_hashtag 	=  str_replace('#', '', (isset($wpvq_options['wpvq_text_field_twitterhashtag'])) ? $wpvq_options['wpvq_text_field_twitterhashtag'] : WPVQ_TWITTER_HASHTAG );	
	$wpvq_twitter_mention 	=  str_replace('@', '', (isset($wpvq_options['wpvq_text_field_twittermention'])) ? $wpvq_options['wpvq_text_field_twittermention'] : '' );	
	$wpvq_networks 			=  array_filter(explode('|', isset($wpvq_options['wpvq_checkbox_enable_networking']) ? $wpvq_options['wpvq_checkbox_enable_networking']:'facebook|twitter|googleplus'));

	$wpvq_networks_display 	=  array(
		'twitter'		=> in_array('twitter', $wpvq_networks),
		'facebook'		=> in_array('facebook', $wpvq_networks),
		'googleplus'	=> in_array('googleplus', $wpvq_networks),
		'vk'			=> in_array('vk', $wpvq_networks),
	);

	// Quiz Social Settings
	$wpvq_show_sharing 	=  ($quiz->getShowSharing() && !empty($wpvq_networks));
	$wpvq_force_share 	=  $quiz->getForceToShare();
?>

<!-- Load CSS Skin Theme -->
<!-- Weird, but HTML5 compliant! o:-) -->
<style> @import url("<?php echo WPVQ_PLUGIN_URL . 'css/front-style.css'; ?>"); </style>
<?php if ($quiz->getSkin() != 'custom'): ?>
	<style> @import url("<?php echo WPVQ_PLUGIN_URL . 'css/skins/' . $quiz->getSkin() . '.css'; ?>"); </style>
<?php else: ?>
	<style> @import url("<?php echo dirname(get_stylesheet_uri()) . '/wpvq-custom.css'; ?>"); </style>
<?php endif; ?>

<!-- Custom style -->
<style>
	<?php echo $wpvq_textarea_custom_css; ?>
</style>

<!-- Prepare sharing options -->
<?php if ($wpvq_show_sharing || $wpvq_force_share): ?>

	<?php
		// Manage social message	
		if ( $quiz->getNiceType() == 'TrueFalse' )
		{
			$twitterText 			=  parse_share_tags_settings($wpvq_share_trivia_simple, $quiz);
			$facebookTitle 			=  parse_share_tags_settings($wpvq_share_trivia_fb_title, $quiz);
			$facebookDescription 	=  parse_share_tags_settings($wpvq_share_trivia_fb_desc, $quiz);
			$localCaption 			=  parse_share_tags_settings($wpvq_share_trivia_local, $quiz);
		}
		elseif( $quiz->getNiceType() ==  'Personality' )
		{
			$twitterText 			=  parse_share_tags_settings($wpvq_share_perso_simple, $quiz);
			$facebookTitle 			=  parse_share_tags_settings($wpvq_share_perso_fb_title, $quiz);
			$facebookDescription 	=  parse_share_tags_settings($wpvq_share_perso_fb_desc, $quiz);
			$localCaption 			=  parse_share_tags_settings($wpvq_share_perso_local, $quiz);
		}

		// Final _server-side_ variables
		$facebookLink 			=  get_permalink();
		$facebookDescription 	=  wpvq_delete_quotes($facebookDescription);
		$facebookTitle 			=  wpvq_delete_quotes($facebookTitle);
		$twitterText 			=  wpvq_delete_quotes(str_replace(' ', '+', stripslashes($twitterText)));
		$localCaption 			=  wpvq_delete_quotes($localCaption);
	?>

	<?php if ($wpvq_networks_display['vk']): ?>
		<script type="text/javascript" src="//vk.com/js/api/share.js?9"; charset="windows-1251"></script>
	<?php endif; ?>

	<!-- Facebook SDK -->
	<?php if (!$wpvq_API_already_loaded && !$wpvq_dont_use_FBAPI): ?>
		<script type="text/javascript">
			(function(d, s, id){
				 var js, fjs = d.getElementsByTagName(s)[0];
				 if (d.getElementById(id)) {return;}
				 js = d.createElement(s); js.id = id;
				 js.src = "//connect.facebook.net/en_US/sdk.js";
				 fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
	<?php endif; ?>

<?php endif ?>
<!-- / Prepare sharing options -->
	
<?php echo apply_filters('wpvq_public_version', "<!--  Quiz Created thanks to WP Viral Quiz (v".WPVQ_VERSION.") - https://www.institut-pandore.com/wp-viral-quiz/download -->"); ?>

<a name="wpvq"></a>

<?php if ($wpvq_squeeze_page && !isset($_GET['wpvqas'])): ?>
	<div id="wpvq-squeeze-<?php echo $quiz->getId(); ?>" class="wpvq-squeeze">
		<button class="wpvq-start-quiz"><?php _e("Start the quiz!", 'wpvq'); ?></button>
	</div>
<?php endif ?>

<div id="wpvq-quiz-<?php echo $quiz->getId(); ?>" class="wpvq <?php echo $quiz->getNiceType(); ?> columns-<?php echo $wpdata['columns']; ?>" <?php if($wpvq_squeeze_page && !isset($_GET['wpvqas'])): ?>style="display:none;"<?php endif; ?>>

	<?php if ($wpvq_display_ads): ?>
		<div class="wpvq-a-d-s wpvq-top-a-d-s">
			<?php echo $wpvq_textarea_ads_top; ?>
			<?php echo $wpvq_textarea_ads_top_specific; ?>
		</div>
	<?php endif; ?>

	<?php if ($quiz->getPageCounter() > 1 && ($wpvq_display_progressbar == 'above' || $wpvq_display_progressbar == 'both')): ?>
		<!-- Progress bar -->
		<div class="wpvq-page-progress wpvq_bar_container wpvq_bar_container_top">
		    <div class="wpvq-progress">
		    	<div class="wpvq-progress-zero">
			    	<?php if ($wpvq_content_progressbar == 'percentage'): ?>
			    		0%
			    	<?php else: ?>
			    		0 / <?php echo ($quiz->getPageCounter() - 1); ?>
			    	<?php endif;?>
		    	</div>
				<span class="wpvq-progress-value" style="background-color:<?php echo $wpvq_progressbar_color; ?>"></span>
			</div>
		</div>
	<?php endif ?>

	<!-- Preload checkbox pictures (checked + loader) -->
	<div id="preload-checkbox-checked"></div>
	<div id="preload-checkbox-loader"></div>
	<div id="preload-checkbox-big-loader"></div>

	<div id="wpvq-page-0" class="wpvq-single-page" style="display:none;">
		<?php 
			foreach($quiz->getQuestions() as $q):

				$disposition 	=  $q->squareOrLine();
				$label 			=  stripslashes($q->getLabel());
				
				// Pagination
				$isTherePage 	=  $q->isTherePageAfter();
				$currentPage 	=  (!isset($currentPage)) ? 0 : $currentPage;

				$max_width 		=  get_option( 'thumbnail_size_w' );
				$max_height 	=  get_option( 'thumbnail_size_h' );
		?>

			<div class="wpvq-question wpvq-<?php echo $disposition; ?>" data-pageAfter="<?php echo ($isTherePage) ? 'true':'false'; ?>" data-questionId="<?php echo $q->getId(); ?>">
				<div class="wpvq-question-label"><?php echo do_shortcode(stripslashes(nl2br($label))); ?></div>
				
				<?php 
					if($q->getPictureId() > 0):
						$image  	=  wp_get_attachment_image_src($q->getPictureId(), 'full');
						$imageInfo 	=  wpvq_wp_get_attachment($q->getPictureId());
						$wpvq_width = ($image[1] == 0) ? 'auto':$image[1].'px';
				?>
					<div style="position:relative; max-width:100%; margin:0 auto;">
						<img src="<?php echo wp_get_attachment_url($q->getPictureId()); ?>" alt="<?php echo htmlentities($imageInfo['description']); ?>" class="<?php echo apply_filters('wpvq_add_class_img_question', 'wpvq-question-img'); ?>" />
						<?php if ($imageInfo['description'] != ''): ?>
							<span class="wpvq-img-legal-label"><?php echo $imageInfo['description']; ?></span>
						<?php endif ?>
					</div>
				<?php endif; ?>
			
				<?php 
					foreach ($q->getAnswers() as $an):
				?>
					<div class="wpvq-answer" data-wpvq-answer="<?php echo $an->getId(); ?>">

						<!-- Weight+multiplier ID -->
						<?php if ($quiz->getNiceType() == 'Personality'): ?>
							<?php foreach ($an->getMultipliers() as $appreciationId => $multiplier): ?>
								<input class="wpvq-appreciation" type="hidden" value="<?php echo $multiplier; ?>" data-appreciationId="<?php echo $appreciationId; ?>" />
							<?php endforeach; ?>
						<?php endif; ?>

						<?php 
							if($an->getPictureId() > 0):
								$imageInfo  = wpvq_wp_get_attachment($an->getPictureId());
								$image 		= wp_get_attachment_image_src($an->getPictureId(), 'wpvq-square-answer');
								$imageUrl 	= $image[0];
								$wpvq_width = ($image[1] == 0) ? 'auto':$image[1].'px';

								// Don't resize gif if user doesn't want
								$fileInfo = pathinfo($imageUrl);
								if ($fileInfo['extension'] == 'gif' && $wpvq_noresize_gif) {
									$image = wp_get_attachment_image_src($an->getPictureId(), 'full');
									$imageUrl = $image[0];
								}
						?>

								<!--  Display a tiny label from the DESCRIPTION field -->
								<div style="position:relative;width:<?php echo $wpvq_width; ?>;max-width:100%; margin:0 auto;">
									<img src="<?php echo $imageUrl; ?>" alt="<?php echo $an->getLabel(); ?>" class="<?php echo apply_filters('wpvq_add_class_img_answer', 'wpvq-answer-img'); ?>" />
									<?php if ($imageInfo['description'] != ''): ?>
										<span class="wpvq-img-legal-label"><?php echo $imageInfo['description']; ?></span>
									<?php endif; ?>
								</div>

						<?php endif; ?>

						<input type="radio" class="vq-css-checkbox" data-wpvq-answer="<?php echo $an->getId(); ?>" />
						<label class="vq-css-label" data-wpvq-answer="<?php echo $an->getId(); ?>">
							<?php if ($an->getLabel() == ''): ?>
								<span style="visibility:hidden;">&nbsp;</span>
							<?php else: ?>
								<?php echo do_shortcode(stripslashes($an->getLabel())); ?>
							<?php endif; ?>
						</label>
					</div>
				<?php
					endforeach;
				?>

				<div class="wpvq-clear"></div>

				<div class="wpvq-explaination">
					<div class="wpvq-true"><?php echo apply_filters('wpvq_correct_label', __('Correct!', 'wpvq')); ?></div>
					<div class="wpvq-false"><?php echo apply_filters('wpvq_wrong_label', __('Wrong!', 'wpvq')); ?></div>
					<p class="wpvq-explaination-content-empty">-<!-- do not empty --></p>
				</div>

			</div>

			<?php if ($isTherePage): $currentPage++; ?>
					<div class="wpvq-next-page" style="display:none;">
						<button class="wpvq-next-page-button" style="background:<?php echo $wpvq_progressbar_color; ?>;"><?php _e("Continue >>", 'wpvq'); ?></button>
					</div>
				</div> <!-- close previous page -->

				<div id="wpvq-page-<?php echo $currentPage; ?>" class="wpvq-single-page" style="display:none;">
			<?php endif ?>
		<?php endforeach; ?>
	</div> <!-- Final page close -->

	<!-- ScrollTo reference -->
	<a id="wpvq-end-anchor"></a>

	<!-- Force to share -->
	<div id="wpvq-forceToShare-before-results">

			<p class="wpvq-forceToShare-please"><?php echo apply_filters('wpvq_shareToShow_label', __("Share the quiz to show your results !", 'wpvq')); ?></p>

			<a href="javascript:PopupFeed('<?php echo get_permalink(); ?>')" class="wpvq-facebook-noscript">
				<div class="wpvq-social-facebook wpvq-social-button">
				    <i class="wpvq-social-icon"><i class="fa fa-facebook"></i></i>
					<div class="wpvq-social-slide">
					    <p>Facebook</p>
					</div>
			  	</div>
			</a>
			
			<a href="#" class="wpvq-facebook-share-button wpvq-facebook-yesscript" style="display:none;">
				<div class="wpvq-social-facebook wpvq-social-button">
				    <i class="wpvq-social-icon"><i class="fa fa-facebook"></i></i>
					<div class="wpvq-social-slide">
					    <p>Facebook</p>
					</div>
			  	</div>
			</a>

			<hr class="wpvq-clear-invisible" />
	</div>

	<!-- Force to give some informations -->
	<div id="wpvq-ask-before-results">
		<form id="wpvq-form-informations" action="" method="post">

			<p class="wpvq-who-are-you">
				<?php echo apply_filters('wpvq_who_are_you_label', __("Just tell us who you are to view your results !", 'wpvq')); ?>
			</p>

			<?php do_action('wpvq_add_fields_before', $quiz->getId()); ?>

			<?php if ($quiz->askNickname()): ?>
				<div class="wpvq-input-block" id="wpvq-askNickname">
					<label><?php echo apply_filters('wpvq_nickname_label', __("Your first name :", 'wpvq')); ?></label>
					<input type="text" name="wpvq_askNickname" value="<?php echo apply_filters('wpvq_default_value_nickname', '', 'wpvq'); ?>" />
				</div>
			<?php endif; ?>

			<?php do_action('wpvq_add_fields_between', $quiz->getId()); ?>

			<?php if ($quiz->askEmail()): ?>
				<div class="wpvq-input-block" id="wpvq-askEmail">
					<label><?php echo apply_filters('wpvq_email_label', __("Your e-mail address :", 'wpvq')); ?></label>
					<input type="text" name="wpvq_askEmail" value="<?php echo apply_filters('wpvq_default_value_email', '', 'wpvq'); ?>" />
				</div>
			<?php endif; ?>

			<?php do_action('wpvq_add_fields', $quiz->getId()); ?>

			<input type="hidden" id="wpvq_ask_result" name="wpvq_ask_result" value="<?php echo $quiz->getId(); ?>" />
			<input type="hidden" name="wpvq_quizId" value="<?php echo $quiz->getId(); ?>" />

			<p class="wpvq-submit-button-ask">
				<button type="submit" id="wpvq-submit-informations"><?php echo apply_filters('wpvq_show_my_results_label', __("Show my results >>", 'wpvq')); ?></button>
				<?php if ($quiz->isAskInformationsOptional()): ?>
					<br />
					<span class="wpvq-ignore-askInfo">
						<?php echo apply_filters('wpvq_optional_label', __("Ignore & see my results >>",'wpvq')); ?>
					</span>
				<?php endif ?>
			</p>
		</form>
	</div>

	<!-- Show results -->
	<div id="wpvq-general-results">

		<?php if ($wpvq_display_ads): ?>
			<div class="wpvq-bloc-addBySettings-top">
				<?php echo $wpvq_textarea_ads_results_above; ?>
				<?php echo $wpvq_textarea_ads_results_above_specific; ?>
			</div>
		<?php endif; ?>

		<div id="wpvq-big-loader">
			<img src="<?php echo plugins_url( 'img/big-loader.gif', __FILE__ ); ?>" alt="" />
		</div>

		<?php if ($quiz->getNiceType() == 'TrueFalse'): ?>
			<div id="wpvq-final-score">
				<span class="wpvq-quiz-title"><?php echo stripslashes($quiz->getName()); ?></span>
				<span class="wpvq-local-caption wpvq-headline"><?php echo $wpvq_share_trivia_local; ?></span>
				<div class="wpvq-appreciation-content"></div>
		<?php elseif ($quiz->getNiceType() == 'Personality'): ?>
			<div id="wpvq-final-personality">
				<span class="wpvq-quiz-title"><?php echo stripslashes($quiz->getName()); ?></span>
				<span class="wpvq-local-caption wpvq-you-are"><?php echo $wpvq_share_perso_local; ?></span>
				<div class="wpvq-personality-content"></div>
		<?php endif; ?>

				<?php if ($wpvq_display_ads): ?>
					<div class="wpvq-bloc-addBySettings-results">
						<?php echo $wpvq_textarea_ads_results_content; ?>
						<?php echo $wpvq_textarea_ads_results_content_specific; ?>
					</div>
				<?php endif; ?>

			<?php if ($wpvq_show_sharing): ?>
				<div id="wpvq-share-buttons">

					<p class="wp-share-results">
						<?php echo apply_filters('wpvq_share_results_label', __('Share your results', 'wpvq')); ?>
					</p>

					<hr class="wpvq-clear-invisible" />

					<?php if ($wpvq_networks_display['facebook']): ?>

						<a href="javascript:PopupFeed('<?php echo get_permalink(); ?>')" class="wpvq-facebook-noscript">
							<div class="wpvq-social-facebook wpvq-social-button">
							    <i class="wpvq-social-icon"><i class="fa fa-facebook"></i></i>
								<div class="wpvq-social-slide">
								    <p>Facebook</p>
								</div>
						  	</div>
						</a>

						<a href="#" class="wpvq-facebook-share-button wpvq-facebook-yesscript" style="display:none;">
							<div class="wpvq-social-facebook wpvq-social-button">
							    <i class="wpvq-social-icon"><i class="fa fa-facebook"></i></i>
								<div class="wpvq-social-slide">
								    <p>Facebook</p>
								</div>
						  	</div>
						</a>

					<?php endif; ?>
					 
					<!-- Twitter -->
					<?php if ($wpvq_networks_display['twitter']): ?>
						<a href="//twitter.com/share?url=<?php echo get_permalink(); ?>&text=<?php echo $twitterText; ?>&hashtags=<?php echo $wpvq_twitter_hashtag; ?>&via=<?php echo $wpvq_twitter_mention; ?>" target="_blank" class="wpvq-js-loop wpvq-twitter-share-popup">
							<div class="wpvq-social-twitter wpvq-social-button">
							    <i class="wpvq-social-icon"><i class="fa fa-twitter"></i></i>
								<div class="wpvq-social-slide">
								    <p>Twitter</p>
								</div>
						  	</div>
						</a>
					<?php endif ?>
					 
					<!-- Google+ -->
					<?php if ($wpvq_networks_display['googleplus']): ?>
						<a href="//plus.google.com/share?url=<?php echo get_permalink(); ?>" target="_blank" class="wpvq-js-loop wpvq-gplus-share-popup">
							<div class="wpvq-social-google wpvq-social-button">
							    <i class="wpvq-social-icon"><i class="fa fa-google-plus"></i></i>
								<div class="wpvq-social-slide">
								    <p>Google+</p>
								</div>
						  	</div>
						</a>
					<?php endif; ?>

					<!-- VK Share Javascript Code -->
					<?php if ($wpvq_networks_display['vk']): ?>
						<div class="wpvq-vk-share-content wpvq-js-loop">

						</div>
					<?php endif; ?>

					<?php 
						// Hook to add your own social buttons
						do_action('wpvq_add_social_buttons', $quiz->getId(), get_permalink());
						/**
						 * Example :
						 * add_action('wpvq_add_social_buttons', 'callback_add_my_social_button');	 
						 * function callback_add_my_social_button($quizId, $shareLink)
						 * {
						 * 		echo '<a href="http://www.social-network.com/share/?url='.$shareLink.'&title=%%quizname%%&description=%%details%%">Social Network</a>';
						 *
						 * 		// For the whole list of %%tags%%, go to the settings page of WP Viral Quiz
						 * 		// then to the "Customise Personality/Trivia Quizzes" subsection.
						 * }
						 */
					?>

					<hr class="wpvq-clear-invisible" />

				</div>
			<?php endif; ?>
		</div>

		<?php if ($quiz->getMeta('playAgain')): ?>
			<?php $playAgainUrl = esc_url( remove_query_arg(array('wpvqas'), add_query_arg(array('playAgain' => time()))) ); ?>
			<div class="wpvq-play-again-area">
				<a href="<?php echo $playAgainUrl; ?>#wpvq"><button><?php _e("↺ &nbsp; PLAY AGAIN !", 'wpvq'); ?></button></a>
			</div>
		<?php endif; ?>

	</div>

	<?php if ($quiz->getPageCounter() > 1 && ($wpvq_display_progressbar == 'below' || $wpvq_display_progressbar == 'both')): ?>
		<!-- Progress bar -->
		<div class="wpvq-page-progress wpvq_bar_container wpvq_bar_container_bottom">
		    <div class="wpvq-progress">
				<div class="wpvq-progress-zero">
			    	<?php if ($wpvq_content_progressbar == 'percentage'): ?>
			    		0%
			    	<?php else: ?>
			    		0 / <?php echo ($quiz->getPageCounter() - 1); ?>
			    	<?php endif;?>
		    	</div>
				<span class="wpvq-progress-value" style="background-color:<?php echo $wpvq_progressbar_color; ?>"></span>
			</div>
		</div>
	<?php endif ?>

	<?php if ($wpvq_display_ads): ?>
		<div class="wpvq-a-d-s wpvq-bottom-a-d-s">
			<?php echo $wpvq_textarea_ads_bottom; ?>
			<?php echo $wpvq_textarea_ads_bottom_specific; ?>
		</div>
	<?php endif; ?>
	
</div>

<?php if ($quiz->getShowCopyright() == 1): ?>
	<p class="wpvq-small-copyright">
		<?php _e("This quiz has been created with", 'wpvq'); ?> <a href="https://www.ohmyquiz.io/discover" target="_blank">WordPress Viral Quiz &hearts;</a>.
	</p>
<?php endif; ?>

<!-- JS Global Vars -->
<script type="text/javascript">
	/* JS debug. Use $_GET['wpvq_js_debug'] to enable it. */
	var wpvq_js_debug = <?php echo (isset($_GET['wpvq_js_debug'])) ? 'true':'false' ?>;

	<?php if ($quiz->getNiceType() == 'TrueFalse'): ?>
	var wpvq_ans89733 = <?php echo json_encode($wpvq_answersTable); ?>;
	<?php endif; ?>

	/* Global var */
	var wpvq_front_quiz 			= true; // useful for wpvq-front-results
	var quizName 					= "<?php echo wpvq_delete_quotes($quiz->getName()); ?>";
	var quizId 						= <?php echo $quiz->getId(); ?>;
	var totalCountQuestions 		= <?php echo $quiz->countQuestions(); ?>;
	var askEmail 					= <?php echo ($quiz->askEmail()) ? 'true':'false'; ?>;
	var askNickname 				= <?php echo ($quiz->askNickname()) ? 'true':'false'; ?>;
	var forceToShare 				= <?php echo (in_array('facebook', $quiz->getForceToShare())) ? 'true':'false'; ?>;
	var wpvq_type 					= "<?php echo $wpdata['type']; ?>";

	var wpvq_hideRightWrong 		= <?php echo (!$quiz->getMeta('hideRightWrong')) ? 'false':'true'; ?>;

	var wpvq_refresh_page 			= <?php echo ($wpvq_refresh_page) ? 'true':'false'; ?>;
	var wpvq_force_continue_button 	= <?php echo ($wpvq_force_continue_button) ? 'true':'false'; ?>;
	var wpvq_browser_page 			= <?php echo $wpvq_browser_page; ?>;
	var wpvq_answersStatus 			= <?php echo $wpvq_answersStatus; ?>;
	var wpvq_countQuestions 		= <?php echo $wpvq_count_questions ?>;
	
	var wpvq_scroll_top_offset 		= <?php echo $wpvq_scroll_top_offset; ?>;
	var wpvq_scroll_speed 			= <?php echo $wpvq_scrollSpeed; ?>;

	var wpvq_autoscroll_next_var 	= <?php echo $wpvq_autoscroll; ?>;
	var wpvq_progressbar_content	= '<?php echo $wpvq_content_progressbar; ?>';
	var wpvq_wait_trivia_page 		= <?php echo $wpvq_wait_trivia_page; ?>;

	var i18n_wpvq_needEmailAlert 	= "<?php _e('You have to give your e-mail to see your results.', 'wpvq'); ?>";
	var i18n_wpvq_needNicknameAlert = "<?php _e('You have to give your nickname to see your results.', 'wpvq'); ?>";
	var wpvq_checkMailFormat 		= <?php echo apply_filters('wpvq_checkMailFormat', 'true'); ?>;

	var wpvq_local_caption 			= '<?php echo (isset($localCaption)) ? $localCaption:''; ?>';
	var wpvq_refresh_url 			= '<?php echo $wpvq_refresh_url; ?>';
	var wpvq_share_url 				= '<?php echo get_permalink(); ?>';
	var wpvq_facebook_caption 		= '<?php echo (isset($facebookTitle)) ? $facebookTitle:''; ?>';
	var wpvq_facebook_description 	= '<?php echo (isset($facebookDescription)) ? $facebookDescription:''; ?>';
	var wpvq_facebook_picture 		= null;

	var wpvq_redirection_page 		= '<?php echo $wpvq_redirection_page; ?>';
</script>