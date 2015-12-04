<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $post, $post_type;

$prefix = OREVA_META_PREFIX;

$post_id = $post->ID;

$oreva_catelogue_title          = get_post_meta( $post_id, $prefix . 'catelogue_title', true );
$oreva_catelogue_download_url   = get_post_meta( $post_id, $prefix . 'catelogue_download_url', true );
$oreva_software_title           = get_post_meta( $post_id, $prefix . 'software_title', true );
$oreva_software_download_url    = get_post_meta( $post_id, $prefix . 'software_download_url', true );

?>
<table class="form-table oreva-form-table">
    
    <tr>
        <th colspan="2">
            <label><?php _e( 'Catelogue Download', 'oreva' ) ?></label>
        </th>
    </tr>
    <tr>
        <td>
            <label for="oreva_img_gallery"><?php _e( 'DOWNLOAD URL', 'oreva' ) ?></label>
        </td>
        <td>
        <?php
            $html = '';
            if( !empty( $oreva_catelogue_download_url ) ) {
                foreach( ( array )$oreva_catelogue_download_url as $key => $att ) {
                    if(!empty($att)) {
                        $splitname = pathinfo( $att );
                        $catelogue_title = isset( $oreva_catelogue_title[$key] ) && !empty( $oreva_catelogue_title[$key] ) ? $oreva_catelogue_title[$key] : '';
                        $html .= "<div class='file-input-advanced'>";
                        $html .= "<input type='text' name='". $prefix . "catelogue_title[]' value='".$catelogue_title."' style='width:25%;' class='oreva-download-title' placeholder='Title'/>";
                        $html .= "<input type='text' name='". $prefix . "catelogue_download_url[]' value='".$att."' style='width:60%;' class='oreva-upload-file-link' placeholder='http://'/>";
                        $html .= "<span class='oreva-upload-files'><a class='oreva-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','oreva')."</a></span>";
                        $html .= "<a href='javascript:void(0);' class='oreva-delete-fileadvanced'><img src='".get_template_directory_uri()."/images/delete.png' alt='".__('Delete','oreva')."'/></a>";
                        $html .= "</div><!-- End .file-input-advanced -->";
                    }
                }
            } 
            if( empty( $oreva_catelogue_download_url[0] ) ) {

                    $html .= "<div class='file-input-advanced'>";
                    $html .= "<input type='text' name='". $prefix . "catelogue_title[]' value='' style='width:25%;' class='oreva-download-title' placeholder='Title'/>";
                    $html .= "<input type='text' name='". $prefix . "catelogue_download_url[]' value='' style='width:60%;' class='oreva-upload-file-link' placeholder='http://'/>";
                    $html .= "<span class='oreva-upload-files'><a class='oreva-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','oreva')."</a></span>";
                    $html .= "<a href='javascript:void(0);' class='oreva-delete-fileadvanced'><img src='".get_template_directory_uri()."/images/delete.png' alt='".__('Delete','oreva')."'/></a>";
                    $html .= "</div><!-- End .file-input-advanced -->";
            }

            $html .= "<a class='oreva-meta-add-fileadvanced button' href='javascript:void(0);'>" . __( 'Add more', 'oreva' ) . "</a>";
            echo $html;
        ?>
        </td>
    </tr>
    
    <tr>
        <th colspan="2">
            <label><?php _e( 'Software: Moving Display Borard Download', 'oreva' ) ?></label>
        </th>
    </tr>
    <tr>
        <td>
            <label for="oreva_img_gallery"><?php _e( 'DOWNLOAD URL', 'oreva' ) ?></label>
        </td>
        <td>
        <?php
            $html = '';
            if( !empty( $oreva_software_download_url ) ) {
                foreach( ( array )$oreva_software_download_url as $key => $att ) {
                    if(!empty($att)) {
                        $splitname = pathinfo( $att );
                        $software_title = isset( $oreva_software_title[$key] ) && !empty( $oreva_software_title[$key] ) ? $oreva_software_title[$key] : '';
                        $html .= "<div class='file-input-advanced'>";
                        $html .= "<input type='text' name='". $prefix . "software_title[]' value='".$software_title."' style='width:25%;' class='oreva-download-title' placeholder='Title'/>";
                        $html .= "<input type='text' name='". $prefix . "software_download_url[]' value='".$att."' style='width:60%;' class='oreva-upload-file-link' placeholder='http://'/>";
                        $html .= "<span class='oreva-upload-files'><a class='oreva-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','oreva')."</a></span>";
                        $html .= "<a href='javascript:void(0);' class='oreva-delete-fileadvanced'><img src='".get_template_directory_uri()."/images/delete.png' alt='".__('Delete','oreva')."'/></a>";
                        $html .= "</div><!-- End .file-input-advanced -->";
                    }
                }
            } 
            if( empty( $oreva_software_download_url[0] ) ) {

                    $html .= "<div class='file-input-advanced'>";
                    $html .= "<input type='text' name='". $prefix . "software_title[]' value='' style='width:25%;' class='oreva-download-title' placeholder='Title'/>";
                    $html .= "<input type='text' name='". $prefix . "software_download_url[]' value='' style='width:60%;' class='oreva-upload-file-link' placeholder='http://'/>";
                    $html .= "<span class='oreva-upload-files'><a class='oreva-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','oreva')."</a></span>";
                    $html .= "<a href='javascript:void(0);' class='oreva-delete-fileadvanced'><img src='".get_template_directory_uri()."/images/delete.png' alt='".__('Delete','oreva')."'/></a>";
                    $html .= "</div><!-- End .file-input-advanced -->";
            }

            $html .= "<a class='oreva-meta-add-fileadvanced button' href='javascript:void(0);'>" . __( 'Add more', 'oreva' ) . "</a>";
            echo $html;
        ?>
        </td>
    </tr>
    
</table>