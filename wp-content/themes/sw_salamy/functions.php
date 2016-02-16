<?php

if ( !defined('__THEME__') ){
	// Define helper constants
	$get_theme_name = explode( '/wp-content/themes/', get_template_directory() );
	define( '__THEME__', next($get_theme_name) );
}

/**
 * Variables
 */
require_once locate_template('/lib/defines.php');
require_once locate_template('/defines.php');

/**
 * Roots includes
 */

require_once locate_template('/lib/classes.php');		// Utility functions
require_once locate_template('/lib/utils.php');			// Utility functions
require_once locate_template('/lib/init.php');			// Initial theme setup and constants
require_once locate_template('/lib/config.php');		// Configuration
require_once locate_template('/lib/activation.php');	// Theme activation
require_once locate_template('/lib/cleanup.php');		// Cleanup
require_once locate_template('/lib/nav.php');			// Custom nav modifications
require_once locate_template('/lib/rewrites.php');		// URL rewriting for assets
require_once locate_template('/lib/htaccess.php');		// HTML5 Boilerplate .htaccess
require_once locate_template('/lib/widgets.php');		// Sidebars and widgets
require_once locate_template('/lib/scripts.php');		// Scripts and stylesheets
require_once locate_template('/lib/customizer.php');	// Custom functions
require_once locate_template('/lib/shortcodes.php');	// Utility functions
require_once locate_template('/lib/woocommerce-hook.php');	// Utility functions
require_once locate_template('/lib/plugins/currency-converter/currency-converter.php'); // currency converter
if(ya_options()->getCpanelValue('menu_type') == 'mega'){
	function stop_removing_core_classes(){
		remove_filter('nav_menu_css_class', 'ya_nav_menu_css_class', 10, 2);
		remove_filter('nav_menu_item_id', '__return_null');
	}
	add_action( 'init' , 'stop_removing_core_classes' );
	require_once locate_template('/lib/ubermenu/ubermenu.php');
}
require_once locate_template('/lib/less.php');			// Custom functions
//active revolution slider
$revslider = get_template_directory() . '/lib/revslider/revslider.php';
if(! ya_options()->getCpanelValue('revslide_active')){
	include $revslider;

	// Activate the plugin if necessary
	if(get_option('ya_revslider_activated', '0') == '0') {
		if(!class_exists('RevSliderAdmin')) {
			$revslider_admin_script = get_template_directory() . '/lib/revslider/revslider_admin.php';
			include $revslider_admin_script;
		}

		// Run activation script
		$revslider_admin = new RevSliderAdmin($revslider);
		$revslider_admin->onActivate();

		// Save a flag that it is activated, so this won't run again
		update_option('ya_revslider_activated', '1');
	}
	
}


/* Disable WordPress Admin Bar for all users but admins. */
show_admin_bar(false);
