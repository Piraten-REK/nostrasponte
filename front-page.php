<?php get_header(); ?>
<main class="pt-6 pt-md-0">
	<p>FRONT</p>
    <pre>
        CUR_TEMPLATE: <?php var_dump($GLOBALS['current_theme_template']); ?>
    </pre>
</main>
<?php get_sidebar(); ?>
<?php get_footer();