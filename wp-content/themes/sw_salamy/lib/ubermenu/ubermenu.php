<?php 

/*
Plugin Name: UberMenu 2 - WordPress Mega Menu Plugin
Plugin URI: http://wpmegamenu.com
Description: Create highly customizable Mega Menus through an easy-to-use WordPress Plugin.  Please be sure to follow the <a href="http://goo.gl/vp3Ix" target="_blank">installation instructions</a> precisely.
Version: 2.4.0.3
Author: Chris Mavricos, SevenSpark
Author URI: http://sevenspark.com
Copyright 2011-2013  Chris Mavricos, SevenSpark http://sevenspark.com
*/

/* Constants */
define( 'UBERMENU_VERSION', 		'2.4.0.3' );
define( 'UBERMENU_LESS',			dirname(__FILE__).'/standard/stylegenerator/skin.less' );
define( 'UBERMENU_GEN_SKIN',		dirname(__FILE__).'/standard/stylegenerator/skin.css' );


require_once( 'core/ubermenu.core.php' );
require_once( 'standard/ubermenu.standard.php' );		
$uberMenu = new UberMenuStandard();



/*
 * Example of how to register an UberMenu preset externally
 * 
	function uberMenu_register_styles_example(){
		ubermenu_registerStylePreset( 'my-preset', 'My Preset Name', 'path/to/stylesheet.css' );
	} 
	add_action( 'uberMenu_register_styles', 'uberMenu_register_styles_example' , 10 , 0 );
 */

do_action( 'uberMenu_load_dependents' );
