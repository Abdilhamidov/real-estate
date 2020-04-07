<?php 

if( ! defined('ABSPATH') ) exit;

// Регистрируем новый виджет
add_action( 'widgets_init', 'register_top_posts_widget' );
function register_top_posts_widget() {
	register_widget( 'Last_Post_Widget' );
}

// Добавляем новый виджет
class Last_Post_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'pop_widget',
			__( 'Last Posts', 'understrap-child'),
			array( 'description' => __( 'Displays Last Posts', 'understrap-child'), )
		);


		// Функция подсчета просмотров
		// function set_post_views($postID) {
		// 	// Мета где будем хранить данные
		// 	$count_views = 'count_views'; // Количество просмотров

		// 	// Получаем данные из мета
		// 	$count = get_post_meta($postID, $count_views, true); // Количество просмотров

		// 	// Если $count не существует
		// 	if($count=='') {
		// 		$count = 0;
		// 		delete_post_meta($postID, $count_views);
		// 		add_post_meta($postID, $count_views, '0');
		// 	} else {
		// 		$count++;
		// 		update_post_meta($postID, $count_views, $count);
		// 	}
		// }   
	}

	/** Вывод виджета популярных записей
	 *
	 *  @param array $args     аргументы виджета.
	 *  @param array $instance сохраненные данные из настроек
	 */
	public function widget( $args, $instance ) {

		// Получим опции виджета
		$title = apply_filters( 'widget_title', $instance['title'] ); 
		$quantity = $instance['quantity'] ? $instance['quantity'] : 1; 
		$post_type = $instance['post_type'] ? $instance['post_type'] : "post";

		// Аргументы вывода виджета
		$args = array(
			'post_status' => 'publish',
			'orderby' => 'date',
			'post_type' => $post_type,
			'numberposts' => $quantity,
			'order' => 'DESC',
		); 
		$result = new WP_Query($args);
		set_query_var('result', $result); // send data to template
		get_template_part( 'global-templates/posts', 'list' );
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	public function form( $instance ) {
		$title = @ $instance['title'] ?: __( 'Title', 'understrap-child');
		$quantity = @ $instance['quantity'] ?: '1';
		$post_types = get_post_types(array('public' => true));
		$post_type = @ $instance['post_type'] ?: 'post';
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'understrap-child'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>">
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post Type', 'understrap-child'); ?></label>
		<select name="<?php echo $this->get_field_name( 'post_type' ); ?>">
			<?php foreach ($post_types as $post_type_item): ?>
				<option value="<?php echo $post_type_item; ?>" <?php selected( $post_type, $post_type_item ) ?>><?php echo $post_type_item; ?></option>
			<?php endforeach;	?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'quantity' ); ?>"><?php _e( 'Quantity', 'understrap-child'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'quantity' ); ?>" name="<?php echo $this->get_field_name( 'quantity' ); ?>" type="text" value="<?php echo $quantity; ?>">
	</p>

	<?php }

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? ( $new_instance['title'] ) : '';
		$instance['quantity'] = ( ! empty( $new_instance['quantity'] ) ) ? sanitize_text_field( $new_instance['quantity'] ) : '';
		$instance['post_type'] = ( ! empty( $new_instance['post_type'] ) ) ? sanitize_text_field( $new_instance['post_type'] ) : '';

		return $instance;
	}
}

?>