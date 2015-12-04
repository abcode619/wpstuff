<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Farmtoyou
 * @since Farmtoyou 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
    <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
        <script type="text/javascript">
            var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
        </script>
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>

        <?php
        $farmtoyou_options = get_option('farmtoyou_options');

        $fb_url = isset($farmtoyou_options['fb_url']) ? farmtoyou_escape_attr($farmtoyou_options['fb_url']) : '';
        $tw_url = isset($farmtoyou_options['tw_url']) ? farmtoyou_escape_attr($farmtoyou_options['tw_url']) : '';
        $pt_url = isset($farmtoyou_options['pt_url']) ? farmtoyou_escape_attr($farmtoyou_options['pt_url']) : '';
        $insta_url = isset($farmtoyou_options['insta_url']) ? farmtoyou_escape_attr($farmtoyou_options['insta_url']) : '';
        ?>

        <div class="top-section orange-bg">
            <div class="container">
                <div class="col-md-6 top-left">
                    <?php if (!empty($fb_url) || !empty($tw_url) || !empty($pt_url) || !empty($insta_url)) { ?>
                        <ul>
                            <?php if (!empty($fb_url)) { ?>
                                <li><a href="<?php echo $fb_url; ?>"><i class="fa fa-facebook"></i></a></li>
                            <?php } ?>   
                            <?php if (!empty($tw_url)) { ?>
                                <li><a href="<?php echo $tw_url; ?>"><i class="fa fa-twitter"></i></a></li>
                            <?php } ?>   
                            <?php if (!empty($pt_url)) { ?>    
                                <li><a href="<?php echo $pt_url; ?>"><i class="fa fa-pinterest"></i></a></li>
                            <?php } ?>   
                            <?php if (!empty($insta_url)) { ?>    
                                <li><a href="<?php echo $insta_url; ?>"><i class="fa fa-instagram"></i></a></li>
                            <?php } ?>    
                        </ul>
                    <?php } ?>    
                </div>
                <div class="col-md-6 top-right">
                    <ul>
                        <?php 
                            $defaults = array(
                                                'theme_location' => 'header',
                                                'menu_class'     => '',
                                                'container'      => false,
                                                'items_wrap'     => '<li id="%1$s" class="%2$s">%3$s</li>'
                                            );
                            wp_nav_menu($defaults);
                        ?>
                        <?php if ( !is_user_logged_in() ) { ?>
                            <li><a href="<?php echo get_permalink( FARMTOYOU_ACCOUNT_PAGE_ID ); ?>">Register</a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo get_permalink( FARMTOYOU_DASHBOARD_PAGE_ID ); ?>">Dashboard</a></li>    
                        <?php } ?>    
                    </ul>
                    
                </div>
            </div>
        </div>
        <!--Top Section end -->

        <div class="header-section">
            <div class="container">
                <div class="col-md-3 top-logo">
                    <a href="<?php echo site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" class="img-responsive2"></a>
                </div>
                <div class="col-md-7 main-menu">
                    <a class="menulinks orange-bg"><i class="fa fa-bars"></i></a>
                    <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => '', 'container' => false)); ?>
                </div>
                <div class="col-md-2 cart">
                    <?php
                        global $woocommerce;
                        $cart_url = $woocommerce->cart->get_cart_url();
                    ?>
                    <a href="<?php echo $cart_url; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/cart.png"></a>
                    <span class="cart-count orange-bg"><?php echo WC()->cart->cart_contents_count; ?></span>
                </div>
            </div>
        </div>

        <?php
            $prefix = FARMTOYOU_META_PREFIX;
            if( is_front_page() ) {

                $banner_args = array(
                                        'post_type'     => FARMTOYOU_BANNER_POST_TYPE,
                                        'post_status'   => 'publish', 
                                        'posts_per_page'=> -1,
                                        'order'         => 'ASC',
                                        'orderby'       => 'menu_order'
                                    );

                $banner_query = new WP_Query( $banner_args );
                if ( $banner_query->have_posts() ) {
        ?>
                <div class="hero-section">

                    <div class="header-slider">
                        <ul class="slides">
                            <?php
                                while ( $banner_query->have_posts() ) : $banner_query->the_post();
                                $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID),'full' );

                                $link  = get_post_meta( $post->ID, $prefix . 'link', true );
                            ?>
                            <li>
                                <img src="<?php echo $feat_image; ?>" class="img-responsive2">
                                <div class="slide-text">
                                    <h1><?php the_title(); ?></h1>
                                    <?php the_content(); ?>

                                    <?php if( !empty( $link ) ) { ?>
                                        <a href="<?php echo $link; ?>" class="read-more">Read More</a>
                                    <?php } ?>    
                                </div>
                            </li>
                            <?php
                                endwhile;
                                //reset the query
                                wp_reset_query();
                            ?>
                        </ul>
                    </div>
                </div>
        <!--Hero Section end-->
        <?php
            }
        } else if ( is_cart() ||  is_checkout() || is_page() ) {

            $header_disable     = get_post_meta( $post->ID, $prefix . 'header_disable', true );

            $header_image       = get_post_meta( $post->ID, $prefix . 'header_image', true );
            $header_image_data  = !empty( $header_image ) ? wp_get_attachment_image_src( $header_image, 'full' ) : '';
            $header_image_url   = !empty( $header_image_data[0] ) ? $header_image_data[0] : '';
            
            if( $header_disable != '1' ) {
        ?>
            <div class="workhero-section">
                <img src="<?php echo $header_image_url; ?>" class="img-responsive2">
            </div>
        <?php 
            }
        } else if ( is_single() ) {
            
            $header_disable     = get_post_meta( FARMTOYOU_BLOG_PAGE_ID, $prefix . 'header_disable', true );

            $header_image       = get_post_meta( FARMTOYOU_BLOG_PAGE_ID, $prefix . 'header_image', true );
            $header_image_data  = !empty( $header_image ) ? wp_get_attachment_image_src( $header_image, 'full' ) : '';
            $header_image_url   = !empty( $header_image_data[0] ) ? $header_image_data[0] : '';
            
            if( $header_disable != '1' ) {
        ?>
            <div class="workhero-section">
                <img src="<?php echo $header_image_url; ?>" class="img-responsive2">
            </div>
        <?php         
            }
        } else if ( is_404() || is_search() ) {
            $farmtoyou_options   = get_option( 'farmtoyou_options' );
    
            $farmtoyou_404_img      = isset( $farmtoyou_options['404_img'] ) ? $farmtoyou_options['404_img'] : '';
            $farmtoyou_search_img   = isset( $farmtoyou_options['search_img'] ) ? $farmtoyou_options['search_img'] : '';
            
            $header_img_url = is_404() ? $farmtoyou_404_img : $farmtoyou_search_img;
        ?>
            <div class="workhero-section">
                <img src="<?php echo $header_img_url; ?>" class="img-responsive2">
            </div>
        <?php      
        }
        ?>
        
        <div class="top-search">
            <div class="container">
                <div class="search-box">
                    <?php dynamic_sidebar('sidebar-6'); ?>
                </div>
                
                <div class="zipcode-box">
                    <a class="fancybox" href="#zipfields"><i class="fa fa-search"></i><?php _e('Find a farm near you', 'farmtoyou'); ?></a>
                </div>
                
                <div id="zipfields" style="display: none;">
                    <form action="" method="get">
                        <input type="text" maxlength="5" name="zipcode" id="zipcode" placeholder="Enter zipcode here" required="required">
                        <select name="miles">
                            <option value="25">25 miles</option>
                            <option value="50">50 miles</option>
                            <option value="100">100 miles</option>
                        </select> 
                        <input type="submit" value="Search">
                    </form>    
                </div>
            </div>
        </div>
        <!--Top Search end-->