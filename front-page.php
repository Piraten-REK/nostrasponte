<?php get_header();
$args = array(
    'posts_per_page' => 1
);

$hero = new WP_Query($args);
while ($hero -> have_posts()): $hero -> the_post(); ?>
<section id="hero" style="background-image: url('<?php echo has_post_thumbnail(get_the_ID()) ? get_the_post_thumbnail_url(get_the_ID()) : get_theme_file_uri('img/standard_hero.jpg'); ?>">
    <p class="metadata"><span><span class="category"><?php the_category(' &bull; '); ?></span> <span class="date"><?php the_date('d. M Y'); ?></span></span></p>
    <header>
        <h2><?php the_title(); ?></h2>
    </header>
    <p class="excerpt"><?php echo wp_trim_words(str_replace('&', '&amp;', get_the_excerpt()), 30); ?></p>
    <div class="btn_wrapper"><a href="<?php the_permalink(); ?>" class="btn btn_readmore" title="&bdquo;<?php echo the_title(); ?>&ldquo; weiterlesen">Weiterlesen</a></div>
</section><?php endwhile; wp_reset_query(); ?>

<?php get_footer(); ?>