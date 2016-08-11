jQuery(document).ready(function() {
	var vColorPickerOptions = {
    	defaultColor: false,
    	change: function(event, ui){},
    	clear: function() {},
		hide: true,
		palettes: true
	};
	
	jQuery('.mailing_fields').hide();
	if (jQuery('#mail_lists').length > 0) {
		jQuery('#mail_lists').on('change', function() {
			var vCurrVal = jQuery(this).val();
			jQuery('.mailing_fields').each(function() {
				if (jQuery(this).data('mailind') == vCurrVal) {
					jQuery(this).show();
				} else {
					jQuery(this).hide();
				}
			});
		});
		
		jQuery('#mail_lists').change();
	}
	
	jQuery('#soverlay').select2({});
	
  //jQuery('#get-lists').prop( "disabled", true );
	jQuery('#get-lists').on('click', function() {
		var eArr = {};
		var vClientID = jQuery('#campaignmonitor_client_id').val();
		var vApiKey   = jQuery('#campaignmonitor_api_key').val();
		var data = { 
					 action: 'get_cm_list', 
					 client_id : vClientID,
					 api_key : vApiKey
				  };
			
			jQuery('#campaignmonitor_list_id').find('option').remove();
			jQuery.post(ajaxurl, data, function(array_in) {
					var array_in = jQuery.parseJSON(array_in);
					jQuery('#campaignmonitor_list_id').find('option').remove();
					
					jQuery.each(array_in, function(index, item) {
						jQuery('#campaignmonitor_list_id').append(jQuery('<option>', {value:item['ListID'], text: item['Name']}));
					});
					jQuery('#campaignmonitor_list_id').select2("open");
					
			});							
			
		return false;
	});
	
	jQuery('#color-countdown').wpColorPicker(vColorPickerOptions);
	jQuery('#color-font-countdown').wpColorPicker(vColorPickerOptions);
	
	if (jQuery('.remove-btn').length > 0) {
		jQuery('.remove-btn').on('click', function() {
			jQuery(this).closest('.input-group.date').find('input').val('');
			return false;
		});
	}	
	
	jQuery('#expiry_time_start, #expiry_time_end').datetimepicker({
			pickDate: false
	});
	jQuery('#expiry_date_start, #expiry_date_end').datetimepicker({
			sideBySide: true,		 
			useSeconds: false,
			useStrict: 	true,
			pickTime:   false
	});
	
	jQuery("#mt-gallery-tabs" ).tabs();

	if (jQuery('#enter_button_checkbox').length > 0) {
        if (jQuery('#enter_button_checkbox').prop("checked")) {
            jQuery('#enter_site_text').prop('disabled', false);
        } else {
            jQuery('#enter_site_text').prop('disabled', true);
        }
    }
    
    jQuery('#enter_button_checkbox').on('change', function() {
        if (jQuery(this).prop("checked")) {
            jQuery('#enter_site_text').prop('disabled', false);
        } else {
            jQuery('#enter_site_text').prop('disabled', true);
        }
        
    });

	if (jQuery('#503_enabled').length > 0) {
        if (jQuery('#503_enabled').prop("checked")) {
            jQuery('#enter_button_checkbox, #enter_site_text').prop('disabled', true);
        } else {
            jQuery('#enter_button_checkbox, #enter_site_text').prop('disabled', false);
        }
    }
    
    jQuery('#503_enabled').on('change', function() {
        if (jQuery(this).prop("checked")) {
            jQuery('#enter_button_checkbox, #enter_site_text').prop('disabled', true);
        } else {
            jQuery('#enter_button_checkbox, #enter_site_text').prop('disabled', false);
        }
        
    });

});