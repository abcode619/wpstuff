<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Template Name: Store Result Template
 *
 * @package WordPress
 * @subpackage Farmtoyou
 * @since Farmtoyou 1.0
 */

get_header(); ?>

        <div class="main-work-section">
            <div class="container">
                <div class="col-md-12 work-left">
                    <h2><?php the_title(); ?> for zipcode: <?php echo $_GET['farmtoyou_zip'] ?> and miles: <?php echo $_GET['miles'] ?></h2>
                    
                    <ul class="dokan-seller-wrap">
                        <?php
                        if( !empty( $_GET['farmtoyou_zip'] ) ) {
                            $zip_codes = get_zips($_GET['farmtoyou_zip'], $_GET['miles']);
                            
                            if(!empty($zip_codes)) {
                                $zips = array();
                                foreach($zip_codes as $z) {
                                    $zips[] = $z->zip_code;
                                }
                                $seller_args = array(
                                                    'meta_query' => array(
                                                                        array(
                                                                                'key'     => 'dokan_vendor_zipcode',
                                                                                'value'   => $zips,
                                                                                'compare' => 'IN'
                                                                        )
                                                                    )
                                            );
                            }
                            $seller_query = new WP_User_Query( $seller_args );
                            
                            if( !empty( $seller_query->results ) ) {
                            
                            foreach ($seller_query->results as $seller) {
                                $store_info = dokan_get_store_info( $seller->ID );
                                $banner_id  = isset( $store_info['banner'] ) ? $store_info['banner'] : 0;
                                $store_name = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', 'dokan' );
                                $store_url  = dokan_get_store_url( $seller->ID );
                                $seller_zipcode = get_user_meta( $seller->ID, 'dokan_vendor_zipcode', true );
                            ?>
                                <li class="dokan-single-seller">
                                    <div class="dokan-store-thumbnail">

                                        <a href="<?php echo $store_url; ?>">
                                            <?php if ( $banner_id ) {
                                                $banner_url = wp_get_attachment_image_src( $banner_id, 'medium' );
                                                ?>
                                                <img class="dokan-store-img" src="<?php echo esc_url( $banner_url[0] ); ?>" alt="<?php echo esc_attr( $store_name ); ?>">
                                            <?php } else { ?>
                                                <img class="dokan-store-img" src="<?php echo dokan_get_no_seller_image(); ?>" alt="<?php _e( 'No Image', 'dokan' ); ?>">
                                            <?php } ?>
                                        </a>

                                        <div class="dokan-store-caption">
                                            <h3><a href="<?php echo $store_url; ?>"><?php echo $store_name; ?></a></h3>

                                            <address>
                                                <?php if ( isset( $store_info['address'] ) ) {
                                                    $address = esc_html( $store_info['address'] );
                                                    echo nl2br( $address );
                                                } ?>

                                                <?php if ( isset( $store_info['phone'] ) && !empty( $store_info['phone'] ) ) { ?>
                                                    <br>
                                                    <abbr title="<?php _e( 'Phone', 'dokan' ); ?>"><?php _e( 'P:', 'dokan' ); ?></abbr> <?php echo esc_html( $store_info['phone'] ); ?>
                                                <?php } ?>
                                                    
                                                <p><?php _e( 'Zipcode: ', 'dokan' ); ?> <?php echo $seller_zipcode; ?></p>
                                            </address>
                                            
                                            <p><a class="dokan-btn dokan-btn-theme" href="<?php echo $store_url; ?>"><?php _e( 'Visit Store', 'dokan' ); ?></a></p>

                                        </div> <!-- .caption -->
                                    </div> <!-- .thumbnail -->
                                </li> <!-- .single-seller -->
                            <?php
                                }
                            } else {
                                echo "Sorry! No farms found nearby zipcode you entered.";
                            }
                        } else {
                            echo "<p>Please enter valid zipcode with its radius.</p>";
                        }
                        ?>
                    </ul>    
                </div>
            </div>
        </div>
        <!--Hero Section end-->

<?php get_footer(); ?>