<?php

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
?>