<article <?php post_class('card card--post'); ?>>
	<div class="card--post__img"<?php if (has_post_thumbnail()) { ?> style="background-image: url('<?php the_post_thumbnail_url(); ?>')"<?php } ?> role="img"></div>
	<header class="card--post__head">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	</header>
	<p class="card--post__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 12, '&hellip;'); ?></p>
	<footer class="card--post__foot">
		<div class="card--post__foot__category" title="<?php esc_attr_e( 'Kategorien', 'nostrasponte' ); ?>">
			<i class="feather icon-bookmark"></i>
			<ul>
				<?php foreach (wp_get_post_categories(get_the_ID(), ['fields' => 'all']) as $cat) { ?>
                    <li><a href="<?php echo get_category_link($cat); ?>" title="<?php echo esc_attr(sprintf('%s %s%s', __('Kategorie', 'nostrasponte'), $cat->name, empty($cat->description) ? '' : "\n\n" . strip_tags($cat->description))); ?>"><?php echo esc_html($cat->name); ?></a></li>
				<?php } ?>
			</ul>
		</div>
		<?php if ( has_tag() ) { ?>
			<div class="card--post__foot__tags" title="<?php esc_attr_e( 'Themen', 'nostrasponte' ); ?>">
				<i class="feather icon-tag"></i>
				<ul>
					<?php foreach ( get_tags() as $tag ) { ?>
                        <li><a href="<?php echo get_tag_link( $tag->term_id ); ?>" title="<?php echo esc_attr(sprintf('%s %s%s', __('Thema', 'nostrasponte'), $tag->name, empty($tag->description) ? '' : "\n\n" . strip_tags($tag->description))); ?>"><?php echo esc_html( $tag->name ); ?></a></li>
					<?php } ?>
				</ul>
			</div>
		<?php }
		if( has_term( '', 'municipality' ) ) { ?>
			<div class="card--post__foot__municipalities" title="<?php esc_attr_e( 'Kommunen', 'nostrasponte' ); ?>">
				<i class="feather icon-home"></i>
				<ul>
					<?php foreach ( get_the_terms( get_the_ID(), 'municipality' ) as $tag ) { ?>
                        <li><a href="<?php echo get_tag_link( $tag->term_id ); ?>" title="<?php $meta = get_term_meta($tag->term_id, 'municipality_data', true); echo esc_attr(sprintf('%s%s', isset($meta['long_title']) ? $meta['long_title'] : __('Kommune', 'nostrasponte') . ' ' . $tag->name , empty($tag->description) ? '' : "\n\n" . strip_tags($tag->description))); ?>"><?php echo esc_html( $tag->name ); ?></a></li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
		<div class="card--post__foot__date" title="<?php echo esc_attr(sprintf('%s %s. %s %s', __("Datum\nveröffentlicht am", 'nostrasponte'), get_the_date('j'), NS_MONTH[intval(get_the_date('n'))], get_the_date('Y'))); ?>">
			<i class="feather icon-calendar"></i>
			<time datetime="<?php the_date( 'Y-m-d' ); ?>"><?php printf('%s, %s. %s %s',
						NS_DAY_OF_WEEK[ intval( get_the_date( 'w' ) ) ],
						get_the_date( 'j' ),
						NS_MONTH[ intval( get_the_date( 'n' ) ) ],
						get_the_date( 'Y' ) ); ?></time>
		</div>
		<div class="card--post__foot__author" title="<?php echo esc_attr(sprintf('%s: %s', __('Autor', 'nostrasponte'), get_the_author())); ?>">
			<i class="feather icon-user"></i><span><?php the_author(); ?></span>
		</div>
	</footer>
</article>
