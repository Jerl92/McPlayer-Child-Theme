<?php
	add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
	function my_theme_enqueue_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
		wp_enqueue_script( 'sticky', get_stylesheet_directory_uri() . '/js/sticky.js', 'jquery' );
		wp_enqueue_script( 'chichi-navigation', get_stylesheet_directory_uri() . '/js/navigation.js', array('jquery'), true );
 	}

	add_action( 'wp_enqueue_scripts', 'my_chichi_navigation_enqueue' );
	function my_chichi_navigation_enqueue() {
		wp_dequeue_script( 'google-font' );
		wp_dequeue_script( 'font-awesome' );
 		wp_dequeue_script( 'chichi-navigation' );
	}

	add_action( 'after_setup_theme', 'mcplayer_support' );
	function mcplayer_support() {
		add_theme_support( 'music' );
	}
?>

