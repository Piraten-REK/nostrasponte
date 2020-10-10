<?php

function ns_setup_theme () {
	add_theme_support( 'post_tuhmbnails' );
	add_theme_support( 'atomatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5' );
	add_theme_support( 'custom-logo' );

	register_nav_menu( 'primary', __('Hauptmenü', 'nostrasponte') );
	register_nav_menu( 'footer_social', __('Social Links', 'nostrasponte') );
	register_nav_menu( 'footer_links', __('Footer Links', 'nostrasponte') );
}

function ns_title_sep (string $sep) {
	return '&#x2620;&#xfe0f;';
}

function ns_title (array $title) {
	return [
		'title' => is_404() ? '404' : (is_page_template('default') ? '501' : $title['title']),
		'page' => $title['page'],
		'site' => is_page_template('default') ? get_bloginfo('name') : $title['site'],
	];
}

function ns_current_theme_template (string $template) {
	$GLOBALS['current_theme_template'] = basename($template);
	return $template;
}