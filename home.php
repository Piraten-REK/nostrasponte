<?php get_header(); ?>
<main><?php
    $curPage = get_query_var('paged');
    $args = array(
        'posts_per_page' => 1,
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
                        <span class="date"><?php the_date('d. M Y'); ?></span>
                    </p>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
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