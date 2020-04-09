<div id="site_nav_toggle"><span></span></div>
<nav id="site_nav">
    <?php
    get_search_form();
    if (has_nav_menu('primary')) {
        wp_nav_menu([
            'theme_location' => 'primary',
            'container' => false,
            'fallback_cb' => false,
            'depth' => 2,
            'walker' => new NS_Primary_Nav_Walker()
        ]);
    }

    ?>
</nav>
<div id="nav_helper"></div>