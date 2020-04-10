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

function ns_widgets_init() {
	register_widget('Ns_Share_Buttons');
	register_widget('Ns_Article_Tags');
}