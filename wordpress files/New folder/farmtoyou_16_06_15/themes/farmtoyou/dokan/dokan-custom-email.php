<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Send notification to the users when a product is published by seller
 *
 * @param WP_Post $post
 * @return void
 */
function dokan_send_notification_to_users( $post ) {
    
    $prefix = FARMTOYOU_META_PREFIX;
    
    if ( $post->post_type != 'product' ) {
        return;
    }
    
    $seller = get_user_by( 'id', $post->post_author );
    $product = get_product( $post->ID );
    $dokan_email = new Dokan_Email();
    
    $args = array(
                    'post_type'      => FARMTOYOU_NEWSLETTER_POST_TYPE,
                    'post_status'    => 'active',
                    'posts_per_page' => '-1',
                    'meta_query' => array(
                                            array(
                                                    'key'     => $prefix.'post_author',
                                                    'value'   => $seller->ID,
                                            ),
                                        ),
                );

    //get newsletter data from database
    $all_newsletter = get_posts($args);
    
    foreach ($all_newsletter as $value) {
        
        $category = wp_get_post_terms($product->id, 'product_cat', array( 'fields' => 'names' ) );
        $category_name = $category ? reset( $category ) : 'N/A';
        
        $user_id = get_post_meta( $value->ID, $prefix.'curr_user_id', true );
        $user_info = get_userdata( $user_id );
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;
        
        $param = array( 'vendor_id' => base64_encode($seller->ID), 'user_id' => base64_encode($user_id), 'status' => base64_encode('pending') );
        $unsubscribe_link = add_query_arg( $param, site_url() );
        
        
        $users_email = get_post_meta( $value->ID, $prefix.'post_title', true );
        
        $body = "Hello $first_name $last_name,"."\r\n\n";
        $body .= "A new product has been submitted to site (".home_url().")\r\n\n";
        $body .= "Summary of the product:"."\r\n";
        $body .= "------------------------"."\r\n\n";
        $body .= "Title: ".$product->get_title()."\r\n";
        $body .= "Price: ".$dokan_email->currency_symbol( $product->get_price() )."\r\n";
        $body .= "Seller: ".$seller->display_name." (".dokan_get_store_url( $seller->ID ).")\r\n";
        $body .= "Category: ".$category_name."\r\n\n";
        $body .= "Currently you are active user of site. <a href='".$unsubscribe_link."'>Click here to unsubscribe</a>";

        $subject = sprintf( __( '[%s] New Product Added', 'dokan' ), $dokan_email->get_from_name() );
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        $dokan_email->send( $users_email, $subject, nl2br($body), $headers );
    }

}

function dokan_unsubscribe_vendor() {
    
    if( !empty($_REQUEST['vendor_id']) && !empty($_REQUEST['user_id']) && !empty($_REQUEST['status']) ) {
        
        $vendor_id = base64_decode($_REQUEST['vendor_id']);
        $user_id = base64_decode($_REQUEST['user_id']);
        $user_status = base64_decode($_REQUEST['status']);
        
        $prefix = FARMTOYOU_META_PREFIX;
        
        $args = array(
                        'post_type'      => FARMTOYOU_NEWSLETTER_POST_TYPE,
                        'post_status'    => 'publish',
                        'posts_per_page' => '-1',
                        'meta_query' => array(
                                                array(
                                                        'key'     => $prefix.'post_author',
                                                        'value'   => $vendor_id,
                                                ),
                                                array(
                                                        'key'     => $prefix.'curr_user_id',
                                                        'value'   => $user_id,
                                                ),    
                                            ),
                    );

        //get newsletter data from database
        $all_newsletter = get_posts($args);
        
        foreach ($all_newsletter as $value) {
            $my_post = array(
                                'ID'          => $value->ID,
                                'post_status' => $user_status,
                            );
            wp_update_post( $my_post, true );
        }
        wp_redirect( site_url() );
        exit;
    }
}

add_action( 'pending_to_publish', 'dokan_send_notification_to_users' );

add_action( 'wp', 'dokan_unsubscribe_vendor' );
?>