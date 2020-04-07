<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$understrap_includes = array(
	'/setup-child.php',                           // Child Theme setup and custom theme supports.
	'/enqueue-child.php',                         // Enqueue scripts and styles.
	'/template-tags-child.php',                   // Custom template tags for this theme.
	'/add-post-type-realty.php',                  // Add custom post type "Недвижимость"
	'/add-post-type-city.php',                    // Add custom post type "Город"
);

foreach ( $understrap_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
