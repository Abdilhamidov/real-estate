<?php

#1. Создадим новый мета блок
add_action('add_meta_boxes', function(){
	add_meta_box( 'extra_fields', __( 'Realty Properties', 'understrap-child'), 'realty_extra_fields_box', array('ceilings', 'page'), 'normal', 'high' );
}, 1);


#2. Заполним этот блок полями html формы
function realty_extra_fields_box( $post ){
	?>
	<div class="realty-props-block">
		<p><label for="subcaption">Подзаголовок:</label><br><textarea id="subcaption" name="props[subcaption]"><?php echo get_post_meta($post->ID, 'subcaption', true); ?></textarea></p>
		<p><label>Цена: <input type="number" name="props[price]" value="<?php echo get_post_meta($post->ID, 'price', true); ?>" /> руб.</label></p>
		<p><label>Цена со скидкой: <input type="number" name="props[discount-price]" value="<?php echo get_post_meta($post->ID, 'discount-price', true); ?>" /> руб.</label></p>
		<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	</div>
	<?php
}

#2. Сохранение данных
add_action('save_post', function( $post_id ){
		// базовая проверка
		if (
			   empty( $_POST['props'] )
			|| ! wp_verify_nonce( $_POST['extra_fields_nonce'], __FILE__ )
			|| wp_is_post_autosave( $post_id )
			|| wp_is_post_revision( $post_id )
		){
			return false;
		}
		foreach( $_POST['props'] as $key => $value ){
			if( empty($value) ){
				delete_post_meta( $post_id, $key );
				continue;
			}
			switch ($key) {
				case 'colors':
				case 'material':
					# code...
					break;
				case 'ceo-text':
				case 'subcaption':
				default:
					$value = esc_html($value);
					break;
			}
			update_post_meta( $post_id, $key, $value );
		}
		return $post_id;
}, 0);