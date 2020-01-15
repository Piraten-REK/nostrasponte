<?php get_header(); ?>

<?php while(have_posts()): the_post(); ?><header>
    <h2><?php the_title(); ?></h2>
</header>
<main>
    <?php the_content(); ?>
</main><?php endwhile; ?>

<?php include('partials/sidebar.php');
get_footer(); ?>