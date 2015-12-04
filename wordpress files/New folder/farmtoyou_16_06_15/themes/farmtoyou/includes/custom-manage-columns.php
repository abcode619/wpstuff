<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// ADD NEW COLUMN
function farmtoyou_manage_columns( $defaults ) {
    
    unset($defaults['title']);
    unset($defaults['date']);
    
    $defaults['image']  = __( 'Image', 'farmtoyou' );
    $defaults['title']  = __( 'Title', 'farmtoyou' );
    $defaults['date']   = __( 'Date', 'farmtoyou' );
    return $defaults;
}

// SHOW THE FEATURED IMAGE
function farmtoyou_columns_content( $column_name, $post_id ) {
    
    global $post;
    
    switch ($column_name) {
        
        case 'image':  
                        $featured_img =  get_the_post_thumbnail( $post_id, array( 60, 60 ) );
                        echo !empty( $featured_img ) ? $featured_img: '<img src="' . get_template_directory_uri() . '/images/default.jpg" width="60" height="60" />';
                        break;
    }
}

//Featured Image Column
add_filter('manage_edit-'.FARMTOYOU_BANNER_POST_TYPE.'_columns', 'farmtoyou_manage_columns');
add_action('manage_'.FARMTOYOU_BANNER_POST_TYPE.'_posts_custom_column', 'farmtoyou_columns_content', 10, 2);
?>