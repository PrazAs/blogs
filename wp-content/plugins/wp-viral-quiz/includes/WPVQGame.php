<?php 

abstract class WPVQGame {

	/**
	 * ----------------------------
	 * 		  ATTRIBUTS
	 * ----------------------------
	 */

	/**
	 * ID
	 * @var int
	 */
	protected $id;

	/**
	 * Quiz Name
	 * @var string
	 */
	protected $name;

	/**
	 * WP Author Id
	 * @var int
	 */
	protected $authorId;

	/**
	 * Quiz creation date
	 * @var int (timestamp UNIX)
	 */
	protected $dateCreation;

	/**
	 * Quiz creation date
	 * @var int (timestamp UNIX)
	 */
	protected $dateUpdate;

	/**
	 * Questions object array
	 * @var Questions
	 */
	protected $questions;

	/**
	 * Appreciations based on score
	 * @var array of ::WPVQAppreciation
	 *
	 * For Personality Quiz :
	 * [
	 * 		0  => ( Object ), 
	 * 		1  => ( Object ), 
	 * 		2  => ( Object ),
	 * ]
	 *
	 * OR
	 *
	 * For TrueFalse Quiz :
	 * [
	 * 		10  => ( Object ), // if 10 or minus
	 * 		20  => ( Object ), // elseif 20 or minus
	 * 		30  => ( Object ), // elseif 30 or minus
	 * ]
	 */
	protected $appreciations;

	/** 
	 * Game score 
	 *
	 * For Personality Quiz (key = weighted values) :
	 * @var array [0 => X, 1 => Y, 2 => Z, ...]
	 *
	 * For TrueFalse Quiz :
	 * @var int 
	*/
	protected $score;


	/**
	 * Type of the quiz
	 * @var string
	 */
	protected $type;


	/**
	 * Show social share buttons / copyright
	 * @var bool
	 */
	protected $showSharing;
	protected $showCopyright;

	/**
	 * Informations labels to ask to people at the end
	 * @var array : empty, array('mail'), array('nickname'), array('mail', 'nickname')
	 */
	protected $askInformations;

	/**
	 * Force people to share to see their results ?
	 * @var array : empty, array('facebook'), array('facebook', 'twitter'), ...
	 */
	protected $forceToShare;

	/**
	 * CSS skin to use for this quiz
	 * @var [type]
	 */
	protected $skin;

	/**
	 * Random questions when playing ?
	 * -1  		=  disabled
	 * int 		=  show X questions
	 * 0 		=  ALL
	 * @var int
	 */
	protected $randomQuestions;

	/**
	 * Random answers when playing ?
	 * @var bool
	 */
	protected $isRandomAnswers;

	/**
	 * Meta options (array)
	 * @var [type]
	 */
	protected $meta;

	/**
	 * ExtraOptions (table ExtraOptions)
	 * @var [type]
	 */
	protected $extraOptions;


	/**
	 * ----------------------------
	 * 		    GETTERS
	 * ----------------------------
	 */
	
	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getAuthorId() {
		return $this->authorId;
	}

	/**
	 * Get the Nice name of a type (not the class name)
	 * @param  boolean $v2 if $v2=true, TrueFalse becomes Trivia
	 * @return [type]      [description]
	 */
	public function getNiceType($v2 = false) {
		$val = self::getNiceTypeFromClass($this->type, $v2);
		return $val;
	}

	static public function getNiceTypeFromClass($className, $v2 = false) {
		$val = str_replace('WPVQGame', '', $className);
		$val = ($v2) ? str_replace('TrueFalse', 'Trivia', $val) : $val;
		return $val;
	}

	public function getType() {
		return $this->type;
	}

	public function getShowSharing() {
		return $this->showSharing;
	}

	public function getShowCopyright() {
		return $this->showCopyright;
	}

	public function getAskInformations() {
		return array_filter($this->askInformations);
	}

	public function isAskInformationsOptional() {
		return in_array('optional', $this->askInformations);	
	}

	public function getForceToShare() {
		return $this->forceToShare;
	}

	public function getPageCounter() {
		$count = 1;
		foreach($this->questions as $question)
		{
			if ($question->isTherePageAfter()) {
				$count++;
			}
		}	

		return $count;
	}

	public function isRandomQuestions() {
		return ($this->randomQuestions > 0 && $this->randomQuestions != NULL);
	}

	public function getRandomQuestions() {
		// NULL = 0
		return ($this->randomQuestions == NULL) ? 0 : $this->randomQuestions;
	}

	public function isRandomAnswers() {
		return ($this->isRandomAnswers == 1 && $this->isRandomAnswers != NULL);
	}

	/**
	 * Info about informations to ask
	 * @return bool
	 */
	public function askEmail() { return (in_array('email', $this->askInformations)); }
	public function askNickname() { return (in_array('nickname', $this->askInformations)); }
	public function askSomething() { return !empty($this->askInformations); }


	/**
	 * Get the WP user for $this->authorId
	 * @return Object WP_User
	 */
	public function getUser() {
		return get_user_by('id', $this->authorId);
	}

	public function getDateCreation() {
		return $this->dateCreation;
	}

	public function getQuestions() {
		return $this->questions;
	}

	public function getAppreciations() {
		return $this->appreciations;
	}

	public function getScore() {
		return $this->score;
	}

	public function getSkin() {
		return $this->skin;
	}

