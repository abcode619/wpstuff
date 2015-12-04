<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Register Custom Post Types
 */
function farmtoyou_register_post_types() {
    
    $banner_labels = array(
                                'name'               => _x( 'Banners', 'farmtoyou_banner', 'farmtoyou' ),
                                'singular_name'      => _x( 'Banner', 'farmtoyou_banner', 'farmtoyou' ),
                                'menu_name'          => _x( 'Banners', 'farmtoyou_banner', 'farmtoyou' ),
                                'name_admin_bar'     => _x( 'Banners', 'farmtoyou_banner', 'farmtoyou' ),
                                'add_new'            => _x( 'Add New', 'farmtoyou_banner', 'farmtoyou' ),
                                'add_new_item'       => __( 'Add New Banner', 'farmtoyou' ),
                                'new_item'           => __( 'New Banner', 'farmtoyou' ),
                                'edit_item'          => __( 'Edit Banner', 'farmtoyou' ),
                                'view_item'          => __( 'View Banner', 'farmtoyou' ),
                                'all_items'          => __( 'All Banners', 'farmtoyou' ),
                                'search_items'       => __( 'Search Banner', 'farmtoyou' ),
                                'parent_item_colon'  => __( 'Parent Banner:', 'farmtoyou' ),
                                'not_found'          => __( 'No banners found.', 'farmtoyou' ),
                                'not_found_in_trash' => __( 'No banners found in Trash.', 'farmtoyou' ),
                            );

    $banner_args = array(
                            'labels'             => $banner_labels,
                            'public'             => true,
                            'publicly_queryable' => true,
                            'show_ui'            => true,
                            'show_in_menu'       => true,
                            'query_var'          => true,
                            'rewrite'            => array( 'slug'=>'banner', 'with_front' => false ),
                            'capability_type'    => 'post',
                            'has_archive'        => false,
                            'hierarchical'       => false,
                            'menu_position'      => null,
                            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' )
                        );

    register_post_type( FARMTOYOU_BANNER_POST_TYPE, $banner_args );
    
    $labels = array(
                        'name'  => __( 'Newsletters', 'farmtoyou' ),
                    );

    $args = array(
                    'labels'             => $labels,
                    'public'             => false,
                    'publicly_queryable' => false,
                    'show_ui'            => false,
                    'show_in_menu'       => false,
                    'query_var'          => true,
                    'rewrite'            => false,
                    'capability_type'    => 'post',
                    'has_archive'        => true,
                    'hierarchical'       => false,
                    'menu_position'      => null,
                    'supports'           => array( 'title', 'thumbnail' )
                );

    register_post_type( FARMTOYOU_NEWSLETTER_POST_TYPE, $args );
    
    $seller_labels = array(
                        'name'  => __( 'Seller Review', 'farmtoyou' ),
                    );

    $seller_args = array(
                    'labels'             => $seller_labels,
                    'public'             => false,
                    'publicly_queryable' => false,
                    'show_ui'            => false,
                    'show_in_menu'       => false,
                    'query_var'          => true,
                    'rewrite'            => false,
                    'capability_type'    => 'post',
                    'has_archive'        => true,
                    'hierarchical'       => false,
                    'menu_position'      => null,
                    'supports'           => array( 'title', 'thumbnail' )
                );

    register_post_type( FARMTOYOU_SELLER_REVIEW_POST_TYPE, $seller_args );
    
    //flush rewrite rules
    flush_rewrite_rules();
}

//add action to create custom post type
add_action( 'init', 'farmtoyou_register_post_types' );

?>