<?php 

	// Default configuration
	require_once dirname(__FILE__) . '/../wpvq-settings-page.php';
	if (!class_exists('Mobile_Detect')) {
		require_once dirname(__FILE__) . '/../includes/Mobile_Detect.php';
	}

	global $wpdata;
	$quiz = $wpdata['quiz'];

	// Quiz General Settings
	$wpvq_options 				=  get_option( 'wpvq_settings' );
	$wpvq_facebookAppID 		=  (isset($wpvq_options['wpvq_text_field_facebook_appid'])) ? $wpvq_options['wpvq_text_field_facebook_appid']:'' ;
	$wpvq_dont_use_FBAPI 		=  (isset($wpvq_options['wpvq_checkbox_facebook_no_api'])) ? true:false;
	$wpvq_API_already_loaded 	=  (isset($wpvq_options['wpvq_checkbox_facebook_already_api'])) ? true:false;

	// General Settings
	$wpvq_autoscroll 		   	=  (isset($wpvq_options['wpvq_checkbox_autoscroll_next'])) ? 'true':'false';
	$wpvq_scrollSpeed 		   	=  (isset($wpvq_options['wpvq_input_scroll_speed'])) ? $wpvq_options['wpvq_input_scroll_speed']:WPVQ_SCROLL_SPEED;

	// Global Ads Settings
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

	// Custom CSS
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


	// Social Options
	
	$wpvq_share_url = (isset($_GET['quizUrl']) && filter_var($_GET['quizUrl'], FILTER_VALIDATE_URL)) ? $_GET['quizUrl'] : get_permalink();

	$wpvq_twitter_hashtag 	=  str_replace('#', '', (isset($wpvq_options['wpvq_text_field_twitterhashtag'])) ? $wpvq_options['wpvq_text_field_twitterhashtag'] : WPVQ_TWITTER_HASHTAG );	
	$wpvq_twitter_mention 	=  str_replace('#', '', (isset($wpvq_options['wpvq_text_field_twittermention'])) ? $wpvq_options['wpvq_text_field_twittermention'] : '' );	
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
		$facebookLink 			=  $wpvq_share_url;
		$facebookDescription 	=  wpvq_delete_quotes($facebookDescription);
		$facebookTitle 			=  wpvq_delete_quotes($facebookTitle);
		$twitterText 			=  wpvq_delete_quotes(str_replace(' ', '+', stripslashes($twitterText)));
		$localCaption 			=  wpvq_delete_quotes($localCaption);
	?>

	<?php if ($wpvq_networks_display['vk']): ?>
		<script type="text/javascript" src="http://vk.com/js/api/share.js?9"; charset="windows-1251"></script>
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

<a name="wpvq"></a>
<div id="wpvq-quiz-<?php echo $quiz->getId(); ?> wpvq-results-page" class="wpvq <?php echo $quiz->getNiceType(); ?>">

	<!-- Preload checkbox pictures (checked + loader) -->
	<div id="preload-checkbox-checked"></div>
	<div id="preload-checkbox-loader"></div>
	<div id="preload-checkbox-big-loader"></div>

	<!-- ScrollTo reference -->
	<a id="wpvq-end-anchor"></a>

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

						<a href="javascript:PopupFeed('<?php echo $wpvq_share_url; ?>')" class="wpvq-facebook-noscript">
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
						<a href="//twitter.com/share?url=<?php echo $wpvq_share_url; ?>&text=<?php echo $twitterText; ?>&hashtags=<?php echo $wpvq_twitter_hashtag; ?>&mention=<?php echo $wpvq_twitter_mention; ?>" target="_blank" class="wpvq-js-loop wpvq-twitter-share-popup">
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
						<a href="//plus.google.com/share?url=<?php echo $wpvq_share_url; ?>" target="_blank" class="wpvq-js-loop wpvq-gplus-share-popup">
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
					?>

					<hr class="wpvq-clear-invisible" />

				</div>
			<?php endif; ?>
		</div>

		<?php if ($quiz->getMeta('playAgain')): ?>
			<div class="wpvq-play-again-area" style="display:block; /* force display */">
				<a href="<?php echo $wpvq_share_url; ?>#wpvq"><button><?php _e("↺ &nbsp; PLAY AGAIN !", 'wpvq'); ?></button></a>
			</div>
		<?php endif; ?>

	</div>

	<?php if ($wpvq_display_ads): ?>
		<div class="wpvq-a-d-s wpvq-bottom-a-d-s">
			<?php echo $wpvq_textarea_ads_bottom; ?>
			<?php echo $wpvq_textarea_ads_bottom_specific; ?>
		</div>
	<?php endif; ?>
	
</div>

<!-- JS Global Vars -->
<script type="text/javascript">
	/* JS debug. Use $_GET['wpvq_js_debug'] to enable it. */
	var wpvq_js_debug = <?php echo (isset($_GET['wpvq_js_debug'])) ? 'true':'false' ?>;

	/* Global var */
	var wpvq_front_quiz 			= false; // useful for wpvq-front-results
	var quizName 					= "<?php echo wpvq_delete_quotes($quiz->getName()); ?>";
	var quizId 						= <?php echo $quiz->getId(); ?>;
	var totalCountQuestions 		= <?php echo $quiz->countQuestions(); ?>;
	var wpvq_type 					= "<?php echo $wpdata['type']; ?>";
	var wpvq_results 				= <?php echo json_encode($wpdata['results']); ?> 
	
	var wpvq_scroll_top_offset 		= <?php echo $wpvq_scroll_top_offset; ?>;
	var wpvq_scroll_speed 			= <?php echo $wpvq_scrollSpeed; ?>;

	var wpvq_local_caption 			= '<?php echo (isset($localCaption)) ? $localCaption:''; ?>';
	var wpvq_share_url 				= '<?php echo $wpvq_share_url; ?>';
	var wpvq_facebook_caption 		= '<?php echo (isset($facebookTitle)) ? $facebookTitle:''; ?>';
	var wpvq_facebook_description 	= '<?php echo (isset($facebookDescription)) ? $facebookDescription:''; ?>';
	var wpvq_facebook_picture 		= null;	
</script>