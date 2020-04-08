<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site:id" content="1612752534">
<meta name="twitter:title" content="<?php echo mb_strimwidth(wp_get_document_title(), 0, 70, '…') ?>">
<?php
if (is_single()) {
	while (have_posts()) {
		the_post();
		?>
		<meta name="twitter:description" content="<?php echo mb_strimwidth(get_the_excerpt(), 0, 200, '…') ?>">
		<?php if(has_post_thumbnail()): ?><meta name="twitter:image" content="<?php the_post_thumbnail_url('full'); ?>"><?php endif;
	}
} elseif (is_front_page()) { ?>
	<meta name="twitter:description" content="<?php echo mb_strimwidth(get_bloginfo('description'), 0, 200, '…'); ?>">
	<?php if (has_site_icon()) { ?>
		<meta name="twitter:image" content="<?php site_icon_url(); ?>">
		<?php
	}
} ?>
