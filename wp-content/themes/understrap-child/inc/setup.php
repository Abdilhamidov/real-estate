<?php
/**
 * Theme basic setup.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


add_action( 'after_setup_theme', 'understrap_child_setup' );

if ( ! function_exists ( 'understrap_child_setup' ) ) {

	function understrap_child_setup() {

		load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );

	}
}
