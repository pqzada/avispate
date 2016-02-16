<?php
$instance = array();

// strip tag on text field
$instance['title'] = strip_tags( $new_instance['title'] );

// int or array
if ( array_key_exists('category', $new_instance) ){
	if ( is_array($new_instance['category']) ){
		$instance['category'] = array_map( 'intval', $new_instance['category'] );
	} else {
		$instance['category'] = intval( $new_instance['category'] );
	}
}

if ( array_key_exists('exclude', $new_instance) ){
	$instance['exclude'] = strip_tags( $new_instance['exclude'] );
}

if ( array_key_exists('include', $new_instance) ){
	$instance['include'] = strip_tags( $new_instance['include'] );
}

if ( array_key_exists('orderby', $new_instance) ){
	$instance['orderby'] = strip_tags( $new_instance['orderby'] );
}

if ( array_key_exists('order', $new_instance) ){
	$instance['order'] = strip_tags( $new_instance['order'] );
}

if ( array_key_exists('numberposts', $new_instance) ){
	$instance['numberposts'] = intval( $new_instance['numberposts'] );
}

if ( array_key_exists('height', $new_instance) ){
	$instance['height'] = intval( $new_instance['height'] );
}

if ( array_key_exists('background', $new_instance) ){
	$instance['background'] = strip_tags( $new_instance['background'] );
}

if ( array_key_exists('interval', $new_instance) ){
	$instance['interval'] = intval( $new_instance['interval'] );
}

if ( array_key_exists('auto_play', $new_instance) ){
	$instance['auto_play'] = strip_tags( $new_instance['auto_play'] );
}

if ( array_key_exists('number_thumb', $new_instance) ){
	$instance['number_thumb'] = intval( $new_instance['number_thumb'] );
}

if ( array_key_exists('hover_stop', $new_instance) ){
	$instance['hover_stop'] = strip_tags( $new_instance['hover_stop'] );
}

if ( array_key_exists('full_width', $new_instance) ){
	$instance['full_width'] = strip_tags( $new_instance['full_width'] );
}


if ( array_key_exists('length', $new_instance) ){
	$instance['length'] = intval( $new_instance['length'] );
}
$instance['thumbnail'] = strip_tags( $new_instance['thumbnail'] );
$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );