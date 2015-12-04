<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Farmtoyou
 * @since Farmtoyou 1.0
 */

get_header(); ?>


	<div class="featured-farm-section">
                <div class="container">

			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Not Found', 'farmtoyou' ); ?></h1>
			</header>

			<div class="page-content">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'farmtoyou' ); ?></p>

				<?php get_search_form(); ?>
			</div><!-- .page-content -->

		</div>
	</div>

<?php get_footer(); ?>