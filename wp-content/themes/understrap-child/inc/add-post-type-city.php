<?php
/* 
* Регистрация пользовательского типа записей 
* Город - city
*/

add_action( 'init', function(){
	register_taxonomy('city_category', array('city'), array(
		'label' => __( 'Section', 'understrap-child' ),
		'labels' => array(
			'name' => __( 'Sections', 'understrap-child' ),
			'singular_name' => __( 'Section', 'understrap-child' ),
			'search_items' =>  __( 'Find Section', 'understrap-child' ),
			'all_items' => __( 'All Sections', 'understrap-child' ),
			'parent_item' => __( 'Parent Section', 'understrap-child' ), // родительская таксономия
			'parent_item_colon' => __( 'Parent Section', 'understrap-child' ),
			'edit_item' => __( 'Edit Sections', 'understrap-child' ),
			'update_item' => __( 'Update Sections', 'understrap-child' ),
			'add_new_item' => __( 'Add Section', 'understrap-child' ),
			'new_item_name' => __( 'New Section', 'understrap-child' ),
			'menu_name' => __( 'Sections', 'understrap-child' ),
		),
		'description' => __( 'City Tax Description', 'understrap-child' ),
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_in_rest' => true, // чтобы подключить редактор Гуттенберга
		'rest_base' => '',
		'hierarchical' => true,
		'has_archive' => 'city',
		'show_admin_column' => true,
	));

	register_post_type( 'city', array(
		'label' => __( 'City', 'understrap-child' ),
		'labels' => array( // добавляем новые элементы в административную часть
			'name' => __( 'City', 'understrap-child' ),
			'singular_name' => __( 'City Singular Name', 'understrap-child' ),
			'has_archive' => true,
			'add_new' => __( 'Add City', 'understrap-child' ),
			'not_found' => __( 'Not Found', 'understrap-child' ),
			'not_found_in_trash' => __( 'Not Found In Trash', 'understrap-child' )
		),
		'description' => '',
		'public' => true,
		'publicly_queryable'  => true,
		'show_ui' => true,
		'show_in_rest' => true, // чтобы подключить редактор Гуттенберга
		'rest_base' => '',
		'hierarchical' => true,
		'menu_position' => 10,
		'menu_icon' => 'dashicons-pressthis',
		'rewrite' => array( 'slug'=>'city', 'with_front' => false ),
		'has_archive' => 'city',
		'query_var' => true,
		'supports' => array( // добавляем элементы в редактор
			'title',
			'excerpt',
			'editor',
			'thumbnail',
			'page-attributes',
			'custom-fields',
			// 'comments'
		),
		'taxonomies' => array('city_category'), // добавляем к записям необходимый набор таксономий
	));
});


/* Создание фильтра по категориям */
add_action('restrict_manage_posts', function(){
	global $typenow;
	$post_type = 'city';
	$taxonomy = 'city_category';
	if ($typenow == $post_type) {
		$selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => __( 'Show all', 'understrap-child')." ".$info_taxonomy->label,
			'taxonomy' => $taxonomy,
			'name' => $taxonomy,
			'orderby' => 'name',
			'selected' => $selected,
			'show_count' => true,
			'hide_empty' => true,
			'value_field' => 'slug',
		));
	};
});


// создаем колонки в админке
add_filter("manage_"."city_posts"."_columns", function($columns){
	$preview = array( 'preview' => __( 'Preview', 'understrap-child') );
	$columns = array_slice( $columns, 0, 1 ) + $preview + array_slice( $columns, 1, NULL, true );
	return $columns;
});


// заполняем новую колонку
add_filter("manage_"."city_posts"."_custom_column", function($column_name, $id){
	switch ($column_name) {
		case 'preview':
			$html = get_the_post_thumbnail( $id, array(40, 40)); 
			echo $html;
 			break;
		default:
			break;
	}
}, 10, 3);


// добавляем сортировку колонки
add_filter( 'manage_'.'edit-city'.'_sortable_columns', function($sortable_columns){
	$sortable_columns['preview'] = [ 'preview_preview', false ]; // false = asc (по умолчанию), true  = desc
	return $sortable_columns;
} );