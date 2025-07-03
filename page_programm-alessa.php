<?php /** Template Name: Wahlprogramm Alessa */

function shift_down_headings (string $content): string {
  $content = preg_replace_callback('/<h([1-6])([^>]*)>/i', function ($matches) {
    $lvl = intval($matches[1]);
    $rest = $matches[2];

    if ($lvl < 6) $lvl++;

    return sprintf('<h%d%s>', $lvl, $rest);
  }, $content);

  $content = preg_replace_callback('/<\/h([1-6])>/i', function ($matches) {
    $lvl = intval($matches[1]);

    if ($lvl < 6) $lvl++;
    return sprintf('</h%d>', $lvl);
  }, $content);

  return $content;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=dege">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class( 'wahlprogramm' ); ?>>
    <header class="site-header px-2 py-1 px-md-4 px-lg-6 container" role="banner">
      <a href="<?php echo is_front_page() ? '#' : get_home_url(); ?>" class="site-header__logo" rel="start"><img class="site-header__logo__img" src="<?php echo get_theme_file_uri('/assets/img/logo.svg'); ?>" alt="Piraten Rhein-Erft-Kreis"></a>
      <h1><a href="/alessa2025"><span>Wahlprogramm</span> Flohe 2025</a></h1>
    </header>
  <div class="main-wrapper container">
    <aside class="site-sidebar px-2 py-6 px-md-4 py-md-9 px-lg-6 py-lg-10">
      <?php
      if (has_nav_menu('wahlprogramm_alessa2025')) {
        wp_nav_menu([
          'theme_location'    => 'wahlprogramm_alessa2025',
          'container'         => 'nav',
          'container_class'   => 'wahlprogramm__navigation px-2 py-4 px-md-4',
          'menu_class'        => '',
          'menu_id'           => '',
          'depth'             => 2,
          'walker'            => new NS_Custom_Nav_Walker()
        ]);
      }
      ?>
    </aside>
    <main class="pb-6">
      <?php while (have_posts()) { the_post(); ?>
        <section class="mt-3 mx-2 mt-md-6 mx-md-4 mx-lg-6 page">
          <?php if (has_post_thumbnail()) { ?><div class="page__image__wrapper mb-4">
            <div class="page__image" style="background-image: url('<?php the_post_thumbnail_url(); ?>')" role="img"></div>
            </div><?php } ?>

          <header class="page__header mb-4 mb-md-8">
            <h1 class="page-title mt-0 mb-2"><span><?php the_title(); ?></span></h1>
          </header>

          <div class="content">
            <?php echo shift_down_headings(get_the_content()); ?>
          </div>
        </section>
      <?php } ?>
    </main>
  <?php get_footer();
