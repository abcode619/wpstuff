<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * The template for displaying featured content
 *
 * @package WordPress
 * @subpackage Demo_Theme
 * @since Demo Theme 1.0
 */
?>

<div id="featured-content" class="featured-content">
	<div class="featured-content-inner">
	<?php
		/**
		 * Fires before the Demo Theme featured content.
		 *
		 * @since Demo Theme 1.0
		 */
		do_action( 'demotheme_featured_posts_before' );

		$featured_posts = demotheme_get_featured_posts();
		foreach ( (array) $featured_posts as $order => $post ) :
			setup_postdata( $post );

			 // Include the featured content template.
			get_template_part( 'content', 'featured-post' );
		endforeach;

		/**
		 * Fires after the Demo Theme featured content.
		 *
		 * @since Demo Theme 1.0
		 */
		do_action( 'demotheme_featured_posts_after' );

		wp_reset_postdata();
	?>
	</div><!-- .featured-content-inner -->
</div><!-- #featured-content .featured-content -->
