<?php

// ADD CSS AND JAVASCRIPT
function pp_setup() {
    // TODO: Change versionnumber for production
    wp_enqueue_style('main', get_stylesheet_uri(), NULL, microtime(), 'all');
}
add_action('wp_enqueue_scripts', 'pp_setup');

// ADD THEME SUPPORT
function pp_init() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search_form'
    ));
}
add_action('after_setup_theme', 'pp_init');