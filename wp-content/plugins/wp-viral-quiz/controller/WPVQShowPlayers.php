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

$vqData['quizId'] 		=  0;
$vqData['showTable'] 	=  false;

$vqData['page'] 		=  1;
if (isset($_GET['wpvq_page']))
{
	$vqData['page'] = intval($_GET['wpvq_page']);
}

if (isset($_GET['wpvq_quizId'])) 
{
	$quizId 	= intval($_GET['wpvq_quizId']);
	$players 	= new WPVQPlayers();
	$players 	= $players->load($quizId, true, $vqData['page']);

	$vqData['showTable'] 	= true;
	$vqData['players']  	= $players;
	$vqData['quizId']   	= $quizId;

	$vqData['exportUrl'] 	= esc_url(add_query_arg(array('element'=>'players','action'=>'export', 'quizId' => $quizId, 'noheader' => 1)));
	$vqData['removeAllurl'] = esc_url(add_query_arg(array('element'=>'players','action'=>'export', 'quizId' => $quizId, 'noheader' => 1)));
}

// Export to CSV
if (isset($_GET['action']) && $_GET['action'] == 'export' && is_numeric($_GET['quizId'])) 
{
	$quizId 	= intval($_GET['quizId']);
	$players 	= new WPVQPlayers();
	$players 	= $players->load($quizId, true, '*');

	$getPlayers = $players->getPlayers();
	if (empty($getPlayers)) {
		return;
	}

	$csv = ''; $i = 1; $separator = ';';
	foreach ($getPlayers as $index => $player) 
	{
		// Save meta and remove it to build the main csv row
		$meta 			=  '';
		$metaHeaders 	=  array();
		// If there are meta values
		if ($player['meta'] != NULL && $player['meta'] != '') 
		{
			$player['meta'] = apply_filters('wpvq_export_csv_meta', $player['meta'], $player);

			$meta 			=  $player['meta'];
			$metaHeaders 	=  array_keys($meta);
			if (is_array($meta)) {
				$meta = implode($separator, $meta);
			}
		}

		// Compute date
		$player['date'] = date(DATE_RFC2822, $player['date']);

		// Column titles of the csv file
		// $i=1 because we create titles only 1 time, @ the first loop
		unset($player['meta']);
		if ($i == 1) {
			$headers = array_keys($player);
			$headers = array_merge($headers, $metaHeaders);
			$headers = implode($separator, $headers);
			$csv = $headers . "\n";
		}

		// build the main row + add meta
		$csvTemp = implode($separator, $player);
		$csvTemp .= $separator . $meta;

		$csv .= stripslashes($csvTemp);
		$csv .= "\n";

		$i++;
	}

	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=export-quiz.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	print $csv;
	die();

}

// VIEW
include dirname(__FILE__) . '/../views/WPVQShowPlayers.php';

