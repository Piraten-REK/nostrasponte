<?php

function ns_enqueue () {
	$uri = get_theme_file_uri();
	$ver = NS_DEV_MODE ? time() : false;

	wp_register_style( 'ns_main', $uri . '/assets/css/app.css' );

	wp_enqueue_style('ns_main');

	wp_register_script('ns_main_js', $uri . '/assets/js/app.js', [], $ver, false);
	wp_enqueue_script('ns_main_js');
}