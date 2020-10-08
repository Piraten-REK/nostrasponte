<?php

class NS_Primary_Nav_Walker extends NS_Custom_Nav_Walker {
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$class = $this->get_container_class($args, '__item');
		if ($this->is_search($item)) $class .= ' ' . $this->get_container_class($args, '__search');
		if ($this->is_separator($item)) $class = $this->get_container_class($args, '__separator');
		if (!empty($item->classes[0])) $class .= ' ' . $item->classes[0];
		$class = trim($class);
		if ($class === '') $class = null;

		if ($this->is_search($item)) {
			$output .= '<li class="' . $class;
			if (!empty($item->attr_title)) $output .= ' title="' . $item->attr_title . '"';
			$output .= '">';
			$output .= get_search_form([ 'echo' => false ]);
		} else if ($this->is_label($item)) {
			$output .= '<li class="' . $class . '">';
			$output .= $args->before;
			$output .= '<span class="' . $this->get_container_class($args, '__label');
			if (!empty($item->attr_title)) $output .= ' title="' . $item->attr_title . '"';
			$output .= '">';
			$output .= $item->title;
			$output .= '</span>';
			$output .= $args->after;
		} else {
			$this->render_el($output, $item, $args, $class);
		}
	}

	private function is_label(WP_Post $item) {
		return $item->url === '#__label';
	}

	private function is_search(WP_Post $item) {
		return $item->url === '#__search';
	}

	static public function fallback() {
		return '<nav class="site-header__navigation px-2 py-4 px-md-4"><ul><li class="site-header__navigation__item"><a href="' . get_home_url() . '">Home</a></li></ul></nav>';
	}
}