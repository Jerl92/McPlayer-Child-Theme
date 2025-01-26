<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chichi
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-thumbnail">
        <?php the_post_thumbnail(); ?>
    </div>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
			echo '<div class="entry-meta-save-to-playlist">';
				echo '<div style="padding-right: 25px">';
				echo do_shortcode( '[simplicity-save-for-later-loop id="' . get_the_id() . '"]' );
				echo '</div><div>';
				echo do_shortcode( '[add-play-now id="' . get_the_id() . '"]' );
				echo '</div>';
			echo '</div>';
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif; 

		if ( 'music' === get_post_type() ) : ?>
		<div class="entry-meta">
			<div class="entry-meta-data">
				<?php
				$cover_id = esc_attr( 'meta-box-media-cover_' );
				$value = get_post_meta( get_the_id(), $cover_id, true );
				$getslugid = wp_get_post_terms( get_the_id(), 'artist' );
					foreach( $getslugid as $thisslug ) {
							echo $thisslug->name; // Added a space between the slugs with . ' '
					}
 				?>
				<br />
				<?php $if_feat = get_post_meta( get_the_id(), "meta-box-artist-feat", true);
				if ($if_feat != '') {
				?>
					<?php echo 	" Feat. "; ?>
					<?php echo $if_feat; ?>
				<br />
				<?php } ?>
				<?php echo get_the_title($value); ?>
				<br />
				<?php echo 	" #"; ?>
				<?php echo get_post_meta( get_the_id(), "meta-box-track-number", true); ?>
				<br />
				<?php echo get_post_meta( $value, "meta-box-year", true); ?>
				<br />
				<?php echo get_post_meta( get_the_id(), "meta-box-track-length", true); ?>
			</div>

			<div class="entry-meta-cover">
				<?php echo wp_get_attachment_image( get_post_meta( get_the_id(), "meta-box-media-cover_", true ), 'full', false, array('style' => 'max-width:450px;height:auto;') ); ?>
			</div>
		
			<div class="entry-meta-data-lyric">
				<?php $if_lyric = nl2br( esc_html( get_post_meta( get_the_id(), "meta-box-music-lyric", true) ) );
				if ($if_lyric != '') {
				?>
					<br />
					<hr>
					<h3>Lyrics</h3>
					<?php echo $if_lyric; ?>
				<?php } ?>
			</div>
		</div><!-- .entry-meta -->
				
		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
            if(is_single()):
			    the_content();
            else:
                the_excerpt();
            endif;

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'chichi' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php // chichi_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
