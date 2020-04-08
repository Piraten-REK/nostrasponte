<?php

function ns_setup_theme() {
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('html5');

	register_nav_menu('primary', 'Primäres Menü');
	register_nav_menu('footer_social', 'Social Media');
	register_nav_menu('footer_links', 'Footer Links');
}
