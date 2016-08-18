<?php

/*
Plugin Name: What Would Seth Godin Do
Plugin URI: http://richardkmiller.com/wordpress-plugin-what-would-seth-godin-do
Description: Displays a custom welcome message to new visitors and another to return visitors.
Version: 2.0.6
Author: Richard K Miller
Author URI: http://richardkmiller.com/
Text Domain: what-would-seth-godin-do

Copyright (c) 2006-2013 Richard K Miller
Released under the GNU General Public License (GPL)
http://www.gnu.org/licenses/gpl.txt
*/

$wwsgd_settings = wwsgd_initialize_and_get_settings();

add_action('admin_menu', 'wwsgd_options_page');
add_action('wp_footer', 'wwsgd_js');
add_filter('the_content', 'wwsgd_filter_content');
add_action('wp_enqueue_scripts', 'wwsgd_enqueue_scripts');

function wwsgd_initialize_and_get_settings() {
    $defaults = array(
        'new_visitor_message' => "<p style=\"border:thin dotted black; padding:3mm;\">If you're new here, you may want to subscribe to my <a href=\"".get_option("home")."/feed/\">RSS feed</a>. Thanks for visiting!</p>",
        'return_visitor_message' => '',
        'message_location' => 'before_post',
        'include_pages' => 'yes',
        'repetition' => '5',
        'wwsgd_exclude_ids' => '',
        );

    add_option('wwsgd_settings', $defaults, 'Options for What Would Seth Godin Do');
    return get_option('wwsgd_settings');
}

function wwsgd_options_page() {
    if ( function_exists('add_options_page') ) {
        add_options_page('What Would Seth Godin Do', 'WWSGD', 8, basename(__FILE__), 'wwsgd_options_subpanel');
    }
}

function wwsgd_options_subpanel() {
    global $wwsgd_settings;

    if ( isset($_POST['wwsgd_save_settings']) ) {
        check_admin_referer('wwsgd_update_options');
        $wwsgd_settings['new_visitor_message'] = stripslashes($_POST['wwsgd_new_visitor_message']);
        $wwsgd_settings['return_visitor_message'] = stripslashes($_POST['wwsgd_return_visitor_message']);
        $wwsgd_settings['message_location'] = stripslashes($_POST['wwsgd_message_location']);
        $wwsgd_settings['include_pages'] = stripslashes($_POST['wwsgd_message_include_pages']);
        $wwsgd_settings['repetition'] = stripslashes($_POST['wwsgd_repetition']);
        $wwsgd_settings['wwsgd_exclude_ids'] = stripslashes($_POST['wwsgd_exclude_ids']);
        update_option('wwsgd_settings', $wwsgd_settings);
    }
    if (isset($_POST['wwsgd_reset_settings']) ) {
        check_admin_referer('wwsgd_reset_options');
        delete_option('wwsgd_settings');
        $wwsgd_settings = wwsgd_initialize_and_get_settings();
    }
    ?>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div>
        <h2>What Would Seth Godin Do</h2>
        <p>"One opportunity that's underused is the idea of using cookies to treat returning visitors differently than newbies…." - <a href="http://sethgodin.typepad.com/seths_blog/2006/08/in_the_middle_s.html">Seth Godin, August 17, 2006</a></p>

        <form method="post">
            <input type="hidden" name="wwsgd_save_settings" value="true" />
            <?php
                if ( function_exists('wp_nonce_field') ) {
                    wp_nonce_field('wwsgd_update_options');
                }
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="wwsgd_new_visitor_message">Message to New Visitors</label>
                    </th>
                    <td>
                        <textarea rows="3" cols="80" name="wwsgd_new_visitor_message"><?php echo esc_textarea($wwsgd_settings['new_visitor_message']); ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="wwsgd_repetition"># of Repetitions</label>
                    </th>
                    <td>
                        <p>Show the above message the first <input type="text" name="wwsgd_repetition" value="<?php echo esc_attr($wwsgd_settings['repetition']); ?>" size="3" /> times the user visits your blog. Then display the message below.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="wwsgd_return_visitor_message">Message to Return Visitors</label>
                    </th>
                    <td>
                        <textarea rows="3" cols="80" name="wwsgd_return_visitor_message" placeholder="Welcome back!"><?php echo esc_textarea($wwsgd_settings['return_visitor_message']); ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="wwsgd_message_location">Location of Message</label>
                    </th>
                    <td>
                        <input type="radio" name="wwsgd_message_location" value="before_post" <?php if ( $wwsgd_settings['message_location'] == 'before_post' ) echo 'checked="checked"'; ?> /> Before Post
                        <input type="radio" name="wwsgd_message_location" value="after_post" <?php if ($wwsgd_settings['message_location'] == 'after_post' ) echo 'checked="checked"'; ?> /> After Post
                        <input type="radio" name="wwsgd_message_location" value="template_tag_only" <?php if ( $wwsgd_settings['message_location'] == 'template_tag_only' ) echo 'checked="checked"'; ?> /> Only where I use the <code>&lt;?php wwsgd_the_message(); ?&gt;</code>template tag
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="wwsgd_message_include_pages">Show Message on Pages?</label>
                    </th>
                    <td>
                        <input type="radio" name="wwsgd_message_include_pages" value="yes" <?php if ( $wwsgd_settings['include_pages'] == 'yes' ) echo 'checked="checked"'; ?> /> On Posts and Pages
                        <input type="radio" name="wwsgd_message_include_pages" value="no" <?php if ( $wwsgd_settings['include_pages'] == 'no' ) echo 'checked="checked"'; ?> /> On Posts Only
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="wwsgd_exclude_ids">Posts/Pages to Exclude</label>
                    </th>
                    <td>
                        <input type="text" name="wwsgd_exclude_ids" value="<?php echo esc_attr($wwsgd_settings['wwsgd_exclude_ids']); ?>" size="60" placeholder="Post and page IDs separated by commas" />
                    </td>
                </tr>
            </table>
            <p class="submit"><input type="submit" name="submit" value="Save Settings" class="button-primary" /></p>
        </form>

        <h3>Reset Settings</h3>
        <form method="post">
            <input type="hidden" name="wwsgd_reset_settings" value="true" />
            <?php
            if ( function_exists('wp_nonce_field') )
                wp_nonce_field('wwsgd_reset_options');
            ?>
            <input type="submit" name="submit" value="Reset Settings" class="button-primary" />
            This may clear up some issues.
        </form>

        <br/>
        <h3>I &hearts; WWSGD</h3>
        <p>Please <a href="http://wordpress.org/plugins/what-would-seth-godin-do/">rate this plugin</a> on WordPress.org.</p>
        <p>If you love this plugin, please make a small donation to the <a href="http://acumen.org/donate/">Acumen Fund</a>, a charity with which Seth Godin works. In the "Referred by" field, enter "Seth Godin".</p>
        <p>For questions, bug reports, or other feedback about this plugin, please contact <a href="http://richardkmiller.com/contact">Richard K. Miller</a>.</p>

        <br/>
        <h3>Additional Reading</h3>
        <p><a href="http://sethgodin.typepad.com/seths_blog/2008/03/where-do-we-beg.html">Where do we begin?</a> by Seth Godin</p>
        <p><a href="http://fortuito.us/2007/05/how_ads_really_work_superfans_1">How Ads Really Work: Superfans and Noobs</a> by Matthew Haughey</p>

    </div>
    <?php
}

