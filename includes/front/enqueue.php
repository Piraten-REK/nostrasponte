<?php

function ns_enqueue() {
	$uri = get_theme_file_uri();
	function ver(string $path) {
		return NOSTRASPONTE_DEV_MODE ? filemtime(get_theme_file_path($path)) : false;
	}

	wp_register_style('main-css', $uri . '/assets/css/main.css', [], ver('/assets/css/main.css'));

	wp_enqueue_style('main-css');

	wp_register_script('main-js', $uri . '/assets/js/main.min.js', [], ver('/assets/js/main.min.js'), true);
	wp_register_script('tetris-js', $uri . '/assets/js/tetris.min.js', [], ver('/assets/js/tetris.min.js'), true);

	wp_enqueue_script('main-js');
	wp_enqueue_script('tetris-js');
}