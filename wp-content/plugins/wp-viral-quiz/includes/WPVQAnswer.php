<?php 

class WPVQAnswer {

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
	 * Label of the answer
	 * @var string
	 */
	private $label;


	/**
	 * Picture of the answer
	 * @var ID of WP Attachement
	 */
	private $pictureId;


	/**
	 * Value of the answer
	 * @var int
	 * TrueFalse : 1 or 0
	 * Personality : 1, 2, 3, 4...
	 */
	private $weight;

	/**
	 * Weight multiplier
	 * @var int
	 * TrueFalse : array()
	 * Personality : array('appreciationId-1' => X, 'appreciationId-2' => Y, ...)
	 */
	private $multipliers;


	/**
	 * HTML content \ when answered
	 * @var string (html)
	 */
	private $content;


	/**
	 * Questions ID of the answer
	 * @var int
	 */
	private $questionId;



	/**
	 * ----------------------------
	 * 		    GETTERS
	 * ----------------------------
	 */

	public function getId() {
		return $this->id;
	}
	
	public function getLabel() {
		return $this->label;
	}

	public function getPictureId() {
		return $this->pictureId;
	}

	public function getWeight() {
		return $this->weight;
	}

	public function getMultipliers($appreciationId = NULL) 
	{
		if ($appreciationId == NULL) {
			return $this->multipliers;	
		} else {
			return (isset($this->multipliers[$appreciationId])) ? $this->multipliers[$appreciationId] : 0;
		}
		
	}

	public function getContent() {
		return $this->content;
	}

	public function getQuestionId() {
		return $this->questionId;
	}

	public function getQuestion() {
		$question = new WPVQQuestion();
		$question->load($this->questionId);
		return $question;
	}



	function __construct()
	{
		$this->id 			=  0;
		$this->questionId 	=  0;
		$this->weight 		=  0;
		$this->multipliers 	=  array();
		$this->label 		=  '';
		$this->pictureId 	=  0;
		$this->content 		=  '';

		return $this;
	}

	/**
	 * Load a question by ID
	 * @return [type] [description]
	 */
	public function load($id)
	{
		global $wpdb;

		if (!is_numeric($id)) {
			throw new Exception("Need numeric ID on answer load ($i).");
		}

		// Fetch from DB
		$row = $wpdb->get_row('SELECT * FROM ' . WPViralQuiz::getTableName('answers') . ' WHERE ID = ' . $id);

		// No appreciations
		if (empty($row)) {
			throw new Exception("No question with ID#$id");
		}

		$this->id 				= $row->ID;
		$this->questionId 		= $row->questionId;
		$this->content 			= $row->content;
		$this->label 			= $row->label;
		$this->pictureId 		= $row->pictureId;
		
		// If not "true/false" quiz
		if ($row->weight > 1) {
			if (WPVQAppreciation::exists($row->weight)) {
				$this->weight = $row->weight;
			} else {
				$this->weight = -1;
			}
		} else {
			$this->weight = $row->weight;
		}

		// Fetch multiplier association for personality quiz
		// Useless for Trivia Quiz
		$row = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . WPViralQuiz::getTableName('multipliers') . ' WHERE answerId = %d', $this->id));
		foreach($row as $multiplier) 
		{
			$this->multipliers[$multiplier->appreciationId] = $multiplier->multiplier;
		}


		return $this;
	}


	/**
	 * Delete Answer 
	 * @return boolean [true|false]
	 */
	public function delete() {
		global $wpdb;

		$wpdb->delete( WPViralQuiz::getTableName('multipliers'), array( 'answerId' => $this->id) );
		return $wpdb->delete( WPViralQuiz::getTableName('answers'), array( 'ID' => $this->id) ) ;
	}

	/**
	 * Duplicate answer 
	 * @param $newQuizId The new quiz ID
	 */
	public function duplicate($newQuestionId, $newQuizId) {

		global $wpdb;

		$wpdb->query('CREATE TEMPORARY TABLE wpvq_tmptable_1 SELECT * FROM '.WPViralQuiz::getTableName('answers').' WHERE id = '.$this->id.'');
		$wpdb->query('UPDATE wpvq_tmptable_1 SET id = NULL, questionId = '.$newQuestionId.'');
		$wpdb->query('INSERT INTO '.WPViralQuiz::getTableName('answers').' SELECT * FROM wpvq_tmptable_1');
		$wpdb->query('DROP TEMPORARY TABLE IF EXISTS wpvq_tmptable_1;');

		$newAnswerId = $wpdb->insert_id;

		// Duplicate multipliers
		// -1 to detect the multipliers for ::appreciation->duplicate()
		$wpdb->query('CREATE TEMPORARY TABLE wpvq_tmptable_1 SELECT * FROM '.WPViralQuiz::getTableName('multipliers').' WHERE answerId = '.$this->id.'');
		$wpdb->query('UPDATE wpvq_tmptable_1 SET id = NULL, answerId = '.$newAnswerId.', questionId = '.$newQuestionId.', quizId = -1');
		$wpdb->query('INSERT INTO '.WPViralQuiz::getTableName('multipliers').' SELECT * FROM wpvq_tmptable_1');
		$wpdb->query('DROP TEMPORARY TABLE IF EXISTS wpvq_tmptable_1;');
	}

	/**
	 * Export answer to array
	 * @return [type] [description]
	 */
	public function export()
	{
		$export = array();
		
		// Export answer itself
		$export = array(
			'questionId' 		=>  $this->questionId,
			'content' 			=>  $this->content,
			'label' 			=>  $this->label,
			'pictureId' 		=>  $this->pictureId,
			'weight' 			=>  $this->weight,
		);

		// Export multipliers (ready for import)
		foreach($this->multipliers as $appreciationId => $multiplier)
		{
			$export['multipliers'][] = array(
				'appreciationId' => $appreciationId,
				'multiplier' => $multiplier,
			);
		}

		return $export;
	}


}