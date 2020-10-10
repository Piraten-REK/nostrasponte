</div>
<footer class="site-footer px-2 pt-5 pb-6 px-md-4 py-md-8 px-lg-6 py-lg-10 container" role="contentinfo">
	<div class="site-footer__social mb-6 mb-md-0">
		<h2 class="mb-2 mb-lg-3">Social Media</h2>
		<?php wp_nav_menu([
			'theme_location'    => 'footer_social',
			'container'         => false,
			'menu_class'        => 'mb-0',
			'fallback_cb'       => false,
			'depth'             => 1,
			'walker'            => new NS_Custom_Nav_Walker()
		]); ?>
	</div>
	<div class="site-footer__links mb-4 mb-md-0">
		<h2 class="mb-2 mb-lg-3">Links</h2>
        <?php wp_nav_menu([
	        'theme_location'    => 'footer_links',
	        'container'         => false,
	        'menu_class'        => 'mb-0',
	        'fallback_cb'       => false,
	        'depth'             => 1,
	        'walker'            => new NS_Custom_Nav_Walker()
        ]); ?>
	</div>
	<hr>
	<div class="site-footer__license">
		<img src="<?php echo get_theme_file_uri('/assets/img/cc_by.png'); ?>" alt="(CC) BY" class="mb-1 mb-lg-3">
		<p class="mb-3">Die Inhalte dieser Seite sind, soweit nicht anders gekennzeichnet, lizenziert unter einer <a href="https://creativecommons.org/licenses/by/4.0/deed.de" target="_blank" class="site-footer__license__link" rel="license">Creative Commons Namensnennung 4.0 International</a> Lizenz.</p>
		<p class="site-footer__license__copy mb-0">
			<span>&copy;&nbsp;<?php echo date('Y'); ?></span>
			<span>Piratenpartei&nbsp;Deutschland</span>
			<span>Kreisverband&nbsp;<span class="nobr">Rhein-Erft</span></span>
		</p>
	</div>
	<button id="back-to-top" class="back-to-top" title="Zurück nach oben"><i class="feather icon-arrow-up"></i></button>
</footer>
<div class="site-header__navigation__darkener"></div>
<?php wp_footer(); ?>
</body>
</html>