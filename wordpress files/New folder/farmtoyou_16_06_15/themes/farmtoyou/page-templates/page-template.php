<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Template Name: Page Template
 *
 * @package WordPress
 * @subpackage Farmtoyou
 * @since Farmtoyou 1.0
 */

get_header(); ?>

        <div class="main-work-section">
            <div class="container">
                
                <div class="col-md-9 work-left">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <h2><?php the_title(); ?></h2>
                        <?php the_content(); ?>
                    <?php endwhile; ?>    
                </div>
                
                <div class="col-md-3 work-right">
                    <?php dynamic_sidebar('sidebar-7'); ?>
                </div>
            </div>
        </div>

        <!--Hero Section end-->

<?php get_footer(); ?>