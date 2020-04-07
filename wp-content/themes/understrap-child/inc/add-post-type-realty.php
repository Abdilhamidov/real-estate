<?php
/* 
* Регистрация пользовательского типа записей 
* Светильники - Lamps
*/

add_action( 'init', function(){
	register_taxonomy('realty_category', array('realty'), array(
		'label' => __( 'Realty Section', 'understrap-child' ),
		'labels' => array(
			'name' => __( 'Realty Sections', 'understrap-child' ),
			'singular_name' => __( 'Realty Section', 'understrap-child' ),
			'search_items' =>  __( 'Find Realty Section', 'understrap-child' ),
			'all_items' => __( 'All Realty Sections', 'understrap-child' ),
			'parent_item' => __( 'Parent Realty Section', 'understrap-child' ), // родительская таксономия
			'parent_item_colon' => __( 'Parent Realty Section', 'understrap-child' ),
			'edit_item' => __( 'Edit Realty Sections', 'understrap-child' ),
			'update_item' => __( 'Update Realty Sections', 'understrap-child' ),
			'add_new_item' => __( 'Add Realty Section', 'understrap-child' ),
			'new_item_name' => __( 'New Realty Section', 'understrap-child' ),
			'menu_name' => __( 'Realty Sections', 'understrap-child' ),
		),
		'description' => __( 'Realty Tax Description', 'understrap-child' ),
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_in_rest' => true, // чтобы подключить редактор Гуттенберга
		'rest_base' => '',
		'hierarchical' => true,
		// 'rewrite' => array( 'slug' => 'realty', 'with_front' => true),
		'has_archive' => 'realty',
		'show_admin_column' => true,
	));

	register_post_type( 'realty', array(
		'label' => __( 'Realty', 'understrap-child' ),
		'labels' => array( // добавляем новые элементы в административную часть
			'name' => __( 'Realty', 'understrap-child' ),
			'singular_name' => __( 'Realty Singular Name', 'understrap-child' ),
			'has_archive' => true,
			'add_new' => __( 'Add Realty', 'understrap-child' ),
			'not_found' => __( 'Not Found', 'understrap-child' ),
			'not_found_in_trash' => __( 'Not Found In Trash', 'understrap-child' )
		),
		'description' => '',
		'public' => true,
		'publicly_queryable'  => true,
		'show_ui' => true,
		'show_in_rest' => true, // чтобы подключить редактор Гуттенберга
		'rest_base' => '',
		// 'capability_type' => 'post',
		'hierarchical' => true,
		'menu_position' => 10,
		'menu_icon' => 'dashicons-admin-home',
		'rewrite' => array( 'slug'=>'realty', 'with_front' => false ),
		'has_archive' => 'realty',
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
		'taxonomies' => array('realty_category'), // добавляем к записям необходимый набор таксономий
	));
});


/* для создания правильного урла */
// add_filter('post_type_link', function($permalink, $post){
// 	if( strpos($permalink, '%realty_category%') === FALSE )
// 		return $permalink;

// 	// Получаем элементы таксы
// 	$terms = get_the_terms($post, 'realty_category');
// 	// если есть элемент заменим холдер
// 	if( ! is_wp_error($terms) && !empty($terms) && is_object($terms[0]) )
// 		$taxonomy_slug = $terms[0]->slug;
// 	else
// 		$taxonomy_slug = 'no-realty';
// 	return str_replace('%realty_category%', $taxonomy_slug, $permalink );
// }, 1, 2);


/* Создание фильтра по категориям */
add_action('restrict_manage_posts', function(){

	global $typenow;
	$post_type = 'realty';
	$taxonomy = 'realty_category';
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
add_filter("manage_"."realty_posts"."_columns", function($columns){
	$preview = array( 'preview' => __( 'Preview', 'understrap-child') );
	$columns = array_slice( $columns, 0, 1 ) + $preview + array_slice( $columns, 1, NULL, true );

	// $section = array( 'section' => 'Раздел' );
	// $columns = array_slice( $columns, 0, 3 ) + $section + array_slice( $columns, 3 );
	return $columns;
});


// заполняем новую колонку
add_filter("manage_"."realty_posts"."_custom_column", function($column_name, $id){
	switch ($column_name) {
		case 'preview':
			$html = get_the_post_thumbnail( $id, array(40, 40)); 
			echo $html;
 			break;
		case 'section':
			$terms = get_the_terms( $id, 'realty_category' );
			if($terms){
				$names = array();
				foreach ($terms as $term) {
					$names[] = $term->name;
				}
				$html = implode(" - ", $names);
				echo $html;
			}
 			break;
		default:
			break;
	}
}, 10, 3);


// добавляем сортировку колонки
add_filter( 'manage_'.'edit-realty'.'_sortable_columns', function(){
	$sortable_columns['preview'] = [ 'preview_preview', false ]; // false = asc (по умолчанию), true  = desc
	// $sortable_columns['section'] = [ 'section_section', false ]; // false = asc (по умолчанию), true  = desc
	return $sortable_columns;
} );