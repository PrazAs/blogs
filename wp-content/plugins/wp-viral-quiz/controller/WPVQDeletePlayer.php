<?php 

global $vqData;

try 
{
	// Delete a single player
	if (isset($_GET['playerId']) && is_numeric($_GET['playerId']) && isset($_GET['wpvq_quizId']) && is_numeric($_GET['wpvq_quizId']))
	{
		global $wpdb;
		$wpdb->delete( WPViralQuiz::getTableName('players'), array( 'id' => $_GET['playerId']) );		

		$url_redirect 	=  esc_url_raw(remove_query_arg(array('playerId', 'id', 'element', 'action', 'wp_nonce', 'noheader'), add_query_arg(array('referer' => 'remove', 'element' => 'players', 'action' => 'show', 'wpvq_quizId' => $_GET['wpvq_quizId']))));
		wp_redirect(url_origin($_SERVER) . $url_redirect);
	} 
	// Delete all players
	elseif (isset($_GET['playerId']) && $_GET['playerId'] == 'all' && isset($_GET['wpvq_quizId']) && is_numeric($_GET['wpvq_quizId']))
	{
		global $wpdb;
		$wpdb->delete( WPViralQuiz::getTableName('players'), array( 'quizId' => $_GET['wpvq_quizId']) );		

		$url_redirect 	=  esc_url_raw(remove_query_arg(array('playerId', 'id', 'element', 'action', 'wp_nonce', 'noheader'), add_query_arg(array('referer' => 'removeAll', 'element' => 'players', 'action' => 'show', 'wpvq_quizId' => $_GET['wpvq_quizId']))));
		wp_redirect(url_origin($_SERVER) . $url_redirect);
	} 
	else {
		throw new Exception(__("This player/quiz doesn't exist.", 'wpvq'));
	}

} catch (Exception $e) {
	echo $e->getMessage();
}

//include dirname(__FILE__) . '/../views/WPVQAddQuizz.php';


