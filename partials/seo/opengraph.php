<meta property="og:locale" content="de_DE">
<meta property="og:locale:alternate" content="en_US">
<meta property="og:locale:alternate" content="en_GB">
<meta property="og:site_name" content="<?php bloginfo('title'); ?>">
<?php if (is_single() === 'post') {
	while (have_posts()) {
		the_post();
		?>
		<meta property="og:title" content="<?php the_title(); ?>">
		<meta property="og:type" content="article">
		<meta property="og:article:published_time" content="<?php echo get_post_time('Y-m-d\TH:i:s+00:00', true); ?>">
		<meta property="og:article:author:username" content="<?php the_author_meta('nickname'); ?>">
		<?php if (get_the_author_meta('first_name') !== null): ?><meta property="og:article:author:first_name" content="<?php the_author_meta('first_name') ?>"><?php endif; ?>
		<?php if (get_the_author_meta('last_name') !== null): ?><meta property="og:article:author:last_name" content="<?php get_the_author_meta('last_name') ?>"><?php endif; ?>
		<?php if (has_category()) {
			foreach ( get_the_category() as $cat ) { ?>
				<meta property="og:article:section" name="<?php echo $cat->name; ?>">
				<?php
			}
		}?>
		<?php if (has_tag()) {
			foreach (get_the_tags() as $tag) { ?>
				<meta property="og:article:tag" content="<?php echo $tag->name; ?>">
				<?php
			}
		} ?>
		<?php
		if (has_post_thumbnail() || has_site_icon()) {
			$url = has_post_thumbnail() ? get_the_post_thumbnail_url('full') : (has_site_icon() ? get_site_icon_url() : null);
			if ($url[4] === 's') { ?>
				<meta property="og:image:url" content="<?php echo str_replace('https://', 'http://', $url); ?>">
				<meta property="og:image:secure_url" name="<?php echo $url; ?>">
			<?php } else { ?>
				<meta property="og:image:url" content="<?php echo $url; ?>">
				<meta property="og:image_secure_url" content="<?php echo str_replace('http://', 'https://', $url); ?>">
				<?php
			}
		} ?>
		<meta property="og:url" content="<?php the_permalink(); ?>">
		<meta property="og:description" content="<?php the_excerpt(); ?>">
		<?php
	}
	wp_reset_postdata();
} else { ?>
	<meta property="og:title" content="<?php bloginfo('title');?>">
	<meta property="og:type" content="website">
	<?php if (has_site_icon()) {
		$url = get_site_icon_url();
		if ($url[4] === 's') { ?>
			<meta property="og:image:url" content="<?php echo str_replace('https://', 'http://', $url); ?>">
			<meta property="og:image:secure_link" content="<?php echo $url; ?>">
			<?php
		} else { ?>
			<meta property="og:image:url" content="<?php echo $url; ?>">
			<meta property="og:image:secure_url" content="<?php echo str_replace('http://', 'https://', $url); ?>">
			<?php
		}
	} ?>
	<meta property="og:url" content="<?php bloginfo('url');?>">
	<meta property="og:description" content="<?php bloginfo('description'); ?>">
	<?php
} ?>
