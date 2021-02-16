<?php

function ns_defer_js ($tag, $handle, $src) {
	if (is_admin()) return $tag;
	return '<script src="' . esc_url($src) . '"' . ($handle === 'ns_main_js' ? 'type="module"' : '') . '></script>';
}