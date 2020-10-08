<?php $unique_id = esc_attr(uniqid('searchform--')); ?>
<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform">
	<input type="search" placeholder="<?php _e('Suchen…', 'nostrasponte'); ?>" name="s" id="<?php echo $unique_id; ?>" value="<?php the_search_query(); ?>">
	<button type="submit" tabindex="-1"></button>
</form>