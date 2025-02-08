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

	function comments_template_mcplayer($image_url) {
		if($image_url != null){
			$attachment_id = attachment_url_to_postid( $image_url ); 
		} else {
			$attachment_id = get_the_ID();
		}
		echo '<div id="comments" class="comments-area">';
			echo '<div id="comments-wrapper">';
				$args = array(
					'post_id' => intval($attachment_id),
					'orderby' => 'comment_date',
					'order' => 'ASC'
				);
				$comments = get_comments($args);
				foreach($comments as $comment){
					echo '<div style="display:flex; padding-bottom:15px;" class="comment_ID_'.$comment->comment_ID.'">';
						echo '<div style="width:95%;">';
							echo $comment->comment_author;
						echo '<br>';
							echo $comment->comment_content;
						echo '</div>';
						if (intval($comment->user_id) === intval(user_if_login())){
							echo '<div class="comment_delete" data-object-id="'.$comment->comment_ID.'">';
								echo 'X';
							echo '</div>';
						}
					echo '</div>';
				}
			echo '</div>';
			echo '<div id="respond_comment" class="comment-respond">';
				echo '<h3 id="reply-title" class="comment-reply-title">Laisser un commentaire <small><a rel="nofollow" id="cancel-comment-reply-link" href="" style="display:none;">Annuler la réponse</a></small></h3><form action="" method="post" id="commentform" class="comment-form" novalidate=""><p class="comment-notes"><span id="email-notes">Votre adresse courriel ne sera pas publiée.</span> <span class="required-field-message">Les champs obligatoires sont indiqués avec <span class="required">*</span></span></p><p class="comment-form-comment"><label for="comment">Commentaire <span class="required">*</span></label> <textarea id="comment_text" name="comment" cols="45" rows="8" maxlength="65525" required=""></textarea></p><p class="comment-form-author"><label for="author">Nom <span class="required">*</span></label> <input id="author_comment" name="author" type="text" value="" size="30" maxlength="245" autocomplete="name" required=""></p>';
				echo '<p class="comment-form-email"><label for="email">Courriel <span class="required">*</span></label> <input id="email_commnent" name="email" type="email" value="" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email" required=""></p>';
				echo '<p class="comment-form-url"><label for="url">Site web</label> <input id="url" name="url" type="url" value="" size="30" maxlength="200" autocomplete="url"></p>';
				echo '<p class="form-submit"><input name="submit" type="submit" id="submit_comment" class="submit" value="Laisser un commentaire"> <input type="hidden" name="comment_post_ID" value="'. $attachment_id .'" id="comment_post_ID">';
				echo '</p></form>';
			echo '</div><!-- #respond -->';
		echo '</div>';
	}
?>