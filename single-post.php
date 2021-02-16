<?php get_header(); ?>
	<main class="pt-2 pb-6 pt-md-0">
        <?php while (have_posts()) { the_post(); ?>
		<section class="mt-3 mx-2 mt-md-6 mx-md-4 mx-lg-6 post">
			<?php if (has_post_thumbnail()) { ?><div class="post__image__wrapper">
				<div class="post__image" style="background-image: url('<?php the_post_thumbnail_url(); ?>')" role="img"></div>
			</div><?php } ?>
            
            <header class="post__header mb-4 mb-md-8">
                <h1 class="page-title mt-0 mb-2"><span><?php the_title(); ?></span></h1>
                <div class="post__header__meta">
                    <div class="post__header__meta__category" title="<?php echo esc_attr( 'Kategorien', 'nostrasponte' ); ?>">
                        <i class="feather icon-bookmark"></i>
                        <ul>
			    <?php foreach (wp_get_post_categories(get_the_ID(), ['fields' => 'all']) as $cat) { ?>
				<li><a href="<?php echo get_category_link($cat); ?>" title="<?php echo esc_attr(sprintf('%s %s%s', __('Kategorie', 'nostrasponte'), $cat->name, empty($cat->description) ? '' : "\n\n" . strip_tags($cat->description))); ?>"><?php echo esc_html($cat->name); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
	                <?php if ( has_tag() ) { ?>
                        <div class="post__header__meta__tags" title="<?php esc_attr_e( 'Themen', 'nostrasponte' ); ?>">
                            <i class="feather icon-tag"></i>
                            <ul>
				                <?php foreach ( get_tags() as $tag ) { ?>
                                    <li><a href="<?php echo get_tag_link( $tag->term_id ); ?>" title="<?php echo esc_attr(sprintf('%s %s%s', __('Thema', 'nostrasponte'), $tag->name, empty($tag->description) ? '' : "\n\n" . strip_tags($tag->description))); ?>"><?php echo esc_html( $tag->name ); ?></a></li>
				                <?php } ?>
                            </ul>
                        </div>
	                <?php }
	                if( has_term( '', 'municipality' ) ) { ?>
                        <div class="post__header__meta__municipalities" title="<?php esc_attr_e( 'Kommunen', 'nostrasponte' ); ?>">
                            <i class="feather icon-home"></i>
                            <ul>
				                <?php foreach ( get_the_terms( get_the_ID(), 'municipality' ) as $tag ) { ?>
                                    <li><a href="<?php echo get_tag_link( $tag->term_id ); ?>" title="<?php $meta = get_term_meta($tag->term_id, 'municipality_data', true); echo esc_attr(sprintf('%s%s', isset($meta['long_title']) ? $meta['long_title'] : __('Kommune', 'nostrasponte') . ' ' . $tag->name , empty($tag->description) ? '' : "\n\n" . strip_tags($tag->description))); ?>"><?php echo esc_html( $tag->name ); ?></a></li>
				                <?php } ?>
                            </ul>
                        </div>
	                <?php } ?>
                    <div class="post__header__meta__date" title="<?php echo esc_attr(sprintf('%s %s. %s %s', __("Datum\nveröffentlicht am", 'nostrasponte'), get_the_date('j'), NS_MONTH[intval(get_the_date('n'))], get_the_date('Y'))); ?>">
                        <i class="feather icon-calendar"></i>
                        <time datetime="<?php the_date( 'Y-m-d' ); ?>"><?php printf('%s, %s. %s %s',
				                NS_DAY_OF_WEEK[ intval( get_the_date( 'w' ) ) ],
				                get_the_date( 'j' ),
				                NS_MONTH[ intval( get_the_date( 'n' ) ) ],
				                get_the_date( 'Y' ) ); ?></time>
                    </div>
                    <div class="post__header__meta__author" title="<?php echo esc_attr(sprintf('%s: %s', __('Autor', 'nostrasponte'), get_the_author())); ?>">
                        <i class="feather icon-user"></i><span><?php the_author(); ?></span>
                    </div>
                </div>
            </header>

			<div class="content">
				<?php the_content(); ?>
			</div>

            <footer class="page-footer mt-6">
                <?php get_template_part('partials/card', 'author'); ?>
            </footer>
			<?php ns_pagination($wp_query, 'center mt-7 mb-5 mt-md-10 mb-md-12 mt-lg-8 mb-lg-11'); ?>
		</section>
        <?php } ?>
	</main>
<?php get_sidebar(); ?>
<?php get_footer();
