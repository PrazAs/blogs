(function($) { 

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 	       ALERT WINDOW IF QUIZ NOT SAVED
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */

	// Need to save before closing tab!
	window.addEventListener("beforeunload", function (e) 
	{
		if (!wpvq_needSave) return;
		(e || window.event).returnValue = php_vars.wpvq_i18n_needSaveAlert; //Gecko + IE
		return php_vars.wpvq_i18n_needSaveAlert;                            //Webkit, Safari, Chrome
	});

	// Detect changes on main input fields
	$('.vq-question-label, .vq-quiz-name, .vq-answer-label, .vq-appreciation-label, textarea, .vq-scoreCondition-label, #wpvq-global-settings-addquiz input').on('change', function() 
	{
		if (!wpvq_needSave) {
			wpvq_needSave = true;
		}
	});

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 	    		SINGLE QUIZ SETTINGS
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	
	/**
	 * --------------------
	 * MARKETING SETTINGS
	 * - ASK INFORMATION
	 * - MAILCHIMP
	 * --------------------
	 */

	// Toggle settings when edit quiz page is loaded
	$('.wpvq-onoffswitch').each(function(){
		wpvq_toggle_settings_section($(this));
	});
	
	// Real Event triggers
	// On/off "Ask info at the end ?"
	// On/off "Mailchimp Sync ?"
	$('.wpvq-onoffswitch').click(function() {
		wpvq_toggle_settings_section($(this));
	});

	// Toggle Snippet
	function wpvq_toggle_settings_section($OnOffSwitchDiv)
	{
		var section 	=  $OnOffSwitchDiv.attr('data-select-section');
		var subSection 	=  $OnOffSwitchDiv.attr('data-select-sub-section');
		var isChecked 	=  $OnOffSwitchDiv.find('input[type=checkbox]').is(':checked');

		if (isChecked) {
			$('[data-section=' + section +']').show('fast');
			$('[data-sub-section=' + subSection + ']').show('fast');
		} else {
			$('[data-section=' + section +']').hide('fast');
			$('[data-sub-section=' + subSection + ']').hide('fast');
		}
	}

	/**
	 * -----------------------------
	 *   RANDOM QUESTIONS SETTINGS
	 * -----------------------------
	 */

	// Manage the checkbox+input for "Display Random Questions"
	$(window).load(function(e) 
	{
		var checkboxState = $('input#wpvq-randomQuestionsCheckbox').is(':checked');
		if (!checkboxState) {
			$('#wpvq-randomQuestionsFields').css('opacity', '.5');
			$('#wpvq-randomQuestions').attr("disabled", "disabled");
		}
	});

	$('input#wpvq-randomQuestionsCheckbox').click(function()
	{
		var checkboxState = $('input#wpvq-randomQuestionsCheckbox').is(':checked');
		if (!checkboxState) {
			$('#wpvq-randomQuestionsFields').css('opacity', '.5');
			$('#wpvq-randomQuestions').attr("disabled", "disabled");
		} else {
			$('#wpvq-randomQuestionsFields').css('opacity', '1');
			$('#wpvq-randomQuestions').removeAttr("disabled");
		}
	});

	/**
	 * Minimize questions
	 */
	$(document).delegate('span.wpvq-window-options-minimize', 'click', function() {
		$(this).parent().nextAll('.wpvq-window-content').toggle();
		return false;
	});

	$(document).delegate('.wpvq-shortcuts-minimize-all', 'click', function(e) {
		$('.wpvq-window-content').hide();
	});

	$(document).delegate('.wpvq-shortcuts-expand-all', 'click', function(e) {
		$('.wpvq-window-content').show();
	});

	$(document).delegate('.wpvq-shortcuts-scroll-to-top', 'click', function(e) {
		$('html, body').animate( { scrollTop: $('#wpvq-navbar').offset().top }, 750 );	
	});

	$(document).delegate('.wpvq-shortcuts-scroll-to-bottom', 'click', function(e) {
		$('html, body').animate( { scrollTop: $('.wpvq-submit-tab').offset().top }, 750 );	
	});

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 			Can't save a TrueFalseQuiz with empty ScoreCondition
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	$('.wpvq-submit-tab').click(function(e) 
	{
		// Score Condition
		var scoreConditionOK = true;
		$('input.vq-scoreCondition-label').each(function(){
			if ($(this).val() == '') {
				scoreConditionOK = false;
			}
		});

		if (!scoreConditionOK) {
			e.preventDefault();
			alert(php_vars.wpvq_i18n_badScoreConditionAlert);
		}

		wpvq_needSave = false;
	});

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 			DELETE A PICTURE IN QUESTION
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	
	$('.wpvq-delete-picture-question').click(function(e) 
	{
		var questionIndex = $(this).attr('data-questionIndex');
		$('.vq-pictureUploaded[data-questionIndex='+questionIndex+'][data-answerIndex=0]').attr('src', php_vars.wpvq_plugin_dir + 'views/img/photo-placeholder.jpg'); // delete picture
		$('.pictureId[data-questionIndex='+questionIndex+'][data-answerIndex=0]').val(''); // empty field
		$('span.wpvq-delete-picture-question[data-questionIndex="'+questionIndex+'"][data-answerIndex=0]').hide();

		if (wpvq_showMiniature) {
			$('a.wpvq-picture-url-link[data-questionIndex="'+questionIndex+'"][data-answerIndex="0"]').attr('href', '#');
			$('a.wpvq-picture-url-link[data-questionIndex="'+questionIndex+'"][data-answerIndex="0"]').text('');
		}

		wpvq_needSave = true;
	});

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 			DELETE A PICTURE IN ANSWER
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	
	$('.wpvq-delete-picture-answer').click(function(e) 
	{
		var questionIndex 	= $(this).attr('data-questionIndex');
		var answerIndex 	= $(this).attr('data-answerIndex');
		$('.vq-pictureUploaded[data-questionIndex='+questionIndex+'][data-answerIndex='+answerIndex+']').attr('src',''); // delete picture
		$('.vq-pictureUploaded[data-questionIndex='+questionIndex+'][data-answerIndex='+answerIndex+']').css('height','30px'); 
		$('.pictureId[data-questionIndex='+questionIndex+'][data-answerIndex='+answerIndex+']').val(''); // empty field
		$('span.wpvq-delete-picture-answer[data-questionIndex="'+questionIndex+'"][data-answerIndex="'+answerIndex+'"]').show();

		if (wpvq_showMiniature) {
			$('a.wpvq-picture-url-link[data-questionIndex="'+questionIndex+'"][data-answerIndex="'+answerIndex+'"]').attr('href', '#');
			$('a.wpvq-picture-url-link[data-questionIndex="'+questionIndex+'"][data-answerIndex="'+answerIndex+'"]').text('');
		}
		
		wpvq_needSave = true;
	});

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 				CKEDITOR LOADER
	 *  	  ! ! ! TRIVIA QUIZ ONLY ! ! !
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	if (vqDataQuizType == 'WPVQGameTrueFalse') {

		// TrueFalse QUIZZ
		$('textarea[id^="vqquestions"]').each(function() {
			CKEDITOR.replace( $(this).attr('id'), {
				enterMode:wpvq_cke_enterMode 
			});
		});

		// TrueFalse QUIZZ
		$('textarea[id^="vqappreciations"]').each(function() {
			CKEDITOR.replace( $(this).attr('id'), {
				enterMode:wpvq_cke_enterMode 
			});
		});


	/**
	 * #################################################
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 		   !! PERSONALITY QUIZ ONLY !!
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * #################################################
	 */

	} else if (vqDataQuizType == 'WPVQGamePersonality') {

		// Personality QUIZZ
		$('textarea[id^="vqappreciations"]').each(function() {
			CKEDITOR.replace( $(this).attr('id'), {
				enterMode:wpvq_cke_enterMode
			});
		});


	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 			CREATE A NEW PERSONALITY
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
		

		$('.vq-add-personality').click(function(e) {
			e.preventDefault();
			var $page = $(wpvq_template_personality); // empty :(

			// #1, #2...  Number display
	  		$page.find('span.vq-appreciationNum').text(appreciationIndex);

			// Update fields names (for a nice $_POST in controller)
			$page.find('input[name=£appreciationLabel£]').attr('name', 'vqappreciations['+ appreciationIndex +'][label]');
			$page.find('textarea[name=£appreciationContent£]').attr('name', 'vqappreciations['+ appreciationIndex +'][content]');
			$page.find('input[name=£appreciationId£]').attr('name', 'vqappreciations['+ appreciationIndex +'][id]');

			// Append to DOM
			var rawhtml  	=  $page.html();
			rawhtml 		=  rawhtml.replace(new RegExp('%%[a-zA-Z]*%%', 'gi'), '');
			$("#vq-list-personalities").append(rawhtml);

			CKEDITOR.replace( 'vqappreciations['+ appreciationIndex +'][content]', {
				enterMode:wpvq_cke_enterMode
			});

			// Enable button
			appreciationIndex++;

			wpvq_needSave = true;
		});

		/**
		 * * * * * * * * * * * * * * * * * * * * * * * * * * 
		 * 			DELETE A PERSONALITY IN DA LIST
		 * * * * * * * * * * * * * * * * * * * * * * * * * * 
		 */
		$(document).on('click', '.delete-personality-button', function(){
			var appreciationId = $(this).attr('data-appreciationId');
			addToDeleteInput(appreciationId, 'deleteAppreciations');
			$(this).closest('.vq-bloc').remove();

			wpvq_needSave = true;
		});

	}



	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 		WORDPRESS MEDIA UPLOADER WINDOW
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	
    var custom_uploader;
		var contentType;
		var questionNum;
		var answerNum;

    $(document).on('click', '.vq-upload_image_button' ,function(e) {

    	questionNum 	= $(this).attr('data-questionIndex');
    	answerNum 		= $(this).attr('data-answerIndex');
    	var $uploadButton = $(this);

    	// Content TYPE : question | answer
    	// dépend du data answerIndex (qui n'existe que sur les answer button upload)
    	if(typeof answerNum === 'undefined') {
    		contentType = 'question';
    	} else {
    		contentType = 'answer';
    	}
 
        e.preventDefault();
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() 
        {
        	attachment 			=  custom_uploader.state().get('selection').first().toJSON();
        	var id 				=  attachment.id;
        	var url 			=  attachment.url;

    		$('img[data-questionIndex="'+questionNum+'"][data-answerIndex="'+answerNum+'"]').css('height', 'auto');

            // Set image + Input hidden ID
            if (contentType == 'question') 
            {
            	$('input[type=hidden][data-questionIndex="'+questionNum+'"][data-answerIndex="0"]').val(id);
				$('img[data-questionIndex="'+questionNum+'"][data-answerIndex="0"]').attr('src', url);
				$('span.wpvq-delete-picture-question[data-questionIndex="'+questionNum+'"]').show();
				
				if (wpvq_showMiniature) {
					$('a.wpvq-picture-url-link[data-questionIndex="'+questionNum+'"][data-answerIndex="0"]').attr('href', url);
					$('a.wpvq-picture-url-link[data-questionIndex="'+questionNum+'"][data-answerIndex="0"]').text(url);
				}
            } 
            else if (contentType == 'answer') 
            {
            	$('input[type=hidden][data-questionIndex="'+questionNum+'"][data-answerIndex="'+answerNum+'"]').val(id);
            	$('img[data-questionIndex="'+questionNum+'"][data-answerIndex="'+answerNum+'"]').attr('src', url);
            	$('img[data-questionIndex="'+questionNum+'"][data-answerIndex="'+answerNum+'"]').css('height', 'auto');
            	$('span.wpvq-delete-picture-answer[data-questionIndex="'+questionNum+'"][data-answerIndex="'+answerNum+'"]').show();

            	if (wpvq_showMiniature) {
					$('a.wpvq-picture-url-link[data-questionIndex="'+questionNum+'"][data-answerIndex="'+answerNum+'"]').attr('href', url);
					$('a.wpvq-picture-url-link[data-questionIndex="'+questionNum+'"][data-answerIndex="'+answerNum+'"]').text(url);
				}
            }

            wpvq_needSave = true;
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 				ADD A NEW QUESTION
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	
	$('.vq-add-question').click(function()
	{
		var $page = $(wpvq_template_question);

		// #1, #2...  Number display
		$page.find('span.vq-questionNum').text(questionIndex);

		// Meta Question Index Data
		$page.find('[data-questionIndex]').attr('data-questionIndex', questionIndex);

		// Update fields names (for a nice $_POST in controller)
		$page.find('input[name=£pictureId£]').attr('name', 'vqquestions['+ questionIndex +'][pictureId]');
		$page.find('textarea[name=£questionLabel£]').attr('name', 'vqquestions['+ questionIndex +'][label]');
		$page.find('input[name=£questionId£]').attr('name', 'vqquestions['+ questionIndex +'][id]');
		$page.find('input[name=£questionContentCheckbox£]').attr('name', 'vqquestions['+ questionIndex +'][questionContentCheckbox]');
		$page.find('input[name=£pageAfterCheckbox£]').attr('name', 'vqquestions['+ questionIndex +'][pageAfter]');

		// Pré-remplir le champ.
		$page.find('input[name=£questionPosition£]').attr('name', 'vqquestions['+ questionIndex +'][position]');$
		$page.find('.questionContent').attr('value', questionIndex);

		$page.find('textarea[name=£questionContent£]').attr('name', 'vqquestions['+ questionIndex +'][content]');

		// Append to DOM
		var rawhtml = $page.html();

		// No placeholder when showing miniature
		if (wpvq_showMiniature) {
			rawhtml = rawhtml.replace(new RegExp('%%questionPictureUrl%%', 'gi'), '#');	
		} else {
			rawhtml = rawhtml.replace(new RegExp('%%questionPictureUrl%%', 'gi'), php_vars.wpvq_plugin_dir + 'views/img/photo-placeholder.jpg');
		}

		rawhtml = rawhtml.replace(new RegExp('%%[a-zA-Z]*%%', 'gi'), '');
		$("#vq-questions").append(rawhtml);

		if (vqDataQuizType == 'WPVQGameTrueFalse') {
			CKEDITOR.replace( 'vqquestions['+ questionIndex +'][content]', {
				enterMode:wpvq_cke_enterMode
			});
		}

		updateTotalNumberQuestions();

		// Append to DOM
		questionIndex++;

		wpvq_needSave = true;
	});

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 				ADD A NEW ANSWER
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	$(document).on('click', '.vq-add-answer', function() 
	{
		questionNum = $(this).attr('data-questionIndex');
		var $page = $(wpvq_template_answer);

		// Answer index++ for this question
		if (typeof answersIndex[questionNum] === 'undefined') {
			answersIndex[questionNum] = 1;
		} else {
			answersIndex[questionNum]++;
		}

		// Meta Answer Index Data
		$page.find('[data-questionIndex]').attr('data-questionIndex', questionNum);
		$page.find('[data-answerIndex]').attr('data-answerIndex', answersIndex[questionNum]);

		// Update fields names (for a nice $_POST in controller)
		$page.find('input[name=£pictureId£]').attr('name', 'vqquestions['+ questionNum +'][answers][' + answersIndex[questionNum] + '][pictureId]');
		$page.find('input[name=£answerLabel£]').attr('name', 'vqquestions['+ questionNum +'][answers][' + answersIndex[questionNum] + '][label]');
		$page.find('input[name=£rightAnswer£]').attr('name', 'vqquestions['+ questionNum +'][answers][' + answersIndex[questionNum] + '][rightAnswer]');
		$page.find('input[name=£answerId£]').attr('name', 'vqquestions['+ questionNum +'][answers][' + answersIndex[questionNum] + '][id]');

		if (vqDataQuizType == 'WPVQGamePersonality') 
		{
			// If no personalities, alert !
			if (wpvq_template_multipliers == '') {
				var $selector = $page.find('div.wpvq-multipliers-answer').html('<div class="wpvq-alert-no-personality">'+php_vars.wpvq_i18n_noPersonality+'</div>');
			} else {
				// Put the multipliers template into the answers template
				var $selector = $page.find('div.wpvq-multipliers-answer').html(wpvq_template_multipliers);
			}

			// Fill the data value + change name
			$selector.find('[data-questionIndex]').attr('data-questionIndex', questionNum);
			$selector.find('[data-answerIndex]').attr('data-answerIndex', answersIndex[questionNum]);
			$selector.find('select').each(function() {
				var personalityId = $(this).attr('data-personalityId');
				$(this).attr('name', 'vqquestions['+ questionNum +'][answers][' + answersIndex[questionNum] + '][multiplier]['+personalityId+']');
			});
		}

		// Append HTML
		var rawhtml = $page.html();
		rawhtml = rawhtml.replace(new RegExp('%%answerPictureUrl%%', 'gi'), '');
		rawhtml = rawhtml.replace(new RegExp('%%[a-zA-Z]*%%', 'gi'), '');
		$('.vq-answers[data-questionIndex="'+questionNum+'"]').append(rawhtml);

		wpvq_needSave = true;
	});

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 	  SHOW THE "EXPLAIN QUESTION" TEXTAREA FIELD
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	$(document).on('click', 'input.vq-explain-checkbox', function(){

		var theQuestionIndex = $(this).attr('data-questionIndex');
		if ($(this).is(':checked'))  {
			$('.vq-bloc[data-questionIndex=' + theQuestionIndex + '] .hide-the-editor').show()
		} else  {
			$('.vq-bloc[data-questionIndex=' + theQuestionIndex + '] .hide-the-editor').hide();
		}

	});

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 			DELETE A QUESTION IN DA LIST
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	$(document).on('click', '.delete-question-button', function(){
		var questionId = $(this).attr('data-questionId');
		addToDeleteInput(questionId, 'deleteQuestions');
		$(this).closest('.vq-bloc').remove();
		updateTotalNumberQuestions();

		wpvq_needSave = true;
	});


	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 			DELETE AN ANSWER IN DA LIST
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	$(document).on('click', '.delete-answer-button', function(){
		var answerId = $(this).attr('data-answerId');
		addToDeleteInput(answerId, 'deleteAnswers');
		$(this).closest('.vq-bloc').remove();

		wpvq_needSave = true;
	});


	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 		GENERATE HIDDEN INPUT FIELD TO DELETE STUFF
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 */
	function addToDeleteInput(id, inputName) {

		if (typeof id === 'undefined' || id == '') {
			return;
		}

		// Add to input
		var values 		=  $('input[name="' + inputName + '"]').val()
		var newValues 	=  values + id + ',';

		$('input[name="' + inputName + '"]').val(newValues);
	}

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 		UPDATE QUESTIONS COUNTER ("[input] / Y")
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	function updateTotalNumberQuestions() {
		var total = $('.wpvq-uniq-question').length;
		$('.total-uniq-question').each(function(){
			$(this).text(total);
		})
	}

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 		CREATE A NEW APPRECIATION (TrueFalse)
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
		

	$('.vq-add-appreciation').click(function(e) 
	{
		e.preventDefault();
		var $page = $(wpvq_template_appreciation);

		// Update fields names (for a nice $_POST in controller)
		$page.find('input[name=£scoreCondition£]').attr('name', 'vqappreciations['+ appreciationIndex +'][scoreCondition]');
		$page.find('textarea[name=£appreciationContent£]').attr('name', 'vqappreciations['+ appreciationIndex +'][content]');
		$page.find('input[name=£appreciationId£]').attr('name', 'vqappreciations['+ appreciationIndex +'][id]');

		// Append to DOM
		var rawhtml  	=  $page.html();
		rawhtml 		=  rawhtml.replace(new RegExp('%%[a-zA-Z]*%%', 'gi'), '');
		$("#vq-list-appreciations").append(rawhtml);

		CKEDITOR.replace( 'vqappreciations['+ appreciationIndex +'][content]', {
				enterMode:wpvq_cke_enterMode
			});

		// Enable button
		appreciationIndex++;

		wpvq_needSave = true;
	});

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 *  Generate Aweber Creds using Auth Code		
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */

	$('#wpvq-generate-aweber-creds').click(function(e)
	{
		var code = $('#wpvq-aweber-authCode').val();

		if (code == '') {
			alert('Empty auth code. Click on "Learn to configure" if you need help.');
			return false;
		}

		$.post(
			ajaxurl,
			{ 'action': 'wpvq_generate_aweber_creds', 'authCode': code }, 
			function(response) 
			{
				if(response.status == 'OK')
				{
					$('#wpvq-aweber-accessKeys').val(
						response.consumerKey+'|'+
						response.consumerSecret+'|'+
						response.accessKey+'|'+
						response.accessSecret
					);

					$('#wpvq-access-key-status-ok').show();
					$('#wpvq-access-key-status-fail').hide();
				}
				else
				{
					$('#wpvq-access-key-status-ok').hide();
					$('#wpvq-access-key-status-fail').show();
					alert('Error, bad auth code. Refresh the Aweber auth code page and try again.');
				}
			},
			'json'
		);
	});

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 			DELETE A PERSONALITY IN DA LIST
	 * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 */
	$(document).on('click', '.delete-appreciation-button', function() 
	{
		// For controller
		var appreciationId = $(this).attr('data-appreciationId');
		addToDeleteInput(appreciationId, 'deleteAppreciations');

		$(this).closest('.vq-bloc').remove();

		wpvq_needSave = true;
	});

	

})(jQuery);