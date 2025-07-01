<?php
get_header();
$cat = get_queried_object();
$allowed_html = [
    'strong'    => [],
    'em'        => [],
    'ins'       => [],
    'del'       => [],
    'b'         => [],
    'i'         => [],
    'br'        => [],
    'a'         => [
        'href'      => [],
        'title'     => [],
	'target'    => [],
	'class'     => []
    ]
]; ?>
<main class="pb-6">
    <section class="mt-3 mx-2 mt-md-6 mx-md-4 mx-lg-6 municipality">
        <h2 class="page-title mt-0 mb-4 mb-md-8"><span><?php echo esc_html($cat->name); ?></span></h2>
        <div class="municipality__info mb-md-6">
            <?php
            $desc = preg_split("/<br(?: \/)?>\r?\n<br(?: \/)>/", nl2br(trim(wp_kses($cat->description, $allowed_html))));
            foreach ($desc as $paragraph) { ?>
                <p><?php echo $paragraph; ?></p>
            <?php } ?>
        </div>

        <div class="municipality__partners kandidaten_btw">
            <h3 class="section-title">Unsere Kandidaten</h3>
            <div class="kandidaten-btw">
                <article class="card card--municipality-partner">
                    <div class="card--municipality-partner__top-wrapper">
                        <div class="card--municipality-partner__avatar" role="img" style="background-image: url(<?php echo esc_attr(wp_get_attachment_url( 2657 )); ?>)"></div>
                        <header class="card--municipality-partner__head">
                            <h3>Kristian Katzmarek</h3>
                            <ul class="card--municipality-partner__tags">
                                <li>Bedburg &bull; Bergheim &bull; Elsdorf &bull; Frechen &bull; Hürth &bull; Kerpen &bull; Pulheim</li>
                            </ul>
                        </header>
                        <p class="card--municipality-partner__bio mx-1 mb-2">Kristian Katzmarek studiert Mathematik und Sozialwissenschaften im Master und ist angestellter Lehrer. Wählbar ist er in Wahlkreis 91 (Rhein-Erft-Kreis Nord).</p>
                    </div>
                </article>
                <article class="card card--municipality-partner">
                    <div class="card--municipality-partner__top-wrapper">
                        <div class="card--municipality-partner__avatar" role="img" style="background-image: url(<?php echo esc_attr(wp_get_attachment_url( 2509 )); ?>)"></div>
                        <header class="card--municipality-partner__head">
                            <h3>Stefano Tuchscherer</h3>
                            <ul class="card--municipality-partner__tags">
                                <li>Brühl &bull; Erftstadt &bull; Wesseling &bull; Kreis Euskirchen</li>
                            </ul>
                        </header>
                        <p class="card--municipality-partner__bio mx-1 mb-2">Stefano Tuchscherer befindet sich in seiner Ausbildung zum Fluggerätemechaniker und wählen könnt ihr ihn im südlichen Rhein-Erft-Kreis sowie im Kreis Euskirchen (Wahlbezirk 92).</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="mt-6 mx-2 mt-md-10 mx-md-4 mx-lg-6 posts">
        <h2 class="section-title mt-0 mb-2 mb-md-3 mb-lg-5">Artikel zur Bundestagswahl</h2>
        <?php if (empty($wp_query->post_count)) { ?>
            <p class="center"><em>Derzeit keine Posts zur Bundestagswahl</em></p>
        <?php } else { ?>
            <div class="post-grid" data-num="<?php echo esc_attr($wp_query->post_count); ?>" data-total="<?php echo esc_attr($wp_query->max_num_pages); ?>">
            <?php while (have_posts()) { the_post(); get_template_part('partials/card', 'post'); } ?>
            </div>
            <?php ns_pagination($wp_query, 'center mt-7 mb-5 mt-md-10 mb-md-12 mt-lg-8 mb-lg-11') ?>
        <?php } ?>
    </section>
</main>
<?php
get_sidebar();
get_footer();

