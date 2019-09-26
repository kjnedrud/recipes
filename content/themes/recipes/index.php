<?php
/**
 * Main template file
 */

get_header(); ?>

<div class="wrap">

	<div class="content">
		<?php while(have_posts()) : the_post(); ?>
			<?php if(is_front_page() || is_singular()) : ?>
				<header class="recipe-header">
					<h1><?php the_title(); ?></h1>
					<div class="recipe-info">
						<?php echo get_the_tag_list('', ' ', ''); ?><?php edit_post_link('Edit', ' | '); ?>
					</div>
				</header>
				<?php if (function_exists('get_field')) {
					$ingredients = get_field('ingredients');
						if (!empty($ingredients)) {
							echo get_ingredients_html($ingredients);
						}
				} ?>
				<div class="recipe"><?php the_content(); ?></div>
			<?php else : ?>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php endif; ?>
		<?php endwhile; ?>
	</div><!-- .content -->

	<?php get_sidebar(); ?>

</div><!-- .wrap -->

<?php get_footer(); ?>
