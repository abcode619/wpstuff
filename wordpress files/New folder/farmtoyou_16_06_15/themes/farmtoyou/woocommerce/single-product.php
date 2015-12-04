<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$prefix = FARMTOYOU_META_PREFIX;
global $post;
$store_user = get_userdata($post->post_author);
$store_info = dokan_get_store_info($store_user->ID);
$map_location = isset($store_info['location']) ? esc_attr($store_info['location']) : '';
$scheme = is_ssl() ? 'https' : 'http';
$store_name = $store_info['store_name'];
$store_url = dokan_get_store_url($store_user->ID);

$current_user = wp_get_current_user();
$current_user_email = $current_user->user_email;
$current_user_id = $current_user->ID;

wp_enqueue_script('google-maps', $scheme . '://maps.google.com/maps/api/js?sensor=true');

get_header( 'shop' ); ?>

<div class="cupcake-section">
    <div class="container">
            
            <?php
            $args = array(
                'post_type' => FARMTOYOU_NEWSLETTER_POST_TYPE,
                'post_status' => 'publish',
                'posts_per_page' => '-1',
                'meta_query' => array(
                    array(
                        'key' => $prefix . 'post_author',
                        'value' => $store_user->ID,
                    ),
                    array(
                        'key' => $prefix . 'post_title',
                        'value' => $current_user_email,
                    ),
                ),
            );

            //get newsletter data from database
            $all_newsletter = get_posts($args);
            ?>

            <div class="col-md-3 cup-left">

                <div class="rating-section">

                    <?php
                        $seller_args = array(
                                        'post_type' => FARMTOYOU_SELLER_REVIEW_POST_TYPE,
                                        'post_status' => 'publish',
                                        'posts_per_page' => '-1',
                                        'meta_query' => array(
                                                                array(
                                                                    'key' => $prefix . 'seller_id',
                                                                    'value' => $store_user->ID,
                                                                ),
                                                            )
                                    );

                        $all_seller_review = get_posts($seller_args);

                        $number_of_review = count($all_seller_review);

                        if( !empty($number_of_review) ) {
                            $total_rating = 0;
                            foreach ($all_seller_review as $key => $value) {
                                $user_rating = get_post_meta( $value->ID, $prefix.'seller_rating', true );

                                $total_rating = $total_rating + $user_rating;
                            }

                            $star_rating = number_format((float)($total_rating/$number_of_review), 1, '.', '');
                        }    
                    ?>
                    
                    <?php if ( isset( $store_info['store_name'] ) ) { ?>
                        <h2><?php echo esc_html( $store_info['store_name'] ); ?></h2>
                    <?php } ?>
                    
                    <div class="dokan-rating">
                        <?php if( !empty($number_of_review) ) { ?>
                            <span class="rating-title">Rating</span>
                            <div class="star-rating" title="<?php echo sprintf(__( 'Rated %f out of 5', 'dokan' ), $star_rating) ?>">
                                <span style="width:<?php echo ( ( $star_rating / 5 ) * 100 ); ?>%"><strong itemprop="ratingValue"><?php echo $star_rating; ?></strong> <?php _e( 'out of 5', 'dokan' ); ?></span>
                            </div>
                        <?php } else { ?>    
                            <span class="rating-title"><?php _e( 'No ratings found yet!', 'dokan' ); ?></span>
                        <?php }?>       
                    </div>         

                    <ul>
                        <?php if( !empty( $number_of_review ) ) { ?>
                            <li><a href="<?php echo dokan_get_review_url( $store_user->ID ); ?>"><?php echo sprintf( _n( '%s review', '%s reviews', $number_of_review, 'farmtoyou' ), $number_of_review ); ?></a></li>
                        <?php } ?>
                        <?php  if( is_user_logged_in() ) { ?>
                            <li><a class="fancybox" href="#seller-review"><?php _e( 'Write a review', 'dokan' ); ?></a></li>
                        <?php }  ?>    
                    </ul>

                    <?php if (!empty($all_newsletter) && count($all_newsletter) > 0) { ?>
                        <p><?php _e('The seller is already in the wishlist!', 'farmtoyou') ?></p>
                    <?php } else {
    //                    if( is_user_logged_in() ) {   
                    ?>
                        <a class="favourite" data-id="<?php echo $store_user->ID; ?>" data-user-email="<?php echo $current_user->user_email; ?>" data-user-id="<?php echo $current_user_id; ?>" href="#"><i class="fa fa-heart-o"></i>Add to favorite</a>
                    <?php /* } else { ?>
                        <a class="guest-favourite fancybox" href="#add-to-fav"><i class="fa fa-heart-o"></i>Add to favorite</a>

                        <div id="add-to-fav" style="display: none;">
                            <form action="" method="get">
                                <input type="hidden" name="seller_id" id="seller_id" value="<?php echo $store_user->ID; ?>">
                                <input type="text" name="user_name" id="user_name" placeholder="Enter your name" required="required">
                                <input type="text" name="user_email" id="user_email" placeholder="Enter your email" required="required">
                                <input type="submit" name="user_submit" value="Submit">
                            </form>
                        </div>
                    <?php    
                    } */
                    } 
                    ?>

                </div>

                <div class="provider">
                    <?php dokan_get_template_part('store-header'); ?>
                </div>

                <div class="contact-provider">
                    <ul>
                        <li><a href="#">Contact the Provider</a></li>
                        <li><a href="#">Store Policy</a></li>
                    </ul>
                </div>

            </div>
                
            <div class="col-md-9 cup-right">

                <?php
                        /**
                         * woocommerce_before_main_content hook
                         *
                         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                         * @hooked woocommerce_breadcrumb - 20
                         */
                        do_action( 'woocommerce_before_main_content' );
                ?>
                
		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>
                
                <?php
                        /**
                         * woocommerce_after_main_content hook
                         *
                         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                         */
                        do_action( 'woocommerce_after_main_content' );
                ?>
                
                <?php
                        /**
                         * woocommerce_sidebar hook
                         *
                         * @hooked woocommerce_get_sidebar - 10
                         */
//                        do_action( 'woocommerce_sidebar' );
                ?>
            </div>
    </div>
</div>

<?php get_footer( 'shop' ); ?>
