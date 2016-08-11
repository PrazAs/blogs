<?php 

class WPVQShortcode {

	public static $isShortcodeLoaded = false;
	public static $quiz = null;

	/** 
	 * Shortcode display Quiz in front 
	 *
	 * @var 
	 * (int) id : quiz's id
	 *
	 * (int) columns : number of columns
	 *  
	*/
	public static function viralQuiz($param) 
	{
		global $wpdata;

		// Bad ID
		if (!is_numeric($param['id'])) {
			return;
		}

		// Show quiz only when on page
		if (!is_page() && !is_single()) {
			return;
		}

		// Load quizz
		$id 	=  intval($param['id']);
		try {
			$type 	=  WPVQGame::getTypeById($id);
			$quiz 	=  new $type();
			$q 		=  $quiz->load($id, true);	
		} catch (Exception $e) {
			echo "ERROR : Quiz #{$param['id']} doesn't exist.";
			die();
		}

		// Useful to load JS script
		self::$isShortcodeLoaded 	=  true;
		self::$quiz 				=  $q;

		$wpdata['quiz'] = $q;
		$wpdata['type'] = $type;

		if(isset($param['columns']) && is_numeric($param['columns'])) {
			$wpdata['columns'] = $param['columns'];
		} else {
			$wpdata['columns'] = 3;
		}

		$shortCode = ob_start();
		include dirname(__FILE__) . '/../views/WPVQShortcode.php';
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
			wp_localize_script( 'wpvq-front', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
			wp_localize_script( 'wpvq-front', 'wpvq_imgdir', WPVQ_PLUGIN_URL . 'views/img/' );
			wp_localize_script( 'wpvq-front', 'wpvq_i18n_loading_label', __('Loading', 'wpvq') );
			wp_enqueue_script( 'wpvq-front', WPVQ_PLUGIN_URL . 'js/wpvq-front.js', array('jquery'), '1.0', true );

			// Facebook SDK (advanced share option)
			$wpvq_options 				=  get_option( 'wpvq_settings' );
			$wpvq_API_already_loaded 	=  (isset($wpvq_options['wpvq_checkbox_facebook_already_api'])) ? 'true':'false';
			$wpvq_dont_use_FBAPI 		=  (isset($wpvq_options['wpvq_checkbox_facebook_no_api'])) ? 'true':'false';
			$wpvq_facebookAppID 		=  (isset($wpvq_options['wpvq_text_field_facebook_appid'])) ? $wpvq_options['wpvq_text_field_facebook_appid']:'' ;
			$wpvq_facebookLink 			=  get_permalink();
			$wpvq_forceFacebookShare 	=  (in_array('facebook', self::$quiz->getForceToShare())) ? 'true':'false';

			wp_localize_script( 'wpvq-facebook-api', 'wpvq_dont_use_FBAPI', $wpvq_dont_use_FBAPI );
			wp_localize_script( 'wpvq-facebook-api', 'wpvq_API_already_loaded', $wpvq_API_already_loaded );
			wp_localize_script( 'wpvq-facebook-api', 'wpvq_facebookAppID', $wpvq_facebookAppID );
			wp_localize_script( 'wpvq-facebook-api', 'wpvq_forceFacebookShare', $wpvq_forceFacebookShare);
			wp_enqueue_script( 'wpvq-facebook-api', WPVQ_PLUGIN_URL . 'js/wpvq-facebook-api.js', array('jquery'), '1.0', true );
		}
	}

	/**
	 * Trigger when player finishes a Trivia Quiz
	 * Can be used using the local parameters instead of ajax $_POST
	 * @return [type] [description]
	 */
	public static function getTrueFalseAppreciation($quizId=NULL, $score=NULL)
	{
		$local = false;
		if ((!isset($_POST['score']) || !is_numeric($_POST['score'])) || (!isset($_POST['quizId']) || !is_numeric($_POST['quizId']))) 
		{
			if (!$quizId || !$score) {
				die();
			}
			else {
				$_POST['score'] = $score;
				$_POST['quizId'] = $quizId;
				$local = true;
			}
		}

		// Debug mode : generate virtual lag
		// sleep(2);

		$score 			=  intval($_POST['score']);
		$quizId 		=  intval($_POST['quizId']);

		$appreciation 	=  WPVQAppreciation::getAppreciationByScore($quizId, $score);
		if ($appreciation == NULL) {
			return 0; // no appreciation set
		}

		$result 		=  array(
			'scoreCondition' 		=> $appreciation->getScoreCondition(),
			'appreciationContent'	=> do_shortcode(htmlspecialchars_decode(stripslashes($appreciation->getContent()))),
		);

		if ($local) {
			return json_encode($result);
		} else {
			print json_encode($result); die();
		}
	}

