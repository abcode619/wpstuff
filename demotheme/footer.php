<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Demo_Theme
 * @since Demo Theme 1.0
 */
?>
<?php
    $demotheme_options   = get_option( 'demotheme_options' );
    $cpy_text   = isset( $demotheme_options['cpy_text'] ) ? $demotheme_options['cpy_text'] : '';
?>
		</div><!-- #main -->

		<footer id="colophon" class="site-footer" role="contentinfo">

			<?php get_sidebar( 'footer' ); ?>

			<div class="site-info">
                            <?php echo $cpy_text; ?>
                        </div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
    </body>
</html>