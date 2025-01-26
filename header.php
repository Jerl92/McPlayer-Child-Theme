<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package chichi
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no" />
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class();  ?>>

<div id="page" class="site">
    <header id="masthead" class="site-header" role="banner">
        <div id="mastheadtop" class="header-menu-top">
                <nav id="site-navigation-top" class="top-navigation" role="navigation">
                    <?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'menu_id' => 'top-menu', 'container_id' => 'top-menu-container' ) ); ?>
                </nav><!-- #site-navigation -->
        </div>
        <div class="wrap">
            <div class="site-branding">
                <h1 class="site-title"><a href="<?php echo esc_url( get_home_url() ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

                <?php $description = get_bloginfo( 'description', 'display' ); ?>
                <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation" role="navigation">
                <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_id' => 'primary-menu' ) ); ?>
            </nav><!-- #site-navigation -->
        </div>
    </header><!-- #masthead -->

    <div id="content" class="site-content">