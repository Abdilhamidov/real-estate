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
		<?php echo do_shortcode('[linked-realties limit="10" city_id="'.$post->ID.'"]'); ?>
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
