<?php
/* Theme Support */
function thb_theme_setup() {
	/* Text Domain */
	load_theme_textdomain('goodlife', THB_THEME_ROOT_ABS . '/inc/languages');
	
	/* Background Support */
	add_theme_support( 'custom-background', array( 'default-color' => 'ffffff') );
	
	/* Title Support */
	add_theme_support( 'title-tag' );

	/* Post Formats */
	add_theme_support('post-formats', array('video', 'gallery'));
	
	/* Editor Styling */
	$body_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Droid+Serif:200,300,400,500,600,700&subset=latin,latin-ext' );
	$title_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700&subset=latin,latin-ext' );
	add_editor_style( array($body_url, $title_url, 'editor-style.css') );
	
	/* Required Settings */
	global $content_width;
	if(!isset($content_width)) $content_width = 1170;
	add_theme_support( 'automatic-feed-links' );
	
	/* Image Settings */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 80, 75, true );
	add_image_size('goodlife-latest', 370, 260, true );
	add_image_size('goodlife-latest-short', 570, 300, true );
	add_image_size('goodlife-widget-photo', 280, 150, true );
	add_image_size('goodlife-widget-photo-vertical', 280, 375, true );
	add_image_size('goodlife-gallery', 1170, 550, true );
	add_image_size('goodlife-gallery-vertical', 670, 730, true );
	add_image_size('goodlife-video-others', 170, 100, true );
	add_image_size('goodlife-post-style1', 770, 9999, false );
	add_image_size('goodlife-grid-8x8', 780, 621, true );
	add_image_size('goodlife-grid-6x6', 584, 425, true );
	add_image_size('goodlife-grid-8x2', 780, 309, true );
	add_image_size('goodlife-grid-2x2', 388, 308, true );
	
	if (false === get_option("medium_crop")) {
	    add_option("medium_crop", "1");
	} else {
	    update_option("medium_crop", "1");
	}
	  
	/* HTML5 Galleries */
	add_theme_support( 'html5', array( 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'thb_theme_setup' );

/* Body Classes */
function thb_body_classes( $classes ) {
	$classes[] = 'lazy-load-'.ot_get_option('lazy_load', 'on');
	$classes[] = 'thb_ads_header_mobile_'.ot_get_option('thb_ads_header_mobile', 'on');
	return $classes;
}
add_filter( 'body_class', 'thb_body_classes' );

/* Youtube & Vimeo Embeds */
function thb_remove_youtube_controls($code){
  if(strpos($code, 'youtu.be') !== false || strpos($code, 'youtube.com') !== false || strpos($code, 'player.vimeo.com') !== false){
  		if(strpos($code, 'youtu.be') !== false || strpos($code, 'youtube.com') !== false) {
      	$return = preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&showinfo=0&rel=0&modestbranding=1", $code);
  		} else {
      	$return = $code;
  		}
      $return = '<div class="flex-video widescreen'.(strpos($code, 'player.vimeo.com') !== false ? ' vimeo' : ' youtube').'">'.$return.'</div>';
  } else {
      $return = $code;
  }
  return $return;
}
 
add_filter('embed_handler_html', 'thb_remove_youtube_controls');
add_filter('embed_oembed_html', 'thb_remove_youtube_controls');

/* Category Rel Fix */
function thb_remove_category_list_rel( $output ) {
    return str_replace( ' rel="category tag"', '', $output );
}
add_filter( 'wp_list_categories', 'thb_remove_category_list_rel' );
add_filter( 'the_category', 'thb_remove_category_list_rel' );

/* Author FB, TW & G+ Links */
function thb_my_new_contactmethods( $contactmethods ) {
	// Add Position
	$contactmethods['position'] = 'Position';
	// Add Twitter
	$contactmethods['twitter'] = 'Twitter URL';
	// Add Facebook
	$contactmethods['facebook'] = 'Facebook URL';
	// Add Google+
	$contactmethods['googleplus'] = 'Google Plus URL';
	
	return $contactmethods;
}
add_filter('user_contactmethods','thb_my_new_contactmethods',10,1);

/* Font Awesome Array */
function thb_getIconArray(){
	$icons = array(
		'' => '', 'fa-glass' => 'fa-glass', 'fa-music' => 'fa-music', 'fa-search' => 'fa-search', 'fa-envelope-o' => 'fa-envelope-o', 'fa-heart' => 'fa-heart', 'fa-star' => 'fa-star', 'fa-star-o' => 'fa-star-o', 'fa-user' => 'fa-user', 'fa-film' => 'fa-film', 'fa-th-large' => 'fa-th-large', 'fa-th' => 'fa-th', 'fa-th-list' => 'fa-th-list', 'fa-check' => 'fa-check', 'fa-times' => 'fa-times', 'fa-search-plus' => 'fa-search-plus', 'fa-search-minus' => 'fa-search-minus', 'fa-power-off' => 'fa-power-off', 'fa-signal' => 'fa-signal', 'fa-cog' => 'fa-cog', 'fa-trash-o' => 'fa-trash-o', 'fa-home' => 'fa-home', 'fa-file-o' => 'fa-file-o', 'fa-clock-o' => 'fa-clock-o', 'fa-road' => 'fa-road', 'fa-download' => 'fa-download', 'fa-arrow-circle-o-down' => 'fa-arrow-circle-o-down', 'fa-arrow-circle-o-up' => 'fa-arrow-circle-o-up', 'fa-inbox' => 'fa-inbox', 'fa-play-circle-o' => 'fa-play-circle-o', 'fa-repeat' => 'fa-repeat', 'fa-refresh' => 'fa-refresh', 'fa-list-alt' => 'fa-list-alt', 'fa-lock' => 'fa-lock', 'fa-flag' => 'fa-flag', 'fa-headphones' => 'fa-headphones', 'fa-volume-off' => 'fa-volume-off', 'fa-volume-down' => 'fa-volume-down', 'fa-volume-up' => 'fa-volume-up', 'fa-qrcode' => 'fa-qrcode', 'fa-barcode' => 'fa-barcode', 'fa-tag' => 'fa-tag', 'fa-tags' => 'fa-tags', 'fa-book' => 'fa-book', 'fa-bookmark' => 'fa-bookmark', 'fa-print' => 'fa-print', 'fa-camera' => 'fa-camera', 'fa-font' => 'fa-font', 'fa-bold' => 'fa-bold', 'fa-italic' => 'fa-italic', 'fa-text-height' => 'fa-text-height', 'fa-text-width' => 'fa-text-width', 'fa-align-left' => 'fa-align-left', 'fa-align-center' => 'fa-align-center', 'fa-align-right' => 'fa-align-right', 'fa-align-justify' => 'fa-align-justify', 'fa-list' => 'fa-list', 'fa-outdent' => 'fa-outdent', 'fa-indent' => 'fa-indent', 'fa-video-camera' => 'fa-video-camera', 'fa-picture-o' => 'fa-picture-o', 'fa-pencil' => 'fa-pencil', 'fa-map-marker' => 'fa-map-marker', 'fa-adjust' => 'fa-adjust', 'fa-tint' => 'fa-tint', 'fa-pencil-square-o' => 'fa-pencil-square-o', 'fa-share-square-o' => 'fa-share-square-o', 'fa-check-square-o' => 'fa-check-square-o', 'fa-arrows' => 'fa-arrows', 'fa-step-backward' => 'fa-step-backward', 'fa-fast-backward' => 'fa-fast-backward', 'fa-backward' => 'fa-backward', 'fa-play' => 'fa-play', 'fa-pause' => 'fa-pause', 'fa-stop' => 'fa-stop', 'fa-forward' => 'fa-forward', 'fa-fast-forward' => 'fa-fast-forward', 'fa-step-forward' => 'fa-step-forward', 'fa-eject' => 'fa-eject', 'fa-chevron-left' => 'fa-chevron-left', 'fa-chevron-right' => 'fa-chevron-right', 'fa-plus-circle' => 'fa-plus-circle', 'fa-minus-circle' => 'fa-minus-circle', 'fa-times-circle' => 'fa-times-circle', 'fa-check-circle' => 'fa-check-circle', 'fa-question-circle' => 'fa-question-circle', 'fa-info-circle' => 'fa-info-circle', 'fa-crosshairs' => 'fa-crosshairs', 'fa-times-circle-o' => 'fa-times-circle-o', 'fa-check-circle-o' => 'fa-check-circle-o', 'fa-ban' => 'fa-ban', 'fa-arrow-left' => 'fa-arrow-left', 'fa-arrow-right' => 'fa-arrow-right', 'fa-arrow-up' => 'fa-arrow-up', 'fa-arrow-down' => 'fa-arrow-down', 'fa-share' => 'fa-share', 'fa-expand' => 'fa-expand', 'fa-compress' => 'fa-compress', 'fa-plus' => 'fa-plus', 'fa-minus' => 'fa-minus', 'fa-asterisk' => 'fa-asterisk', 'fa-exclamation-circle' => 'fa-exclamation-circle', 'fa-gift' => 'fa-gift', 'fa-leaf' => 'fa-leaf', 'fa-fire' => 'fa-fire', 'fa-eye' => 'fa-eye', 'fa-eye-slash' => 'fa-eye-slash', 'fa-exclamation-triangle' => 'fa-exclamation-triangle', 'fa-plane' => 'fa-plane', 'fa-calendar' => 'fa-calendar', 'fa-random' => 'fa-random', 'fa-comment' => 'fa-comment', 'fa-magnet' => 'fa-magnet', 'fa-chevron-up' => 'fa-chevron-up', 'fa-chevron-down' => 'fa-chevron-down', 'fa-retweet' => 'fa-retweet', 'fa-shopping-cart' => 'fa-shopping-cart', 'fa-folder' => 'fa-folder', 'fa-folder-open' => 'fa-folder-open', 'fa-arrows-v' => 'fa-arrows-v', 'fa-arrows-h' => 'fa-arrows-h', 'fa-bar-chart' => 'fa-bar-chart', 'fa-twitter-square' => 'fa-twitter-square', 'fa-facebook-square' => 'fa-facebook-square', 'fa-camera-retro' => 'fa-camera-retro', 'fa-key' => 'fa-key', 'fa-cogs' => 'fa-cogs', 'fa-comments' => 'fa-comments', 'fa-thumbs-o-up' => 'fa-thumbs-o-up', 'fa-thumbs-o-down' => 'fa-thumbs-o-down', 'fa-star-half' => 'fa-star-half', 'fa-heart-o' => 'fa-heart-o', 'fa-sign-out' => 'fa-sign-out', 'fa-linkedin-square' => 'fa-linkedin-square', 'fa-thumb-tack' => 'fa-thumb-tack', 'fa-external-link' => 'fa-external-link', 'fa-sign-in' => 'fa-sign-in', 'fa-trophy' => 'fa-trophy', 'fa-github-square' => 'fa-github-square', 'fa-upload' => 'fa-upload', 'fa-lemon-o' => 'fa-lemon-o', 'fa-phone' => 'fa-phone', 'fa-square-o' => 'fa-square-o', 'fa-bookmark-o' => 'fa-bookmark-o', 'fa-phone-square' => 'fa-phone-square', 'fa-twitter' => 'fa-twitter', 'fa-facebook' => 'fa-facebook', 'fa-github' => 'fa-github', 'fa-unlock' => 'fa-unlock', 'fa-credit-card' => 'fa-credit-card', 'fa-rss' => 'fa-rss', 'fa-hdd-o' => 'fa-hdd-o', 'fa-bullhorn' => 'fa-bullhorn', 'fa-bell' => 'fa-bell', 'fa-certificate' => 'fa-certificate', 'fa-hand-o-right' => 'fa-hand-o-right', 'fa-hand-o-left' => 'fa-hand-o-left', 'fa-hand-o-up' => 'fa-hand-o-up', 'fa-hand-o-down' => 'fa-hand-o-down', 'fa-arrow-circle-left' => 'fa-arrow-circle-left', 'fa-arrow-circle-right' => 'fa-arrow-circle-right', 'fa-arrow-circle-up' => 'fa-arrow-circle-up', 'fa-arrow-circle-down' => 'fa-arrow-circle-down', 'fa-globe' => 'fa-globe', 'fa-wrench' => 'fa-wrench', 'fa-tasks' => 'fa-tasks', 'fa-filter' => 'fa-filter', 'fa-briefcase' => 'fa-briefcase', 'fa-arrows-alt' => 'fa-arrows-alt', 'fa-users' => 'fa-users', 'fa-link' => 'fa-link', 'fa-cloud' => 'fa-cloud', 'fa-flask' => 'fa-flask', 'fa-scissors' => 'fa-scissors', 'fa-files-o' => 'fa-files-o', 'fa-paperclip' => 'fa-paperclip', 'fa-floppy-o' => 'fa-floppy-o', 'fa-square' => 'fa-square', 'fa-bars' => 'fa-bars', 'fa-list-ul' => 'fa-list-ul', 'fa-list-ol' => 'fa-list-ol', 'fa-strikethrough' => 'fa-strikethrough', 'fa-underline' => 'fa-underline', 'fa-table' => 'fa-table', 'fa-magic' => 'fa-magic', 'fa-truck' => 'fa-truck', 'fa-pinterest' => 'fa-pinterest', 'fa-pinterest-square' => 'fa-pinterest-square', 'fa-google-plus-square' => 'fa-google-plus-square', 'fa-google-plus' => 'fa-google-plus', 'fa-money' => 'fa-money', 'fa-caret-down' => 'fa-caret-down', 'fa-caret-up' => 'fa-caret-up', 'fa-caret-left' => 'fa-caret-left', 'fa-caret-right' => 'fa-caret-right', 'fa-columns' => 'fa-columns', 'fa-sort' => 'fa-sort', 'fa-sort-desc' => 'fa-sort-desc', 'fa-sort-asc' => 'fa-sort-asc', 'fa-envelope' => 'fa-envelope', 'fa-linkedin' => 'fa-linkedin', 'fa-undo' => 'fa-undo', 'fa-gavel' => 'fa-gavel', 'fa-tachometer' => 'fa-tachometer', 'fa-comment-o' => 'fa-comment-o', 'fa-comments-o' => 'fa-comments-o', 'fa-bolt' => 'fa-bolt', 'fa-sitemap' => 'fa-sitemap', 'fa-umbrella' => 'fa-umbrella', 'fa-clipboard' => 'fa-clipboard', 'fa-lightbulb-o' => 'fa-lightbulb-o', 'fa-exchange' => 'fa-exchange', 'fa-cloud-download' => 'fa-cloud-download', 'fa-cloud-upload' => 'fa-cloud-upload', 'fa-user-md' => 'fa-user-md', 'fa-stethoscope' => 'fa-stethoscope', 'fa-suitcase' => 'fa-suitcase', 'fa-bell-o' => 'fa-bell-o', 'fa-coffee' => 'fa-coffee', 'fa-cutlery' => 'fa-cutlery', 'fa-file-text-o' => 'fa-file-text-o', 'fa-building-o' => 'fa-building-o', 'fa-hospital-o' => 'fa-hospital-o', 'fa-ambulance' => 'fa-ambulance', 'fa-medkit' => 'fa-medkit', 'fa-fighter-jet' => 'fa-fighter-jet', 'fa-beer' => 'fa-beer', 'fa-h-square' => 'fa-h-square', 'fa-plus-square' => 'fa-plus-square', 'fa-angle-double-left' => 'fa-angle-double-left', 'fa-angle-double-right' => 'fa-angle-double-right', 'fa-angle-double-up' => 'fa-angle-double-up', 'fa-angle-double-down' => 'fa-angle-double-down', 'fa-angle-left' => 'fa-angle-left', 'fa-angle-right' => 'fa-angle-right', 'fa-angle-up' => 'fa-angle-up', 'fa-angle-down' => 'fa-angle-down', 'fa-desktop' => 'fa-desktop', 'fa-laptop' => 'fa-laptop', 'fa-tablet' => 'fa-tablet', 'fa-mobile' => 'fa-mobile', 'fa-circle-o' => 'fa-circle-o', 'fa-quote-left' => 'fa-quote-left', 'fa-quote-right' => 'fa-quote-right', 'fa-spinner' => 'fa-spinner', 'fa-circle' => 'fa-circle', 'fa-reply' => 'fa-reply', 'fa-github-alt' => 'fa-github-alt', 'fa-folder-o' => 'fa-folder-o', 'fa-folder-open-o' => 'fa-folder-open-o', 'fa-smile-o' => 'fa-smile-o', 'fa-frown-o' => 'fa-frown-o', 'fa-meh-o' => 'fa-meh-o', 'fa-gamepad' => 'fa-gamepad', 'fa-keyboard-o' => 'fa-keyboard-o', 'fa-flag-o' => 'fa-flag-o', 'fa-flag-checkered' => 'fa-flag-checkered', 'fa-terminal' => 'fa-terminal', 'fa-code' => 'fa-code', 'fa-reply-all' => 'fa-reply-all', 'fa-star-half-o' => 'fa-star-half-o', 'fa-location-arrow' => 'fa-location-arrow', 'fa-crop' => 'fa-crop', 'fa-code-fork' => 'fa-code-fork', 'fa-chain-broken' => 'fa-chain-broken', 'fa-question' => 'fa-question', 'fa-info' => 'fa-info', 'fa-exclamation' => 'fa-exclamation', 'fa-superscript' => 'fa-superscript', 'fa-subscript' => 'fa-subscript', 'fa-eraser' => 'fa-eraser', 'fa-puzzle-piece' => 'fa-puzzle-piece', 'fa-microphone' => 'fa-microphone', 'fa-microphone-slash' => 'fa-microphone-slash', 'fa-shield' => 'fa-shield', 'fa-calendar-o' => 'fa-calendar-o', 'fa-fire-extinguisher' => 'fa-fire-extinguisher', 'fa-rocket' => 'fa-rocket', 'fa-maxcdn' => 'fa-maxcdn', 'fa-chevron-circle-left' => 'fa-chevron-circle-left', 'fa-chevron-circle-right' => 'fa-chevron-circle-right', 'fa-chevron-circle-up' => 'fa-chevron-circle-up', 'fa-chevron-circle-down' => 'fa-chevron-circle-down', 'fa-html5' => 'fa-html5', 'fa-css3' => 'fa-css3', 'fa-anchor' => 'fa-anchor', 'fa-unlock-alt' => 'fa-unlock-alt', 'fa-bullseye' => 'fa-bullseye', 'fa-ellipsis-h' => 'fa-ellipsis-h', 'fa-ellipsis-v' => 'fa-ellipsis-v', 'fa-rss-square' => 'fa-rss-square', 'fa-play-circle' => 'fa-play-circle', 'fa-ticket' => 'fa-ticket', 'fa-minus-square' => 'fa-minus-square', 'fa-minus-square-o' => 'fa-minus-square-o', 'fa-level-up' => 'fa-level-up', 'fa-level-down' => 'fa-level-down', 'fa-check-square' => 'fa-check-square', 'fa-pencil-square' => 'fa-pencil-square', 'fa-external-link-square' => 'fa-external-link-square', 'fa-share-square' => 'fa-share-square', 'fa-compass' => 'fa-compass', 'fa-caret-square-o-down' => 'fa-caret-square-o-down', 'fa-caret-square-o-up' => 'fa-caret-square-o-up', 'fa-caret-square-o-right' => 'fa-caret-square-o-right', 'fa-eur' => 'fa-eur', 'fa-gbp' => 'fa-gbp', 'fa-usd' => 'fa-usd', 'fa-inr' => 'fa-inr', 'fa-jpy' => 'fa-jpy', 'fa-rub' => 'fa-rub', 'fa-krw' => 'fa-krw', 'fa-btc' => 'fa-btc', 'fa-file' => 'fa-file', 'fa-file-text' => 'fa-file-text', 'fa-sort-alpha-asc' => 'fa-sort-alpha-asc', 'fa-sort-alpha-desc' => 'fa-sort-alpha-desc', 'fa-sort-amount-asc' => 'fa-sort-amount-asc', 'fa-sort-amount-desc' => 'fa-sort-amount-desc', 'fa-sort-numeric-asc' => 'fa-sort-numeric-asc', 'fa-sort-numeric-desc' => 'fa-sort-numeric-desc', 'fa-thumbs-up' => 'fa-thumbs-up', 'fa-thumbs-down' => 'fa-thumbs-down', 'fa-youtube-square' => 'fa-youtube-square', 'fa-youtube' => 'fa-youtube', 'fa-xing' => 'fa-xing', 'fa-xing-square' => 'fa-xing-square', 'fa-youtube-play' => 'fa-youtube-play', 'fa-dropbox' => 'fa-dropbox', 'fa-stack-overflow' => 'fa-stack-overflow', 'fa-instagram' => 'fa-instagram', 'fa-flickr' => 'fa-flickr', 'fa-adn' => 'fa-adn', 'fa-bitbucket' => 'fa-bitbucket', 'fa-bitbucket-square' => 'fa-bitbucket-square', 'fa-tumblr' => 'fa-tumblr', 'fa-tumblr-square' => 'fa-tumblr-square', 'fa-long-arrow-down' => 'fa-long-arrow-down', 'fa-long-arrow-up' => 'fa-long-arrow-up', 'fa-long-arrow-left' => 'fa-long-arrow-left', 'fa-long-arrow-right' => 'fa-long-arrow-right', 'fa-apple' => 'fa-apple', 'fa-windows' => 'fa-windows', 'fa-android' => 'fa-android', 'fa-linux' => 'fa-linux', 'fa-dribbble' => 'fa-dribbble', 'fa-skype' => 'fa-skype', 'fa-foursquare' => 'fa-foursquare', 'fa-trello' => 'fa-trello', 'fa-female' => 'fa-female', 'fa-male' => 'fa-male', 'fa-gratipay' => 'fa-gratipay', 'fa-sun-o' => 'fa-sun-o', 'fa-moon-o' => 'fa-moon-o', 'fa-archive' => 'fa-archive', 'fa-bug' => 'fa-bug', 'fa-vk' => 'fa-vk', 'fa-weibo' => 'fa-weibo', 'fa-renren' => 'fa-renren', 'fa-pagelines' => 'fa-pagelines', 'fa-stack-exchange' => 'fa-stack-exchange', 'fa-arrow-circle-o-right' => 'fa-arrow-circle-o-right', 'fa-arrow-circle-o-left' => 'fa-arrow-circle-o-left', 'fa-caret-square-o-left' => 'fa-caret-square-o-left', 'fa-dot-circle-o' => 'fa-dot-circle-o', 'fa-wheelchair' => 'fa-wheelchair', 'fa-vimeo-square' => 'fa-vimeo-square', 'fa-try' => 'fa-try', 'fa-plus-square-o' => 'fa-plus-square-o', 'fa-space-shuttle' => 'fa-space-shuttle', 'fa-slack' => 'fa-slack', 'fa-envelope-square' => 'fa-envelope-square', 'fa-wordpress' => 'fa-wordpress', 'fa-openid' => 'fa-openid', 'fa-university' => 'fa-university', 'fa-graduation-cap' => 'fa-graduation-cap', 'fa-yahoo' => 'fa-yahoo', 'fa-google' => 'fa-google', 'fa-reddit' => 'fa-reddit', 'fa-reddit-square' => 'fa-reddit-square', 'fa-stumbleupon-circle' => 'fa-stumbleupon-circle', 'fa-stumbleupon' => 'fa-stumbleupon', 'fa-delicious' => 'fa-delicious', 'fa-digg' => 'fa-digg', 'fa-pied-piper-pp' => 'fa-pied-piper-pp', 'fa-pied-piper-alt' => 'fa-pied-piper-alt', 'fa-drupal' => 'fa-drupal', 'fa-joomla' => 'fa-joomla', 'fa-language' => 'fa-language', 'fa-fax' => 'fa-fax', 'fa-building' => 'fa-building', 'fa-child' => 'fa-child', 'fa-paw' => 'fa-paw', 'fa-spoon' => 'fa-spoon', 'fa-cube' => 'fa-cube', 'fa-cubes' => 'fa-cubes', 'fa-behance' => 'fa-behance', 'fa-behance-square' => 'fa-behance-square', 'fa-steam' => 'fa-steam', 'fa-steam-square' => 'fa-steam-square', 'fa-recycle' => 'fa-recycle', 'fa-car' => 'fa-car', 'fa-taxi' => 'fa-taxi', 'fa-tree' => 'fa-tree', 'fa-spotify' => 'fa-spotify', 'fa-deviantart' => 'fa-deviantart', 'fa-soundcloud' => 'fa-soundcloud', 'fa-database' => 'fa-database', 'fa-file-pdf-o' => 'fa-file-pdf-o', 'fa-file-word-o' => 'fa-file-word-o', 'fa-file-excel-o' => 'fa-file-excel-o', 'fa-file-powerpoint-o' => 'fa-file-powerpoint-o', 'fa-file-image-o' => 'fa-file-image-o', 'fa-file-archive-o' => 'fa-file-archive-o', 'fa-file-audio-o' => 'fa-file-audio-o', 'fa-file-video-o' => 'fa-file-video-o', 'fa-file-code-o' => 'fa-file-code-o', 'fa-vine' => 'fa-vine', 'fa-codepen' => 'fa-codepen', 'fa-jsfiddle' => 'fa-jsfiddle', 'fa-life-ring' => 'fa-life-ring', 'fa-circle-o-notch' => 'fa-circle-o-notch', 'fa-rebel' => 'fa-rebel', 'fa-empire' => 'fa-empire', 'fa-git-square' => 'fa-git-square', 'fa-git' => 'fa-git', 'fa-hacker-news' => 'fa-hacker-news', 'fa-tencent-weibo' => 'fa-tencent-weibo', 'fa-qq' => 'fa-qq', 'fa-weixin' => 'fa-weixin', 'fa-paper-plane' => 'fa-paper-plane', 'fa-paper-plane-o' => 'fa-paper-plane-o', 'fa-history' => 'fa-history', 'fa-circle-thin' => 'fa-circle-thin', 'fa-header' => 'fa-header', 'fa-paragraph' => 'fa-paragraph', 'fa-sliders' => 'fa-sliders', 'fa-share-alt' => 'fa-share-alt', 'fa-share-alt-square' => 'fa-share-alt-square', 'fa-bomb' => 'fa-bomb', 'fa-futbol-o' => 'fa-futbol-o', 'fa-tty' => 'fa-tty', 'fa-binoculars' => 'fa-binoculars', 'fa-plug' => 'fa-plug', 'fa-slideshare' => 'fa-slideshare', 'fa-twitch' => 'fa-twitch', 'fa-yelp' => 'fa-yelp', 'fa-newspaper-o' => 'fa-newspaper-o', 'fa-wifi' => 'fa-wifi', 'fa-calculator' => 'fa-calculator', 'fa-paypal' => 'fa-paypal', 'fa-google-wallet' => 'fa-google-wallet', 'fa-cc-visa' => 'fa-cc-visa', 'fa-cc-mastercard' => 'fa-cc-mastercard', 'fa-cc-discover' => 'fa-cc-discover', 'fa-cc-amex' => 'fa-cc-amex', 'fa-cc-paypal' => 'fa-cc-paypal', 'fa-cc-stripe' => 'fa-cc-stripe', 'fa-bell-slash' => 'fa-bell-slash', 'fa-bell-slash-o' => 'fa-bell-slash-o', 'fa-trash' => 'fa-trash', 'fa-copyright' => 'fa-copyright', 'fa-at' => 'fa-at', 'fa-eyedropper' => 'fa-eyedropper', 'fa-paint-brush' => 'fa-paint-brush', 'fa-birthday-cake' => 'fa-birthday-cake', 'fa-area-chart' => 'fa-area-chart', 'fa-pie-chart' => 'fa-pie-chart', 'fa-line-chart' => 'fa-line-chart', 'fa-lastfm' => 'fa-lastfm', 'fa-lastfm-square' => 'fa-lastfm-square', 'fa-toggle-off' => 'fa-toggle-off', 'fa-toggle-on' => 'fa-toggle-on', 'fa-bicycle' => 'fa-bicycle', 'fa-bus' => 'fa-bus', 'fa-ioxhost' => 'fa-ioxhost', 'fa-angellist' => 'fa-angellist', 'fa-cc' => 'fa-cc', 'fa-ils' => 'fa-ils', 'fa-meanpath' => 'fa-meanpath', 'fa-buysellads' => 'fa-buysellads', 'fa-connectdevelop' => 'fa-connectdevelop', 'fa-dashcube' => 'fa-dashcube', 'fa-forumbee' => 'fa-forumbee', 'fa-leanpub' => 'fa-leanpub', 'fa-sellsy' => 'fa-sellsy', 'fa-shirtsinbulk' => 'fa-shirtsinbulk', 'fa-simplybuilt' => 'fa-simplybuilt', 'fa-skyatlas' => 'fa-skyatlas', 'fa-cart-plus' => 'fa-cart-plus', 'fa-cart-arrow-down' => 'fa-cart-arrow-down', 'fa-diamond' => 'fa-diamond', 'fa-ship' => 'fa-ship', 'fa-user-secret' => 'fa-user-secret', 'fa-motorcycle' => 'fa-motorcycle', 'fa-street-view' => 'fa-street-view', 'fa-heartbeat' => 'fa-heartbeat', 'fa-venus' => 'fa-venus', 'fa-mars' => 'fa-mars', 'fa-mercury' => 'fa-mercury', 'fa-transgender' => 'fa-transgender', 'fa-transgender-alt' => 'fa-transgender-alt', 'fa-venus-double' => 'fa-venus-double', 'fa-mars-double' => 'fa-mars-double', 'fa-venus-mars' => 'fa-venus-mars', 'fa-mars-stroke' => 'fa-mars-stroke', 'fa-mars-stroke-v' => 'fa-mars-stroke-v', 'fa-mars-stroke-h' => 'fa-mars-stroke-h', 'fa-neuter' => 'fa-neuter', 'fa-genderless' => 'fa-genderless', 'fa-facebook-official' => 'fa-facebook-official', 'fa-pinterest-p' => 'fa-pinterest-p', 'fa-whatsapp' => 'fa-whatsapp', 'fa-server' => 'fa-server', 'fa-user-plus' => 'fa-user-plus', 'fa-user-times' => 'fa-user-times', 'fa-bed' => 'fa-bed', 'fa-viacoin' => 'fa-viacoin', 'fa-train' => 'fa-train', 'fa-subway' => 'fa-subway', 'fa-medium' => 'fa-medium', 'fa-y-combinator' => 'fa-y-combinator', 'fa-optin-monster' => 'fa-optin-monster', 'fa-opencart' => 'fa-opencart', 'fa-expeditedssl' => 'fa-expeditedssl', 'fa-battery-full' => 'fa-battery-full', 'fa-battery-three-quarters' => 'fa-battery-three-quarters', 'fa-battery-half' => 'fa-battery-half', 'fa-battery-quarter' => 'fa-battery-quarter', 'fa-battery-empty' => 'fa-battery-empty', 'fa-mouse-pointer' => 'fa-mouse-pointer', 'fa-i-cursor' => 'fa-i-cursor', 'fa-object-group' => 'fa-object-group', 'fa-object-ungroup' => 'fa-object-ungroup', 'fa-sticky-note' => 'fa-sticky-note', 'fa-sticky-note-o' => 'fa-sticky-note-o', 'fa-cc-jcb' => 'fa-cc-jcb', 'fa-cc-diners-club' => 'fa-cc-diners-club', 'fa-clone' => 'fa-clone', 'fa-balance-scale' => 'fa-balance-scale', 'fa-hourglass-o' => 'fa-hourglass-o', 'fa-hourglass-start' => 'fa-hourglass-start', 'fa-hourglass-half' => 'fa-hourglass-half', 'fa-hourglass-end' => 'fa-hourglass-end', 'fa-hourglass' => 'fa-hourglass', 'fa-hand-rock-o' => 'fa-hand-rock-o', 'fa-hand-paper-o' => 'fa-hand-paper-o', 'fa-hand-scissors-o' => 'fa-hand-scissors-o', 'fa-hand-lizard-o' => 'fa-hand-lizard-o', 'fa-hand-spock-o' => 'fa-hand-spock-o', 'fa-hand-pointer-o' => 'fa-hand-pointer-o', 'fa-hand-peace-o' => 'fa-hand-peace-o', 'fa-trademark' => 'fa-trademark', 'fa-registered' => 'fa-registered', 'fa-creative-commons' => 'fa-creative-commons', 'fa-gg' => 'fa-gg', 'fa-gg-circle' => 'fa-gg-circle', 'fa-tripadvisor' => 'fa-tripadvisor', 'fa-odnoklassniki' => 'fa-odnoklassniki', 'fa-odnoklassniki-square' => 'fa-odnoklassniki-square', 'fa-get-pocket' => 'fa-get-pocket', 'fa-wikipedia-w' => 'fa-wikipedia-w', 'fa-safari' => 'fa-safari', 'fa-chrome' => 'fa-chrome', 'fa-firefox' => 'fa-firefox', 'fa-opera' => 'fa-opera', 'fa-internet-explorer' => 'fa-internet-explorer', 'fa-television' => 'fa-television', 'fa-contao' => 'fa-contao', 'fa-500px' => 'fa-500px', 'fa-amazon' => 'fa-amazon', 'fa-calendar-plus-o' => 'fa-calendar-plus-o', 'fa-calendar-minus-o' => 'fa-calendar-minus-o', 'fa-calendar-times-o' => 'fa-calendar-times-o', 'fa-calendar-check-o' => 'fa-calendar-check-o', 'fa-industry' => 'fa-industry', 'fa-map-pin' => 'fa-map-pin', 'fa-map-signs' => 'fa-map-signs', 'fa-map-o' => 'fa-map-o', 'fa-map' => 'fa-map', 'fa-commenting' => 'fa-commenting', 'fa-commenting-o' => 'fa-commenting-o', 'fa-houzz' => 'fa-houzz', 'fa-vimeo' => 'fa-vimeo', 'fa-black-tie' => 'fa-black-tie', 'fa-fonticons' => 'fa-fonticons', 'fa-reddit-alien' => 'fa-reddit-alien', 'fa-edge' => 'fa-edge', 'fa-credit-card-alt' => 'fa-credit-card-alt', 'fa-codiepie' => 'fa-codiepie', 'fa-modx' => 'fa-modx', 'fa-fort-awesome' => 'fa-fort-awesome', 'fa-usb' => 'fa-usb', 'fa-product-hunt' => 'fa-product-hunt', 'fa-mixcloud' => 'fa-mixcloud', 'fa-scribd' => 'fa-scribd', 'fa-pause-circle' => 'fa-pause-circle', 'fa-pause-circle-o' => 'fa-pause-circle-o', 'fa-stop-circle' => 'fa-stop-circle', 'fa-stop-circle-o' => 'fa-stop-circle-o', 'fa-shopping-bag' => 'fa-shopping-bag', 'fa-shopping-basket' => 'fa-shopping-basket', 'fa-hashtag' => 'fa-hashtag', 'fa-bluetooth' => 'fa-bluetooth', 'fa-bluetooth-b' => 'fa-bluetooth-b', 'fa-percent' => 'fa-percent', 'fa-gitlab' => 'fa-gitlab', 'fa-wpbeginner' => 'fa-wpbeginner', 'fa-wpforms' => 'fa-wpforms', 'fa-envira' => 'fa-envira', 'fa-universal-access' => 'fa-universal-access', 'fa-wheelchair-alt' => 'fa-wheelchair-alt', 'fa-question-circle-o' => 'fa-question-circle-o', 'fa-blind' => 'fa-blind', 'fa-audio-description' => 'fa-audio-description', 'fa-volume-control-phone' => 'fa-volume-control-phone', 'fa-braille' => 'fa-braille', 'fa-assistive-listening-systems' => 'fa-assistive-listening-systems', 'fa-american-sign-language-interpreting' => 'fa-american-sign-language-interpreting', 'fa-deaf' => 'fa-deaf', 'fa-glide' => 'fa-glide', 'fa-glide-g' => 'fa-glide-g', 'fa-sign-language' => 'fa-sign-language', 'fa-low-vision' => 'fa-low-vision', 'fa-viadeo' => 'fa-viadeo', 'fa-viadeo-square' => 'fa-viadeo-square', 'fa-snapchat' => 'fa-snapchat', 'fa-snapchat-ghost' => 'fa-snapchat-ghost', 'fa-snapchat-square' => 'fa-snapchat-square', 'fa-pied-piper' => 'fa-pied-piper', 'fa-first-order' => 'fa-first-order', 'fa-yoast' => 'fa-yoast', 'fa-themeisle' => 'fa-themeisle', 'fa-google-plus-official' => 'fa-google-plus-official', 'fa-font-awesome' => 'fa-font-awesome'
	);
  return $icons;
}

/* Display Post Bottom Elements */
function thb_PostMeta($author = false, $time = false, $shares = false, $comment = false,  $views = false) {
	if (ot_get_option('thb_logo')) { $logo = ot_get_option('thb_logo'); } else { $logo = THB_THEME_ROOT. '/assets/img/logo.png'; }
	$post_meta = ot_get_option('post_meta') ? ot_get_option('post_meta') : array();
	?>
	<aside class="post-bottom-meta">
		<strong rel="author" itemprop="author" class="<?php if (!$author || in_array('author', $post_meta)) { ?>hide<?php }?>"><?php the_author_posts_link(); ?></strong>
		<time class="time<?php if (!$time || in_array('post-date', $post_meta)) { ?> hide<?php }?>" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished" content="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo thb_human_time_diff_enhanced(); ?></time>
		<meta itemprop="dateModified" content="<?php the_modified_date('c'); ?>">
		<span class="hide" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
			<meta itemprop="name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
			<span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
				<meta itemprop="url" content="<?php echo esc_url($logo); ?>">
			</span>
			
		</span>
		<meta itemscope itemprop="mainEntityOfPage" itemtype="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>">
		<?php if ($shares && !in_array('shares', $post_meta)) { ?>
		<span class="shares"><svg version="1.1" class="share_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			 width="16.156px" height="9.113px" viewBox="0 0 16.156 9.113" enable-background="new 0 0 16.156 9.113" xml:space="preserve">
				<path d="M10.388,1.813c1.2,0.771,2.867,1.845,3.987,2.57c-1.113,0.777-2.785,1.938-3.984,2.761
					c-0.002-0.234-0.004-0.476-0.005-0.709l-0.005-0.827L9.568,5.458L9.293,5.407C8.837,5.318,8.351,5.272,7.85,5.272
					c-0.915,0-1.912,0.15-2.964,0.446C4.027,5.962,3.136,6.306,2.24,6.74c0.914-1.09,2.095-1.995,3.369-2.576
					c1.039-0.475,2.145-0.739,3.379-0.81l0.453-0.025l0.941-0.053l0.003-0.943C10.387,2.162,10.387,1.986,10.388,1.813 M9.402,0
					c-0.01,0-0.017,2.33-0.017,2.33L8.933,2.355C7.576,2.433,6.346,2.728,5.193,3.254C3.629,3.968,2.19,5.125,1.146,6.509
					C0.558,7.289-0.099,9.006,0.242,9.006c0.033,0,0.076-0.017,0.129-0.052c1.595-1.053,3.248-1.838,4.787-2.273
					C6.124,6.41,7.023,6.273,7.85,6.273c0.438,0,0.856,0.038,1.251,0.115l0.284,0.053c0,0,0.016,2.555,0.037,2.555
					c0.092,0,6.733-4.626,6.733-4.644C16.156,4.336,9.434,0,9.402,0L9.402,0z"/>
		</svg><?php echo thb_social_article_totalshares(get_the_ID()); ?></span>
		<?php } ?>
		<?php if ($comment && !in_array('comments', $post_meta)) { ?>
		<span class="comment">
			<a href="<?php comments_link(); ?>" title="<?php the_title_attribute(); ?>">
				<svg version="1.1" class="comment_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			 width="12px" height="13px" viewBox="0 0 12 13" enable-background="new 0 0 12 13" xml:space="preserve">
					<path d="M11.531,0H0.424c-0.23,0-0.419,0.183-0.419,0.407L0.002,8.675c0,0.402-0.097,1.17,1,1.17H3.99v2.367
						c0,0.162,0.057,0.393,0.043,0.752c0.063,0.039,0.105,0.039,0.168,0.039c0.105,0,0.21-0.039,0.294-0.123L7.18,9.845h3.975
						c0.231,0,0.798-0.092,0.798-0.791l-0.002-8.647C11.951,0.183,11.761,0,11.531,0z M11.155,9.054H7.18
						c-0.104,0-0.315,0.119-0.399,0.199l-2.16,2.367V9.75c0-0.225,0.02-0.695-0.631-0.695H0.8l0.044-8.241h10.267L11.155,9.054z"/>
			</svg> <?php echo get_comments_number(); ?>
			</a>
		</span>
		<?php } ?>
		<?php if ($views && function_exists( 'stats_get_csv' ) && !in_array('views', $post_meta)) { ?>
			<?php
				echo '<span class="views"><i class="fa fa-eye"></i> ';  
				do_action( 'thb_post_viewcount'); 
				echo ' <em>' . esc_html__('views', 'goodlife').'</em></span>';
			?>
		<?php } ?>
	</aside>
	<?php
}
add_action( 'thb_PostMeta', 'thb_PostMeta', 10, 5 );

/* Add Lightbox Class */

function thb_image_rel($content) {	
	$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
	  	$replacement = '<a$1href=$2$3.$4$5 rel="mfp"$6>';
  $content = preg_replace($pattern, $replacement, $content);
  return $content;
}
add_filter('the_content', 'thb_image_rel');

// Custom filter function to modify default gallery shortcode output
add_filter(
  'post_gallery',
  function() {
    add_filter('wp_get_attachment_link', function($content) {
      $pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
      $replacement = '<a$1href=$2$3.$4$5 rel="mfp"$6>$7</a>';
      $content = preg_replace($pattern, $replacement, $content);
      return $content;
    });
  }
);

/* Sibling Categories */
function thb_sibling_categories($current_category = false) {
    $output = '';

    if (!empty($current_category->cat_ID)) {


			// child categories
      $categories = get_categories( array(
        'parent'     => $current_category->cat_ID
      ) );

      
      if (empty($categories)) {
      	// siblings categories
        $categories = get_categories(array(
	        'parent'        => $current_category->parent
        ));
      }
    }

    if (!empty($categories)) {
	    $output .= '<ul class="thb-sibling-categories">';
				foreach ($categories as $category) {
					$output .= '<li><a href="' . get_category_link($category->cat_ID) . '" title="' . $category->name . '">' . $category->name . '</a></li>';
				}
	    $output .= '<li class="thb-pull-down"><a href="#">'.esc_html__('More','goodlife'). '<i class="fa fa-angle-down"></i></a><div class="sub-menu-holder"><ul class="sub-menu"></ul></div></li></ul>';
    }

    echo wp_kses_post($output);
}
add_action( 'thb_Sibling_Categories', 'thb_sibling_categories', 10, 1 );

/* Get Single Category ID */
function thb_getSingleCategory() {
	$selection = get_post_meta(get_the_id(), 'post-primary-category', true);
	
	if (!$selection || $selection === 'auto') { 
	  if ( empty($id)) {
	    $id = '';
	    $categories = get_the_category();
	
	    if ( empty( $categories ) ) return;
	    while ( empty($id) && ! empty($categories) ) {
	      $cat = array_shift($categories);
	      if ( $cat->parent == 0 ) $id = $cat->term_id;
	    }
	  }
	  // if no parent cat found, but a not-parent cat id passed to function use that
	  if ( ! (int) $id && isset($backup) ) $id = $backup;
	  if ( ! (int) $id ) return;
	} else {
		$id = $selection;
	}
  return $id;
}
function thb_fb_information() {
	$sharing_type = ot_get_option('sharing_buttons') ? ot_get_option('sharing_buttons') : array();
	$general_disable_og_tags = ot_get_option('general_disable_og_tags');
	
	if ($general_disable_og_tags !== 'on') {
		if (in_array('facebook',$sharing_type) && is_single()) {
				$image_id = get_post_thumbnail_id();
		    $image_link = wp_get_attachment_image_src($image_id, 'full');
			?>
			<?php if ($fb_app_id = ot_get_option('facebook_app_id')) { ?>
			<meta property="fb:app_id" content="<?php echo esc_attr($fb_app_id); ?>" /> 
			<?php } ?>
			<meta property="og:title" content="<?php the_title_attribute(); ?>" />
			<meta property="og:type" content="article" />
			<meta property="og:description" content="<?php echo esc_html(thb_excerpt(200, false, false)); ?>" />
			<meta property="og:image" content="<?php echo $image_link[0]; ?>" />
			<meta property="og:url" content="<?php the_permalink(); ?>" />
			<?php
		}
	}
}
add_action( 'wp_head', 'thb_fb_information',3 );

/* Display Single Category */
function thb_DisplaySingleCategory($boxed = true, $id = false) {
	$selection = get_post_meta(get_the_id(), 'post-primary-category', true);
	
	if (!$selection || $selection === 'auto') { 
	  if ( (int) $id ) {
	    $cat = get_category($id);
	    if ( ! empty($cat) ) {
	       $backup = $cat->term_id;
	       if ( $cat->parent == 0 ) $id = $cat->term_id;
	    }
	  }
	  if ( empty($id)) {
	    $id = '';
	    $categories = get_the_category();
	
	    if ( empty( $categories ) ) return;
	    while ( empty($id) && ! empty($categories) ) {
	      $cat = array_shift($categories);
	      if ( $cat->parent == 0 ) $id = $cat->term_id;
	    }
	  }
	  // if no parent cat found, but a not-parent cat id passed to function use that
	  if ( ! (int) $id && isset($backup) ) $id = $backup;
	  if ( ! (int) $id ) return;
	} else {
		$id = $selection;
	}
  $name = get_cat_name($id);
  $url = esc_url( get_category_link($id) );
  $class = $boxed ? ' class="single_category_title boxed-link category-boxed-link-'.$id.'"' : ' class="single_category_title category-link-'.$id.'"';
  $frmt = '<a href="%s"%s title="%s">%s</a>';
  echo sprintf( $frmt, $url, $class, esc_attr($name), esc_html($name) );
}
add_action( 'thb_DisplaySingleCategory', 'thb_DisplaySingleCategory',3 );

/* Get Category Color */
function thb_GetCategoryColor($id) {
	$color = ot_get_option('category_colors_'. $id, '#666');
	return $color;
}
/* Blockquote Shortcode */
function thb_blockquote( $atts, $content = null ) {
    extract(shortcode_atts(array(
       	'pull'      => '',
       	'author'    => ''
    ), $atts));
	$authorhtml = '';
	if ($author) {
		$authorhtml = '<cite>'. $author. '</cite>';
	}
	$out = '<blockquote class="styled '.$pull.'"><p>' .$content. $authorhtml. '</p></blockquote>';
    return $out;
}
add_shortcode('blockquote', 'thb_blockquote');

/* Thb Header Search */
function thb_quick_search() {
 ?>
	<div class="quick_search">
		<a href="#" class="quick_toggle"></a>
		<svg version="1.1" class="quick_search_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 -1 20 18" xml:space="preserve">
			<path d="M18.96,16.896l-4.973-4.926c1.02-1.255,1.633-2.846,1.633-4.578c0-4.035-3.312-7.317-7.385-7.317S0.849,3.358,0.849,7.393
				c0,4.033,3.313,7.316,7.386,7.316c1.66,0,3.188-0.552,4.422-1.471l4.998,4.95c0.181,0.179,0.416,0.268,0.652,0.268
				c0.235,0,0.472-0.089,0.652-0.268C19.32,17.832,19.32,17.253,18.96,16.896z M2.693,7.393c0-3.027,2.485-5.489,5.542-5.489
				c3.054,0,5.541,2.462,5.541,5.489c0,3.026-2.486,5.489-5.541,5.489C5.179,12.882,2.693,10.419,2.693,7.393z"/>
		</svg>
		<?php get_search_form(); ?>
	</div>
	
<?php
}
add_action( 'thb_quick_search', 'thb_quick_search',3 );

/* Author */
function thb_author($id) {
	$id = $id ? $id : get_the_author_meta( 'ID' );
	if (is_author()) {
		$count = count_user_posts($id);
		$comments = get_comments(array('author__in' => array($id), 'count' => 1));
	}
	?>
	<?php echo get_avatar( $id , '164'); ?>
	<div class="author-content">
		<h5><a href="<?php echo esc_url(get_author_posts_url( $id )); ?>"><?php the_author_meta('display_name', $id ); ?></a></h5>
		<?php if (is_author()) { ?>
			<?php if(get_the_author_meta('position', $id) != '') { ?>
				<h4><?php echo get_the_author_meta('position', $id ); ?></h4>
			<?php } ?>
			<span><?php echo esc_attr($count); ?> <?php _e('Articles', 'goodlife'); ?></span><span><?php echo esc_attr($comments); ?> <?php _e('Comments', 'goodlife'); ?></span>
		<?php } ?>
		<p><?php the_author_meta('description', $id ); ?></p>
		<?php if(get_the_author_meta('url', $id ) != '') { ?>
			<a href="<?php echo esc_url(get_the_author_meta('url', $id )); ?>"><i class="fa fa-link"></i></a>
		<?php } ?>
		<?php if(get_the_author_meta('twitter', $id ) != '') { ?>
			<a href="<?php echo esc_url(get_the_author_meta('twitter', $id )); ?>" class="twitter"><i class="fa fa-twitter"></i></a>
		<?php } ?>
		<?php if(get_the_author_meta('facebook', $id ) != '') { ?>
			<a href="<?php echo esc_url(get_the_author_meta('facebook', $id )); ?>" class="facebook"><i class="fa fa-facebook"></i></a>
		<?php } ?>
		<?php if(get_the_author_meta('googleplus', $id ) != '') { ?>
			<a href="<?php echo esc_url(get_the_author_meta('googleplus', $id )); ?>" class="google-plus"><i class="fa fa-google-plus"></i></a>
		<?php } ?>
	</div>
	<?php
}
add_action( 'thb_author', 'thb_author',3 );

/* Social Icons */
function thb_social_header() {
	
	if (ot_get_option('social_links_style','style1') === 'style1') {
	?>
	<li class="menu-item-has-children">
		<a href="#"><?php _e('Follow Us', 'goodlife'); ?></a>
		<ul class="sub-menu">
			<?php if ($fb = ot_get_option('fb_link_header')) { ?>
			<li><a href="<?php echo esc_url($fb); ?>" class="facebook icon-1x" target="_blank"><i class="fa fa-facebook"></i> <?php _e('Facebook', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($pi = ot_get_option('pinterest_link_header')) { ?>
			<li><a href="<?php echo esc_url($pi); ?>" class="pinterest icon-1x" target="_blank"><i class="fa fa-pinterest"></i> <?php _e('Pinterest', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($tw = ot_get_option('twitter_link_header')) { ?>
			<li><a href="<?php echo esc_url($tw); ?>" class="twitter icon-1x" target="_blank"><i class="fa fa-twitter"></i> <?php _e('Twitter', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($li = ot_get_option('linkedin_link_header')) { ?>
			<li><a href="<?php echo esc_url($li); ?>" class="linkedin icon-1x" target="_blank"><i class="fa fa-linkedin"></i> <?php _e('Linkedin', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($in = ot_get_option('instragram_link_header')) { ?>
			<li><a href="<?php echo esc_url($in); ?>" class="instagram icon-1x" target="_blank"><i class="fa fa-instagram"></i> <?php _e('Instagram', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($xi = ot_get_option('xing_link_header')) { ?>
			<li><a href="<?php echo esc_url($xi); ?>" class="xing icon-1x" target="_blank"><i class="fa fa-xing"></i> <?php _e('Xing', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($tu = ot_get_option('tumblr_link_header')) { ?>
			<li><a href="<?php echo esc_url($tu); ?>" class="tumblr icon-1x" target="_blank"><i class="fa fa-tumblr"></i> <?php _e('Tumblr', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($vk = ot_get_option('vk_link_header')) { ?>
			<li><a href="<?php echo esc_url($vk); ?>" class="vk icon-1x" target="_blank"><i class="fa fa-vk"></i> <?php _e('VKontakte', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($gp = ot_get_option('googleplus_link_header')) { ?>
			<li><a href="<?php echo esc_url($gp); ?>" class="google-plus icon-1x" target="_blank"><i class="fa fa-google-plus"></i> <?php _e('Google Plus', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($sc = ot_get_option('soundcloud_link_header')) { ?>
			<li><a href="<?php echo esc_url($sc); ?>" class="soundcloud icon-1x" target="_blank"><i class="fa fa-soundcloud"></i> <?php _e('Soundcloud', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($dr = ot_get_option('dribbble_link_header')) { ?>
			<li><a href="<?php echo esc_url($dr); ?>" class="dribbble icon-1x" target="_blank"><i class="fa fa-dribbble"></i> <?php _e('Dribbble', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($yt = ot_get_option('youtube_link_header')) { ?>
			<li><a href="<?php echo esc_url($yt); ?>" class="youtube icon-1x" target="_blank"><i class="fa fa-youtube"></i> <?php _e('Youtube', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($sp = ot_get_option('spotify_link_header')) { ?>
			<li><a href="<?php echo esc_url($sp); ?>" class="spotify icon-1x" target="_blank"><i class="fa fa-spotify"></i> <?php _e('Spotify', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($be = ot_get_option('behance_link_header')) { ?>
			<li><a href="<?php echo esc_url($be); ?>" class="behance icon-1x" target="_blank"><i class="fa fa-behance"></i> <?php _e('Behance', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($da = ot_get_option('deviantart_link_header')) { ?>
			<li><a href="<?php echo esc_url($da); ?>" class="deviantart icon-1x" target="_blank"><i class="fa fa-deviantart"></i> <?php _e('Deviantart', 'goodlife'); ?></a></li>
			<?php } ?>
			<?php if ($rss = ot_get_option('rss_link_header')) { ?>
			<li><a href="<?php echo esc_url($rss); ?>" class="rss icon-1x" target="_blank"><i class="fa fa-rss"></i> <?php _e('RSS', 'goodlife'); ?></a></li>
			<?php } ?>
		</ul>
	</li>
	<?php
	} else {
		?>
	<li class="social_links_style2">
		<?php if ($fb = ot_get_option('fb_link_header')) { ?>
		<a href="<?php echo esc_url($fb); ?>" class="facebook icon-1x" target="_blank"><i class="fa fa-facebook"></i></a>
		<?php } ?>
		<?php if ($pi = ot_get_option('pinterest_link_header')) { ?>
		<a href="<?php echo esc_url($pi); ?>" class="pinterest icon-1x" target="_blank"><i class="fa fa-pinterest"></i></a>
		<?php } ?>
		<?php if ($tw = ot_get_option('twitter_link_header')) { ?>
		<a href="<?php echo esc_url($tw); ?>" class="twitter icon-1x" target="_blank"><i class="fa fa-twitter"></i></a>
		<?php } ?>
		<?php if ($li = ot_get_option('linkedin_link_header')) { ?>
		<a href="<?php echo esc_url($li); ?>" class="linkedin icon-1x" target="_blank"><i class="fa fa-linkedin"></i></a>
		<?php } ?>
		<?php if ($in = ot_get_option('instragram_link_header')) { ?>
		<a href="<?php echo esc_url($in); ?>" class="instagram icon-1x" target="_blank"><i class="fa fa-instagram"></i></a>
		<?php } ?>
		<?php if ($xi = ot_get_option('xing_link_header')) { ?>
		<a href="<?php echo esc_url($xi); ?>" class="xing icon-1x" target="_blank"><i class="fa fa-xing"></i></a>
		<?php } ?>
		<?php if ($tu = ot_get_option('tumblr_link_header')) { ?>
		<a href="<?php echo esc_url($tu); ?>" class="tumblr icon-1x" target="_blank"><i class="fa fa-tumblr"></i></a>
		<?php } ?>
		<?php if ($vk = ot_get_option('vk_link_header')) { ?>
		<a href="<?php echo esc_url($vk); ?>" class="vk icon-1x" target="_blank"><i class="fa fa-vk"></i></a>
		<?php } ?>
		<?php if ($gp = ot_get_option('googleplus_link_header')) { ?>
		<a href="<?php echo esc_url($gp); ?>" class="google-plus icon-1x" target="_blank"><i class="fa fa-google-plus"></i></a>
		<?php } ?>
		<?php if ($sc = ot_get_option('soundcloud_link_header')) { ?>
		<a href="<?php echo esc_url($sc); ?>" class="soundcloud icon-1x" target="_blank"><i class="fa fa-soundcloud"></i></a>
		<?php } ?>
		<?php if ($dr = ot_get_option('dribbble_link_header')) { ?>
		<a href="<?php echo esc_url($dr); ?>" class="dribbble icon-1x" target="_blank"><i class="fa fa-dribbble"></i></a>
		<?php } ?>
		<?php if ($yt = ot_get_option('youtube_link_header')) { ?>
		<a href="<?php echo esc_url($yt); ?>" class="youtube icon-1x" target="_blank"><i class="fa fa-youtube"></i></a>
		<?php } ?>
		<?php if ($sp = ot_get_option('spotify_link_header')) { ?>
		<a href="<?php echo esc_url($sp); ?>" class="spotify icon-1x" target="_blank"><i class="fa fa-spotify"></i></a>
		<?php } ?>
		<?php if ($be = ot_get_option('behance_link_header')) { ?>
		<a href="<?php echo esc_url($be); ?>" class="behance icon-1x" target="_blank"><i class="fa fa-behance"></i></a>
		<?php } ?>
		<?php if ($da = ot_get_option('deviantart_link_header')) { ?>
		<a href="<?php echo esc_url($da); ?>" class="deviantart icon-1x" target="_blank"><i class="fa fa-deviantart"></i></a>
		<?php } ?>
		<?php if ($rss = ot_get_option('rss_link_header')) { ?>
		<a href="<?php echo esc_url($rss); ?>" class="rss icon-1x" target="_blank"><i class="fa fa-rss"></i></a>
		<?php } ?>
	</li>
		<?php	
	}
}
add_action( 'thb_social_header', 'thb_social_header',3 );

/* Social Icons */
function thb_social_header_mobile() {
	?>
	<?php if ($fb = ot_get_option('fb_link_header')) { ?>
	<a href="<?php echo esc_url($fb); ?>" class="facebook icon-1x" target="_blank"><i class="fa fa-facebook"></i></a>
	<?php } ?>
	<?php if ($pi = ot_get_option('pinterest_link_header')) { ?>
	<a href="<?php echo esc_url($pi); ?>" class="pinterest icon-1x" target="_blank"><i class="fa fa-pinterest"></i></a>
	<?php } ?>
	<?php if ($tw = ot_get_option('twitter_link_header')) { ?>
	<a href="<?php echo esc_url($tw); ?>" class="twitter icon-1x" target="_blank"><i class="fa fa-twitter"></i></a>
	<?php } ?>
	<?php if ($li = ot_get_option('linkedin_link_header')) { ?>
	<a href="<?php echo esc_url($li); ?>" class="linkedin icon-1x" target="_blank"><i class="fa fa-linkedin"></i></a>
	<?php } ?>
	<?php if ($in = ot_get_option('instragram_link_header')) { ?>
	<a href="<?php echo esc_url($in); ?>" class="instagram icon-1x" target="_blank"><i class="fa fa-instagram"></i></a>
	<?php } ?>
	<?php if ($xi = ot_get_option('xing_link_header')) { ?>
	<a href="<?php echo esc_url($xi); ?>" class="xing icon-1x" target="_blank"><i class="fa fa-xing"></i></a>
	<?php } ?>
	<?php if ($tu = ot_get_option('tumblr_link_header')) { ?>
	<a href="<?php echo esc_url($tu); ?>" class="tumblr icon-1x" target="_blank"><i class="fa fa-tumblr"></i></a>
	<?php } ?>
	<?php if ($vk = ot_get_option('vk_link_header')) { ?>
	<a href="<?php echo esc_url($vk); ?>" class="vk icon-1x" target="_blank"><i class="fa fa-vk"></i></a>
	<?php } ?>
	<?php if ($gp = ot_get_option('googleplus_link_header')) { ?>
	<a href="<?php echo esc_url($gp); ?>" class="google-plus icon-1x" target="_blank"><i class="fa fa-google-plus"></i></a>
	<?php } ?>
	<?php if ($sc = ot_get_option('soundcloud_link_header')) { ?>
	<a href="<?php echo esc_url($sc); ?>" class="soundcloud icon-1x" target="_blank"><i class="fa fa-soundcloud"></i></a>
	<?php } ?>
	<?php if ($dr = ot_get_option('dribbble_link_header')) { ?>
	<a href="<?php echo esc_url($dr); ?>" class="dribbble icon-1x" target="_blank"><i class="fa fa-dribbble"></i></a>
	<?php } ?>
	<?php if ($yt = ot_get_option('youtube_link_header')) { ?>
	<a href="<?php echo esc_url($yt); ?>" class="youtube icon-1x" target="_blank"><i class="fa fa-youtube"></i></a>
	<?php } ?>
	<?php if ($sp = ot_get_option('spotify_link_header')) { ?>
	<a href="<?php echo esc_url($sp); ?>" class="spotify icon-1x" target="_blank"><i class="fa fa-spotify"></i></a>
	<?php } ?>
	<?php if ($be = ot_get_option('behance_link_header')) { ?>
	<a href="<?php echo esc_url($be); ?>" class="behance icon-1x" target="_blank"><i class="fa fa-behance"></i></a>
	<?php } ?>
	<?php if ($da = ot_get_option('deviantart_link_header')) { ?>
	<a href="<?php echo esc_url($da); ?>" class="deviantart icon-1x" target="_blank"><i class="fa fa-deviantart"></i></a>
	<?php } ?>
	<?php if ($rss = ot_get_option('rss_link_header')) { ?>
	<a href="<?php echo esc_url($rss); ?>" class="rss icon-1x" target="_blank"><i class="fa fa-rss"></i></a>
	<?php } ?>
	<?php
}
add_action( 'thb_social_header_mobile', 'thb_social_header_mobile',3 );

/* Mobile Menu */
function thb_mobile_menu() {
	?>
		<nav id="mobile-menu">
			<div class="custom_scroll" id="menu-scroll">
				<div>
					<?php if(has_nav_menu('mobile-menu')) { ?>
					  <?php wp_nav_menu( array( 'theme_location' => 'mobile-menu', 'depth' => 3, 'container' => false, 'menu_class' => 'mobile-menu', 'walker' => new thb_mobileDropdown ) ); ?>
					<?php } else { ?>
						<ul class="mobile-menu">
							<li><a href="<?php echo get_admin_url().'nav-menus.php'; ?>"><?php esc_html_e( 'Please assign a menu', 'goodlife' ); ?></a></a></li>
						</ul>
					<?php } ?>
					<?php if (has_nav_menu('secondary-menu')) { ?>
						<?php wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'depth' => 2, 'container' => false, 'menu_class' => 'mobile-menu secondary'  ) ); ?>
					<?php } ?>
					<div class="social-links">
						<?php do_action( 'thb_social_header_mobile' ); ?>
					</div>
					<div class="menu-footer">
						<?php echo do_shortcode(ot_get_option('menu_footer')); ?>
					</div>
				</div>
			</div>
		</nav>
	<?php
}
add_action( 'thb_mobile_menu', 'thb_mobile_menu',3 );

/* Post Categories Array */
function thb_blogCategories(){
	$blog_categories = get_categories();
	$out = array();
	foreach($blog_categories as $category) {
		$out[$category->name] = $category->cat_ID;
	}
	return $out;
}

function thb_post_nav() {
		$article_prevnext_samecat = ot_get_option('article_prevnext_samecat', 'off') == 'off' ? false: true;
		$prev_post = get_adjacent_post($article_prevnext_samecat, '', true);
		
		?>
			<div class="row post-navi hide-on-print no-padding" data-equal=">.columns">
				<div class="small-12 medium-6 columns">
					<?php
					if(!empty($prev_post)) {
						$excerpt = $prev_post->post_content;
						$previd = $prev_post->ID;
						
						echo '<span>'.esc_html__('Previous Article', 'goodlife').'</span><a href="' . get_permalink($previd) . '" title="' . $prev_post->post_title . '">' . $prev_post->post_title. '</a>'; 
					} else {
						echo '<span>'.esc_html__('No Older Articles', 'goodlife').'</span>';
					}
				?>
				</div>
				<div class="small-12 medium-6 columns">
					<?php
						$next_post = get_adjacent_post($article_prevnext_samecat, '', false);
						
						if(!empty($next_post)) {
							$excerptnext = $next_post->post_content;
							$nextid = $next_post->ID;
							
							echo '<span>'.esc_html__('Next Article', 'goodlife').'</span><a href="' . get_permalink($nextid) . '" title="' . $next_post->post_title . '">' . $next_post->post_title . '</a>'; 
						} else {
							echo '<span>'.esc_html__('No Newer Articles', 'goodlife').'</span>';
						}
					?>
				</div>
			</div>
		<?php
}
add_action( 'thb_post_nav', 'thb_post_nav',3 );

/* Human time */
function thb_human_time_diff_enhanced( $duration = 60 ) {

	$post_time = get_the_time('U');
	$human_time = '';

	$time_now = date('U');

	// use human time if less that $duration days ago (60 days by default)
	// 60 seconds * 60 minutes * 24 hours * $duration days
	if ( $post_time > $time_now - ( 60 * 60 * 24 * $duration ) ) {
		$human_time = sprintf( esc_html__( '%s ago', 'goodlife'), human_time_diff( $post_time, current_time( 'timestamp' ) ) );
	} else {
		$human_time = get_the_date();
	}

	if (ot_get_option('relative_dates', 'on') == 'off') {
		return get_the_date();
	} else {
		return $human_time;
	}

}
// Do Shortcodes inside widgets
add_filter('widget_text', 'do_shortcode');

/**
 * Shorten large numbers into abbreviations (i.e. 1,500 = 1.5k)
 *
 * @param int    $number  Number to shorten
 * @return String   A number with a symbol
 */ 
function thb_numberAbbreviation($number) {
    $abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");

	if ($number > 999) {
	    foreach($abbrevs as $exponent => $abbrev) {
	        if($number >= pow(10, $exponent)) {
	        	$display_num = $number / pow(10, $exponent);
	        	$decimals = ($exponent >= 3 && round($display_num) < 100) ? 1 : 0;
	            return number_format($display_num,$decimals) . $abbrev;
	        }
	    }
	} else {
		return $number;	
	}
}

// thb Tag Cloud Size
function thb_tag_cloud_filter($args = array()) {
   $args['smallest'] = 10;
   $args['largest'] = 10;
   $args['unit'] = 'px';
   $args['format']= 'list';
   return $args;
}

add_filter('widget_tag_cloud_args', 'thb_tag_cloud_filter', 90);

function thb_dns_prefetch() {
	echo '
	<meta http-equiv="x-dns-prefetch-control" content="on">
	<link rel="dns-prefetch" href="//fonts.googleapis.com" />
	<link rel="dns-prefetch" href="//fonts.gstatic.com" />
	<link rel="dns-prefetch" href="//0.gravatar.com/" />
	<link rel="dns-prefetch" href="//2.gravatar.com/" />
	<link rel="dns-prefetch" href="//1.gravatar.com/" />
	';
}
add_action('wp_head', 'thb_dns_prefetch', 0);

// Get Term Meta
if(!function_exists('get_term_meta')) {
	function get_term_meta( $term_id, $key = '', $single = false ) {
		// Bail if term meta table is not installed.
		if ( get_option( 'db_version' ) < 34370 ) {
			return false;
		}
		return get_metadata( 'term', $term_id, $key, $single );
	}
}
if(!function_exists('get_term_meta')) {
	function update_term_meta( $term_id, $meta_key, $meta_value, $prev_value = '' ) {
		// Bail if term meta table is not installed.
		if ( get_option( 'db_version' ) < 34370 ) {
			return false;
		}
		if ( wp_term_is_shared( $term_id ) ) {
			return new WP_Error( 'ambiguous_term_id', __( 'Term meta cannot be added to terms that are shared between taxonomies.'), $term_id );
		}
		$updated = update_metadata( 'term', $term_id, $meta_key, $meta_value, $prev_value );
		// Bust term query cache.
		if ( $updated ) {
			wp_cache_set( 'last_changed', microtime(), 'terms' );
		}
		return $updated;
	}
}

// Remove src= attribute
function thb_src_attribute( $html, $post_id, $post_image_id ) {
	if (ot_get_option('lazy_load', 'on') == 'on') {
		if (!strpos($html, 'no-lazy-load')) {
	    $html = preg_replace( '/src=/', 'data-original=', $html );
	    $html = preg_replace( '/srcset=/', 'data-original-set=', $html );
		}
	}
  return $html; 
}
add_filter( 'post_thumbnail_html', 'thb_src_attribute', 10, 3 );

// Redirect
function thb_disable_redirect_canonical($redirect_url, $requested_url) {
	if (is_single() || is_page()) { $redirect_url = false; }
	return $redirect_url;
}
add_filter('redirect_canonical','thb_disable_redirect_canonical', 10, 2);


function thb_hide_wp_update_nag() {
    remove_action( 'admin_notices', 'wp_rankie_admin_notice' );
    remove_action( 'admin_notices', 'wpvq_notice_addons_1' );
}
add_action('admin_menu','thb_hide_wp_update_nag');


// VC AJAX Support
function thb_register_vc_shortcodes() {
  if ( class_exists("WPBMap") && method_exists("WPBMap", "addAllMappedShortcodes") ) {
		WPBMap::addAllMappedShortcodes();
  }
}
add_action("thb_vc_ajax", "thb_register_vc_shortcodes", 10);

/*--------------------------------------------------------------------*/                							
/*  ADD DASHBOARD LINK			                							
/*--------------------------------------------------------------------*/
function thb_admin_menu_new_items() {
    global $submenu;
    $submenu['index.php'][500] = array( 'Fuelthemes.net', 'manage_options' , 'http://fuelthemes.net/?ref=wp_sidebar' ); 
}
add_action( 'admin_menu' , 'thb_admin_menu_new_items' );


/*--------------------------------------------------------------------*/         							
/*  FOOTER TYPE EDIT									 					
/*--------------------------------------------------------------------*/
function thb_footer_admin () {  
  return 'Thank you for choosing <a href="http://fuelthemes.net/?ref=wp_footer" target="blank">Fuel Themes</a>.';  
}
add_filter('admin_footer_text', 'thb_footer_admin'); 
?>