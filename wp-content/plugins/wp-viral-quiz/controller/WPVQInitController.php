<?php
	
class WPVQInitController {

	function __construct() {

	}

	public static function init_page_admin_addons() {

		global $wp_query, $vqData;
		$url_create = esc_url(add_query_arg(array('element' => 'addons', 'action' => 'show')));

		// Addons list
		$wpvq_AddonsPage_shown = false;
		if (isset($_GET['element']) && $_GET['element'] == 'addons')
		{
			switch ($_GET['action']) 
			{
				case 'show':
				default:
					$wpvq_AddonsPage_shown = true;
					include dirname(__FILE__) . '/WPVQShowAddons.php';
				break;
			}
		}
		else
		{
			$wpvq_AddonsPage_shown = true;
			include dirname(__FILE__) . '/WPVQShowAddons.php';
		}

		// Manage notice for addon page (hide notice)
		if($wpvq_AddonsPage_shown) {
			update_option( 'wpvq_notice_addons_1', 1);
		}

	}

	public static function init_page_admin_players() {

		global $wp_query, $vqData;
		$url_create = esc_url(add_query_arg(array('element' => 'players', 'action' => 'show')));

		// Players list
		if (isset($_GET['element']) && $_GET['element'] == 'players')
		{
			switch ($_GET['action']) 
			{
				case 'show':
				default:
					include dirname(__FILE__) . '/WPVQShowPlayers.php';
				break;
				case 'remove':
					include dirname(__FILE__) . '/WPVQDeletePlayer.php';
				break;
			}
		}
		else
		{
			include dirname(__FILE__) . '/WPVQShowPlayers.php';
		}

	}

	public static function init_page_admin() {

		global $wp_query, $vqData;

		$url_create_quiz = esc_url(add_query_arg(array('element'=>'quizzes','action'=>'show')));
		
		// Quizzes list
		if (isset($_GET['element']) && $_GET['element'] == 'quizzes')
		{

			switch ($_GET['action']) 
			{
				case 'show':
				default:
					include dirname(__FILE__) . '/WPVQShowQuizzes.php';
				break;
			}

		}


		// Quizz config
		elseif (isset($_GET['element']) && $_GET['element'] == 'quiz')
		{

			switch ($_GET['action']) 
			{
				case 'add':
				default:
					include dirname(__FILE__) . '/WPVQAddQuizz.php';
				break;
				case 'delete':	
					include dirname(__FILE__) . '/WPVQDeleteQuizz.php';
				break;
				case 'duplicate':	
					include dirname(__FILE__) . '/WPVQDuplicateQuizz.php';
				break;
				case 'export':	
					include dirname(__FILE__) . '/WPVQExportQuizz.php';
				break;
				case 'import':	
					include dirname(__FILE__) . '/WPVQImportQuizz.php';
				break;
			}
		}

		else
		{
			if (!isset($_GET['element']) && !isset($_GET['action']))
			{
				include dirname(__FILE__) . '/WPVQShowQuizzes.php';
			}
			else
			{
				do_action('wpvq_custom_page');
			}
		}

	}
}