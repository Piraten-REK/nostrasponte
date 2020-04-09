<?php
function getShareLink($platform) {
	switch (strtolower($platform)) {
		case 'twitter':
			return 'https://twitter.com/intent/tweet?text=' . urlencode(get_the_title()) . '&url=' . urlencode(get_the_permalink()) . '&via=Piraten_REK';
		case 'facebook':
			return 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode(get_the_permalink()) . (has_post_thumbnail() ? '&picture=' . urlencode(get_the_post_thumbnail_url()) : (has_site_icon() ? '&picture=' . urlencode(get_site_icon_url()) : '')) . '&title=' . urlencode(get_the_title()) . '&description=' . urlencode(wp_trim_words(get_the_excerpt(), 12, '…')) . '&caption=' . urlencode(get_bloginfo('title'));
		case 'reddit':
			return 'https://www.reddit.com/submit?url=' . urlencode(get_the_permalink()) . '&title=' . urlencode(get_the_title() . ' – ' . get_bloginfo('title'));
		case 'whatsapp':
			return 'whatsapp://send?text=' . urlencode(get_the_permalink() . "\n" . get_the_title() . ' – ' . get_bloginfo('title'));
		case 'telegram':
			return 'https://telegram.me/share/url?url=' . urlencode(get_the_permalink()) . '&text=' . urlencode(get_the_title() . ' – ' . get_bloginfo('title'));
		case 'mail':
			return 'mailto:info@piratenpartei-rhein-erft.de?subject=' . rawurlencode(get_the_title() . ' – ' . get_bloginfo('title')) . '&body=' . rawurlencode(get_the_title() . ' auf der Website der ' . get_bloginfo('title') . "\n\n" . get_the_permalink());
        case 'mastodon':
            return 'web+toot:share?text=' . rawurldecode(wp_get_document_title() . "\n" . get_the_permalink());
		default:
			throw new Error();
	}
}

function shareLink($platform) {
	echo getShareLink($platform);
}
?>

<div class="wrapper">
    <ul>
        <li><a class="twitter" href="<?php shareLink('twitter'); ?>" target="_blank" title="twittern"></a></li>
        <li><a class="facebook" href="<?php shareLink('facebook'); ?>" target="_blank" title="auf Facebook posten"></a></li>
        <li><a class="reddit" href="<?php shareLink('reddit'); ?>" target="_blank" title="auf Reddit posten"></a></li>
        <li><a class="mastodon" href="<?php shareLink('mastodon'); ?>" target="_blank" title="auf Mastodon tooten"></a></li>
        <li><a class="whatsapp" href="<?php shareLink('whatsapp'); ?>" target="_blank" title="per WhatsApp verschiken"></a></li>
        <li><a class="telegram" href="<?php shareLink('telegram'); ?>" target="_blank" title="per Telegram verschicken"></a></li>
        <li><a class="mail" href="<?php shareLink('mail'); ?>" title="per Mail verschicken"></a></li>
        <li><button class="link" data-link="<?php the_permalink(); ?>" title="Link kopieren"></button></li>
    </ul>
</div>