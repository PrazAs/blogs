(function($) 
{ 
	// Not the same content depending on the quiz type
	var resultTitle = ''; var resultContent = '';
	if (wpvq_type == 'WPVQGamePersonality') 
	{
		resultTitle = wpvq_results.label;
		resultContent = wpvq_results.content;
	} 
	else if (wpvq_type == 'WPVQGameTrueFalse') 
	{
		resultTitle = wpvq_results.resultValue;
		resultContent = wpvq_results.appreciationContent;
	}

	// Appreciation
	$('.wpvq-appreciation-content, .wpvq-personality-content').html(resultContent);

	// Social media + local caption
	if(jQuery.wpvq_add_social_meta(wpvq_type, resultTitle, wpvq_results.appreciationContent))
	{
		$('#wpvq-final-score').css('display', 'block');
		$('#wpvq-final-personality').css('display', 'block');
	}

})(jQuery);