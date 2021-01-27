<?php

class NS_Calendar_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'ns_calendar_widget', 'Nostra Sponte Calendar Widget', [
			'classname'     => 'ns-calendar-container',
			'description'   => __('Fügt das Kalender Widget zur Website hinzu', 'nostrasponte')
		] );
	}

	public function form( $instance ) {
		$default = [
			'title' => 'Unsere Termine',
			'url'   => ''
		];
		$instance = wp_parse_args($instance, $default);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Titel:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>">URL von der die Daten abgerufen werden sollen:</label>
			<input type="url" class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo esc_attr($instance['url']); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = [];
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = strip_tags($new_instance['url']);
		return $instance;
	}

	public function widget( $args, $instance ) {
		extract($args);
		extract($instance);

		/**
		 * @var string $title
		 * @var string $url
		 * @var string $before_widget
		 * @var string $before_title
		 * @var string $after_title
		 * @var string $after_widget
		 */

		$days = NS_DAY_OF_WEEK_COMP;
		array_shift($days);
		array_push($days, NS_DAY_OF_WEEK_COMP[0]);

		$title = apply_filters('widget_title', $title);
		echo $before_widget;
		echo $before_title . $title .$after_title;
		get_template_part('partials/widgets/calendar', null, [
			'url'                   => $url[strlen($url) - 1] === '/' ? $url : $url . '/',
			'next'                  => '&#xe829;',
			'prev'                  => '&#xe828;',
			'eventStringSingular'   => _x('Ein Termin', 'Calendar Widget: event string singular', 'nostrasponte'),
			'eventStringPlural'     => _x('$num Termine', 'Calendar Widget: event string plural', 'nostrasponte'),
			'eventStringNone'       => _x('Keine Termine', 'Calendar Widget: event string none', 'nostrasponte'),
			'days'                  => $days,
			'months'                => NS_MONTH
		]);
		echo $after_widget;
	}
}