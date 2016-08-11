<?php 
	function mt_get_plugin_options_pro() {
		return (array) get_option('maintenance_options');
	}
	
	function get_custom_styles_pro () {
		wp_enqueue_style ('_gallery',    MAINTENANCE_PRO_URI .'css/_gallery.css' );
		wp_enqueue_style ('_ui', 		 MAINTENANCE_PRO_URI .'css/_ui.css');
		wp_enqueue_style ('_bootstrap',	 MAINTENANCE_PRO_URI .'bootstrap/css/bootstrap.min.css');
		wp_enqueue_style ('_bootstrap-theme', MAINTENANCE_PRO_URI .'bootstrap/css/bootstrap-theme.min.css');
		wp_enqueue_style ('_datepicker', MAINTENANCE_PRO_URI .'css/bootstrap-datetimepicker.min.css');
		wp_enqueue_style ('wp-mediaelement' );
	}
	
	function get_custom_scripts_pro () {
		global $wp_scripts;
		
		wp_enqueue_script ( 'wp-mediaelement' );
		wp_enqueue_script ( 'jquery-ui-tabs' );
		
		wp_enqueue_script ('_gallery', MAINTENANCE_PRO_URI .'js/_gallery.min.js' );
		wp_enqueue_script ('jquery-ui-slider');
		wp_enqueue_script ('_bootstrap',  MAINTENANCE_PRO_URI .'bootstrap/js/bootstrap.min.js');
		wp_enqueue_script ('_moment',  	  MAINTENANCE_PRO_URI .'js/moment.js');
		wp_enqueue_script ('_datepicker', MAINTENANCE_PRO_URI .'js/bootstrap-datetimepicker.min.js');
		
		$ui = $wp_scripts->query('jquery-ui-core');
		$protocol = is_ssl() ? 'https' : 'http';
		$url = "$protocol://ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/smoothness/jquery-ui.min.css";
		wp_enqueue_style('jquery-ui-smoothness', $url, false, null);
		
		wp_localize_script('_gallery', 'maintenance_pro_vars_ajax', array(
																			'ajaxurl' 		=> admin_url( 'admin-ajax.php' ),
																			'ajax_nonce' 	=> wp_create_nonce( 'maintenance_pro_add_thumb_ajax_nonce' )
		));
		
		
		wp_enqueue_script ('_init',  MAINTENANCE_PRO_URI .'js/_init.min.js' );
	}
	
	add_action( 'admin_enqueue_scripts', 'add_admin_options_and_styles_pro' );
	function add_admin_options_and_styles_pro($hook) {
		global $options_page;
		if( $options_page != $hook ) return;
		get_custom_scripts_pro();
		get_custom_styles_pro();
	} 
	
	function add_custom_scripts_pro() {
		global $wp_scripts;
		$mt_options   = mt_get_plugin_options_pro();
		$wp_scripts->do_items('jquery-ui-slider');
		
		wp_register_script('_modernizr', 	MAINTENANCE_PRO_URI  	.'frontend/_modernizr.js', 'jquery');
		wp_register_script('_bgVideo', 		MAINTENANCE_PRO_URI 	.'frontend/_bgvideo/_bigvideo.min.js', 'jquery');
		wp_register_script('_videojs',		MAINTENANCE_PRO_URI 	.'frontend/_bgvideo/_videojs.js', 'jquery');		
		wp_register_script('_moment', 		MAINTENANCE_PRO_URI		.'js/moment.js', 'jquery');		
		wp_register_script('pro-init', 		MAINTENANCE_PRO_URI  	.'frontend/_init_pro.min.js', 	  'jquery');
		
		/* Mute video youtube */
		wp_register_script('youtube', 		MAINTENANCE_PRO_URI		.'frontend/youtube.js', 'jquery');		
		
		/*Countdown*/
		wp_register_script('_easing', 		MAINTENANCE_PRO_URI	.'frontend/_easing.js',   	   'jquery');
		wp_register_script('_countdown', 	MAINTENANCE_PRO_URI	.'frontend/_countdown.min.js', 'jquery');
		
		
		wp_register_script('_countdown-kinetic', 	MAINTENANCE_PRO_URI	.'frontend/kinetic.js', 'jquery');
		wp_register_script('_countdown-circular', 	MAINTENANCE_PRO_URI	.'frontend/jquery.final-countdown.min.js', 'jquery');
	
		$vCurrDate_start = $vCurrDate_end = null;
		
		$vdate_start  = date_i18n( 'Y-m-d', strtotime( current_time('mysql', 0) )); 
		$vtime_start  = date_i18n( 'h:i a', strtotime( '12:00 am')); 
		
		$vdate_end  = date_i18n( 'Y-m-d', strtotime( current_time('mysql', 0) )); 
		$vtime_end  = date_i18n( 'h:i a', strtotime( '12:00 pm')); 
		

		if (!empty($mt_options['expiry_date_start']))
			$vdate_start = $mt_options['expiry_date_start'];
		if (!empty($mt_options['expiry_time_start']))
			$vtime_start = $mt_options['expiry_time_start'];		   
		
		if (!empty($mt_options['expiry_date_end']))
			$vdate_end = $mt_options['expiry_date_end'];
		if (!empty($mt_options['expiry_time_end']))
			$vtime_end = $mt_options['expiry_time_end'];		   

		$date_concat_start = $vdate_start . ' ' . $vtime_start;
		$vCurrDate_start = strtotime($date_concat_start); 	
		
		$date_concat_end = $vdate_end . ' ' . $vtime_end;
		$vCurrDate_end = strtotime($date_concat_end); 	
		
		
		if ((isset($mt_options['expiry_date_end']) && 
			!empty($mt_options['expiry_date_end'])) ||
			(isset($mt_options['expiry_time_end']) && 
			!empty($mt_options['expiry_time_end'])) ) {
				$wp_scripts->localize( 'pro-init', 'maintenance_frontend_vars', array( 		'ajaxurl' 		 => admin_url( 'admin-ajax.php' ),
																							'date_countdown_start' => esc_js($vCurrDate_start), 
																							'date_countdown_end'   => esc_js($vCurrDate_end), 
																							'circle_color'	 => esc_js($mt_options['countdown_font_color']),
																							'dLabel'		 => __('Days', 		'maintenance-pro'),
																							'hLabel'		 => __('Hours', 	'maintenance-pro'),
																							'mLabel'		 => __('Minutes', 	'maintenance-pro'),
																							'sLabel'		 => __('Seconds', 	'maintenance-pro'),
																							'isDown'		 => esc_js(isset($mt_options['is_down']))
																							));

		} else {
				$wp_scripts->localize( 'pro-init', 'maintenance_frontend_vars', array( 		'ajaxurl' 		 => admin_url( 'admin-ajax.php' )));
		}		
		
		$wp_scripts->do_items('_easing');		
		$wp_scripts->do_items('_countdown');	

		if (isset($mt_options['countdown_type']) && $mt_options['countdown_type'] == 2) {
			$wp_scripts->do_items('_countdown-kinetic');
			$wp_scripts->do_items('_countdown-circular');		
		}	
		
		/*End of Countdown*/
		
		/* preloader */
		if (empty($mt_options['preloader'])) {
				remove_action('before_content_section', 'get_preloader_element', 5);
		}

		$wp_scripts->do_items('_modernizr');
		$wp_scripts->do_items('_videojs');		
		$wp_scripts->do_items('_bgVideo');
		$wp_scripts->do_items('pro-init');
	}

	function add_custom_styles_pro() {
		global $wp_styles;
		
		wp_register_style('frontend', MAINTENANCE_PRO_URI .'frontend/frontend.css');
		wp_register_style('bgVideo',  MAINTENANCE_PRO_URI .'frontend/_bgvideo/_bigvideo.css');
		
		$wp_styles->do_items('bgVideo');
		maintenance_options_style_pro();
		$wp_styles->do_items('frontend');
	}
	
	add_action ('load_custom_scripts', 'add_custom_styles_pro' , 5);
	add_action ('load_custom_scripts', 'add_custom_scripts_pro', 20);
		
		function maintenance_enter_button_pro(){
			global $mt_options;
			if (empty($mt_options['enter_button_checkbox'])){
				unset($_COOKIE["mt_enter_site"]);
				return;
			} 

			if(isset($_COOKIE["mt_enter_site"])) {
				$mt_options['state'] = false;
			}
			elseif (!empty($_POST['enter-site'])) {
				setcookie("mt_enter_site", "on", time()+86400);
				$mt_options['state'] = false;
			}

		}

		function get_enter_button_pro() {
			$mt_options = mt_get_plugin_options_pro();
			if (!empty($mt_options['enter_button_checkbox']) && !empty($mt_options['enter_site_text'])) {
			$out_enter_button = '';
			$out_enter_button .= '<form method="post" class="form-enter">';
			$out_enter_button .= '<button class="btn btn-enter" type="submit" name="enter-site" value="on">' . wp_kses_post(stripslashes($mt_options['enter_site_text'])) .'</button>';
			$out_enter_button .= '</form>';
			echo $out_enter_button;
			}
		}
		
		function maintenance_enable_enter_button_pro() {
			$mt_options = mt_get_plugin_options_pro();
			if (empty($mt_options['503_enabled'])) {
				maintenance_enter_button_pro();
				add_action('content_section',  'get_enter_button_pro', 5);
			}

		}
		add_action('init', 'maintenance_enable_enter_button_pro', 1);

	add_action('add_meta_boxes', 'maintenance_extends_splash_page_pro',20); 	
	function maintenance_extends_splash_page_pro() {
		global $options_page;
		add_meta_box( 'splash-page-pro', __('Splash Page', 'maintenance-pro'), 'maintenance_splash_page_pro', $options_page, 'normal', 'default' );
	}

	add_action('add_meta_boxes', 'maintenance_extends_roles_pro', 25); 	
	function maintenance_extends_roles_pro() {
		global $options_page;
		add_meta_box( 'maintenance-roles', __('Exclude User Roles', 'maintenance-pro'), 'add_data_user_roles', $options_page, 'normal', 'default' );
	}
	
	add_action('add_meta_boxes', 'maintenance_extends_gallery_pro',30); 	
	function maintenance_extends_gallery_pro() {
		global $options_page;
		add_meta_box( 'maintenance-gallery', __('Gallery', 'maintenance-pro'), 'maintenance_gallery_show_box_pro', $options_page, 'normal', 'default' );
	}
	
	add_action('add_meta_boxes', 'maintenance_extends_countdown_pro',35); 	
	function maintenance_extends_countdown_pro() {
		global $options_page;
		add_meta_box( 'maintenance-countdown', __('Countdown', 'maintenance-pro'), 'maintenance_countdown_show_box_pro', $options_page, 'normal', 'default' );
	}
	
	
	add_action('add_meta_boxes', 'maintenance_extends_htmlcss_pro',40); 	
	function maintenance_extends_htmlcss_pro() {
		global $options_page;		
		add_meta_box( 'maintenance-htmlcss', __('HTML in PopUp window', 'maintenance-pro'), 'maintenance_htmlcss_box_pro', $options_page, 'normal', 'default' );
	}
	
	add_action('add_meta_boxes', 'maintenance_extends_maillists_pro',45); 	
	function maintenance_extends_maillists_pro() {
		global $options_page;
		add_meta_box( 'maintenance-maillists', __('eMail Lists', 'maintenance-pro'), 'maintenance_maillists_box_pro', $options_page, 'normal', 'default' );
	}
	
	add_action('add_meta_boxes', 'maintenance_extends_social_pro',50); 	
	function maintenance_extends_social_pro() {
		global $options_page;
		add_meta_box( 'maintenance-social', __('Social', 'maintenance-pro'), 'maintenance_social_box_pro', $options_page, 'normal', 'default' );
	}
	
	function maintenance_splash_page_pro() {
		$mt_options = mt_get_plugin_options_pro();

		$out_splash  = '';
		$out_splash .= '<table class="form-table">';
			$out_splash .= '<tr valign="top">';
			$out_splash .= '<th scope="row">'.__('Preloader On / Off', 'maintenance-pro') .'</th>';
				$out_splash .= '<td>';
					$out_splash .= '<filedset>';
								$value = (!empty($mt_options['preloader'])) ? 1 : 0;
								$out_splash .= '<label for="preloader">';
								$out_splash .= '<input type="checkbox"  id="preloader_checkbox" name="lib_options[preloader]" value="1" '. checked( true, $value, false ) .'/>';
							$out_splash .= '</label>';
							$out_splash .= '<br />';
					$out_splash .= '</fieldset>';
				$out_splash .= '</td>';
			$out_splash .= '</tr>';
			$out_splash .= '<tr valign="top">';
			$out_splash .= '<th scope="row">'.__('Enter site button On / Off', 'maintenance-pro') .'</th>';
				$out_splash .= '<td>';
					$out_splash .= '<filedset>';
					
								$value = (!empty($mt_options['enter_button_checkbox'])) ? $mt_options['enter_button_checkbox'] : false;
								
								$out_splash .= '<label for="enter_button_checkbox">';
								$out_splash .= '<input type="checkbox"  id="enter_button_checkbox" name="lib_options[enter_button_checkbox]" value="1" '. checked( true, $value, false ) .'/>'; 
							$out_splash .= '</label>';
							$out_splash .= '<br />';
					$out_splash .= '</fieldset>';
				$out_splash .= '</td>';
				$out_splash .= '</tr>';
						$out_splash .= '</tr>';
			$out_splash .= '<tr valign="top">';
			$out_splash .= '<th scope="row">'.__('Text for button', 'maintenance-pro') .'</th>';
				$out_splash .= '<td>';
					$out_splash .= '<filedset>';
					
					$value = (!empty($mt_options['enter_site_text'])) ? $mt_options['enter_site_text'] : '';

								$out_splash .= '<label for="enter_site_text">';
								$out_splash .= '<input type="text" id="enter_site_text" name="lib_options[enter_site_text]" value="'. wp_kses_post(stripslashes($value)) .'" placeholder="enter button text"/>';
							$out_splash .= '</label>';
							$out_splash .= '<br />';
					$out_splash .= '</fieldset>';
				$out_splash .= '</td>';
				$out_splash .= '</tr>';				
		$out_splash .= '</table>';
		echo $out_splash;
	}
	
	function maintenance_get_thumb_pro($attachment_id) {
		$out = $type = "";
		$length = 7000;
		$image_attributes = wp_get_attachment_image_src( $attachment_id, 'thumbnail');
		$meta_data 		  = wp_get_attachment_metadata ( $attachment_id);
		
		if(isset($meta_data['length'])) {
			$type = 'video';
			$length = absint($meta_data['length']);
			$length = ($length * 1000) - 2000;
		} else {
			$type = 'image';
			$length = 7000;
		}
			
		$out .= '<li class="item">';
			$out .= '<input type="hidden" value="'. $attachment_id  .'" name="lib_options[gallery_array][attachment_ids][]" />';
			$out .= '<input type="hidden" value="'. wp_get_attachment_url( $attachment_id )  .'" name="lib_options[gallery_array][attachment_urls][]" />';
			$out .= '<input type="hidden" value="'. $type  	   .'" name="lib_options[gallery_array][attachment_types][]" />';
			$out .= '<input type="hidden" value="'. $length	   .'" name="lib_options[gallery_array][attachment_length][]" />';
			
			if ($type == 'video') {
				$attr 	   = array();
				$video_url = wp_get_attachment_url( $attachment_id );
				$attr = array(
								'src'    => $video_url,
								'width'  => 150,
								'height' => 150
							);
				$out .= wp_video_shortcode( $attr );
			} else {
				$out .= '<img id="image-'. $attachment_id .'" src="'. $image_attributes[0] .'" alt="" />';
			}	
			
			
			$out .= '<input id="delete_thumb" class="button button-primary delete_thumb" type="button" value="x" name="delete_thumb">';
		$out .= '</li>';
			
		return $out;
	}
	
	add_action( 'wp_ajax_maintenance_pro_gallery_init', 'maintenance_pro_add_new_thumb');
	function maintenance_pro_add_new_thumb() {
		$out = '';
		$length = 7000;
		
		if(!is_admin() || !wp_verify_nonce( $_POST['maintenance_pro_ajax_nonce'], 'maintenance_pro_add_thumb_ajax_nonce' )) { return; }
			
		$image_url	 = esc_url($_POST['image_url']);
		$image_id	 = esc_attr($_POST['image_id']);
		$type 		 = esc_attr($_POST['object_type']);
		
		$image_attributes = wp_get_attachment_image_src( $image_id, 'thumbnail');
		$meta_data 		  = wp_get_attachment_metadata ( $image_id);
		
		if(isset($meta_data['length'])) {
			$type = 'video';
			$length = absint(esc_attr($meta_data['length']));
			$length = ($length * 1000) - 2000;
		} else {
			$type = 'image';
			$length = 7000;
		}
			
		
		$out .= '<li class="item">';
			$out .= '<input type="hidden" value="'. $image_id  .'" name="lib_options[gallery_array][attachment_ids][]" />';
			if($type == 'video') {
				$video_url = '';
				$video_url = wp_get_attachment_url( $image_id );
				$out .= '<input type="hidden" value="'. $video_url .'" name="lib_options[gallery_array][attachment_urls][]" />';
			} else {
				$out .= '<input type="hidden" value="'. $image_url .'" name="lib_options[gallery_array][attachment_urls][]" />';
			}
			$out .= '<input type="hidden" value="'. $type  	   .'" name="lib_options[gallery_array][attachment_types][]" />';
			$out .= '<input type="hidden" value="'. $length	   .'" name="lib_options[gallery_array][attachment_length][]" />';
			if ($type == 'video') {
				$attr = array();
				$video_url = wp_get_attachment_url( $image_id );
				$attr = array(
								'src'    => $image_url,
								'width'  => 150,
								'height' => 150
							);
				$out .= wp_video_shortcode( $attr );
			} else {
				$out .= '<img id="image-'.$image_id.'" src="'. $image_attributes[0] .'" alt="" />' . "\r\n";
			}	
			$out .= '<input id="delete_thumb" class="button button-primary delete_thumb" type="button" value="x" name="delete_thumb">';
		$out .= '</li>';
			
		echo $out;
		die();
		
	}
	
	 function maintenance_gallery_show_box_pro () {
			$out = $gallery_items = $active_overlay = '';
			$val_overlay = 0;
			$gallery_data = array();
			$video_link = '';
			
			$mt_options   = mt_get_plugin_options_pro();
			if (isset($mt_options['gallery_array']['attachment_ids']) && (count($mt_options['gallery_array']['attachment_ids']) > 0)) {
				$gallery_data = $mt_options['gallery_array'];
			} 
			
			if($gallery_data && count($gallery_data['attachment_ids']) > 0) {
				foreach($gallery_data['attachment_ids'] as $attachment_id) {
						$gallery_items .= maintenance_get_thumb_pro($attachment_id);
				}
			}
			
			if (isset($mt_options['single_link_video']) && (!empty($mt_options['single_link_video']))) {
				$video_link = esc_url($mt_options['single_link_video']);
			}
			
			
			$out .= '<div id="mt-gallery-tabs">';
				$out .= '<ul>';
					$out .= '<li><a href="#gallery-loop">'.__('Gallery', 'maintenance-pro').'</a></li>';
					$out .= '<li><a href="#gallery-video-single">'.__('Single video link', 'maintenance-pro').'</a></li>';
				$out .= '</ul>';
			
				$out .= '<div id="gallery-loop">';
					$out .= '<div class="soratble-wrap">';
						$out .= '<ul id="sortable-gallery-pro" class="sortable-maintenanace-pro-gallery">';
							$out .= $gallery_items;
						$out .= '</ul>';
					$out .= '</div>';
					
					$out .= '<input id="add_thumbs" class="button button-primary add_thumbs" type="button" value="'.__('Add elements', 'maintenance-pro').'" name="add_thumbs">';
					$out .= '<input id="remove_all_thumbs" class="button button-primary remove_all_thumbs" type="button" value="'.__('Remove all elements', 'maintenance-pro').'" name="remove_all_thumbs">';			
					
					if (isset($mt_options['gallery_array']['overlay']) && (intval($mt_options['gallery_array']['overlay']) != 0)) {
						$val_overlay    = esc_attr($mt_options['gallery_array']['overlay']);
						$active_overlay = '_' .$val_overlay;
					}
					$out .= '<div class="admin_overlays">';
						$out .= '<select title="'.__('select to set overlays', 'maintenance-pro').'" name="lib_options[gallery_array][overlay]" id="soverlay" class="soverlay">';
							$out .= '<option value="0" '.selected( $val_overlay, 0, false ).'>'. __('no overlay', 'maintenance-pro') .'</option>';
							for ($i = 1; $i <= 15; $i++) {
								 $out .= '<option value="'.$i.'" '.selected( $val_overlay, $i, false ).'>'. sprintf(__('%1$s example', 'maintenance-pro'), $i) .'</option>';
							}
						$out .= '</select>';
						$out .= '<div id="example-overlay" class="'.$active_overlay.'"></div>';
					$out .= '</div>';
					
					$out .= '<div class="delay-time">';
						$delay = 7000; 
						
						if (intval($mt_options['delay_time']) != 0) {
							$delay = intval($mt_options['delay_time']);
						}
						$out .= '<label for="delay_time">';
							$out .= __('Delay Time', 'maintenance-pro');
							$out .= '<input type="text" id="delay_time" name="lib_options[delay_time]" value="'.$delay.'" />';			
						$out .= '</label>';
					$out .= '</div>';
				$out .= '</div>';	
				
				$out .= '<div id="gallery-video-single">';
					
					$out .= '<table class="form-table">';
						$out .= '<tr valign="top">';
							$out .= '<td>';
								$out .= '<filedset>';
									$out .= '<div class="row">';
									$out .= '<div class="col-md-8">';
										$out .= '<div class="form-group">';
											$out .= '<label for="single-link-video">'.__('Edit single link', 'maintenance-pro').':</label>';
											$out .= '<input type="text" id="single-link-video" class="single-link-video form-control input-md" name="lib_options[single_link_video]" value="'.$video_link.'" />';	
											$out .= '<span class="help-block">('.__("YouTube or Vimeo", "maintenance-pro").')</span>'; 
										$out .= '</div>';
										$out .= '<div class="form-group">';
										$out .= '<filedset>';
												$value = (!empty($mt_options['single_sound_video'])) ? 1 : 0;
												$out .= '<label for="sound_video_checkbox">';
													$out .= '<input type="checkbox"  id="sound_video_checkbox" name="lib_options[single_sound_video]" value="1" '. checked( true, $value, false ) .'/>';
													$out .= __('Video sound On / Off (Youtube only)', 'maintenance-pro');	
												$out .= '</label>';
												$out .= '<br />';
												$out .= '</fieldset>';
										$out .= '</div>';
									$out .= '</div>';
								$out .= '</filedset>';	
							$out .= '</td>';		
						$out .= '</tr>';		
					$out .= '</table>';		
					
				$out .= '</div>';
			
			$out .= '</div>';
			
			
			
			
			echo $out;
	}
	
	function maintenance_countdown_show_box_pro () {
		$out = $exp_date_start = $exp_date_end = $exp_time_start = $exp_time_end = $ct_color = $ct_font_color = $fsz = $type = '';
		$is_down = $is_countdown_display = false;
		$mt_options = mt_get_plugin_options_pro();
		
		if (isset($mt_options['expiry_date_start']))
			if ($mt_options['expiry_date_start'] != '') $exp_date_start = $mt_options['expiry_date_start'];
			
		if (isset($mt_options['expiry_time_start']))
			if ($mt_options['expiry_time_start'] != '') $exp_time_start = $mt_options['expiry_time_start'];
		
		
		if (isset($mt_options['expiry_date_end'])) 
			if ($mt_options['expiry_date_end'] != '') $exp_date_end = $mt_options['expiry_date_end'];
			
		if (isset($mt_options['expiry_time_end'])) 
			if ($mt_options['expiry_time_end'] != '') $exp_time_end = $mt_options['expiry_time_end'];
		
		
		if (isset($mt_options['countdown_color']))
			if ($mt_options['countdown_color'] != '') $ct_color = stripslashes($mt_options['countdown_color']);
		
		if (isset($mt_options['countdown_font_color']))
			if ($mt_options['countdown_font_color'] != '') $ct_font_color = stripslashes($mt_options['countdown_font_color']);
		
		if (isset($mt_options['is_down']))
			if ($mt_options['is_down'] != '') $is_down  = $mt_options['is_down'];
			
		if (isset($mt_options['is_countdown_display']))
			if ($mt_options['is_countdown_display'] != '') $is_countdown_display  = $mt_options['is_countdown_display'];	
		
		
/* 		if (isset($mt_options['countdown_font_size']))
			if ($mt_options['countdown_font_size'] != '') $fsz  = $mt_options['countdown_font_size']; */
		
		if (isset($mt_options['countdown_type']))
			if ($mt_options['countdown_type'] != '') $type  = $mt_options['countdown_type'];
		
		
		
		$out .= '<table class="form-table">';
			$out .= '<tr valign="top">';
				$out .= '<th scope="row">'.__('Set expiry date', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						
						$out .= '<div class="row">';
							$out .= '<div class="col-md-3">';
								$out .= '<div class="form-group">';
									$out .= '<label for="expiry_time_start">'.__('Time Start').'</label>';
									$out .= '<div class="input-group date">';
										$out .= '<input data-date-format="hh:mm a" type="text" id="expiry_time_start" class="expiry_time_start form-control" name="lib_options[expiry_time_start]" value="'.$exp_time_start.'" />';	
									$out .= '</div>';		
								$out .= '</div>';
							$out .= '</div>';
							
							$out .= '<div class="col-md-3">';
								$out .= '<div class="form-group">';
									$out .= '<label for="expiry_time_start">'.__('Date Start').'</label>';
									$out .= '<div class="input-group date">';
										$out .= '<input data-date-format="YYYY-MM-DD" type="text" id="expiry_date_start" class="expiry_date_start form-control" name="lib_options[expiry_date_start]" value="'.$exp_date_start.'" />';
										$out .= '<span class="input-group-addon"><span class="glyphicon glyphicon-remove remove-btn"></span>';
									$out .= '</div>';
								$out .= '</div>';
							$out .= '</div>';
							
							
							$out .= '<div class="col-md-3">';
								$out .= '<div class="form-group">';
									$out .= '<label for="expiry_time_end">'.__('Time end').'</label>';
									$out .= '<input data-date-format="hh:mm a" type="text" id="expiry_time_end" class="expiry_time_end form-control" name="lib_options[expiry_time_end]" value="'.$exp_time_end.'" />';
								$out .= '</div>';
							$out .= '</div>';
							
							$out .= '<div class="col-md-3">';
								$out .= '<div class="form-group">';
									$out .= '<label for="expiry_date_end">'.__('Date end').'</label>';
									$out .= '<div class="input-group date">';
										$out .= '<input data-date-format="YYYY-MM-DD" type="text" id="expiry_date_end" class="expiry_date_end form-control" name="lib_options[expiry_date_end]" value="'.$exp_date_end.'" />';
										$out .= '<span class="input-group-addon"><span class="glyphicon glyphicon-remove remove-btn"></span>';
									$out .= '</div>';	
								$out .= '</div>';
							$out .= '</div>';
							
						$out .= '</div>';	
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
			$out .= '<tr valign="top">';
				$out .= '<th scope="row">'.__('Type', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<select name="lib_options[countdown_type]" id="countdown_type" class="select2_customize">';
							$out .= '<option value="0" '.selected( $type, 0, false ).'>'.__('Simple', 'maintenance-pro').'</option>';
							$out .= '<option value="1" '.selected( $type, 1, false ).'>'.__('Boxed',  'maintenance-pro').'</option>';
							$out .= '<option value="2" '.selected( $type, 2, false ).'>'.__('Circle',  'maintenance-pro').'</option>';
						$out .= '</select>';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
			$out .= '<tr valign="top">';
				$out .= '<th scope="row">'.__('Set color scheme', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<input type="text" id="color-countdown" class="color-countdown" name="lib_options[countdown_color]" data-default-color="#333333" value="'. $ct_color .'" />';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
			$out .= '<tr valign="top">';
				$out .= '<th scope="row">'.__('Set font color', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<input type="text" id="color-font-countdown" class="color-font-countdown" name="lib_options[countdown_font_color]" data-default-color="#ffffff" value="'. $ct_font_color .'" />';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
			$out .= get_fonts_field(__('Font family', 'maintenance-pro'), 'countdown_font_family', 'countdown_font_family', esc_attr($mt_options['countdown_font_family'])); 	
			
/* 			$out .= '<tr valign="top">';
				$out .= '<th scope="row">'.__('Set font size', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<input type="text" id="countdown_font_size" class="countdown_font_size" name="lib_options[countdown_font_size]" value="'. $fsz .'" />';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>'; */
			
			$out .= '<tr valign="top">';
				$out .= '<th scope="row">'.__('Maintenance off after expiry', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<input type="checkbox"  id="is_down_date_maintenance" name="lib_options[is_down]" value="1" '. checked( true, $is_down, false ) .'/>';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
			
			$out .= '<tr valign="top">';
				$out .= '<th scope="row">'.__('Turn off the countdown', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<input type="checkbox"  id="is_countdown_display" name="lib_options[is_countdown_display]" value="1" '. checked( true, $is_countdown_display, false ) .'/>';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
		$out .= '</table>';		
				
		echo $out;
	}
	
	function add_data_user_roles($object, $box) {
		global $wp_roles;
			   $mt_options = mt_get_plugin_options_pro();
		
		$out_roles  = '';
		$out_roles .= '<table class="form-table">';
			$out_roles .= '<tr valign="top">';
			$out_roles .= '<th scope="row">'.__('Select user roles', 'maintenance-pro') .'</th>';
				$out_roles .= '<td>';
					$out_roles .= '<filedset>';
					
						foreach($wp_roles->roles as $key => $role) { 
								$name = $role['name'];
								$value = isset($mt_options['roles_array'][$key]);
								
								$out_roles .= '<label for='. translate_user_role($key) .'>';
								$out_roles .= '<input type="checkbox"  id="'.$key .'" name="lib_options[roles_array]['.$key.']" value="1" '.checked( true, $value, false ).'/>';
								$out_roles .= translate_user_role($name); 
							$out_roles .= '</label>';
							$out_roles .= '<br />';
						} 
					$out_roles .= '</fieldset>';
				$out_roles .= '</td>';
				$out_roles .= '</tr>';			
		$out_roles .= '</table>';
		echo $out_roles;
	}
	
	function maintenance_pro_get_gallery() {
		$mt_options = mt_get_plugin_options_pro();
		$class_overlay = $out_gallery_html = $out_gallery_items = '';
		$gallery_data = array();
		if (isset($mt_options['gallery_array'])) {
			$gallery_data = $mt_options['gallery_array'];
		}	
		$delay_img = $single_video_link = '';
		
		if(isset($mt_options['delay_time'])) {
			$delay_img = intval($mt_options['delay_time']);
		}
		
		if (isset($mt_options['single_link_video'])) {
			$single_video_link = $mt_options['single_link_video'];
		}	
		
		
		if (!empty($single_video_link)) {
			$iframe_build = '';
			
			
			if (strpos($single_video_link, 'youtube')) {
				parse_str( parse_url( $single_video_link, PHP_URL_QUERY ), $youtube_vars );	
				
				if(!wp_is_mobile()) {
					
					$iframe_build = '<iframe id="player" frameborder="0" allowfullscreen="1" volume="0" height="100%" width="100%" src="http://www.youtube.com/embed/'.$youtube_vars['v'].'?rel=0&amp;autoplay=1&amp;loop=1&amp;controls=0&amp;showinfo=0&amp;autohide=1&amp;modestbranding=1&amp;wmode=transparent&amp;enablejsapi=1"></iframe>';
					
						if ( $mt_options['single_sound_video'] == 1 ) {
							global $wp_scripts;
							$wp_scripts->do_items('youtube');
						}
					
				} else {
					$iframe_build = '<div style="background: url(http://img.youtube.com/vi/'.$youtube_vars['v'].'/maxresdefault.jpg); height: 100%; background-size: cover; background-position: center;"></div>';
				}
			} elseif (strpos($single_video_link, 'vimeo')) {
				$vimeo_video_id = (int) substr(parse_url($single_video_link, PHP_URL_PATH), 1);
				$iframe_build = ' <iframe frameborder="0" height="100%" src="//player.vimeo.com/video/'.$vimeo_video_id.'?title=0&amp;byline=0&amp;portrait=0&amp;color=3a6774&amp;autoplay=1&amp;loop=1" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			}
			
			$out_gallery_html = '<div id="single-video" class="single-video">';
				$out_gallery_html .= $iframe_build;
			$out_gallery_html .= '</div>';
			
		} else {
			if(!empty($gallery_data['attachment_ids'])) {
				for ($i = 0; $i <= count($gallery_data['attachment_ids'])-1; $i++) {
					$id = $url = $type = $length = '';
						
					$id   	= $gallery_data['attachment_ids'][$i];
					$url  	= esc_url($gallery_data['attachment_urls'][$i]);
					$type 	= $gallery_data['attachment_types'][$i];
					$length = $gallery_data['attachment_length'][$i];
					
					if (!wp_is_mobile()) {
						
						if ($type != 'video') $length = $delay_img;
							
						$out_gallery_items .= '<li id="slide-'.$id.'" class="items bgFullSlide" data-type="'.$type.'" data-delayslider="'.$length.'">';

						if ($type == 'video') {
							$out_gallery_items .= '<div class="video" data-videourl="'.$url.'"></div>';
						} else {
							$meta_data = '';
							$meta_data = wp_get_attachment_metadata ($id);
							$out_gallery_items .= '<img width="'.$meta_data['width'].'" height="'.$meta_data['height'].'" src="'. $url .'" alt="" />';
						}
						$out_gallery_items .= '</li>';
					} else {
						if ($type != 'video') {
							$meta_data = '';
							$meta_data = wp_get_attachment_metadata ($id);
							
							$out_gallery_items .= '<li id="slide-'.$id.'" class="items bgFullSlide" data-type="'.$type.'" data-delayslider="'.$length.'">';
								$out_gallery_items .= '<img width="'.$meta_data['width'].'" height="'.$meta_data['height'].'" src="'. $url .'" alt="" />';
							$out_gallery_items .= '</li>';
						}
					}
				}
				
				if ($out_gallery_items != '') {
					$out_gallery_html .= '<div id="gallery-maintenance-pro" class="gallery-maintenance-pro">';
						if (isset($gallery_data['overlay']) && ($gallery_data['overlay'] != 0)) {
							$class_overlay = '_' . $gallery_data['overlay'];
						}
						$out_gallery_html .= '<div class="overlays '.$class_overlay.'"></div>';
							$out_gallery_html .= '<ul class="slides-container">';
								$out_gallery_html .= $out_gallery_items;
							$out_gallery_html .= '</ul>';
					$out_gallery_html .= '</div>';
				}	
				
				
			}
		}	
		
		echo $out_gallery_html;
	}
	
	
	if (wp_is_mobile()) {
		add_action('before_main_container',  'maintenance_pro_get_gallery', 10);
	} else {
		add_action('before_content_section', 'maintenance_pro_get_gallery', 10);
	}	
	
	function get_countdown_circle_html() {
		
		$out_ = null;
		
		$out_ = '<div id="cirlce-countdown" class="cirlce-countdown">';
			$out_ .= '<div class="clock">';
				$out_ .= '<div class="clock-item clock-days countdown-time-value">';
					$out_ .= '<div class="wrap">';
						$out_ .= '<div class="inner">';
							$out_ .= '<div id="canvas-days" class="clock-canvas"></div>';
							$out_ .= '<div class="text">';
								$out_ .= '<p class="val">0</p>';
								$out_ .= '<p class="type-days type-time">'.__('Days', 'maintenance-pro').'</p>';
							$out_ .= '</div>';
						$out_ .= '</div>';
					$out_ .= '</div>';
				$out_ .= '</div>';

				$out_ .= '<div class="clock-item clock-hours countdown-time-value">';
					$out_ .= '<div class="wrap">';
						$out_ .= '<div class="inner">';
							$out_ .= '<div id="canvas-hours" class="clock-canvas"></div>';

							$out_ .= '<div class="text">';
								$out_ .= '<p class="val">0</p>';
								$out_ .= '<p class="type-hours type-time">'.__('Hours', 'maintenance-pro').'</p>';
							$out_ .= '</div>';
						$out_ .= '</div>';
					$out_ .= '</div>';
				$out_ .= '</div>';

				$out_ .= '<div class="clock-item clock-minutes countdown-time-value">';
					$out_ .= '<div class="wrap">';
						$out_ .= '<div class="inner">';
							$out_ .= '<div id="canvas-minutes" class="clock-canvas"></div>';

							$out_ .= '<div class="text">';
								$out_ .= '<p class="val">0</p>';
								$out_ .= '<p class="type-minutes type-time">'.__('Minutes', 'maintenance-pro').'</p>';
							$out_ .= '</div>';
						$out_ .= '</div>';
					$out_ .= '</div>';
				$out_ .= '</div>';

				$out_ .= '<div class="clock-item clock-seconds countdown-time-value">';
					$out_ .= '<div class="wrap">';
						$out_ .= '<div class="inner">';
							$out_ .= '<div id="canvas-seconds" class="clock-canvas"></div>';

							$out_ .= '<div class="text">';
								$out_ .= '<p class="val">0</p>';
								$out_ .= '<p class="type-seconds type-time">'.__('Seconds', 'maintenance-pro').'</p>';
							$out_ .= '</div>';
						$out_ .= '</div>';
					$out_ .= '</div>';
				$out_ .= '</div>';
			$out_ .= '</div>';
		$out_ .= '</div>';
		
		return $out_;
	}
	
	function get_content_section_pro() {
		$out_html 	= '';
		$mt_options  = mt_get_plugin_options_pro();
		$if_exists_list = $is_countdown_off = false;
		if (isset($mt_options['is_countdown_display']) && (!empty($mt_options['is_countdown_display']))) {
			$is_countdown_off = true;
		}
		
		if(((!empty($mt_options['expiry_date_end']) && isset($mt_options['expiry_date_end'])) || (!empty($mt_options['expiry_time_end']) && isset($mt_options['expiry_time_end']))) && (!$is_countdown_off)) {
			if (isset($mt_options['countdown_type'])) {
			      if ($mt_options['countdown_type'] == 2) {
					  $out_html .= get_countdown_circle_html();
				  } else {
					  $out_html .= '<div id="countdown" class="countdown"></div>';
				  }	
			} else {
				$out_html .= '<div id="countdown" class="countdown"></div>';
			}
		}
		
		$mail_list = $mt_options['mail_lists'];
		if ($mail_list == 'mail_ch') {		
				if (!empty($mt_options['mailchimp_param']['mailchimp_app_id']) &&
					!empty($mt_options['mailchimp_param']['mailchimp_list_id'])) {
			
					$MailChimpMaintenance = new MailChimpMaintenance($mt_options['mailchimp_param']['mailchimp_app_id']);
					$lists = $MailChimpMaintenance->call('lists/list', array());
			
					if (!empty($lists['data'])) {
						foreach ($lists['data'] as $arr_of_list) {
							if ($arr_of_list['id'] == $mt_options['mailchimp_param']['mailchimp_list_id'])  {
								$if_exists_list = true;
							}
						}
					}
					$out_html .= get_mail_chimp_form_subscribe($if_exists_list, __('Check the correct input "APP ID" or "LIST ID" to MailChimp access!', 'maintenance-pro'));	
				} 
		} else if ($mail_list = 'mail_cm') {
			if (!empty($mt_options['campaignmonitor_param']['campaignmonitor_client_id']) &&
				!empty($mt_options['campaignmonitor_param']['campaignmonitor_api_key']) && 
				!empty($mt_options['campaignmonitor_param']['campaignmonitor_list_id'])) {
					$message_error = '';
					 
					$auth = array('api_key' => $mt_options['campaignmonitor_param']['campaignmonitor_api_key']);
					$cMonitorList = new CS_REST_Lists($mt_options['campaignmonitor_param']['campaignmonitor_list_id'], $auth);
					$result = $cMonitorList->get();
					

					if(!$result->was_successful()) {
						$message_error = sprintf(__('Campaing Monitor Erorr: %s !', 'maintenance-pro'), $result->response->Message); 
						$if_exists_list = false;
					} else {
						$if_exists_list = true;
					}
				
				$out_html .= get_mail_chimp_form_subscribe($if_exists_list, $message_error);	
			}	
		} 
		
		
		/*Add button for content more*/
		if(!empty($mt_options['htmlcss'])) {
			$read_more = 'Read More';
			if (!empty($mt_options['readmore']))  { $read_more  = esc_attr($mt_options['readmore']); }
			$out_html .= '<a id="read-more-content" href="#" class="read-more-content">'.__($read_more, 'maintenance-pro').'</a>';
		}	
		
		echo $out_html;
	}
	add_action('content_section', 'get_content_section_pro', 20);
	
	
	function maintenance_lernmore_box_pro() {
		$out_html 	= '';
		$mt_options  = mt_get_plugin_options_pro();
		if(!empty($mt_options['htmlcss'])) {
			$out_html .= '<div class="user-content">';
				$out_html .= '<div class="center">';
					$out_html .= '<a href="#" class="close-user-content"><i class="general foundicon-remove"></i></a>';
					$out_html .= '<div class="user-content-wrapper">';
						$out_html .= apply_filters('the_content', $mt_options['htmlcss']);	
					$out_html .= '</div>';
				$out_html .= '</div>';
			$out_html .= '</div>';
		}	
		echo $out_html;
		
	}	
	add_action('user_content_section', 'maintenance_lernmore_box_pro', 99);
	
	function maintenance_htmlcss_box_pro() {
		$value = $out = '';
		$read_more = 'Read More';
		$mt_options = mt_get_plugin_options_pro();
		if (!empty($mt_options['htmlcss'])) {
			$value = wp_kses_stripslashes($mt_options['htmlcss']);
		} 
		if (!empty($mt_options['readmore']))  { $read_more  = esc_attr($mt_options['readmore']); }
		$out .= '<table class="form-table">';
			$out .= '<tr valign="top">';
				$out .= '<th scope="row">'.__('Text for "Read More" button', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<input type="text" id="readmore" class="readmore" name="lib_options[readmore]" value="'.$read_more.'" />';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
		$out .= '</table>';
		echo $out;
		wp_editor($value, 'maintenancehtmlcsspro', array('textarea_name' => 'lib_options[htmlcss]')); 
	}
	
	function maintenance_maillists_box_pro() {
		$out = $mail_list = '';
		$mc_app_id = $mc_list_id = '';
		$cm_client_id = $cm_app_id = $cm_list_id = '';
		$mt_options = mt_get_plugin_options_pro();
		
		$mailing_grab_options = json_decode(get_option( 'mailing_grab_lists' ));
		
		$mail_lists_array = array();
		$mail_lists_array = array (
			'mail_ch' => __('Mail Chimp', 'maintenance-pro'),
			'mail_cm' => __('Campaign Monitor', 'maintenance-pro'),
		);	
		
		if (!empty($mt_options['mail_lists'])) { $mail_list = esc_attr($mt_options['mail_lists']); }
		if (!empty($mt_options['mail_lists'])) { $mail_list = esc_attr($mt_options['mail_lists']); }
		
		if (!empty($mt_options['mailchimp_param']['mailchimp_app_id']))  { $mc_app_id 	= esc_attr($mt_options['mailchimp_param']['mailchimp_app_id']); }
		if (!empty($mt_options['mailchimp_param']['mailchimp_list_id'])) { $mc_list_id  = esc_attr($mt_options['mailchimp_param']['mailchimp_list_id']); }
		
		if (!empty($mt_options['campaignmonitor_param']['campaignmonitor_client_id']))  { $cm_client_id  = esc_attr($mt_options['campaignmonitor_param']['campaignmonitor_client_id']); }
		if (!empty($mt_options['campaignmonitor_param']['campaignmonitor_api_key'])) 	{ $cm_app_id  	 = esc_attr($mt_options['campaignmonitor_param']['campaignmonitor_api_key']); }
		if (!empty($mt_options['campaignmonitor_param']['campaignmonitor_list_id'])) 	{ $cm_list_id  	 = esc_attr($mt_options['campaignmonitor_param']['campaignmonitor_list_id']); }
		
		$subscribe_form_title = __('Be the first to know when website is ready', 'maintenance-pro');
		if (isset($mt_options['subscribe_form_title']) && !empty($mt_options['subscribe_form_title']))  {
			$subscribe_form_title = esc_html($mt_options['subscribe_form_title']);
		}
		
		$out .= '<table class="form-table">';
			$out .= '<tr valign="top">';
				$out .= '<th scope="row">'.__('Subscribe form title', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<input type="text" id="subscribe_form_title" class="subscribe_form_title" name="lib_options[subscribe_form_title]" value="'.$subscribe_form_title.'" />';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
			$out .= '<tr valign="top">';
				$out .= '<th scope="row">'.__('Mailing List', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<select name="lib_options[mail_lists]" id="mail_lists" class="select2_customize">';
							foreach ($mail_lists_array as $key => $value) {
								$out .= '<option value="'.$key.'" '.selected( $mail_list, $key, false ).'>'.$value.'</option>';
							}
						$out .= '</select>';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
			/*Mail Chimp*/
			$out .= '<tr data-mailind="mail_ch" valign="top" class="mailing_fields">';
				$out .= '<th scope="row">'.__('API Key', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<input type="text" id="mailchimp_app_id" class="mailchimp_app_id" name="lib_options[mailchimp_param][mailchimp_app_id]" value="'.$mc_app_id.'" />';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
			$out .= '<tr data-mailind="mail_ch" valign="top" class="mailing_fields">';
				$out .= '<th scope="row">'.__('List ID', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<input type="text" id="mailchimp_list_id" class="mailchimp_list_id" name="lib_options[mailchimp_param][mailchimp_list_id]" value="'.$mc_list_id.'" />';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
			/*Compaing Monitor*/
			$out .= '<tr data-mailind="mail_cm" valign="top" class="mailing_fields">';
				$out .= '<th scope="row">'.__('Client ID', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<input type="text" id="campaignmonitor_client_id" class="campaignmonitor_client_id" name="lib_options[campaignmonitor_param][campaignmonitor_client_id]" value="'.$cm_client_id.'" />';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
			$out .= '<tr data-mailind="mail_cm" valign="top" class="mailing_fields">';
				$out .= '<th scope="row">'.__('API Key', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<input type="text" id="campaignmonitor_api_key" class="campaignmonitor_api_key" name="lib_options[campaignmonitor_param][campaignmonitor_api_key]" value="'.$cm_app_id.'" />';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
			
			$out .= '<tr data-mailind="mail_cm" valign="top" class="mailing_fields">';
				$out .= '<th scope="row">'.__('List ID', 'maintenance-pro') .'</th>';
				$out .= '<td>';
					$out .= '<filedset>';
						$out .= '<select name="lib_options[campaignmonitor_param][campaignmonitor_list_id]" id="campaignmonitor_list_id" class="select2_customize campaignmonitor_list_id">';
							if (!empty($mailing_grab_options)) {
								foreach ($mailing_grab_options as $value) {
									$out .= '<option value="'.$value->ListID.'" '.selected( $cm_list_id, $value->ListID, false ).'>'.$value->Name.'</option>';
								}	
							}
						$out .= '</select>';
						$out .= '<input type="button" class="get-lists button" id="get-lists" value="'.__('Get All Available lists', 'maintenance-pro').'"/>';
					$out .= '</filedset>';
				$out .= '</td>';	
			$out .= '</tr>';
		$out .= '</table>';
		echo $out;
	}
	
	function maintenance_options_style_pro() {
		global $wp_styles;
		$mt_options = mt_get_plugin_options_pro();
		$options_style = '';
		
		if (!empty($mt_options['countdown_font_family'])) {
			$font_link = '';
			$font_link = mt_get_google_font(esc_attr($mt_options['countdown_font_family']));
			if ($font_link != '') {
				wp_register_style('_custom_countdown_font', $font_link);
				$wp_styles->do_items('_custom_countdown_font');		
			}	
		}
		
		if ( isset($mt_options['countdown_color'] )) {

			$rgb = '';
			if ( function_exists('maintenance_hex2rgb')) {
				 $rgb = maintenance_hex2rgb(esc_attr($mt_options['countdown_color']));
				 $ie_ = esc_attr($mt_options['countdown_color']);
			}	
			
			if (isset($mt_options['countdown_type']) && $mt_options['countdown_type'] > 0) {
				$options_style .= '#countdown .title-time  {background-color: rgba('. $rgb .', 0.8);} ';
				$options_style .= '#countdown .bg-overlay  {background-color: rgba('. $rgb .', 0.8);} ';
				$options_style .= '#countdown .box-digits  {background-color: rgba('. $rgb .', 0.8);} ';
				
				$options_style .= '.ie8 #countdown .title-time, .ie7 #countdown .title-time  {background-color: '. $ie_ .';} ';
				$options_style .= '.ie8 #countdown .bg-overlay, .ie7 #countdown .bg-overlay  {background-color: '. $ie_ .';} ';
				$options_style .= '.ie8 #countdown .box-digits, .ie7 #countdown .box-digits  {background-color: '. $ie_ .';} ';
			} 
			
			$options_style .= '#cirlce-countdown .clock-canvas {background-color: rgba('. $rgb .', 0.8);} ';
			
			if (!empty($mt_options['countdown_font_family'])) { 
				$options_style .=  '#countdown .box-digits .position .digit {font-family: '. esc_attr($mt_options['countdown_font_family']) .'; }';
				$options_style .=  '#cirlce-countdown .clock .clock-item .wrap .inner .text p.val {font-family: '. esc_attr($mt_options['countdown_font_family']) .'; }';
			}
			
/* 			if (!empty($mt_options['countdown_font_size'])) { 
				$options_style .=  '#countdown .box-digits .position .digit {font-size: '. esc_attr($mt_options['countdown_font_size']) .'; }';
				$options_style .=  '#cirlce-countdown .clock .clock-item .wrap .inner .text p.val {font-size: '. esc_attr($mt_options['countdown_font_size']) .'; }';
			} */
			
			if (!empty($mt_options['countdown_font_color'])) { 
				$options_style .=  '#countdown .box-digits .position .digit {color: '. esc_attr($mt_options['countdown_font_color']) .'; }';
				$options_style .=  '#countdown .title-time {color: '. esc_attr($mt_options['countdown_font_color']) .'; }';
				$options_style .=  '#cirlce-countdown .clock .clock-item .wrap .inner .text p {color: '. esc_attr($mt_options['countdown_font_color']) .'; }';
			}
			
		}

		if (empty($mt_options['preloader']) && !empty($mt_options['is_login'])) {
			$options_style .= 'body > div.login-form-container {display: block}';
		}

		if (!empty($mt_options['enter_button_checkbox']) && !empty($mt_options['enter_site_text'])) {
			$options_style .= '.btn-enter {background-color: '. esc_attr($mt_options['body_bg_color']) .'}';
			$options_style .=  '.btn-enter {font-family: '. esc_attr($mt_options['body_font_family']) .'; }';
			$options_style .= '.btn-enter {color: '. esc_attr($mt_options['font_color']) .'; }';
		}

		wp_add_inline_style( 'frontend', $options_style );
	}
	//add_action('options_style', 'maintenance_options_style_pro', 15);
	
	
	function maintenance_social_box_pro() {
		function generate_field_html($title, $id, $name, $value) {
			$out_filed = '';
			$out_filed .= '<tr valign="top">';
			$out_filed .= '<th scope="row">' . $title .'</th>';
				$out_filed .= '<td>';
					$out_filed .= '<filedset>';
						$out_filed .= '<input class="social-input" type="text" id="'.$id.'" name="lib_options[social]['.$name.']" value="'. stripslashes($value) .'" />';
					$out_filed .= '</filedset>';
				$out_filed .= '</td>';
			$out_filed .= '</tr>';			
			return $out_filed;
		}	

		$mt_options = mt_get_plugin_options_pro();
		if (!empty($mt_options['social'])) {
			$mt_options = $mt_options['social'];
		} else {
			$mt_options = null;
		}		
		$out_html   = '';
		
		$out_html .= '<table class="form-table">';
			$out_html .= generate_field_html(__('Vkontakte', 'maintenance-pro'),  'svkontakte', 'svkontakte',  	esc_url($mt_options['svkontakte']));
			$out_html .= generate_field_html(__('Facebook',  'maintenance-pro'),  'sfacebook', 	'sfacebook',  	esc_url($mt_options['sfacebook']));
			$out_html .= generate_field_html(__('Twitter',   'maintenance-pro'),  'stwitter',  	'stwitter',   	esc_url($mt_options['stwitter']));
			$out_html .= generate_field_html(__('Google+',   'maintenance-pro'),  'sgplus',    	'sgplus',     	esc_url($mt_options['sgplus']));
			$out_html .= generate_field_html(__('SoundCloud','maintenance-pro'),  'ssoundcloud','ssoundcloud',  esc_url($mt_options['ssoundcloud']));
			$out_html .= generate_field_html(__('LinkedIn',  'maintenance-pro'),  'slinkedin', 	'slinkedin',  	esc_url($mt_options['slinkedin']));
			$out_html .= generate_field_html(__('Dribbble',  'maintenance-pro'),  'sdribbble', 	'sdribbble',   	esc_url($mt_options['sdribbble']));
			$out_html .= generate_field_html(__('Behance',   'maintenance-pro'),  'sbehance', 	'sbehance',    	esc_url($mt_options['sbehance']));
			$out_html .= generate_field_html(__('Tumblr',    'maintenance-pro'),  'stumblr', 	'stumblr',  	esc_url($mt_options['stumblr']));
			$out_html .= generate_field_html(__('Flickr',    'maintenance-pro'),  'sflickr', 	'sflickr',  	esc_url($mt_options['sflickr']));
			$out_html .= generate_field_html(__('Pinterest', 'maintenance-pro'),  'spinterest', 'spinterest',   esc_url($mt_options['spinterest']));
			$out_html .= generate_field_html(__('Vimeo', 	 'maintenance-pro'),  'svimeo', 	'svimeo',   	esc_url($mt_options['svimeo']));
			$out_html .= generate_field_html(__('YouTube', 	 'maintenance-pro'),  'syoutube', 	'syoutube',   	esc_url($mt_options['syoutube']));
			$out_html .= generate_field_html(__('Skype', 	 'maintenance-pro'),  'sskype', 	'sskype',   	esc_attr($mt_options['sskype']));
			$out_html .= generate_field_html(__('Instagram', 'maintenance-pro'),  'sinstagram',	'sinstagram',  	esc_url($mt_options['sinstagram']));
			$out_html .= generate_field_html(__('Foursquare', 'maintenance-pro'),  'sfoursquare','sfoursquare',  	esc_url($mt_options['sfoursquare']));
			$out_html .= generate_field_html(__('E-mail', 	 'maintenance-pro'),  'semail', 	'semail',   	sanitize_email($mt_options['semail']));
		$out_html .= '</table>';	
		echo $out_html;
	}
	
	function get_footer_section_pro() {
		$mt_options = mt_get_plugin_options_pro();
		$out_ftext = '';
		if (isset($mt_options['social'])) {
			if (count($mt_options['social']) > 0) {
				$out_ftext .= '<div id="social" class="social">';
					foreach($mt_options['social'] as $key=>$value) {
						if (!empty($value)) {
							if ($key == 'sskype') {
								$out_ftext .= '<a class="socialicon '.$key.'" href="skype:'.esc_attr($value).'?call"></a>';
							} else if ($key == 'semail') {
								$out_ftext .= '<a class="socialicon '.$key.'" href="mailto:'.esc_attr($value).'"></a>';
							} else {
								$out_ftext .= '<a class="socialicon '.$key.'" href="'.esc_url($value).'" target="_blank"></a>';
							}
						}	
					}
				$out_ftext .= '</div>';
			}
		}
		echo $out_ftext;
	}
	add_action('footer_section', 'get_footer_section_pro', 5);
	
	global $options_page;
	add_action( "load-{$options_page}", 'mt_firstCollapseBoxForUser', 10 );
	function mt_firstCollapseBoxForUser() {
		global $options_page;
		$closeIds   = $allIDs = array();
		$user_id 	= get_current_user_id();
		$optionName = "closedpostboxes_$options_page";
		
		$has_been_done = get_user_option('maintenance_pb_has_been_closed', $user_id);
		if (!$has_been_done) {
			$hasclose = get_user_option($optionName, $user_id);
			$wasclose = array('maintenance-roles', 'maintenance-gallery', 'maintenance-countdown', 'maintenance-htmlcss', 'maintenance-social', 'maintenance-maillists');
			if (is_array($hasclose)) {
				$allIDs   = array_unique(array_merge($hasclose, $wasclose));
			} else {
				$allIDs   = $wasclose;
			}			
			update_user_option($user_id, $optionName, $allIDs, true);
			update_user_option($user_id, 'maintenance_pb_has_been_closed', '1', true);
		}	
	}
	
	add_action('wp_ajax_send_email_susbscribe', 'send_email_susbscribe');
	add_action('wp_ajax_nopriv_send_email_susbscribe', 'send_email_susbscribe');
	function send_email_susbscribe () {
		$mt_options = mt_get_plugin_options_pro();
		$email_ = '';
		$result = array();
		$message = __('Thanks for subscribing!', 'maintenance-pro');
		
		if (!empty($_POST)) {
			if ($_POST['action'] == 'send_email_susbscribe') {
				$data = $_POST['data'];
				parse_str($data, $searcharray);
				$email_  = sanitize_email($searcharray['email-subscribe']);
				
				$mail_list = $mt_options['mail_lists'];
				if ($mail_list == 'mail_ch') {		
					$app_id = $list_id = '';
					$app_id  = esc_attr($mt_options['mailchimp_param']['mailchimp_app_id']);
					$list_id = esc_attr($mt_options['mailchimp_param']['mailchimp_list_id']);
					$result  = mc_subscribe_lists($app_id, $list_id, $email_);
					$result[] = $message;
			
				} else if ($mail_list = 'mail_cm') {
					$cm_client_id =  $cm_app_id = $cm_list_id = '';
					
					$cm_client_id 	= esc_attr($mt_options['campaignmonitor_param']['campaignmonitor_client_id']);
					$cm_app_id 		= esc_attr($mt_options['campaignmonitor_param']['campaignmonitor_api_key']);
					$cm_list_id 	= esc_attr($mt_options['campaignmonitor_param']['campaignmonitor_list_id']);
					$result  	= cm_subscribe_lists($cm_client_id, $cm_app_id, $cm_list_id, $email_);
					$result[] 	= $message;
				} 
			}
			echo json_encode($result);				
		}	
		
		
		die('');
	}
	
	function mc_subscribe_lists($api_id = null, $list_id = null, $email_ = null) {
		$res = 0;
		$error = '';
		$MailChimpMaintenance = new MailChimpMaintenance($api_id);
		$result = $MailChimpMaintenance->call('lists/subscribe', array(
                'id'                => $list_id,
                'email'             => array('email'=> $email_),
                'merge_vars'        => array(''),
                'email_type'		=> 'html',
				'double_optin'      => false,
                'update_existing'   => true,
                'replace_interests' => false,
                'send_welcome'      => false,
            ));
		
		if (!empty($result['error'])) {
			$res  = 0;
			$error = $result['error'];
		} else {
			$res  = 1;
			$error = '';
		}	
		
		$out = array($res, $error);
		return $out;	
	}
	
	function cm_subscribe_lists($client_id = null, $api_id = null, $list_id = null, $email_ = null) {
		$res = 0;
		$error = '';
		
		$auth = array('api_key' => $api_id);
		$cMonitor = new CS_REST_Subscribers($list_id, $auth);
		
		$result = $cMonitor->add(array(
										'EmailAddress' => $email_,
										'Resubscribe'  => true
								));
		
		if (!$result->was_successful()) {
			$res  = 0;
			$error = $result->response->Message;
		} else {
			$res  = 1;
			$error = '';
		}	
		
		$out = array($res, $error);
		return $out;	
	}
	
	
	function get_mail_chimp_form_subscribe($is_validate_api_keys = true, $emassage = null) {
		
		$mt_options = mt_get_plugin_options_pro();
		$subscribe_form_title = __('Be the first to know when website is ready', 'maintenance-pro');
		if (isset($mt_options['subscribe_form_title']) && !empty($mt_options['subscribe_form_title']))  {
			$subscribe_form_title = esc_html($mt_options['subscribe_form_title']);
		}
		
		$out_form = '';
		$out_form .= '<div id="mailchimp-box" class="mailchimp-box">';
		if ($is_validate_api_keys) {
			$out_form .= '<h3>'.$subscribe_form_title.'</h3>';
			$out_form .= '<form id="custom-subscribe" name="custom-subscribe" action="">';
				$out_form .= '<span id="eicon" class="eicon" style="display: inline;">';
					$out_form .= '<input type="email" id="email-subscribe" class="email-subscribe" name="email-subscribe" value="" placeholder="'. __('Email', 'maintenance-pro') .'"/>';
				$out_form .= '</span>';
				$out_form .= '<input type="submit" id="submit-subscribe" class="submit-subscribe" value="'. __('Subscribe', 'maintenance-pro') .'" />';
			$out_form .= '</form>';
		} else {
			$out_form .= '<h3>'.$emassage.'</h3>';
		}
		$out_form .= '</div>';
		
		return $out_form;
	}
	
	function get_cm_list($client_id, $api_key) {
		$wrap = new CS_REST_Clients($client_id, $api_key);
		$result = $wrap->get_lists();
		if (!empty($result)) {
			return $result;
		}	
	}	
		
	add_action('wp_ajax_get_cm_list', 'get_cm_list_js');
	add_action('wp_ajax_nopriv_get_cm_list', 'get_cm_list_js');
	function get_cm_list_js() {
		if (!empty($_POST)) {
			$client_id = $_POST['client_id'];
			$api_key   = $_POST['api_key'];
			$arr = get_cm_list($client_id, $api_key);
			if (!empty($arr)) {
				update_option( 'mailing_grab_lists',  json_encode($arr->response));
				echo json_encode($arr->response);
			}
		}
		die('');
	}