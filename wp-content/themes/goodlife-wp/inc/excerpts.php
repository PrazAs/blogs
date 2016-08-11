<?php

function thb_excerpt($excerpt_length, $added = false, $autop = true) {
    $text = wp_strip_all_tags(apply_filters( 'the_excerpt', get_the_excerpt() ));
    $text = strip_shortcodes( $text );
    $text = str_replace('[…]', '', $text );
    $text = str_replace('[&hellip;]', '', $text );
    $text = mb_substr($text,0,$excerpt_length, "utf-8");
    if ($autop) {
    	$text = wpautop($text.$added);
    } else {
    	$text = $text.$added;
    }
    return $text;
}
function thb_ShortenText($text, $chars_limit)
	{
	$text = strip_tags($text);
	$text = strip_shortcodes( $text );
	
	$chars_text = strlen($text);
	$text = $text." ";
	$text = substr($text,0,$chars_limit);
	$text = substr($text,0,strrpos($text,' '));
	
	if ($chars_text > $chars_limit) {
		$text = $text."...";
	}
	$text = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $text);
	$text = apply_filters('the_content', $text);
	return $text;
}
?>