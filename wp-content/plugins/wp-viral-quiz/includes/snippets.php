<?php 

/**
 * Export images URLs from $content
 * @param  [type] $content [description]
 * @return [type]          [description]
 */
function export_images_urls($content)
{
    $matches = array();
    preg_match_all('!https?://[^?#]+\.(?:jpe?g|png|gif)!Ui', $content , $matches);
    return (isset($matches[0])) ? $matches[0] : $matches;
}

/**
 * Shuffle() array but with a $seed
 * @param  [type] $array [description]
 * @param  [type] $seed  [description]
 */
function shuffle_seed(&$items, $seed)
{
    @mt_srand($seed);
    for ($i = count($items) - 1; $i > 0; $i--)
    {
        $j = @mt_rand(0, $i);
        $tmp = $items[$i];
        $items[$i] = $items[$j];
        $items[$j] = $tmp;
    }
}

/**
 * Check if a zip archive is valid or not
 * @param  [type] $path [description]
 * @return [type]       [description]
 */
function zipIsValid($path) {
  $zip = zip_open($path);
  if (is_resource($zip)) {
    // it's ok
    zip_close($zip); // always close handle if you were just checking
    return true;
  } else {
    return false;
  }
}

/**
 * media_sideload_image, but returns ID
 * @param  string  $image_url [description]
 * @param  boolean $post_id   [description]
 * @return [type]             [description]
 */
function custom_media_sideload_image( $image_url = '', $post_id = false  ) 
{
    require_once ABSPATH . 'wp-admin/includes/file.php';
    $tmp = download_url( $image_url );

    // Set variables for storage
    // fix file filename for query strings
    preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $image_url, $matches );
    $file_array['name'] = basename($matches[0]);
    $file_array['tmp_name'] = $tmp;

    // If error storing temporarily, unlink
    if ( is_wp_error( $tmp ) ) {
        @unlink($file_array['tmp_name']);
        $file_array['tmp_name'] = '';
    }

    $time = current_time( 'mysql' );
    $file = wp_handle_sideload( $file_array, array('test_form'=>false), $time );
    
    if ( isset($file['error']) ) {
        return new WP_Error( 'upload_error', $file['error'] );
    }

    $url = $file['url'];
    $type = $file['type'];
    $file = $file['file'];
    $title = preg_replace('/\.[^.]+$/', '', basename($file) );
    $parent = (int) absint( $post_id ) > 0 ? absint($post_id) : 0;
    
    $attachment = array(
        'post_mime_type' => $type,
        'guid' => $url,
        'post_parent' => $parent,
        'post_title' => $title,
        'post_content' => '',
    );

    $id = wp_insert_attachment($attachment, $file, $parent);
    if ( !is_wp_error($id) ) {
        require_once ABSPATH . 'wp-admin/includes/image.php'; 
        $data = wp_generate_attachment_metadata( $id, $file );
        wp_update_attachment_metadata( $id, $data );
    }  

    return $id;
}

/**
 * Replace a certain value for a certain key, in a multidimensional array
 */
function array_replace_only_for_key(&$array, $key, $needle, $haystack)
{
    foreach($array as $k => &$elem)
    {
       if(is_array($elem)) {
            array_replace_only_for_key($elem, $key, $needle, $haystack);
        } else {
            if ($k == $key && $elem == $needle) {
                $elem = str_replace($elem, $needle, $haystack);
            }
        }
    }
}

/**
* Get all values from specific key in a multidimensional array
*
* @param $key string
* @param $arr array
* @return null|string|array
*/
function array_value_recursive($key, $arr){
    $val = array();
    array_walk_recursive($arr, function($v, $k) use($key, &$val){
        if($k == $key) array_push($val, $v);
    });
    return count($val) > 1 ? $val : array_pop($val);
}

/**
 * Return the envato licence code
 * @return [type] [description]
 */
function wpvq_get_licence()
{
    $options    =  get_option( 'wpvq_settings' );
    $code       =  (isset($options['wpvq_text_field_envato_code'])) ? $options['wpvq_text_field_envato_code']:'';
    return $code;
}

/**
 * Get the HTML code of a $file in the /view directory
 * @param  [type] $file [description]
 * @return [type]       [description]
 */
function wpvq_get_view($file)
{
    $file = dirname( __FILE__ ) . '/../views/' . $file;
    ob_start();
    include($file);
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}

/**
 * Useful snippets
 */

/**
 * Get information about the picture by using it ID
 * @param  [type] $attachment_id [description]
 * @return [type]                [description]
 */
function wpvq_wp_get_attachment( $attachment_id ) {

    $attachment = get_post( $attachment_id );
    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}


/**
 * Addons snippets
 */

function wpvq_is_addon_active($slug)
{
    return (is_plugin_active($slug . '/' . $slug . '.php'));
}

function wpvq_is_addon_installed($slug)
{
    return (file_exists(WP_PLUGIN_DIR . '/' . $slug . '/' . $slug . '.php'));
}

/**
 * Parse tags for social share sentences
 * @param  [type] $sentence [description]
 * @param  [type] $quiz     [description]
 * @return [type]           [description]
 */
function parse_share_tags_settings($sentence, $quiz)
{
    // same shortcode for user as the one we need on backoffice, so it's useless
    $sentence = str_replace('%%score%%', '%%score%%', $sentence);
    $sentence = str_replace('%%personality%%', '%%personality%%', $sentence);

    // Variables
    $sentence = str_replace('%%total%%', $quiz->countQuestions(), $sentence);
    $sentence = str_replace('%%quizname%%', $quiz->getName(), $sentence);
    $sentence = str_replace('%%quizlink%%', get_permalink(), $sentence);

    return $sentence;
}

/**
 * Slugify a $text
 * @param  [type] $text [description]
 * @return [type]       [description]
 */
function slugify($text, $noTiret=false)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (empty($text)) {
        return 'n-a';
    }

    if ($noTiret) {
        $text = str_replace('-', '', $text);
    }

    return $text;
}

/**
 * Get the full absolute domain (with port, protocol, ...)
 * @uses echo url_origin($_SERVER)
 */
function url_origin($s, $use_forwarded_host=false) {
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}


/**
 * Replace ' by "
 * @param  [type] $string [description]
 * @return [type]         [description]
 */
function wpvq_delete_quotes($string) {
	$string = str_replace("'", "‘", $string);
	$string = str_replace('"', "”", $string);
	return $string; 
}

/**
 * Anonymous-like function, used in usort callback (arg2)
 */
function wpvq_usort_callback_function($a, $b) { 
    return $a->getScoreCondition() < $b->getScoreCondition(); 
}