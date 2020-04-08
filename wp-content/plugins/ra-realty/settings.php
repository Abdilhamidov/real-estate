<?php
/* ====================================
 * Settings
 * ==================================== */

/**
 * Создаем страницу настроек плагина
 */
add_action('admin_menu', 'add_plugin_page');
function add_plugin_page(){
	add_options_page( __('RA Realty Settings', 'ra-realty'), __('RA Realty', 'ra-realty'), 'manage_options', 'ra_realty', 'ra_rlt_options_page_output' );

	global $post_types;
	$post_types = get_post_types(array('public' => true));
}


function ra_rlt_options_page_output(){
	?>
	<div class="wrap">
		<h2><?php echo get_admin_page_title() ?></h2>

		<form action="options.php" method="POST">

			<?php
			global $ra_rlt_active_tab;
			$ra_rlt_active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'main_settings'; 
			?>
			<h2 class="nav-tab-wrapper"><?php do_action( 'ra_rlt_settings_tab' ); ?></h2>
			<?php do_action( 'ra_rlt_settings_content' );?>

		</form>
	</div>

	<?php
}


// add a tab of the main settings
add_action( 'ra_rlt_settings_tab', function(){
	global $ra_rlt_active_tab; ?>
	<a class="nav-tab <?php echo $ra_rlt_active_tab == 'main_settings' || '' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=ra_realty&tab=main_settings' ); ?>"><?php _e( 'Main Settings', 'ra-realty' ); ?> </a>
	
	<?php
}, 1 );


// Main settings tab content
add_action( 'ra_rlt_settings_content', function(){
	global $ra_rlt_active_tab;
	if ( '' || 'main_settings' != $ra_rlt_active_tab )
		return;
	?>
	<?php
		settings_fields( 'ra_rlt_option_group' ); // скрытые защитные поля
		do_settings_sections( 'ra_rlt_page' );
		submit_button();
	?>
	<?php
} );


/**
 * Регистрируем настройки.
 * Настройки будут храниться в массиве, а не одна настройка = одна опция.
 */
add_action('admin_init', 'plugin_settings');

function plugin_settings(){
	
	// Main Settings
	register_setting( 'ra_rlt_option_group', 'ra_rlt_options', 'ra_rlt_sanitize_callback' );
	
	add_settings_section( 'ra_rlt_main_section', __('Main Settings', 'ra-realty'), 'before_ra_rlt_section_f', 'ra_rlt_page' );
	
	add_settings_field('realty_post_type', __('Select Realty Post Type', 'ra-realty'), 'select_realty_post_type_f', 'ra_rlt_page', 'ra_rlt_main_section' );
	add_settings_field('city_post_type', __('Select Linked City Post Type', 'ra-realty'), 'select_city_post_type_f', 'ra_rlt_page', 'ra_rlt_main_section' );
}


/*
* Main settings functions
* 
*/
// main settings tab description 
function before_ra_rlt_section_f(){
	_e('Main Settings Tab Description', 'ra-realty');
}


// create html for realty_post_type option
function select_realty_post_type_f(){
	global $post_types;
	$val = get_option('ra_rlt_options');
	$post_type = isset($val['realty_post_type']) && $val['realty_post_type'] ? $val['realty_post_type'] : 'post';
	?>
	<!-- <input type="text" name="ra_rlt_options[post_type]" value="<?php //echo esc_attr( $val ) ?>" /> -->
	
	<select name="ra_rlt_options[realty_post_type]">
		<?php foreach ($post_types as $post_type_item): ?>
			<option value="<?php echo $post_type_item; ?>" <?php selected( $post_type, $post_type_item ) ?>><?php echo $post_type_item; ?></option>
		<?php endforeach;	?>
	</select>

	<?php
}


// create html for city_post_type option
function select_city_post_type_f(){
	global $post_types;
	$val = get_option('ra_rlt_options');
	$post_type = isset($val['city_post_type']) && $val['city_post_type'] ? $val['city_post_type'] : 'post';
	?>

	<select name="ra_rlt_options[city_post_type]">
		<?php foreach ($post_types as $post_type_item): ?>
			<option value="<?php echo $post_type_item; ?>" <?php selected( $post_type, $post_type_item ) ?>><?php echo $post_type_item; ?></option>
		<?php endforeach;	?>
	</select>

	<?php
}

// prepare to save to DB
function ra_rlt_sanitize_callback( $options ){ 
	// fppr($options, __FILE__.' $options');
	foreach( $options as $name => & $val ){
		$val = sanitize_text_field( $val );
	}
	return $options;
}
