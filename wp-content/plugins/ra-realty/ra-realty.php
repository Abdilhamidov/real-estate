<?php
/* ====================================
 * Plugin Name: RA Realty
 * Description: Для работы с записями "Недвижимость". Добавление c учетом всех мета-полей.
 * Author: Abdilkhamidov R.
 * Version: 1.0
 * ==================================== */

define( 'RARLT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RARLT_PLUGIN_URL', plugin_dir_url(__FILE__) );

// activate the plugin
add_action('plugins_loaded', 'rarlt_plugin_init');

function rarlt_plugin_init(){

	load_plugin_textdomain( 'ra-realty', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	include_once(RARLT_PLUGIN_DIR."settings.php");

	// include shortcode [addrealty-form ...]
	// include_once("shortcodes/addrealty-form.php");

	/* 
	* Include CSS and JS for front
	* 
	*/
	add_action( 'wp_enqueue_scripts', function(){
		wp_enqueue_style( 'ra-realty', RARLT_PLUGIN_URL . 'assets/dist/css/style.css', array(), '1.0', 'all' );
		wp_register_script( 'ra-realty-js', RARLT_PLUGIN_URL . 'assets/dist/js/main.js', array('jquery'), "1.0", true );
		wp_enqueue_script('ra-realty-js');

	}, 20 );


	/**
	 * Include CSS and JS for Admin
	 */
	// function admin_style() {
	// 	wp_enqueue_style('ra-realty-admin', get_stylesheet_directory_uri() . '/assets/dist/css/admin-style.min.css', array(), "1.0");
	// }
	// add_action('admin_enqueue_scripts', 'admin_style');
	
}


add_filter("plugin_action_links_".plugin_basename(__FILE__), "ra_realty_plugin_actions", 10, 4);

function ra_realty_plugin_actions( $actions, $plugin_file, $plugin_data, $context ) {
	array_unshift($actions,
		sprintf('<a href="%s" aria-label="%s">%s</a>',
			menu_page_url('ra_realty', false),
			esc_attr__( 'Settings for RA Realty', 'ra-realty'),
			esc_html__("Settings", 'default')
		)
	);
	return $actions;
}


