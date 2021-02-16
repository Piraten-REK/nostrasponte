<?php $avatarArgs = [
	'size'          => 96,
	'default'       => 'mm'
]; ?>

<article class="card card--author">
	<div style="background-image: url(<?php echo esc_attr(get_avatar_url(get_the_author_meta('ID'), $avatarArgs)); ?>);" title="<?php echo esc_attr(get_the_author_meta('display_name')); ?>" class="card--author__avatar" role="img"></div>
	<div class="card--author__wrapper">
		<h2 class="card--author__title my-0"><?php esc_html_e('Über den Autor', 'nostrasponte'); ?></h2>
		<p class="card--author__description"><?php echo nl2br(esc_html(get_the_author_meta('description'))); ?></p>
        <div class="card--author__email-wrapper fl-center mt-2">
            <a href="mailto:<?php echo esc_attr(get_the_author_meta('user_email')); ?>" class="card--author__email btn btn--secondary"><?php echo esc_html(get_the_author_meta('user_email')); ?></a>
        </div>
	</div>
</article>
