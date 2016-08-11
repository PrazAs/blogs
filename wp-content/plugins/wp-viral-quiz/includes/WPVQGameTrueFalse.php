<?php

class WPVQGameTrueFalse extends WPVQGame {

	/**
	 * ----------------------------
	 * 		  ATTRIBUTS
	 * ----------------------------
	 */
	

	// ...


	/**
	 * ----------------------------
	 * 		    GETTERS
	 * ----------------------------
	 */


	function __construct()
	{
		parent::__construct();
	}


	/**
	 * Get the appreciation based on current score
	 * @return object ::Appreciation
	 */
	public function getCurrentAppreciation()
	{
		// Get the first value
		$previousValue = key($this->appreciations);
		next($this->appreciations);

		// If player gets the first appreciation
		if ($this->score <= $previousValue) {
			$appreciationRank = $previousValue;
		} 

		// else, we need to find the correct appreciation
		else {
			next($this->appreciations);
			foreach ($this->appreciations as $key => $value)
			{
				if ($this->score > $previousValue && $this->score <= $key) {
					$appreciationRank = $key;
					break;
				} else {
					$previousValue = $key;
				}
			}
		}


		return $this->appreciations[$appreciationRank];
	}

	/**
	 * Returns the list of answer with their weight (1 or 0)
	 * Encrypted keys : 
	 * 	- a9374 means 'answers'
	 * 	- ra98euef means 'rightAnswers'
	 *  - e9878 means 'explanation'
	 *  - ai0099 means 'answerId'
	 */
	public function getAnswersTable()
	{
		$answersTable = array(
			/*answer = */ 		'a9374' 	=> array(/* answerId => weight */),
			/*rightAnswers = */	'ra98euef' 	=> array(/* questionId => answerId,explanation / */),
		);

		foreach ($this->questions as $question)
		{
			foreach($question->getAnswers() as $answer)
			{
				// all the answers (0 or 1)
				$answersTable['a9374'][$answer->getId()] = $answer->getWeight();

				// save right answer
				if ($answer->getWeight() == 1) {
					$answersTable['ra98euef'][$answer->getQuestionId()] = array(
						'ai0099' 	=> $answer->getId(),
						'e9878' 	=> stripslashes($answer->getQuestion()->getContent()),
					);
				}
			}
		}

		return $answersTable;
	}


}