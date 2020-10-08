<?php
status_header(501);
get_header();
?>
	<main class="pt-6 pt-md-0">
		<section class="error-content px-2 py-8 px-md-4 py-15 px-lg-6">
			<h1 class="error-content__title mb-3 mb-lg-4" lang="en-US">Das hat nicht funktioniert</h1>
			<p class="error-content__text mb-6 mb-lg-12">Die von Dir gesuchte Seite kann nicht angezeigt werden…</p>
			<p class="center"><a href="javascript:window.history.back()" class="btn center"><i class="feather icon-arrow-left"></i> Zurück</a></p>
		</section>
	</main>
    <?php get_sidebar(); ?>
<?php get_footer();