<?php
/*
	Plugin Name: Maintenance Pro
	Plugin URI: http://codecanyon.net/item/maintenance-pro-wordpress-plugin/2781350
	Description: PRO provides extended functionality for <a href="http://wordpress.org/plugins/maintenance/">Maintenance</a> WordPress plugin. They works together.
	Version: 3.0
	Author: fruitfulcode
	Author URI: http://fruitfulcode.com
	License: GPL2
*/
/*  Copyright 2013  Fruitful Code  (email : mail@fruitfulcode.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class maintenance_pro  {
		function __construct() {
			global $options_page;
				   $options_page = 'toplevel_page_maintenance';
				   
			add_action( 'plugins_loaded', array( &$this, 'constants'), 	1);
			add_action( 'plugins_loaded', array( &$this, 'lang'),		2);
			add_action( 'plugins_loaded', array( &$this, 'includes'), 	3);
			add_action( 'plugins_loaded', array( &$this, 'alter_maintenance_action'),	4);
			add_action( 'admin_notices',  array( &$this, 'plugin_notice_message' ) ) ;
			register_activation_hook  ( __FILE__, array( &$this,  'activation' ));
			register_deactivation_hook( __FILE__, array( &$this,  'deactivation') );
			add_action('init', array( &$this, 'remove_action_area' ) ) ;
		}
		
		function remove_action_area() {
			remove_action('add_meta_boxes', 'maintenance_page_create_meta_boxes_widget_pro', 11);	
		}
		
		function constants() {
			define( 'MAINTENANCE_PRO_VERSION', '2.0.0' );
			define( 'MAINTENANCE_PRO_DB_VERSION', 1 );
			define( 'MAINTENANCE_PRO_WP_VERSION', get_bloginfo( 'version' ));
			define( 'MAINTENANCE_PRO_DIR', 		  trailingslashit( plugin_dir_path( __FILE__ ) ) );
			define( 'MAINTENANCE_PRO_URI', 		  trailingslashit( plugin_dir_url( __FILE__ ) ) );
			define( 'MAINTENANCE_PRO_INCLUDES',   MAINTENANCE_PRO_DIR . trailingslashit( 'includes' ) );
		}
		
		function lang() {
			load_plugin_textdomain( 'maintenance-pro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );		
		}	
		
		function includes() {
			/*Mail list*/
			include_once( MAINTENANCE_PRO_INCLUDES . 'mailchimp/MailChimp.class.php');
			include_once( MAINTENANCE_PRO_INCLUDES . 'campaignmonitor/csrest_general.php');
			include_once( MAINTENANCE_PRO_INCLUDES . 'campaignmonitor/csrest_subscribers.php');
			include_once( MAINTENANCE_PRO_INCLUDES . 'campaignmonitor/csrest_lists.php');
			include_once( MAINTENANCE_PRO_INCLUDES . 'campaignmonitor/csrest_clients.php');
			/*
			
			*/
			
			include_once( MAINTENANCE_PRO_INCLUDES . 'functions.php' ); 
		}
		
		function alter_maintenance_action() {
		
		}
		
		function plugin_notice_message() {
			$html = '';
			$free_options = get_option('maintenance_options');
			if (empty($free_options)) {
				$plugin = '';
				$plugin = plugin_basename( __FILE__ );
				if( is_plugin_active($plugin) ) {
					deactivate_plugins( $plugin );
				}
				include_once( MAINTENANCE_PRO_INCLUDES . '_message.php' ); 
			}	
		}
		
		function activation() {
			$default_arr  = array();
			$free_options = get_option('maintenance_options');
			
			$default_arr  = array(
				'gallery_array'		=> array(),
				'single_link_video' => '',
				'expiry_date_start'	=> date_i18n( 'Y-m-d', strtotime( current_time('mysql', 0) )), 
				'expiry_date_end'	=> date_i18n( 'Y-m-d', strtotime( current_time('mysql', 0) )+60*60*24*30),
				'expiry_time_start'	=> date_i18n( 'h:i a', strtotime( current_time('mysql', 0) )), 
				'expiry_time_end'	=> date_i18n( 'h:i a', strtotime( current_time('mysql', 0) )),
				'countdown_type'		=>  1,
				'countdown_color'	    => '#333333',	
				'countdown_font_color'	=> '#fffffff',	
				'countdown_font_family' => 'Open Sans',
				'countdown_font_size' 	=> '90px',
				'delay_time'			=> '7000',
				'is_down' 			=> false,
				'is_countdown_display' => false,
				'roles_array'		=> array(),
				'social'			=> array(),
				'htmlcss'			=> '',
				'mail_lists'		=> 'mail_ch',
				'mailchimp_param'	=> array(	'mailchimp_app_id'  => '',
												'mailchimp_list_id' => '',
											),
				'campaignmonitor_param' => array (
												'campaignmonitor_client_id' => '',
												'campaignmonitor_api_key'	=> '',
												'campaignmonitor_list_id' 	=> ''
												),
				'subscribe_form_title' => __('Be the first to know when website is ready', 'maintenance-pro'),
				'preloader'			=> true
												
												
												
			);
			
			if (!empty($free_options)) {
				if (!array_key_exists('expiry_date_start', $free_options) ||
					!array_key_exists('expiry_date_end', $free_options)) {
						$options  = wp_parse_args($default_arr, $free_options );
						update_option( 'maintenance_options',  $options);
				}	
			} 			
		}	
		function deactivation () {
			/*Closed Pro Postboxes*/
			$user_id = get_current_user_id();
			delete_user_option( $user_id, 'maintenance_pb_has_been_closed', true );
		}
}
$maintenance_pro = new maintenance_pro();