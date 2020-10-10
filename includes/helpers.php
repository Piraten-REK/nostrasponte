<?php

/**
 * Checks if current page/post template is themes index.php
 * @return boolean true if template file is index.php
 */
function is_index() {
	return $GLOBALS['current_theme_template'] === 'index.php';
}

define( 'NS_DAY_OF_WEEK', [
	'So',
	'Mo',
	'Di',
	'Mi',
	'Do',
	'Fr',
	'Sa'
] );

define( 'NS_MONTH', [
	'Januar',
	'Februar',
	'März',
	'April',
	'Mai',
	'Juni',
	'Juli',
	'August',
	'September',
	'Oktober',
	'November',
	'Dezember'
] );