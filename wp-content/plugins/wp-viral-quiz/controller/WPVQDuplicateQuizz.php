<?php 


global $vqData;

try {
	if(isset($_GET['id']) && is_numeric($_GET['id'])) 
	{
		$type = WPVQGame::getTypeById($_GET['id']);
		$quiz = new $type();
		$quiz->load(intval($_GET['id']));

		if(!isset($_GET['wp_nonce']) || !wp_verify_nonce($_GET['wp_nonce'], 'delete_wpvquizz_'.$_GET['id'])) {
			throw new Exception(__("You can't do this ! Sorry.", 'wpvq'));
		} else {
			if($quiz->duplicate()) {
				$url_redirect 	=  esc_url_raw(remove_query_arg(array('id', 'element', 'action', 'wp_nonce', 'noheader'), add_query_arg(array('referer' => 'duplicate'))));
				wp_redirect(url_origin($_SERVER) . $url_redirect);
			} else {
				throw new Exception(__("Error during quiz duplication.", 'wpvq'));
			}
		}
	} else {
		throw new Exception(__("This quiz doesn't exist.", 'wpvq'));
	}

} catch (Exception $e) {
	echo $e->getMessage();
}


//include dirname(__FILE__) . '/../views/WPVQAddQuizz.php';


