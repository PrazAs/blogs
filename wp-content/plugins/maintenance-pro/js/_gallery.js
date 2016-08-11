jQuery(document).ready(function($) {
   jQuery('.add_thumbs').live('click', function( event ) {
			event.preventDefault();
			var vLinkElem = jQuery(this);
			var customData = vLinkElem.data('imagetype');
			
			var file_frame = uploads_multimedia_init('Upload Image', 'Select Images', true, true);
				file_frame.on( 'select', function() {
					var selection = file_frame.state().get('selection');
						selection.map( function( attachment ) {
						attachment = attachment.toJSON();
						var image_url = attachment.url,
							image_id  = attachment.id,
							object_type  = attachment.type;
							
						var data = {	
							action:  'maintenance_pro_gallery_init',										
							type:    'maintennace_pro_gallery',										
							image_url: image_url,										
							image_id : image_id,										
							object_type : object_type,
							image_cnt: $("ul.sortable-maintenanace-pro-gallery li.item").length,
							maintenance_pro_ajax_nonce : maintenance_pro_vars_ajax.ajax_nonce
						};													
					
					$.post(maintenance_pro_vars_ajax.ajaxurl, data, function(response) {							
						if ($("ul.sortable-maintenanace-pro-gallery li.item").length > 0) {								
							$("ul.sortable-maintenanace-pro-gallery li.item").last().after(response);							
						} else {								
							$("ul.sortable-maintenanace-pro-gallery").append(response);							
						}
						
						$(function () {
							var settings = {};
							if ( typeof _wpmejsSettings !== 'undefined' )
							settings.pluginPath = _wpmejsSettings.pluginPath;
							$('.wp-video-shortcode:not(".mejs-video")').mediaelementplayer( settings );
						});
					});			
				});
			});

			file_frame.open();
			return false;
		});
		
		jQuery( "#sortable-gallery-pro" ).disableSelection();	
		jQuery( "#sortable-gallery-pro" ).sortable({placeholder:'ui-SortPlaceHolder'});			
		
		jQuery('.delete_thumb').live('click', function( event ) {
			event.preventDefault();
			$(this).parent().remove();		
			return false;
		});	
		
		jQuery('#remove_all_thumbs').live('click', function( event ) {
			event.preventDefault();
			$(this).parent().find('.soratble-wrap > ul li').each(function () {
				$(this).fadeOut(300, function(){
					$(this).remove();
				});
			});
			
			return false;
		});	
		
		jQuery('#soverlay').change(function (){
			var vOption = $(this).find( "option:selected").val();
			$("#example-overlay").removeAttr('class');
			$('#example-overlay').addClass('_' + vOption);
			return false;
		});
	
}); 

jQuery.fn.extend({
	uploads_multimedia_init: function(title, btnName, editing, multiple) {
		var file_frame;
		if (file_frame) {		
			file_frame.open();
			return;
		}
		file_frame = wp.media.editor.send.attachment  = wp.media({ title: title, button: { text: btnName }, editing: editing,  multiple:  multiple });
		return file_frame;
	}
});