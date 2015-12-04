<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>

<!--<li <?php // post_class( $classes ); ?>>-->
    <li class="col-md-4 product-box">
    
        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
        
        <?php
            $link = get_permalink($product->post->id);
        ?>
        <div class="product-image">
            <a href="<?php echo $link; ?>">
                <?php
                        /**
                         * woocommerce_before_shop_loop_item_title hook
                         *
                         * @hooked woocommerce_show_product_loop_sale_flash - 10
                         * @hooked woocommerce_template_loop_product_thumbnail - 10
                         */
                        do_action( 'woocommerce_before_shop_loop_item_title' );
                ?>
            </a>
        </div>    
        <?php 
            $terms = get_the_terms( $post->ID, 'product_cat' );
        ?>
        <div class="product-detail">

            <a href="<?php echo get_permalink(); ?>">
                <h6><?php the_title(); ?></h6>

                <?php
                        /**
                         * woocommerce_after_shop_loop_item_title hook
                         *
                         * @hooked woocommerce_template_loop_rating - 5
                         * @hooked woocommerce_template_loop_price - 10
                         */
                        do_action( 'woocommerce_after_shop_loop_item_title' );
                ?>
            </a>    
                <ul>
                    <?php 
                        $author_id = get_the_author_meta( 'ID' );
                        $author_url  = dokan_get_store_url( $author_id );
                    ?>
                    <li><a href="<?php echo $author_url; ?>"><?php the_author(); ?></a></li>
                    <?php foreach( $terms as $term ) { ?>
                        <li><a href="<?php echo get_term_link($term->slug, 'product_cat'); ?>"><?php echo $term->name; ?></a></li>
                    <?php } ?>
                </ul>

            <div class="product-detail inner-box">
                <?php

                        /**
                         * woocommerce_after_shop_loop_item hook
                         *
                         * @hooked woocommerce_template_loop_add_to_cart - 10
                         */
                        do_action( 'woocommerce_after_shop_loop_item' ); 

                ?>
            </div>

        </div>
    
    </li>
<!--</li>-->