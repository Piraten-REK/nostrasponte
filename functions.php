<?php

// Setup
define('NOSTRASPONTE_DEV_MODE', true);

// Inlcudes
include(get_theme_file_path('/includes/front/enqueue.php'));
include(get_theme_file_path('/includes/setup.php'));
include(get_theme_file_path('/includes/primary-nav-walker.php'));
include(get_theme_file_path('/includes/widgets.php'));

// Hooks
add_action('wp_enqueue_scripts', 'ns_enqueue');
add_action('after_setup_theme', 'ns_setup_theme');
add_action('widgets_init', 'ns_widgets');