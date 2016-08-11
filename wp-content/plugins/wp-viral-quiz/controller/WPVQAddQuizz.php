<?php 

// DATA
global $vqData;

// Fetch TYPE
if (isset($_GET['type'])) {
	$vqData['type'] = htmlentities($_GET['type']);
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$vqData['type'] = WPVQGame::getTypeById($_GET['id']);
}

// Global option
$options = get_option('wpvq_settings');
$vqData['showMiniature'] = (isset($options['wpvq_checkbox_backoffice_miniature'])) ? true:false;

// Get ID (or NULL)
// Useful for redirection after submit, and other stuff.
$vqData['quizId'] = NULL; $vqData['quizName'] = '';

$vqData['showSharing'] 			=  1; 
$vqData['showCopyright'] 		=  0; 
$vqData['skin'] 				=  'buzzfeed';
$vqData['askInformations'] 		=  array(); 
$vqData['forceToShare'] 		=  array();

$vqData['isRandomQuestions'] 	=  false; 
$vqData['randomQuestions'] 		=   -1;
$vqData['isRandomAnswers'] 		=  false;

$vqData['meta'] 				=  null;
$vqData['extraOptions'] 		=  null;

$referer = 'create';

/**
 * Prepare the controller for EDIT MODE
 */
if (isset($_GET['action']) && $_GET['action'] == 'edit' && is_numeric($_GET['id']))
{
	$referer 			=  'update';
	$vqData['quizId'] 	=  intval($_GET['id']);

	$quiz = new $vqData['type'](); // todo : vérifier type
	$quiz->load($vqData['quizId']);

	$vqData['quizName'] 			=  stripslashes($quiz->getName());
	$vqData['parsedView'] 			=  $quiz->getParsedViewQuestions($vqData['showMiniature']);
	$vqData['JS_questionIndex'] 	=  $quiz->countQuestions() + 1; // don't begin at 0.
	$vqData['JS_answersIndex'] 		=  json_encode($quiz->countAnswers(true));

	$vqData['showSharing'] 			=  $quiz->getShowSharing();
	$vqData['showCopyright'] 		=  $quiz->getShowCopyright();
	$vqData['askInformations'] 		=  $quiz->getAskInformations();
	$vqData['forceToShare'] 		=  $quiz->getForceToShare();
	$vqData['skin'] 				=  $quiz->getSkin();

	$vqData['isRandomQuestions'] 	=  $quiz->isRandomQuestions(); 
	$vqData['randomQuestions'] 		=  ($vqData['isRandomQuestions']) ? $quiz->getRandomQuestions() : '';
	$vqData['isRandomAnswers'] 		=  $quiz->isRandomAnswers();
	
	$vqData['meta'] 				=  $quiz->getMeta();
	$vqData['extraOptions'] 		=  $quiz->getExtraOptions();

	// HTML View on edit
	$vqData['parsedViewAppreciations'] 		=  $quiz->getParsedViewAppreciations();
	$vqData['JS_appreciationIndex']  		=  $quiz->countAppreciations() + 1; // don't begin at 0.

	// Appreciations for personality type
	if ($vqData['type'] == 'WPVQGamePersonality') 
	{
		// Build JS tab of appreciations
		$vqData['appreciations'] 				=  $quiz->getAppreciations();
		$vqData['JS_vqPersonalities'] 			=  array();
		foreach($quiz->getAppreciations() as $index => $appreciation) 
		{
			$vqData['JS_vqPersonalities'][] 	=  array(
				'label'  =>  $appreciation->getLabel(),
			);
		}

		$vqData['JS_vqPersonalities'] = json_encode($vqData['JS_vqPersonalities']);

		// Personalities selected list attribute (selected option on <select> input)
		$vqData['JS_selectedAppreciations'] = array();
		foreach($quiz->getQuestions() as $indexQ => $question) 
		{
			foreach($question->getAnswers() as $indexA => $answer) 
			{
				$appreciationId  =  $answer->getWeight();	

				try {
					$appreciation 	 =  new WPVQAppreciation();
					$appreciation->load($appreciationId);			
				} catch (Exception $e) {
					continue;
				}

				$vqData['JS_selectedAppreciations'][($indexQ+1)][($indexA+1)] = $appreciation->getLabel();
			}
		}
		$vqData['JS_selectedAppreciations'] = json_encode($vqData['JS_selectedAppreciations']);
	}
}

