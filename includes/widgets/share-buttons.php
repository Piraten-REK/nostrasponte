<?php

class NS_Share_Buttons extends WP_Widget {
	public function __construct() {
		parent::__construct( 'ns_social_buttons', 'Nostra Sponte Social Buttons', [
			'classname' => 'social',
			'description' => __('Fügt Teilen Buttons zur Seite hinzu', 'nostrasponte')
		] );
	}

	public function form($instance) {
		$default = [
			'title' => 'Teilen',
			'display_on_front' => false,
			'display_on_blog' => false,
			'display_on_page' => false,
			'display_on_post' => true,
			'display_on_archive' => false,
			'display_on_category' => false,
			'display_on_tag' => false,
			'display_on_date' => false,
			'display_on_search' => false,
			'display_on_404' => false,
			'display_on_attachment' => true,
			'display_on_index' => false
		];
		$instance = wp_parse_args($instance, $default);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Titel: </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']);?>">
		</p>
		<?php
		$labels = [
			'display_on_front' => 'Auf Startseite anzeigen',
			'display_on_blog' => 'Auf Blog-Seite anzeigen',
			'display_on_page' => 'Auf Seiten anzeigen',
			'display_on_post' => 'Auf Posts anzeigen',
			'display_on_archive' => 'Auf Archiv-Seiten anzeigen',
			'display_on_category' => 'Auf Kategorie-Archiven anzeigen',
			'display_on_tag' => 'Auf Tag-Archiven anzeigen',
			'display_on_date' => 'Auf Datums-Archiven anzeigen',
			'display_on_search' => 'Auf der Suchergebnisse-Seite anzeigen',
			'display_on_404' => 'Auf der 404-Seite anzeigen',
			'display_on_attachment' => 'Auf Anhangs-Seiten anzeigen',
			'display_on_index' => 'Auf index.php anzeigen'
		];
		foreach(array_filter(array_keys($default), function($key) { return substr($key, 0, 11) === 'display_on_'; }) as $field_name) {
			?>
			<p>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id($field_name); ?>" name="<?php echo $this->get_field_name($field_name); ?>" <?php if ($instance[$field_name]) echo 'checked="checked"'; ?>>
				<label for="<?php echo $this->get_field_id($field_name); ?>"><?php echo $labels[$field_name]; ?></label>
			</p>
			<?php
		}
	}

	public function update($new_instance, $old_instance) {
		$instance = [];
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['display_on_front'] = strip_tags($new_instance['display_on_front']);
		$instance['display_on_blog'] = strip_tags($new_instance['display_on_blog']);
		$instance['display_on_page'] = strip_tags($new_instance['display_on_page']);
		$instance['display_on_post'] = strip_tags($new_instance['display_on_post']);
		$instance['display_on_archive'] = strip_tags($new_instance['display_on_archive']);
		$instance['display_on_category'] = strip_tags($new_instance['display_on_category']);
		$instance['display_on_tag'] = strip_tags($new_instance['display_on_tag']);
		$instance['display_on_date'] = strip_tags($new_instance['display_on_date']);
		$instance['display_on_search'] = strip_tags($new_instance['display_on_search']);
		$instance['display_on_404'] = strip_tags($new_instance['display_on_404']);
		$instance['display_on_attachment'] = strip_tags($new_instance['display_on_attachment']);
		$instance['display_on_index'] = strip_tags($new_instance['display_on_index']);
		return $instance;
	}

	public function widget($args, $instance) {
		extract( $args );
		extract( $instance );

		/**
		 * @var string $title
		 * @var string $before_widget
		 * @var string $before_title
		 * @var string $after_title
		 * @var string $after_widget
		 * @var string|null $display_on_front,
		 * @var string|null $display_on_blog,
		 * @var string|null $display_on_page,
		 * @var string|null $display_on_post
		 * @var string|null $display_on_archive,
		 * @var string|null $display_on_category,
		 * @var string|null $display_on_tag,
		 * @var string|null $display_on_date,
		 * @var string|null $display_on_search,
		 * @var string|null $display_on_404,
		 * @var string|null $display_on_attachment
		 * @var string|null $display_on_index
		 */

		if (
			is_front_page() && isset($display_on_front) && $display_on_front === 'on'
			|| is_home() && isset($display_on_blog) && $display_on_blog === 'on'
			|| is_page() && isset($display_on_page) && $display_on_page === 'on'
			|| is_single() && isset($display_on_post) && $display_on_post === 'on'
			|| is_archive() && isset($display_on_archive) && $display_on_archive === 'on'
			|| is_category() && isset($display_on_category) && $display_on_category === 'on'
			|| is_tag() && isset($display_on_tag) && $display_on_tag === 'on'
			|| is_date() && isset($display_on_date) && $display_on_date === 'on'
			|| is_search() && isset($display_on_search) && $display_on_search === 'on'
			|| is_404() && isset($display_on_404) && $display_on_404 === 'on'
			|| is_attachment() && isset($display_on_attachment) && $display_on_attachment === 'on'
			|| is_page_template('default') && isset($display_on_index) && $display_on_index === 'on'
		) {
			$title = apply_filters( 'widget_title', $title );
			echo $before_widget;
			echo $before_title . $title . $after_title;
			get_template_part( 'partials/widgets/share-buttons' );
			echo $after_widget;
		}
	}
}