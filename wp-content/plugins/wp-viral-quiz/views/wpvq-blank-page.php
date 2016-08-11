<?php 
	// Fetch page
	$post_id 	= get_the_ID();
	$the_post 	= get_post($post_id);

	// Fetch content
	$content 	= $the_post->post_content;
	$title 		= $the_post->post_title;
?>

<!DOCTYPE html>
<html>

	<head>
		<title><?php echo $title; ?></title>
		<meta name="robots" content="noindex">
	</head>

	<body>
		<?php echo do_shortcode($content); ?>
	</body>

	<?php wp_footer(); ?>

</html>