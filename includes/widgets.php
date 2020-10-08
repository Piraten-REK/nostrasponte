<?php

function ns_widgets() {
	register_sidebar([
		'name'          => __( 'Nostra Sponte Sidebar', 'nostrasponte' ),
		'id'            => 'ns_sidebar',
		'description'   => __('Sidebar für Nostra Sponte', 'nostra sponte'),
		'class'         => 'site-sidebar',
		'before_widget' => '<section id="%1$s" class="site-sidebar__%2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="section-title">',
		'after_title'   => '</h2>'
	]);
}
