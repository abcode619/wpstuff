<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Farmtoyou
 * @since Farmtoyou 1.0
 */
?>
<?php
$farmtoyou_options = get_option('farmtoyou_options');

$purpose_title = isset($farmtoyou_options['purpose_title']) ? $farmtoyou_options['purpose_title'] : '';
$purpose_desc = isset($farmtoyou_options['purpose_desc']) ? $farmtoyou_options['purpose_desc'] : '';

$fb_url = isset($farmtoyou_options['fb_url']) ? $farmtoyou_options['fb_url'] : '';
$tw_url = isset($farmtoyou_options['tw_url']) ? $farmtoyou_options['tw_url'] : '';
$pt_url = isset($farmtoyou_options['pt_url']) ? $farmtoyou_options['pt_url'] : '';
$insta_url = isset($farmtoyou_options['insta_url']) ? $farmtoyou_options['insta_url'] : '';

$cpy_text = isset($farmtoyou_options['cpy_text']) ? $farmtoyou_options['cpy_text'] : '';
?>

            <div class="bottom-search">
                <div class="container">
                    <?php echo do_shortcode('[contact-form-7 id="71" title="Subscriber form"]'); ?>
                </div>
            </div>
            <!--Bottom Search end-->


            <div class="footer-section orange-bg">
                <div class="container">
                    <div class="footer-top">
                        <div class="ft-row1">
                            <div class="footermenu-left">
                                <ul>
                                    <?php if ( !is_user_logged_in() ) { ?>
                                        <li><a href="<?php echo get_permalink( FARMTOYOU_ACCOUNT_PAGE_ID ); ?>">Register</a></li>
                                    <?php } ?>  
                                    <?php 
                                        $defaults = array(
                                                            'theme_location' => 'footer',
                                                            'menu_class'     => '',
                                                            'container'      => false,
                                                            'items_wrap'     => '<li id="%1$s" class="%2$s">%3$s</li>'
                                                        );
                                        wp_nav_menu($defaults);
                                    ?>
                                </ul>
                                <?php // wp_nav_menu(array('theme_location' => 'footer', 'menu_class' => '', 'container' => false)); ?>
                            </div>
                            <div class="footermenu-right">
                                <?php wp_nav_menu(array('theme_location' => 'footer2', 'menu_class' => '', 'container' => false)); ?>
                            </div>
                        </div>
                        <div class="ft-row2">
                            <div class="col-md-4 purpose min-hgt">
                                <?php dynamic_sidebar( 'sidebar-3' ); ?>
                            </div>
                            <div class="col-md-4 social min-hgt">
                                <?php dynamic_sidebar( 'sidebar-4' ); ?>
                            </div>
                            <div class="col-md-4 areu-farmer min-hgt">
                                <?php dynamic_sidebar( 'sidebar-5' ); ?>
                            </div>
                        </div>
                    </div>
                    <?php if( !empty( $cpy_text ) ) { ?>
                        <div class="footer-bottom">
                            <ul>
                                <?php echo $cpy_text; ?>
                            </ul>
                        </div>
                    <?php } ?> 
                </div>
            </div>

        <?php wp_footer(); ?>
    </body>
</html>