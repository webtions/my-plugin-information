<?php
/**
 * Plugin Name:       My Plugin Information
 * Plugin URI:        https://themeist.com/plugins/wordpress/my-plugin-information/#utm_source=wp-plugin&utm_medium=my-plugin-information&utm_campaign=plugins-page
 * Description:       Developer-focused plugin to fetch and display information from the WordPress.org Plugin API.
 * Version:           0.4
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Themeist
 * Author URI:        https://themeist.com/
 * Author Email:      support@themeist.com
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       my-plugin-information
 * Domain Path:       /languages
 *
 * @package MyPluginInformation
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// do nothing if class is already defined
if( class_exists( 'DOT_MyPluginInfo' ) ) {
	return;
}

// require includes
require_once dirname( __FILE__ ) . '/includes/class-my-plugin-info.php';
require_once dirname( __FILE__ ) . '/includes/functions.php';

// create instance of plugin class
global $my_plugin_information;
$my_plugin_information = new DOT_MyPluginInfo();
$my_plugin_information->add_hooks();
