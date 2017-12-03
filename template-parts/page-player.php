<?php
/**
 * Player
 */

$music_playlist = wp_get_attachment_url(get_post_meta( $post->ID, 'music_link_', true ));

$terms = wp_get_post_terms( $post->ID, 'artist' );

$name = esc_attr( 'meta-box-media-cover_' );
$value = $rawvalue = get_post_meta( $post->ID, $name, true );
$attachment_title = get_the_title($value);
$delimeter_player56s = esc_attr(' - ');

?>

<audio href="<?php echo $music_playlist; ?>" class="player56s" rel="playlist" postid="<?php echo $post->ID; ?>"><?php
    echo $attachment_title;
    echo $delimeter_player56s;
    foreach($terms as $term) {
        echo $term->name;
    }
    echo $delimeter_player56s;
    echo get_the_title();
    echo $delimeter_player56s;
    echo wp_get_attachment_image_url( $value , 'full' );
    echo $delimeter_player56s;
?>
</audio>