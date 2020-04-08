<?php
/**
 * Last Posts List
 *
 * @package understrap-child
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$attr = get_query_var('attr');
$result = $attr["wp_query_result"];
// fppr($attr, __FILE__.' $attr');
?>
<?php if($result->have_posts()): ?>
<div class="container posts-list-widget">
	<h2 class="text-center text-uppercase"><?php echo $attr["title"] ?></h2>
	<div class="row">
		<?php while ( $result->have_posts() ) : $result->the_post(); ?>
			<div class="col-md-4">
				<?php get_template_part( 'loop-templates/content', 'realty' ); ?>
			</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
	<div class="text-center mt-3">
		<a href="/<?php echo $result->query["post_type"]; ?>/" class="btn btn-primary "><?php _e( 'Show All', 'understrap-child' ) ?></a>
	</div>
</div>
<?php endif; ?>
