<?php 

global $vqData;

// Admin & editor can see all quizzes
if (current_user_can('edit_others_posts')) {
	$authorId = 0;	
} else {
	$authorId = get_current_user_id();
}

// VIEW
include dirname(__FILE__) . '/../views/WPVQShowAddons.php';

