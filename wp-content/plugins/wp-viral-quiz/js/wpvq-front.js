var PopupFeed;
var openDialogFB;

(function($) 
{ 
	if (wpvq_front_quiz)
	{
		/**
		 * Facebook Share Window Without API
		 */
		openDialogFB = function(e, t, n) {
		    var r = window.open(e, t, n);
		    var i = window.setInterval(function() {
		        try {
		            if (r == null || r.closed) {
		                window.clearInterval(i);
		                $('#wpvq-forceToShare-before-results').hide(400, function() {
		                	if (askEmail || askNickname) {
					        	$('#wpvq-ask-before-results').show(400, function() { wpvq_scrollToQuizEnd(); });
					        } else {
					        	$('#wpvq-general-results').show(400, function() { wpvq_scrollToQuizEnd(); wpvq_hook_show_results(); });
					        }
		                });
		            }
		        } catch (e) {}
		    }, 1e3);
		    return r;
		}

		PopupFeed = function(e) {
		    uda = e;
		    openDialogFB("https://www.facebook.com/sharer/sharer.php?u=" + uda, "", "top=100, left=300, width=600, height=300, status=no, menubar=no, toolbar=no scrollbars=no")
		};


		/**
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
		 *
		 * 								EVENTS MAP
		 * 								----------
		 * 								
		 *
		 * 		a — Init :
		 * 			|| 1. Hide everything except page #1
		 * 			
		 *
		 * 		b — When people play :
		 * 			|| 1. Trigger event on click answer
	 	 * 			|| 2. Compute answer 
	 	 * 		 	||  	a) Trivia 		: check if true/false + visual feedback (ajax).
	 	 * 			||  	b) Personality 	: save the choice (local).
	 	 * 			|| 3. Switch page if we need
	 	 * 			|| 4. Scroll to the next question if we want
	 	 * 			
		 *
		 * 		c — (on Ajax Callback) When answer = totalQuestions
		 * 			|| 1. Compute answers
		 * 			|| 		a) Trivia 		: count final score.
		 * 		 	|| 		b) Personality 	: match player personality.
		 * 		 	|| 2. Fill final area (currently hidden)
		 * 			|| 3. Call wpvq_add_social_meta()
		 * 			|| 4. Call wpvq_action_before_results()
		 * 			||		a) Can show "force to share"
		 * 			||		b) Can show "ask info" form
		 * 			||		c) JS hook wpvq_hook_beforeResults() for developers
		 * 			|| 5. Show final area.
		 * 				
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
		 */
		
		// Obfuscated keys :
	 	var key_answers 		= 'a9374';
	 	var key_rightAnswers 	= 'ra98euef';
	 	var key_answerId 		= 'ai0099';
	 	var key_explanation 	= 'e9878';

		var wpvq_scroll_to_explanation  = false;				// prevent to scroll to far if there is an expl. between questions
		var wpvq_lastClicked 			= 0;					// prevent double click on same answer

		var wpvq_global_result 			= null;	 					// convenient for some hook (redirectionPage for example)
		var wpvq_global_results 		= {'quizId':quizId, 'resultValue':null}; // same as above, but more info

		// Page management (browser refresh)
		var wpvq_currentPage = 0;
		var countQuestions = 0;
		if (wpvq_refresh_page) 
		{
			var wpvq_currentPage = wpvq_browser_page;
			wpvq_savedArrayToCheckedAnswers();

			// transmit the nb of questions answered from a page to another
			if (wpvq_countQuestions == false) {
				var countQuestions = $('.wpvq-question input:checked').length;
			} else {
				var countQuestions = wpvq_countQuestions;
			}

			if (wpvq_currentPage > 0) {
				$(document).scrollTop( $(".wpvq").offset().top - 35 - wpvq_scroll_top_offset );  		
			}
		}

		var wpvq_totalPages 			= wpvq_count_pages();	
		var wpvq_block_pageChanging 	= false; 				// block page auto changing 
		var wpvq_block_continue_button 	= false; 				// prevent double click on "continue" button
		var wpvq_begin_new_page 		= false;				// (flag) detect new page, helpful for scroll management
		wpvq_update_progress();

		// Pagination : show first page only at begining
		// By default, ALL PAGES are display=none
		$('#wpvq-page-' + wpvq_currentPage).show();

		// CLICK ON ANSWER : TRUE-FALSE QUIZ
		var countTrueAnswer = $('.wpvq-question .wpvq-answer-true input:checked').length;

		// If wpvq_refresh_page : need to conclude quiz immediatly after refresh (ie new page after last question) ?
		if (wpvq_refresh_page && countQuestions == totalCountQuestions) {
			wpvq_concludeQuiz(wpvq_type);
		}

		// If there is a squeeze page
		$('.wpvq-start-quiz').click(function() {
			$(this).fadeOut(500, function(){ $('.wpvq').fadeIn(); });
		});	

	 	// Useful for hideRightWrong
	 	var rightAnswerCssClass = 'wpvq-answer-true' + ((wpvq_hideRightWrong) ? '-hideRightWrong':'');
		var wrongAnswerCssClass = 'wpvq-answer-false' + ((wpvq_hideRightWrong) ? '-hideRightWrong':'');

		$('.TrueFalse .wpvq-answer').click(function() 
		{
			var $answer 		=  $(this);
			var $parent 		=  $(this).parent();
			var questionId 		=  $parent.attr('data-questionId');
			var isRightAnswer 	=  false;

			// Prevent double click on the same answer
			if ($answer.data('wpvq-answer') == wpvq_lastClicked) { return; }
			wpvq_lastClicked = $answer.data('wpvq-answer');

			if($parent.find('.wpvq-choose').length == 0) 
			{
				$answer.find('input').attr('checked', 'checked');
				$(this).addClass('wpvq-choose');

				var answerId = new String( $(this).data('wpvq-answer') );
				if(wpvq_ans89733[key_answers][answerId] == 1) 
				{
					$answer.addClass(rightAnswerCssClass);
					isRightAnswer = true;
					countTrueAnswer++;
				}
				else 
				{
					$answer.addClass(wrongAnswerCssClass);
					isRightAnswer = false;

					// Highlight true answer
					var $trueAnswer = $parent.find('[data-wpvq-answer=' + wpvq_ans89733[key_rightAnswers][questionId][key_answerId] + ']');
					$trueAnswer.addClass(rightAnswerCssClass);

					console.log($trueAnswer);
				}

				// Show explanation if needed
				if (wpvq_ans89733[key_rightAnswers][questionId][key_explanation] != '')
				{
					// Span "correct!" or "wrong!"
					if(isRightAnswer) {
						$parent.find('div.wpvq-explaination div.wpvq-true').show();
					} else {
						$parent.find('div.wpvq-explaination div.wpvq-false').show();
					}
					
					// wpvq-explaination-content-empty BECOMES wpvq-explaination-content, if not empty
					// Useful for hideRightWrong
					$parent.find('div.wpvq-explaination p.wpvq-explaination-content-empty').addClass('wpvq-explaination-content');
					$parent.find('div.wpvq-explaination p.wpvq-explaination-content-empty').removeClass('wpvq-explaination-content-empty');
					$parent.find('div.wpvq-explaination p.wpvq-explaination-content').html(wpvq_ans89733[key_rightAnswers][questionId][key_explanation]);
					if (!wpvq_hideRightWrong)
					{
						$parent.find('div.wpvq-explaination').show();
						wpvq_scroll_to_explanation = true;

						// Block page auto-changing when multipages + explanation
						if ($parent.attr('data-pageAfter') == 'true') {
							wpvq_block_pageChanging = true;
						}
					}

					// MathJax Support
					// Parse the whole page to find Jax content
					if(typeof MathJax != "undefined") {
						MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
					}
				}

				// Question++
				// var countQuestions = $('.wpvq-question input:checked').length;
				countQuestions++;

				// Scroll to the next question (if possible)
				// But not when for the last answer.
				// And not for the first question of a new page (autoscroll top new page already)
				if (countQuestions != totalCountQuestions && !wpvq_begin_new_page) {
					wpvq_autoscroll_next($parent);
				}

				// Force the continue button
				if (wpvq_force_continue_button && countQuestions != totalCountQuestions) {
					wpvq_block_pageChanging = true;
				}

				// Switch page
				var changePage = wpvq_change_page($parent, -1);
				if (changePage == 0) {
					return;
				}

				if (countQuestions == totalCountQuestions && !wpvq_block_pageChanging) {
					wpvq_concludeQuiz('WPVQGameTrueFalse');
				}
			}
		});

		// CLICK ON ANSWER : PERSONALITY QUIZ
		var personalitiesWeight  = [];
		var maxWeight   		 = 0;
		var personalityTestEnded = false;
		$('.Personality .wpvq-answer').click(function() 
		{
			var $answer = $(this);
			var $parent = $(this).parent();

			// Prevent double click on the same answer
			if ($answer.data('wpvq-answer') == wpvq_lastClicked) { return; }
			wpvq_lastClicked = $answer.data('wpvq-answer');

			// can't play when quiz is ended
			if (personalityTestEnded) {
				return;
			}

			// undo the previous command
			if( !!$parent.find('.wpvq-choose') ){
				$parent.find('.wpvq-choose').removeClass('wpvq-choose');
				$parent.find('input').prop('checked', false);
			}
			
			// when question needs an answer
			if($parent.find('.wpvq-choose').length == 0) 
			{
				$answer.find('input').prop('checked', true);
				$(this).addClass('wpvq-choose');

				// Count checked inputs 
				countQuestions = $('.wpvq-question input:checked').length;

				// Scroll to the next question
				// But not for the last answer
				if (countQuestions != totalCountQuestions && !wpvq_begin_new_page) {
					wpvq_autoscroll_next($parent);
				}

				// Force the continue button
				if (wpvq_force_continue_button && countQuestions != totalCountQuestions) {
					wpvq_block_pageChanging = true;
				}

				var changePage = wpvq_change_page($parent, -1);
				if (changePage == 0) {
					return;
				}

				stopClick = true;

				if (countQuestions == totalCountQuestions) {
					wpvq_concludeQuiz('WPVQGamePersonality');
				}
			}
		});


		// Switch page between questions if we need ("continue button")
		$('.wpvq-next-page-button').click(function() 
		{
			wpvq_block_pageChanging = false;

			// Prevent from double click
			if (!wpvq_block_continue_button) 
			{
				wpvq_block_continue_button = true;
				var changePage = wpvq_change_page($(this).parents('.wpvq-question'), 0);
				if (changePage == 0) {
					return;
				}
			}

			if (countQuestions == totalCountQuestions) 
			{
				wpvq_concludeQuiz(wpvq_type);
			}
		});

		/**
		 * Open Twitter share on a popup window
		 */
		$('.wpvq-twitter-share-popup').click(function(event) 
		{
			var width  = 575,
			    height = 400,
			    left   = ($(window).width()  - width)  / 2,
			    top    = ($(window).height() - height) / 2,
			    url    = this.href,
			    opts   = 'status=1' +
			             ',width='  + width  +
			             ',height=' + height +
			             ',top='    + top    +
			             ',left='   + left;

			window.open(url, 'twitter', opts);
			return false;
		});

		/**
		 * Open G+ share on a popup window
		 */
		$('.wpvq-gplus-share-popup').click(function(event) 
		{
			var width  = 575,
			    height = 450,
			    left   = ($(window).width()  - width)  / 2,
			    top    = ($(window).height() - height) / 2,
			    url    = this.href,
			    opts   = 'status=1' +
			             ',width='  + width  +
			             ',height=' + height +
			             ',top='    + top    +
			             ',left='   + left;

			window.open(url, 'gplus', opts);
			return false;
		});

		/**
		 * When people submit their info (nickname, email....)
		 */
		
		// Click on "ignore & see my results"
		var wpvq_ignoreForm = false;
		$('.wpvq-ignore-askInfo').click(function(){
			wpvq_ignoreForm = true;
		});

		// Submit form OR ignore form
		$('button#wpvq-submit-informations, .wpvq-ignore-askInfo').click(function(e) 
		{	
			if (askEmail && !wpvq_ignoreForm) {
				if( $('input[name=wpvq_askEmail]').val() == '' || (wpvq_checkMailFormat && !wpvq_isEmail($('input[name=wpvq_askEmail]').val())) ) {
					alert(i18n_wpvq_needEmailAlert);
					return false;
				}
			}

			if (askNickname && !wpvq_ignoreForm) {
				if($('input[name=wpvq_askNickname]').val() == '') {
					alert(i18n_wpvq_needNicknameAlert);
					return false;
				}
			}

			// Block button
			$(this).attr('disabled', 'disabled');
			$(this).html('<i class="fa fa-spinner fa-spin-custom" aria-hidden="true"></i> '+wpvq_i18n_loading_label+'...');

			e.preventDefault();
			var data = $('form#wpvq-form-informations').serialize();
			$.post(
				ajaxurl,
				{ 'action': 'submit_informations', 'data': data }, 
				function(response) 
				{
					$('#wpvq-general-results').show(400, function() { 
						$('#wpvq-ask-before-results').hide(400, function() { wpvq_scrollToQuizEnd(); }); 
					});
				}
			);

			// You can hook something in JS if you need to exploit the form info
			if (typeof wpvq_hook_askInformations == 'function') { 
				wpvq_hook_askInformations(data);
			}

			// Function run when displaying results.
			wpvq_hook_show_results();
		});

		// Ignore share when Facebook API is misconfigured
		$('.wpvq-facebook-ignore-share').click(function() 
		{
			$('#wpvq-general-results').show();
			$('#wpvq-ask-before-results').hide();
			$('#wpvq-forceToShare-before-results').hide();

			// Function run when displaying results.
			wpvq_hook_show_results();
		});

		// Skip Facebook Share, even when Facebook is blocked
		$('.wpvq-facebook-share-button.wpvq-facebook-noscript.wpvq-js-loop').click(function() 
		{
			$('#wpvq-forceToShare-before-results').hide();
	        if (askEmail || askNickname) {
	        	$('#wpvq-ask-before-results').show();
	        } else {
	        	$('#wpvq-general-results').show();
	        	// Function run when displaying results.
				wpvq_hook_show_results();
	        }
		});


		/**
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
		 *
		 * 									SNIPPETS
		 * 									--------
		 * 									
		 *
		 * 		wpvq_autoscroll_next() : void
		 * 			Scroll to the next question
		 * 			
		 * 		wpvq_findPictureUrls() : array
		 * 			Extract Picture URLs from text
		 *
		 * 		wpvq_isEmail(), wpvq_isUrl() : boolean
		 * 			Regular boolean function
		 *
		 * 		wpvq_groupPointsByPersonality() : array
		 * 			Group points by personnality when quiz finished
		 *
		 * 		wpvq_getMax() : int
		 * 			Find the max value in the "wpvq_groupPointsByPersonality" result array
		 *
		 * 		wpvq_add_social_meta() : void
		 * 			Configure social meta when quiz finished
		 *
		 * 		wpvq_hook_show_results() : void
		 * 			Hook useful function when displaying results
		 * 			
		 * 		wpvq_action_before_results() : void
		 * 			Hook useful function when quiz finished
		 *
		 * 		wpvq_update_progress() : void
		 * 			Fill and ++ the progressbar
		 *
		 * 		wpvq_change_page() : void
		 * 			Switch page
		 *
		 * 		wpvq_count_pages() : int
		 * 			Count number of pages
		 * 
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
		 */
		
		// Tools : base64 encode/decode
		var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

		/**
		 * Finish a quiz (show results, etc)
		 * @param  {[type]} quizType [description]
		 * @return {[type]}          [description]
		 */
		function wpvq_concludeQuiz(quizType)
		{
			if (quizType == 'WPVQGamePersonality')
			{
				var answers 	=  wpvq_groupPointsByPersonality( $('.vq-css-checkbox:checked') );
				maxWeight 		=  wpvq_getMax(answers, true);

				// No answer :|
				if (maxWeight == 0) {
					return;
				}

				// Loader for personality result block
				$('div#wpvq-big-loader').fadeIn();

				$.post(
					ajaxurl,
					{ 'action': 'choose_personality', 'weight': maxWeight }, 
					function(response) 
					{
						$('div#wpvq-big-loader').fadeOut();

						personalityTestEnded = true;
						var responseArray = $.parseJSON(response);
						
						// json string to json array + test answer
						var responseArray 		=  $.parseJSON(response);
						var personalityLabel 	=  responseArray.label;
						var personalityContent 	=  responseArray.content;

						// Can be useful (ex : for redirect page)
						wpvq_global_result = personalityLabel;
						wpvq_global_results.resultValue = maxWeight;

						// useful to ask info, else useless.
						$('input#wpvq_ask_result').val(personalityLabel); 

						// Replace ahref, meta, ...
						jQuery.wpvq_add_social_meta('Personality', personalityLabel, personalityContent);
						$('#wpvq-final-personality div.wpvq-personality-content').html(personalityContent);

						wpvq_action_before_results(personalityLabel);

						$('#wpvq-final-personality').show('slow', function(){ wpvq_scrollToQuizEnd(); });
					}
				);
			} 
			else if (quizType == 'WPVQGameTrueFalse')
			{
				// Loader for personality result block
				$('div#wpvq-big-loader').fadeIn(200);

				$.post( 
					ajaxurl,
					{ 'action': 'get_truefalse_appreciation', 'score': countTrueAnswer, 'quizId': quizId }, 
					function(response)
					{
						$('div#wpvq-big-loader').fadeOut();

						// Fill score + content
						$('.wpvq #wpvq-final-score .wpvq-score').text(countTrueAnswer);
						$('input#wpvq_ask_result').val(countTrueAnswer); // useful to "ask-info" form
						if (response != 0) {
							var responseArray = $.parseJSON(response);
							$('.wpvq-appreciation-content').html(responseArray['appreciationContent']);
						} else {
							var responseArray = [];
							responseArray['appreciationContent'] = '';
						}

						wpvq_global_result = countTrueAnswer;
						wpvq_global_results.resultValue = countTrueAnswer;

						// Replace ahref, meta, ...
						jQuery.wpvq_add_social_meta('TrueFalse', countTrueAnswer, responseArray['appreciationContent']);
						
						wpvq_action_before_results(countTrueAnswer);

						$('#wpvq-final-score').show('slow', function(){ wpvq_scrollToQuizEnd(); });
					});
			}
		}

		/**
		 * Scroll to the next question
		 * @return void
		 */
		function wpvq_autoscroll_next($questionSelector)
		{
			// Don't scroll if last question of a page with explanation to show
			if (wpvq_autoscroll_next_var && !wpvq_block_pageChanging && !wpvq_scroll_to_explanation) {
				$('html, body').animate( { scrollTop: $questionSelector.next().offset().top - 35 - wpvq_scroll_top_offset }, wpvq_scroll_speed );	
			}

			// Scroll to the explanation if there is one.
			if (wpvq_autoscroll_next_var && wpvq_scroll_to_explanation) {
				$('html, body').animate( { scrollTop: $questionSelector.find('.wpvq-explaination').offset().top - 35 - wpvq_scroll_top_offset }, wpvq_scroll_speed );	
				wpvq_scroll_to_explanation = false;
			}
		}

		/**
		 * Test an email with regex
		 */
		function wpvq_isEmail(myVar){
			var regEmail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');
			return regEmail.test(myVar);
		}

		/**
		 * Test an url with regex
		 */
		function wpvq_isUrl(str) {
			var pattern = new RegExp("^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");
			return pattern.test(str);
		}

		/**
		 * Generate personalitiesWeight array before ajax 
		 * @param $elList = selector of checked answer (ie : $('.vq-css-checkbox:checked'))
		 * @author Bogdan Petru Pintican (bogdan.pintican@netlogiq.ro)
		 * @website http://www.netlogiq.ro
		 */	
		function wpvq_groupPointsByPersonality( $elList ) 
		{
			var dataAnswers = [],
				personalitiesWeight = {}; // should be an object

			// for each question
			$.each($elList, function(i, el)
			{
				var answerId = $(this).attr('data-wpvq-answer');
				var $answerDiv = $(document).find('.wpvq-answer[data-wpvq-answer='+answerId+']');
				
				$answerDiv.find('input.wpvq-appreciation').each(function() {
					var appreciationId 	= $(this).attr('data-appreciationId');
					var multiplier 		= $(this).val();

					if( personalitiesWeight[appreciationId] ) {
						personalitiesWeight[appreciationId] = parseInt(personalitiesWeight[appreciationId]) + parseInt(multiplier);
					} else {
						personalitiesWeight[appreciationId] = parseInt(multiplier);
					}
				});
			});

			return personalitiesWeight;
		}

		/**
		 * Find the max in array (context : personalitiesWeight)
		 * @author Bogdan Petru Pintican (bogdan.pintican@netlogiq.ro)
		 * @website http://www.netlogiq.ro
		 */
		function wpvq_getMax(myArray, randomIfEgal)
		{
			var maxPersonalityId = 0, 
				maxPersonalityWeight = 0,
				forceReplacement = false;

			$.each(myArray, function(index, elem) 
			{
				if (elem > maxPersonalityWeight) 
				{
					maxPersonalityId 		= index;
					maxPersonalityWeight 	= elem;
				}
				// If 2 value are equal AND if we want to fetch a random answer
				else if (elem == maxPersonalityWeight && randomIfEgal)
				{
					var randNum = parseInt(Math.random() * 4);
					if (randNum%2 == 0 || maxPersonalityId == 0 /* prevent from empty result */) 
					{
						maxPersonalityId 		= index;
						maxPersonalityWeight 	= elem;
					}
				}
			});

		   return maxPersonalityId;
		}

		/**
		 * Shuffle an array
		 * @param  {[type]} array [description]
		 * @return {[type]}       [description]
		 */
		function shuffleArray(array) {
		    for (var i = array.length - 1; i > 0; i--) {
		        var j = Math.floor(Math.random() * (i + 1));
		        var temp = array[i];
		        array[i] = array[j];
		        array[j] = temp;
		    }
		    return array;
		}

		// Function run when showing results
		function wpvq_hook_show_results()
		{
			// Redirect to another result page (quiz setting)
			if (wpvq_redirection_page != '') 
			{
				$('.wpvq').html(''); // don't display result

				// Encoded results
				var paramRedirection = '' + Base64.encode( JSON.stringify(wpvq_global_results) );
				var newUrl = addParam(wpvq_redirection_page, 'wpvqdataresults', paramRedirection);
				
				// Param containing raw results, to be compatible with old version
				newUrl = addParam(newUrl, 'wpvqresults', wpvq_global_result);
				newUrl = addParam(newUrl, 'quizUrl', wpvq_share_url);
				
				window.location = newUrl;
				return;
			}

			// Show RightWrong answer at the end of the quiz
			if (wpvq_hideRightWrong)
			{
				$('.wpvq-explaination > p.wpvq-explaination-content').parent().show();

				$('.' + rightAnswerCssClass).each(function(){
					$(this).removeClass(rightAnswerCssClass);
					$(this).addClass('wpvq-answer-true');
				});

				$('.' + wrongAnswerCssClass).each(function(){
					$(this).removeClass(wrongAnswerCssClass);
					$(this).addClass('wpvq-answer-false');
				});

				// Display all pages
				console.log('show all');
				$('.wpvq-single-page').show();

				// MathJax Support
				// Parse the whole page to find Jax content
				if(typeof MathJax != "undefined") {
					MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
				}
			}

			$('.wpvq-play-again-area').show();
		}
		// Make it global (for wpvq-facebook-api.js for instance)
		jQuery.wpvq_hook_show_results = function() { wpvq_hook_show_results(); };

		/**
		 * Ask informations, force to share, ...
		 * @param mixed result Can be a score, a personality label, ...
		 */
		function wpvq_action_before_results(result)
		{
			// Save game stats
			var submitData 			=  { 'wpvq_quizId' : quizId, 'wpvq_ask_result' : result, 'beforeResults' : true };
			var submitDataArray 	=  submitData; // keep an array version
			submitData 				=  $.param(submitData);

			// code/ads above results
			$('.wpvq-bloc-addBySettings-top').show();

			// You can hook something in JS
			if (typeof wpvq_hook_beforeResults == 'function') { 
				wpvq_hook_beforeResults(submitDataArray);
			}

			$.post(
				ajaxurl,
				{ 'action': 'submit_informations', 'data': submitData }, 
				function(response) { /* nothing */ }
			);

			// Hide results with ForceToShare
			if (forceToShare) {
				$('#wpvq-forceToShare-before-results').show(400, function(){
					$('#wpvq-general-results').hide(400, function(){ wpvq_scrollToQuizEnd(); });
				});
			}

			// Get info from user
			if (askEmail || askNickname) 
			{
				// If ForceToShare + AskInfo, forceToShare first.
				if (!forceToShare) {
					$('#wpvq-ask-before-results').show(400, function(){
						$('#wpvq-general-results').hide(400, function(){ wpvq_scrollToQuizEnd(); });
					});
				}
			}

			// Run hook if no action before results
			if (!forceToShare && !askEmail && !askNickname) {
				wpvq_hook_show_results();
			}
		}

		/**
		 * Update the progress bar for paginated quizzes
		 */
		function wpvq_update_progress()
		{
			// Percentage for computing
			var wpvq_percent_progress = parseInt( ( wpvq_currentPage * 100 ) / wpvq_totalPages );
			
			// Public content
			var content;
			if (wpvq_progressbar_content == 'none') {
				content = '';
			} else if (wpvq_progressbar_content == 'percentage') {
				content = wpvq_percent_progress + '%';
			} else /*if (wpvq_progressbar_content == 'page')*/ {
				content = parseInt(wpvq_currentPage) + ' / ' + wpvq_totalPages;
			}
			
			// Display
			if (wpvq_percent_progress == 0) {
				$('.wpvq-page-progress .wpvq-progress-value').css('width', wpvq_percent_progress + '%');
				$('.wpvq-page-progress .wpvq-progress-value').text(content);
			} 
			else {
				$('.wpvq-progress-zero').html('');
				$('.wpvq-page-progress .wpvq-progress-value').animate({width:wpvq_percent_progress + '%'}, 800);
				$('.wpvq-page-progress .wpvq-progress-value').text(content);
			}

			// Scroll to top auto for the page > 0
			var isNextPageEmpty = ($.trim($('#wpvq-page-' + wpvq_currentPage).html()).length == 0) ;
			if (!wpvq_refresh_page && wpvq_autoscroll_next_var && wpvq_currentPage > 0 && wpvq_percent_progress != 100 && !isNextPageEmpty) {
				$('html, body').animate( { scrollTop: $('#wpvq-page-' + wpvq_currentPage).offset().top - 70 - wpvq_scroll_top_offset }, wpvq_scroll_speed );	
			}
		}


		/**
		 * Switch page
		 * @param  selector $parent The current $(.wpvq-question) element
		 * @param  int configure time before to switch
		 *                       -1 	=  wpvq_wait_trivia_page (WP option)
		 *                       0 		=  no delay (personality quiz for instance)
		 * @return int
		 *         1 = change page
		 *         0 = change page BUT please, stop everything (window.location)
		 */
		function wpvq_change_page($parent, forceWaitingTime)
		{
			var $page = $parent.parents('.wpvq-single-page');
			var areAllQuestionAnswered = ( $page.find('.wpvq-question').length == $page.find('.wpvq-choose').length ) ;

			// Blocked = end of page + explanation to read before to switch
			// Show the "continue" button to switch page.
			if (wpvq_block_pageChanging == true && areAllQuestionAnswered /* = only for the current page */) {
				$parent.parents('.wpvq-single-page').find('.wpvq-next-page').show();
				return 1;
			}

			// Do not switch anything if there is only 1 page
			if ($parent.find('.wpvq-single-page').length == 1) {
				return 1;
			}

			// If all questions have been answered on the current page, try to switch.
			if (areAllQuestionAnswered)
			{
				// Do not hide the last page
				// Condition matches at the end of the quiz (last question, last page)
				var isTherePageAfter = $parent.attr('data-pageAfter');
				if (isTherePageAfter == 'false') 
				{
					wpvq_currentPage++;
					wpvq_update_progress();
					return 1;
				}

				// Changing delay between pages (with the "force" parameter)
				// or Personality quiz (no need waiting time)
				var waitBeforeChanging;
				if (forceWaitingTime == 0 || wpvq_type == 'WPVQGamePersonality') {
					var waitBeforeChanging = 0;
				} else {
					var waitBeforeChanging = wpvq_wait_trivia_page;
				}

				// Next page empty
				// hide questions and just display results + 1 progress bar
				var isNextPageEmpty = ($.trim($('#wpvq-page-' + (wpvq_currentPage+1)).html()).length == 0);
				if (isNextPageEmpty) 
				{
					if (wpvq_refresh_page) 
					{
						wpvq_currentPage++;
						var wpvq_urlParam = wpvq_answersToUrl();
						setTimeout(function() {
						  window.location = wpvq_refresh_url.replace('%%wpvqas%%', wpvq_urlParam);
						}, waitBeforeChanging);
						return 0;
					} 
					else 
					{
						$('#wpvq-page-' + wpvq_currentPage).fadeOut(function(){
							$('.wpvq_bar_container_bottom').hide();
							wpvq_currentPage++;
							wpvq_update_progress();	
						});
					}
					return 1;
				}

				// Change page !
				if (wpvq_refresh_page) 
				{
					wpvq_currentPage++;
					var wpvq_urlParam = wpvq_answersToUrl();
					setTimeout(function() {
						  window.location = wpvq_refresh_url.replace('%%wpvqas%%', wpvq_urlParam);
					}, waitBeforeChanging);
					return 1;
				} else {
					$('#wpvq-page-' + wpvq_currentPage).fadeIn(0).delay(waitBeforeChanging).fadeOut(
						function() {
							wpvq_currentPage++;
							$('#wpvq-page-' + wpvq_currentPage).fadeIn();
							wpvq_update_progress();
							wpvq_block_continue_button = false;
						}
					);
				}
				wpvq_begin_new_page = true;
			}
			else {
				wpvq_begin_new_page = false;
			}
		}


		// Convert answer given to URL value (browser page refresh needs it)
		function wpvq_answersToUrl()
		{
			var wpvq_answers = wpvq_savedCheckedAnswersToArray();

			// Step 0 : associative array
			var wpvq_answersObj = { 'wpvqas' : wpvq_answers, 'wpvqn' : wpvq_currentPage, 'wpvqcq' : countQuestions };

			// Step 1 : object to string 
			wpvq_answersObj = $.param(wpvq_answersObj);

			// Step 2 : base encode64
			wpvq_answersObj = Base64.encode(wpvq_answersObj);

			return wpvq_answersObj;
		}

		function wpvq_savedCheckedAnswersToArray()
		{

			if (wpvq_type == 'WPVQGamePersonality') 
			{
				var array = [];
				$('.vq-css-checkbox:checked').each(function(){
					array.push($(this).attr('data-wpvq-answer'));
				});
			}
			else if (wpvq_type == 'WPVQGameTrueFalse') 
			{
				var array = { 'true':[], 'false':[] };
				$('.wpvq-choose.wpvq-answer-true, .wpvq-choose.wpvq-answer-true-hideRightWrong').each(function(){
					array['true'].push($(this).attr('data-wpvq-answer'));
				});

				$('.wpvq-choose.wpvq-answer-false, .wpvq-choose.wpvq-answer-false-hideRightWrong').each(function(){
					array['false'].push($(this).attr('data-wpvq-answer'));
				});
			}

			return array;
		}

		// Convert answer given to URL to checked box ingame
		function wpvq_savedArrayToCheckedAnswers()
		{
			if (wpvq_type == 'WPVQGamePersonality') 
			{
				$.each(wpvq_answersStatus, function(key, value) 
				{
					$('input.vq-css-checkbox[data-wpvq-answer='+value+']').attr('checked','checked');
				});
			}

			if (wpvq_type == 'WPVQGameTrueFalse') 
			{
				$.each(wpvq_answersStatus['true'], function(key, value) 
				{
					// For TrueFalse : add the class ".wpvq-choose.wpvq-answer-true" to right answers
					$('input.vq-css-checkbox[data-wpvq-answer='+value+']').attr('checked','checked');
					$('.wpvq-answer[data-wpvq-answer='+value+']').addClass('wpvq-choose').addClass('wpvq-answer-true');
				});

				$.each(wpvq_answersStatus['false'], function(key, value) 
				{
					// For TrueFalse : add the class ".wpvq-choose.wpvq-answer-true" to false answers
					$('input.vq-css-checkbox[data-wpvq-answer='+value+']').attr('checked','checked');
					$('.wpvq-answer[data-wpvq-answer='+value+']').addClass('wpvq-choose').addClass('wpvq-answer-false');

					// Add real right answer
					var questionId = $('.wpvq-answer[data-wpvq-answer='+value+']').parent('.wpvq-question').attr('data-questionId');
					var $trueAnswer = $('.wpvq-question[data-questionId='+questionId+'] .wpvq-answer[data-wpvq-answer=' + wpvq_ans89733[key_rightAnswers][questionId][key_answerId] + ']');
					$trueAnswer.addClass('wpvq-answer-true');
				});
			}

			return true;
		}

		/**
		 * Simple function that... scrolls to results.
		 */
		function wpvq_scrollToQuizEnd()
		{
			$('html, body').animate( { scrollTop: $('#wpvq-end-anchor').offset().top - wpvq_scroll_top_offset }, wpvq_scroll_speed );
		}

		/**
		 * /!\ NOT USED ANYMORE
		 * Add obj1 keyX value with obj2 keyX value. For each key.
		 * Result in obj1
		 * @param  {[type]} obj1 [description]
		 * @param  {[type]} obj2 [description]
		 * @return {[type]}      [description]
		 */
		function wpvq_sum_objects(obj1, obj2)
		{
			if (obj2 == "") return obj1;

			$.each(obj1, function(key) {
				obj1[key] += parseInt(obj2[key]);
			});

			return obj1;
		}

		/**
		 * Count the number of (not empty) pages
		 * @return int
		 */
		function wpvq_count_pages()
		{
			var total = 0;

			$('.wpvq-single-page').each(function(){
				if ($.trim($(this).html()).length > 0) {
					total++;
				}
			});

			return total;
		}

		/**
		 * add query args equivalent for JS
		 * @param  {[type]} key   [description]
		 * @param  {[type]} value [description]
		 * @return {[type]}       [description]
		 */
		function addParam(url, param, value) 
		{
		   var a = document.createElement('a'), regex = /(?:\?|&amp;|&)+([^=]+)(?:=([^&]*))*/gi;
		   var params = {}, match, str = []; a.href = url;
		   while (match = regex.exec(a.search))
		       if (encodeURIComponent(param) != match[1]) 
		           str.push(match[1] + (match[2] ? "=" + match[2] : ""));
		   str.push(encodeURIComponent(param) + (value ? "=" + encodeURIComponent(value) : ""));
		   a.search = str.join("&");
		   return a.href;
		}
	}

	/**
	 * ########################
	 * 	       GLOBAL
	 * ########################
	 */
	
	/**
	 * A utility function to find all _picture_ URLs 
	 * and return them in an array.  Note, the URLs returned are exactly as found in the text.
	 * 
	 * @param text the text to be searched.
	 * @return an array of URLs.
	 */
	function wpvq_findPictureUrls( text )
	{
		var source = (text || '').toString();
		var urlArray = [];
		var url;
		var matchArray;

		// Regular expression to find FTP, HTTP(S) and email URLs.
		var regexToken = /(((ftp|https?):\/\/)[\-\w@:%_\+.~#?,&\/\/=]+)|((mailto:)?[_.\w-]+@([\w][\w\-]+\.)+[a-zA-Z]{2,3})/g;

		// Iterate through any URLs in the text.
		while( (matchArray = regexToken.exec( source )) !== null )
		{
		    var token = matchArray[0];
		    if ((/\.(gif|jpg|jpeg|tiff|png)$/i).test(token)) {
		    	urlArray.push( token );
		    }
		}

		return urlArray;
	}
	jQuery.wpvq_findPictureUrls = function( text ) { return wpvq_findPictureUrls(text); };

	/**
	 * Add social meta to share link, meta value, ...
	 * @param  {[type]} quizType TrueFalse | Personality
	 * @param  {[type]} tagValue [description]
	 * @param  {string} tagContent html content of personality/TrueFalse Appreciation
	 */
	function wpvq_add_social_meta(quizType, tagValue, tagContent)
	{
		var tag = '';
		if (quizType == 'TrueFalse' || quizType == 'WPVQGameTrueFalse')  {
			tag = '%%score%%';
		} else if (quizType == 'Personality' || quizType == 'WPVQGamePersonality') {
			tag = '%%personality%%';
		}

		// Need fake HTML in some weird cases. Don't know why.
		var rawTextTagContent = $('<div>' + tagContent + '</div>').text();

		// Local text
		wpvq_local_caption 			=  wpvq_local_caption.replace(tag, tagValue);
		wpvq_local_caption 			=  wpvq_local_caption.replace('%%details%%', rawTextTagContent);
		$('.wpvq-local-caption').text(wpvq_local_caption);

		// Meta Title and Description
		wpvq_facebook_caption 		=  wpvq_facebook_caption.replace(tag, tagValue);
		wpvq_facebook_description 	=  wpvq_facebook_description.replace(tag, tagValue);

		// Details tags %%details%%
		wpvq_facebook_caption 		=  wpvq_facebook_caption.replace('%%details%%', rawTextTagContent);
		wpvq_facebook_description 	=  wpvq_facebook_description.replace('%%details%%', rawTextTagContent);

		// Facebook Share Picture
		var potentialPictures = jQuery.wpvq_findPictureUrls(tagContent);
		if (potentialPictures.length > 0) {
			wpvq_facebook_picture = potentialPictures[0];
		}

		// Facebook API Js Var
		wpvq_facebook_caption = wpvq_facebook_caption.replace(tag, tagValue);

		// VK Share button
		if (typeof VK != 'undefined' && typeof VK.Share.button != 'undefined') {
			var vkButton = VK.Share.button({ 
				url: wpvq_share_url, 
				title: wpvq_facebook_caption, 
				description: wpvq_facebook_description,  
				image: wpvq_facebook_picture, 
				noparse: true
			}, {type: 'custom', text: '<div class="wpvq-social-vk wpvq-social-button"><i class="wpvq-social-icon"><i class="fa fa-vk"></i></i><div class="wpvq-social-slide"><p>VK</p></div></div>'});
			$('.wpvq-vk-share-content').html(vkButton);
		}
		
		// Prepare social share link (for social media with simple <a href> share tools [Twitter, G+])
		$('a.wpvq-js-loop').each(function() 
		{
			var ahref 	=  $(this).attr('href');
			ahref 		=  ahref.replace(tag, tagValue);
			ahref		=  ahref.replace('%%details%%', rawTextTagContent);
			ahref 		=  ahref.replaceAll('#', '%23');
			$(this).attr('href', ahref);
		});

		return true;
	}
	jQuery.wpvq_add_social_meta = function(quizType, tagValue, tagContent) { return wpvq_add_social_meta(quizType, tagValue, tagContent); };

})(jQuery);


/**
 * ========================================
 * 				GLOBAL SNIPPETS
 * ========================================
 */


/**
 * .replace but all the occurences of $search (not a native JS function O_O)
 */
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};