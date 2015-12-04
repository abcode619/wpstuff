<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Securead
 * @since Securead 1.0
 */

get_header(); 

// Start the Loop.
while ( have_posts() ) : the_post();
    the_content();

    // Previous/next post navigation.
    secureadv_post_nav();

endwhile;

get_footer();
?>