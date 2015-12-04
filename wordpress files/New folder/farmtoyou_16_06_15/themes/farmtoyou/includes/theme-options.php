<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    function farmtoyou_admin_tabs( $current = 'general' ) {
        $tabs = array(
                        'farmtoyou_tab_general' => __( 'General', 'farmtoyou' ),
                        'farmtoyou_tab_social'  => __( 'Social', 'farmtoyou' ),
                        'farmtoyou_tab_footer'  => __( 'Footer', 'farmtoyou' )
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
    
    $farmtoyou_options   = get_option( 'farmtoyou_options' );
    
    $farmtoyou_404_img      = isset( $farmtoyou_options['404_img'] ) ? farmtoyou_escape_attr( $farmtoyou_options['404_img'] ) : '';
    $farmtoyou_search_img   = isset( $farmtoyou_options['search_img'] ) ? farmtoyou_escape_attr( $farmtoyou_options['search_img'] ) : '';
    
    $fb_url     = isset( $farmtoyou_options['fb_url'] ) ? farmtoyou_escape_attr( $farmtoyou_options['fb_url'] ) : '';
    $tw_url     = isset( $farmtoyou_options['tw_url'] ) ? farmtoyou_escape_attr( $farmtoyou_options['tw_url'] ) : '';
    $pt_url     = isset( $farmtoyou_options['pt_url'] ) ? farmtoyou_escape_attr( $farmtoyou_options['pt_url'] ) : '';
    $insta_url  = isset( $farmtoyou_options['insta_url'] ) ? farmtoyou_escape_attr( $farmtoyou_options['insta_url'] ) : '';
    
    $cpy_text   = isset( $farmtoyou_options['cpy_text'] ) ? farmtoyou_escape_attr( $farmtoyou_options['cpy_text'] ) : '';
?>
<div class="wrap farmtoyou-settings-page">
    
    <h2><?php _e( 'Theme Options', 'farmtoyou' ) ?></h2>

    <?php
    
        if( isset( $_GET['settings-updated'] ) ) {

            echo '<div class="updated"> 
                    <p><strong>'. __( 'Settings saved.', 'farmtoyou' ) .'</strong></p>
                </div>';
        }
    
    ?>
    
    <?php echo farmtoyou_admin_tabs(); ?>
    <form method="post" action="options.php">
        
        <?php settings_fields( 'farmtoyou-settings-group' ); ?>
        
        <div class="farmtoyou-content">
            
            <div class="farmtoyou-tab-content" id="farmtoyou_tab_general">
                <table class="form-table farmtoyou-form-table">
                    
                    <tr valign="top">
                        <td scope="row">
                            <label for="farmtoyou_options_404_img"><?php _e( '404 Page Header Image', 'farmtoyou' ) ?></label>
                        </td>
                        <td>
                        <?php
                            $html = '';
                            
                            $html .= "<div class='file-input-advanced'>";
                            $html .= "<input type='text' name='farmtoyou_options[404_img]' value='".$farmtoyou_404_img."' style='width:40%;' class='farmtoyou-upload-file-link' placeholder='http://'/>";
                            $html .= "<span class='farmtoyou-upload-files'><a class='farmtoyou-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','farmtoyou')."</a></span>";
                            $html .= "</div><!-- End .file-input-advanced -->";
                            
                            echo $html;
                        ?>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <td scope="row">
                            <label for="farmtoyou_options_search_img"><?php _e( 'Search Page Header Image', 'farmtoyou' ) ?></label>
                        </td>
                        <td>
                        <?php
                            $html = '';
                            
                            $html .= "<div class='file-input-advanced'>";
                            $html .= "<input type='text' name='farmtoyou_options[search_img]' value='".$farmtoyou_search_img."' style='width:40%;' class='farmtoyou-upload-file-link' placeholder='http://'/>";
                            $html .= "<span class='farmtoyou-upload-files'><a class='farmtoyou-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','farmtoyou')."</a></span>";
                            $html .= "</div><!-- End .file-input-advanced -->";
                            
                            echo $html;
                        ?>
                        </td>
                    </tr>

                </table>
            </div>
            
            <div class="farmtoyou-tab-content" id="farmtoyou_tab_social">
                <table class="form-table farmtoyou-form-table">

                    <tr valign="top">
                        <th scope="row" colspan="2">
                            <label><?php _e( 'Social Options', 'farmtoyou' ); ?></label>
                        </th>
                    </tr>

                    <tr valign="top">
                        <td scope="row">
                            <label for="farmtoyou_options_fb_url"><?php _e( 'Facebook URL', 'farmtoyou' ); ?></label>
                        </td>
                        <td>
                            <input type="text" id="farmtoyou_options_fb_url" name="farmtoyou_options[fb_url]" class="regular-text" value="<?php echo $fb_url ?>" />
                        </td>
                    </tr>

                    <tr valign="top">
                        <td scope="row">
                            <label for="farmtoyou_options_tw_url"><?php _e( 'Twitter URL', 'farmtoyou' ); ?></label>
                        </td>
                        <td>
                            <input type="text" id="farmtoyou_options_tw_url" name="farmtoyou_options[tw_url]" class="regular-text" value="<?php echo $tw_url ?>" />
                        </td>
                    </tr>

                    <tr valign="top">
                        <td scope="row">
                            <label for="farmtoyou_options_pt_url"><?php _e( 'Pinterest URL', 'farmtoyou' ); ?></label>
                        </td>
                        <td>
                            <input type="text" id="farmtoyou_options_pt_url" name="farmtoyou_options[pt_url]" class="regular-text" value="<?php echo $pt_url ?>" />
                        </td>
                    </tr>

                    <tr valign="top">
                        <td scope="row">
                            <label for="farmtoyou_options_insta_url"><?php _e( 'Instagram URL', 'farmtoyou' ); ?></label>
                        </td>
                        <td>
                            <input type="text" id="farmtoyou_options_insta_url" name="farmtoyou_options[insta_url]" class="regular-text" value="<?php echo $insta_url ?>" />
                        </td>
                    </tr>

                </table>
            </div>
            
            <div class="farmtoyou-tab-content" id="farmtoyou_tab_footer">
                <table class="form-table farmtoyou-form-table">
                    <tr valign="top">
                        <th scope="row" colspan="2">
                            <label><?php _e( 'Footer Options', 'farmtoyou' ); ?></label>
                        </th>
                    </tr>

                    <tr valign="top">
                        <td scope="row">
                            <label for="cpy_text"><?php _e( 'Copy Right Text', 'farmtoyou' ); ?></label>
                        </td>
                        <td>
                            <input type="text" id="farmtoyou_options_cpy_text" name="farmtoyou_options[cpy_text]" class="regular-text" value="<?php echo $cpy_text ?>" />
                        </td>
                    </tr>
                </table>
            </div>    
            
        </div>    

        <?php submit_button(); ?>

    </form>
</div>