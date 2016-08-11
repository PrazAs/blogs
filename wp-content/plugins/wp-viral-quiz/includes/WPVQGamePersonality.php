<?php

class WPVQGamePersonality extends WPVQGame {

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
	 * Get the most heaviest value
	 * @return int The value key
	 */
	private function getBestScore()
	{
		$heaviestValues = array_keys($this->score, max($this->score));

		return $heaviestValues[0]; // return the first value
	}

	/**
	 * Get the appreciation based on current score
	 *
	 *
	 * 
	 * @return object ::Appreciation
	 */
	public function getCurrentAppreciation()
	{
		$currentAppreciation = $this->appreciations[ $this->getBestScore() ];

		return $currentAppreciation;
	}



}