	/**
	 * Return questions counter
	 * @return int
	 */
	public function countQuestions()
	{
		return count($this->questions);
	}

	/**
	 * Return the nb of question (not in the current quiz, but in the whole table)
	 * @return [type] [description]
	 */
	public function countQuestionsFromDB()
	{
		global $wpdb;
		$wpdb->get_results( 'SELECT * FROM ' . WPViralQuiz::getTableName('questions') . ' WHERE quizId = ' . $this->id );
		return $wpdb->num_rows;
	}

	/**
	 * Return the nb of players (via the DB, not the object Players. More efficient in some cases)
	 * @return [type] [description]
	 */
	public function countPlayersFromDB()
	{
		global $wpdb;
		$wpdb->get_results( 'SELECT * FROM ' . WPViralQuiz::getTableName('players') . ' WHERE quizId = ' . $this->id );
		return $wpdb->num_rows;
	}

	/**
	 * Return appreciations counter
	 * @return int
	 */
	public function countAppreciations()
	{
		return count($this->appreciations);
	}

	/**
	 * Return answers counter by question
	 * @return array (0 => 12, 1 => 8) 
	 *                   means :
	 *               (question 0 : 12 answers, question 1 : 8 answers)
	 */
	public function countAnswers($startAtOne=false)
	{
		$indexAnswers = array();
		foreach ($this->questions as $key => $question) {
			if($startAtOne) { $key++; }
			$count = count($question->getAnswers());
			$indexAnswers[$key] = $count;
		}

		return $indexAnswers;
	}

	/**
	 * Return the human time diff since creation date
	 * @return string eg. "3 days ago..."
	 */
	public function getNiceDateCreation() {
		return human_time_diff( $this->dateCreation );
	}

	/**
	 * Return the human time diff since update date
	 * @return string eg. "3 days ago..."
	 */
	public function getNiceDateUpdate() {
		return human_time_diff( $this->dateUpdate );
	}

	/**
	 * Return meta
	 * @return (mixed|array)
	 */
	public function getMeta($key=NULL) 
	{
		if ($key == NULL) {
			return $this->meta;
		} else {
			if (isset($this->meta[$key])) {
				return $this->meta[$key];
			} else {
				return null;
			}
		}
	}

	/**
	 * ==========================================
	 * 			EXTRA OPTIONS MANAGEMENT
	 * ==========================================
	 */

	/**
	 * Return option value (table extraOptions)
	 * @return [type] [description]
	 */
	static public function getExtraOption($quizId, $optionName)
	{
		global $wpdb;

		$row = $wpdb->get_row($wpdb->prepare('SELECT optionValue FROM ' . WPViralQuiz::getTableName('extraoptions') . ' WHERE quizId = %d AND optionName = \'%s\'', array($quizId, $optionName)));

		if (empty($row)) {
			return NULL;
		} else {
			return $row->optionValue;
		}
	}

	// Same as getExtraOption, but local context (using $this->id by default)
	public function _getExtraOption($optionName) {
		return self::getExtraOption($this->id, $optionName);
	}

	/**
	 * Update option value (table extraOptions)
	 * @return [type] [description]
	 */
	static public function updateExtraOption($quizId, $optionName, $optionValue)
	{
		global $wpdb;

		$dataSql = array('optionValue' => $optionValue);

		// If user empties the option
		if ($optionValue == '' || $optionValue == NULL)
		{
			$wpdb->delete( WPViralQuiz::getTableName('extraoptions'), array('quizId' => $quizId, 'optionName' => $optionName) );		
		}
		// If option doesn't exist yet
		else if (self::getExtraOption($quizId, $optionName) == NULL) 
		{
			$dataSql['quizId'] = $quizId;
			$dataSql['optionName'] = $optionName;
			$wpdb->insert( WPViralQuiz::getTableName('extraoptions'), $dataSql);
		}
		// Just update option
		else 
		{
			$wpdb->update( WPViralQuiz::getTableName('extraoptions'), $dataSql, array('quizId' => $quizId, 'optionName' => $optionName));
		}

		return true;
	}

	// Same as updateExtraOption, but local context (using $this->id by default)
	public function _updateExtraOption($optionName, $optionValue) {
		return self::updateExtraOption($this->id, $optionName, $optionValue);
	}

