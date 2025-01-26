<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chichi
 */

global $post;

get_header(); ?>

	<div id="primary" class="content-area">
		<div class="loader"></div>
		<main id="main" class="site-main" role="main">
			
			<?php 
			if ($_GET['album']) {
				$album_meta = $_GET['album']; 
				$image = get_post($album_meta);
			} 
						
			$image_title = $image->post_title;
			
			$getslugid = wp_get_post_terms( $post->ID, 'artist' );
			foreach( $getslugid as $thisslug ) {
				$artist_slug_name = $thisslug->name; // Added a space between the slugs with . ' '
			}

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
						'terms'    => $artist_slug_name
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
						'terms'    => $artist_slug_name
					)
				)
			);

			$get_songs = get_posts($get_songs_args);


			if ($get_songs) {

				$i = 0;
				$get_songs_calc = [];

				foreach ($get_songs as $get_songs_time) {
					$get_songs_calc[$i++] =  seconds_from_time(get_post_meta($get_songs_time->ID, 'meta-box-track-length', true));
					$get_count_played[$i++] = get_post_meta($get_songs_time->ID, 'count_play_loop', true);
				}
			}
			
			?>

			<div class="page-header" style="background: center no-repeat url(<?php echo z_taxonomy_image_url(); ?>); height: 225px; background-size: cover;">
				<?php
					single_term_title( '<h1 class="page-title artist-banner-info" style="width: auto;display: inline;text-shadow: -2px 0 #fff, 0 2px #fff, 2px 0 #fff, 0 -2px #fff;margin: 10px;">', '</h1>' );
					echo '<h2 class="page-title artist-banner-info" style="text-align: right; float: right;margin: 10px;text-shadow: -2px 0 #fff, 0 2px #fff, 2px 0 #fff, 0 -2px #fff;">';

						echo count($get_albums);
						echo ' albums - ';
						echo count($get_songs);
						echo ' songs';
						echo '</br>';
						echo array_sum($get_count_played);
						echo ' Plays';
						echo ' - ';
						echo time_from_seconds(array_sum($get_songs_calc));
						echo '</br>';		
						echo get_post_meta($get_albums[0]->ID,  "meta-box-year", true);
						echo ' - ';
						echo get_post_meta($get_albums[count($get_albums) - 1]->ID,  "meta-box-year", true);

					echo '</h2>';			
					//  the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</div><!-- .page-header -->

			<?php

			$getslugid = wp_get_post_terms( $post->ID, 'artist' );
			foreach( $getslugid as $thisslug ) {
				$artist_slug_name = $thisslug->name; // Added a space between the slugs with . ' '
			}

			$args = array(
				'post_type' => 'music',
				'posts_per_page' =>  1,
				'tax_query' => array(
					array(
						'taxonomy' => 'artist',
						'field'    => 'name',
						'terms'    => $artist_slug_name,
					),
				
				),
			);

			// The Query
			$the_query = new WP_Query( $args );

			if ( $album_meta == null) {

				if($the_query->have_posts()){

					while ( $the_query->have_posts() ) {

						$the_query->the_post();

						$args = array( 
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
									'terms'    => $artist_slug_name,
								),
							),
						); 

						$attachments_ = get_posts( $args );	
						$attachments = array_reverse($attachments_);
						$count = 1;
						if ( $attachments ) {
							foreach ( $attachments as $attachment ) {

								$cover_loop = get_post_meta( $post->ID , 'meta-box-media-cover_' , true );

								$album_link = add_query_arg( 'album', esc_attr($attachment->ID ) , get_site_url() & '/mcplayer/artist/' & $cover_loop &  '/' );
									
								$parsed = parse_url( wp_get_attachment_url( $attachment->ID ) );
								$url    = dirname( $parsed [ 'path' ] ) . '/' . rawurlencode( basename( $parsed[ 'path' ] ) );

								$album_year = get_post_meta( $attachment->ID , 'meta-box-year' , true );

								$get_songs_args = array( 
									'post_type' => 'music',
									'posts_per_page' => -1,
									'meta_key' => 'meta-box-media-cover_',
									'meta_value' => $attachment->ID,
									'order' => 'DESC',
									'tax_query' => array(
										array(
											'taxonomy' => 'artist',
											'field'    => 'name',
											'terms'    => $artist_slug_name
										)
									)
								); 

								$get_songs = get_posts( $get_songs_args );

								if ( $get_songs ) {
									
									$i = 0; 
									$get_songs_calc = [];

									foreach ( $get_songs as $get_songs_time ) {
										$get_songs_calc[$i++] =  seconds_from_time( get_post_meta(  $get_songs_time->ID , 'meta-box-track-length' , true ));
									}
								}

								if(strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile')){
									if ($count%2 == 1) {  
										?><div class="album-row" style="display: inline-table; width: 100%;"><?php
									}
								} else {
									if ($count%4 == 1) {  
										?><div class="album-row" style="display: inline-table; width: 100%;"><?php
									}
								}
								?>
								<ul id="album-class-artist" class="album-<?php echo $attachment->ID; ?>">
									<li>
										<a href="<?php echo $album_link; ?>">
											<img id="album-class-artist-img" src="<?php echo $url; ?>"></img>
										</a>
										<li style="float: left; max-width: calc(100% - 40px);">
												<?php echo apply_filters( 'the_title' , $attachment->post_title ); ?>
												</br>
												<?php echo count( $get_songs ); ?>
												<?php echo ' songs - '; ?>
												<?php echo time_from_seconds ( array_sum($get_songs_calc) ); ?>
												</br>
												<?php echo $album_year; ?>
			
												</li>
											<li style="float: right; margin: 25px 15px 0 0;">
												<?php echo do_shortcode( '[simplicity-save-for-later-loop-album album_id="' . $attachment->ID . '"]' ); ?>
											</li>
									</li>
								</ul>
								<?php
								if(strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile')){
									if ($count%2 == 0) {
										?></div><?php
									}
								} else {
									if ($count%4 == 0) {
										?></div><?php
									}
								}
								$count++;
							}
						}

					}
				}
				wp_reset_postdata();
			}
					 
			if ( $album_meta !== null) {

					$album_meta = $_GET['album'];
					$image = get_post($album_meta) ;
					$image_title = $image->post_title;

					$cover_loop = get_post_meta( $post->ID , 'meta-box-media-cover_' , true );

					$album_link = add_query_arg( 'album', esc_attr($album_meta ) , get_site_url() & '/mcplayer/artist/' & $cover_loop &  '/' );
						
					$parsed = parse_url( wp_get_attachment_url( $album_meta ) );
					$url    = dirname( $parsed [ 'path' ] ) . '/' . rawurlencode( basename( $parsed[ 'path' ] ) );

					$album_year = get_post_meta( $album_meta , 'meta-box-year' , true );

					$get_songs_args = array( 
						'post_type' => 'music',
						'posts_per_page' => -1,
						'meta_key' => 'meta-box-media-cover_',
						'meta_value' => $album_meta,
						'order' => 'DESC',
						'tax_query' => array(
							array(
								'taxonomy' => 'artist',
								'field'    => 'name',
								'terms'    => $artist_slug_name
							)
						)
					); 

					$get_songs = get_posts( $get_songs_args );

					if ( $get_songs ) {
						
						$i = 0; 
						$get_songs_calc = [];

						foreach ( $get_songs as $get_songs_time ) {
							$get_songs_calc[$i++] =  seconds_from_time( get_post_meta(  $get_songs_time->ID , 'meta-box-track-length' , true ));
						}
					}

					$previous = "javascript:history.go(-1)";
					if(isset($_SERVER['HTTP_REFERER'])) {
						$previous = $_SERVER['HTTP_REFERER'];
					}

					if ($_GET['album'] != '') { 

					?>
							<div class="album-class-loop">
							<span style="font-size: 25px; font-weight: 400;"><a href="<?= $previous ?>">< Back</a></span>
							</br>
								<div class="album-class-loop-info" style="float: left; max-width: calc(100% - 40px);">
									<span style="font-size: 30px; font-weight: 600;"><?php echo apply_filters( 'the_title' ,  get_the_title($album_meta) ); ?></span>
									</br>
									<span style="font-size: 25px; font-weight: 500;"><?php echo count( $get_songs ); ?>
									<?php echo ' songs'; ?></span>
									</br>
									<span style="font-size: 20px; font-weight: 400;"><?php echo time_from_seconds ( array_sum($get_songs_calc) ); ?></span>
									</br>
									<span style="font-size: 20px; font-weight: 300;"><?php echo $album_year; ?></span>
								</div>
								<div class="album-class-img">
									<img class="album-class-artist-img" src="<?php echo wp_get_attachment_url($album_meta); ?>"></img>
								</div>
							</div>
					<?php

					}

					echo "<div id='idalbum'>";

					$wp_query = new WP_Query();
					$wp_query->query('post_type=music&order=ASC&meta_value=' . $album_meta . '&orderby=meta_value_num&showposts=-1');
					$x = 0;
					$posts = array();
					echo "<table id='album-class-artist-list'>";
					while ( have_posts() ) : the_post();

						$posts[$x][0] = get_post_meta( get_the_id(), "meta-box-track-number", true );
						$posts[$x][1] = get_the_id();
						$x++;

					endwhile;
					wp_reset_postdata();

					asort($posts);

					if ($_GET['album'] != '') { 

						foreach($posts as $post) { ?>
							<tr style='width: 100%; height: 60px;'>
							<td id="album-class-artist-list-id-<?php echo $post[1]; ?>" style='text-align: center; width: 30px; padding: 0 15px;'>
								<?php echo do_shortcode( '[simplicity-save-for-later-loop id="' . $post[1] . '"]' ); ?>
							</td>
							<td style='width: 30px; display: inline-flex; text-align: center; margin auto 0; padding: 0 5px;'>
								<?php echo do_shortcode( '[add-play-now id="' . $post[1] . '"]' ); ?>
							</td>
							<td style='text-align: center; padding: 0 5px; width: 30px;'>
								<?php echo get_post_meta( $post[1], "meta-box-track-number", true ); ?>
							</td>
							<td style='text-align: left; font-size: 18px; font-weight: 400; width: 100%; padding 0 25px;'>
								<a href="<?php echo get_permalink( $post[1] ) ?>" class='entry-title'><?php echo get_the_title($post[1]) ?></a>	
								<?php $if_feat = get_post_meta( $post[1], "meta-box-artist-feat", true);
									if ($if_feat != '') {
									?>
										<?php echo      " Feat. "; ?>
										<?php echo $if_feat; ?>
									<br />
									<?php } ?>
							</td>
							<td style="padding: 0 25px;">
								<?php echo get_post_meta( $post[1], "count_play_loop", true); ?>
							</td>
							<td style="">
								<?php echo get_post_meta( $post[1], "meta-box-track-length", true ); ?>
							</td>
						</tr>	
						<?php }
					} 	
					
					echo "</table>";

				echo "</div>";
		
			// the_posts_navigation();

		} ?>	

		</main><!-- #main -->

	</div><!-- #primary -->

<?php
	get_sidebar();
	get_footer();
?>