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
		
		<main id="main" class="site-main" role="main">
			
			<?php 
			if ($_GET['album']) {
				$album_meta = $_GET['album']; 
				$image = get_post($album_meta);
			} 
						
			$image_title = $image->post_title;
			
			
			?>

			<div class="page-header" style="background: center no-repeat url(<?php echo z_taxonomy_image_url(); ?>); height: 225px; background-size: cover;">
				<?php
					single_term_title( '<h1 class="page-title" style="width: auto; display: inline; text-shadow: -2px 0 #fff, 0 2px #fff, 2px 0 #fff, 0 -2px #fff; margin: 0;">', '</h1>' );
					if ( $_GET['album']) {
						echo '<h2 class="page-title" style="float: right; margin: 15px 15px 0 0; text-shadow: -2px 0 #fff, 0 2px #fff, 2px 0 #fff, 0 -2px #fff;">' . $image_title . '</h2>';
					}					
					//  the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</div><!-- .page-header -->

			<?php echo "<div id='album-class-artist-wraper'>";

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

			if($the_query->have_posts()){

				while ( $the_query->have_posts() ) {

					$the_query->the_post();

					$args = array( 
						'post_type' => 'attachment',
						'posts_per_page' => -1,
						'post_mime_type' => 'image',
						'meta_key' => 'meta-box-year',
						'orderby' => 'meta_value_num',
						'order' => 'DESC',
						'tax_query' => array(
							array(
								'taxonomy' => 'artist',
								'field'    => 'name',
								'terms'    => $artist_slug_name,
							),
						),
					); 

					$attachments = get_posts( $args );
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

							?>
							<ul id="album-class-artist" class="album-<?php echo $attachment->ID; ?>">
								<li>
									<a href="<?php echo $album_link . '#idalbum'; ?>">
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

						}
					}

				} wp_reset_postdata();
				echo "</div>"; 
			}
					 
			if ( have_posts() ) : 

					echo "<div id='idalbum'>";

					$album_meta = $_GET['album'];
					$image = get_post($album_meta) ;
					$image_title = $image->post_title;

					if ( $album_meta != '') {
						echo '</br>';
						echo '<h3 style="text-shadow: -2px 0 #fff, 0 2px #fff, 2px 0 #fff, 0 -2px #fff; margin: 0;">';
						echo $image_title;   
						echo '</h3>';
					}  

					$wp_query = new WP_Query();
					$wp_query->query('post_type=music&order=ASC&orderby=meta-box-track-number&meta_value=' . $album_meta . '&showposts=-1');
					echo "<table id='album-class-artist-list'>";
					while ( have_posts() ) : the_post();

						if ($_GET['album'] != '') { ?>				
 							<tr style='width: 100%; height: 60px;'>
 	                           <td id="album-class-artist-list-id-<?php echo get_the_id(); ?>" style='text-align: center; width: 30px; padding: 0 10px;'>
									<?php echo do_shortcode( '[simplicity-save-for-later-loop id="' . get_the_id() . '"]' ); ?>
								</td>
								<td style='width: 30px; display: inline-flex; text-align: center; margin auto 0; padding: 0 5px;'>
									<?php echo do_shortcode( '[add-play-now id="' . get_the_id() . '"]' ); ?>
								</td>
								<td style='text-align: center; padding: 0 5px; width: 30px;'>
									<?php echo get_post_meta( get_the_id(), "meta-box-track-number", true ); ?>
								</td>
								<td style='text-align: left; font-size: 18px; font-weight: 400; width: 100%; padding 0 25px;'>
									<a href="<?php echo get_permalink( get_the_id() ) ?>" class='entry-title'><?php the_title() ?></a>	
									<?php $if_feat = get_post_meta( get_the_id(), "meta-box-artist-feat", true);
										if ($if_feat != '') {
										?>
											<?php echo      " Feat. "; ?>
											<?php echo $if_feat; ?>
										<br />
										<?php } ?>
								</td>
								<td style="">
									<?php echo get_post_meta( get_the_id(), "meta-box-track-length", true ); ?>
								</td>
							</tr>					
						<?php } 				

					endwhile;
					wp_reset_postdata();

					echo "</table>";

				echo "</div>";
		
			// the_posts_navigation();

		else :

			echo 'no music found';

		endif; ?>	

		</main><!-- #main -->

	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>