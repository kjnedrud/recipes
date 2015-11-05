<?php
/**
 * Search template file
 */

get_header(); ?>

<div class="wrap">

	<div class="content">
		<h1>Search Results: <?php echo get_search_query(); ?></h1>
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php endwhile; ?>
		<?php else : ?>
			<p>Sorry, no content was found.</p>
		<?php endif; ?>
	</div><!-- .content -->

	<?php get_sidebar(); ?>

</div><!-- .wrap -->

<?php get_footer(); ?>
