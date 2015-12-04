<?php
/**
 * The Template for displaying all reviews.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$prefix = FARMTOYOU_META_PREFIX;
$store_user = get_userdata( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->ID );
$user_description = get_the_author_meta( 'description', $store_user->ID );
$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';
$scheme       = is_ssl() ? 'https' : 'http';

wp_enqueue_script( 'google-maps', $scheme . '://maps.google.com/maps/api/js?sensor=true' );

get_header( 'shop' );
?>
    
        <div class="main-work-section">
            <div class="container">
                <div class="col-md-12 work-left">
                    <div class="provider-image">
                        <?php echo get_avatar( $store_user->ID, 68 ); ?>
                    </div>

                    <div class="provider-title">
                        <?php if ( isset( $store_info['store_name'] ) ) { ?>
                            <h6><?php echo esc_html( $store_info['store_name'] ); ?></h6>
                        <?php } ?>
                        <?php if ( isset( $store_info['address'] ) && !empty( $store_info['address'] ) ) { ?>    
                            <span class="country"><?php echo esc_html( $store_info['address'] ); ?></span>
                        <?php } ?>    
                    </div>

                    <?php if ( !empty( $user_description ) ) { ?>    
                        <div class="provide-content"><?php echo $user_description; ?></div>
                    <?php } ?>
                        
                        <div class="mainreview-box">
                            <h2 class="headline"><?php _e( 'Seller Review', 'dokan' ); ?></h2>
                            <ol class="commentlist">
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

                                    foreach ($all_seller_review as $key => $value) {
                                        $user_rating = get_post_meta( $value->ID, $prefix.'seller_rating', true );
                                        $user_comments   = get_post_meta( $value->ID, $prefix.'user_comment', true );
                                        $comment_user_id = get_post_meta( $value->ID, $prefix.'current_user_id', true );
                                        $user_info = get_userdata($comment_user_id);
                                        $comment_date = isset($value->post_date) ? $value->post_date : '';
                                        $comment_date = date( 'l, F j, Y g:i a', strtotime($comment_date) );
                                ?>

                                        <li>
                                            <div class="review_comment_container">
                                                <div class="dokan-review-author-img">
                                                    <?php echo get_avatar( $comment_user_id, 180 ); ?>
                                                </div>
                                                <div class="comment-text">
                                                    <div class="dokan-rating">
                                                        <div class="star-rating" title="<?php echo sprintf(__( 'Rated %f out of 5', 'dokan' ), $user_rating) ?>">
                                                            <span style="width:<?php echo ( ( $user_rating / 5 ) * 100 ); ?>%"><strong itemprop="ratingValue"><?php echo $user_rating; ?></strong> <?php _e( 'out of 5', 'dokan' ); ?></span>
                                                        </div>
                                                    </div>
                                                    <p>
                                                        <strong itemprop="author"><?php echo $user_info->user_login; ?></strong> -
                                                        <?php if( !empty( $comment_date ) ) { ?>
                                                            <time itemprop="datePublished"><?php echo $comment_date; ?></time>
                                                        <?php } ?>    
                                                    </p>
                                                    <div class="description" itemprop="description">
                                                        <p><?php echo $user_comments; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                <?php
                                    }
                                ?>
                            </ol>
                        </div>    
                </div>
            </div>
        </div>

<?php get_footer(); ?>