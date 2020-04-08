<!doctype html>
<html <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
    wp_head();
    get_template_part('partials/seo/twitter');
    get_template_part('partials/seo/opengraph');
    ?>


</head>
<body <?php body_class(); ?>>
    <header id="site_header">
        <h1><a href="<?php echo is_front_page() ? '#' : site_url(''); ?>"><img src="<?php echo get_theme_file_uri('/assets/img/logotype_black.svg'); ?>" alt="<?php bloginfo('title'); ?>"></a></h1>
        <?php get_template_part('partials/navbar'); ?>
    </header>
    <div id="container">