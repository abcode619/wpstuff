<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    function demotheme_admin_tabs( $current = 'general' ) {
        $tabs = array( 
                        'demotheme_tab_general'       => __( 'General', 'demotheme' ),
                        'demotheme_tab_images'        => __( 'Images', 'demotheme' ),
                        'demotheme_tab_social'        => __( 'Social', 'demotheme' ),
                        'demotheme_tab_footer'        => __( 'Footer', 'demotheme' )
                    ); 
        $links = array();
        echo '<div id="icon-themes" class="icon32"><br></div>';
        echo '<h2 class="nav-tab-wrapper">';
        foreach( $tabs as $tab => $name ){
            $class = ( $tab == $current ) ? ' nav-tab-active' : '';
            echo "<a class='nav-tab$class' href='#$tab'>$name</a>";
        }
        echo '</h2>';
    }
    
    $demotheme_options   = get_option( 'demotheme_options' );
    
    $site_logo      = isset( $demotheme_options['site_logo'] ) ? demotheme_escape_attr( $demotheme_options['site_logo'] ) : '';
    
    $clients_images = isset( $demotheme_options['clients_images'] ) ? demotheme_escape_attr( $demotheme_options['clients_images'] ) : '';
    
    $fb_url     = isset( $demotheme_options['fb_url'] ) ? demotheme_escape_attr( $demotheme_options['fb_url'] ) : '';
    $tw_url     = isset( $demotheme_options['tw_url'] ) ? demotheme_escape_attr( $demotheme_options['tw_url'] ) : '';
    $li_url     = isset( $demotheme_options['li_url'] ) ? demotheme_escape_attr( $demotheme_options['li_url'] ) : '';
    $gp_url     = isset( $demotheme_options['gp_url'] ) ? demotheme_escape_attr( $demotheme_options['gp_url'] ) : '';
    $yt_url     = isset( $demotheme_options['yt_url'] ) ? demotheme_escape_attr( $demotheme_options['yt_url'] ) : '';
    
    $cpy_text   = isset( $demotheme_options['cpy_text'] ) ? demotheme_escape_attr( $demotheme_options['cpy_text'] ) : '';
?>
<div class="wrap demotheme-settings-page">
    
    <h2><?php _e( 'Theme Options', 'demotheme' ) ?></h2>

    <?php
    
        if( isset( $_GET['settings-updated'] ) ) {

            echo '<div class="updated"> 
                    <p><strong>'. __( 'Settings saved.', 'demotheme' ) .'</strong></p>
                </div>';
        }
    
    ?>
    
    <?php echo demotheme_admin_tabs(); ?>
    <form method="post" action="options.php">
        
        <?php settings_fields( 'demotheme-settings-group' ); ?>
        
        <div class="demotheme-content">
            
            <div class="demotheme-tab-content" id="demotheme_tab_general">
                <table class="form-table demotheme-form-table">

                    <tr valign="top">
                        <td scope="row">
                            <label for="demotheme_options_site_logo"><?php _e( 'Site Logo', 'demotheme' ) ?></label>
                        </td>
                        <td>
                        <?php
                            $html = '';
                            
                            $html .= "<div class='file-input-advanced'>";
                            $html .= "<input type='text' name='demotheme_options[site_logo]' value='".$site_logo."' style='width:40%;' class='demotheme-upload-file-link' placeholder='http://'/>";
                            $html .= "<span class='demotheme-upload-files'><a class='demotheme-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','demotheme')."</a></span>";
                            $html .= "</div><!-- End .file-input-advanced -->";
                            
                            echo $html;
                        ?>
                        </td>
                    </tr>
                    
                </table>
            </div>
            
            <div class="demotheme-tab-content" id="demotheme_tab_images">
                <table class="form-table demotheme-form-table">
                    <tr valign="top">
                        <td scope="row">
                            <label for="demotheme_clients_images"><?php _e( 'Clients Images', 'demotheme' ); ?></label>
                        </td>
                        <td>
                            <div id="wp_gallery_images_container">
                                <ul class="wp_gallery_images">
                                        <?php
                                                $attachments = array_filter( explode( ',', $clients_images ) );

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

                                <input type="hidden" id="wp_gallery_image_gallery" name="demotheme_options[clients_images]" value="<?php echo esc_attr( $clients_images ); ?>" />

                            </div>
                            <p class="add_wp_gallery_images hide-if-no-js">
                                    <a href="javascript:void(0);" data-choose="<?php _e( 'Add Photos', 'demotheme' ); ?>" data-update="<?php _e( 'Add to gallery', 'demotheme' ); ?>" data-delete="<?php _e( 'Delete image', 'demotheme' ); ?>" data-text="<?php _e( 'Delete', 'demotheme' ); ?>"><?php _e( 'Add images', 'demotheme' ); ?></a>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="demotheme-tab-content" id="demotheme_tab_social">
                <table class="form-table demotheme-form-table">

                    <tr valign="top">
                        <td scope="row">
                            <label for="demotheme_options_fb_url"><?php _e( 'Facebook URL', 'demotheme' ); ?></label>
                        </td>
                        <td>
                            <input type="text" id="demotheme_options_fb_url" name="demotheme_options[fb_url]" class="regular-text" value="<?php echo $fb_url ?>" />
                        </td>
                    </tr>

                    <tr valign="top">
                        <td scope="row">
                            <label for="demotheme_options_tw_url"><?php _e( 'Twitter URL', 'demotheme' ); ?></label>
                        </td>
                        <td>
                            <input type="text" id="demotheme_options_tw_url" name="demotheme_options[tw_url]" class="regular-text" value="<?php echo $tw_url ?>" />
                        </td>
                    </tr>

                    <tr valign="top">
                        <td scope="row">
                            <label for="demotheme_options_li_url"><?php _e( 'LinkedIn URL', 'demotheme' ); ?></label>
                        </td>
                        <td>
                            <input type="text" id="demotheme_options_li_url" name="demotheme_options[li_url]" class="regular-text" value="<?php echo $li_url ?>" />
                        </td>
                    </tr>

                    <tr valign="top">
                        <td scope="row">
                            <label for="demotheme_options_gp_url"><?php _e( 'Google+ URL', 'demotheme' ); ?></label>
                        </td>
                        <td>
                            <input type="text" id="demotheme_options_gp_url" name="demotheme_options[gp_url]" class="regular-text" value="<?php echo $gp_url ?>" />
                        </td>
                    </tr>

                    <tr valign="top">
                        <td scope="row">
                            <label for="demotheme_options_yt_url"><?php _e( 'You Tube URL', 'demotheme' ); ?></label>
                        </td>
                        <td>
                            <input type="text" id="demotheme_options_yt_url" name="demotheme_options[yt_url]" class="regular-text" value="<?php echo $yt_url ?>" />
                        </td>
                    </tr>
                    
                </table>
            </div>
            
            <div class="demotheme-tab-content" id="demotheme_tab_footer">
                <table class="form-table demotheme-form-table">

                    <tr valign="top">
                        <td scope="row">
                            <label for="cpy_text"><?php _e( 'Copy Right Text', 'demotheme' ); ?></label>
                        </td>
                        <td>
                            <input type="text" id="demotheme_options_cpy_text" name="demotheme_options[cpy_text]" class="regular-text" value="<?php echo $cpy_text ?>" />
                        </td>
                    </tr>
                    
                </table>
            </div>
            
        </div>    

        <?php submit_button(); ?>

    </form>
</div>