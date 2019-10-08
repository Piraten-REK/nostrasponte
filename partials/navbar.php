<?php

function setActive($predicate) {
    if ($predicate) echo 'class="active"';
}
function checkPages($arr) {
    foreach ($arr as $pageName)
        if (is_page($pageName)) return true;
    return false;
}

?>
<div id="site_nav_toggle"><span></span></div>
<nav id="site_nav">
    <ul>
        <li <?php setActive(is_front_page()); ?>> <!-- Home -->
            <a href="<?php echo is_front_page() ? '#' : site_url(''); ?>">Home</a>
        </li><li <?php setActive(get_post_type() === 'post' || is_post_type_archive('post')); ?>> <!-- Aktuelles -->
            <button>Aktuelles</button>
            <ul>
                <li><a href="<?php echo site_url('blog'); ?>" <?php setActive(get_post_type() === 'post' || is_post_type_archive('post')); ?>>Unsere Arbeit</a></li>
                <hr>
                <li><a href="<?php echo site_url('ort/bedburg'); ?>" <?php setActive(is_category('bedburg')); ?>>Bedburg</a></li>
                <li><a href="<?php echo site_url('ort/bergheim'); ?>" <?php setActive(is_category('bergheim')); ?>>Bergheim</a></li>
                <li><a href="<?php echo site_url('ort/bruehl'); ?>" <?php setActive(is_category('bruehl')); ?>>Brühl</a></li>
                <li><a href="<?php echo site_url('ort/elsdorf'); ?>" <?php setActive(is_category('elsdorf')); ?>>Elsdorf</a></li>
                <li><a href="<?php echo site_url('ort/erftstadt'); ?>" <?php setActive(is_category('erftstadt')); ?>>Erftstadt</a></li>
                <li><a href="<?php echo site_url('ort/frechen'); ?>" <?php setActive(is_category('frechen')); ?>>Frechen</a></li>
                <li><a href="<?php echo site_url('ort/huerth'); ?>" <?php setActive(is_category('huerth')); ?>>Hürth</a></li>
                <li><a href="<?php echo site_url('ort/kerpen'); ?>" <?php setActive(is_category('kerpen')); ?>>Kerpen</a></li>
                <li><a href="<?php echo site_url('ort/pulheim'); ?>" <?php setActive(is_category('pulheim')); ?>>Pulheim</a></li>
                <li><a href="<?php echo site_url('ort/wesseling'); ?>" <?php setActive(is_category('wesseling')); ?>>Wesseling</a></li>
            </ul>
        </li><li <?php setActive(checkPages(array('standpunkte', 'vorstand', 'piraten'))); ?>> <!-- Partei -->
            <button>Partei</button>
            <ul>
                <li><a href="<?php echo site_url('standpunkte'); ?>" <?php setActive(is_page('standpunkte')); ?>>Standpunkte</a></li>
                <li><a href="<?php echo site_url('vorstand'); ?>" <?php setActive(is_page('vorstand')); ?>>Kreisvorstand</a></li>
                <li><a href="<?php echo site_url('piraten'); ?>" <?php setActive(is_page('piraten')); ?>>Piraten im Kreis</a></li>
            </ul>
        </li><li <?php setActive(get_post_type() === 'calendar' || is_post_type_archive('calendar') || is_page('spenden')) ?>>
            <button>Mitmachen</button>
            <ul>
                <li><a href="https://mitglieder.piratenpartei.de">Werde Pirat!</a></li>
                <li><a href="<?php echo site_url('termine') ?>" <?php setActive(is_page('termine')) ?>>Triff uns!</a></li>
                <li><a href="<?php echo site_url('spenden') ?>" <?php setActive(is_page('spenden')) ?>>Spenden</a></li>
            </ul>
    </ul>
</nav>
<div id="nav_helper"></div>