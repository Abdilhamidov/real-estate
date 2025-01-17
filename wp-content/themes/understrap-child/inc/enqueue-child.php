<?php
/**
 * Understrap enqueue scripts
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Include CSS and JS for child theme
 */
function understrap_child_scripts() {
	enqueue_fa_fonts();

	// my styles
	wp_enqueue_style( 'fingildiya-style', get_stylesheet_directory_uri() . '/assets/dist/css/style.min.css', array(), "1.0.0" );

	// my scripts
	wp_enqueue_script( 'understrap-child-scripts', get_stylesheet_directory_uri() . '/assets/dist/js/main.min.js', array('jquery'), "1.0", true );

	// переменная для ajax-запросов
	wp_localize_script( 'understrap-child-scripts', 'myajax', 
		array(
			'url' => admin_url('admin-ajax.php')
		)
	); 

	// inputmask
	wp_register_script( 'inputmask', get_stylesheet_directory_uri() . '/assets/vendor/jquery.inputmask.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'inputmask' );

	wp_register_script( 'inputmaskbindings', get_stylesheet_directory_uri() . '/assets/vendor/inputmask.binding.min.js', array('jquery', 'inputmask'), null, true );
	wp_enqueue_script( 'inputmaskbindings' );
	
}
add_action( 'wp_enqueue_scripts', 'understrap_child_scripts' );


/**
 * Include CSS and JS for Admin
 */
function admin_style() {
	// enqueue_fa_fonts();
	wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() . '/assets/dist/css/admin-style.min.css', array(), "1.0.0");
}
add_action('admin_enqueue_scripts', 'admin_style');


/**
 * Includes fa fonts
 */
function enqueue_fa_fonts(){
	wp_enqueue_style( 'fa-classes', get_stylesheet_directory_uri() .'/assets/vendor/font-awesome/css/fontawesome.min.css', array() );
	wp_enqueue_style( 'fa-font-solid', get_stylesheet_directory_uri() .'/assets/vendor/font-awesome/css/solid.min.css', array() );
	wp_enqueue_style( 'fa-font-brands', get_stylesheet_directory_uri() .'/assets/vendor/font-awesome/css/brands.min.css', array() );
}


