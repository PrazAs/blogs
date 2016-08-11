<?php

	/**
	 * **************************************************
	 * **************************************************
	 * 
	 * 					SETTINGS PAGE
	 * 					
	 * **************************************************
	 * **************************************************
	 */

	function wpvq_settings_init() { 

		register_setting( 'wpvqSettings_general', 'wpvq_settings', 'wpvq_settings_validate');
		register_setting( 'wpvqSettings_multipages', 'wpvq_settings', 'wpvq_settings_validate');
		register_setting( 'wpvqSettings_ads', 'wpvq_settings', 'wpvq_settings_validate');
		register_setting( 'wpvqSettings_facebookApi', 'wpvq_settings', 'wpvq_settings_validate');
		register_setting( 'wpvqSettings_socialNetworks', 'wpvq_settings', 'wpvq_settings_validate');
		register_setting( 'wpvqSettings_sharePersonality', 'wpvq_settings', 'wpvq_settings_validate');
		register_setting( 'wpvqSettings_shareTrivia', 'wpvq_settings', 'wpvq_settings_validate');
		register_setting( 'wpvqSettings_autoUpdate', 'wpvq_settings', 'wpvq_settings_validate');
		register_setting( 'wpvqSettings_underTheHood', 'wpvq_settings', 'wpvq_settings_validate');

		/**
		 * ------------------------------------
		 * 			REGISTER SETTINGS
		 * ------------------------------------
		 */

		/**
		 * General Settings Section
		 */
		add_settings_section(
			'wpvq_wpvqSettings_general_section', 
			'<a name="general"></a><span class="dashicons dashicons-admin-settings"></span> ' . __( 'General Options', 'wpvq' ), 
			'wpvq_settings_general_section_callback', 
			'wpvqSettings_general'
		);

		add_settings_field( 
			'wpvq_checkbox_autoscroll_next', 
			__("Auto-scroll on game", 'wpvq'),
			'wpvq_checkbox_autoscroll_next_render', 
			'wpvqSettings_general', 
			'wpvq_wpvqSettings_general_section' 
		);

		add_settings_field( 
			'wpvq_input_scroll_speed', 
			__("Scroll speed<br>(in milliseconds)", 'wpvq'),
			'wpvq_input_scroll_speed_render', 
			'wpvqSettings_general', 
			'wpvq_wpvqSettings_general_section' 
		);

		add_settings_field( 
			'wpvq_input_scroll_speed', 
			__("Allow subscribers ?", 'wpvq'),
			'wpvq_checkbox_allow_subscribers_render', 
			'wpvqSettings_general', 
			'wpvq_wpvqSettings_general_section' 
		);


		/**
		 * Multi-pages settings
		 */
		add_settings_section(
			'wpvq_wpvqSettings_multipages_section', 
			'<a name="multipages"></a><span class="dashicons dashicons-book-alt"></span> ' . __( 'Multipages Quiz Settings', 'wpvq' ), 
			'wpvq_settings_multipages_section_callback', 
			'wpvqSettings_multipages'
		);

		add_settings_field( 
			'wpvq_select_show_progressbar', 
			__("Display progressbar", 'wpvq'),
			'wpvq_select_show_progressbar_render', 
			'wpvqSettings_multipages', 
			'wpvq_wpvqSettings_multipages_section' 
		);

		add_settings_field( 
			'wpvq_select_content_progressbar', 
			__("Text in the progressbar", 'wpvq'),
			'wpvq_select_content_progressbar_render', 
			'wpvqSettings_multipages', 
			'wpvq_wpvqSettings_multipages_section' 
		);

		add_settings_field( 
			'wpvq_input_progressbar_color', 
			__("Progressbar color", 'wpvq'),
			'wpvq_input_progressbar_color_render', 
			'wpvqSettings_multipages', 
			'wpvq_wpvqSettings_multipages_section' 
		);

		add_settings_field( 
			'wpvq_input_wait_trivia_page', 
			__("Time before changing page", 'wpvq')."<br/>".__("(in milliseconds)", 'wpvq'),
			'wpvq_input_wait_trivia_page_render', 
			'wpvqSettings_multipages', 
			'wpvq_wpvqSettings_multipages_section' 
		);

		/**
		 * Ads Network
		 */
		add_settings_section(
			'wpvq_wpvqSettings_ads_section',
			'<a name="ads"></a><span class="dashicons dashicons-welcome-widgets-menus"></span> ' . __( 'Ads Settings', 'wpvq' ), 
			'wpvq_wpvqSettings_ads_section_callback', 
			'wpvqSettings_ads'
		);

		add_settings_field( 
			'wpvq_textarea_ads_top', 
			__("Just before each quiz", 'wpvq'),
			'wpvq_textarea_ads_top_render', 
			'wpvqSettings_ads', 
			'wpvq_wpvqSettings_ads_section' 
		);

		add_settings_field( 
			'wpvq_textarea_ads_bottom', 
			__("Just after each quiz", 'wpvq'),
			'wpvq_textarea_ads_bottom_render', 
			'wpvqSettings_ads', 
			'wpvq_wpvqSettings_ads_section' 
		);

		add_settings_field( 
			'wpvq_textarea_ads_results_above', 
			__("Above the result area (when a quiz is finished)", 'wpvq'),
			'wpvq_textarea_ads_results_above_render', 
			'wpvqSettings_ads', 
			'wpvq_wpvqSettings_ads_section' 
		);

		add_settings_field( 
			'wpvq_textarea_results_content', 
			__("Just after the text in the result area", 'wpvq'),
			'wpvq_textarea_ads_results_content_render', 
			'wpvqSettings_ads', 
			'wpvq_wpvqSettings_ads_section' 
		);

		add_settings_field( 
			'wpvq_textarea_no_ads', 
			__("No ads for these quizzes :", 'wpvq'),
			'wpvq_textarea_no_ads_render', 
			'wpvqSettings_ads', 
			'wpvq_wpvqSettings_ads_section' 
		);

		/**
		 * Facebook API Section
		 */
		add_settings_section(
			'wpvq_wpvqSettings_section', 
			'<a name="facebook"></a><div style="height:25px;"></div><span class="dashicons dashicons-facebook"></span> ' . __( 'Enable Facebook Share Button', 'wpvq' ), 
			'wpvq_settings_section_callback', 
			'wpvqSettings_facebookApi'
		);

		add_settings_field( 
			'wpvq_text_field_facebook_appid', 
			__('Your Facebook APP ID', 'wpvq'),
			'wpvq_text_field_facebook_appid_render', 
			'wpvqSettings_facebookApi', 
			'wpvq_wpvqSettings_section' 
		);

		add_settings_field( 
			'wpvq_checkbox_facebook_no_api', 
			__("Don't use Facebook API", 'wpvq'),
			'wpvq_checkbox_facebook_no_api_render', 
			'wpvqSettings_facebookApi', 
			'wpvq_wpvqSettings_section' 
		);

		add_settings_field( 
			'wpvq_checkbox_facebook_already_api', 
			__("Facebook SDK already included", 'wpvq'),
			'wpvq_checkbox_facebook_already_api_render', 
			'wpvqSettings_facebookApi', 
			'wpvq_wpvqSettings_section' 
		);

		/**
		 * Social Networking Section
		 */
		add_settings_section(
			'wpvq_wpvqSettings_networking_section_update', 
			'<a name="social"></a><div style="height:25px;"></div><span class="dashicons dashicons-share"></span> ' . __( 'Social Networking Options', 'wpvq' ), 
			'wpvq_settings_networking_section_callback', 
			'wpvqSettings_socialNetworks'
		);

		add_settings_field( 
			'wpvq_checkbox_enable_networking', 
			__('Display button for :', 'wpvq'),
			'wpvq_checkbox_enable_networking_render', 
			'wpvqSettings_socialNetworks', 
			'wpvq_wpvqSettings_networking_section_update' 
		);

		add_settings_field( 
			'wpvq_text_field_twitterhashtag', 
			__('Which Twitter hashtag do you want to use:', 'wpvq'),
			'wpvq_text_field_twitterhashtag_render', 
			'wpvqSettings_socialNetworks', 
			'wpvq_wpvqSettings_networking_section_update' 
		);

		add_settings_field( 
			'wpvq_text_field_twittermention', 
			__('Which Twitter @mention do you want to use:', 'wpvq'),
			'wpvq_text_field_twittermention_render', 
			'wpvqSettings_socialNetworks', 
			'wpvq_wpvqSettings_networking_section_update' 
		);

		/**
		 * Share box settings PERSONALITY
		 */
		add_settings_section(
			'wpvq_wpvqSettings_networking_sharebox_settings_PERSO', 
			'<a name="sharebox"></a><div id="wpvqsharebox" style="height:25px;"></div><span class="dashicons dashicons-format-status"></span> ' . __( 'Social Media Sharebox Settings ', 'wpvq' ) .' '. __('<span class="vq-badge vq-badge-primary">For Personality Quiz</span>', 'wpvq'), 
			'wpvq_settings_sharebox_section_PERSO_callback', 
			'wpvqSettings_sharePersonality'
		);

		add_settings_field( 
			'wpvq_text_field_share_local_PERSO', 
			__('Text on your page<br />(below the quiz) :', 'wpvq'),
			'wpvq_text_field_share_local_PERSO_render', 
			'wpvqSettings_sharePersonality', 
			'wpvq_wpvqSettings_networking_sharebox_settings_PERSO' 
		);

		add_settings_field( 
			'wpvq_text_field_share_simple_PERSO', 
			__('Content for Twitter :', 'wpvq'),
			'wpvq_text_field_share_simple_PERSO_render', 
			'wpvqSettings_sharePersonality', 
			'wpvq_wpvqSettings_networking_sharebox_settings_PERSO' 
		);

		add_settings_field( 
			'wpvq_text_field_share_facebook_title_PERSO', 
			__('Content for Facebook Title :', 'wpvq'),
			'wpvq_text_field_share_facebook_title_PERSO_render', 
			'wpvqSettings_sharePersonality', 
			'wpvq_wpvqSettings_networking_sharebox_settings_PERSO' 
		);

		add_settings_field( 
			'wpvq_text_field_share_facebook_desc_PERSO', 
			__('Content for Facebook Description :', 'wpvq'),
			'wpvq_text_field_share_facebook_desc_PERSO_render', 
			'wpvqSettings_sharePersonality', 
			'wpvq_wpvqSettings_networking_sharebox_settings_PERSO' 
		);

		/**
		 * Share box settings TRIVIA
		 */
		add_settings_section(
			'wpvq_wpvqSettings_networking_sharebox_settings_TRIVIA', 
			'<div style="height:25px;"></div><span class="dashicons dashicons-format-status"></span> ' . __( 'Social Media Sharebox Settings ', 'wpvq' ) .' '. __('<span class="vq-badge vq-badge-primary">For TrueFalse Quiz</span>', 'wpvq'), 
			'wpvq_settings_sharebox_section_TRIVIA_callback', 
			'wpvqSettings_shareTrivia'
		);


		add_settings_field( 
			'wpvq_text_field_share_local_TRIVIA', 
			__('Text on your page<br />(below the quiz) :', 'wpvq'),
			'wpvq_text_field_share_local_TRIVIA_render', 
			'wpvqSettings_shareTrivia', 
			'wpvq_wpvqSettings_networking_sharebox_settings_TRIVIA' 
		);

		add_settings_field( 
			'wpvq_text_field_share_simple_TRIVIA', 
			__('Content for Twitter :', 'wpvq'),
			'wpvq_text_field_share_simple_TRIVIA_render', 
			'wpvqSettings_shareTrivia', 
			'wpvq_wpvqSettings_networking_sharebox_settings_TRIVIA' 
		);

		add_settings_field( 
			'wpvq_text_field_share_facebook_title_TRIVIA', 
			__('Content for Facebook Title :', 'wpvq'),
			'wpvq_text_field_share_facebook_title_TRIVIA_render', 
			'wpvqSettings_shareTrivia', 
			'wpvq_wpvqSettings_networking_sharebox_settings_TRIVIA' 
		);

		add_settings_field( 
			'wpvq_text_field_share_facebook_desc_TRIVIA', 
			__('Content for Facebook Description :', 'wpvq'),
			'wpvq_text_field_share_facebook_desc_TRIVIA_render', 
			'wpvqSettings_shareTrivia', 
			'wpvq_wpvqSettings_networking_sharebox_settings_TRIVIA' 
		);

		/**
		 * Auto-update Section
		 */
		add_settings_section(
			'wpvq_wpvqSettings_section_update', 
			'<a name="update"></a><div style="height:25px;"></div><span class="dashicons dashicons-update"></span> ' . __( 'Enable Auto Update', 'wpvq' ), 
			'wpvq_settings_update_section_callback', 
			'wpvqSettings_autoUpdate'
		);

		add_settings_field( 
			'wpvq_text_field_facebook_appid', 
			__('Your Envato Purchase Code :', 'wpvq'),
			'wpvq_text_field_envato_code_render', 
			'wpvqSettings_autoUpdate', 
			'wpvq_wpvqSettings_section_update' 
		);

		/**
		 * Under the hood
		 */
		add_settings_section(
			'wpvq_wpvqSettings_section_underthehood', 
			'<a name="hood"></a><div style="height:25px;"></div><span class="dashicons dashicons-hammer"></span> ' . __( 'Under the Hood', 'wpvq' ), 
			'wpvq_settings_underthehood_callback', 
			'wpvqSettings_underTheHood'
		);

		add_settings_field( 
			'wpvq_checkbox_noresize_gif', 
			__("Don't resize GIF picture", 'wpvq'),
			'wpvq_checkbox_noresize_gif_render', 
			'wpvqSettings_underTheHood', 
			'wpvq_wpvqSettings_section_underthehood' 
		);

		add_settings_field( 
			'wpvq_checkbox_backoffice_miniature', 
			__("Display links instead of pictures (backoffice)", 'wpvq'),
			'wpvq_checkbox_backoffice_miniature_render', 
			'wpvqSettings_underTheHood', 
			'wpvq_wpvqSettings_section_underthehood' 
		);

		add_settings_field( 
			'wpvq_checkbox_do_minify', 
			__("Allow minified files", 'wpvq'),
			'wpvq_checkbox_do_minify_render', 
			'wpvqSettings_underTheHood', 
			'wpvq_wpvqSettings_section_underthehood' 
		);

		add_settings_field( 
			'wpvq_checkbox_disable_playersLogs', 
			__("Disable players logs", 'wpvq'),
			'wpvq_checkbox_disable_playersLogs_render', 
			'wpvqSettings_underTheHood', 
			'wpvq_wpvqSettings_section_underthehood' 
		);

		add_settings_field( 
			'wpvq_input_scroll_top_offset', 
			__("Auto Scroll Offset", 'wpvq'),
			'wpvq_input_scroll_top_offset_render', 
			'wpvqSettings_underTheHood', 
			'wpvq_wpvqSettings_section_underthehood' 
		);

		add_settings_field( 
			'wpvq_input_scroll_top_offset_mobile', 
			__("Auto Scroll Offset (for Mobile)", 'wpvq'),
			'wpvq_input_scroll_top_offset_mobile_render', 
			'wpvqSettings_underTheHood', 
			'wpvq_wpvqSettings_section_underthehood' 
		);

		add_settings_field( 
			'wpvq_textarea_custom_css', 
			__("Custom CSS code", 'wpvq'),
			'wpvq_textarea_custom_css_render', 
			'wpvqSettings_underTheHood', 
			'wpvq_wpvqSettings_section_underthehood' 
		);

	}

	/**
	 * ------------------------------------
	 * 			RENDER FUNCTIONS
	 * ------------------------------------
	 */
	
	// Section Title Callback
	function wpvq_settings_general_section_callback() {
		
	}


	// Auto-scroll next checkbox
	function wpvq_checkbox_autoscroll_next_render() { 
		$options = get_option( 'wpvq_settings' );
		?>
			<label for="wpvq_checkbox_autoscroll_next">
				<input type="checkbox" id="wpvq_checkbox_autoscroll_next" name='wpvq_settings[wpvq_checkbox_autoscroll_next]' <?php if(isset($options['wpvq_checkbox_autoscroll_next']) && $options['wpvq_checkbox_autoscroll_next'] == 1): ?>checked="checked"<?php endif; ?> value="1" />
				<?php _e("Auto-scroll to the next question each time someone click an answer.", 'wpvq'); ?>
			</label>
		<?php
	}


	// Scroll Speed Input
	function wpvq_input_scroll_speed_render() { 
		$options = get_option( 'wpvq_settings' );
		$speed = (isset($options['wpvq_input_scroll_speed']) && !empty($options['wpvq_input_scroll_speed'])) ? $options['wpvq_input_scroll_speed']:WPVQ_SCROLL_SPEED;
		?>
			<label for="wpvq_input_scroll_speed">
				<input type="text" name="wpvq_settings[wpvq_input_scroll_speed]" id="wpvq_input_scroll_speed" value="<?php echo $speed; ?>" style="width:80px; text-align:center;" />
				Default is 750, and it's pretty nice.
			</label>
		<?php
	}

	// Allow subscribers
	function wpvq_checkbox_allow_subscribers_render() { 
		$options = get_option( 'wpvq_settings' );
		?>
			<label for="checkbox_allow_subscribers">
				<input type="checkbox" id="checkbox_allow_subscribers" name='wpvq_settings[checkbox_allow_subscribers]' <?php if(isset($options['checkbox_allow_subscribers']) && $options['checkbox_allow_subscribers'] == 1): ?>checked="checked"<?php endif; ?> value="1" />
				<?php _e("Allow subscribers role to create quizzes", 'wpvq'); ?>
			</label>
		<?php
	}

	// --------------------------------------------------
	
	// Section Multi Pages
	function wpvq_settings_multipages_section_callback() { 
		_e( "Configure your multipages quizzes easily. To understand how to create a multipages quiz,", 'wpvq');
		echo ' <a href="https://www.ohmyquiz.io/knowledgebase/create-multi-pages-quiz/" target="_blank">';
		_e("click here.", 'wpvq');
		echo "</a>";
	}

	// Display progress bar
	function wpvq_select_show_progressbar_render() 
	{ 
		$options = get_option( 'wpvq_settings' );

		// Deprecated option (only on v1.60)
		if(!isset($options['wpvq_select_show_progressbar'])) {
			$show = 'below';
		} else {
			$show = (isset($options['wpvq_select_show_progressbar'])) ? $options['wpvq_select_show_progressbar']:'hide';
		}

		?>
			<label for="wpvq_select_show_progressbar">
				<select id="wpvq_select_show_progressbar" name='wpvq_settings[wpvq_select_show_progressbar]'>
					<option <?php if($show == 'hide'): ?>selected<?php endif; ?> value="hide"><?php _e("Hide progressbar", 'wpvq'); ?></option>
					<option <?php if($show == 'above'): ?>selected<?php endif; ?> value="above"><?php _e("Display above the quiz", 'wpvq'); ?></option>
					<option <?php if($show == 'below'): ?>selected<?php endif; ?> value="below"><?php _e("Display below the quiz", 'wpvq'); ?></option>
					<option <?php if($show == 'both'): ?>selected<?php endif; ?> value="both"><?php _e("Display above and below", 'wpvq'); ?></option>
				</select>
			</label>
		<?php
	}

	// Progress bar content
	function wpvq_select_content_progressbar_render() { 
		$options = get_option( 'wpvq_settings' );
		$content = (isset($options['wpvq_select_content_progressbar'])) ? $options['wpvq_select_content_progressbar']:'percentage';
		?>
			<label for="wpvq_select_content_progressbar">
				<select name="wpvq_settings[wpvq_select_content_progressbar]" id="wpvq_select_content_progressbar">
					<option value="none" <?php echo ($content=='none') ? 'selected':''; ?>><?php _e("Leave blank", 'wpvq'); ?></option>
					<option value="percentage" <?php echo ($content=='percentage') ? 'selected':''; ?>><?php _e("Show progress percentage (ex: 70%)", 'wpvq'); ?></option>
					<option value="page" <?php echo ($content=='page') ? 'selected':''; ?>><?php _e("Show progress page per page (ex: page 7/10)", 'wpvq'); ?></option>
				</select>
			</label>
		<?php
	}

	// Progress bar color picker
	function wpvq_input_progressbar_color_render() { 
		$options = get_option( 'wpvq_settings' );
		$color = (isset($options['wpvq_input_progressbar_color'])) ? $options['wpvq_input_progressbar_color']:WPVQ_PROGRESSBAR_COLOR;
		?>
			<label for="wpvq_input_progressbar_color">
				<input type="text" name="wpvq_settings[wpvq_input_progressbar_color]" id="wpvq_input_progressbar_color" value="<?php echo $color; ?>" />
			</label>
		<?php
	}

	// Progress bar color picker
	function wpvq_input_wait_trivia_page_render() { 
		$options = get_option( 'wpvq_settings' );
		$wait = (isset($options['wpvq_input_wait_trivia_page']) && is_numeric($options['wpvq_input_wait_trivia_page'])) ? $options['wpvq_input_wait_trivia_page']:WPVQ_WAIT_TRIVIA_PAGE;
		?>
			<label for="wpvq_input_wait_trivia_page">
				<input name="wpvq_settings[wpvq_input_wait_trivia_page]" id="wpvq_input_wait_trivia_page" type="number" value="<?php echo $wait; ?>" style="width:80px; text-align:center;" />
				<?php _e("With no pause, people won't see if they are right or wrong <strong>(TriviaQuiz only)</strong>.", 'wpvq'); ?>
			</label>
		<?php
	}


	// --------------------------------------------------
	
	// Section Ads Pages
	function wpvq_wpvqSettings_ads_section_callback() { 
		_e( "You can <strong>put some ads above and below each of your quizzes</strong>. Just copy and paste the HTML code of your ads in the field below.", 'wpvq');
		echo " ";
		_e("If you don't want to display ads for some quizzes, put their ID in the \"no ads\" field (comma separated).", 'wpvq');
		?>
			<p class="wpvq-protip"><?php _e("<strong>You can also configure specific content quiz by quiz</strong>, when building your quiz. Look for the “ads and content” settings section on the building page.", 'wpvq'); ?>.</p>
		<?php

	}

	// Top ads before quiz
	function wpvq_textarea_ads_top_render() 
	{ 
		$options = get_option( 'wpvq_settings' );
		$code = (isset($options['wpvq_textarea_ads_top'])) ? $options['wpvq_textarea_ads_top']:'';

		?>
			<textarea name="wpvq_settings[wpvq_textarea_ads_top]" id="wpvq_settings[wpvq_textarea_ads_top]" cols="55" rows="5"><?php echo $code; ?></textarea>
		<?php
	}

	// Bottom ads after quiz
	function wpvq_textarea_ads_bottom_render() {
		$options = get_option( 'wpvq_settings' );
		$code = (isset($options['wpvq_textarea_ads_bottom'])) ? $options['wpvq_textarea_ads_bottom']:'';

		?>
			<textarea name="wpvq_settings[wpvq_textarea_ads_bottom]" id="wpvq_settings[wpvq_textarea_ads_bottom]" cols="55" rows="5"><?php echo $code; ?></textarea>
		<?php
	}

	// Below results bloc
	function wpvq_textarea_ads_results_above_render() {
		$options = get_option( 'wpvq_settings' );
		$code = (isset($options['wpvq_textarea_ads_results_above'])) ? $options['wpvq_textarea_ads_results_above']:'';

		?>
			<textarea name="wpvq_settings[wpvq_textarea_ads_results_above]" id="wpvq_settings[wpvq_textarea_ads_results_above]" cols="55" rows="5"><?php echo $code; ?></textarea>
		<?php
	}

	// In the results bloc
	function wpvq_textarea_ads_results_content_render() {
		$options = get_option( 'wpvq_settings' );
		$code = (isset($options['wpvq_textarea_ads_results_content'])) ? $options['wpvq_textarea_ads_results_content']:'';

		?>
			<textarea name="wpvq_settings[wpvq_textarea_ads_results_content]" id="wpvq_settings[wpvq_textarea_ads_results_content]" cols="55" rows="5"><?php echo $code; ?></textarea>
		<?php
	}

	// Progress bar content
	function wpvq_textarea_no_ads_render() {
		$options = get_option( 'wpvq_settings' );
		$ignoreList = (isset($options['wpvq_textarea_no_ads'])) ? $options['wpvq_textarea_no_ads']:'';

		?>
			<input type="text" name="wpvq_settings[wpvq_textarea_no_ads]" id="wpvq_settings[wpvq_textarea_no_ads]" value="<?php echo $ignoreList; ?>" placeholder="Ex : 12,18,94" />
		<?php
	}

	// -------------------------------------------

	// Section Facebook Configure
	function wpvq_settings_section_callback() { 
		_e( "To enable the Facebook share button, you have to create a Facebook App with your Facebook account. Don't panic, <strong>it's VERY easy</strong>.", 'wpvq');
		echo '<br /><a href="https://www.ohmyquiz.io/knowledgebase/configure-facebook-share-button/" target="_blank">'; 
		_e('Click here to understand how to create a Facebook App.', 'wpvq' );
		echo '</a>';
	}
	
	// Input Facebook App ID
	function wpvq_text_field_facebook_appid_render() { 
		$options = get_option( 'wpvq_settings' );
		?>
			<input type='text' id="wpvq_text_field_facebook_appid" name='wpvq_settings[wpvq_text_field_facebook_appid]' value='<?php echo (isset($options['wpvq_text_field_facebook_appid'])) ? $options['wpvq_text_field_facebook_appid']:''; ?>' <?php if(isset($options['wpvq_checkbox_facebook_no_api']) && $options['wpvq_checkbox_facebook_no_api'] == 1 || isset($options['wpvq_checkbox_facebook_already_api']) && $options['wpvq_checkbox_facebook_already_api'] == 1): ?>disabled<?php endif; ?>>
		<?php
	}

	// Checkbox No API
	function wpvq_checkbox_facebook_no_api_render() { 
		$options = get_option( 'wpvq_settings' );
		?>
			<label for="wpvq_checkbox_facebook_no_api">
				<input type="checkbox" id="wpvq_checkbox_facebook_no_api" name='wpvq_settings[wpvq_checkbox_facebook_no_api]' <?php if(isset($options['wpvq_checkbox_facebook_no_api']) && $options['wpvq_checkbox_facebook_no_api'] == 1): ?>checked="checked"<?php endif; ?> value="1" />
				<?php _e("We do not recommend it, check this box if you know what you are doing.", 'wpvq'); ?>
			</label>
		<?php
	}

	// Checkbox API Already loaded
	function wpvq_checkbox_facebook_already_api_render() { 
		$options = get_option( 'wpvq_settings' );
		?>
			<label for="wpvq_checkbox_facebook_already_api">
				<input type="checkbox" id="wpvq_checkbox_facebook_already_api" name='wpvq_settings[wpvq_checkbox_facebook_already_api]' <?php if(isset($options['wpvq_checkbox_facebook_already_api']) && $options['wpvq_checkbox_facebook_already_api'] == 1): ?>checked="checked"<?php endif; ?> value="1" />
				<?php _e("Check if FB SDK is already included on your site. Ignore it if you don't understand.", 'wpvq'); ?>
			</label>
		<?php
	}

	// -------------------------------------------

	// Networking Callback (Enable network, ....)
	function wpvq_settings_networking_section_callback() { 
		_e( "What share buttons do you want to display below the quiz results?", 'wpvq');
		echo "<br/>";
		_e("If you don't want to display share buttons under a particular quiz, you can disable them when you create your quiz.", 'wpvq');
	}

	// Enable/disable share buttons
	function wpvq_checkbox_enable_networking_render() {
		$options 		=  get_option( 'wpvq_settings' );
		$networksRaw 	=  isset($options['wpvq_checkbox_enable_networking']) ? $options['wpvq_checkbox_enable_networking']:'facebook|twitter|googleplus';
		$networks 		=  explode('|', $networksRaw);
		?>
			<label style="margin-right:10px;"><input type="checkbox" name="wpvq_settings[wpvq_checkbox_enable_networking][]" value="facebook" <?php echo (in_array('facebook', $networks)) ? 'checked':''; ?> /> Facebook</label>
			<label style="margin-right:10px;"><input type="checkbox" name="wpvq_settings[wpvq_checkbox_enable_networking][]" value="twitter" <?php echo (in_array('twitter', $networks)) ? 'checked':''; ?> /> Twitter</label>
			<label style="margin-right:10px;"><input type="checkbox" name="wpvq_settings[wpvq_checkbox_enable_networking][]" value="googleplus" <?php echo (in_array('googleplus', $networks)) ? 'checked':''; ?> /> Google+</label>
			<label style="margin-right:10px;"><input type="checkbox" name="wpvq_settings[wpvq_checkbox_enable_networking][]" value="vk" <?php echo (in_array('vk', $networks)) ? 'checked':''; ?> /> VK</label>
		<?php
	}

	// Twitter Hashtag
	function wpvq_text_field_twitterhashtag_render() {
		$options 		=  get_option( 'wpvq_settings' );
		$twitterHashtag =  (isset($options['wpvq_text_field_twitterhashtag'])) ? $options['wpvq_text_field_twitterhashtag']:WPVQ_TWITTER_HASHTAG;
		?>
			<input type="text" value="<?php echo $twitterHashtag; ?>" name="wpvq_settings[wpvq_text_field_twitterhashtag]" />
		<?php
	}

	// Twitter Mention
	function wpvq_text_field_twittermention_render() {
		$options 		=  get_option( 'wpvq_settings' );
		$twitterMention =  (isset($options['wpvq_text_field_twittermention'])) ? $options['wpvq_text_field_twittermention']:'';
		?>
			<input type="text" value="<?php echo $twitterMention; ?>" name="wpvq_settings[wpvq_text_field_twittermention]" />
		<?php
	}

	// -------------------------------------------

	// Sharebox callback (what to display on share message) (PERSO)
	function wpvq_settings_sharebox_section_PERSO_callback() { 
		echo '<a href="'.plugins_url( 'views/img/share-content-big.jpg', __FILE__ ).'" target="_blank"><img src="'.plugins_url( 'views/img/share-content-small.jpg', __FILE__ ).'" class="wpvq-clicktozoom" /></a><br />';
		_e( "Configure share box content for Facebook and Twitter, when people share your quizzes. ", 'wpvq');
		echo "<br />";
		_e("Unfortunately, <strong>Google+ does not let us customize the text</strong> when sharing.", 'wpvq');
		echo "<ul class=\"wpvq-tags-list\">";
			echo "<li><strong>%%personality%%</strong> : ".__('will be replaced by the final result', 'wpvq')."</li>";
			echo "<li><strong>%%details%%</strong> : ".__('will be replaced by the personality description', 'wpvq')."</li>";
			echo "<li><strong>%%total%%</strong> : ".__('will be replaced by the number of questions', 'wpvq')."</li>";
			echo "<li><strong>%%quizname%%</strong> : ".__('will be replaced by the name of your quiz', 'wpvq')."</li>";
			// echo "<li><strong>%%quizlink%%</strong> : ".__('will be replaced by the url of the quiz', 'wpvq')."</li>";
		echo "</ul>";
	}

	// ————- Local display
	function wpvq_text_field_share_local_PERSO_render() {
		$options 		 =  get_option( 'wpvq_settings' );
		$localSharebox  =  (isset($options['wpvq_text_field_share_local_PERSO']) && !empty($options['wpvq_text_field_share_local_PERSO'])) ? $options['wpvq_text_field_share_local_PERSO']:WPVQ_SHARE_PERSO_LOCAL;
		?>
			<input type="text" value="<?php echo $localSharebox; ?>" name="wpvq_settings[wpvq_text_field_share_local_PERSO]" style="width:600px;" />
		<?php
	}

	// ————- Twitter and simple others
	function wpvq_text_field_share_simple_PERSO_render() {
		$options 		 =  get_option( 'wpvq_settings' );
		$simpleSharebox  =  (isset($options['wpvq_text_field_share_simple_PERSO']) && !empty($options['wpvq_text_field_share_simple_PERSO'])) ? $options['wpvq_text_field_share_simple_PERSO']:WPVQ_SHARE_PERSO_SIMPLE;
		?>
			<input type="text" value="<?php echo $simpleSharebox; ?>" name="wpvq_settings[wpvq_text_field_share_simple_PERSO]" style="width:600px;" />
		<?php
	}

	// ————- Facebook Title
	function wpvq_text_field_share_facebook_title_PERSO_render() {
		$options 		=  get_option( 'wpvq_settings' );
		$fbTitle 		=  (isset($options['wpvq_text_field_share_facebook_title_PERSO']) && !empty($options['wpvq_text_field_share_facebook_title_PERSO'])) ? $options['wpvq_text_field_share_facebook_title_PERSO']:WPVQ_SHARE_PERSO_FB_TITLE;
		?>
			<input type="text" value="<?php echo $fbTitle; ?>" name="wpvq_settings[wpvq_text_field_share_facebook_title_PERSO]" style="width:600px;" />
		<?php
	}

	// ————- Facebook Description
	function wpvq_text_field_share_facebook_desc_PERSO_render() {
		$options 		=  get_option( 'wpvq_settings' );
		$fbTitle 		=  (isset($options['wpvq_text_field_share_facebook_desc_PERSO']) && !empty($options['wpvq_text_field_share_facebook_desc_PERSO'])) ? $options['wpvq_text_field_share_facebook_desc_PERSO']:WPVQ_SHARE_PERSO_FB_DESC;
		?>
			<input type="text" value="<?php echo $fbTitle; ?>" name="wpvq_settings[wpvq_text_field_share_facebook_desc_PERSO]" style="width:600px;" />
		<?php
	}

	// Sharebox callback (TRIVIA)
	function wpvq_settings_sharebox_section_TRIVIA_callback() { 
		_e( "Same as the previous section, but for trivia quiz only.", 'wpvq');
		echo "<ul class=\"wpvq-tags-list\">";
			echo "<li><strong>%%score%%</strong> : ".__('will be replaced by the final score', 'wpvq')."</li>";
			echo "<li><strong>%%details%%</strong> : ".__('will be replaced by the appreciation', 'wpvq')."</li>";
			echo "<li><strong>%%total%%</strong> : ".__('will be replaced by the number of questions', 'wpvq')."</li>";
			echo "<li><strong>%%quizname%%</strong> : ".__('will be replaced by the name of your quiz', 'wpvq')."</li>";
			// echo "<li><strong>%%quizlink%%</strong> : ".__('will be replaced by the url of the quiz', 'wpvq')."</li>";
		echo "</ul>";
	}

	// Local display
	function wpvq_text_field_share_local_TRIVIA_render() {
		$options 		 =  get_option( 'wpvq_settings' );
		$localSharebox  =  (isset($options['wpvq_text_field_share_local_TRIVIA']) && !empty($options['wpvq_text_field_share_local_TRIVIA'])) ? $options['wpvq_text_field_share_local_TRIVIA']:WPVQ_SHARE_TRIVIA_LOCAL;
		?>
			<input type="text" value="<?php echo $localSharebox; ?>" name="wpvq_settings[wpvq_text_field_share_local_TRIVIA]" style="width:600px;" />
		<?php
	}

	// Twitter and G+ text
	function wpvq_text_field_share_simple_TRIVIA_render() {
		$options 		 =  get_option( 'wpvq_settings' );
		$simpleSharebox  =  (isset($options['wpvq_text_field_share_simple_TRIVIA']) && !empty($options['wpvq_text_field_share_simple_TRIVIA'])) ? $options['wpvq_text_field_share_simple_TRIVIA']:WPVQ_SHARE_TRIVIA_SIMPLE;
		?>
			<input type="text" value="<?php echo $simpleSharebox; ?>" name="wpvq_settings[wpvq_text_field_share_simple_TRIVIA]" style="width:600px;" />
		<?php
	}

	// Facebook Title
	function wpvq_text_field_share_facebook_title_TRIVIA_render() {
		$options 		=  get_option( 'wpvq_settings' );
		$fbTitle 		=  (isset($options['wpvq_text_field_share_facebook_title_TRIVIA']) && !empty($options['wpvq_text_field_share_facebook_title_TRIVIA'])) ? $options['wpvq_text_field_share_facebook_title_TRIVIA']:WPVQ_SHARE_TRIVIA_FB_TITLE;
		?>
			<input type="text" value="<?php echo $fbTitle; ?>" name="wpvq_settings[wpvq_text_field_share_facebook_title_TRIVIA]" style="width:600px;" />
		<?php
	}

	// Facebook Description
	function wpvq_text_field_share_facebook_desc_TRIVIA_render() {
		$options 		=  get_option( 'wpvq_settings' );
		$fbTitle 		=  (isset($options['wpvq_text_field_share_facebook_desc_TRIVIA']) && !empty($options['wpvq_text_field_share_facebook_desc_TRIVIA'])) ? $options['wpvq_text_field_share_facebook_desc_TRIVIA']:WPVQ_SHARE_TRIVIA_FB_DESC;
		?>
			<input type="text" value="<?php echo $fbTitle; ?>" name="wpvq_settings[wpvq_text_field_share_facebook_desc_TRIVIA]" style="width:600px;" />
		<?php
	}

	// -------------------------------------------

	// Section Title Callback (Update)
	function wpvq_settings_update_section_callback() { 
		_e( "To enable auto-update (very recommended), you have to put your Envato Purchase Code here.", 'wpvq');
		echo '<br /><a href="https://www.ohmyquiz.io/knowledgebase/enable-auto-update/" target="_blank">'; 
		_e('Click here to understand how to get your purchase code.', 'wpvq' );
		echo '</a>';
	}

	// Input Call Back (Envato App Purchase)
	function wpvq_text_field_envato_code_render() { 
		$options = get_option( 'wpvq_settings' );
		?>
			<input type='text' id="wpvq_text_field_envato_code" name='wpvq_settings[wpvq_text_field_envato_code]' value='<?php echo (isset($options['wpvq_text_field_envato_code'])) ? $options['wpvq_text_field_envato_code']:''; ?>' placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" style="width:300px;">
		<?php
	}

	// -------------------------------------------
	
	// Section Under The Hood
	function wpvq_settings_underthehood_callback() { 
		_e( "Complex or very specific settings. Ignore them if you don't need them.", 'wpvq');
	}

	// Gif resize disable
	function wpvq_checkbox_noresize_gif_render() {
		$options = get_option( 'wpvq_settings' );
		?>
			<label for="wpvq_checkbox_noresize_gif">
				<input type="checkbox" id="wpvq_checkbox_noresize_gif" name='wpvq_settings[wpvq_checkbox_noresize_gif]' <?php if(isset($options['wpvq_checkbox_noresize_gif'])): ?>checked="checked"<?php endif; ?> value="1" />
				<?php _e("Do not resize gif automatically on your quizzes (resize destroyes the animation)", 'wpvq'); ?>
			</label>
		<?php
	}

	// Gif resize disable
	function wpvq_checkbox_backoffice_miniature_render() {
		$options = get_option( 'wpvq_settings' );
		?>
			<label for="wpvq_checkbox_backoffice_miniature">
				<input type="checkbox" id="wpvq_checkbox_backoffice_miniature" name='wpvq_settings[wpvq_checkbox_backoffice_miniature]' <?php if(isset($options['wpvq_checkbox_backoffice_miniature'])): ?>checked="checked"<?php endif; ?> value="1" />
				<?php _e("Display links instead of pictures when building a quiz (faster to load for big quizzes)", 'wpvq'); ?>
			</label>
		<?php
	}

	// Disable minify protection system
	function wpvq_checkbox_do_minify_render() {
		$options = get_option( 'wpvq_settings' );
		?>
			<label for="wpvq_checkbox_do_minify">
				<input type="checkbox" id="wpvq_checkbox_do_minify" name='wpvq_settings[wpvq_checkbox_do_minify]' <?php if(isset($options['wpvq_checkbox_do_minify'])): ?>checked="checked"<?php endif; ?> value="1" />
				<?php _e("Check this box if you want to disable the anti-minify protection system", 'wpvq'); ?>
			</label>
		<?php
	}

	// Disable players logs
	function wpvq_checkbox_disable_playersLogs_render() {
		$options = get_option( 'wpvq_settings' );
		?>
			<label for="wpvq_checkbox_disable_playersLogs">
				<input type="checkbox" id="wpvq_checkbox_disable_playersLogs" name='wpvq_settings[wpvq_checkbox_disable_playersLogs]' <?php if(isset($options['wpvq_checkbox_disable_playersLogs'])): ?>checked="checked"<?php endif; ?> value="1" />
				<?php _e("Disable players logs, except when you ask a firstname/e-mail", 'wpvq'); ?>
			</label>
		<?php
	}

	// Scroll top offset
	function wpvq_input_scroll_top_offset_render() {
		$options = get_option( 'wpvq_settings' );
		$scrollTop = (isset($options['wpvq_input_scroll_top_offset']) && is_numeric($options['wpvq_input_scroll_top_offset'])) ? $options['wpvq_input_scroll_top_offset'] : WPVQ_SCROLL_OFFSET ; 
		?>
			<label for="wpvq_input_scroll_top_offset">
				<input type="number" id="wpvq_input_scroll_top_offset" name='wpvq_settings[wpvq_input_scroll_top_offset]' value='<?php echo $scrollTop; ?>' style="width:70px;text-align:center;"> px
			</label>
		<?php
	}

	// Scroll top offset (for Mobile)
	function wpvq_input_scroll_top_offset_mobile_render() {
		$options = get_option( 'wpvq_settings' );
		$scrollTop = (isset($options['wpvq_input_scroll_top_offset_mobile']) && is_numeric($options['wpvq_input_scroll_top_offset_mobile'])) ? $options['wpvq_input_scroll_top_offset_mobile'] : WPVQ_SCROLL_OFFSET ; 
		?>
			<label for="wpvq_input_scroll_top_offset_mobile">
				<input type="number" id="wpvq_input_scroll_top_offset_mobile" name='wpvq_settings[wpvq_input_scroll_top_offset_mobile]' value='<?php echo $scrollTop; ?>' style="width:70px;text-align:center;"> px
			</label>
		<?php
	}

	// Custom CSS editor
	function wpvq_textarea_custom_css_render() {
		$options 	=  get_option( 'wpvq_settings' );
		$css 		=  (isset($options['wpvq_textarea_custom_css'])) ? $options['wpvq_textarea_custom_css']:'';
		?>
			<style>
				textarea#wpvq_textarea_custom_css { 
					font-family: monospace; 
					background:#272822;
				    color:white;
				}
				textarea#wpvq_textarea_custom_css:focus { 
				 	outline: none !important;
				    box-shadow:none;
				}
			</style>
			<label for="wpvq_textarea_custom_css">
				<textarea name="wpvq_settings[wpvq_textarea_custom_css]" id="wpvq_textarea_custom_css" cols="60" rows="12"><?php echo $css; ?></textarea>
			</label>
		<?php
	}

	// -------------------------------------------	

	function wp_viral_quiz_options_page() { 

		$activeTab = (isset($_GET['tab'])) ? $_GET['tab'] : 'general';

		?>

		<div class="wrap">

			<div id="wpvq-fixed-settings-menu">
				<h3><?php _e("Need some help ?", 'wpvq'); ?></h3>
				<p>
					First, <a href="https://www.ohmyquiz.io/faq/" target="_blank">read the FAQ (click here) !</a>
					<br />You'll discover a lot of things and most of cases, <strong>your problem was already explained ! :)</strong></li>
				</p>
				<p>
					If you don't find any solution, <a href="https://www.ohmyquiz.io/support/" target="_blank">feel free to contact me</a>.
				</p>
			</div>

			<div class="vq-medium">
				<form action='options.php' method='post' class="wpvq-main-settings">
					<h2>WP Viral Quiz – <strong><?php _e("Settings", 'wpvq'); ?></strong></h2>
					<hr />

					<?php if( isset($_GET['settings-updated']) ) { ?>
					    <div id="message" class="updated" style="margin-left:0px;">
					        <p><strong><?php _e("Settings updated.", 'wpvq'); ?></strong></p>
					    </div>
					<?php } ?>

					<?php $activeTab = htmlentities((isset($_GET['tab'])) ? $_GET['tab']:'general'); ?>
					<?php $tab_url['general'] = esc_url(add_query_arg(array('tab' => 'general'))); ?>
					<?php $tab_url['multipages'] = esc_url(add_query_arg(array('tab' => 'multipages'))); ?>
					<?php $tab_url['ads'] = esc_url(add_query_arg(array('tab' => 'ads'))); ?>
					<?php $tab_url['facebookApi'] = esc_url(add_query_arg(array('tab' => 'facebookApi'))); ?>
					<?php $tab_url['socialNetworks'] = esc_url(add_query_arg(array('tab' => 'socialNetworks'))); ?>
					<?php $tab_url['sharePersonality'] = esc_url(add_query_arg(array('tab' => 'sharePersonality'))); ?>
					<?php $tab_url['shareTrivia'] = esc_url(add_query_arg(array('tab' => 'shareTrivia'))); ?>
					<?php $tab_url['autoUpdate'] = esc_url(add_query_arg(array('tab' => 'autoUpdate'))); ?>
					<?php $tab_url['underTheHood'] = esc_url(add_query_arg(array('tab' => 'underTheHood'))); ?>

					<h2 id="wpvq-navbar" class="nav-tab-wrapper">
						<a href="<?php echo $tab_url['general']; ?>" class="wpvq-tab-settings nav-tab <?php if($activeTab == 'general') echo 'nav-tab-active'; ?>" style="outline: 0px;"><i class="fa fa-cog"></i> <?php _e("General", 'wpvq'); ?></a>
						<a href="<?php echo $tab_url['ads']; ?>" class="wpvq-tab-settings nav-tab <?php if($activeTab == 'ads') echo 'nav-tab-active'; ?>" style="outline: 0px;"><i class="fa fa-money"></i> <?php _e("Ads Manager", 'wpvq'); ?></a>
						<a href="<?php echo $tab_url['facebookApi']; ?>" class="wpvq-tab-settings nav-tab <?php if($activeTab == 'facebookApi') echo 'nav-tab-active'; ?>" style="outline: 0px;"><i class="fa fa-facebook-official"></i> <?php _e("Configure Facebook", 'wpvq'); ?></a>
						<a href="<?php echo $tab_url['socialNetworks']; ?>" class="wpvq-tab-settings nav-tab <?php if($activeTab == 'socialNetworks') echo 'nav-tab-active'; ?>" style="outline: 0px;"><i class="fa fa-share-square"></i> <?php _e("Configure Sharing", 'wpvq'); ?></a>
					</h2>

					<h2 id="wpvq-navbar" class="nav-tab-wrapper">
						<a href="<?php echo $tab_url['multipages']; ?>" class="wpvq-tab-settings nav-tab <?php if($activeTab == 'multipages') echo 'nav-tab-active'; ?>" style="outline: 0px;"><i class="fa fa-columns"></i> <?php _e("Multipages Quizzes", 'wpvq'); ?></a>
						<a href="<?php echo $tab_url['sharePersonality']; ?>" class="wpvq-tab-settings nav-tab <?php if($activeTab == 'sharePersonality') echo 'nav-tab-active'; ?>" style="outline: 0px;"><i class="fa fa-users"></i> <?php _e("Customise Personality Quizzes", 'wpvq'); ?></a>
						<a href="<?php echo $tab_url['shareTrivia']; ?>" class="wpvq-tab-settings nav-tab <?php if($activeTab == 'shareTrivia') echo 'nav-tab-active'; ?>" style="outline: 0px;"><i class="fa fa-question-circle"></i> <?php _e("Customise Trivia Quizzes", 'wpvq'); ?></a>
					</h2>
					
					<h2 id="wpvq-navbar" class="nav-tab-wrapper">
						<a href="<?php echo $tab_url['autoUpdate']; ?>" class="wpvq-tab-settings nav-tab <?php if($activeTab == 'autoUpdate') echo 'nav-tab-active'; ?>" style="outline: 0px;"><i class="fa fa-refresh"></i> <?php _e("Enable Auto-update", 'wpvq'); ?></a>
						<a href="<?php echo $tab_url['underTheHood']; ?>" class="wpvq-tab-settings nav-tab <?php if($activeTab == 'underTheHood') echo 'nav-tab-active'; ?>" style="outline: 0px;"><i class="fa fa-wrench"></i> <?php _e("Under the Hood", 'wpvq'); ?></a>
					</h2>
						
					<!-- GENERAL -->
					<?php if ($activeTab != 'general'): ?><div style="display:none;"><?php endif; ?>
						<div class="wpvq-panel-options">
							<?php
								settings_fields( 'wpvqSettings_general' );
								do_settings_sections( 'wpvqSettings_general' );
							?>
						</div>
					<?php if ($activeTab != 'general'): ?></div><?php endif; ?>

					<!-- MULTIPAGES -->
					<?php if ($activeTab != 'multipages'): ?><div style="display:none;"><?php endif; ?>
						<div class="wpvq-panel-options">
							<?php
								settings_fields( 'wpvqSettings_multipages' );
								do_settings_sections( 'wpvqSettings_multipages' );
							?>
						</div>
					<?php if ($activeTab != 'multipages'): ?></div><?php endif; ?>

					<!-- ADS -->
					<?php if ($activeTab != 'ads'): ?><div style="display:none;"><?php endif; ?>
						<div class="wpvq-panel-options">
							<?php 
								settings_fields('wpvqSettings_ads');
								do_settings_sections('wpvqSettings_ads');
							?>
						</div>
					<?php if ($activeTab != 'ads'): ?></div><?php endif; ?>

					<!-- FACEBOOK API -->
					<?php if ($activeTab != 'facebookApi'): ?><div style="display:none;"><?php endif; ?>
						<div class="wpvq-panel-options">
							<?php 
								settings_fields('wpvqSettings_facebookApi');
								do_settings_sections('wpvqSettings_facebookApi');
							?>
						</div>
					<?php if ($activeTab != 'facebookApi'): ?></div><?php endif; ?>

					<!-- SOCIAL NETWORKS -->
					<?php if ($activeTab != 'socialNetworks'): ?><div style="display:none;"><?php endif; ?>
						<div class="wpvq-panel-options">
							<?php 
								settings_fields('wpvqSettings_socialNetworks');
								do_settings_sections('wpvqSettings_socialNetworks');
							?>
						</div>
					<?php if ($activeTab != 'socialNetworks'): ?></div><?php endif; ?>

					<!-- SHARE PERSO -->
					<?php if ($activeTab != 'sharePersonality'): ?><div style="display:none;"><?php endif; ?>
						<div class="wpvq-panel-options">
							<?php 
								settings_fields('wpvqSettings_sharePersonality');
								do_settings_sections('wpvqSettings_sharePersonality');
							?>
						</div>
					<?php if ($activeTab != 'sharePersonality'): ?></div><?php endif; ?>

					<!-- SHARE TRIVIA -->
					<?php if ($activeTab != 'shareTrivia'): ?><div style="display:none;"><?php endif; ?>
						<div class="wpvq-panel-options">
							<?php 
								settings_fields('wpvqSettings_shareTrivia');
								do_settings_sections('wpvqSettings_shareTrivia');
							?>
						</div>
					<?php if ($activeTab != 'shareTrivia'): ?></div><?php endif; ?>

					<!-- AUTO UPDATE -->
					<?php if ($activeTab != 'autoUpdate'): ?><div style="display:none;"><?php endif; ?>
						<div class="wpvq-panel-options">
							<?php 
								settings_fields('wpvqSettings_autoUpdate');
								do_settings_sections('wpvqSettings_autoUpdate');
							?>
						</div>
					<?php if ($activeTab != 'autoUpdate'): ?></div><?php endif; ?>

					<!-- UNDER THE HOOD -->
					<?php if ($activeTab != 'underTheHood'): ?><div style="display:none;"><?php endif; ?>
						<div class="wpvq-panel-options">
							<?php 
								settings_fields('wpvqSettings_underTheHood');
								do_settings_sections('wpvqSettings_underTheHood');
							?>
						</div>
					<?php if ($activeTab != 'underTheHood'): ?></div><?php endif; ?>

					<?php submit_button(); ?>
				</form>
			</div>
		</div>

		<?php
	}

	/**
	 * Validation callback function
	 * @param  array $input $_POST
	 * @return array        $_POST after computing
	 */
	function wpvq_settings_validate($input)
	{
		if(isset($input['wpvq_checkbox_enable_networking']))
		{
			$input['wpvq_checkbox_enable_networking'] = (!isset($input['wpvq_checkbox_enable_networking'])) ? array():$input['wpvq_checkbox_enable_networking'];
			$input['wpvq_checkbox_enable_networking'] = implode('|', $input['wpvq_checkbox_enable_networking']);
		}

		if (isset($input['wpvq_textarea_no_ads'])) 
		{
			$input['wpvq_textarea_no_ads'] = trim(str_replace(' ', '', $input['wpvq_textarea_no_ads']));
		}

		if (isset($input['wpvq_input_scroll_speed']) && (!is_numeric($input['wpvq_input_scroll_speed']) || $input['wpvq_input_scroll_speed'] == 0)) {
			$input['wpvq_input_scroll_speed'] = 750;
		}

		if (isset($input['wpvq_text_field_envato_code'])) {
			$input['wpvq_text_field_envato_code'] = trim($input['wpvq_text_field_envato_code']);
		}

		// Progress bar hexa code (default if failure)
		if (isset($input['wpvq_input_progressbar_color']) && !preg_match('/^#[0-9a-f]{3,6}$/i', $input['wpvq_input_progressbar_color'])) {
			$input['wpvq_input_progressbar_color'] = '#2bc253';
		}

		// Progress bar content (default if failure)
		if (isset($input['wpvq_select_content_progressbar']) && !in_array($input['wpvq_select_content_progressbar'], array('none', 'percentage', 'page'))) {
			$input['wpvq_select_content_progressbar'] = 'percentage';
		}

		return $input;
	}