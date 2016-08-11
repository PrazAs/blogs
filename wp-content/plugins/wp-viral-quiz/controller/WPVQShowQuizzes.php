<?php 


global $vqData;

// Admin & editor can see all quizzes
if (current_user_can('edit_others_posts')) {
	$authorId = 0;	
} else {
	$authorId = get_current_user_id();
}

// Quizzes Pagination
if (isset($_GET['wpvq_pagination']) && is_numeric($_GET['wpvq_pagination'])) {
	$wpvq_current_page = intval($_GET['wpvq_pagination']);
} else {
	$wpvq_current_page = 0;
}

$vqData['quizzes'] 		=  WPVQGame::listAll($authorId, $wpvq_current_page);
$vqData['pagesCount'] 	=  WPVQGame::getPagesCount($authorId);
$vqData['currentPage'] 	=  $wpvq_current_page;


// VIEW
include dirname(__FILE__) . '/../views/WPVQShowQuizzes.php';

