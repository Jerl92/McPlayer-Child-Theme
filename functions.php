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

	add_action('after_setup_theme', 'remove_admin_bar');
	function remove_admin_bar() {
		if (!current_user_can('administrator') && !is_admin()) {
			show_admin_bar(false);
		}
	}

	function attachment_search( $query ) {
		if ( $query->is_search ) {
		   $query->set( 'post_type', array( 'post', 'attachment', 'music' ) );
		   $query->set( 'post_status', 'any' );
		   $query->set( 'posts_per_page', 50 );
		}
	 
	   return $query;
	}
	
	add_filter( 'pre_get_posts', 'attachment_search' );
	
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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'top-menu' => esc_html__( 'Top menu', 'chichi' ),
	) );

	function custom_login_redirect() {
		return home_url();
	}
	add_filter('login_redirect', 'custom_login_redirect');
?>