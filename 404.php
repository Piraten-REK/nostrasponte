<?php get_header(); ?>

<header>
    <h2 title="Error 404 - Not Found">404</h2>
</header>
<main>
    <p>Deine angeforderte Seie <span class="pre"><?php echo esc_attr(urldecode($_SERVER['REQUEST_URI'])); ?></span> konnte nicht gefunden werden.</p>
    <a href="javascript:window.history.back()" class="btn no_img" id="btn_back">Zurück</a>
</main>

<?php include('partials/sidebar.php');
get_footer(); ?>