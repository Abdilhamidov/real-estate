<?php
/** 
 * Add shortcode: [linked-realties limit="{int}" city_id="{int}"] 
 * Displays realties linked to city
 * @param 
*/
/*add_shortcode( 'linked-realties', function($atts){
		$atts = shortcode_atts( array(
			'limit' => 10,
			'city_id' => '',
		), $atts, 'linked-realties');

		$args = array(
			'post_status' => 'publish',
			'orderby' => 'date',
			'post_type' => 'realty',
			'posts_per_page' => $atts['limit'],
			'order' => 'DESC',
		); 
		if($atts['city_id']){
			$args['meta_query'] = array(
				array(
					'key' => 'city',
					'value' => serialize( array( strval($atts['city_id']) ) ),
					'compare' => 'LIKE',
				),
			);
		}

		$result = new WP_Query($args);
		?>
		<?php if ( $result->have_posts() ) : ?>
			<div class="linked-realty-wrapper">
				<h2><?php _e( 'Realty', 'understrap-child'); ?></h2>
				<div class="row">
					<?php while ( $result->have_posts() ) : $result->the_post(); ?>
						<div class="col-md-4">
							<?php get_template_part( 'loop-templates/content', 'realty' ); ?>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		<?php endif; ?>
		<?php
	return;
} );*/