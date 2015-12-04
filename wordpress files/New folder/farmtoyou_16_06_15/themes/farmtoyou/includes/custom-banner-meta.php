<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $post;

$prefix = FARMTOYOU_META_PREFIX;

$post_id = $post->ID;

$link  = get_post_meta( $post_id, $prefix . 'link', true );
$link  = !empty( $link ) ? farmtoyou_escape_attr( $link ) : '';
?>
<table class="form-table farmtoyou-form-table">
    
    <tr>
        <td>
            <label for="<?php echo $prefix ?>link"><?php _e( 'Read More Link', 'farmtoyou' ) ?></label>
        </td>
        <td>
            <input type="text" name="<?php echo $prefix ?>link" id="<?php echo $prefix ?>link" class="regular-text" value="<?php echo $link ?>" />
        </td>
    </tr>
    
</table>