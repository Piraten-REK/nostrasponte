<?php

// Setup
define('NS_DEV_MODE', true);

// Includes
$includes = [
	'setup',
	'custom-nav-walker',
	'primary-nav-walker',
	'widgets',
	'widgets/share-buttons',
	'front/enqueue',
	'front/js'
];
foreach ($includes as $inc) {
	include( get_theme_file_path( "/includes/$inc.php" ) );
}

// Hooks
add_action( 'after_setup_theme', 'ns_setup_theme' );
add_action( 'widgets_init', 'ns_widgets' );
add_action( 'wp_enqueue_scripts', 'ns_enqueue' );

add_filter( 'document_title_parts', 'ns_title' );
add_filter( 'document_title_separator', 'ns_title_sep' );
add_filter( 'script_loader_tag', 'ns_defer_js', 10, 3 );

// Shortcodes