	/**
	 * Triggered when player finishes a Personality Quiz
	 * Can be used using the local parameter instead of Ajax $_POST
	 * @return [type] [description]
	 */
	public static function choosePersonality($weight=NULL) 
	{
		$local = false;
		if (!isset($_POST['weight']) || !is_numeric($_POST['weight'])) 
		{
			if (!$weight) {
				die();
			}
			else {
				$_POST['weight'] = $weight;
				$local = true;
			}
		}

		// Debug mode : generate virtual lag
		// sleep(2);
		
		// Fetch player answer / question
		$weight 		=  intval($_POST['weight']);
		$appreciation 	=  new WPVQAppreciation();
		$appreciation	=  $appreciation->load($weight);

		$result = array(
			'label' 	=> $appreciation->getLabel(), // string
			'content' 	=> do_shortcode(htmlspecialchars_decode(stripslashes($appreciation->getContent()))), // can be '' or HTML
		);

		if ($local) {
			return json_encode($result);
		} else {
			print json_encode($result); die();
		}
	}


	/**
	 * Triggered when player submit information (mail, nickname, ...)
	 * @return [type] [description]
	 */
	public static function submitInformations()
	{
		if (!isset($_POST['data'])) {
			die('nodata');
		}

		// WP options disable players logs
		$options = get_option( 'wpvq_settings' );
		$disablePlayersLogs = isset($options['wpvq_checkbox_disable_playersLogs']) ? true:false;

		// Parse jquery data
		$post = array();
		parse_str($_POST['data'], $post);
		// isset($post['beforeResults']) on natural tigger (not form validation, but quiz end)

		$nickname 	= sanitize_text_field( (isset($post['wpvq_askNickname'])) ? $post['wpvq_askNickname']:'');
		$email 		= sanitize_text_field( (isset($post['wpvq_askEmail'])) ? $post['wpvq_askEmail']:'');
		$result 	= sanitize_text_field( (isset($post['wpvq_ask_result'])) ? $post['wpvq_ask_result']:'');
		$quizId 	= intval($post['wpvq_quizId']);

		// Destroy seed (for random quiz only)
		if (!session_id()) { session_start(); }
		$_SESSION['wpvq_randomQuestionSeed_quiz' . $quizId] = 0;

		// If disable logs AND no nickname/email catching, don't save any logs
		if($disablePlayersLogs && $nickname == '' && $email == '') {
			die('nolog');
		}

		$type 	=  WPVQGame::getTypeById($quizId);
		$quiz 	=  new $type();
		$quiz 	=  $quiz->load($quizId);
		$meta 	=  $quiz->getMeta();

		// Don't save Anonymous Player if we save firstname/email on the next step
		$getInformations = $quiz->getAskInformations();
		if (!empty($getInformations) && isset($post['beforeResults'])) {
			return;
		}

		$players = new WPVQPlayers();
		$players = $players->load($quizId, false);

		$playerData = array(
			'nickname' 	=> $nickname,
			'email'		=> $email,
			'quizName'	=> $quiz->getName(),
			'result'	=> $result, );
		$playerId = $players->addPlayers($playerData);

		// Meta for Mailchimp
		if (isset($meta['mailchimp'])) {
			$mailingApi = new WPVQMailingAPI('mailchimp', $meta, $playerData);
		}

		// Meta for Aweber
		if (isset($meta['aweber'])) {
			$mailingApi = new WPVQMailingAPI('aweber', $meta, $playerData);
		}

		// Hook
		do_action('wpvq_add_player', $playerId, $playerData, $quizId, $post);
	}
}