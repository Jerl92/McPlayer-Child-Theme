<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package chichi
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<div class="loader"></div>
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'chichi' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php

			$search_ = $_GET['s'];

			if($search_ != ''){
			$paged = $wp_query->get( 'paged' );
			
			if ( ! $paged || $paged < 2 ) {
				$terms = get_terms( array(
					'taxonomy' => 'artist',
					'name__like' => get_search_query(),
					'hide_empty' => true,
				) );
	
				echo '<div class="searchartist">';
				foreach ($terms as $term){
					
					$get_albums_args = array(
						'post_type' => 'attachment',
						'posts_per_page' => -1,
						'post_mime_type' => 'image',
						'meta_key' => 'meta-box-year',
						'orderby' => 'meta_value_num',
						'order' => 'ASC',
						'tax_query' => array(
							array(
								'taxonomy' => 'artist',
								'field'    => 'name',
								'terms'    => $term->name
							)
						)
					);
	
					$get_albums = get_posts($get_albums_args);
	
					$get_songs_args = array(
						'post_type' => 'music',
						'posts_per_page' => -1,
						'order' => 'ASC',
						'tax_query' => array(
							array(
								'taxonomy' => 'artist',
								'field'    => 'name',
								'terms'    => $term->name
							)
						)
					);
	
					$get_songs = get_posts($get_songs_args);
	
	
					if ($get_songs) {
	
						$i = 0;
						$get_songs_calc = [];
	
						foreach ($get_songs as $get_songs_time) {
							$get_songs_calc[$i++] =  seconds_from_time(get_post_meta($get_songs_time->ID, 'meta-box-track-length', true));
						}
					}
	
					echo '<li style="list-style: none; text-align: center; width: 50%; float: left; border-bottom: .25px solid rgba(0,0,0,.75); border-right: .25px solid rgba(0,0,0,.75); padding: 10px 0;"><a href="' . esc_attr(get_term_link($term, $taxonomy)) . '" title="' . sprintf(__("View all posts in %s"), $term->name) . '" ' . '><img style="height: 150px; display: flex; margin-left: auto; margin-right: auto;" src="' . z_taxonomy_image_url($term->term_id) . '"><p style="margin: 0;">' . $term->name . '</p></img></a>';
					echo '<p style="margin: 0; float: left; padding-left: 2.5%;">';
					echo count($get_albums);
					echo ' albums - ';
					echo count($get_songs);
					echo ' songs - ';
					echo time_from_seconds(array_sum($get_songs_calc));
					echo '</p>';
					echo '<p style="margin: 0; padding-right: 2.5%; float: right;">';
	
					echo get_post_meta($get_albums[0]->ID,  "meta-box-year", true);
					echo ' - ';
					echo get_post_meta($get_albums[count($get_albums) - 1]->ID,  "meta-box-year", true);
	
					echo '</p></li>';
				}
				echo '</div>';

				$args = array(
					'posts_per_page' => -1,
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					's'           => get_search_query()
				);
			
				$get_attachments = get_posts( $args );
			
				$count_attachments = count($get_attachments);
				if($count_attachments > 0){
					foreach ($get_attachments as $get_attachment) {
						$getslugid = get_the_terms( $get_attachment->ID, 'artist' );
						if ($getslugid) {
							$getslugid = wp_get_post_terms($get_attachment->ID, 'artist');
							foreach ($getslugid as $thisslug) {
								$artist_slug_name = $thisslug->name; // Added a space between the slugs with . ' '
							}
							foreach ($getslugid as $thisslug) {
								$_slug_name = $thisslug->slug; // Added a space between the slugs with . ' '
							}
					
					
					
							$get_songs_args = array(
								'post_type' => 'music',
								'posts_per_page' => -1,
								'meta_key' => 'meta-box-media-cover_',
								'meta_value' => $get_attachment->ID,
								'order' => 'DESC',
								'tax_query' => array(
									array(
										'taxonomy' => 'artist',
										'field'    => 'name',
										'terms'    => $artist_slug_name
									)
								)
							);
					
							$get_songs = get_posts($get_songs_args);
					
							$i = 0;
							$get_songs_calc = [];
					
							foreach ($get_songs as $get_songs_time) {
								$get_songs_calc[$i++] =  seconds_from_time(get_post_meta($get_songs_time->ID, 'meta-box-track-length', true));
							}
					
							?>
							<div class="" style="width: 19.5%; display: inline-block; padding: 0 0.25% 0 0.25%">
								<h2 style="margin: 0;"><a href="/artist/<?php echo $_slug_name ?>?album=<?php echo $get_attachment->ID; ?>" rel="bookmark">
										<?php echo get_the_title($get_attachment->ID); ?>
									</a></h2>
								<a href="/artist/<?php echo $_slug_name ?>?album=<?php echo $get_attachment->ID; ?>"><?php echo wp_get_attachment_image($get_attachment->ID, array('350', '350')); ?></a>
								<div style="float: left; max-width: calc(100% - 40px);">
									<?php echo $artist_slug_name ?>
									</br>
									<?php echo count($get_songs); ?>
									</br>
									<?php echo time_from_seconds(array_sum($get_songs_calc)); ?>
								</div>
								<div style="float: right; margin: 25px 15px 0 0;">
									<?php echo do_shortcode('[simplicity-save-for-later-loop-album album_id="' . $get_attachment->ID . '"]'); ?>
								</div>
							</div>
							<?php
						}
					}
				}

			}

		}

			echo '<div class="searchartist">';
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					if(get_post_type() == 'music') {
						get_template_part( 'template-parts/page-music-archive', 'search' );
					}

				endwhile;
			echo '</div>';

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
