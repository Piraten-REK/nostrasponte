<?php get_header();
while (have_posts()): the_post(); ?>
<header id="post_header"<?php if(has_post_thumbnail()): ?> style="<?php echo get_the_post_thumbnail_url(); ?>"<?php endif; ?>>
    <h2><?php the_title(); ?></h2>
</header>
<main>
    <?php the_content(); ?>
</main>
<?php endwhile;
include('partials/sidebar.php');
get_footer(); ?>
