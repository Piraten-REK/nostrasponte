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
                        <article class="card card--post">
                            <div class="card--post__img"<?php if (has_post_thumbnail()) { ?> style="background-image: url('<?php the_post_thumbnail_url(); ?>')"<?php } ?> role="img"></div>
                            <header class="card--post__head">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </header>
                            <p class="card--post__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '&hellip;'); ?></p>
                            <footer class="card--post__foot">
                                <div class="card--post__foot__category">
                                    <i class="feather icon-bookmark" title="<?php esc_attr_e( 'Kategorien', 'nostrasponte' ); ?>"></i>
                                    <ul>
                                        <?php wp_list_categories( [ 'title_li' => '' ] ); ?>
                                    </ul>
                                </div>
                                <?php if ( has_tag() ) { ?>
                                <div class="card--post__foot__tags">
                                    <i class="feather icon-tag" title="<?php esc_attr_e( 'Tags', 'nostrasponte' ); ?>"></i>
                                    <ul>
                                        <?php foreach ( get_tags() as $tag ) { ?>
                                        <li><a href="<?php echo get_tag_link( $tag->term_id ); ?>" <?php if ( !empty($tag->description) ) { ?>title="<?php echo esc_attr($tag->description); ?>"<?php } ?>><?php echo esc_html( $tag->name ); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php }
                                if( has_term( '', 'municipality' ) ) { ?>
                                    <div class="card--post__foot__municipalities">
                                        <i class="feather icon-home" title="<?php esc_attr_e( 'Kommune', 'nostrasponte' ); ?>"></i>
                                        <ul>
				                            <?php foreach ( get_tags( [ 'taxonomy' => 'municipality' ] ) as $tag ) { ?>
                                                <li><a href="<?php echo get_tag_link( $tag->term_id ); ?>" <?php if ( !empty($tag->description) ) { ?>title="<?php echo esc_attr($tag->description); ?>"<?php } ?>><?php echo esc_html( $tag->name ); ?></a></li>
				                            <?php } ?>
                                        </ul>
                                    </div>
	                            <?php } ?>
                                <div class="card--post__foot__date">
                                    <i class="feather icon-calendar" title="<?php esc_attr_e( 'Datum', 'nostrasponte' ); ?>"></i>
                                    <a href="#"><time datetime="<?php the_date( 'Y-m-d' ); ?>"><?php printf('%s, %s. %s %s',
                                                NS_DAY_OF_WEEK[ intval( get_the_date( 'w' ) ) ],
                                                get_the_date( 'j' ),
                                                NS_MONTH[ intval( get_the_date( 'n' ) ) ],
                                                get_the_date( 'Y' ) ); ?></time></a>
                                </div>
                                <div class="card--post__foot__author">
                                    <i class="feather icon-user" title="<?php esc_attr_e('Autor', 'nostrasponte' ); ?>"></i><?php the_author_link(); ?>
                                </div>
                            </footer>
                        </article>
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