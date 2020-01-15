<?php get_header();
$months = array(
    '01' => 'Januar',
    '02' => 'Februar',
    '03' => 'März',
    '04' => 'April',
    '05' => 'Mai',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'August',
    '09' => 'Sptember',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Dezember'
);
while (have_posts()): the_post();
[$y, $m, $d] = explode('-', get_field('date'));
$M = $months[$m]; ?><header>
    <h1><?php the_title(); ?></h1>
    <table>
        <tr title="Datum&#xd;<?php echo "$d. $M $y";?>">
            <th></th>
            <td><time datetime="<?php echo "$y-$m-$d"; ?>"><?php echo "$d. $M $y"; ?></time></td>
        </tr>
        <?php if (get_field('start')): ?><tr title="Uhrzeit&#013;<?php the_field('start'); if(get_field('end')) echo ' Uhr bis ' . get_field('end'); ?> Uhr">
            <th></th>
            <td><?php the_field('start'); if(get_field('end')) echo ' Uhr bis ' . get_field('end'); ?> Uhr</td>
        </tr><?php endif; ?>
        <tr title="Ort&#xd;<?php echo get_field('mumble-discord') === 'mumble' ? 'Mumble-Server der Piratenpartei NRW' : (get_field('mumble-discord') === 'discord' ? 'Discord-Server der Piratenpartei Rhein-Erft' : preg_replace("/<br ?\/?>\r?\n?/", ', ', get_field('place'))); ?>">
            <th></th>
            <td><?php switch (get_field('mumble-discord')) { case 'mumble': echo '<a href="mumble://">Mumble-Server der Piratenpartei NRW</a>'; break; case 'discord': echo '<a href="https://discord.gg/ZQJjdDn">Discord-Server der Piratenpartei Rhein-Erft</a>'; break; default: the_field('place'); break; } ?></td>
        </tr>
    </table>
</header>
<main>
<?php the_content(); ?>
    <?php if (!get_field('mumble') && get_field('osm')):
    if (get_the_content() !== '') echo '<hr>';
    the_field('osm'); endif; ?>
</main>
<?php endwhile;
include('partials/sidebar.php');
get_footer(); ?>
