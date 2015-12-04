<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Farmtoyou
 * @since Farmtoyou 1.0
 */

get_header(); ?>

        <div class="main-work-section">
            <div class="container">
                <div class="col-md-12 work-left">

                    <?php
                        // Start the Loop.
                        while ( have_posts() ) : the_post();
                    ?>    
                        <h2><?php echo the_title(); ?></h2>
                    <?php        
                        the_content();
                        endwhile;
                    ?>

                </div>
<!--                <div class="col-md-3 work-right">
                    <h2>Featured Farm</h2>
                    <div class="ff-box">
                        <a href="#"><img src="<?php // echo get_template_directory_uri(); ?>/images/ff1.jpg" class="img-responsive2"></a>
                        <div class="ff-detail">
                            <div class="ffd-image"><a href="#"><img src="<?php // echo get_template_directory_uri(); ?>/images/ffd1.png" class="img-responsive2"></a></div>
                            <div class="feature-title">
                                <h6><a href="#">Rodia12</a></h6>
                                <span>150 items</span>
                            </div>
                            <div class="ffd-click"><a href="#"><i class="fa fa-angle-right"></i></a></div>
                        </div>
                    </div>
                    <h2>Latest Blog Post</h2>
                </div>-->
            </div>
        </div>

<?php get_footer(); ?>