	/**
	 * Fetch all extraoptions for a quiz (fill $this->extraOptions)
	 * @return [type] [description]
	 */
	public function fetchAllExtraOptions()
	{
		global $wpdb;

		$row = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . WPViralQuiz::getTableName('extraoptions') . ' WHERE quizId = %d', $this->id));

		foreach($row as $value)
		{
			$optionName 	= $value->optionName;
			$optionValue 	= $value->optionValue;

			$this->extraOptions[$optionName] = $optionValue;
		}

		return $this->extraOptions;
	}

	/**
	 * Getters
	 */
	public function getExtraOptions() { return $this->extraOptions; }

	// Check the value of an extraOption
	static public function extraOptionIsTrue($extraOptions, $optionName) 
	{
		return (
			isset($extraOptions[$optionName]) && 
			$extraOptions[$optionName] != NULL && 
			$extraOptions[$optionName] != '' &&
			$extraOptions[$optionName] != '0'
		);
	}
	// Same as extraOptionIsTrue but local context (with $this->extraOptions by default)
	public function _extraOptionIsTrue($optionName) {
		return self::extraOptionIsTrue($this->extraOptions, $optionName);
	}


	/**
	 * ----------------------------
	 * 	  ABSTRACT 	METHODS
	 * ----------------------------
	 */
	
	abstract protected function getCurrentAppreciation();

	function __construct() {

		$this->id 				=  0;
		$this->name 			=  'Untitled Quiz';
		$this->authorId 		=  0;
		$this->dateCreation 	=  0;
		$this->dateUpdate 		=  0;
		$this->questions 		=  array();
		$this->appreciations 	=  array();
		$this->score 			=  0;
		$this->type 			=  '';
		$this->showSharing 		=  1;
		$this->showCopyright 	=  0;
		$this->askInformations  =  array();
		$this->forceToShare  	=  array();
		$this->skin 			=  'buzzfeed';
		$this->randomQuestions 	=  -1;
		$this->isRandomAnswers 	=  0;
		$this->meta 			=  array('playAgain' => 0, 'redirectionPage' => '', 'hideRightWrong' => 0);
		$this->extraOptions 	=  array();

	}

	/**
	 * Add a new quizz
	 * @param array $param
	 */
	public function add($param, $quizId = NULL) 
	{
		global $wpdb;

		// Use default parameter if $param[key] not set
		if(!isset($param['name'])) 				$param['name'] = $this->name;
		if(!isset($param['showSharing'])) 		$param['showSharing'] = $this->showSharing;
		if(!isset($param['showCopyright'])) 	$param['showCopyright'] = $this->showCopyright;
		if(!isset($param['skin'])) 				$param['skin'] = $this->skin;
		if(!isset($param['askInformations'])) 	$param['askInformations'] = $this->askInformations;
		if(!isset($param['forceToShare'])) 		$param['forceToShare'] = $this->forceToShare;
		if(!isset($param['randomQuestions'])) 	$param['randomQuestions'] = $this->randomQuestions;
		if(!isset($param['isRandomAnswers'])) 	$param['isRandomAnswers'] = $this->isRandomAnswers;
		if(!isset($param['meta'])) 				$param['meta'] = $this->meta;

		$this->name 	 		=  $param['name'];
		$this->type 	 		=  get_class($this);
		$this->authorId  		=  get_current_user_id();
		
		$this->showSharing  	=  $param['showSharing'];
		$this->showCopyright  	=  $param['showCopyright'];

		$this->askInformations  =  $param['askInformations'];
		$this->forceToShare  	=  $param['forceToShare'];
		
		$this->skin  			=  $param['skin'];

		$this->randomQuestions 	=  $param['randomQuestions'];
		$this->isRandomAnswers 	=  $param['isRandomAnswers'];
		
		$this->meta 			=  serialize($param['meta']);

		// Add new quizz
		if ($quizId == NULL || $quizId == "" || $quizId == 0)
		{
			$this->dateCreation  	=  time();
			$this->dateUpdate 		=  time();

			$dataSql = array(
				'type' 			=>  $this->type,
				'name' 			=>  $this->name,
				'authorId' 		=>  $this->authorId,
				'dateCreation' 	=>  $this->dateCreation,
				'dateUpdate' 	=>  $this->dateUpdate,
				'showSharing' 	=>  $this->showSharing,
				'showCopyright' =>  $this->showCopyright,
				'askInformations' 	=>  htmlspecialchars(implode(',', $this->askInformations)),
				'forceToShare' 		=>  htmlspecialchars(implode(',', $this->forceToShare)),
				'skin'				=>  $this->skin,
				'randomQuestions'	=>  $this->randomQuestions,
				'isRandomAnswers'	=>  $this->isRandomAnswers,
				'meta'				=>  $this->meta,
			);

			$typeSql = array(
				'%s',
				'%s',
				'%d',
				'%d',
				'%d',
				'%d',
				'%d',
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%s',
			);

			$wpdb->insert( WPViralQuiz::getTableName('quizzes'), $dataSql, $typeSql );
			$this->id = $wpdb->insert_id;
		}
		// Update
		else
		{
			$this->dateUpdate 		=  time();

			$dataSql = array(
				'name' 			=>  $this->name,
				'dateUpdate' 	=>  $this->dateUpdate,
				'showSharing' 	=>  $this->showSharing,
				'showCopyright' =>  $this->showCopyright,
				'askInformations' 	=>  htmlspecialchars(implode(',', $this->askInformations)),
				'forceToShare' 		=>  htmlspecialchars(implode(',', $this->forceToShare)),
				'skin'				=>  $this->skin,
				'randomQuestions'	=>  $this->randomQuestions,
				'isRandomAnswers'	=>  $this->isRandomAnswers,
				'meta'				=>  $this->meta,
			);

			$typeSql = array(
				'%s',
				'%d',
				'%d',
				'%d',
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%s',
			);

			$wpdb->update( WPViralQuiz::getTableName('quizzes'), $dataSql, array('ID' => $quizId), $typeSql, array('%d') );
			$this->id = $quizId;
		}

		return $this;
	}

	/**
	 * Add a question
	 * @param array $param
	 * [
	 * 		label (string),
	 * 		position (int),
	 * 		pictureId (int),
	 * 		content (string),
	 * ]
	 */
	public function addQuestion($param, $questionId = NULL) {

		global $wpdb;

		if (!isset($param['label']) || !isset($param['position']) || !isset($param['pictureId']) || !isset($param['content']) || !is_array($param)) {
			throw new Exception("Bad parameter(s) when adding question.", 1);
		}

		// Add new question
		if ($questionId == NULL || $questionId == "" || $questionId == 0) 
		{
			$dataSql = array(
				'label' 			=>  $param['label'],
				'quizId' 			=>  $this->id,
				'position' 			=>  $param['position'],
				'pictureId' 		=>  $param['pictureId'],
				'content' 			=>  $param['content'],
				'pageAfter' 		=>  $param['pageAfter'],
			);

			$typeSql = array(
				'%s',
				'%d',
				'%d',
				'%s',
				'%s',
				'%d',
			);

			$wpdb->insert( WPViralQuiz::getTableName('questions'), $dataSql, $typeSql );
			$questionId = $wpdb->insert_id;
		}
		// Update question
		else 
		{
			$dataSql = array(
				'label' 			=>  $param['label'],
				'position' 			=>  $param['position'],
				'pictureId' 		=>  $param['pictureId'],
				'content' 			=>  $param['content'],
				'pageAfter' 		=>  $param['pageAfter'],
			);

			$typeSql = array(
				'%s',
				'%d',
				'%s',
				'%s',
				'%d',
			);

			$wpdb->update( WPViralQuiz::getTableName('questions'), $dataSql, array('ID' => $questionId), $typeSql, array('%d'));
		}

		// Update questions list
		$this->questions = $this->fetchQuestions();

		$question = new WPVQQuestion();
		$question->load($questionId);
		return $question;
	}

	/**
	 * Add appreciation to the quizz
	 * @param array $param
	 * [
	 * 		label (string),
	 * 		content (int),
	 * 		scoreCondition (int),
	 * ]
	 */
	public function addAppreciation($param, $appreciationId = NULL)
	{
		global $wpdb;

		if (!isset($param['label']) || !isset($param['scoreCondition']) || !isset($param['content']) || !is_array($param)) {
			throw new Exception("Bad parameter(s) when adding appreciation.", 1);
		}

		// Add new appreciation
		if ($appreciationId == NULL || $appreciationId == '' || $appreciationId == 0)
		{
			$dataSql = array(
				'quizId' 			=>  $this->id,
				'label' 			=>  $param['label'],
				'content' 			=>  $param['content'],
				'scoreCondition' 	=>  $param['scoreCondition'],
			);

			$typeSql = array(
				'%d',
				'%s',
				'%s',
				'%d',
			);

			$wpdb->insert( WPViralQuiz::getTableName('appreciations'), $dataSql, $typeSql );
			$appreciationId = $wpdb->insert_id;
		}
		// Update appreciation
		else
		{
			$dataSql = array(
				'label' 			=>  $param['label'],
				'content' 			=>  $param['content'],
				'scoreCondition' 	=>  $param['scoreCondition'],
			);

			$typeSql = array(
				'%s',
				'%s',
				'%d',
			);

			$wpdb->update( WPViralQuiz::getTableName('appreciations'), $dataSql, array('ID' => $appreciationId), $typeSql, array('%d') );
		}
		

		// Update appreciations list
		$this->appreciations = $this->fetchAppreciations();

		$appr = new WPVQAppreciation();
		$appr->load($appreciationId);

		return $appr;
	}
	


	/**
	 * Load an existing game
	 * @param  int $id Game ID
	 * @return $this
	 */
	public function load($id, $gameplayContext=false) {

		global $wpdb;

		if (!is_numeric($id)) {
			throw new Exception("Need numeric ID on Game load.");
		}

		$row = $wpdb->get_row('SELECT * FROM ' . WPViralQuiz::getTableName('quizzes') . ' WHERE ID = ' . $id);
		if (empty($row)) {
			throw new Exception("Quizz $id doesn't exist.");
		}

		$this->id 				= $row->ID;
		$this->type 			= $row->type;
		$this->name 			= $row->name;
		$this->authorId 		= $row->authorId;
		$this->dateCreation 	= $row->dateCreation;
		$this->dateUpdate 		= $row->dateUpdate;

		$this->randomQuestions  	= $row->randomQuestions;
		$this->isRandomAnswers  	= $row->isRandomAnswers;

		$this->appreciations 	= $this->fetchAppreciations();
		$this->questions 		= $this->fetchQuestions($gameplayContext, $this->isRandomAnswers);
		
		$this->showSharing  	= $row->showSharing;
		$this->showCopyright  	= $row->showCopyright;
		
		$this->askInformations  = explode(',', $row->askInformations);
		$this->forceToShare  	= explode(',', $row->forceToShare);

		$this->skin 			= $row->skin;
		
		$this->meta 			= unserialize($row->meta);

		$this->fetchAllExtraOptions();

		return $this;
	}

	/**
	 * Returns array of appreciations for this game
	 * @return array of ::Appreciation
	 */
	private function fetchAppreciations() {
		global $wpdb;

		// Fetch from DB
		$row = $wpdb->get_results($wpdb->prepare('SELECT id FROM ' . WPViralQuiz::getTableName('appreciations') . ' WHERE quizId = %d', $this->id));

		// No appreciations
		if (empty($row)) {
			return array();
		}

		$appreciations = array();
		foreach($row as $appreciation) 
		{
			$app = new WPVQAppreciation();
			$app->load($appreciation->id);

			$appreciations[] = $app;
		}

		return $appreciations;
	}
	
	/**
	 * Returns array of Questions
	 * @return array of ::Questions
	 */
	private function fetchQuestions($gameplayContext=false, $randomAnswers=false)
	{
		global $wpdb;

		// Fetch from DB
		$row = $wpdb->get_results($wpdb->prepare('SELECT id FROM ' . WPViralQuiz::getTableName('questions') . ' WHERE quizId = %d ORDER BY position ASC', $this->id));

		// No questions
		if (empty($row)) {
			return array();
		}

		// Random specificities
		if ($this->isRandomQuestions() && $gameplayContext)
		{
			if (!session_id()) {
				@session_start(); // ugly :(
			}

			// Prevent from fetching same question if reloading page
			if (!isset($_SESSION['wpvq_random_quiz_' . $this->id])) {
				$_SESSION['wpvq_random_quiz_' . $this->id] = array();	
			}

			// If session contains ALL questions, then reset the algo
			if (count($_SESSION['wpvq_random_quiz_' . $this->id]) == $this->countQuestionsFromDB ()) {
				$_SESSION['wpvq_random_quiz_' . $this->id] = array();		
			}
		}
		
		// Fetch questions
		$questions = array();
		$alreadyPlayedQuestions = array(); // used for random questions
		foreach($row as $question) 
		{
			$que = new WPVQQuestion();
			$que->load($question->id, $gameplayContext, $randomAnswers);

			// Don't add question already played during previous game
			if ($this->isRandomQuestions() && $gameplayContext) 
			{
				if (!in_array($question->id, $_SESSION['wpvq_random_quiz_' . $this->id])) {
					$questions[] = $que;
					// Don't loop anymore if you already have enough questions !
					if (count($questions) >= $this->randomQuestions) { break; }
				}
				else {
					$alreadyPlayedQuestions[] = $que;
				}
			}

			// Not random : we add all questions.
			if (!$this->isRandomQuestions() || !$gameplayContext) {
				$questions[] = $que;
			}
		}

		// Randomize questions
		if ($this->isRandomQuestions() && $gameplayContext) 
		{
			shuffle_seed($questions, $this->getRandomQuestionSeed());
			shuffle_seed($alreadyPlayedQuestions, $this->getRandomQuestionSeed());

			$questions = array_merge($questions, $alreadyPlayedQuestions); // complete with more questions if needed
			$questions = array_slice($questions, 0, $this->randomQuestions); // truncate the final array

			foreach($questions as $question) {
				if (!in_array($question->getId(), $_SESSION['wpvq_random_quiz_' . $this->id])) {
					$_SESSION['wpvq_random_quiz_' . $this->id][] = $question->getId();
				}
			}
		}

		return $questions;
	}

	/**
	 * [getRandomQuestionSeed description]
	 * @return [type] [description]
	 * @note Destroy the session in the controller (submitInformation process, at the end of the quiz)
	 */
	private function getRandomQuestionSeed()
	{
		$sessionName = 'wpvq_randomQuestionSeed_quiz' . $this->id;
		
		// If doesn't exist
		if (!isset($_SESSION[$sessionName]) || $_SESSION[$sessionName] == 0) 
		{
			srand();
			$_SESSION[$sessionName] = rand(1,9999);
		} 

		return $_SESSION[$sessionName];
	}

	/**
	 * List all quizz for a user
	 * @param $authorId ID of user
	 * @return array de WPVQGame[TrueFalse|Personnality]
	 */
	public static function listAll($authorId=0, $page=0, $listAll=false) {

		global $wpdb;

		$limitBegin = $page * WPVQ_QUIZ_PER_PAGE;

		// Fetch from DB
		$authorId = intval($authorId);
		if ($authorId == 0) {
			$sql_where_author = '';
		} else {
			$sql_where_author = "WHERE authorId = $authorId";
		}

		if ($listAll) {
			$row = $wpdb->get_results('SELECT ID, type FROM ' . WPViralQuiz::getTableName('quizzes') . ' '. $sql_where_author .' ORDER BY id DESC');
		}
		else {
			$row = $wpdb->get_results('SELECT ID, type FROM ' . WPViralQuiz::getTableName('quizzes') . ' '. $sql_where_author .' ORDER BY id DESC LIMIT '.$limitBegin.','.WPVQ_QUIZ_PER_PAGE);
		}

		// No quizz
		if (empty($row)) {
			return array();
		}

		$quizzes = array();
		foreach($row as $quiz) 
		{	
			$type 	=  $quiz->type;
			$qu 	=  new $type();
			$qu->load($quiz->ID);

			$quizzes[] = $qu;
		}

		return $quizzes;

	}

	/**
	 * List quizzes pagination
	 * @return [type] [description]
	 */
	public static function getPagesCount($authorId=0) 
	{
		global $wpdb;

		// Fetch from DB
		$authorId = intval($authorId);
		if ($authorId == 0) {
			$sql_where_author = '';
		} else {
			$sql_where_author = "WHERE authorId = $authorId";
		}

		// Count quizzes
		$quizzesCount = $wpdb->get_var('SELECT COUNT(ID) FROM ' . WPViralQuiz::getTableName('quizzes') . ' '. $sql_where_author );
		$pagesCount = round($quizzesCount / WPVQ_QUIZ_PER_PAGE) + 1;

		return $pagesCount;
	}

	/**
	 * Delete quizz 
	 * @return boolean [true|false]
	 */
	public function delete() {

		global $wpdb;

		// Delete questions + answers
		foreach ($this->questions as $questions) {
			$questions->delete();
		}

		// Delete appreciations
		foreach ($this->appreciations as $appreciation) {
			$appreciation->delete();
		}

		// Delete players
		$wpdb->delete( WPViralQuiz::getTableName('players'), array( 'quizId' => $this->id) );		

		// Delete quiz
		return $wpdb->delete( WPViralQuiz::getTableName('quizzes'), array( 'ID' => $this->id) ) ;
	}

	/**
	 * Duplicate a quiz
	 * @return new quiz object
	 */
	public function duplicate()
	{
		global $wpdb;

		$wpdb->query('CREATE TEMPORARY TABLE wpvq_tmptable_1 SELECT * FROM '.WPViralQuiz::getTableName('quizzes').' WHERE id = '.$this->id.';');
		$wpdb->query('UPDATE wpvq_tmptable_1 SET id = NULL, dateCreation = '.time().', dateUpdate = '.time().', name = CONCAT(name, " (bis)")');
		$wpdb->query('INSERT INTO '.WPViralQuiz::getTableName('quizzes').' SELECT * FROM wpvq_tmptable_1;');
		$wpdb->query('DROP TEMPORARY TABLE IF EXISTS wpvq_tmptable_1;');
		$newQuizId = $wpdb->insert_id;

		foreach ($this->questions as $questions) {
			$questions->duplicate($newQuizId);
		}

		foreach ($this->appreciations as $appreciation) {
			$appreciation->duplicate($newQuizId);
		}

		foreach($this->extraOptions as $name => $value) {
			self::updateExtraOption($newQuizId, $name, $value);
		}

		$wpdb->query('UPDATE '.WPViralQuiz::getTableName('multipliers').' SET quizId = '.$newQuizId.' WHERE quizId = -1');

		return true;
	}

	/**
	 * Export a quiz to a zip file (json + pictures)
	 * @return [type] [description]
	 */
	public function export()
	{
		$export = array('appreciations' => array(), 'settings' => array(), 'content' => array(), 'players' => array());

		// Content export
		foreach($this->questions as $question) {
			$contentExport = $question->export();
			$export['content'][] = $contentExport;
		}

		// Settings export
		$export['settings'] = $this->exportSettings();

		// Meta export
		$export['extraOptions'] = $this->exportExtraOptions();

		// Players export
		$export['players'] = $this->exportPlayers();

		// Upload config
		$currentTime 		=  time();
		$upload_dir 		=  wp_upload_dir();
		$upload_path 		=  $upload_dir['path'];
		$file_slug 			=  'wpvq-' . substr(slugify($this->getName(), true), 0, 10) . '-' . $currentTime;

		// Create local upload dir
		$upload_local_path  			=  $upload_path . '/' . $file_slug;
		if (!mkdir($upload_local_path, 0777, true)) {
			die('Error : can\'t upload.');
		}

		// Create json+pictures
		$final_json_path 	=  $upload_local_path . '/export.json';

		// Fetch pictures ID then save them into the pictures folder
		$picturesIds = array_filter(array_value_recursive('pictureId', $export['content']));
		foreach($picturesIds as $pictureId) 
		{
			$url = wp_get_attachment_url($pictureId);
			$ext = pathinfo($url, PATHINFO_EXTENSION);
			if (file_put_contents("$upload_local_path/$pictureId.$ext", file_get_contents($url)) === FALSE) {
				die('Error : can\'t upload.');
			}
		}

		// Export appreciations with pictures
		$export['appreciations'] = $this->exportAppreciations($upload_local_path);
		
		$exportJson = json_encode($export);
		if (file_put_contents($final_json_path, $exportJson) === FALSE) {
			die('Error : can\'t upload.');
		}

		// Create zip file
		$final_zip_path =  $upload_path . '/' . $file_slug . '.zip';
		$zip = new ZipArchive();
		if ($zip->open($final_zip_path, ZipArchive::CREATE) !== TRUE) {
		    die('Error : can\'t upload.');
		}

		$zip->addGlob($upload_local_path . "/*.*", 0, array('remove_all_path' => true, 'add_path' => $file_slug.'/'));
		if (!$zip->status == ZIPARCHIVE::ER_OK) {
		    die('Error : can\'t upload.');
		}

		$zip->close();
		return $final_zip_path;
	}

	/**
	 * Export quiz settings to array
	 * @return [type] [description]
	 */
	public function exportSettings()
	{
		$export = array();

		$export = array(
			'id' 				=> $this->id,
			'name' 				=> $this->name,
			'authorId' 			=> $this->authorId,
			'dateCreation' 		=> $this->dateCreation,
			'dateUpdate' 		=> $this->dateUpdate,
			'score' 			=> $this->score,
			'type' 				=> $this->type,
			'showSharing' 		=> $this->showSharing,
			'showCopyright' 	=> $this->showCopyright,
			'askInformations' 	=> $this->askInformations,
			'forceToShare' 		=> $this->forceToShare,
			'skin' 				=> $this->skin,
			'randomQuestions' 	=> $this->randomQuestions,
			'isRandomAnswers' 	=> $this->isRandomAnswers,
			'meta' 				=> $this->meta,
		);

		return $export;
	}

	/**
	 * Export quiz settings to array
	 * @return [type] [description]
	 */
	public function exportExtraOptions()
	{
		return $this->fetchAllExtraOptions();
	}

	/**
	 * Export appreciations
	 * @return [type] [description]
	 */
	public function exportAppreciations($upload_local_path) 
	{
		$export = array();

		foreach($this->appreciations as $appreciation) {
			$export[] = $appreciation->export($upload_local_path);
		}

		return $export;
	}

	/**
	 * Export quiz settings to array
	 * @return [type] [description]
	 */
	public function exportPlayers()
	{
		$export 	=  array();

		// Fetch players
		$players 	=  new WPVQPlayers();
		$players 	=  $players->load($this->id);

		$export = $players->getPlayers();

		return $export;
	}

	/**
	 * Import a quiz package (ajax call)
	 * @param array List of URLs
	 * @return [type] [description]
	 */
	public static function ajaxImport()
	{
		if(!isset($_POST['urls']) && is_array($_POST['urls']) || !current_user_can( 'manage_options' )) {
			wp_die(500);
		}

		// Upload via URLs
		$urls = $_POST['urls'];
		foreach($urls as $url)
		{
			if (!filter_var($url, FILTER_VALIDATE_URL) === false) 
			{
				self::import($url);
			}
		}

		wp_die(201);
	}

	public static function import($url)
	{
		$upload_dir 		=  wp_upload_dir();
		$upload_url 		=  $upload_dir['url'];
		$upload_path 		=  $upload_dir['path'];
		$dirname 			=  pathinfo($url, PATHINFO_FILENAME); // filename without extension
		$basename 			=  pathinfo($url, PATHINFO_BASENAME); // file with extension

		// Download file
		if (file_put_contents($upload_path.'/'.$basename, file_get_contents($url)) === FALSE) {
			die('Error : can\'t upload.');
		}

		// Check file type
		if (!zipIsValid($upload_path.'/'.$basename)) {
			die('Wrong file.');
		}

		// Extract archive
		$zip 		=  new ZipArchive;
		$res 		=  $zip->open($upload_path . '/' . $basename);
		
		// new dirname based on real directory on the zip
		$dirname = dirname(trim($zip->getNameIndex(0), '/')); 
		if ($dirname == '.') {
			// In some cases (when zip is not generated via export),
			// the getNameIndex already returns the perfect dirname
			// so applying dirname() returns "."
			$dirname = trim($zip->getNameIndex(0), '/'); 
		}

		if ($res === TRUE) {
		    $zip->extractTo($upload_path);
		    $zip->close();
		} else {
		    die('Error : can\'t upload.');
		}

		// Get the json file
		$exportJson = file_get_contents($upload_path . '/' . $dirname . '/export.json');
		if ($exportJson === FALSE) { die('Error : can\'t upload.'); }
		// Parse raw to json
		$exportJson = json_decode($exportJson, true);
		if ($exportJson == NULL) { die('Wrong file.'); }

		// Import Quiz
		if (!isset($exportJson['settings']['type'])) {
			die('Wrong file.');			
		}
		$quizType = $exportJson['settings']['type'];
		$quiz = new $quizType();
		$quiz->add($exportJson['settings']);

		// Upload pictures
		foreach (glob("$upload_path/$dirname/*.{jpg,png,gif}", GLOB_BRACE) as $key => $file) 
		{
			$basename 	=  pathinfo($file, PATHINFO_BASENAME);
			$oldId 		=  pathinfo($file, PATHINFO_FILENAME);
			$newId 		=  custom_media_sideload_image("$upload_url/$dirname/$basename");
			array_replace_only_for_key($exportJson['content'], 'pictureId', $oldId, $newId);
		}

		// Appreciations
		foreach ($exportJson['appreciations'] as $appreciation)
		{
			$matches = array();
			preg_match_all('#%%export(.*)%%#', $appreciation['content'], $matches);
			foreach ($matches[1] as $match)
			{
				$newId 	=  custom_media_sideload_image("$upload_url/$dirname/$match");
				$url 	=  wp_get_attachment_url($newId);
				$appreciation['content'] = str_replace('%%export'.$match.'%%', $url, $appreciation['content']);
			}

			$newAppr 	=  $quiz->addAppreciation($appreciation);
			$oldId 		=  $appreciation['id'];
			$newId 		=  $newAppr->getId();
			array_replace_only_for_key($exportJson['content'], 'appreciationId', $oldId, $newId);
		}

		// Questions + answers
		foreach ($exportJson['content'] as $content)
		{
			$question = $content['question'];
			$question = $quiz->addQuestion($question);

			// Answers
			foreach ($content['answers'] as $index => $answer) 
			{
				$multipliers = ($quizType == 'WPVQGameTrueFalse') ? array() : $answer['multipliers'];
				$question->addAnswer($answer, NULL, $multipliers);
			}
		}

		// ExtraOptions
		if(isset($exportJson['extraOptions']))
		{
			foreach ($exportJson['extraOptions'] as $name => $option)
			{
				self::updateExtraOption($quiz->getId(), $name, $option);
			}
		}
	}

	/** 	
	 * Get type quizz by id
	 * @return string [WPVQGameTrueFalse|WPVQGamePersonnality]
	 */

	public static function getTypeById($id) {

		global $wpdb;

		if (!is_numeric($id)) {
			throw new Exception("Need numeric ID on Game load.");
		}

		$row = $wpdb->get_row('SELECT type FROM ' . WPViralQuiz::getTableName('quizzes') . ' WHERE ID = ' . $id);
		if (empty($row)) {
			throw new Exception("Quizz $id doesn't exist.");
		}

		return $row->type;
	}

	/**
	 * Return the <add question view> parsed
	 * @return [type] [description]
	 */
	public function getParsedViewQuestions($showMiniature = false) {
		$name = 'WPVQAddQuestion.' . $this->type . '.append.php';
		return $this->parseAddQuestion($name, $showMiniature);
	}
	
	private function parseAddQuestion($templateName, $showMiniature)
	{
		$finalTemplate 	= '';
		$blankHtmlTemplate = wpvq_get_view($templateName);
		$blankHtmlTemplate = preg_replace('#<div>\n*(.*)\n*<\/div>#m', '$1', $blankHtmlTemplate);

		$i = 1;
		foreach ($this->questions as $index => $question)
		{
			// Parsing elements
			$questionTemplate = $blankHtmlTemplate;
			$elements = array(
				'%%questionLabel%%' 		=> htmlentities(stripslashes($question->getLabel()), ENT_COMPAT, 'UTF-8'),
				'%%questionIndex%%' 		=> $i,
				'%%questionPictureUrl%%'	=> ($question->getPictureId() == NULL || $question->getPictureId() == 0) ? (($showMiniature) ? '#' : WPVQ_PLUGIN_URL . 'views/img/photo-placeholder.jpg') : wp_get_attachment_url($question->getPictureId()),
				'%%questionPictureId%%' 	=> $question->getPictureId(),
				'%%questionId%%' 			=> $question->getId(),
				'%%questionContent%%' 		=> stripslashes($question->getContent()),
				'%%questionPosition%%'		=> $question->getPosition(),
				'%%explainChecked%%' 		=> ($question->getContent() != '') ? 'checked':'',
				'%%pageAfterChecked%%' 		=> ($question->isTherePageAfter()) ? 'checked':'',
				'%%styleEditor%%' 			=> ($question->getContent() != '') ? 'display:block;':'display:none;',
				'%%showDeletePictureLabel%%' => ($question->getPictureId() == NULL || $question->getPictureId() == 0) ? 'display:none;':'display:block;',
				'%%totalUniqQuestions%%' 	=> $this->countQuestions(),
				'£questionContentCheckbox£' => "vqquestions[$i][questionContentCheckbox]",
				'£questionLabel£' 			=> "vqquestions[$i][label]",
				'£questionPosition£' 		=> "vqquestions[$i][position]",
				'£pictureId£' 				=> "vqquestions[$i][pictureId]",
				'£questionId£' 				=> "vqquestions[$i][id]",
				'£questionContent£' 		=> "vqquestions[$i][content]",
				'£pageAfterCheckbox£' 		=> "vqquestions[$i][pageAfter]",
				'data-questionIndex=""'		=> 'data-questionIndex="'.$i.'"',
			);

			foreach ($elements as $tag => $value) {
				$questionTemplate = str_replace($tag, $value, $questionTemplate);
			}

			// Parse answer view
			$questionTemplate = str_replace('%%answers%%', $question->getParsedView($this->type, $i, $showMiniature), $questionTemplate);

			$finalTemplate .= "\n $questionTemplate";
			$i++;
		}

		return $finalTemplate;	
	}

	/**
	 * Return the <add question view> parsed
	 * @return [type] [description]
	 */
	public function getParsedViewAppreciations() 
	{
		if ($this->type == 'WPVQGamePersonality') {
			$name = 'WPVQAddQuestion.WPVQGamePersonality.personality.append.php';
		} elseif ($this->type == 'WPVQGameTrueFalse') {
			$name = 'WPVQAddQuestion.WPVQGameTrueFalse.appreciation.append.php';
		}
		return $this->parseAddAppreciation($name);
	}
	
	private function parseAddAppreciation($templateName)
	{
		$finalTemplate 	   = '';
		$blankHtmlTemplate = wpvq_get_view($templateName);
		$blankHtmlTemplate = preg_replace('#<div>\n*(.*)\n*<\/div>#m', '$1', $blankHtmlTemplate);

		$i = 1;
		foreach ($this->appreciations as $index => $appreciation)
		{
			// Parsing elements
			$appreciationTemplate = $blankHtmlTemplate;
			$elements = array(
				'%%scoreCondition%%' 			=> $appreciation->getScoreCondition(),
				'%%appreciationLabel%%' 		=> htmlentities($appreciation->getLabel(), ENT_COMPAT, 'UTF-8'),
				'%%appreciationIndex%%' 		=> $i,
				'%%appreciationId%%' 			=> $appreciation->getId(),
				'%%appreciationContent%%' 		=> stripslashes($appreciation->getContent()),

				'£scoreCondition£' 				=> "vqappreciations[$i][scoreCondition]",
				'£appreciationLabel£' 			=> "vqappreciations[$i][label]",
				'£appreciationId£' 				=> "vqappreciations[$i][id]",
				'£appreciationContent£' 		=> "vqappreciations[$i][content]",
			);

			foreach ($elements as $tag => $value) {
				$appreciationTemplate = str_replace($tag, $value, $appreciationTemplate);
			}

			$finalTemplate .= "\n $appreciationTemplate";
			$i++;
		}

		return $finalTemplate;	
	}
}

