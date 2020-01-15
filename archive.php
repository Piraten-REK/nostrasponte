<?php $months = array(
    '1' => 'Januar',
    '2' => 'Februar',
    '3' => 'März',
    '4' => 'April',
    '5' => 'Mai',
    '6' => 'Juni',
    '7' => 'Juli',
    '8' => 'August',
    '9' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Dezember'
);
function pp_archive_per_page($query) {
    if (is_tax('category')) {
        $curPage = get_query_var('paged');
        $query -> set('posts_per_page', 6);
        $query -> set('paged', $curPage);
    }
}
add_filter('pre_get_posts', 'pp_archive_per_page');
get_header(); ?>
<header>
    <h1>Archiv: <?php the_archive_title(); ?></h1>
</header>
<main>
    <section id="posts">
        <div class="grid" data-count="<?php echo $wp_query -> post_count; ?>">
            <?php while (have_posts()): the_post(); ?>
            <article class="card">
                <div class="post_img" <?php if (get_the_post_thumbnail_url()): ?>style="background-image: url('<?php the_post_thumbnail_url(); ?>');"<?php endif; ?>></div>
                <header>
                    <p class="metadata">
                        <span class="category"><?php the_category(' &bull; '); ?></span>
                        <time datetime="<?php the_date('Y-m-d'); ?>" class="date"><?php echo get_the_date('d') . '. ' . $months[get_the_date('n')] . ' ' . get_the_date('Y'); ?></time>
                    </p>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </header>
                <p class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '&hellip;'); ?></p>
                <a href="<?php the_permalink(); ?>" class="btn btn_readmore" title="&bdquo;<?php the_title(); ?>&ldquo; weiterlesen">Weiterlesen</a>
            </article>
        <?php endwhile; ?></div>
        <div id="pagination">
            <?php echo paginate_links(array(
                'total' => $wp_query -> max_num_pages,
                'prev_text' => 'Zurück',
                'next_text' => 'Weiter'
            ));wp_reset_query(); ?>
        </div>
    </section>
</main>
<?php include('partials/sidebar.php');
get_footer(); ?>