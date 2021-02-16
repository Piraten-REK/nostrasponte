<?php
function ns_get_share_link($platform) {
	$url = str_replace('+', '%20', urlencode( get_the_permalink() ));
	$title = str_replace('+', '%20', urlencode( get_the_title() ));
	$blog_title = str_replace('+', '%20', urlencode( get_bloginfo( 'title' ) ));
	$title_tag = str_replace('+', '%20', urlencode( html_entity_decode( wp_get_document_title(), ENT_NOQUOTES | ENT_HTML5 ) ));
	$desc = str_replace('+', '%20', urlencode( wp_trim_words( get_the_excerpt(), 12, '…' ) ));
	$img = str_replace('+', '%20', urlencode( has_post_thumbnail() ? get_the_post_thumbnail_url() : get_site_icon_url() ));
	$newLine = '%0A';

	switch (strtolower($platform)) {
		case 'facebook':
			return "https://www.facebook.com/sharer/sharer.php?u=${url}&picture=${img}&title=${title}&description=${desc}&caption=${blog_title}";
		case 'twitter':
			return "https://twitter.com/intent/tweet?text=${title_tag}&url=${url}&via=Piraten_REK";
		case 'reddit':
			return "https://www.reddit.com/submit?url=${url}&title=${title_tag}";
		case 'mastodon':
			return "web+toot:share?text=${title_tag}$newLine${url}";
		case 'whatsapp':
			return "whatsapp://send?text=${title_tag}$newLine${url}";
		case 'telegram':
			return "https://telegram.me/share/url?url=${url}&text=${title_tag}";
		case 'mail':
			return "mailto:?to=&subject=${title_tag}&body=${url}";
		default:
			throw new Error('Nope');
	}
}

function ns_share_link($platform) {
	echo ns_get_share_link($platform);
}
?>
<ul class="site-sidebar__social__buttons--fallback">
    <li><a href="<?php ns_share_link('facebook'); ?>" target="_blank" class="site-sidebar__social__link--facebook link--no-mark"></a></li>
    <li><a href="<?php ns_share_link('twitter'); ?>" target="_blank" class="site-sidebar__social__link--twitter link--no-mark"></a></li>
    <li><a href="<?php ns_share_link('reddit'); ?>" target="_blank" class="site-sidebar__social__link--reddit link--no-mark"></a></li>
    <li><a href="<?php ns_share_link('mastodon'); ?>" target="_blank" class="site-sidebar__social__link--mastodon link--no-mark"></a></li>
    <li><a href="<?php ns_share_link('whatsapp'); ?>" target="_blank" class="site-sidebar__social__link--whatsapp link--no-mark"></a></li>
    <li><a href="<?php ns_share_link('telegram'); ?>" target="_blank" class="site-sidebar__social__link--telegram link--no-mark"></a></li>
    <li><button class="site-sidebar__social__link--link" data-url="<?php the_permalink(); ?>"></button></li>
    <li><a href="<?php ns_share_link('mail'); ?>" class="site-sidebar__social__link--mail link--no-mark"></a></li>
</ul>
<button class="site-sidebar__social__buttons--share-api" data-title="<?php echo esc_attr(wp_get_document_title()); ?>" data-text="<?php echo esc_attr(get_the_excerpt()); ?>" data-url="<?php echo esc_attr(get_the_permalink()); ?>">
    <div class="site-sidebar__social__buttons--share-api__circle feather icon-share-2 mr-4"></div>
    <div class="site-sidebar__social__buttons--share-api__bubble">Jetzt teilen</div>
</button>
