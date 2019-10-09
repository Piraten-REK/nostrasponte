<?php

// ADD CSS AND JAVASCRIPT
function pp_setup() {
    // TODO: Change versionnumber for production
    wp_enqueue_style('main', get_stylesheet_uri(), NULL, microtime(), 'all');
    wp_enqueue_script('main-js', get_theme_file_uri('js/main.js'), NULL, microtime(), true);
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

// ADD CALENDAR POST TYPE
function pp_calender_post_type() {
    register_post_type('calendar', array(
        'rewrite' => array( 'slug' => 'termine' ),
        'labels' => array(
            'name' => 'Termine',
            'singular_name' => 'Termin',
            'add_new_item' => 'Neuen Termin hinzufügen',
            'edit_item' => 'Termin bearbeiten'
        ),
        'menu_icon' => 'dashicons-calendar-alt',
        'public' => true,
        'has_archive' => true,
        'supports' => array( 'title', 'thumbnail', 'editor', 'custom-fields' )
    ));
    flush_rewrite_rules(false);
}
add_action('init', 'pp_calender_post_type');
flush_rewrite_rules(false);

// // ADD PROTOCOL POST TYPE
function pp_protocol_post_type() {
    register_post_type('protocol', array(
        'rewrite' => array( 'slug' => 'protokolle' ),
        'labels' => array(
            'name' => 'Protokolle',
            'singular_name' => 'Protokoll',
            'add_new_item' => 'Protokoll anlegen',
            'edit_item' => 'Protokoll überarbeiten'
        ),
        'menu_icon' => 'dashicons-clipboard',
        'public' => true,
        'has_archive' => true,
        'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'revision' )
    ));
    flush_rewrite_rules(false);
}
add_action('init', 'pp_protocol_post_type');