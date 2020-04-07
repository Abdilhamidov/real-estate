<?php
/**
 * Last Posts List
 *
 * @package understrap-child
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$result = get_query_var('result');

// fppr($result, __FILE__.' $result');

?>


<div class="wrapper" id="wrapper-posts-list">

	<?php //get_template_part( 'sidebar-templates/sidebar', 'hero' ); ?>

	<?php while ( $result->have_posts() ) : $result->the_post(); ?>

		<?php get_template_part( 'loop-templates/content', 'page' ); ?>

	<?php endwhile; wp_reset_postdata(); ?>

</div>
