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

            $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $tokens = explode('/', $actual_link);
            $tokens_ = $tokens[sizeof($tokens)-2];

			$args = array(
				'post_type' => 'music',
				'posts_per_page' =>  -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'genre',
						'field'    => 'slug',
						'terms'    => $tokens_,
					),
				
				),
			);

			// The Query
			$the_query = new WP_Query( $args );

            $classes = array(
                'page-music',
            );

				if($the_query->have_posts()){

					while ( $the_query->have_posts() ) {

						$the_query->the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
                        <div class="entry-header">
                            <?php
                            if ( is_single() ) :
                                the_title( '<h1 class="entry-title">', '</h1>' );
                            else :
                                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                            endif; 

                            if ( 'music' === get_post_type() ) : ?>
                            
                            <div class="entry-meta-cover">
                                <?php echo wp_get_attachment_image( get_post_meta( get_the_id(), "meta-box-media-cover_", true ), 'full', false, array('style' => 'max-width:100%;height:auto;') ); ?>
                            </div>
                            <div class="entry-meta">
                                <div class="entry-meta-data-archive">
                                    <?php
                                        $cover_id = esc_attr( 'meta-box-media-cover_' );
                                        $value = get_post_meta( get_the_id(), $cover_id, true );

                                        $getslugid = wp_get_post_terms( get_the_id(), 'artist' );

                                        foreach( $getslugid as $thisslug ) {
                                            echo $thisslug->name; // Added a space between the slugs with . ' '
                                        }
                                    ?>
                                    <br />
                                    <?php echo get_the_title($value); ?>
                                    <br />
                                    <?php echo 	" #"; ?>
                                    <?php echo get_post_meta( get_the_id(), "meta-box-track-number", true); ?>
                                    <br />
                                    <?php echo get_post_meta( $value, "meta-box-year", true); ?>
                                    </div>
                            </div><!-- .entry-meta -->

                            <div id="postid-<?php echo get_the_id(); ?>" class="entry-save-for-later">
                                <div class="rs-item-nav rs-item-save-for-later">
                                    <?php echo do_shortcode( '[simplicity-save-for-later-loop id="' . get_the_id() . '"]' ); ?>
                                </div>
                                <div class="rs-item-nav rs-item-nav-play-now">
                                    <?php echo do_shortcode( '[add-play-now id="' . get_the_id() . '"]' ); ?>
                                </div>
                            </div>

                            <?php endif; ?>

                        </div><!-- .entry-header -->
                        
                    </article>
<?php
                    }

                }

            wp_reset_postdata();

            ?>

		</main><!-- #main -->

	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>