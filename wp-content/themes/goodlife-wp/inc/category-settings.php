<?php


/**
 * Edit category header field.
 */

function thb_edit_category_settings( $term, $taxonomy ) {
	$image 			= '';
	$header_id 	= absint( get_term_meta( $term->term_id, 'thb_header_id', true ) );
	$thb_listing_style 	= get_term_meta( $term->term_id, 'thb_listing_style', true );
	if ($header_id) :
		$image = wp_get_attachment_url( $header_id );
	else :
		//$image = woocommerce_placeholder_img_src();
	endif;

	?>
	<tr class="form-field">
		<th scope="row"><h2><?php _e( 'GoodLife Settings', 'goodlife' ); ?></h2></th>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e( 'Header', 'goodlife' ); ?></label></th>
		<td>
			<div id="thb_cat_header" style="float:left;margin-right:10px;"><img src="<?php echo esc_url($image); ?>" width="60px" height="60px" /></div>
			<div style="line-height:60px;">
				<input type="hidden" id="thb_cat_header_id" name="thb_cat_header_id" value="<?php echo esc_attr($header_id); ?>" />
				<button type="submit" class="thb_upload_header button"><?php _e( 'Upload/Add image', 'goodlife' ); ?></button>
				<button type="submit" class="thb_remove_header button"><?php _e( 'Remove image', 'goodlife' ); ?></button>
			</div>
			<p class="description"><?php _e( 'Works in Style 1 category header', 'goodlife'); ?></p>
			<script type="text/javascript">			 
			
			if (jQuery('#thb_cat_header_id').val() == 0)
				 jQuery('.thb_remove_header').hide();

				// Uploading files
				var header_file_frame;

				jQuery(document).on( 'click', '.thb_upload_header', function( event ){

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( header_file_frame ) {
						header_file_frame.open();
						return;
					}

					// Create the media frame.
					header_file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( 'Choose an image', 'goodlife' ); ?>',
						button: {
							text: '<?php _e( 'Use image', 'goodlife' ); ?>',
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					header_file_frame.on( 'select', function() {
						attachment = header_file_frame.state().get('selection').first().toJSON();
						jQuery('#thb_cat_header_id').val( attachment.id );
						jQuery('#thb_cat_header img').attr('src', attachment.url );
						jQuery('.thb_remove_header').show();
					});

					// Finally, open the modal.
					header_file_frame.open();
				});

				jQuery(document).on( 'click', '.thb_remove_header', function( event ){
					jQuery('#thb_cat_header img').attr('src', '');
					jQuery('#thb_cat_header_id').val('');
					jQuery('.thb_remove_header').hide();
					return false;
				});

			</script>

			<div class="clear"></div>

		</td>

	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e( 'Listing Style', 'goodlife' ); ?></label></th>
		<td>
			<p><input type="radio" name="thb_listing_style" id="thb_listing_style-1" value="style2"  class="radio" <?php if($thb_listing_style === 'style2'){ echo 'checked="checked"'; } ?>><label for="thb_listing_style-1">Style - 1</label></p>
			<p><input type="radio" name="thb_listing_style" id="thb_listing_style-2" value="style3"
				class="radio" <?php if($thb_listing_style === 'style3'){ echo 'checked="checked"'; } ?>><label for="thb_listing_style-2">Style - 2</label></p>
			<p class="description"><?php _e( 'Overrides Theme Options', 'goodlife'); ?></p>
		</td>
	</tr>
	<?php

}

add_action( 'category_edit_form_fields', 'thb_edit_category_settings', 10,2 );

function thb_category_setting_save( $term_id ) {	
	
	if ( isset( $_POST['thb_cat_header_id'] ) ) {
		update_term_meta( $term_id, 'thb_header_id', absint( $_POST['thb_cat_header_id'] ) );
	}
	if ( isset( $_POST['thb_listing_style'] ) ) {
		update_term_meta( $term_id, 'thb_listing_style', $_POST['thb_listing_style'] );
	}
}
add_action( 'created_term', 'thb_category_setting_save', 10,3 );
add_action( 'edit_category', 'thb_category_setting_save', 10,3 );

?>