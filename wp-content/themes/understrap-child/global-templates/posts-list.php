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

<!-- 16:9 (отношение между шириной и высотой) -->
<div class="item-responsive item-16by9">
  <div class="content"></div>
</div>

<div class="container posts-list-widget">
	<div class="row">

		<?php while ( $result->have_posts() ) : $result->the_post(); ?>

			<div class="col-md-4">
				<?php get_template_part( 'loop-templates/content', 'realty' ); ?>
			</div>

		<?php endwhile; wp_reset_postdata(); ?>

	</div>
</div>
