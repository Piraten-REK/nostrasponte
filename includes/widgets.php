<?php

function ns_widgets() {
	register_sidebar([
		'name'          => __( 'Nostra Sponte Sidebar', 'nostrasponte' ),
		'id'            => 'ns_sidebar',
		'description'   => __('Sidebar für Nostra Sponte', 'nostra sponte'),
		'class'         => 'site-sidebar',
		'before_widget' => '<section id="%1$s" class="site-sidebar__%2$s" role="group">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="section-title">',
		'after_title'   => '</h2>'
	]);

	register_widget( 'NS_Share_Buttons' );
	register_widget('NS_Calendar_Widget');
}

function ns_primary_nav_filter(string $html, stdClass $args) {
	if ($args->theme_location === 'primary') {
		$html = preg_replace('/<nav( class=".+")?>/U', '<nav$1 role="navigation">', $html, 1);
	}
	$html = preg_replace('/<ul( id=".+")?( class=".*")?>/U', '<ul$1$2 role="tree">', $html, 1);                 // Set role to `tree` on parent <ul>
	return $html;
}