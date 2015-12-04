<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if( !defined( 'DEMOTHEME_POST_POST_TYPE' ) ) {
    define( 'DEMOTHEME_POST_POST_TYPE', 'post' );
}
if( !defined( 'DEMOTHEME_PAGE_POST_TYPE' ) ) {
    define( 'DEMOTHEME_PAGE_POST_TYPE', 'page' );
}
if( !defined( 'DEMOTHEME_PRODUCT_POST_TYPE' ) ) {
    define( 'DEMOTHEME_PRODUCT_POST_TYPE', 'demotheme_product' );
}
if( !defined( 'DEMOTHEME_PRODUCT_POST_TAX' ) ) {
    define( 'DEMOTHEME_PRODUCT_POST_TAX', 'demotheme_product_tax' );
}
if( !defined( 'DEMOTHEME_META_PREFIX' ) ) {
    define( 'DEMOTHEME_META_PREFIX', '_demotheme_' );
}

// Include custom post types & taxonomies
require get_stylesheet_directory() . '/includes/custom-posttypes.php';

//include custom scripts file 
include( get_stylesheet_directory() . '/includes/custom-scripts.php' );

//include custom widget file 
include( get_stylesheet_directory() . '/widgets/class-custom-contactus-widget.php' );

/**
* Escape Tags & Slashes
*
* Handles escapping the slashes and tags
*/
function demotheme_escape_attr($data){
       return !empty( $data ) ? esc_attr( stripslashes( $data ) ) : '';
}

/**
* Strip Slashes From Array
*/
function demotheme_escape_slashes_deep($data = array(),$flag=true){

    if($flag != true) {
         $data = demotheme_nohtml_kses($data);
    }
    $data = stripslashes_deep($data);
    return $data;
}

/**
* Strip Html Tags 
* 
* It will sanitize text input (strip html tags, and escape characters)
*/
function demotheme_nohtml_kses($data = array()) {

    if ( is_array($data) ) {
        $data = array_map(array($this,'demotheme_nohtml_kses'), $data);
    } elseif ( is_string( $data ) ) {
        $data = wp_filter_nohtml_kses($data);
    }
   return $data;
}

/**
 * Display Short Content By Character
 */
function demotheme_excerpt_char( $content, $length = 40 ) {
    
    $text = '';
    if( !empty( $content ) ) {
        $text = strip_shortcodes( $content );
        $text = str_replace(']]>', ']]&gt;', $text);
        $text = strip_tags($text);
        $excerpt_more = apply_filters('excerpt_more', ' ' . ' ...');
        $text = substr($text, 0, $length);
        $text = $text . $excerpt_more;
    }
    return $text;
}

/**
 * Custom Meta box for post types.
 */
function demotheme_meta_box() {
    
    add_meta_box( 'demotheme_product_meta', __( 'Product Information', 'demotheme' ), 'demotheme_product_meta_options_page',DEMOTHEME_PRODUCT_POST_TYPE );
}

/**
 * Custom Meta box page.
 */
function demotheme_product_meta_options_page() {
    
    include get_stylesheet_directory() . '/includes/custom-product-meta.php';
}

/**
 * Save Meta for post types.
 */
function demotheme_save_meta( $post_id ) {
    
    if( empty( $post_id ) ) { return; }
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    $prefix = DEMOTHEME_META_PREFIX;
    
    // Check post type is product
    if ( isset( $_POST['post_type'] ) && DEMOTHEME_PRODUCT_POST_TYPE == $_POST['post_type'] ) {
        
        if( isset( $_POST[$prefix.'product_title'] ) ) {
            update_post_meta( $post_id, $prefix.'product_title', demotheme_escape_slashes_deep( $_POST[$prefix.'product_title'], true ) );
        }
        if( isset( $_POST[$prefix.'product_desc'] ) ) {
            update_post_meta( $post_id, $prefix.'product_desc', demotheme_escape_slashes_deep( $_POST[$prefix.'product_desc'], true ) );
        }
        if( isset( $_POST[$prefix.'product_images'] ) ) {
            update_post_meta( $post_id, $prefix.'product_images', demotheme_escape_slashes_deep( $_POST[$prefix.'product_images'], true ) );
        }
        if( isset( $_POST[$prefix.'product_video_url'] ) ) {
            update_post_meta( $post_id, $prefix.'product_video_url', demotheme_escape_slashes_deep( $_POST[$prefix.'product_video_url'], true ) );
        }
    }
}

/**
 * Add Register Settings
 */
function demotheme_register_settings() {
    
    register_setting( 'demotheme-settings-group', 'demotheme_options', 'demotheme_options_validate' );
}

/**
 * Validate Settings
 */
function demotheme_options_validate( $input ) {
    
    $input['site_logo']      = demotheme_escape_slashes_deep( $input['site_logo'] );
    $input['clients_images'] = demotheme_escape_slashes_deep( $input['clients_images'] );
    
    $input['fb_url']         = demotheme_escape_slashes_deep( $input['fb_url'] );
    $input['tw_url']         = demotheme_escape_slashes_deep( $input['tw_url'] );
    $input['li_url']         = demotheme_escape_slashes_deep( $input['li_url'] );
    $input['gp_url']         = demotheme_escape_slashes_deep( $input['gp_url'] );
    $input['yt_url']         = demotheme_escape_slashes_deep( $input['yt_url'] );
    
    $input['cpy_text']       = demotheme_escape_slashes_deep( $input['cpy_text'] );
    
    return $input;
}

/**
 * Adding Menu Pages
 */
function demotheme_add_menu_pages() {
    
    add_theme_page( __( 'Theme Options', 'demotheme' ), __( 'Theme Options', 'demotheme' ), 'manage_options', 'demotheme-theme-options', 'demotheme_theme_options_page' );
}

/**
 * Theme Options Page.
 */
function demotheme_theme_options_page() {
    
    include get_stylesheet_directory() . '/includes/theme-options.php';
}

/**
 * search in posts and pages
 */
function demotheme_filter_search( $query ) {
    if( !is_admin() && $query->is_search ) {
	$query->set( 'post_type', array( DEMOTHEME_POST_POST_TYPE, DEMOTHEME_PAGE_POST_TYPE ) );
    };
    return $query;
};

//add action to create custom meta box
add_action( 'admin_init', 'demotheme_meta_box' );

//add action to save custom 
add_action( 'save_post', 'demotheme_save_meta' );

//add action to add theme options page
add_action( 'admin_menu', 'demotheme_add_menu_pages' );

//add action to call register settings function
add_action( 'admin_init', 'demotheme_register_settings' );

//add filter to search in posts and pages
add_filter('pre_get_posts', 'demotheme_filter_search');

//add filter to add shortcode in widget
add_filter('widget_text', 'do_shortcode');
?>