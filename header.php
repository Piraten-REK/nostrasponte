<!DOCTYPE html>
<html <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=dege">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header px-2 py-1 px-md-4 px-lg-6 container">
	<a href="<?php echo is_front_page() ? '#' : get_home_url(); ?>" class="site-header__logo"><img class="site-header__logo__img" src="<?php echo get_theme_file_uri('/assets/img/logo.svg'); ?>" alt="Piraten Rhein-Erft-Kreis"></a>
	<button class="site-header__menu-button site-header__menu-button--closed" id="nav__toggle">
		<span class="site-header__menu-button__bar"></span>
		<span class="site-header__menu-button__bar"></span>
		<span class="site-header__menu-button__bar"></span>
	</button>
    <?php get_template_part( 'partials/nav' ) ?>
</header>
<div class="main-wrapper container">