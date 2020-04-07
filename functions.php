<?php

// Setup
define('NOSTRASPONTE_DEV_MODE', true);

// Inlcudes
include(get_theme_file_path('/includes/front/enqueue.php'));
include(get_theme_file_path('/includes/setup.php'));

// Hooks
add_action('wp_enqueue_scripts', 'ns_enqueue');
add_action('after_setup_theme', 'ns_setup_theme');
