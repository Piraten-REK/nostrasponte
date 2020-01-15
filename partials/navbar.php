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
            <button>Vor Ort</button>
            <ul>
                <!-- <li><a href="<?php echo site_url('stadt/bedburg'); ?>" <?php setActive(is_category('bedburg')); ?>>Bedburg</a></li> -->
                <!-- <li><a href="<?php echo site_url('stadt/bergheim'); ?>" <?php setActive(is_category('bergheim')); ?>>Bergheim</a></li> -->
                <li><a href="<?php echo site_url('stadt/bruehl'); ?>" <?php setActive(is_category('bruehl')); ?>>Brühl</a></li>
                <!-- <li><a href="<?php echo site_url('stadt/elsdorf'); ?>" <?php setActive(is_category('elsdorf')); ?>>Elsdorf</a></li> -->
                <li><a href="<?php echo site_url('stadt/erftstadt'); ?>" <?php setActive(is_category('erftstadt')); ?>>Erftstadt</a></li>
                <li><a href="<?php echo site_url('stadt/frechen'); ?>" <?php setActive(is_category('frechen')); ?>>Frechen</a></li>
                <!-- <li><a href="<?php echo site_url('stadt/huerth'); ?>" <?php setActive(is_category('huerth')); ?>>Hürth</a></li> -->
                <li><a href="<?php echo site_url('stadt/kerpen'); ?>" <?php setActive(is_category('kerpen')); ?>>Kerpen</a></li>
                <!-- <li><a href="<?php echo site_url('stadt/pulheim'); ?>" <?php setActive(is_category('pulheim')); ?>>Pulheim</a></li> -->
                <!-- <li><a href="<?php echo site_url('stadt/wesseling'); ?>" <?php setActive(is_category('wesseling')); ?>>Wesseling</a></li> -->
            </ul>
        </li><li <?php setActive(checkPages(array('standpunkte', 'vorstand', 'piraten'))); ?>> <!-- Partei -->
            <button>Politik</button>
            <ul>
                <li><a href="<?php echo site_url('wer-wir-sind'); ?>" <?php setActive(is_page('wer-wir-sind')); ?>>Warum?</a></li>
                <?php /* <li><a href="<?php echo site_url('vorstand'); ?>" <?php setActive(is_page('vorstand')); ?>>Wahlprogramm</a></li> */ ?>
                <!-- <li><a href="<?php echo site_url('piraten'); ?>" <?php setActive(is_page('piraten')); ?>>Piraten im Kreis</a></li> -->
            </ul>
        </li><li <?php setActive(get_post_type() === 'calendar' || is_post_type_archive('calendar') || is_page('spenden')) ?>>
            <button>Mitmachen</button>
            <ul>
                <li><a href="<?php echo site_url('termine') ?>" <?php setActive(is_page('termine')) ?>>Triff uns!</a></li>
                <li><a href="https://mitglieder.piratenpartei.de" target="_blank">Werde Pirat!</a></li>
                <li><a href="<?php echo site_url('spenden') ?>" <?php setActive(is_page('spenden')) ?>>Spenden</a></li>
                <li><a href="<?php echo site_url('kontakt') ?>" <?php setActive(is_page('kontakt')) ?>>Kontakt</a></li>
                <hr>
                <li><a href="<?php echo site_url('leitfaden') ?>" <?php setActive(is_page('leitfaden')) ?>>Leitfaden für neue Piraten</a></li>
                <li><a href="<?php echo site_url('werkzeugkasten') ?>" <?php setActive(is_page('werkzeugkasten')) ?>>Werkzeugkasten</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div id="nav_helper"></div>