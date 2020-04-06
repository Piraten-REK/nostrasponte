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
get_header();
while (have_posts()): the_post(); ?>
<header id="post_header"<?php if(has_post_thumbnail()): ?> style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');"<?php endif; ?>>
    <p class="metadata"><span class="category"><?php the_category(' &bull; '); ?></span> <time datetime="<?php the_date('Y-m-d'); ?>" class="date"><?php echo get_the_date('d') . '. ' . $months[get_the_date('n')] . ' ' . get_the_date('Y'); ?></time></p>
    <h2><?php the_title(); ?></h2>
</header>
<main>
    <?php the_content(); ?>
</main>
<?php endwhile;
include('partials/sidebar.php');
get_footer(); ?>
