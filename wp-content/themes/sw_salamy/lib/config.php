<?php
/**
 * Enable theme features
 */
// add_theme_support('root-relative-urls');    // Enable relative URLs
// add_theme_support('rewrites');              // Enable URL rewrites
// add_theme_support('h5bp-htaccess');         // Enable HTML5 Boilerplate's .htaccess
// add_theme_support('bootstrap-top-navbar');  // Enable Bootstrap's top navbar
add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery]
// add_theme_support('nice-search');           // Enable /?s= to /search/ redirect
add_theme_support('jquery-cdn');            // Enable to load jQuery from the Google CDN

/**
 * Configuration values
 */
define('POST_EXCERPT_LENGTH', 40);

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide, set $content_width = 620; so images and videos will not overflow.
 * Default: 940px is the default Bootstrap container width.
 */
if (!isset($content_width)) { $content_width = 940; }

$add_query_vars = array( 'scheme', 'text_direction', 'menu_type' );

$customize_types = array(
		'general' => array(
				'type' => 'section',
				'title' => __('General', 'yatheme')
		),

		'scheme' => array(
				'type' => 'select',
				'label' => __('Color Scheme', 'yatheme'),
				'choices' => array(
						'default' => __('Green',  'yatheme'),
						'blue'    => __('Blue',   'yatheme'),
						'orange'  => __('Orange', 'yatheme'),
						'pink'    => __('Pink',   'yatheme'),
						'purple'  => __('Purple', 'yatheme'),
						'red'  => __('Red', 'yatheme')
				)
		),

		'favicon' => array(
				'type' => 'image',
				'label' => __('Favicon Icon', 'yatheme')
		),

		'text_direction' => array(
				'type' => 'select',
				'label' => __('Text Direction', 'yatheme'),
				'choices' => array(
						'auto' => __('Auto',          'yatheme'),
						'ltr'  => __('Left to Right', 'yatheme'),
						'rtl'  => __('Right to Left', 'yatheme')
				)
		),

		'responsive_support' => array(
				'type' => 'checkbox',
				'label' => __('Responsive Support', 'yatheme')
		),

		'sitelogo' => array(
				'type' => 'image',
				'label' => __('Logo Image', 'yatheme')
		),
		
		'navbar-options' => array(
				'type' => 'section',
				'title' => __('Navbar Options', 'yatheme')
		),
		'navbar_position' => array(
				'type' => 'select',
				'label' => __('Navbar Position', 'yatheme'),
				'choices' => array(
					'static' => 'Static',
					'top-fixed' => 'Top Fixed',
					'bottom-fixed' => 'Bottom Fixed'
				)
		),
		'navbar_inverse' => array(
				'type' => 'checkbox',
				'label' => __('Navbar Inverse Color', 'yatheme')
		),
		'navbar_branding' => array(
				'type' => 'checkbox',
				'label' => __('Display Branding', 'yatheme')
		),
		
		'navbar_logo' => array(
				'type' => 'image',
				'label' => __('Use Logo for Branding', 'yatheme')
		),
		
		'menu_type' => array(
			'type' => 'select',
			'label' => __('Menu Type', 'yatheme'),
			'choices' => array(
				'dropdown' => 'Dropdown Menu',
				'mega' => 'Mega Menu'
			)
		),

		'yatheme-layouts' => array(
				'type' => 'section',
				'title' => __('Layout', 'yatheme')
		),
		
		'theme_layout' => array(
				'type' => 'select',
				'label' => __('Content Layout', 'yatheme'),
				'choices' => array(
						'mo'  => __('No Sidebar',      'yatheme'), // Using 'mo'
						//'ms'  => __('Content-Sidebar', 'yatheme'), // And ('ms'
						//'sm'  => __('Sidebar-Content', 'yatheme'), //           & 'sm' ) or
						'lmr' => __('Left-Main-Right', 'yatheme'), // And ('lmr'
						'lrm' => __('Left-Right-Main', 'yatheme'), //             & 'lrm'
						'mlr' => __('Main-Left-Right', 'yatheme'), //             & 'mlr'
						'mrl' => __('Main-Right-Left', 'yatheme'), //             & 'mrl'
						'rml' => __('Right-Main-Left', 'yatheme'), //             & 'rml'
						'rlm' => __('Right-Left-Main', 'yatheme')  //             & 'rlm').
				)
		),

		'sidebar_primary_expand' => array(
				'type' => 'select',
				'label' => __('Primary Sidebar Expand', 'yatheme'),
				'choices' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12'
				)
		),
		
		'sidebar_left_expand' => array(
				'type' => 'select',
				'label' => __('Left Sidebar Expand', 'yatheme'),
				'choices' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12'
				)
		),

		'sidebar_right_expand' => array(
				'type' => 'select',
				'label' => __('Left Right Expand', 'yatheme'),
				'choices' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12'
				)
		),
		'blog_layout' => array(
				'type' => 'select',
				'label' => __('Layout blog', 'yatheme'),
				'choices' => array(
						'column1' => 'Layout 1',
						'column2' => 'Layout 2',
						
				)
		),
		'blog_column' => array(
				'type' => 'select',
				'label' => __('Blog column', 'yatheme'),
				'choices' => array(
						'2' => '2 column',
						'3' => '3 column',
						'4' => '4 column',
						'6' => '6 column',			
				)
		),
		'typography' => array(
				'type' => 'section',
				'title' => __('Typography', 'yatheme')
		),

		'google_webfonts' => array(
				'type' => 'text',
				'label' => __('Use Google Webfont', 'yatheme')
		),

		'webfonts_weight' => array(
				'type' => 'select',
				'label' => __('Webfont Weight', 'yatheme'),
				'choices' => array(
						'200' => '200',
						'300' => '300',
						'400' => '400',
						'600' => '600',
						'700' => '700',
						'800' => '800',
						'900' => '900'
				)
		),

		'webfonts_character_set' => array(
				'type' => 'select',
				'label' => __('Webfont Character Set',    'yatheme'),
				'choices' => array(
						'cyrillic'     => __( 'Cyrillic',          'yatheme' ),
						'cyrillic-ext' => __( 'Cyrillic Extended', 'yatheme' ),
						'greek'        => __( 'Greek',             'yatheme' ),
						'greek-ext'    => __( 'Greek Extended',    'yatheme' ),
						'latin'        => __( 'Latin',             'yatheme' ),
						'latin-ext'    => __( 'Latin Extended',    'yatheme' ),
						'vietnamese'   => __( 'Vietnamese',        'yatheme' )
				)
		),

		'webfonts_assign' => array(
				'type' => 'select',
				'label' => __('Webfont Assign to', 'yatheme'),
				'choices' => array(
						'headers' => __( 'Headers',    'yatheme' ),
						'all'     => __( 'Everywhere', 'yatheme' ),
						'custom'  => __( 'Custom',     'yatheme' )
				)
		),

		'webfonts_custom' => array(
				'type' => 'text',
				'label' => __('Webfont Custom Selector', 'yatheme')
		),

		'advanced' => array(
				'type' => 'section',
				'title' => __('Advanced', 'yatheme')
		),
		
		'developer_mode' => array(
				'type' => 'checkbox',
				'label' => __('Developer Mode', 'yatheme')
		),
		
		'google_analytics_id' => array(
				'type' => 'text',
				'label' => __('Google Analytics ID', 'yatheme')
		),
		
		'advanced_head' => array(
				'type' => 'textarea',
				'label' => __('Custom CSS/JS', 'yatheme')
		)

);

