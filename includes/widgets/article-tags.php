<?php
class Ns_Article_Tags extends WP_Widget {
    public function __construct() {
    	$widget_ops = [
		    'description' => 'Zeigt die Tags eines Artikel an.'
	    ];
    	parent::__construct('ns_article_tags_widget', 'Artikel Tags', $widget_ops);
    }

    public function form($instance) {
    	$default = [
    		'title' => 'Tags'
	    ];
    	$instance = wp_parse_args($instance, $default);
    	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Titel: </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']);?>">
		</p>
		<?php
    }

    public function update($new_instance, $old_instance) {
    	$instance = [];
    	$instance['title'] = strip_tags($new_instance['title']);
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
	     */

    	if (is_single()) {
		    global $post;
		    if ($post->post_type === 'post') {
			    $title = apply_filters( 'widget_title', $title );
			    echo $before_widget;
			    echo $before_title . $title . $after_title;
			    foreach (get_tags() as $tag) {
			    	?>
					<a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a>
					<?php
			    }
			    echo $after_widget;
		    }
	    }
    }
}