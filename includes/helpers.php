<?php

/**
 * Checks if current page/post template is themes index.php
 * @return boolean true if template file is index.php
 */
function is_index() {
	return $GLOBALS['current_theme_template'] === 'index.php';
}