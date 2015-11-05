<?php
/**
 * Theme Functions
 */

/**
 * Actions & Filters
 */
// add_action( 'init', 'init' );
// add_action( 'admin_init', 'remove_dashboard_widgets' );
add_action( 'wp_enqueue_scripts', 'add_styles' );
add_action( 'wp_enqueue_scripts', 'add_scripts' );
add_action('pre_get_posts', 'modify_home_query');


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
 * This is required for ACF to work when WP is installed in a subdirectory
 */
add_filter('acf/settings/dir', function( $dir ) {
	return site_url() . '/content/plugins/advanced-custom-fields/';
});


/**
 * Disable admin bar
 */
add_filter('show_admin_bar', '__return_false');


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

	// register_post_type

	// register_taxonomy

	// add_rewrite_rule

}


/**
 * Set up CSS
 */
function add_styles() {

	// google webfonts
	// wp_enqueue_style( 'fonts', '//fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic|Open+Sans:300italic,700italic,700,300', false, false, 'all' );

	wp_enqueue_style( 'fonts', '//fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic|Lato:300italic,700italic,700,300', false, false, 'all' );

	// main styles
	// wp_enqueue_style( 'main', site_url() . get_stylesheet_directory_uri() . '/assets/css/main.css', 'fonts', '1.0', 'all' );
	wp_enqueue_style( 'main', site_url() . get_stylesheet_directory_uri() . '/assets/css/main.css', 'fonts', false, 'all' );
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
