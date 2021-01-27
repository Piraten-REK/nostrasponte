<?php

// Setup
define('NS_DEV_MODE', true);

// Includes
$includes = [
	'helpers',
	'setup',
	'custom-nav-walker',
	'primary-nav-walker',
	'theme-customizer',
	'widgets',
	'widgets/share-buttons',
	'widgets/calendar',
	'front/enqueue',
	'front/js'
];
foreach ($includes as $inc) {
	include( get_theme_file_path( "/includes/$inc.php" ) );
}

// Hooks
add_action( 'after_setup_theme', 'ns_setup_theme' );
add_action( 'customize_register', 'ns_customize_register' );
add_action( 'widgets_init', 'ns_widgets' );
add_action( 'wp_enqueue_scripts', 'ns_enqueue' );

add_filter( 'document_title_parts', 'ns_title' );
add_filter( 'document_title_separator', 'ns_title_sep' );
add_filter( 'script_loader_tag', 'ns_defer_js', 10, 3 );
add_filter( 'template_include', 'ns_current_theme_template', 1000 );
add_filter( 'wp_nav_menu', 'ns_primary_nav_filter', 10, 2 );

// Shortcodes