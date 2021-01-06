<?php
/**
 * Plugin Name: Content Tag List
 * Description: This plugin show all A tags and check for rel, if rel="FOLLOW" or rel="NOFOLLOW" shows in 'rel' field of table
 * Version: 1.0
 * Author: Davood Jafari
 * Author URI: https://www.codeinwp.ir/
 * Plugin URI: https://www.codeinwp.ir/content-tag-list
 * License: MIT License
 * License URI: http://opensource.org/licenses/MIT
 * Text Domain: content-tag-list
 * License: GPL v3
 */


// exit if accessed directly
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

define("CTL_PLUGIN_DIR", plugin_dir_path(__FILE__));

require_once CTL_PLUGIN_DIR . 'includes/plugin.php';

