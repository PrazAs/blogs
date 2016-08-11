<?php

define('WPVQ_PLAYERS_PER_PAGE', 50);

class WPVQPlayers {


	/**
	 * ----------------------------
	 * 		  ATTRIBUTS
	 * ----------------------------
	 */

	/**
	 * Quiz id of the request
	 * @var int
	 */
	private $quizId;

	/**
	 * Qui name
	 * @var [type]
	 */
	private $quizName;

	/**
	 * List of player (nickname => '', email => '', date => '', result => '' , 'meta' => '')
	 * @var array of array
	 */
	private $players;

	/**
	 * Results counter (for analytics)
	 * @var array ('result label 1' => X, 'result label 2' => Y)
	 */
	private $resultsCounter;

	/**
	 * Number of players pages
	 * @var int
	 */
	private $pagesCount;

	/**
	 * Number of players
	 * @var int
	 */
	private $playersCount;


	/**
	 * ----------------------------
	 * 		    GETTERS
	 * ----------------------------
	 */


	public function getQuizId() {
		return $this->quizId;
	}

	public function getQuizName() {
		return $this->quizName;
	}

	public function getPlayers() {
		return $this->players;
	}

	public function countPlayers() {
		return $this->playersCount;
	}

	public function getResultsCounter() {
		return $this->resultsCounter;
	}

	public function getPagesCount() {
		return $this->pagesCount;
	}

	function __construct()
	{
		$this->quizId 			=  0;
		$this->quizName 		=  '';
		$this->players 			=  array();
		$this->resultsCounter 	=  array();
		$this->pagesCount 		=  0;
		$this->playersCount 	=  0;
		
		return $this;
	}

	/**
	 * Load a question by ID
	 * @param  $loadPlayers Permet de ne pas perdre de temps à charger les joueurs si pas besoin.
	 * @return [type] [description]
	 */
	public function load($quizId, $loadPlayers = true, $page = 1)
	{
		global $wpdb;

		if (!is_numeric($quizId)) {
			throw new Exception("Need numeric quizID on players load ($quizId).");
		}

		$firstPos 	=  ($page-1) * WPVQ_PLAYERS_PER_PAGE;
		$lastPos 	=  $page * WPVQ_PLAYERS_PER_PAGE;
		

		$playersCount 			=  $wpdb->get_row($wpdb->prepare( 'SELECT COUNT(*) as count FROM ' . WPViralQuiz::getTableName('players') . ' WHERE quizId = %d', array(intval($quizId)) ));
		$this->playersCount		=  $playersCount->count;
		$this->pagesCount 		=  round($this->playersCount / WPVQ_PLAYERS_PER_PAGE);

		// Fetch quiz name
		$type = WPVQGame::getTypeById($quizId);
		$quiz = new $type();
		$quiz->load(intval($quizId));
		$this->quizName = $quiz->getName();

		// Fetch from DB
		$this->quizId  = $quizId;
		if ($loadPlayers)
		{
			if ($page == '*') {
				$row = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . WPViralQuiz::getTableName('players') . ' WHERE quizId = %d ORDER BY id DESC', array($quizId)));
			} else {
				$row = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . WPViralQuiz::getTableName('players') . ' WHERE quizId = %d ORDER BY id DESC LIMIT '.$firstPos.','.WPVQ_PLAYERS_PER_PAGE, array($quizId)));
			}

			
			foreach($row as $player) 
			{
				$newPlayer = array(
					'id'		=>  $player->id,
					'email' 	=>  $player->email,
					'quizName' 	=>  $this->quizName,
					'nickname' 	=>  $player->nickname,
					'result' 	=>  $player->result,
					'date' 		=>  $player->date,
					'meta'		=>  array(),
				);

				// Count results
				if (!isset($this->resultsCounter[$player->result])) {
					$this->resultsCounter[$player->result] = 1;
				} else {
					$this->resultsCounter[$player->result]++;
				}

				// Fetch meta (serialized in DB)
				if ($player->meta != NULL && $player->meta != '') 
				{
					$metaRaw 	=  $player->meta;
					$meta 		=  unserialize($metaRaw);
					if (!is_array($meta)) {
						continue; // malformed array
					}

					foreach($meta as $key => $value) {
						$newPlayer['meta'][$key] = $value;
					}
				}

				$this->players[] = $newPlayer;
			}

			// sort array
			arsort($this->resultsCounter);

		}

		return $this;
	}


	/**
	 * Add answer to the quizz
	 * @param array $param
	 * [
	 * 		label (string),
	 * 		pictureId (int),
	 * 		weight (int),
	 * 		content (string/html),
	 * ]
	 * @return id of player added
	 */
	public function addPlayers($param)
	{
		global $wpdb;

		if (!isset($param['nickname']) && !isset($param['email']) || !isset($param['result']) || !is_array($param)) {
			throw new Exception("Bad parameter(s) when adding player.", 1);
		}
		
		$dataSql = array(
			'quizId' 			=>  intval($this->quizId),
			'email' 			=>  $param['email'],
			'nickname' 			=>  $param['nickname'],
			'result' 			=>  $param['result'],
			'date' 				=>  time(),
		);

		$typeSql = array(
			'%d',
			'%s',
			'%s',
			'%s',
			'%d',
		);

		$wpdb->insert( WPViralQuiz::getTableName('players'), $dataSql, $typeSql );
		return $wpdb->insert_id;
	}

	/**
	 * Update meta fields for $playerId
	 * @param  int $playerId index of player
	 * @param  array $meta   an array of meta, serialized in the DB
	 * @return bool
	 */
	static public function updateMetaPlayer($playerId, $meta)
	{
		global $wpdb;
		$meta = serialize($meta);

		$dataSql = array('meta' => $meta);
		$typeSql = array('%s');

		$return = $wpdb->update( WPViralQuiz::getTableName('players'), $dataSql, array('id' => $playerId), $typeSql, array('%d') ) or die(mysql_error());

		return $return;
	}

}