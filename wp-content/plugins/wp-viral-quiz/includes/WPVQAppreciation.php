<?php

class WPVQAppreciation {


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
	 * Statement of the question
	 * @var string
	 */
	private $label;


	/**
	 * Content of the appreciation
	 * @var string (html)
	 */
	private $content;


	/**
	 * The score needed to activate this appreciation
	 * @var int See WPVGame::$score.
	 */
	private $scoreCondition;



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

	public function getContent() {
		return $this->content;
	}

	public function getScoreCondition() {
		return $this->scoreCondition;
	}



	function __construct()
	{
		$this->id 				= 0;
		$this->label 			= "";
		$this->content 			= "";
		$this->scoreCondition 	= 0;

		return $this;
	}

	/**
	 * Load an appreciation from ID
	 * @param  int $id Appreciation ID
	 * @return $this
	 */
	public function load($id)
	{
		global $wpdb;

		if (!is_numeric($id)) {
			throw new Exception("Need numeric ID on Appreciation load ($id).");
		}

		// Deleted appreciation
		if ($id == -1) {
			return $this;
		}


		// Fetch from DB
		$row = $wpdb->get_row('SELECT * FROM ' . WPViralQuiz::getTableName('appreciations') . ' WHERE ID = ' . $id);

		// No appreciations
		if (empty($row)) {
			throw new Exception("No appreciation with ID#$id");
		}

		$this->id 				= $row->ID;
		$this->label 			= $row->label;
		$this->content 			= $row->content;
		$this->scoreCondition 	= $row->scoreCondition;

		return $this;
	}

	/**
	 * Delete appreciation 
	 * @return boolean [true|false]
	 */
	public function delete() {
		global $wpdb;
		return $wpdb->delete( WPViralQuiz::getTableName('appreciations'), array( 'ID' => $this->id) ) ;
	}

	/**
	 * Export appreciation to an array
	 * @return [type] [description]
	 */
	public function export($uploadLocalPath)
	{
		// Export pictures
		$picturesUrl = export_images_urls($this->content);
		foreach ($picturesUrl as $url) 
		{
			$ext 			=  pathinfo($url, PATHINFO_EXTENSION);
			$tagId 			=  time().rand(1000,9999);

			if (file_put_contents("$uploadLocalPath/$tagId.$ext", file_get_contents($url)) === FALSE) {
				die('Error : can\'t upload.');
			}
			
			$pictureTag 	=  '%%export'.$tagId.'.'.$ext.'%%';
			$this->content = str_replace($url, $pictureTag, $this->content);
		}

		$export = array(
			'id'			 => $this->id,
			'label' 		 => $this->label,
			'content' 		 => $this->content,
			'scoreCondition' => $this->scoreCondition,
		);

		return $export;
	}


	/**
	 * Duplicate appreciation 
	 * @param int $newQuizId the new quiz ID
	 * @return boolean [true|false]
	 */
	public function duplicate($newQuizId) 
	{
		global $wpdb;

		$wpdb->query('CREATE TEMPORARY TABLE wpvq_tmptable_1 SELECT * FROM '.WPViralQuiz::getTableName('appreciations').' WHERE id = '.$this->id.'');
		$wpdb->query('UPDATE wpvq_tmptable_1 SET id = NULL, quizId = '.$newQuizId.'');
		$wpdb->query('INSERT INTO '.WPViralQuiz::getTableName('appreciations').' SELECT * FROM wpvq_tmptable_1');
		$wpdb->query('DROP TEMPORARY TABLE IF EXISTS wpvq_tmptable_1;');
		
		// Update multipliers
		$newAppreciationId = $wpdb->insert_id;
		$wpdb->query('UPDATE '.WPViralQuiz::getTableName('multipliers').' SET appreciationId = '.$newAppreciationId.' WHERE appreciationId = '.$this->id.' AND quizId = -1');
	}

	/**
	 * Does an appreciation exist ?
	 * @param  int $id ID of appr.
	 * @return bool
	 */
	static public function exists($id)
	{
		global $wpdb;

		if (!is_numeric($id)) {
			throw new Exception("Need numeric ID on Appreciation load ($id).");
		}

		// Fetch from DB
		$row = $wpdb->get_row('SELECT * FROM ' . WPViralQuiz::getTableName('appreciations') . ' WHERE ID = ' . $id);

		return !(empty($row));
	}

	/**
	 * Returns an appreciation object for a $quizId and a $score
	 * @param  [type] $score [description]
	 * @return [type]        [description]
	 */
	static public function getAppreciationByScore($quizId, $score)
	{
		if (!is_numeric($quizId) || !is_numeric($score)) {
			return NULL;
		}

		$type = WPVQGame::getTypeById($quizId);
		$quiz = new $type();
		$quiz->load(intval($quizId));

		$appreciations = $quiz->getAppreciations();
		if (empty($appreciations) || !is_numeric($score)) {
			return NULL;
		}

		// Force DESC order for scoreCondition appreciation items
		// Anonymous functions not supported by php < 5.3 :(
		// See snippets.php
		usort($appreciations, 'wpvq_usort_callback_function');

		$currentAppreciation 	= NULL;
		foreach ($appreciations as $appreciation)
		{
			if ($appreciation->getScoreCondition() > $score) {
				$currentAppreciation = $appreciation;
			}
		}

		return $currentAppreciation;
	}

}