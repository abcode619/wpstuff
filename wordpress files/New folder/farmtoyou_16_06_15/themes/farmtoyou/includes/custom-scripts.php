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
function farmtoyou_admin_scripts() {
    
        global $wp_version;
    
        // Load our admin stylesheet.
	wp_enqueue_style( 'farmtoyou-admin-style', get_template_directory_uri() . '/css/admin-style.css' );
        
        // Load our admin script.
	wp_enqueue_script( 'farmtoyou-admin-script', get_template_directory_uri() . '/js/admin-script.js' );

        // Load featured-img-script script
	wp_enqueue_script( 'farmtoyou-featured-img-script', get_template_directory_uri() . '/js/featured-img-script.js', array(), NULL );
        
        //localize script
        $newui = $wp_version >= '3.5' ? '1' : '0'; //check wp version for showing media uploader
        wp_localize_script( 'farmtoyou-admin-script', 'FarmtoyouAdmin', array(
                                                                        'new_media_ui'	=>  $newui,
                                                                        'one_file_min'	=>  __('You must have at least one file.','farmtoyou' )
                                                                    ));
        wp_enqueue_media();

}

/**
 * Enqueue scripts and styles for the front end.
 */
function farmtoyou_public_scripts() {

	// Load our bootstrap stylesheet.
	wp_enqueue_style( 'farmtoyou-bootstrap-style', get_template_directory_uri() . '/css/bootstrap.css', array(), NULL );
	
	// Load our font-awesome stylesheet.
	wp_enqueue_style( 'farmtoyou-font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), NULL );
	
	// Load our main stylesheet.
	wp_enqueue_style( 'farmtoyou-style', get_stylesheet_uri(), array(), NULL );
	
	// Load our jquery-fancybox-css stylesheet.
	wp_enqueue_style( 'farmtoyou-jquery-fancybox-css', get_template_directory_uri() . '/css/jquery.fancybox.css', array(), NULL );
	
	// Load our responsive stylesheet.
	wp_enqueue_style( 'farmtoyou-responsive', get_template_directory_uri() . '/css/responsive.css', array(), NULL );
	
	// Load our public-style stylesheet.
//	wp_enqueue_style( 'farmtoyou-public-style', get_template_directory_uri() . '/css/public-style.css', array(), NULL );

        // Load main jquery
        wp_enqueue_script( 'jquery', array(), NULL );
        
        // Load flexslider script
	wp_enqueue_script( 'farmtoyou-flexslider-script', get_template_directory_uri() . '/js/jquery.flexslider.js', array(), NULL );
        
        // Load jquery-fancybox-js script
	wp_enqueue_script( 'farmtoyou-jquery-fancybox-js', get_template_directory_uri() . '/js/jquery.fancybox.js', array(), NULL );
        
        // Load custom script
	wp_enqueue_script( 'farmtoyou-script', get_template_directory_uri() . '/js/script.js', array(), NULL );
        
        // Load public script
	wp_enqueue_script( 'farmtoyou-public-script', get_template_directory_uri() . '/js/public-script.js', array(), NULL );
        wp_localize_script( 'farmtoyou-public-script', 'FarmtoyouPublic', array(
                                                                                'ajaxurl'   => admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ),
                                                                            ));
}

//add action to load scripts and styles for the back end
add_action( 'admin_enqueue_scripts', 'farmtoyou_admin_scripts' );

//add action load scripts and styles for the front end
add_action( 'wp_enqueue_scripts', 'farmtoyou_public_scripts' );

?>