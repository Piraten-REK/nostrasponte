<?php

function ns_widgets() {
	register_sidebar([
		'name' => 'Sidebar',
		'id' => 'ns_sidebar',
		'description' => 'Sidebar für das Theme Nostra Sponte',
		'before_widget' => '<article id="%1$s" class="widget %2$s">',
		'after_widget' => '</article>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	]);
}