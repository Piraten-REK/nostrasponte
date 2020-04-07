<?php

function ns_enqueue() {
	$uri = get_theme_file_uri();
	$ver = NOSTRASPONTE_DEV_MODE ? time() : false;

	wp_register_style('main-css', $uri . '/assets/css/main.css', [], $ver);

	wp_enqueue_style('main-css');

	wp_register_script('main-js', $uri . '/assets/js/main.min.js', [], $ver, true);
	wp_register_script('tetris', $uri . '/assets/js/tetris.min.js', [], $ver, true);

	wp_enqueue_script('main-js');
	wp_enqueue_script('tetris-js');

//	wp_enqueue_style('main', get_stylesheet_uri(), null, $ver , 'all');
//	wp_enqueue_script('main-js', get_theme_file_uri('js/main.min.js'), NULL, microtime(), true);
//	wp_enqueue_script('tetris-js', get_theme_file_uri('js/tetris.min.js'), NULL, microtime(), true);
}