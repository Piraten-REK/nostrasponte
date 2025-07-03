<?php

function ns_enqueue () {
	$uri = get_theme_file_uri();
	$ver = NS_DEV_MODE ? time() : false;

	wp_register_style( 'ns_main', $uri . '/assets/css/app.css', [], $ver );
	wp_enqueue_style('ns_main');

  wp_register_style('pprek_wahlprogramm', $uri . '/assets/css/wahlprogramm.css', [], $ver);
  if (get_page_template_slug() === 'page_program-kerpen.php' || get_page_template_slug() === 'page_program-alessa.php')
    wp_enqueue_style('pprek_wahlprogramm');

	wp_register_script('ns_main_js', $uri . '/assets/js/app.js', [], $ver, false);
	wp_enqueue_script('ns_main_js');
}