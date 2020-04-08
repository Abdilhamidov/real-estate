<?php 

if( ! defined('ABSPATH') ) exit;

// Регистрируем новый виджет
add_action( 'widgets_init', 'register_posts_list_widget' );
function register_posts_list_widget() {
	register_widget( 'Posts_List_Widget' );
}

// Добавляем новый виджет
class Posts_List_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'pop_widget',
			__( 'Posts List', 'understrap-child'),
			array( 'description' => __( 'Displays Posts List', 'understrap-child'), )
		);
	}

	/** Вывод виджета записей
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
			'posts_per_page' => $quantity,
			'order' => 'DESC',
		); 
		$result = new WP_Query($args);
		$attr = array(
			'title' => $title,
			'wp_query_result' => $result,
		);
		set_query_var('attr', $attr); // send data to template
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