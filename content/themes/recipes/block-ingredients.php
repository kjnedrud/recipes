<?php
/**
 * Custom Block: Ingredients
 */
?>
<?php if (function_exists('get_field')) : ?>
	<?php
		$ingredients = get_field('ingredients');
	?>
	<div class="ingredients">
		<?php if (!empty($ingredients)) : ?>
			<?php get_ingredients_html($ingredients, true); ?>
		<?php else : ?>
			<i class="placeholder">Add some ingredients</i>
		<?php endif; ?>
	</div>
<?php endif; ?>
