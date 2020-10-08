<?php

if (has_nav_menu('primary')) {
    wp_nav_menu([
        'theme_location'    => 'primary',
        'container'         => 'nav',
        'container_class'   => 'site-header__navigation px-2 py-4 px-md-4',
        'menu_class'        => '',
        'menu_id'           => '',
        'fallback_cb'       => NS_Primary_Nav_Walker::fallback(),
        'depth'             => 2,
        'walker'            => new NS_Primary_Nav_Walker()
    ]);
}