function ya_optionsx(){
	return YA_Config::setVariables(
			wp_parse_args(
					get_option('ya_options'),
					ya_default_options()
			)
	);
}

function ya_default_options(){
	$default_theme_options = array(
			'scheme'                 => 'default',
			'favicon'                => get_template_directory_uri().'/assets/img/favicon.ico',
			'text_direction'         => 'ltr',
			'responsive_support'     => true,

			'display_searchform'     => true,
			'display_socials'        => true,
			'sitelogo'               => get_template_directory_uri().'/assets/img/logo.png',
			
			'navbar_position'        => 'static',
			'navbar_inverse'		 => false,
			'navbar_branding'	     => true,
			'navbar_logo'            => get_template_directory_uri().'/assets/img/logo.png',
			'navbar_searchform'      => true,
			'menu_type'              => 'dropdown',
			
			'theme_sidebar'          => 'primary',
			'theme_layout'           => 'ms',
			'sidebar_primary_expand' => 4,
			'sidebar_left_expand'    => 4,
			'sidebar_right_expand'   => 4,
			'blog_layout'			 => 'column1',

			'google_webfonts'        => '',
			'webfonts_weight'        => '400',
			'webfonts_character_set' => 'latin',
			'webfonts_assign'        => 'custom',
			'webfonts_custom'        => '',

			'advanced_head'          => '',
			'google_analytics_id'    => '',
			'developer_mode'         => false

	);
	return apply_filters( 'theme_default_options', $default_theme_options );
}