// Templates for the JS view
$vqData['template']['question'] 		=  '';
$vqData['template']['answer'] 			=  '';
$vqData['template']['multipliers']		=  '';
$vqData['template']['appreciation']		=  '';
$vqData['template']['personality'] 		=  '';

if ($vqData['type'] == 'WPVQGamePersonality') 
{
	$vqData['template']['personality'] 		=  wpvq_get_view('WPVQAddQuestion.WPVQGamePersonality.personality.append.php');
	$vqData['template']['question'] 		=  wpvq_get_view('WPVQAddQuestion.WPVQGamePersonality.append.php');
	$vqData['template']['answer'] 			=  wpvq_get_view('WPVQAddQuestion.WPVQGamePersonality.answer.append.php');

	// Multipliers templates (depends on the appreciations saved in the DB)
	$multiplier_view_template = wpvq_get_view('WPVQAddQuestion.WPVQGamePersonality.answer.append.multiplier.php');
	if ($vqData['quizId'] != NULL) // only for existing quiz
	{ 
		foreach ($quiz->getAppreciations() as $index => $appreciation) 
		{
			$multiplier_view = $multiplier_view_template;
			$multiplier_view = str_replace('%%personalityLabel%%', $appreciation->getLabel(), $multiplier_view);
			$multiplier_view = str_replace('%%personalityId%%', $appreciation->getId(), $multiplier_view);
			$multiplier_view = str_replace('%%multiplierValue%%', 0, $multiplier_view);

			$vqData['template']['multipliers'] 	.= $multiplier_view;
		}
	}
} 
else 
{
	$vqData['template']['appreciation'] 	=  wpvq_get_view('WPVQAddQuestion.WPVQGameTrueFalse.appreciation.append.php');
	$vqData['template']['question']	 		=  wpvq_get_view('WPVQAddQuestion.WPVQGameTrueFalse.append.php');
	$vqData['template']['answer'] 			=  wpvq_get_view('WPVQAddQuestion.WPVQGameTrueFalse.answer.append.php');
}

