<?php get_header(); ?>
	<main class="py-6 pt-md-0">
		<section class="mt-3 mx-2 mt-md-6 mx-md-4 mx-lg-6 category">
			<h1 class="page-title mt-0 mb-4 mb-md-8"><span><?php echo esc_html(__('Kategorie', 'nostrasponte') . ' ' . get_queried_object()->name); ?></span></h1>

			<?php if (empty($wp_query->post_count)) { ?>
			<p class="center"><em><?php esc_html_e('Leider gibt es keine Posts', 'nostrasponte'); ?></em></p>
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