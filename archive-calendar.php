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
        $query -> set('post_type', 'appointment');
        $query -> set('meta_key', 'date');
        $query -> set('orderby', 'meta_value');
        $query -> set('order', 'DESC');
        $query -> set('paged', $curPage);
    }
}
add_filter('pre_get_posts', 'pp_archive_per_page');
get_header(); ?>
<header>
    <h1>Unsere Termine</h1>
</header>
<main>
    <section id="posts" class="calendar">
        <div class="grid" data-count="<?php echo $wp_query -> post_count; ?>"><?php while (have_posts()): the_post(); [$y, $m, $d] = explode('-', get_field('date')); $M = $months[$m]; ?>
            <article class="card calendar">
                <div class="post_img"<?php if (get_the_post_thumbnail_url()): ?> style="background-image: url('<?php the_post_thumbnail_url(); ?>');"<?php endif; ?>></div>
                <header>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </header>
                <p class="data">
                    <table>
                        <tr title="Datum&#xd;<?php echo "$d. $M $y";?>">
                            <th></th>
                            <td><time datetime="<?php echo "$y-$m-$d"; ?>"><?php echo "$d. $M $y"; ?></time></td>
                        </tr>
                        <?php if (get_field('start')): ?><tr title="Uhrzeit&#013;<?php the_field('start'); if(get_field('end')) echo ' Uhr bis ' . get_field('end'); ?> Uhr">
                            <th></th>
                            <td><?php the_field('start'); if(get_field('end')) echo ' Uhr bis ' . get_field('end'); ?> Uhr</td>
                        </tr><?php endif; ?>
                        <tr title="Ort&#xd;<?php echo get_field('mumble') ? 'Mumble-Server der Piratenpartei NRW' : preg_replace("/<br ?\/?>\r?\n?/", ', ', get_field('place')); ?>">
                            <th></th>
                            <td><?php if (get_field('mumble')) { echo 'Mumble-Server der Piratenpartei NRW<br><a href="mumble://">Link zum Mumble</a>'; } else { the_field('place'); } ?></td>
                        </tr>
                    </table>
                </p>
                <a href="<?php the_permalink(); ?>" class="btn btn_readmore" title="<?php the_title('Mehr Infos zum Termin &bdquo;', '&ldquo;') ?>">Mehr Infos</a>
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