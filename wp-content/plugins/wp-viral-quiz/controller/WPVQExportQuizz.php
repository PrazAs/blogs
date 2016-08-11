<?php 


global $vqData;

try {
	if(isset($_GET['id']) && is_numeric($_GET['id'])) 
	{
		$type = WPVQGame::getTypeById($_GET['id']);
		$quiz = new $type();
		$quiz->load(intval($_GET['id']));

		if(!isset($_GET['wp_nonce']) || !wp_verify_nonce($_GET['wp_nonce'], 'delete_wpvquizz_'.$_GET['id'])) 
		{
			throw new Exception(__("You can't do that ! Sorry.", 'wpvq'));
		} 
		else 
		{
			if(($filePath = $quiz->export()) != NULL) 
			{
				header('Content-Description: File Transfer');
	            header('Content-Type: application/octet-stream');
	            header('Content-Disposition: attachment; filename='.basename($filePath));
	            header('Expires: 0');
	            header('Cache-Control: must-revalidate');
	            header('Pragma: public');
	            header('Content-Length: ' . filesize($filePath));
	            readfile($filePath);
	            exit;
			} 
			else 
			{
				throw new Exception(__("Error during export.", 'wpvq'));
			}
		}
	} else {
		throw new Exception(__("This quiz doesn't exist.", 'wpvq'));
	}

} catch (Exception $e) {
	echo $e->getMessage();
}



