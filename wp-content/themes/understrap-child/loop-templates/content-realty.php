<?php
/**
 * Partial template for content for realty
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
					<?php if( $post_thumbnail = get_the_post_thumbnail( $post->ID, 'medium' ) ) :
						echo $post_thumbnail; ?>
					<?php else: ?>
						<img src="https://via.placeholder.com/342x257.jpg" alt="">
					<?php endif; ?>
				</a>
			</div>
		</div>
	</p>
	<div class="entry-content">
		<p>
		<?php 
			$content = apply_filters( 'the_content', $post->post_content ); 
			echo wp_trim_words( $content, 18, '... <a href="'. get_permalink($post->ID) .'" class="more-link"><i class="fas fa-angle-double-right"></i></a>' );
		?>
		</p>
		<?php 
		$fields = get_field_objects();
		if( $fields ): ?>
			<ul class="list-inline">
				<?php foreach( $fields as $name => $fields ): ?>
					<?php switch ($name) {
					 	case 'city':
					 		$title = $fields["value"][0]->post_title;
					 		break;
					 	default:
					 		$title = $fields["value"];
					 		break;
					 } ?>
					<li class="list-inline-item d-block"><small><?php echo $fields["label"]; ?>: <?php echo $title; ?></small></li>
				<?php endforeach; ?>
			</ul>
		<?php endif;
		?>
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
