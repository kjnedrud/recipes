<?php
/**
 * Sidebar
 */

$all_recipes = new WP_Query(array(
	'orderby' => 'title',
	'order' => 'ASC',
	'posts_per_page' => -1
));

?>

<div class="sidebar">

	<section class="section">
		<h6>All Tags</h6>
		<?php wp_tag_cloud(); ?>
	</section>

	<section class="section">
		<h6>All Recipes</h6>
		<ul>
			<?php while($all_recipes->have_posts()) : $all_recipes->the_post(); ?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endwhile; wp_reset_postdata(); ?>
		</ul>
	</section>

</div><!-- .sidebar -->
