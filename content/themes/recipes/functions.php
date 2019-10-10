<?php
/**
 * Theme Functions
 */

define(THEME_VERSION, wp_get_theme()->get('Version'));

/**
 * Actions & Filters
 */
add_action( 'init', 'init' );
// add_action( 'admin_init', 'remove_dashboard_widgets' );
add_action('wp_enqueue_scripts', 'add_styles');
add_action('wp_enqueue_scripts', 'add_scripts');
add_action('pre_get_posts', 'modify_home_query');
add_action('admin_menu', 'change_admin_post_label');


/**
 * Advanced Custom Fields
 */
if (function_exists('acf_register_block_type')) {
	add_action('acf/init', 'register_acf_block_types');
}


/**
 * Remove WP stuff we don't want
 */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
// remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
// remove_filter('the_content_feed', 'wp_staticize_emoji');
// remove_filter('comment_text_rss', 'wp_staticize_emoji');


/**
 * Disable admin bar
 */
// add_filter('show_admin_bar', '__return_false');


/**
 * Theme setup
 */
function setup() {

	/* Disable the admin bar */
	// show_admin_bar(false);

	/* Enable post thumbnails (featured images) */
	// add_theme_support('post-thumbnails');

	/* image sizes */
	// add_image_size( 'name', 240, 240, array('center', 'top') );

	/* Nav Menus */
	// register_nav_menus( array(
	// 	'main' => 'Main Nav',
	// 	'footer_1' => 'Footer - Col 1',
	// 	'footer_2' => 'Footer - Col 2',
	// 	'footer_3' => 'Footer - Col 3'
	// ) );

}


/**
 * Init
 */
function init() {

	// modify post object
	$post_type_object = get_post_type_object('post');

	// change labels to use to 'Recipes' instead of 'Posts'
	$name = 'Recipes';
	$singular_name = 'Recipe';

	// set labels
	$labels = &$post_type_object->labels;
	$labels->name = $name;
	$labels->singular_name = $singular_name;
	$labels->add_new = 'Add New';
	$labels->add_new_item = "Add New $singular_name";
	$labels->edit_item = "Edit $singular_name";
	$labels->new_item = "New $singular_name";
	$labels->view_item = "View $singular_name";
	$labels->search_items = "Search $name";
	$labels->not_found = "No $name found";
	$labels->not_found_in_trash = "$not_found in Trash";
	$labels->all_items = "All $labels->name";
	$labels->menu_name = $name;
	$labels->name_admin_bar = $name;

	$post_type_object->template = array(
		array('acf/ingredients'),
		array('core/freeform'),
	);

	// register_post_type

	// register_taxonomy

	// add_rewrite_rule

}


/**
 * Change 'Posts' to 'Recipes' in WP Admin nav
 */
function change_admin_post_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'Recipes';
	$submenu['edit.php'][5][0] = 'Recipes';
	$submenu['edit.php'][10][0] = 'Add Recipe';
	$submenu['edit.php'][16][0] = 'Tags';
	echo '';
}


/**
 * Set up CSS
 */
function add_styles() {

	// google webfonts
	wp_enqueue_style( 'fonts', '//fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic|Lato:300italic,700italic,700,300', false, false, 'all' );

	// main styles
	wp_enqueue_style( 'main', site_url() . get_stylesheet_directory_uri() . '/assets/css/main.css', 'fonts', THEME_VERSION, 'all' );
}


/**
 * Set up JS
 */
function add_scripts() {

	// jquery
	wp_deregister_script('jquery');
	wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', false, false, true);
	wp_enqueue_script( 'jquery' );

	// main js
	// wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/assets/js/main.js', 'jquery', '1.0', true);
}

function modify_home_query($query) {

	if ( $query->is_home() && $query->is_main_query() ) {
		// $query->set( 'orderby', 'title' );
		$query->set( 'orderby', 'rand' );
		// $query->set( 'order', 'ASC' );
		// $query->set( 'posts_per_page', -1 );
		$query->set( 'posts_per_page', 1 );
	}
}

/**
 * Register custom blocks for ACF
 */
function register_acf_block_types() {

	// ingredients list block
	acf_register_block_type(array(
		'name' => 'ingredients',
		'title' => __('Ingredients'),
		'description' => __('List of ingredients'),
		'render_template' => 'block-ingredients.php',
		'category' => 'formatting',
		'icon' => 'editor-list',
		'keywords' => array('ingredients', 'list'),
		'mode' => 'edit',
		'supports' => array(
			'align' => false,
			'mode' => false,
		),
	));
}

/**
 * Get title for achive template
 */
function get_archive_title() {
	if (is_post_type_archive()) {
		return get_post_type_archive_title('', false) . ' Archive';
	}
	else if (is_tag()) {
		return single_term_title('Tag: ', false);
	}
	else {
		return 'Archive';
	}
}

/**
 * Given an ingredients string, parse the whitespace
 * and use it to build html for the ingredients list
 */
function get_ingredients_html($string, $echo = false) {
	// trim excess whitespace
	$html = trim($string);

	// if first line is followed by blank line, it should be wrapped in an h6 and followed by the start of a list
	if (preg_match('#\A(.*)\r\n\r\n#m', $html, $matches)) {
		$html = str_replace($matches[0], '<h6>' . $matches[1] . '</h6><ul><li>', $html);
	}
	// otherwise, just start with a list
	else {
		$html = '<ul><li>' . $html;
	}
	// close list
	$html .= '</li></ul>';

	// titles (blank lines before and after) should be wrapped in an h6, close previous list, and start a new list
	$html = preg_replace('#\r\n\r\n(.*)\r\n\r\n#m', "</li></ul><h6>$1</h6><ul><li>", $html);

	// regular list items
	$html = str_replace("\r\n", '</li><li>', $html);

	if ($echo) {
		echo $html;
	}
	else {
		return $html;
	}
}

/**
 * Copy ingredients content from old ACF meta field to new ACF block field
 * @param  [integer] $post_id : ID of the post (recipe) to update
 * @param  [boolean] $delete_meta : Whether to delete the old meta field content (default false)
 */
function migrate_acf_ingredients($post_or_id) {

	if (is_int($post_or_id)) {
		$post_id = $post_or_id;
		$post = get_post($post_id);
	}
	else {
		$post = $post_or_id;
		$post_id = $post->ID;
	}

	// ignore other post types
	if (get_post_type($post_id) != 'post') {
		return;
	}

	// field to get
	$field_name = 'ingredients';
	$block_name = 'ingredients';

	// update only if post content does not already have recipe block
	if (!stristr($post->post_content, "<!-- wp:acf/$block_name")) {

		// get field in block format
		$block_content = get_acf_meta_block_format($field_name, $block_name, $post_id);

		// update post content with new block content prepended
		wp_update_post(array(
			'ID' => $post_id,
			'post_content' => wp_slash($block_content) . "\n\n" . $post->post_content,
		));
	}
}


/**
 * Convert ACF meta field data to the ACF block format
 * @param  [string]  $field_name
 * @param  [string]  $block_name
 * @param  [int]     $post_id
 * @return [string]
 */
function get_acf_meta_block_format($field_name, $block_name, $post_id) {

	if (function_exists('get_field_object')) {
		$field = get_field_object($field_name, $post_id);
	}

	$field_data = array(
		$field['key'] => $field['value']
	);

	$block_data = array(
		'name' => "acf/$block_name",
		'data' => $field_data,
	);

	$json_data = json_encode($block_data);

	return "<!-- wp:acf/$block_name $json_data /-->";
}
