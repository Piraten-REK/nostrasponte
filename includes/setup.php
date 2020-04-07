<?php

function ns_setup_theme() {
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('html5', ['search-form', 'gallery', 'caption']);
}
