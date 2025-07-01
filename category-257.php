<?php
add_action('wp_head', function () { ?>
<style>
  .kandidaten-ltw {
    display: flex;
    flex-direction: column;
    justify-content: center !important;
    gap: 2rem;
  }
  .kandidaten-ltw article {
    margin: 0 !important;
  }
  .card--municipality-partner__tags li {
    display: inline-block !important;
  }
  .card--municipality-partner__tags li:not(:last-child)::after {
    content: "\0020\2022\0020";
  }
  @media (min-width: 768px) and (max-width: 1279px) {
    .kandidaten-ltw {
      display: grid;
      grid-template: repeat(2, 1fr) / repeat(2, auto);
      justify-items: center;
      align-items: stretch;
    }
    .kandidaten-ltw article:nth-of-type(1) {
      grid-area: 1 / 1 / 2 / 3;
    }
  }
  @media (min-width: 1280px) {
    .kandidaten-ltw {
      flex-direction: row;
      justify-content: space-around !important;
      align-items: stretch !important;
    }
  }
</style>
<?php }, 999);

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
];
$candidates = [
    [
        'name'              => 'Alessa Flohe',
        'wk'                => [5, 'Rhein-Erft-Kreis I'],
        'municipalities'    => ['Bedburg', 'Bergheim', 'Elsdorf', 'Pulheim'],
        'bio'               => 'Alessa Flohe arbeitet als Datenschutzbeauftragte im öffentlichen Dienst. Seit 2020 vertritt sie die Piraten im Kerpener Stadtrat. Wählen könnt ihr sie in Wahlkreis I, außerdem ist sie Spitzenkandidatin der Piratenpartei NRW.',
        'img'               => 1777
    ],
    [
        'name'              => 'Kristian Katzmarek',
        'wk'                => [6, 'Rhein-Erft-Kreis II'],
        'municipalities'    => ['Frechen', 'Hürth', 'Kerpen (ohne Balkhausen, Brüggen & Türnich'],
        'bio'               => 'Kristian Katzmarek studiert Mathematik und Sozialwissenschaften im Master und ist angestellter Lehrer. Wählbar ist er in Wahlkreis II sowie auf Listenplatz 4 der Landesliste.',
        'img'               => 2657
    ],
    [
        'name'              => 'Jannis Milios',
        'wk'                => [7, 'Rhein-Erft-Kreis III'],
        'municipalities'    => ['Brühl', 'Erftstadt', 'Wesseling', 'Kerpen-Balkhausen, Brüggen & Türnich'],
        'bio'               => 'Jannis Milios aus Türnich vertritt die Piraten seit 2014 im Kreistag des Rhein-Erft-Kreis, in den er 2020 wiedergewählt wurde. Seit 2020 ist er Vorsitzender des Digitalausschuss\' im Kreis. Wählbar ist er in Wahlkreis III.',
        'img'               => 2487
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
            <div class="kandidaten-ltw">
            <?php
            foreach ($candidates as $candidate) { ?>
                <article class="card card--municipality-partner">
                    <div class="card--municipality-partner__top-wrapper">
                        <div class="card--municipality-partner__avatar" role="img" style="background-image: url(<?php echo esc_attr(wp_get_attachment_url( $candidate['img'] )); ?>)"></div>
                        <header class="card--municipality-partner__head">
                            <h3><?php echo esc_html($candidate['name']); ?></h3>
                            <ul class="card--municipality-partner__tags">
                            <?php foreach ($candidate['municipalities'] as $municipality) { ?>
                                <li><?php echo $municipality; ?></li>
                            <?php } ?>
                            </ul>
                        </header>
                        <p class="card--municipality-partner__bio mx-1 mb-2"><?php echo esc_html($candidate['bio']); ?></p>
                    </div>
                </article>
            <?php } ?>
        </div>
    </section>
    <section class="mt-6 mx-2 mt-md-10 mx-md-4 mx-lg-6 posts">
        <h2 class="section-title mt-0 mb-2 mb-md-3 mb-lg-5">Artikel zur Landtagswahl</h2>
        <?php if (empty($wp_query->post_count)) { ?>
            <p class="center"><em>Derzeit keine Posts zur Landtagswahl</em></p>
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
