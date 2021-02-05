<?php get_header(); ?>
    <main class="pt-6 pt-md-0">
        <section class="hero--homepage hero--top" data-hero-type="<?php esc_attr_e( ns_homepage_hero_type() ); ?>">
            <div class="hero--homepage__img" style="background-image: url('<?php ns_homepage_hero_image(); ?>');" role="img"></div>
            <div class="hero--homepage__wrapper px-2 pb-5 px-md-4 py-md-4 px-lg-6 py-lg-6">
                <h2 class="hero--homepage__title"><?php ns_homepage_hero_title(); ?></h2>
                <p class="hero--homepage__subtitle"><?php ns_homepage_hero_text(); ?></p>
                <a href="<?php ns_homepage_hero_url(); ?>" class="btn hero--homepage__cta"><?php ns_homepage_hero_button(); ?></a>
            </div>
        </section>
        <section class="mt-6 mx-2 mt-md-8 mx-md-4 mt-md-10 mx-lg-6 blog">
            <h2 class="section-title mt-0 mb-2 mb-md-3 mb-lg-5"><?php _ex( 'Aktuelles', 'Blog Section Caption', 'nostrasponte' ); ?></h2>
            <?php $posts = new WP_Query([ 'posts_per_page' => 6, 'offset' => ns_homepage_hero_type() === 'last_post' ? 1 : 0 ]); ?>
            <div class="slider slider--mobile grid--desktop">
                <div class="slider__wrapper" data-num="<?php esc_attr_e( $posts->post_count ); ?>">
                    <?php while ($posts -> have_posts()) { $posts -> the_post(); ?>
                    <div class="slider__content">
                        <?php get_template_part('partials/card', 'post'); ?>
                    </div>
                    <?php } ?>
                </div>
                <nav class="slider__nav-arrows">
                    <button class="slider__nav-arrows__prev feather icon-chevron-left"></button>
                    <button class="slider__nav-arrows__next feather icon-chevron-right"></button>
                </nav>
                <nav class="slider__nav"><?php for ($i = 0; $i < $posts->post_count; $i++) echo '<span></span>'; ?></nav>
            </div>
            <div class="blog__more-wrapper pt-4 pb-8 pt-md-7 pb-md-12 pt-lg-12 pb-lg-18">
                <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="btn mx-center"><?php echo esc_html_x( 'Mehr Posts', 'Homepage Button', 'nostrasponte' ); ?></a>
            </div>
        </section>
    </main>
<?php wp_reset_query(); get_sidebar(); ?>
<?php get_footer();