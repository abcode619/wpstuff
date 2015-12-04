<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Register Custom Post Types
 */
function demotheme_register_post_types() {

    $product_labels = array(
                                'name'               => _x( 'Products', 'demotheme_product', 'demotheme' ),
                                'singular_name'      => _x( 'Product', 'demotheme_product', 'demotheme' ),
                                'menu_name'          => _x( 'Products', 'demotheme_product', 'demotheme' ),
                                'name_admin_bar'     => _x( 'Products', 'demotheme_product', 'demotheme' ),
                                'add_new'            => _x( 'Add New', 'demotheme_product', 'demotheme' ),
                                'add_new_item'       => __( 'Add New Product', 'demotheme' ),
                                'new_item'           => __( 'New Product', 'demotheme' ),
                                'edit_item'          => __( 'Edit Product', 'demotheme' ),
                                'view_item'          => __( 'View Product', 'demotheme' ),
                                'all_items'          => __( 'All Products', 'demotheme' ),
                                'search_items'       => __( 'Search Product', 'demotheme' ),
                                'parent_item_colon'  => __( 'Parent Product:', 'demotheme' ),
                                'not_found'          => __( 'No products found.', 'demotheme' ),
                                'not_found_in_trash' => __( 'No products found in Trash.', 'demotheme' ),
                            );

    $product_args = array(
                            'labels'             => $product_labels,
                            'public'             => true,
                            'publicly_queryable' => true,
                            'show_ui'            => true,
                            'show_in_menu'       => true,
                            'query_var'          => true,
                            'rewrite'            => array( 'slug'=>'product', 'with_front' => false ),
                            'capability_type'    => 'post',
                            'has_archive'        => false,
                            'hierarchical'       => false,
                            'menu_position'      => null,
                            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' )
                        );

    register_post_type( DEMOTHEME_PRODUCT_POST_TYPE, $product_args );
    
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
                        'name'              => _x( 'Categories', 'taxonomy general name', 'demotheme'),
                        'singular_name'     => _x( 'Category', 'taxonomy singular name','demotheme' ),
                        'search_items'      => __( 'Search Categories','demotheme' ),
                        'all_items'         => __( 'All Categories','demotheme' ),
                        'parent_item'       => __( 'Parent Category','demotheme' ),
                        'parent_item_colon' => __( 'Parent Category:','demotheme' ),
                        'edit_item'         => __( 'Edit Category' ,'demotheme'), 
                        'update_item'       => __( 'Update Category' ,'demotheme'),
                        'add_new_item'      => __( 'Add New Category' ,'demotheme'),
                        'new_item_name'     => __( 'New Category Name' ,'demotheme'),
                        'menu_name'         => __( 'Categories' ,'demotheme')
                    );

    $args = array(
                    'hierarchical'      => true,
                    'labels'            => $labels,
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
                    'rewrite'           => false
                );
	
    register_taxonomy( DEMOTHEME_PRODUCT_POST_TAX, DEMOTHEME_PRODUCT_POST_TYPE, $args );
    
}

//add action to create custom post type
add_action( 'init', 'demotheme_register_post_types' );

?>