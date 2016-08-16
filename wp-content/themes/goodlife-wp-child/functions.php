<?php

if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

function output_scripts()
{
    the_field('google_analytics_code', 'option');
    the_field('facebook_tracking', 'option');
}
add_action('wp_footer', 'output_scripts');
