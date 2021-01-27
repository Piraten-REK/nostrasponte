<?php
/** @var mixed $args */
extract($args);

/**
 * @var string $url
 * @var string $next
 * @var string $prev
 * @var string $eventStringSingular
 * @var string $eventStringPlural
 * @var string $eventStringNone
 * @var string[] $days
 * @var string[] $months
 */
?>
<div class="nostrasponte-calendar-widget__placeholder loading" data-url="<?php echo esc_url($url); ?>" data-next="<?php echo esc_attr($next); ?>" data-prev="<?php echo esc_attr($prev); ?>" data-event-singular="<?php echo esc_attr($eventStringSingular); ?>" data-event-plural="<?php echo esc_attr($eventStringPlural); ?>" data-event-none="<?php echo esc_attr($eventStringNone); ?>" data-days="<?php echo esc_attr(join(',', $days)); ?>" data-months="<?php echo esc_attr(join(',', $months)); ?>"></div>
