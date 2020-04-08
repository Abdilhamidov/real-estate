<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->
	<p>
		<div class="h-from-w ratio-4x3">
			<div class="ratio-content">
				<?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?>
			</div>
		</div>
	</p>
	<div class="entry-content">

		<?php //the_content(); ?>
		<p>
		<?php 
			$content = apply_filters( 'the_content', $post->post_content ); 
			echo wp_trim_words( $content, 20, '... <a href="'. get_permalink($post->ID) .'" class="more-link"><i class="fas fa-angle-double-right"></i></a>' );
		?>
		</p>
		<?php 
		$fields = get_field_objects();
		if( $fields ): ?>
			<p>
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
						<li class="list-inline-item"><?php echo $fields["label"]; ?>: <?php echo $title; ?></li>
					<?php endforeach; ?>
				</ul>
			</p>
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
