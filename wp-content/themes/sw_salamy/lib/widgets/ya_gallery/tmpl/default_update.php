<?php
$instance = array();
// strip tag on text field
$instance['title'] = strip_tags( $new_instance['title'] );

if ( array_key_exists('post_id', $new_instance) ){
	$instance['post_id'] = intval( $new_instance['post_id'] );
}

$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );