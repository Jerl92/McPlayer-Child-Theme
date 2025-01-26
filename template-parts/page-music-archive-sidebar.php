<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chichi
 */

 	$classes = array(
		'page-music',
	);

	$cover_id = esc_attr( 'meta-box-media-cover_' );
	$value = get_post_meta( get_the_id(), $cover_id, true );

	$getslugid = wp_get_post_terms( get_the_id(), 'artist' );	
?>

<li class="rs-item-saved-for-later" id="rs-item-<?php echo esc_attr(get_the_id());?>" data-object-id="<?php echo esc_attr(get_the_id());?>">
	<div class="rs-item-content">
		<div class="rs-item-cover">
			<?php echo wp_get_attachment_image( get_post_meta( get_the_id(), "meta-box-media-cover_", true ), array('62.5', '62.5'), false, array('style' => 'max-width:100%;height:auto;') ); ?>
		</div>
		<div class="rs-item-title"><a href="<?php echo get_the_permalink(); ?>" ><?php the_title(); ?></a> - 
			<?php foreach( $getslugid as $thisslug ) {
				echo $thisslug->name; // Added a space between the slugs with . ' '
			} ?>
		<br /><?php echo get_the_title($value); ?> - <?php echo get_post_meta( $value, "meta-box-year", true); ?> - <?php echo get_post_meta( get_the_id(), "meta-box-track-length", true ); ?></div>
		<div class="rs-item-nav rs-item-nav-play-now">
			<?php echo do_shortcode( '[play-now id="' . get_the_id() . '"]' ); ?>
		</div>
		<div class="rs-item-nav rs-item-nav-remove">
			<?php echo do_shortcode( '[simplicity-save-for-later-remove-sidebar id="' . get_the_id() . '"]' ); ?>
		</div>		
	</div>
</li>