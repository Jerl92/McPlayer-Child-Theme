<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package chichi
 */

?>
                </div><!-- .wrap -->  
                <footer id="colophon" class="site-footer noselect" role="contentinfo">
                    <div class="wrap wrap-footer">  
                        <p class="made-with-love">
                            <span>Fait avec <span class="heart">♥</span> Par <a href="http://jerl92.ca" style="color: #000" class="name" Target= "Blank">Jérémie Langevin</a></span>
                        </p>
                    </div><!-- .wrap -->
                </footer><!-- #colophon -->    
            </div><!-- .wrap -->
        </div><!-- .wrap -->  
        <div id="wrap-player" class="wrap wrap-footer noselect"> 
            <?php if ( is_active_sidebar( 'left-menu-widget' ) ) : ?> 
                <div id="left-menu-widget" class="sidebar-container menu-off" role="complementary">
                    <div id="player1" class="widget-area-bottom-player aplayer">
                        <?php dynamic_sidebar( 'left-menu-widget' ); ?>
                    </div><!-- .widget-area -->
                </div><!-- #sidr-left -->
            <?php endif; ?>
        </div>   

        <?php wp_footer(); ?>

    </body>

</html>
