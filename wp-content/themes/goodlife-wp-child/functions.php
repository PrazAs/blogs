<?php

if (function_exists('acf_add_options_page')) {
    acf_add_options_page('Theme Settings');
    acf_add_options_page('Tracking Settings');
    acf_add_options_page('CTA Settings');
}

function output_scripts()
{
    the_field('google_analytics_code', 'option');
    the_field('facebook_tracking', 'option');
}
add_action('wp_footer', 'output_scripts');


function cta_to_post($content)
{
    if (is_single()) {
        $cta_url = get_field('cta_url');
        $cta_img = get_field('cta_image');
        if ($cta_img) {
            $cta_output = '<a href="' . $cta_url . '"><img src="' . $cta_img . '"></a>';
        }
        $content .= $cta_output;
    }
    return $content;
}
add_filter('the_content', 'cta_to_post');
