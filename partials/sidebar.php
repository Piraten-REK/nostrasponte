<?php

function getShareLink($platform) {
    switch (strtolower($platform)) {
        case 'twitter':
            return 'https://twitter.com/tweet/intent?text=' . urlencode(get_the_title()) . '&url=' . urlencode(get_the_permalink()) . '&via=P1R4T3N';
        case 'facebook':
            return 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode(get_the_permalink()) . (has_post_thumbnail() ? '&picture=' . urlencode(get_the_post_thumbnail_url()) : (has_site_icon() ? '&picture=' . urlencode(get_site_icon_url()) : '')) . '&title=' . urlencode(get_the_title()) . '&description=' . urlencode(wp_trim_words(get_the_excerpt(), 12, '…')) . '&caption=' . urlencode(get_bloginfo('title'));
        case 'reddit':
            return 'https://www.reddit.com/submit?url=' . urlencode(get_the_permalink()) . '&title=' . urlencode(get_the_title() . ' – ' . get_bloginfo('title'));
        case 'whatsapp':
            return 'whatsapp://send?text=' . urlencode(get_the_permalink() . "\n" . get_the_title() . ' – ' . get_bloginfo('title'));
        case 'telegram':
            return 'https://telegram.me/share/url?url=' . urlencode(get_the_permalink()) . '&text=' . urlencode(get_the_title() . ' – ' . get_bloginfo('title'));
        case 'mail':
            return 'mailto:info@piratenpartei-rhein-erft.de?subject=' . urlencode(get_the_title() . ' – ' . get_bloginfo('title')) . '&body=' . urlencode(get_the_title() . ' auf der Website der ' . get_bloginfo('title') . "\n\n" . get_the_permalink()); 
        default:
            throw new Error();
    }
}

function shareLink($platform) {
    echo getShareLink($platform);
}

?>
<aside id="sidebar">
    <section id="search">
        <h2 title="Seite dursuchen" aria-label="Suchen">Suche</h2>
        <form action="<?php echo site_url(''); ?>" role="search" method="get">
            <input id="s" type="search" value="<?php if (is_search()) { echo $_GET['s']; } ?>" placeholder="Suche" name="s">
            <input id="searchsubmit" type="submit" value="&#xe909;" tabindex="-1">
        </form>
    </section>
    <!-- ORT INFO -->
    <?php if (is_single()): ?><section id="share">
        <h2 title="Diesen Artikel teilen" aria-label="Diesen Artikel teilen">Teilen</h2>
        <ul>
            <li><a class="twitter" href="<?php shareLink('twitter'); ?>" target="_blank" title="twittern"></a></li>
            <li><a class="facebook" href="<?php shareLink('facebook'); ?>" target="_blank" title="auf Facebook posten"></a></li>
            <li><a class="reddit" href="<?php shareLink('reddit'); ?>" target="_blank" title="auf Reddit posten"></a></li>
            <li><a class="whatsapp" href="<?php shareLink('whatsapp'); ?>" target="_blank" title="per WhatsApp verschiken"></a></li>
            <li><a class="telegram" href="<?php shareLink('telegram'); ?>" target="_blank" title="per Telegram verschicken"></a></li>
            <li><a class="mail" href="<?php shareLink('mail'); ?>" title="per Mail verschicken"></a></li>
            <li><button class="link" data-link="<?php the_permalink(); ?>" title="Link kopieren"></button></a>
        </ul>
    </section>
    <section id="author">
        <h2>Der Autor</h2>
        <a class="author_avatar no_img" href="<?php the_author_url(); ?>">
            <img src="<?php echo get_avatar_url(get_the_author_ID(), array('size'=>450)) ?>">
        </a>
        <a class="author_name" href="<?php the_author_url(); ?>">
            <h3>
                <span>@<?php the_author_nickname(); ?></span>
                <?php the_author_firstname(); ?> <?php the_author_lastname(); ?>
            </h3>
        </a>
    </section><?php endif; ?>
    <section id="calendar">
        <h2 title="Unsere Termine" aria-label="Termine">Triff uns!</h2>
        <?php $ms = array(
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mär',
            '04' => 'Apr',
            '05' => 'Mai',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Okt',
            '11' => 'Nov',
            '12' => 'Dez'
        );
        $args = array(
            'posts_per_page' => 5,
            'post_type' => 'appointment',
            'meta_key' => 'date',
            'orderby' => 'meta_value',
            'order' => 'DESC'
        );
        $query = new WP_Query($args);
        while ($query -> have_posts()): $query -> the_post();
        [$y, $m, $d] = explode('-', get_field('date'));
        $M = $ms[$m] ?>
        <article data-year="<?php echo $y; ?>" data-month="<?php echo $m; ?>" data-day="<?php echo $d; ?>" data-time-start="<?php the_field('start'); ?>" data-time-end="<?php the_field('end'); ?>" title="<?php the_title(); ?>&#013;<?php echo "$d. $M. $y" . (get_field('start') ? ', ' . get_field('start') . (get_field('end') ? ' - ' . get_field('end') : '') . ' Uhr' : ''); ?>" class="calendar">
            <a href="<?php the_permalik(); ?>">
                <header>
                    <p class="date"><span class="day"><?php echo (int) $d; ?></span><span class="month"><?php echo $M; ?></span></p>
                    <h5><?php the_title(); ?></h5>
                </header>
                <div class="more">
                    <table>
                        <tbody>
                            <?php if (get_field('start')): ?><tr class="time">
                                <th></th>
                                <td><?php the_field('start'); if (get_field('end')) echo ' bis ' . get_field('end'); ?> Uhr</td>
                            </tr><?php endif; ?>
                            <tr class="place">
                                <th></th>
                                <td><?php echo get_field('mumble') ? 'Mumble Server der Piratenpartei NRW<br><a href="mumble://">Link zum Mumble</a>' : preg_replace("/<br ?\/?>\r?\n?/", ', ', get_field('place')) ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php if (get_the_content() !== ''): ?><p class="text"><?php echo wp_trim_words(str_replace('&', '&amp;', get_the_content()), 30); ?></p><?php endif; ?>
                </div>
            </a>
    </article><?php endwhile; wp_reset_query(); ?>
    <a href="<?php echo site_url('termine'); ?>" class="showmore" alt="Alle Termine anzeigen">alle Termine anzeigen</a>
    </section>
</aside>