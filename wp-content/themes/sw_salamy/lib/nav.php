<?php

/**
 * Remove the id="" on nav menu items
 * Return 'menu-slug' for nav menu classes
 */
function ya_nav_menu_css_class($classes, $item) {
	$slug = sanitize_title($item->title);
	$classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes);
	$classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

	$classes[] = 'menu-' . $slug;

	$classes = array_unique($classes);

	return array_filter($classes, 'is_element_empty');
}
add_filter('nav_menu_css_class', 'ya_nav_menu_css_class', 10, 2);
add_filter('nav_menu_item_id', '__return_null');

/**
 * Clean up wp_nav_menu_args
 *
 * Remove the container
 * Use YA_Menu_Walker() by default
*/
function ya_nav_menu_args($args = '') {
	$ya_nav_menu_args['container'] = false;

	if (!$args['items_wrap']) {
		$ya_nav_menu_args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
	}
	
	if (!$args['walker']) {
		if ( 'mega' == ya_options()->getCpanelValue('menu_type') ){
			$ya_nav_menu_args['walker'] = new YA_Mega_Menu_Walker();
		} else {
			$ya_nav_menu_args['walker'] = new YA_Menu_Walker();
		}
	}

	return array_merge($args, $ya_nav_menu_args);
}
add_filter('wp_nav_menu_args', 'ya_nav_menu_args');
