<article <?php post_class('card card--post'); ?>>
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
			<time datetime="<?php the_date( 'Y-m-d' ); ?>"><?php printf('%s, %s. %s %s',
						NS_DAY_OF_WEEK[ intval( get_the_date( 'w' ) ) ],
						get_the_date( 'j' ),
						NS_MONTH[ intval( get_the_date( 'n' ) ) ],
						get_the_date( 'Y' ) ); ?></time>
		</div>
		<div class="card--post__foot__author">
			<i class="feather icon-user" title="<?php esc_attr_e('Autor', 'nostrasponte' ); ?>"></i><?php the_author_link(); ?>
		</div>
	</footer>
</article>