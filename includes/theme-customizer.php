<?php

function ns_customize_register ( WP_Customize_Manager $wp_customize) {

	// Settings
	$wp_customize->add_setting( 'ns-homepage-hero__type', [
		'default'   => 'last_post'
	] );
	$wp_customize->add_setting( 'ns-homepage-hero--page__id', [
		'default'   => null
	] );
	$wp_customize->add_setting( 'ns-homepage-hero--link__url', [
		'default'   => ''
	] );
	$wp_customize->add_setting( 'ns-homepage-hero__title', [
		'default'   => ''
	] );
	$wp_customize->add_setting( 'ns-homepage-hero__text', [
		'default'   => ''
	] );
	$wp_customize->add_setting( 'ns-homepage-hero__image', [
		'default'   => null
	] );
	$wp_customize->add_setting( 'ns-homepage-hero__button-text', [
		'default'   => 'Mehr erfahren'
	] );

	// Section
	$wp_customize->add_section( 'ns-homepage-hero', [
		'title' => __( 'Nostra Sponte Homepage Hero', 'nostrasponte' )
	] );

	// Controllers
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'ns-homepage-hero__type', [
			'priority'  => 1,
			'section'   => 'ns-homepage-hero',
			'label'     => __( 'Hero Typ', 'nostrasponte' ),
			'type'      => 'select',
			'choices'   => [
				'last_post' => __( 'Neuster Post', 'nostrasponte' ),
				'page'      => __( 'Seite', 'nostrasponte' ),
				'link'      => __( 'Benutzerdefinierter Link', 'nostrasponte' )
			]
		]
	) );
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'ns-homepage-hero--page__id', [
			'priority'  => 2,
			'section'   => 'ns-homepage-hero',
			'label'     => __( 'Seite', 'nostrasponte' ),
			'type'      => 'dropdown-pages'
		]
	) );
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'ns-homepage-hero--link__url', [
			'priority'  => 3,
			'section'   => 'ns-homepage-hero',
			'label'     => __( 'URL', 'nostrasponte' ),
			'type'      => 'url'
		]
	) );
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'ns-homepage-hero__title', [
			'priority'      => 4,
			'section'       => 'ns-homepage-hero',
			'label'         => __( 'Titel', 'nostrasponte' ),
			'description'   => __( 'Leer lassen für Post/Page Titel', 'nostrasponte' ),
			'type'          => 'text'
		]
	) );
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'ns-homepage-hero__text', [
			'priority'  => 5,
			'section'   => 'ns-homepage-hero',
			'label'     => __( 'Text', 'nostrasponte' ),
			'type'      => 'textarea'
		]
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'ns-homepage-hero__image', [
			'priority'  => 6,
			'section'   => 'ns-homepage-hero',
			'label'     => __( 'Hintergrundbild', 'nostrasponte' )
		]
	) );
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'ns-homepage-hero__button-text', [
			'priority'  => 7,
			'section'   => 'ns-homepage-hero',
			'label'     => __( 'Button Text', 'nostrasponte' ),
			'type'      => 'text'
		]
	) );
}

function ns_homepage_hero_type () {
	return get_theme_mod( 'ns-homepage-hero__type' ) ? get_theme_mod( 'ns-homepage-hero__type' ) : 'last_post';
}

function ns_homepage_hero_page () {
	return get_theme_mod( 'ns-homepage-hero--page__id' ) ? get_post( intval( get_theme_mod( 'ns-homepage-hero--page__id' ) ) ) : null;
}

function ns_homepage_hero_url ( $echo = true ) {
	$link = '';
	switch ( ns_homepage_hero_type() ) {
		case 'last_post':
			$post = (new WP_Query( [ 'posts_per_page' => 1 ] ))->post;
			$link = get_the_permalink( $post );
			wp_reset_query();
			break;
		case 'page':
			$link = get_the_permalink( ns_homepage_hero_page() );
			break;
		default:
			$link = get_theme_mod( 'ns-homepage-hero--link__url' ) ? get_theme_mod( 'ns-homepage-hero--link__url' ) : get_home_url();
	}
	if ( $echo ) echo esc_url($link);
	else return $link;
}

function ns_homepage_hero_title ( $echo = true ) {
	$title = get_theme_mod( 'ns-homepage-hero__title' ) ? get_theme_mod( 'ns-homepage-hero__title' ) : '';
	if ( $title === '' && ns_homepage_hero_type() === 'last_post' ) {
		$query = new WP_Query( [ 'posts_per_page' => 1 ] );
		$title = get_the_title( $query->post );
		wp_reset_query();
	}
	elseif ( $title === '' && ns_homepage_hero_type() === 'page' ) $title = get_the_title( ns_homepage_hero_page() );

	if ( $echo ) echo esc_html($title);
	else return $title;
}

function ns_homepage_hero_text ( $echo = true ) {
	$text = get_theme_mod( 'ns-homepage-hero__text' ) ? get_theme_mod( 'ns-homepage-hero__text' ) : '';
	if ( $text === '' && ns_homepage_hero_type() === 'last_post' ) {
		$query = new WP_Query( [ 'posts_per_page' => 1 ] );
		$text = wp_trim_words(get_the_excerpt( $query->post ), 12, '…');
		wp_reset_query();
	}
	else if ( $text === '' && ns_homepage_hero_type() === 'page' ) $title = get_the_excerpt( ns_homepage_hero_page() );

	if ( $echo ) echo esc_html($text);
	else return $text;
}

function ns_homepage_hero_image ( $echo = true ) {
	$image = get_theme_mod( 'ns-homepage-hero__image' ) ? get_theme_mod( 'ns-homepage-hero__image' ) : null;
	if ( empty($image) && ns_homepage_hero_type() === 'last_post' ) {
		$query = new WP_Query( [ 'posts_per_page' => 1 ] );
		if (has_post_thumbnail( $query->post )) $image = get_the_post_thumbnail_url( $query->post );
		wp_reset_query();
	}
	else if ( empty($image) && ns_homepage_hero_type() === 'page' && has_post_thumbnail( ns_homepage_hero_page() ) ) $iamge = get_the_post_thumbnail_url( ns_homepage_hero_page() );

	if ( $echo ) echo esc_url($image);
	else return $image;
}

function ns_homepage_hero_button ( $echo = true ) {
	$btn = get_theme_mod( 'ns-homepage-hero__button-text' ) ? get_theme_mod( 'ns-homepage-hero__button-text' ) : 'Mehr erfahren';

	if ( $echo ) echo esc_html($btn);
	else return $btn;
}