<?php 
/*
Plugin Name:Wordpress Rankie
Plugin URI: http://codecanyon.net/item/rankie-wordpress-rank-tracker-plugin/7605032?ref=ValvePress
Description: Wordpress ranking tracking plugin
Version: 1.5.0
Author: Atef 
Author URI: http://codecanyon.net/user/ValvePress/portfolio?ref=ValvePress
*/

/*  Copyright 2014  Wordpress Ranker   (email : sweetheatmn@gmail.com) */

 
// UPDATES
$licenseactive=get_option('wp_rankie_license_active','');
if(trim($licenseactive) != ''){

	//fire checks
	require 'plugin-updates/plugin-update-checker.php';
	$wp_rankie_UpdateChecker = PucFactory::buildUpdateChecker(
			'http://deandev.com/upgrades/meta/wp-rankie.json',
			__FILE__,
			'wp-ranker'
	);

	//append keys to the download url
	$wp_rankie_UpdateChecker->addResultFilter('wp_rankie_addResultFilter');
	function wp_rankie_addResultFilter($info){
			
		$wp_rankie_license = get_option('wp_rankie_license','');

		if(isset($info->download_url)){
			$info->download_url = $info->download_url . '&key='.$wp_rankie_license;
		}
		return $info;
	}
}

//generic functions 
require_once 'r-functions.php';

//log
require_once 'r-log.php';

//Menus
require_once 'r-menus.php';

//Dashboard page
require_once 'r-dashboard.php';

//Settings page
function wp_rankie_settings_fn(){
	require_once 'r-settings.php';	
}

//Ajax 
require_once 'r-ajax.php';

//Reports page
function wp_rankie_reports_fn(){
	require_once 'r-reports.php';
}

//catch new words hook
require_once 'r-catch.php';  

//internal cron schedule
require_once 'r-schedule.php';

//internal cron schedule
require_once 'r-schedule-report.php';

//research page 
require_once 'r-research.php';

//license notice
require_once 'r-license.php';

//plugin tables
register_activation_hook( __FILE__, 'create_table_wp_rankie' );
require_once 'r-tables.php';



?>