<?php 

class WPVQShortcodeResults {

	public static $isShortcodeLoaded = false;
	public static $quiz = null;

	/** 
	 * Shortcode display Quiz's Results in front 
	*/
	public static function viralQuizResults() 
	{
		global $wpdata;

		// Data helpful to debug :
		// $array = array(
		// 	'quizId' => 98,
		// 	'resultValue' => 1,
		// );
		// echo base64_encode(json_encode($array));

		// No URL parameters
		if (!isset($_GET['wpvqdataresults'])) {
			return;
		}

		$results = json_decode(base64_decode($_GET['wpvqdataresults']), true);
		if (!is_array($results) || !isset($results['quizId']) || !isset($results['resultValue']) ) {
			return;
		}

		// Load quizz
		$id 	=  intval($results['quizId']);
		try {
			$type 	=  WPVQGame::getTypeById($id);
			$quiz 	=  new $type();
			$q 		=  $quiz->load($id, false);	
		} catch (Exception $e) {
			echo "ERROR : Quiz #{$param['id']} doesn't exist.";
			die();
		}

		// Useful to load JS script
		self::$isShortcodeLoaded 	=  true;
		self::$quiz 				=  $q;

		$wpdata['quiz'] = $q;
		$wpdata['type'] = $type;

		// Fetch results
		if ($type == 'WPVQGameTrueFalse') {
			$wpdata['results'] = json_decode(WPVQShortcode::getTrueFalseAppreciation($id, $results['resultValue']), true);
		} else if ($type == 'WPVQGamePersonality') {
			$wpdata['results'] = json_decode(WPVQShortcode::choosePersonality($results['resultValue']), true);
		}

		// Also keep the main value (score, personality, ...)
		$wpdata['results']['resultValue'] = $results['resultValue'];

		$shortCode = ob_start();
		include dirname(__FILE__) . '/../views/WPVQShortcodeResults.php';
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	/**
	 * Quiz main scripts
	 */
	public static function register_scripts() 
	{
		wp_register_script( 'wpvq-front', WPVQ_PLUGIN_URL . 'js/wpvq-front.js', array('jquery'), '1.0', true );
		wp_register_script( 'wpvq-front-results', WPVQ_PLUGIN_URL . 'js/wpvq-front-results.js', array('jquery', 'wpvq-front'), '1.0', true );
		wp_register_script( 'wpvq-facebook-api', WPVQ_PLUGIN_URL . 'js/wpvq-facebook-api.js', array('jquery'), '1.0', true );
	}

	/**
	 * Print script into the footer (if needed)
	 * @return [type] [description]
	 */
	public static function print_scripts()
	{
		if (self::$isShortcodeLoaded) 
		{
			// Frontend (UX)
			wp_enqueue_script( 'wpvq-front', WPVQ_PLUGIN_URL . 'js/wpvq-front.js', array('jquery'), '1.0', true );

			wp_enqueue_script( 'wpvq-front-results', WPVQ_PLUGIN_URL . 'js/wpvq-front-results.js', array('jquery', 'wpvq-front'), '1.0', true );

			// Facebook SDK (advanced share option)
			$wpvq_options 				=  get_option( 'wpvq_settings' );
			$wpvq_API_already_loaded 	=  (isset($wpvq_options['wpvq_checkbox_facebook_already_api'])) ? 'true':'false';
			$wpvq_dont_use_FBAPI 		=  (isset($wpvq_options['wpvq_checkbox_facebook_no_api'])) ? 'true':'false';
			$wpvq_facebookAppID 		=  (isset($wpvq_options['wpvq_text_field_facebook_appid'])) ? $wpvq_options['wpvq_text_field_facebook_appid']:'' ;
			$wpvq_facebookLink 			=  get_permalink();

			wp_localize_script( 'wpvq-facebook-api', 'wpvq_dont_use_FBAPI', $wpvq_dont_use_FBAPI );
			wp_localize_script( 'wpvq-facebook-api', 'wpvq_API_already_loaded', $wpvq_API_already_loaded );
			wp_localize_script( 'wpvq-facebook-api', 'wpvq_facebookAppID', $wpvq_facebookAppID );
			wp_enqueue_script( 'wpvq-facebook-api', WPVQ_PLUGIN_URL . 'js/wpvq-facebook-api.js', array('jquery'), '1.0', true );
		}
	}
}