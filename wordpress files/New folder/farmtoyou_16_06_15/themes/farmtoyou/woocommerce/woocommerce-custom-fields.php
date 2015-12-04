<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function add_checkout_options() {
    
    global $woocommerce;
    $vendor_ids = array();
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        if( !in_array($cart_item['data']->post->post_author, $vendor_ids) ) {
            $vendor_ids[] = $cart_item['data']->post->post_author;
        }
    }
    ?>
        <div class="your-order">
            <?php    
            foreach ($vendor_ids as $vendor_id) {
                $store_settings = dokan_get_store_info( $vendor_id );

                $shipping_charge        = get_user_meta( $vendor_id, 'dokan_enable_seller_shipping', true );
                $seller_shipping_charge = get_user_meta( $vendor_id, 'dokan_seller_shipping_charge', true );
                $currency_symbol = get_woocommerce_currency_symbol();

                ?>

                    <span class="order-title"><?php echo $store_settings['store_name']; ?></span>
                    <div class="order-raw">
                        <input type="radio" name="dokan_product_shipping_choice[<?php echo $vendor_id; ?>]" class="dokan_product_shipping_choice" data-id="<?php echo $vendor_id; ?>" value="dokan_product_pick_at_farm">
                        <label>Pick up at the farm (<?php echo $store_settings['address'] ?>)</label>
                        <?php if( $shipping_charge == "yes" ) { ?>
                            <input type="radio" name="dokan_product_shipping_choice[<?php echo $vendor_id; ?>]" class="dokan_product_shipping_choice" data-id="<?php echo $vendor_id; ?>" value="dokan_product_shipping">
                            <label>Shipping (<?php echo $currency_symbol." ".$seller_shipping_charge; ?>)</label>
                        <?php } ?>    
                    </div>
                <?php
            }
            ?>
        </div>  
<?php            
}

function add_seller_shipping_field( $user ) {
    $seller_zipcode         = get_user_meta( $user->ID, 'dokan_vendor_zipcode', true );
    $shipping_charge        = get_user_meta( $user->ID, 'dokan_enable_seller_shipping', true );
    $seller_shipping_charge = get_user_meta( $user->ID, 'dokan_seller_shipping_charge', true );
    $seller_icon            = get_user_meta( $user->ID, 'dokan_seller_icon', true );
?>
    <tr>
        <th><?php _e( 'Zipcode', 'dokan' ); ?></th>
        <td>
            <input type="text" name="dokan_store_zipcode" value="<?php echo esc_attr( $seller_zipcode ); ?>">
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Seller Shipping Charge', 'dokan' ); ?></th>
        <td>
            <label for="dokan_shipping">
                <input type="hidden" name="dokan_shipping" value="no">
                <input name="dokan_shipping" type="checkbox" id="dokan_shipping" value="yes" <?php checked( $shipping_charge, 'yes' ); ?> />
                <input type="text" name="dokan_seller_shipping_charge" value="<?php echo esc_attr( $seller_shipping_charge ); ?>">
            </label>    
            <p class="description"><?php _e( 'How much amount will get for ship the product. ( Only if checkbox is enable ) ', 'dokan' ) ?></p>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Seller Icon', 'dokan' ); ?></th>
        <td class="file-input-advanced">
            <input type="text" class="farmtoyou-upload-file-link" name="dokan_seller_icon" placeholder="http://" value="<?php echo esc_attr( $seller_icon ); ?>" style='width:65%;'>
            <span class='farmtoyou-upload-files'><a class='farmtoyou-upload-fileadvanced button' href='javascript:void(0);'>Upload</a></span>
            <p class="description"><?php _e( 'Seller icon.', 'dokan' ) ?></p>
        </td>
    </tr>
<?php    
}

function save_seller_shipping_field( $user_id ) {
    
    $seller_store_zipcode = $_POST['dokan_store_zipcode'];
    update_user_meta( $user_id, 'dokan_vendor_zipcode', $seller_store_zipcode );
    
    $shipping_charge = sanitize_text_field( $_POST['dokan_shipping'] );
    update_user_meta( $user_id, 'dokan_enable_seller_shipping', $shipping_charge ); 
    
    $seller_shipping_charge = floatval( $_POST['dokan_seller_shipping_charge'] );
    update_user_meta( $user_id, 'dokan_seller_shipping_charge', $seller_shipping_charge ); 
    
    $seller_icon = $_POST['dokan_seller_icon'];
    update_user_meta( $user_id, 'dokan_seller_icon', $seller_icon ); 
}

function dokan_add_zipcode_on_create_seller( $user_id, $data ) {
    if ( $data['role'] != 'seller' ) {
        return;
    }
    
    if( isset( $_POST['zipcode'] ) ) {
        update_user_meta( $user_id, 'dokan_vendor_zipcode', $_POST['zipcode'] );
    }
}

//add action to create custom checkout options
add_action( 'woocommerce_checkout_before_order_review', 'add_checkout_options' );

//add action to create custom shipping feild
add_action( 'dokan_seller_meta_fields', 'add_seller_shipping_field' );

//add action to save custom shipping feild
add_action( 'dokan_process_seller_meta_fields', 'save_seller_shipping_field' );

add_action( 'woocommerce_created_customer', 'dokan_add_zipcode_on_create_seller', 10, 2);
?>