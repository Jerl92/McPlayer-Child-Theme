<?php
	add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
	function my_theme_enqueue_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
		wp_enqueue_script( 'sticky', get_stylesheet_directory_uri() . '/js/sticky.js',  array('jquery'), true );
		wp_enqueue_script( 'chichi-navigation', get_stylesheet_directory_uri() . '/js/navigation.js', array('jquery'), true );
 	}

	add_action( 'wp_enqueue_scripts', 'my_chichi_navigation_enqueue' );
	function my_chichi_navigation_enqueue() {
		wp_dequeue_script( 'google-font' );
		wp_dequeue_script( 'font-awesome' );
 		wp_dequeue_script( 'chichi-navigation' );
	}

	add_action( 'after_setup_theme', 'mcplayer_support' );
	function mcplayer_support() {
		add_theme_support( 'music' );
	}

	function mytheme_pre_get_posts( $query ) {
		if ( !is_admin() && $query->is_search() && $query->is_main_query() ) {
			$term = get_term_by('name', get_query_var('s'), 'artist');
			if ($term) {
				$query->set( 'tax_query', array(
					 array(
						'taxonomy' => 'artist',
						'field'    => 'slug',
						'terms'    =>  $term->slug,
						'operator' => 'AND'
					)
				));
			 }
		}
	}
	add_action( 'pre_get_posts', 'mytheme_pre_get_posts', 1 );

	function my_pre_get_posts($query) {
		if( is_admin() ) 
			return;
	
		if( is_search() && $query->is_main_query() ) {
			$query->set('post_type', 'music');
			$query->set('post_status', 'any');
		} 
	}
	add_action( 'pre_get_posts', 'my_pre_get_posts' );
	
	/* ========================================
	 * SEARCH CUSTOM POST TYPES
	 * ======================================== */
	
	function cf_search_join( $join ) {
		global $wpdb;
	
			if ( is_search() && !is_admin() ) {    
				$join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
			}
	
		return $join;
	}
	add_filter('posts_join', 'cf_search_join' );
	
	/**
	 * Modify the search query with posts_where
	 *
	 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
	 */
	function cf_search_where( $where ) {
		global $wpdb;
	
			if ( is_search() ) {
				$where = preg_replace(
					"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
					"(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
			}
	
		return $where;
	}
	add_filter( 'posts_where', 'cf_search_where' );
	
	if (!function_exists('current_time')) {
		function current_time( $type, $gmt = 0 ) {
			// Don't use non-GMT timestamp, unless you know the difference and really need to.
			if ( 'timestamp' === $type || 'U' === $type ) {
				return $gmt ? time() : time() + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
			}
		
			if ( 'mysql' === $type ) {
				$type = 'Y-m-d H:i:s';
			}
		
			$timezone = $gmt ? new DateTimeZone( 'UTC' ) : wp_timezone();
			$datetime = new DateTime( 'now', $timezone );
		
			return $datetime->format( $type );
		}
	}
	
	if (!function_exists('mysql2date')) {
		function mysql2date( $format, $date, $translate = true ) {
			if ( empty( $date ) ) {
				return false;
			}
		
			$datetime = date_create( $date, wp_timezone() );
		
			if ( false === $datetime ) {
				return false;
			}
		
			// Returns a sum of timestamp with timezone offset. Ideally should never be used.
			if ( 'G' === $format || 'U' === $format ) {
				return $datetime->getTimestamp() + $datetime->getOffset();
			}
		
			if ( $translate ) {
				return wp_date( $format, $datetime->getTimestamp() );
			}
		
			return $datetime->format( $format );
		}
	}

	if (!function_exists('_wp_http_get_object')) {
		function _wp_http_get_object() {
			static $http = null;
		
			if ( is_null( $http ) ) {
				$http = new WP_Http();
			}
			return $http;
		}
	}
?>