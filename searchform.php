<?php $unique_id = esc_attr(uniqid('search-')); ?>
<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form">
	<input data-id="searchsubmit" type="submit" value="&#xe909;" tabindex="-1">
	<input id="<?php echo $unique_id; ?>" data-id="s" type="search" value="<?php the_search_query(); ?>" placeholder="Suche" name="s">
</form>
