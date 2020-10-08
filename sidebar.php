<aside class="site-sidebar px-2 py-6 px-md-4 py-md-9 px-lg-6 py-lg-10">
	<?php
	if ( is_active_sidebar( 'ns_sidebar' ) ) {
		dynamic_sidebar('ns_sidebar');
	}
	?>
</aside>