function wwsgd_filter_content($content = '') {
    global $wwsgd_settings;

    static $message_already_displayed = false;

    if ( ! in_the_loop() ) {
        return $content;
    }

    if ( ! is_home() && ! is_front_page() && ! is_single() && ! is_page() ) {
        return $content;
    }

    $excluded_ids = explode(',', str_replace(' ', '', $wwsgd_settings['wwsgd_exclude_ids']));

    $template_tag_only  = ( $wwsgd_settings['message_location'] == 'template_tag_only' );
    $all_pages_excluded = ( is_page() && $wwsgd_settings['include_pages'] == 'no' );
    $this_post_excluded = in_array($GLOBALS['post']->ID, $excluded_ids);

    if ( $template_tag_only || $all_pages_excluded || $this_post_excluded ) {
        return $content;
    }

    if ( $message_already_displayed ) {
        return $content;
    }

    $message_already_displayed = true;

    return ( $wwsgd_settings['message_location'] == 'after_post' ) ? $content.wwsgd_get_the_message() : wwsgd_get_the_message().$content;
}

function wwsgd_get_the_message() {
    global $wwsgd_settings;

    if ( $_COOKIE['wwsgd_visits'] < $wwsgd_settings['repetition'] || 0 == $wwsgd_settings['repetition'] ) {
        return '<div class="wwsgd" style="display:none;">'. $wwsgd_settings['new_visitor_message'] . '</div>';
    }
    else {
        return $wwsgd_settings['return_visitor_message'];
    }
}

function wwsgd_the_message() {
    echo wwsgd_get_the_message();
}

function wwsgd_js() {
    global $wwsgd_settings;
?>
<script type="text/javascript" src="<?php echo plugins_url("jquery.cookie.js", __FILE__); ?>"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        var count;
        if ( !jQuery.cookie('wwsgd_visits') ) {
            count = 1;
        }
        else {
            count = parseInt(jQuery.cookie('wwsgd_visits'), 10) + 1;
        }
        jQuery.cookie('wwsgd_visits', count, { expires: 365, path: "<?php $url=parse_url(get_bloginfo('url')); echo rtrim($url['path'], '/').'/' ?>" });

        if ( count <= <?php echo $wwsgd_settings['repetition'] ?> ) {
            jQuery(".wwsgd").show();
        }
    });
</script>
<?php
}

function wwsgd_enqueue_scripts() {
    wp_enqueue_script('jquery');
}

