<?php

/**
 * Checks if current page/post template is themes index.php
 * @return boolean true if template file is index.php
 */
function is_index() {
	return $GLOBALS['current_theme_template'] === 'index.php';
}

define ('NS_DAY_OF_WEEK_COMP', [
	_x( 'Sonntag', 'Day of Week', 'nostrasponte' ),
	_x( 'Montag', 'Day of Week', 'nostrasponte' ),
	_x( 'Dienstag', 'Day of Week', 'nostrasponte' ),
	_x( 'Mittwoch', 'Day of Week', 'nostrasponte' ),
	_x( 'Donnerstag', 'Day of Week', 'nostrasponte' ),
	_x( 'Freitag', 'Day of Week', 'nostrasponte' ),
	_x( 'Samstag', 'Day of Week', 'nostrasponte' )
]);

define(
	'NS_DAY_OF_WEEK',
	array_map(function ($it) { return substr($it, 0, 2); }, NS_DAY_OF_WEEK_COMP)
);

define( 'NS_MONTH', [
	__( 'Januar', 'nostrasponte' ),
	__( 'Februar', 'nostrasponte' ),
	__( 'März', 'nostrasponte' ),
	__( 'April', 'nostrasponte' ),
	__( 'Mai', 'nostrasponte' ),
	__( 'Juni', 'nostrasponte' ),
	__( 'Juli', 'nostrasponte' ),
	__( 'August', 'nostrasponte' ),
	__( 'September', 'nostrasponte' ),
	__( 'Oktober', 'nostrasponte' ),
	__( 'November', 'nostrasponte' ),
	__( 'Dezember', 'nostrasponte' )
] );

/**
 * Renders the pagination for the Nostra Sponte Theme
 *
 * @param WP_Query $wp_query Current query
 * @param string $addClass class(es) to add to the container of the pagination, default ``
 * @param bool $echo Whether to echo or return the pagination, default true
 * @return string|void
 */
function ns_pagination( WP_Query $wp_query, string $addClass = '', bool $echo = true) {
	$pages = isset( $wp_query->max_num_pages ) ? intval( $wp_query->max_num_pages ) : 1;
	if ( $pages <= 1 ) return;
	$current = get_query_var( 'paged' ) > 0 ? intval( get_query_var( 'paged' ) ) : 1;

	function build_link ( int $page = null ) {
		$query = is_search() ? '?s=' . urlencode( get_query_var( 's' ) ) : '';
		global $wp;
		$link = home_url( $wp->request );
		if ( strpos( $link, '/page/' ) ) $link = substr( $link, 0, strpos( $link, '/page/' ) );
		switch ( $page ) {
			case null:
			case 1:
				return esc_url($link . $query);
			default:
				return esc_url($link . '/page/' . $page . $query);
		}
	}

	function page_attr ( int $page ) {
		if ( $page === 1 ) return esc_attr_x( 'Erste Seite', 'Pagination', 'nostrasponte' );
		elseif ( $page === -1 ) return esc_attr_x( 'Letzte Seite', 'Pagination', 'nostrasponte' );
		else return esc_attr( sprintf( _x( 'Seite %d', 'Pagination', 'nostrasponte' ), $page ) );
	}
	function jump_attr (int $page) {
		if ( $page === 1 ) return esc_attr_x( 'Zur ersten Seite wechseln', 'Pagination', 'nostrasponte' );
		elseif ( $page === -1 ) return esc_attr_x( 'Zur letzten Seite wechseln', 'Pagination', 'nostrasponte' );
		else return esc_attr( sprintf( _x( 'Zu Seite %d wechseln', 'Pagination', 'nostrasponte' ), $page ) );
	}
	function cur_attr ( int $page ) {
		return esc_attr( sprintf( _x( 'Aktuell auf Seite %d', 'Pagination', 'nostrasponte' ), $page ) );
	}

	$addClass = esc_attr( empty( $addClass ) ? $addClass : ' ' . $addClass );

	$return = "<div class=\"pagination-wrapper${addClass}\">";

	$render = [];
	if ( $current <= 4 ) $render = [ 2, 3, 4, -1, $pages - 1 ];
	elseif ( $current >= $pages - 3 ) $render = [ 2, -1, $pages - 3, $pages - 2, $pages - 1 ];
	else $render = array_filter( array_unique( [ $current - 1, $current, $current + 1 ] ), function ( int $it ) use ( $pages ) { return $it > 1 && $it < $pages; } );
	$hellip = [
		'pre'   => $current - 2 > 1,
		'after' => $current + 2 < $pages
	];

	$return .= '<nav class="pagination" role="navigation">';
	$return .= $current === 1 ? '<span class="pagination__prev feather icon-chevron-left" title="' . esc_attr_x( 'Eine Seite zurück', 'Pagination', 'nostrasponte' ) . '"></span>' : '<a class="pagination__prev feather icon-chevron-left" rel="prev" href="' . build_link( $current - 1 ) . '" title="' . esc_attr_x( 'Eine Seite zurück', 'Pagination', 'nostrasponte' ) . '"></a>';
	$return .= $current === 1 ? '<span class="pagination__first pagination__current" title="' . page_attr( 1 ) . '"><span>1</span></span>' : '<a class="pagination__first" rel="first" href="' . build_link( 1 ) . '" title="' . jump_attr( 1 ) . '"><span>1</span></a>';

	if ( $pages <= 7 ) {
		for ($i = 2; $i <= min(7, $pages - 1); $i++) {
			$return .= $current === $i ? '<span class="pagination__current" title="' . page_attr( $i ) . '"><span>' . $i . '</span></span>' : '<a class="pagination__num" href="' . build_link( $i ) . '" title="' . jump_attr( $i ) . '"><span>' . $i . '</span></a>';
		}
	} else {
		if ( !in_array( -1, $render ) && $hellip['pre'] ) $return .= '<span class="pagination__ellipsis"><span>&hellip;</span></span>';
		foreach ( $render as $i ) {
			if ( $i === -1 ) $return .= '<span class="pagination__ellipsis"><span>&hellip;</span></span>';
			else $return .= $current === $i ? '<span class="pagination__current" title="' . cur_attr( $i ) . '"><span>' . $i . '</span></span>' : '<a class="pagination__num" href="' . build_link( $i ) . '" title="' . jump_attr( $i ) . '"><span>' . $i . '</span></a>';
		}
		if ( !in_array( -1, $render ) && $hellip['after'] ) $return .= '<span class="pagination__ellipsis"><span>&hellip;</span></span>';
	}

	$return .= $current === $pages ? '<span class="pagination__last pagination__current" title="' . page_attr( -1 ) . '"><span>' . $pages . '</span></span>' : '<a class="pagination__last" rel="last" href="' . build_link( $pages ) . '" title="' . jump_attr( -1 ) . '"><span>' . $pages . '</span></a>';
	$return .= $current === $pages ? '<span class="pagination__next feather icon-chevron-right" title="' . esc_attr_x( 'Eine Seite weiter', 'Pagination', 'nostrasponte' ) . '"></span>' : '<a class="pagination__next feather icon-chevron-right" rel="next" href="' . build_link( $current + 1 ) . '" title="' . esc_attr_x( 'Eine Seite weiter', 'Pagination', 'nostrasponte' ) . '"></a>';
	$return .= '</nav>';

	$return .= '</div>';

	if ( $echo ) echo $return;
	else return $return;
}