<?php
/**
 * Install wp-cli and then run:
 * wp eval-file migrate-acf-ingredients.php
 */

if (function_exists('migrate_acf_ingredients')) {

	echo "Migrating ACF ingrdients:\n";

	$posts = get_posts(array(
		'numberposts' => -1,
		'post_status' => array('publish', 'draft', 'pending'),
	));

	foreach($posts as $post) {
		echo "Post ID $post->ID\n";
		migrate_acf_ingredients($post);
	}
}
