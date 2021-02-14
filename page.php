<?php get_header(); ?>
	<main class="py-6 pt-md-0">
        <?php while (have_posts()) { the_post(); ?>
        <section class="mt-3 mx-2 mt-md-6 mx-md-4 mx-lg-6 page">
            <?php if (has_post_thumbnail()) { ?><div class="page__image__wrapper mb-4">
                <div class="page__image" style="background-image: url('<?php the_post_thumbnail_url(); ?>')" role="img"></div>
            </div><?php } ?>

            <header class="page__header mb-4 mb-md-8">
                <h1 class="page-title mt-0 mb-2"><span><?php the_title(); ?></span></h1>
            </header>

			<div class="content">
				<?php the_content(); ?>
			</div>
		</section>
        <?php } ?>
	</main>
<?php get_sidebar(); ?>
<?php get_footer();