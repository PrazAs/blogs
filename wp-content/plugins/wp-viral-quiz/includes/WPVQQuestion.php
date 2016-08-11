<?php

class WPVQQuestion {


	/**
	 * ----------------------------
	 * 		  ATTRIBUTS
	 * ----------------------------
	 */
		
	/**
	 * Id of the question
	 * @var int
	 */
	private $id;

	/**
	 * Quiz id of the question
	 * @var int
	 */
	private $quizId;

	/**
	 * Shuffle answers ?
	 * @var bool
	 */
	private $isRandomAnswers;

	/**
	 * Statement of the question
	 * @var string
	 */
	private $label;


	/**
	 * Picture of the question
	 * @var ID of WP Attachement
	 */
	private $pictureId;


	/**
	 * Answers of the question
	 * @var Array of ::Answers
	 */
	private $answers;


	/**
	 * Position of the question in da game
	 * @var [type]
	 */
	private $position;

	/**
	 * Useful for TRUE/FALSE quizzes answer
	 * @var [type]
	 */
	private $content;

	/**
	 * Is there a page after this question ?
	 * @var int (0 ou 1)
	 */
	private $pageAfter;




	/**
	 * ----------------------------
	 * 		    GETTERS
	 * ----------------------------
	 */

	public function getId() {
		return $this->id;
	}

	public function getQuizId() {
		return $this->quizId;
	}

	public function getLabel() {
		return $this->label;
	}

	public function getPictureId() {
		return $this->pictureId;
	}

	public function getAnswers() {
		return $this->answers;
	}

	public function getPosition() {
		return $this->position;
	}

	public function getContent() {
		return $this->content;
	}

	public function isTherePageAfter() {
		return ($this->pageAfter == 1);
	}


	function __construct()
	{
		$this->id 			=  0;
		$this->quizId 		=  0;
		$this->label 		=  '';
		$this->pictureId 	=  0;
		$this->answers 		=  array();
		$this->position 	=  0;	
		$this->content 		=  '';
		$this->pageAfter 	=  0;
		$this->isRandomAnswers =  false;

		return $this;
	}

