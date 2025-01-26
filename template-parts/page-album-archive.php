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

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
		<?php
	
        $getslugid = wp_get_post_terms(get_the_id(), 'artist');
        foreach ($getslugid as $thisslug) {
            $artist_slug_name = $thisslug->name; // Added a space between the slugs with . ' '
        }


        $get_songs_args = array(
            'post_type' => 'music',
            'posts_per_page' => -1,
            'meta_key' => 'meta-box-media-cover_',
            'meta_value' => get_the_id(),
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
        <div class="">
            <h2 style="margin: 0;"><a href="/artist/<?php echo $artist_slug_name ?>?album=<?php echo get_the_id(); ?>" rel="bookmark">
                    <?php echo get_the_title(get_the_id()); ?>
                </a></h2>
            <a href="/artist/<?php echo $artist_slug_name ?>?album=<?php echo get_the_id(); ?>"><?php echo wp_get_attachment_image(get_the_id(), array('350', '350')); ?></a>
            <div style="float: left; max-width: calc(100% - 40px);">
                <?php echo $artist_slug_name ?>
                </br>
                <?php echo count($get_songs); ?>
                </br>
                <?php echo time_from_seconds(array_sum($get_songs_calc)); ?>
            </div>
            <div style="float: right; margin: 25px 15px 0 0;">
                <?php echo do_shortcode('[simplicity-save-for-later-loop-album album_id="' . get_the_id() . '"]'); ?>
            </div>
        </div>
 
</article>