<!doctype html>
<html lang="de_DE" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
    
    <!-- TWITTER SEO -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site:id" content="1612752534">
    <?php if (get_post_type() === 'post') { while(have_posts()) { the_post(); ?><meta name="twitter:description" content="<?php echo mb_strimwidth(get_the_excerpt(), 0, 200, '…'); ?>">
    <meta name="twitter:title" content="<?php echo mb_strimwidth(get_the_title(), 0, 70, '…'); ?>">
    <?php if (has_post_thumbnail()) { ?><meta name="twitter:image" content="<?php the_post_thumbnail_url(); ?>">
    <?php } } } elseif (is_front_page()) { ?><meta name="twitter:description" content="<?php echo mb_strimwidth(get_bloginfo('description'), 0, 200, '…'); ?>">
    <meta name="twitter:title" content="<?php echo mb_strimwidth(get_bloginfo('title'), 0, 70, '…'); ?>">
    <?php if (has_site_icon()) { ?><meta name="twitter:image" content="<?php site_icon_url(); ?>"><?php } } ?>

    <!-- OGP SEO -->
    <meta property="og:locale" content="de_DE">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:locale:alternate" content="en_GB">
    <meta property="og:site_name" content="<?php bloginfo('title'); ?>">
    <?php if (get_post_type() === 'post') { while (have_posts()) { the_post(); ?><meta property="og:title" content="<?php the_title(); ?>">
    <meta property="og:type" content="article">
    <meta property="og:article:published_time" content="<?php echo get_post_time('Y-m-d\TH:i:s+00:00', true); ?>">
    <meta property="og:article:author:username" content="<?php the_author_nickname(); ?>">
    <?php if (get_the_author_firstname() !== null) { ?><meta property="og:article:author:first_name" content="<?php the_author_firstname() ?>"><?php } ?>
    <?php if (get_the_author_lastname() !== null) { ?><meta property="og:article:author:last_name" content="<?php get_the_author_lastname() ?>"><?php } ?>
    <?php if (has_category()) { ?><meta property="og:article:section" name="<?php get_the_category()[0]->name; ?>"><?php } ?>
    <?php if (has_tag()) { foreach (get_the_tags() as $tag) { ?><meta property="og:article:tag" content="<?php echo $tag->name; ?>"><?php } } ?>
    <?php if (has_post_thumbnail() || has_site_icon()) { $url = has_post_thumbnail() ? get_the_post_thumbnail_url() : (has_site_icon() ? get_site_icon_url() : null); if (url[4] === 's') { // secure link ?><meta property="og:image:url" content="<?php echo str_replace('https://', 'http://', $url); ?>">
    <meta property="og:image:secure_url" name="<?php echo $url; ?>">
    <?php } else { ?><meta property="og:image:url" content="<?php echo $url; ?>">
    <meta property="og:image_secure_url" content="<?php echo str_replace('http://', 'https://', $url); ?>"><?php } } ?>
    <meta property="og:url" content="<?php the_permalink(); ?>">
    <meta property="og:description" content="<?php the_excerpt(); ?>">
    <?php } } else { ?><meta property="og:title" content="<?php bloginfo('title');?>">
    <meta property="og:type" content="website">
    <?php if (has_site_icon()) { $url = get_site_icon_url(); if (url[4] === 's') { //secure link ?><meta property="og:image:url" content="<?php echo str_replace('https://', 'http://', $url); ?>">
    <meta property="og:image:secure_link" content="<?php echo $url; ?>">
    <?php } else { ?><meta property="og:image:url" content="<?php echo $url; ?>">
    <meta property="og:image:secure_url" content="<?php echo str_replace('http://', 'https://', $url); ?>"><?php } } ?>
    <meta property="og:url" content="<?php bloginfo('url');?>">
    <meta property="og:description" content="<?php bloginfo('description'); ?>"><?php } ?>
</head>
<body class="<?php echo get_post_type(); if (is_admin_bar_showing()) { echo ' admin'; } ?>">
    <header id="site_header">
        <a href="<?php echo is_front_page() ? '#' : site_url(''); ?>"><img src="<?php echo get_theme_file_uri('/img/logotype_black.svg'); ?>" alt="<?php echo bloginfo('title'); ?>"></a>
        <?php // NAVBAR ?>
    </header>
    <div id="container">