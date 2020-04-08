<?php

function ns_customize_register( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_setting('ns_doctitle_separator', [
		'default' => '-'
	]);

	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ns_doctitle_separator', [
			'label' => 'Titel-Trennzeichen',
			'description' => 'Zeichen welches den Titel der Website vom Titel der Webpage oder der Website-Beschreibung trennt',
			'section' => 'title_tagline',
			'settings' => 'ns_doctitle_separator',
			'type' => 'text'
		])
	);
}

function ns_change_doctitle_separator($defaultSeparator) {
	return get_theme_mod('ns_doctitle_separator') ? get_theme_mod('ns_doctitle_separator') : $defaultSeparator;
}