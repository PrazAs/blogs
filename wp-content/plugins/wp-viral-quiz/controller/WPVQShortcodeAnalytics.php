<?php 

class WPVQShortcodeAnalytics {

	/** 
	 * Shortcode display Quiz's Results in front 
	*/
	public static function viralQuizAnalytics($param) 
	{
		global $wpdata;

		// Bad ID
		if (!is_numeric($param['id'])) {
			return;
		}

		// Load quizz
		$id  =  intval($param['id']);
		try {
			$type 	=  WPVQGame::getTypeById($id);
			$quiz 	=  new $type();
			$q 		=  $quiz->load($id, false);	
		} catch (Exception $e) {
			return __("ERROR : Quiz #{$param['id']} doesn't exist.", 'wpvq');
		}
		
		// Add a fake count ?
		$countPlayers = $q->countPlayersFromDB();
		if(isset($param['fake']) && is_numeric($param['fake'])) {
			$countPlayers += $param['fake'];
		}

		return $countPlayers;
	}

	/**
	 * Quiz main scripts
	 */
	public static function register_scripts() 
	{
	}

	/**
	 * Print script into the footer (if needed)
	 * @return [type] [description]
	 */
	public static function print_scripts()
	{
	}
}