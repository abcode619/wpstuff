<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $post;

$prefix = CORNELL_META_PREFIX;

$post_id = $post->ID;

$header_disable     = get_post_meta( $post_id, $prefix . 'header_disable', true );

$header_title       = get_post_meta( $post_id, $prefix . 'header_title', true );
$header_title       = !empty( $header_title ) ? cornell_escape_attr( $header_title ) : '';

$header_image       = get_post_meta( $post_id, $prefix . 'header_image', true );
$header_image_data  = !empty( $header_image ) ? wp_get_attachment_image_src( $header_image, 'medium' ) : '';
$header_image_url   = !empty( $header_image_data[0] ) ? $header_image_data[0] : '';

?>
<table class="form-table cornell-form-table">
    
    <tr>
        <td>
            <label for="<?php echo $prefix ?>header_disable"><?php _e( 'Disable', 'cornell' ) ?></label>
        </td>
        <td>
            <select name="<?php echo $prefix ?>header_disable" id="<?php echo $prefix ?>header_disable">
                <option value="0" <?php selected( $header_disable, '0' ) ?>><?php _e( 'No', 'cornell' ) ?></option>
                <option value="1" <?php selected( $header_disable, '1' ) ?>><?php _e( 'Yes', 'cornell' ) ?></option>
            </select>
        </td>
    </tr>
    
    <tr>
        <td>
            <label for="<?php echo $prefix ?>header_title"><?php _e( 'Title', 'cornell' ) ?></label>
        </td>
        <td>
            <textarea name="<?php echo $prefix ?>header_title" id="<?php echo $prefix ?>header_title" cols="37" rows="4"><?php echo $header_title ?></textarea>
        </td>
    </tr>
    
    <tr>
        <td>
            <label for="<?php echo $prefix ?>header_image"><?php _e( 'Image', 'cornell' ) ?></label>
        </td>
        <td>
        <?php 
            echo '<img class="cornell_custom_media_image" src="'. $header_image_url .'" width="254" height="114" style="'. ( ! $header_image ? 'display:none;' : '' ) .'" />';
            echo '<a href="#" class="button cornell_custom_media_add" style="'. (! $header_image ? '' : 'display:none;') .'">'.__( 'Upload', 'cornell' ).'</a>';
            echo '<a href="#" class="button cornell_custom_media_remove" style="'. ( ! $header_image ? 'display:none;' : '' ) .'">'.__( 'Remove', 'cornell' ).'</a>';
            echo '<input class="cornell_custom_media_id" type="hidden" name="'. $prefix .'header_image" value="'. $header_image .'">';
        ?>
        </td>
    </tr>
    
</table>