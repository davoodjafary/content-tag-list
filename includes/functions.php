<?php
/**
 * Content Tag List Back functions
 *
 *
 *
 * @author  Davood Jafari
 * @package Content Tag List
 * @since   1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_enqueue_scripts', 'ctl_enqueue_style');

// Number Pagination Function
function ctl_pagination_content($current_page, $total_page)
{
    $big = 9999999; // need an unlikely integer
    $args = array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => $current_page,
        'total' => $total_page
    );
    echo paginate_links($args);
}

// Get all posts from DB and search for <a> tag / Result is array of <a> tags
function ctl_get_links_info()
{
    global $wpdb;

    //get list of all posts
    //post_status='publish'
    $post_list_query = $wpdb->get_results(
        "SELECT ID, post_title, post_content, guid
        FROM $wpdb->posts
        WHERE 1
    ");

    $results = array();

    foreach ($post_list_query AS $post) {
        //Get content and search for <a> tag
        $dom = new DOMDocument;
        $html_data = mb_convert_encoding($post->post_content, 'HTML-ENTITIES', 'UTF-8'); // require mb_string
        $dom->loadHTML($html_data);
        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {

            $row = array();
            $row['post_ID'] = $post->ID;
            $row['post_title'] = $post->post_title;
            $row['post_guid'] = $post->guid;

            $row['link_href'] = $link->getAttribute('href');
            $row['link_rel'] = !empty($link->getAttribute('rel')) ? $link->getAttribute('rel') : 'follow';
            $row['link_node'] = $link->nodeValue;

            $results[] = $row;
        }
    }
    return $results;
}

// Call css for plugin
function ctl_enqueue_style()
{
    wp_enqueue_style('admin-styles', plugin_dir_url(__FILE__) . 'css/style.css');
}
