jQuery(document).ready(function($){
	// Review Average
	var thb_AverageScoreInput = $('#post_ratings_average'),
			thb_ratings = $('#setting_post_ratings_percentage');
	
	function thb_calculateAverage() {
        var i = 0, thb_TempTotal = 0;
        thb_ratings.find('[id^="post_ratings_percentage_feature_score_"]').each(function() {
            i++;
            thb_TempTotal += parseFloat( $(this).val() );
        });
        var thb_AverageScore = Math.round(thb_TempTotal / i);

        thb_AverageScoreInput.val(thb_AverageScore);

        if ( isNaN(thb_AverageScore) ) { thb_AverageScoreInput.val(''); }

    }

    thb_ratings.find('.ot-numeric-slider-wrap').each(function() {
         var hidden = $('.ot-numeric-slider-hidden-input', this),
            value  = hidden.val(),
            helper = $('.ot-numeric-slider-helper-input', this);
        if ( ! value ) {
          value = hidden.data("min");
          helper.val(value);
        }

        thb_ratings.find('.ot-numeric-slider', this).slider({

            slide: function(event, ui) {
                hidden.add(helper).val(ui.value);
                thb_calculateAverage();
            },
            change: function() {
                OT_UI.init_conditions();
                thb_calculateAverage();
            }
        });
    });

    jQuery(thb_ratings).on('change', '.ot-numeric-slider-hidden-input', function() {
        thb_calculateAverage();
    });

    thb_ratings.on('click', '.option-tree-setting-remove', function(e) {
      if ( $(this).parents('li').hasClass('ui-state-disabled') ) {
        alert(option_tree.remove_no);
        return false;
      }

      var agree = window.confirm(option_tree.remove_agree);

      if (agree) {

          var list = $(this).parents('ul');
          OT_UI.remove(this);
          setTimeout( function() { 
              OT_UI.update_ids(list); 
              thb_calculateAverage();
          }, 200 );
          
      }
      e.preventDefault();
      return false;
  });
	
	// Demo Content Import
	var thb_data = new FormData(),
			thb_once = false;
		
	thb_data.append( 'action', 'ocdi_import_demo_data' );
	thb_data.append( 'security', ocdi.ajax_nonce );
	
	function thb_ajaxCall() {
		var demo = $('input[name="option_tree[demo-select]"]:checked').val();

		thb_data.append( 'selected', demo );
		
		// AJAX call.
		$.ajax({
			method:     'POST',
			url:        ocdi.ajax_url,
			data:       thb_data,
			contentType: false,
			processData: false,
			beforeSend: function() {
				if (!thb_once) {
					$('#thb-import-messages').addClass('active').append( '<div class="notice notice-success"><p><strong>Starting Import</strong></p></div>' );
					thb_once = 1;
				}
			}
		})
		.done( function( response ) {
			if ( 'undefined' !== typeof response.status && 'newAJAX' === response.status ) {
				thb_ajaxCall( thb_data );
			} else {
				$( '#thb-import-messages' ).append( '<div class="error below-h2"><p>' + response.message + '</p></div>' );
			}
		})
		.fail( function( error ) {
			$('#thb-import-messages').append( '<div class="error thb-failed below-h2"> Error: ' + error.statusText + ' (' + error.status + ')' + '</div>' );
		});
	}
	
	$('#import-demo-content').on("click", function(e){
		$(this).addClass('disabled').attr('disabled', 'disabled').unbind('click');
		
		thb_ajaxCall(thb_data);
		
		e.preventDefault();
	});
});