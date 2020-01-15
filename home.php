<?php get_header();
$months = array(
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
?>
<main><?php
    $curPage = get_query_var('paged');
    $args = array(
        'posts_per_page' => 6,
        'paged' => $curPage
    );
    $posts = new WP_Query($args); ?>
    <section id="posts">
        <h2>Neuigkeiten</h2>
        <div class="grid" data-count="<?php echo $posts -> post_count; ?>">
            <?php while ($posts -> have_posts()): $posts -> the_post(); ?><article class="card">
                <div class="post_img"<?php if (get_the_post_thumbnail_url()): ?> style="background-image: url('<?php the_post_thumbnail_url(); ?>');"<?php endif; ?>></div>
                <header>
                    <p class="metadata">
                        <span class="category"><?php the_category(' &bull; '); ?></span>
                        <time datetime="<?php the_date('Y-m-d'); ?>" class="date"><?php echo get_the_date('d') . '. ' . $months[get_the_date('n')] . ' ' . get_the_date('Y'); ?></time>
                    </p>
                    <h3 title="<?php the_permalink(); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </header>
                <p class="excerpt"><?php echo get_the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>" class="btn btn_readmore" title="&bdquo;<?php the_title(); ?>&ldquo; weiterlesen">Weiterlesen</a>
            </article><?php endwhile; ?>
        </div>
        <div id="pagination">
            <?php echo paginate_links(array(
                'total' => $posts -> max_num_pages,
                'prev_text' => 'Zurück',
                'next_text' => 'Weiter'
            ));wp_reset_query(); ?>
        </div>
    </section>
</main>
<?php include('partials/sidebar.php');
get_footer(); ?>