<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Enqueue scripts and styles for the back end.
 */
function demotheme_admin_scripts() {
    
        global $wp_version;
    
        // Load our admin stylesheet.
	wp_enqueue_style( 'demotheme-admin-style', get_template_directory_uri() . '/css/admin-style.css' );
        
        // Load our admin script.
	wp_enqueue_script( 'demotheme-admin-script', get_template_directory_uri() . '/js/admin-script.js' );

        //localize script
        $newui = $wp_version >= '3.5' ? '1' : '0'; //check wp version for showing media uploader
        wp_localize_script( 'demotheme-admin-script', 'DemoThemeAdmin', array(
                                                                        'new_media_ui'	=>  $newui,
                                                                        'one_file_min'	=>  __('You must have at least one file.','demotheme' )
                                                                    ));
        wp_enqueue_media();

}

/**
 * Enqueue scripts and styles for the front end.
 */
function demotheme_public_scripts() {

	// Load our main stylesheet.
	wp_enqueue_style( 'demotheme-style', get_stylesheet_uri(), array(), NULL );
	
	// Load our public style stylesheet.
	wp_enqueue_style( 'demotheme-public-style', get_template_directory_uri() . '/css/public-style.css', array(), NULL );

        // Load main jquery
        wp_enqueue_script( 'jquery', array(), NULL );
        
        // Load public script
	wp_enqueue_script( 'demotheme-public-script', get_template_directory_uri() . '/js/public-script.js', array(), NULL );
}

//add action to load scripts and styles for the back end
add_action( 'admin_enqueue_scripts', 'demotheme_admin_scripts' );

//add action load scripts and styles for the front end
add_action( 'wp_enqueue_scripts', 'demotheme_public_scripts' );

?>