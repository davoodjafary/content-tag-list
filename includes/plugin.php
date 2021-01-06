<?php
/**
 * Content Tag List Font functions
 *
 *
 *
 * @author  Davood Jafari
 * @package Content Tag List
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ){
    exit;
}

define( "CTL_PLUGIN_DIR", plugin_dir_path( __FILE__ ) );

require_once CTL_PLUGIN_DIR . 'includes/functions.php';

add_action("admin_menu", "ctl_show_result_action");

function ctl_show_result_action()
{
    add_options_page("content-tag-list", "Content tag list", "manage_options", __FILE__, "ctl_show_result");
}

function ctl_show_result()
{
    $results = ctl_get_links_info();

    $current_page = 1;

    $get_paged = intval($_GET['paged']);

    if (!filter_var($get_paged, FILTER_VALIDATE_INT) === false) {
            if ($get_paged > 1) {
            $current_page = $get_paged;
        }
    }

    $item_per_page = 10;
    $total_page = ceil(count($results) / $item_per_page);

    ?>
    <div class="wrap">
        <h2>Content tag list</h2>
        <h4>This plugin show all A tags and check for rel, if rel="FOLLOW" or rel="NOFOLLOW" shows in 'rel' field of
            table.</h4>
        <p>If tag don't have any rel, not show any value in table. this plugin support all type of rel, i thought it's
            not necessary to show only 'follow' or 'nofollow' rel and this will show all type of rel.</p>
        <p>In all page show 5 row and this plugin support pagination.</p>
        <table class="wp-list-table widefat fixed striped pages">
            <thead>
            <tr>
                <td>Content Title</td>
                <td>Link</td>
                <td>Rel</td>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td>Content Title</td>
                <td>Link</td>
                <td>Rel</td>
            </tr>
            </tfoot>
            <tbody>
            <?php
            for ($i = (($current_page - 1) * $item_per_page); $i < ($current_page * $item_per_page); $i++) {
                $result = $results[$i];
                if (!empty($result['post_title'])) {
                    ?>
                    <tr class="">
                        <?php
                        echo "<td><a href='" . $result['post_guid'] . "' >" . $result['post_title'] . "</a></td>";
                        echo "<td><a href='" . $result['link_href'] . "' >" . $result['link_node'] . "</a></td>";
                        echo "<td>" . $result['link_rel'] . "</td>";
                        ?>
                    </tr>
                <?php }
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
    <div class="pagination-div">
        <?php
        ctl_pagination_content($current_page, $total_page);
        ?>
    </div>
    <?php
}