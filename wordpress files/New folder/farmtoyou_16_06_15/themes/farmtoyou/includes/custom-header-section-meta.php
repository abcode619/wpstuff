<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $post;

$prefix = FARMTOYOU_META_PREFIX;
$post_id = $post->ID;

$header_disable     = get_post_meta( $post_id, $prefix . 'header_disable', true );

$header_image       = get_post_meta( $post_id, $prefix . 'header_image', true );
$header_image_data  = !empty( $header_image ) ? wp_get_attachment_image_src( $header_image, 'medium' ) : '';
$header_image_url   = !empty( $header_image_data[0] ) ? $header_image_data[0] : '';

?>
<table class="form-table farmtoyou-form-table">
    
    <tr>
        <td>
            <label for="<?php echo $prefix ?>header_disable"><?php _e( 'Disable', 'farmtoyou' ) ?></label>
        </td>
        <td>
            <select name="<?php echo $prefix ?>header_disable" id="<?php echo $prefix ?>header_disable">
                <option value="0" <?php selected( $header_disable, '0' ) ?>><?php _e( 'No', 'farmtoyou' ) ?></option>
                <option value="1" <?php selected( $header_disable, '1' ) ?>><?php _e( 'Yes', 'farmtoyou' ) ?></option>
            </select>
        </td>
    </tr>
    
    <tr>
        <td>
            <label for="<?php echo $prefix ?>header_image"><?php _e( 'Image', 'farmtoyou' ) ?></label>
        </td>
        <td>
        <?php 
            echo '<img class="farmtoyou_custom_media_image" src="'. $header_image_url .'" width="254" height="114" style="'. ( ! $header_image ? 'display:none;' : '' ) .'" />';
            echo '<a href="#" class="button farmtoyou_custom_media_add" style="'. (! $header_image ? '' : 'display:none;') .'">'.__( 'Upload', 'esaprkbiz' ).'</a>';
            echo '<a href="#" class="button farmtoyou_custom_media_remove" style="'. ( ! $header_image ? 'display:none;' : '' ) .'">'.__( 'Remove', 'esaprkbiz' ).'</a>';
            echo '<input class="farmtoyou_custom_media_id" type="hidden" name="'. $prefix .'header_image" value="'. $header_image .'">';
        ?>
        </td>
    </tr>
    
</table>