// Create ou update the quiz when submited by user
if (isset($_POST['activeTab']) && !empty($_POST['activeTab']) && isset($_POST['quizId']))
{
	// Useful var
	$activeTab 	=  htmlentities($_POST['activeTab']);
	$quizId 	=  intval($_POST['quizId']);
	$quizType 	=  htmlentities($_POST['type']);
	$param 		=  array();

	// Is it a new quiz ? (creation process)
	if ($newQuiz = ($_POST['quizId'] == ''))
	{
		$quiz = new $quizType(); // todo : check $type
		$quiz->add($param);
		$quizId = $quiz->getId();
	}

	/**
	 * ================================================
	 * 				CONFIGURATION PROCESS
	 * ================================================
	 */
	if ($activeTab == 'configuration')
	{
		$param['name'] 				=  sanitize_text_field($_POST['quizName']);
		$param['showSharing'] 		=  (isset($_POST['showSharing'])) ? 1:0;
		$param['showCopyright'] 	=  (isset($_POST['showCopyright'])) ? 1:0;
		$param['skin'] 				=  sanitize_text_field($_POST['skin']);
		$param['forceToShare'] 		=  explode(',', sanitize_text_field($_POST['forceToShare']));
		$param['isRandomAnswers'] 	=  (isset($_POST['isRandomAnswers'])) ? 1:0;
		$param['randomQuestions'] 	=  (isset($_POST['randomQuestions']) && is_numeric($_POST['randomQuestions'])) ? intval($_POST['randomQuestions']):0;

		// Meta
		$param['meta'] 						=  array();
		$param['meta']['playAgain'] 		=  (isset($_POST['playAgain'])) ? 1:0;
		$param['meta']['hideRightWrong'] 	=  (isset($_POST['hideRightWrong'])) ? 1:0;
		$param['meta']['redirectionPage'] 	=  (!filter_var($_POST['redirectionPage'], FILTER_VALIDATE_URL) === false) ? sanitize_text_field($_POST['redirectionPage']):'';

		// If enable the main section "Ask Informations"
		$askInformations_section = (isset($_POST['askInformations_section']));
		if ($askInformations_section)
		{
			$param['askInformations'] = (isset($_POST['askInformations'])) ? $_POST['askInformations']:array();	

			// Mailchimp Integration
			$mailchimp_section = (isset($_POST['askInformations_mailchimp_section']));
			if ($mailchimp_section)
			{
				$param['meta']['mailchimp']['apiKey'] 				= sanitize_text_field($_POST['mailchimp_apiKey']);
				$param['meta']['mailchimp']['listId'] 				= sanitize_text_field($_POST['mailchimp_listId']);
				$param['meta']['mailchimp']['firstNameField'] 		= sanitize_text_field($_POST['mailchimp_firstNameField']);
				$param['meta']['mailchimp']['resultField'] 			= sanitize_text_field($_POST['mailchimp_resultField']);
				$param['meta']['mailchimp']['doubleOptin'] 			= (isset($_POST['mailchimp_doubleOptin'])) ? 1:0;
			}

			// Aweber Integration
			$mailchimp_section = (isset($_POST['askInformations_aweber_section']));
			if ($mailchimp_section)
			{
				$param['meta']['aweber']['accessKeys'] 	 =  sanitize_text_field($_POST['aweber_accessKeys']);
				$param['meta']['aweber']['listId'] 		 =  sanitize_text_field($_POST['aweber_listId']);
				$param['meta']['aweber']['resultField']  =  sanitize_text_field($_POST['aweber_resultField']);
			}
		}
		else
		{
			$param['askInformations'] = array();
		}

		// Update the model
		$quiz->add($param, $quizId);

		// Update options (new system)
		$extraOptions = isset($_POST['wpvqExtraOptions']) ? $_POST['wpvqExtraOptions']:array();
		foreach($extraOptions as $key => $value)
		{
			$quiz->_updateExtraOption($key, $value);
		}

	} // end of tab=CONFIGURATION

	/**
	 * ================================================
	 * 		    QUESTIONS / ANSWERS PROCESS
	 * ================================================
	 */
	
	if ($activeTab == 'questions')
	{
		/**
		 * Delete stuff for update
		 */
		$deleteAnswers = array_filter(explode(',', $_POST['deleteAnswers']));
		foreach($deleteAnswers as $answerId) {
			$answer = new WPVQAnswer();
			try {
				$answer->load(intval($answerId))->delete();	
			} catch (Exception $e) { }
		}

		$deleteQuestions = array_filter(explode(',', $_POST['deleteQuestions']));
		foreach($deleteQuestions as $questionId) {
			$question = new WPVQQuestion();
			try {
				$question->load(intval($questionId))->delete();	
			} catch (Exception $e) { }
		}

		/**
		 * Add question and answers
		 */
		$i = 0;
		$vqquestions = (isset($_POST['vqquestions'])) ? $_POST['vqquestions']:array();
		foreach($vqquestions as $question)
		{
			// Empty question
			if ($question['label'] == '' && $question['pictureId'] == 0) {
				continue;
			}

			$param = array();
			$param['label'] 	=  $question['label'];
			$param['pictureId'] =  intval($question['pictureId']);
			$param['position'] 	=  intval($question['position']);
			$param['content'] 	=  (isset($question['content']) && isset($question['questionContentCheckbox'])) ? $question['content']:'';
			$param['pageAfter'] =  (isset($question['pageAfter'])) ? 1:0;
			$theQuestion 		=  $quiz->addQuestion($param, intval($question['id']));

			// Empty answer
			if (!isset($question['answers'])) {
				continue;
			}

			foreach($question['answers'] as $answer) 
			{		
				// Empty answser
				if ($answer['label'] == '' && $answer['pictureId'] == 0) {
					continue;
				}

				// Available here : $answer['personalities'] (appreciationLabel)
				$param = array();
				$param['label'] 	= sanitize_text_field($answer['label']);
		 		$param['pictureId'] = intval($answer['pictureId']);

		 		// Based on quiz type
		 		$multiplierParam = array(); // not used on trivia quiz
		 		if ($quizType == 'WPVQGamePersonality') 
		 		{
		 			// User has created question but no personality at all.
		 			if (!isset($answer['multiplier'])) {
		 				continue;
		 			}
		 			
		 			$multiplierParam = array();
		 			foreach ($answer['multiplier'] as $appreciationId => $multiplier)
		 			{
			 			$multiplierParam[] = array(
			 				'appreciationId' => $appreciationId,
			 				'multiplier'	 => $multiplier, 
			 			);
			 		}

			 		// Useless for personality quiz, just TrueFalse quiz.
			 		$param['weight']	= 0;

		 		} elseif ($quizType == 'WPVQGameTrueFalse') {
					$param['weight'] 	= (isset($answer['rightAnswer'])) ? 1:0;
		 		}

		 		$param['content'] 	= '';
				$theQuestion->addAnswer($param, intval($answer['id']), $multiplierParam);			

				// echo "<pre>";
				// echo "— DEBUG —";
				// print_r($param);
				// echo "</pre>";
			}
			$i++;
		}
	} // end of tab=QUESTIONS

	/**
	 * ================================================
	 * 		      APPRECIATIONS PROCESS
	 * ================================================
	 */
	
	if ($activeTab == 'appreciations')
	{

		// Delete appreciations if we need to
		$deleteAppreciations = array_filter(explode(',', $_POST['deleteAppreciations']));
		foreach($deleteAppreciations as $appreciationId) {
			$appreciation = new WPVQAppreciation();
			try {
				$appreciation->load(intval($appreciationId))->delete();	
			} catch (Exception $e) {}
		}

		// If Personality Quizz
		// => add appreciations
		if ($quizType == 'WPVQGamePersonality' && isset($_POST['vqappreciations'])) 
		{
			foreach($_POST['vqappreciations'] as $appreciation) 
			{
				// Empty appreciation
				if ($appreciation['content'] == '' && $appreciation['label'] == '') {
					continue;
				}

				$param = array();

				// Wordpress addslashes to $_POST by default. But in the case of appreciation,
				// there is an issue with json_encode and slashes. We have to remove slashes here.
				$appreciation['label'] = sanitize_text_field(stripslashes_deep($appreciation['label']));

				$param['label'] 			= $appreciation['label'];
				$param['content'] 			= $appreciation['content'];
				$param['scoreCondition'] 	= 0; 
				$appr = $quiz->addAppreciation($param, intval($appreciation['id']));

				// Link label with ID for the next step
				// $appreciationsAssoc[$appreciation['label']] = intval($appr->getId());
				// $i++;
			}
		}
		else if ($quizType == 'WPVQGameTrueFalse' && isset($_POST['vqappreciations'])) 
		{
			$i=0;
			foreach($_POST['vqappreciations'] as $appreciation) 
			{
				// Empty appreciation
				if ($appreciation['content'] == '' && $appreciation['scoreCondition'] == '') {
					continue;
				}

				$param = array();
				$param['label'] 			= '';
				$param['content'] 			= $appreciation['content'];
				$param['scoreCondition'] 	= intval($appreciation['scoreCondition']); 
				$appr = $quiz->addAppreciation($param, intval($appreciation['id']));

				$i++;
			}
		}
	} // end of tab=APPRECIATIONS

	// Redirect
	$url_quizzes_show = esc_url_raw(add_query_arg(array('referer' => 'update', 'tab' => $activeTab, 'element' => 'quiz','action' => 'edit', 'id' => $quizId), remove_query_arg(array('type', 'noheader'))));
	wp_redirect(url_origin($_SERVER) . $url_quizzes_show);
	die();
}

// VIEW
include dirname(__FILE__) . '/../views/WPVQAddQuizz.php';


