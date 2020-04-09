<?php
/**
 * Custom hooks.
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// add post from form by ajax
if( wp_doing_ajax() ){
	add_action('wp_ajax_addpost', 'addpost_callback');
	add_action('wp_ajax_nopriv_addpost', 'addpost_callback');
}
function addpost_callback() {
	$responce = array();
	$responce['errors'] = array();
	$responce['request'] = $_REQUEST;

	if ( empty($_POST) || ! wp_verify_nonce( $_POST['addpost_wpnonce'], 'addpost') ){
	   $responce['errors'][] = __('wp_nonce not valid', 'ra-realty');
	}else{

		// Create a new post
		$realty = array(
			'post_status' => 'publish',
			'post_type' => 'realty',
			'post_title' => 'Объект'
		);	
		$post_id = wp_insert_post( $realty, $wp_error ); 
		if( is_wp_error( $error ) ){
			$responce['errors'][] = $wp_error->get_error_message();
		}

		// file meta fields
		$is_fields_added = true;
		foreach ($_REQUEST['fields'] as $key => $value) {
			if(!update_field($key, $value, $post_id)) {
				$is_fields_added = false;
			}
		}
		if(!$is_fields_added){
			$responce['errors'][] = __('All fields not added succesfully', 'ra-realty');
		}
	}

	echo json_encode($responce);

	wp_die();
}