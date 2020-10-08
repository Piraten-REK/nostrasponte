<?php

/**
 * Class NS_Custom_Nav_Walker
 *
 * Custom Menu Walker for extra functionality
 */
class NS_Custom_Nav_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$class = $this->is_separator($item) ? $this->get_container_class($args, '__separator') : '';
		if (!empty($item->classes[0])) $class .= ' ' . $item->classes[0];
		$class = trim($class);
		if ($class === '') $class = null;

		$this->render_el($output, $item, $args, $class);
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	protected function get_container_class(stdClass $args, string $add = '') {
		$class = null;
		if ($args !== null) {
			if (!empty($args->container_class)) $class = explode(' ', $args->container_class)[0];
			if (!empty($args->menu_class)) $class = explode(' ', $args->menu_class)[0];
		}
		if ($class === null || preg_match('/^(?:[mp][xytrbl]-\d+$|(?:fl-)?center)/i', $class)) {
			$class = 'navigation';
		}
		return $class . $add;
	}

	protected function is_separator(WP_Post $item) {
		return $item->url === '#__' && $item->title === '---';
	}

	protected function render_el(&$output, $item, $args, $class) {
		if ($this->is_separator($item)) {
			$output .= '<li' . (is_null($class) ? '' : ' class="' . $class .'"') . '>';
			$output .= '<hr>';
		} else {
			$output .= '<li' . (is_null($class) ? '' : ' class="' . $class .'"') . '>';
			$output .= $args->before;
			$output .= '<a href="' . $item->url . '"';
			if (!empty($item->target)) $output .= ' target="' . $item->target . '"';
			if (!empty($item->attr_title)) $output .= ' title="' . $item->attr_title . '"';
			if (!empty($item->xfn)) $output .= ' rel="' . $item->xfn . '"';
			$output .= '>';
			$output .= $args->link_before . $item->title . $args->link_after;
			$output .= '</a>';
			$output .= $args->after;
		}
	}
}