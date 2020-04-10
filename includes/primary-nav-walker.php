<?php

class NS_Primary_Nav_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = [] ) {
		$output .= '<ul>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		global $post;
		$output .= '<li>';
		$output .= $args->before;
		if ($this->checkForTopButton($item, $depth)) {
			$output .= '<button>';
			$output .= $args->link_before . $item->title . $args->link_after;
			$output .= '</button>';
		} elseif ($this->checkForHr($item, $depth)) {
			$output .= '<hr>';
		} elseif ($item->object === 'page' && intval($item->object_id) === $post->ID) {
			$output .= '<a href="#">';
			$output .= $args->link_before . $item->title . $args->link_after;
			$output .= '</a>';
		} else {
			$output .= '<a href="' . $item->url . '">';
			$output .= $args->link_before . $item->title . $args->link_after;
			$output .= '</a>';
		}
		$output .= $args->after;
	}

	public function end_el( &$output, $item, $depth = 0, $args = [] ) {
		$output .= '</li>';
	}

	public function end_lvl( &$output, $depth = 0, $args = [] ) {
		$output .= '</ul>';
	}

	private function checkForTopButton($item, $depth): bool {
		return $depth === 0 && $item->url === '';
	}

	private function checkForHr($item, $depth): bool {
		return $depth > 0 && $item->title === '---' && $item->url === '#'
			|| $depth > 0 && $item->title === '---' && $item->url === '';
	}
}
