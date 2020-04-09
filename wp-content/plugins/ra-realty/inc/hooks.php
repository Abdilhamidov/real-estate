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
		$realty_args = array(
			'post_status' => 'publish',
			'post_type' => 'realty',
			'post_title' => $_REQUEST['post_title'],
			'post_content' => $_REQUEST['post_content'],
			'tax_input' => array('realty_category' => array($_REQUEST['post_category'])),
		);	
		$post_id = wp_insert_post( $realty_args, $wp_error ); 

		if( is_wp_error( $error ) ){
			$responce['errors'][] = $wp_error->get_error_message();
		}else{

			// Загрузка фото и создание миниатюры поста
			if(isset($_FILES['file'])){
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once( ABSPATH . 'wp-admin/includes/media.php' );

				$attachment_id = media_handle_upload( 'file', 0 );
				$responce['attachment_id'] = $attachment_id;

				if ( is_wp_error( $attachment_id ) ) {
					$responce['errors'][] = __('Photo upload error', 'ra-realty');
				}else{
					set_post_thumbnail( $post_id, $attachment_id );
				}
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
	}

	echo json_encode($responce);

	wp_die();
}
