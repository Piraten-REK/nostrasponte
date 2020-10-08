<?php

// Setup
define('NS_DEV_MODE', true);

// Includes
include( get_theme_file_path( '/includes/front/enqueue.php' ) );
include( get_theme_file_path( '/includes/front/js.php' ) );
include( get_theme_file_path( '/includes/setup.php' ) );
include( get_theme_file_path('/includes/custom-nav-walker.php') );
include( get_theme_file_path('/includes/primary-nav-walker.php') );
include( get_theme_file_path('/includes/widgets.php') );

// Hooks
add_action( 'after_setup_theme', 'ns_setup_theme' );
add_action( 'widgets_init', 'ns_widgets' );
add_action( 'wp_enqueue_scripts', 'ns_enqueue' );

add_filter( 'document_title_parts', 'ns_title' );
add_filter( 'document_title_separator', 'ns_title_sep' );
add_filter( 'script_loader_tag', 'ns_defer_js', 10, 3 );

// Shortcodes