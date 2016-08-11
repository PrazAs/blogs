<?php 

try 
{
	if(isset($_POST['urls'])) 
	{
		echo "<pre>";
		echo "— DEBUG —";
		print_r($_POST);
		echo "</pre>";
		die();
	}
} 
catch (Exception $e) {
	echo $e->getMessage();
}