	/**
	 * Load a question by ID
	 * @return [type] [description]
	 */
	public function load($id, $gameplayContext=false, $randomAnswers=false)
	{
		global $wpdb;

		if (!is_numeric($id)) {
			throw new Exception("Need numeric ID on question load ($id).");
		}

		// Fetch from DB
		$row = $wpdb->get_row('SELECT * FROM ' . WPViralQuiz::getTableName('questions') . ' WHERE ID = ' . $id);

		// No appreciations
		if (empty($row)) {
			throw new Exception("No question with ID#$id");
		}

		$this->id 				= $row->ID;
		$this->label 			= $row->label;
		$this->quizId 			= $row->quizId;
		$this->position 		= $row->position;
		$this->pictureId 		= $row->pictureId;

		$this->isRandomAnswers 	= $randomAnswers; // fn param from ::Game
		$this->answers 			= $this->fetchAnswers($gameplayContext);

		$this->content 			= $row->content;
		$this->pageAfter 		= $row->pageAfter;

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
	 */
	public function addAnswer($param, $answerId = NULL, $multiplierParam = array())
	{
		global $wpdb;

		if (!isset($param['label']) || !isset($param['pictureId']) || !isset($param['content']) || !is_array($param)) {
			throw new Exception("Bad parameter(s) when adding question.", 1);
		}

		// Add new answer
		if ($answerId == NULL || $answerId == "" || $answerId == 0) 
		{
			$dataSql = array(
				'label' 			=>  $param['label'],
				'questionId' 		=>  $this->id,
				'weight' 			=>  $param['weight'],
				'content' 			=>  $param['content'],
				'pictureId' 		=>  $param['pictureId'],
			);

			$typeSql = array(
				'%s',
				'%d',
				'%d',
				'%s',
				'%d',
			);

			$wpdb->insert( WPViralQuiz::getTableName('answers'), $dataSql, $typeSql );
			$answerId = $wpdb->insert_id;
		}
		// Update
		else 
		{
			$dataSql = array(
				'label' 			=>  $param['label'],
				'weight' 			=>  $param['weight'],
				'content' 			=>  $param['content'],
				'pictureId' 		=>  $param['pictureId'],
			);

			$typeSql = array(
				'%s',
				'%d',
				'%s',
				'%d',
			);

			$wpdb->update( WPViralQuiz::getTableName('answers'), $dataSql, array('ID' => $answerId), $typeSql, array('%d'));
		}

		// For PersonalityQuiz, associate the answer with weight multiplier
		$dataSql = array();
		if (!empty($multiplierParam)) 
		{
			// Purge old associations
			$wpdb->delete( WPViralQuiz::getTableName('multipliers'), array( 'answerId' => $answerId) ) ;

			$typeSql = array(
				'%d',
				'%d',
				'%d',
				'%d',
				'%d',
			);
			foreach($multiplierParam as $multiplier)
			{
				$dataSql = array(
					'quizId' 		 => $this->quizId,
	 				'questionId' 	 => $this->id,
	 				'answerId'		 => $answerId,
	 				'appreciationId' => $multiplier['appreciationId'],
	 				'multiplier' 	 => $multiplier['multiplier'],
				);

				$wpdb->insert( WPViralQuiz::getTableName('multipliers'), $dataSql, $typeSql );
			}
		}

		// Update answers lists
		$this->answers = $this->fetchAnswers();

		$answer = new WPVQAnswer();
		$answer->load($answerId);

		return $answer;
	}


	/**
	 * Returns array of answers for this game
	 * @return array of ::Answer
	 */
	private function fetchAnswers($gameplayContext=false)
	{
		global $wpdb;

		// Fetch from DB
		$row = $wpdb->get_results($wpdb->prepare('SELECT ID FROM ' . WPViralQuiz::getTableName('answers') . ' WHERE questionId = %d', $this->id));

		// No answer
		if (empty($row)) {
			return array();
		}

		$answers = array();
		foreach($row as $answer) 
		{
			$ans = new WPVQAnswer();
			$ans->load($answer->ID);

			$answers[] = $ans;
		}

		// Shuffle answers
		if ($this->isRandomAnswers && $gameplayContext) {
			shuffle($answers);
		}

		return $answers;
	}

	/**
	 * Delete question 
	 * @return boolean [true|false]
	 */
	public function delete() {

		global $wpdb;

		foreach ($this->answers as $answers) {
			$answers->delete();
		}

		return $wpdb->delete( WPViralQuiz::getTableName('questions'), array( 'ID' => $this->id) ) ;

	}

	/**
	 * Duplicate question 
	 * @param $newQuizId The new quiz ID
	 */
	public function duplicate($newQuizId) {

		global $wpdb;

		$wpdb->query('CREATE TEMPORARY TABLE wpvq_tmptable_1 SELECT * FROM '.WPViralQuiz::getTableName('questions').' WHERE id = '.$this->id.'');
		$wpdb->query('UPDATE wpvq_tmptable_1 SET id = NULL, quizId = '.$newQuizId.'');
		$wpdb->query('INSERT INTO '.WPViralQuiz::getTableName('questions').' SELECT * FROM wpvq_tmptable_1');
		$wpdb->query('DROP TEMPORARY TABLE IF EXISTS wpvq_tmptable_1;');
		$newQuestionId = $wpdb->insert_id;

		foreach ($this->answers as $answers) {
			$answers->duplicate($newQuestionId, $newQuizId);
		}
	}

	/**
	 * Define if answers have pictures or not 
	 * @return string [square|line]
	 */
	public function squareOrLine() 
	{
		$result = 'line';
		foreach ($this->getAnswers() as $an) {
			if($an->getPictureId() > 0) {
				$result = 'square';
			}
		}

		return $result;
	}

	/**
	 * Export questions to an array
	 * @return [type] [description]
	 */
	public function export()
	{
		$export = array('question' => array(), 'answers' => array());

		// Export question itself
		$export['question'] = array(
			'quizId' 			=>  $this->quizId,
			'content' 			=>  $this->content,
			'label' 			=>  $this->label,
			'pictureId' 		=>  $this->pictureId,
			'position' 			=>  $this->position,
			'isRandomAnswers' 	=>  $this->isRandomAnswers,
			'pageAfter' 		=>  $this->pageAfter,
		);

		// Export answsers
		foreach($this->getAnswers() as $answser) {
			$export['answers'][] = $answser->export();
		}

		 return $export;
	}

	/**
	 * Return the <add answer view> parsed
	 * @return [type] [description]
	 */
	public function getParsedView($quizType, $questionNum, $showMiniature) {
		$path = plugin_dir_path( __FILE__ ) . '/../views/WPVQAddQuestion.'.$quizType.'.answer.append.php';
		return $this->parseAddAnswer($path, $questionNum, $quizType, $showMiniature);
	}

	private function parseAddAnswer($templatePath, $questionNum, $quizType, $showMiniature) 
	{
		$finalTemplate 	= '';
		$quiz 			= new $quizType();
		$quiz->load($this->quizId); 
	
		// Main Answer Template
		ob_start();
		include($templatePath);
		$blankHtmlTemplate = ob_get_contents();
		$blankHtmlTemplate = preg_replace('#<div>\n*(.*)\n*<\/div>#m', '$1', $blankHtmlTemplate);
		ob_end_clean();

		// Multiplier answer
		if ($quizType == 'WPVQGamePersonality')
		{
			ob_start();
			include(plugin_dir_path( __FILE__ ) . '/../views/WPVQAddQuestion.'.$quizType.'.answer.append.multiplier.php');
			$blankHtmlTemplateMultiplier = ob_get_contents();
			$blankHtmlTemplateMultiplier = preg_replace('#<div>\n*(.*)\n*<\/div>#m', '$1', $blankHtmlTemplateMultiplier);
			ob_end_clean();
		}

		$i = 1;
		foreach ($this->answers as $index => $answer)
		{
			// Parsing elements
			$answerTemplate = $blankHtmlTemplate;
			$elements = array(
				'%%answerLabel%%' 		=> htmlentities(stripslashes($answer->getLabel()), ENT_COMPAT, 'UTF-8'),
				'%%isRightAnswer%%' 	=> $answer->getWeight(),
				'%%checked%%' 			=> ($answer->getWeight() == 1) ? 'checked':'',
				'%%answerPictureUrl%%'	=> ($answer->getPictureId() != NULL && $answer->getPictureId() != 0) ? wp_get_attachment_url($answer->getPictureId()) : '',
				'%%answerPictureId%%' 	=> $answer->getPictureId(),
				'%%answerId%%' 			=> $answer->getId(),
				'%%showDeletePictureLabel%%' => ($answer->getPictureId() == NULL || $answer->getPictureId() == 0) ? 'display:none;':'display:block;',
				'£answerLabel£' 		=> "vqquestions[$questionNum][answers][$i][label]",
				'£pictureId£' 			=> "vqquestions[$questionNum][answers][$i][pictureId]",
				'£rightAnswer£' 		=> "vqquestions[$questionNum][answers][$i][rightAnswer]",
				'£personalities£' 		=> "vqquestions[$questionNum][answers][$i][personalities]",
				'£answerId£' 			=> "vqquestions[$questionNum][answers][$i][id]",
				'data-questionIndex=""'		=> 'data-questionIndex="'.$questionNum.'"',
				'data-answerIndex=""'		=> 'data-answerIndex="'.$i.'"',
			);

			foreach ($elements as $tag => $value) {
				$answerTemplate = str_replace($tag, $value, $answerTemplate);
			}

			// Multiplier answer
			if ($quizType == 'WPVQGamePersonality')
			{
				$finalMultiplierTemplate 	= '';
				foreach ($quiz->getAppreciations() as $personality)
				{
					$multiplierTemplate = $blankHtmlTemplateMultiplier;
					$multiplierTemplate = str_replace('£answerMultiplier£', 'vqquestions['.$questionNum.'][answers]['.$i.'][multiplier]['.$personality->getId().']', $multiplierTemplate);
					$multiplierTemplate = str_replace('%%personalityLabel%%', $personality->getLabel(), $multiplierTemplate);
					$multiplierTemplate = str_replace('%%personalityId%%', $personality->getId(), $multiplierTemplate);
					$multiplierTemplate = str_replace('%%multiplierValue%%', $answer->getMultipliers($personality->getId()), $multiplierTemplate);
					$finalMultiplierTemplate .= $multiplierTemplate;
				}
				$answerTemplate = str_replace('%%multipliers%%', $finalMultiplierTemplate, $answerTemplate);
			}

			$finalTemplate .= $answerTemplate;
			$i++;
		}

		return $finalTemplate;		
	}

}