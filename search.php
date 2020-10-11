<?php get_header(); ?>
	<main class="pt-6 pt-md-0">
        <section class="mt-7 mb-6 px-2 my-md-8 px-md-4 my-lg-10 px-lg-6 fl-center">
			<?php get_search_form(); ?>
        </section>
        <section class="mt-6 mx-2 mt-md-8 mx-md-4 mx-lg-6 mt-lg-10 blog">
            <h2 class="section-title mt-0 mb-2 mb-md-5 mb-lg-7">Suchergebnisse für<br>&bdquo;<?php echo esc_html( get_search_query( false ) ); ?>&ldquo;</h2>
            <div class="post-grid" data-num="<?php echo esc_attr( $wp_query->post_count ); ?>" data-total="<?php echo $wp_query->max_num_pages; ?>">
				<?php while (have_posts()) { the_post(); ?>
                    <article class="card card--post">
                        <div class="card--post__img"<?php if (has_post_thumbnail()) { ?> style="background-image: url('<?php the_post_thumbnail_url(); ?>')"<?php } ?>></div>
                        <header class="card--post__head">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        </header>
                        <p class="card--post__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '&hellip;'); ?></p>
                        <footer class="card--post__foot">
                            <div class="card--post__foot__category">
                                <i class="feather icon-bookmark" title="Kategorien"></i>
                                <ul>
									<?php wp_list_categories( [ 'title_li' => '' ] ); ?>
                                </ul>
                            </div>
							<?php if ( has_tag() ) { ?>
                                <div class="card--post__foot__tags">
                                    <i class="feather icon-tag" title="Tags"></i>
                                    <ul>
										<?php foreach ( get_tags() as $tag ) { ?>
                                            <li><a href="<?php echo get_tag_link( $tag->term_id ); ?>" <?php if ( !empty($tag->description) ) { ?>title="<?php echo esc_attr($tag->description); ?>"<?php } ?>><?php echo esc_html( $tag->name ); ?></a></li>
										<?php } ?>
                                    </ul>
                                </div>
							<?php }
							if( has_term( '', 'municipality' ) ) { ?>
                                <div class="card--post__foot__municipalities">
                                    <i class="feather icon-home" title="Kommune"></i>
                                    <ul>
										<?php foreach ( get_tags( [ 'taxonomy' => 'municipality' ] ) as $tag ) { ?>
                                            <li><a href="<?php echo get_tag_link( $tag->term_id ); ?>" <?php if ( !empty($tag->description) ) { ?>title="<?php echo esc_attr($tag->description); ?>"<?php } ?>><?php echo esc_html( $tag->name ); ?></a></li>
										<?php } ?>
                                    </ul>
                                </div>
							<?php } ?>
                            <div class="card--post__foot__date">
                                <i class="feather icon-calendar" title="Datum"></i>
                                <a href="#"><time datetime="<?php the_date( 'Y-m-d' ); ?>"><?php printf('%s, %s. %s %s',
											_x( NS_DAY_OF_WEEK[ intval( get_the_date( 'w' ) ) ] ,'day of week', 'nostrasponte' ),
											get_the_date( 'j' ),
											__( NS_MONTH[ intval( get_the_date( 'n' ) ) ] ),
											get_the_date( 'Y' ) ); ?></time></a>
                            </div>
                            <div class="card--post__foot__author">
                                <i class="feather icon-user" title="Autor"></i><?php the_author_link(); ?>
                            </div>
                        </footer>
                    </article>
				<?php } ?>
            </div>
            <?php ns_pagination($wp_query, 'center mt-7 mb-5 mt-md-10 mb-md-12 mt-lg-8 mb-lg-11'); ?>
        </section>
	</main>
<?php get_sidebar(); ?>
<?php get_footer();
