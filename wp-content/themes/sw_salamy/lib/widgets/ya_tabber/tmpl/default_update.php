<?php
$instance = array();

// strip tag on text field
$instance['title'] = strip_tags( $new_instance['title'] );

// int or array

if ( array_key_exists('latest_posts', $new_instance) ){
	$instance['latest_posts'] = intval( $new_instance['latest_posts'] );
}

if ( array_key_exists('popular_posts', $new_instance) ){
	$instance['popular_posts'] = intval( $new_instance['popular_posts'] );
}

if ( array_key_exists('length', $new_instance) ){
	$instance['length'] = intval( $new_instance['length'] );
}
$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );