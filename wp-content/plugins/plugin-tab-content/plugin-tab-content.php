<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * @package   Plugin_Name
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 *
 * @wordpress-plugin
 * Plugin Name: Tab Content
 * Plugin URI:  Tab Content
 * Description: Tab Content
 * Version:     1.0.0
 * Author:      Tab Content
 * Author URI:  Tab Content
 * Text Domain: plugin-name-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// TODO: replace `class-plugin-tab-content.php` with the name of the actual plugin's class file
require_once( plugin_dir_path( __FILE__ ) . 'class-plugin-tab-content.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
// TODO: replace Plugin_Name with the name of the plugin defined in `class-plugin-tab-content.php`
register_activation_hook( __FILE__, array( 'Plugin_Tab_Content', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Plugin_Tab_Content', 'deactivate' ) );
// TODO: replace Plugin_Name with the name of the plugin defined in `class-plugin-tab-content.php`
Plugin_Tab_Content::get_instance();