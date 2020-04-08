</div>
    <footer id="site_footer">
        <div>
            <h3>Social Media</h3>
            <?php if (has_nav_menu('footer_social')) {
                wp_nav_menu([
                    'theme_location' => 'footer_social',
                    'container' => false,
                    'menu_class' => 'no_bullets',
                    'fallback_cb' => false,
                    'depth' => 1
                ]);
            } ?>
        </div>
        <div>
            <h3>Links</h3>
	        <?php if (has_nav_menu('footer_links')) {
		        wp_nav_menu([
			        'theme_location' => 'footer_links',
			        'container' => false,
			        'menu_class' => 'no_bullets',
			        'fallback_cb' => false,
			        'depth' => 1
		        ]);
	        } ?>
        </div>
        <div id="license">
            <a class="no_img" rel="license" target="_blank" href="http://creativecommons.org/licenses/by-nd/4.0/"><img alt="Creative Commons Lizenzvertrag" style="border-width:0" src="<?php echo get_theme_file_uri('/assets/img/cc_by_nd.png') ?>" /></a>
            <p>
                Die Inhalte dieser Seite sind, soweit nicht anders gekennzeichnet, lizensiert unter einer <a rel="license" href="http://creativecommons.org/licenses/by-nd/4.0/">Creative Commons Namensnennung - Keine Bearbeitungen 4.0 International Lizenz</a>.
            </p>
        </div>
        <div id="copyright">
            <span>&copy;&nbsp;<?php echo date('Y'); ?></span>
            <span>Piratenpartei&nbsp;Deutschland Kreisverband&nbsp;Rhein-Erft</span>
        </div>
        <button id="btn_up" title="Nach oben" onclick="window.scrollTo(window.scrollX, 0)"></button>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>