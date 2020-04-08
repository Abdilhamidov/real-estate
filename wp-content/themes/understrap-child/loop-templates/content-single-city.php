<?php
/**
 * Partial template for content for city
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class("my-2"); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">
		<?php the_title( '<h3 class="entry-title"><a href="'. get_permalink($post->ID) .'">', '</a></h3>' ); ?>
	</header><!-- .entry-header -->
	<p>
		<div class="h-from-w ratio-4x3">
			<div class="ratio-content">
				<a href="<?php echo get_permalink($post->ID); ?>">
					<?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?>
				</a>
			</div>
		</div>
	</p>
	<div class="entry-content">
		<p>
		<?php 
			the_content();
		?>
		</p>
		
		<!--  Связанная недвижимость  -->
		<?php 
		$args = array(
			'post_status' => 'publish',
			'orderby' => 'date',
			'post_type' => 'realty',
			'posts_per_page' => 10,
			'order' => 'DESC',
			'meta_query' => array(
				array(
					'key' => 'city',
					'value' => serialize( array( strval($post->ID) ) ),
					'compare' => 'LIKE',
				),
			),
		); 
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
		<!--  Связанная недвижимость  -->

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			)
		);
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
