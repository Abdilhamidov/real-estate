<?php
/** 
 * Add shortcode: [add-realty] 
 * Displays realties linked to city
 * @param 
*/
add_shortcode( 'add-realty', function($atts){

	$errors = array();
	$fields = array();
	$cities = array();

	$ra_rlt_options = get_option('ra_rlt_options');

	// мета-поля ACF
	if(function_exists('acf_get_field_groups')){
		$field_groups = acf_get_field_groups( array('post_type' => $ra_rlt_options['realty_post_type'], 'post_status' => 'publish') );
		if( $field_groups ) {
			foreach( $field_groups as $field_group ) {
				$_fields = acf_get_fields( $field_group );
				if( $_fields ) {
					foreach( $_fields as $_field ) {
						$fields[] = $_field;
					}
				}
			}
		}
	}else{
		$errors[] = __( 'Function acf_get_field_groups() not found. Probably Advanced Custom Fields plugin is not installed', 'ra-realty');
	}

	// города 
	$result = new WP_Query(array(
		'post_type' => $ra_rlt_options['city_post_type'],
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
	));
	$cities = array();
	if($result->have_posts()){
		$cities = $result->posts;
	}

	// template render with attributes
	$atts = shortcode_atts( array(
		'errors' => $errors,
		'fields' => $fields,
		'cities' => $cities
	), $atts, 'add-realty');

	set_query_var('atts', $atts); // send data to template
	ob_start();
	include_once( RARLT_PLUGIN_DIR . 'templates/add-realty.php');

	return ob_get_clean();
} );