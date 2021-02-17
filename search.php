<?php get_header(); ?>
	<main class="pb-6">
        <section class="mt-7 mb-6 px-2 my-md-8 px-md-4 my-lg-10 px-lg-6 fl-center">
			<?php get_search_form(); ?>
        </section>
        <section class="mt-6 mx-2 mt-md-8 mx-md-4 mx-lg-6 mt-lg-10 search">
            <h1 class="section-title mt-0 mb-2 mb-md-5 mb-lg-7"><?php printf( __( 'Suchergebnisse für<br>&bdquo;%s&ldquo;', 'nostrasponte' ), esc_html( get_search_query( false ) ) ); ?></h1>
            <?php if ( empty( $wp_query->post_count ) ) { ?>
            <p class="center"><em><?php _e( 'Deine Suche lieferte leider keine Ergebnisse', 'nostrasponte' ); ?></em></p>
            <?php } else { ?>
            <div class="post-grid" data-num="<?php echo esc_attr( $wp_query->post_count ); ?>" data-total="<?php echo esc_attr($wp_query->max_num_pages); ?>">
				<?php while (have_posts()) { the_post(); get_template_part('partials/card', 'post'); } ?>
            </div>
            <?php ns_pagination($wp_query, 'center mt-7 mb-5 mt-md-10 mb-md-12 mt-lg-8 mb-lg-11');
            } ?>
        </section>
	</main>
<?php get_sidebar(); ?>
<?php get_footer();
