<?php

class NS_Primary_Nav_Walker extends NS_Custom_Nav_Walker {
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$class = $this->get_element_class( $item, $args );

		$this->render_el( $output, $item, $args, $class, $this->is_separator($item) ? null : 'role="treeitem"' );
	}

	private function is_label(WP_Post $item) {
		return $item->url === '#__label';
	}

	private function is_search(WP_Post $item) {
		return $item->url === '#__search';
	}

	protected function render_el( string &$output, WP_Post $item, stdClass $args, array $class, string $extra = null ) {
		$class = empty( $class ) ? null : join(' ', $class);

		if ($this->is_search($item)) {
			$output .= '<li class="' . $class;
			if (!empty($item->attr_title)) $output .= ' title="' . $item->attr_title . '"';
			$output .= '"' . (isset($extra) ? ' ' . $extra : '') . '>';
			$output .= get_search_form([ 'echo' => false ]);
		} else if ($this->is_label($item)) {
			$output .= '<li class="' . $class . '"' . (isset($extra) ? ' ' . $extra : '') . '">';
			$output .= $args->before;
			$output .= '<span class="' . $this->get_container_class($args, '__label');
			if (!empty($item->attr_title)) $output .= ' title="' . $item->attr_title . '"';
			$output .= '">';
			$output .= $item->title;
			$output .= '</span>';
			$output .= $args->after;
		} else {
			parent::render_el($output, $item, $args, explode(' ', $class), $extra);
		}
	}

	protected function get_element_class( WP_Post $item, stdClass $args ): array {
		$class = [ $this->get_container_class( $args, '__item' ) ];
		if ( $this->is_search( $item ) ) array_push( $class, $this->get_container_class( $args, '__search' ) );
		if (!empty( $item->classes ) && array_reduce( $item->classes, 'self::classCurrent', false )) array_push($class, 'current');
		return array_unique(array_map( function ( string $it ) { return trim( $it ); }, array_merge( $class, parent::get_element_class( $item, $args ))), SORT_REGULAR);
	}

	private static function classCurrent (bool $carry, string $item): bool {
		if ($carry || preg_match('/^current-/', $item)) return true;
		else return $carry;
	}


	static public function fallback() {
		return '<nav class="site-header__navigation px-2 py-4 px-md-4"><ul><li class="site-header__navigation__item"><a href="' . get_home_url() . '">Home</a></li></ul></nav>';
	}
}