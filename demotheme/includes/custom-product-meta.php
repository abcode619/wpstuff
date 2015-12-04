<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $post;

$prefix = DEMOTHEME_META_PREFIX;

$post_id = $post->ID;

$product_images = get_post_meta( $post_id, $prefix . 'product_images', true );

$product_title  = get_post_meta( $post_id, $prefix . 'product_title', true );
$product_title  = !empty( $product_title ) ? demotheme_escape_attr( $product_title ) : '';

$product_desc   = get_post_meta( $post_id, $prefix . 'product_desc', true );
$product_desc   = !empty( $product_desc ) ? demotheme_escape_attr( $product_desc ) : '';

$product_video_url   = get_post_meta( $post_id, $prefix . 'product_video_url', true );
$product_video_url   = !empty( $product_video_url ) ? demotheme_escape_attr( $product_video_url ) : '';
?>
<table class="form-table demotheme-form-table">
    
    <tr>
        <td>
            <label for="<?php echo $prefix ?>product_title"><?php _e( 'Product Title', 'demotheme' ) ?></label>
        </td>
        <td>
            <input type="text" name="<?php echo $prefix ?>product_title" id="<?php echo $prefix ?>product_title" class="regular-text" value="<?php echo $product_title ?>" />
        </td>
    </tr>
    <tr>
        <td>
            <label for="<?php echo $prefix ?>product_desc"><?php _e( 'Product Description', 'demotheme' ) ?></label>
        </td>
        <td>
            <textarea name="<?php echo $prefix ?>product_desc" id="<?php echo $prefix ?>product_desc" class="regular-text" cols="37" rows="4"><?php echo $product_desc ?></textarea>
        </td>
    </tr>
    <tr>
        <td>
            <label for="demotheme_product_images"><?php _e( 'Product Images', 'demotheme' ); ?></label>
        </td>
        <td>
            <div id="wp_gallery_images_container">
                <ul class="wp_gallery_images">
                        <?php
                                $attachments = array_filter( explode( ',', $product_images ) );

                                if ( $attachments ) {
                                    foreach ( $attachments as $attachment_id ) {
                                            echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
                                                    ' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
                                                    <ul class="actions">
                                                            <li><a title="' . __( 'Delete image', 'demotheme' ) . '" href="javascript:void(0);" class="delete tips" data-tip="' . __( 'Delete image', 'demotheme' ) . '">X</a></li>
                                                    </ul>
                                            </li>';
                                    }
                                }
                        ?>
                </ul>

                <input type="hidden" id="wp_gallery_image_gallery" name="<?php echo $prefix ?>product_images" value="<?php echo esc_attr( $product_images ); ?>" />

            </div>
            <p class="add_wp_gallery_images hide-if-no-js">
                <a href="javascript:void(0);" data-choose="<?php _e( 'Add Photos', 'demotheme' ); ?>" data-update="<?php _e( 'Add to gallery', 'demotheme' ); ?>" data-delete="<?php _e( 'Delete image', 'demotheme' ); ?>" data-text="<?php _e( 'Delete', 'demotheme' ); ?>"><?php _e( 'Add images', 'demotheme' ); ?></a>
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <label for="<?php echo $prefix ?>product_video_url"><?php _e( 'YouTube/Vimeo URL', 'demotheme' ) ?></label>
        </td>
        <td>
            <input type="text" name="<?php echo $prefix ?>product_video_url" id="<?php echo $prefix ?>product_video_url" class="regular-text" value="<?php echo $product_video_url; ?>" />
        </td>
    </tr>
</table>