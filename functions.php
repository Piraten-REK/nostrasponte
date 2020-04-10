<?php

// Setup
define('NOSTRASPONTE_DEV_MODE', true);

// Inlcudes
include(get_theme_file_path('/includes/front/enqueue.php'));
include(get_theme_file_path('/includes/setup.php'));
include(get_theme_file_path('/includes/primary-nav-walker.php'));
include(get_theme_file_path('/includes/widgets.php'));
include(get_theme_file_path('/includes/theme-customizer.php'));
include(get_theme_file_path('./includes/widgets/share-buttons.php'));
include(get_theme_file_path('./includes/widgets/article-tags.php'));

// Hooks
add_action('wp_enqueue_scripts', 'ns_enqueue');
add_action('after_setup_theme', 'ns_setup_theme');
add_action('widgets_init', 'ns_widgets');
add_action('customize_register', 'ns_customize_register');
add_action('widgets_init', 'ns_widgets_init');

add_filter('document_title_separator', 'ns_change_doctitle_separator');