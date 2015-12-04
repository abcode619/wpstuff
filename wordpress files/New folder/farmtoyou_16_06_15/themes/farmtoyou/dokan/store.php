<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

global $product;

$prefix = FARMTOYOU_META_PREFIX;
$store_user = get_userdata(get_query_var('author'));
$store_info = dokan_get_store_info($store_user->ID);
$map_location = isset($store_info['location']) ? esc_attr($store_info['location']) : '';
$scheme = is_ssl() ? 'https' : 'http';
$store_name = $store_info['store_name'];
$store_url = dokan_get_store_url($store_user->ID);

$current_user = wp_get_current_user();
$current_user_email = $current_user->user_email;
$current_user_id = $current_user->ID;

wp_enqueue_script('google-maps', $scheme . '://maps.google.com/maps/api/js?sensor=true');

get_header('shop');
?>

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
                    <?php if( is_user_logged_in() ) { ?>
                        <li><a class="fancybox" href="#seller-review"><?php _e( 'Write a review', 'dokan' ); ?></a></li>
                    <?php } ?>    
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
                    <li><a href="<?php echo get_permalink( FARMTOYOU_STORE_POLICY_PAGE_ID ); ?>">Store Policy</a></li>
                </ul>
            </div>

        </div>

        <div class="col-md-9 cup-right">

            <div class="dropdown-section">

                <div class="list-grid">
                    
                    <?php
                    /**
                     * woocommerce_before_shop_loop hook
                     *
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    do_action('woocommerce_before_shop_loop');
                    ?>
                </div>
            </div>

            <?php // do_action( 'woocommerce_before_main_content' );  ?>

            <?php /* if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' ) == 'off' ) { ?>
              <div id="dokan-secondary" class="dokan-clearfix dokan-w3 dokan-store-sidebar" role="complementary" style="margin-right:3%;">
              <div class="dokan-widget-area widget-collapse">
              <?php do_action( 'dokan_sidebar_store_before', $store_user, $store_info ); ?>
              <?php
              if ( ! dynamic_sidebar( 'sidebar-store' ) ) {

              $args = array(
              'before_widget' => '<aside class="widget">',
              'after_widget'  => '</aside>',
              'before_title'  => '<h3 class="widget-title">',
              'after_title'   => '</h3>',
              );

              if ( class_exists( 'Dokan_Store_Location' ) ) {
              the_widget( 'Dokan_Store_Category_Menu', array( 'title' => __( 'Store Category', 'dokan' ) ), $args );
              if( dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on' ) {
              the_widget( 'Dokan_Store_Location', array( 'title' => __( 'Store Location', 'dokan' ) ), $args );
              }
              if( dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
              the_widget( 'Dokan_Store_Contact_Form', array( 'title' => __( 'Contact Seller', 'dokan' ) ), $args );
              }
              }

              }
              ?>

              <?php do_action( 'dokan_sidebar_store_after', $store_user, $store_info ); ?>
              </div>
              </div><!-- #secondary .widget-area -->
              <?php
              } else {
              get_sidebar( 'store' );
              } */
            ?>

            <?php do_action('dokan_store_profile_frame_after', $store_user, $store_info); ?>

            <?php if (have_posts()) { ?>

                <div class="cupcake-container">    
                    <?php woocommerce_product_loop_start(); ?>

                    <?php while (have_posts()) : the_post(); ?>

                        <?php wc_get_template_part('content', 'product'); ?>

                    <?php endwhile; // end of the loop.  ?>

                    <?php woocommerce_product_loop_end(); ?>
                </div>

                <?php
                /**
                 * woocommerce_after_shop_loop hook
                 *
                 * @hooked woocommerce_pagination - 10
                 */
                do_action('woocommerce_after_shop_loop');
                ?>    

                <?php dokan_content_nav('nav-below'); ?>

            <?php } else { ?>

                <p class="dokan-info"><?php _e('No products were found of this seller!', 'dokan'); ?></p>

            <?php } ?>

            <?php // do_action( 'woocommerce_after_main_content' );  ?>

        </div>
    </div>
</div>

<?php get_footer('shop'); ?>