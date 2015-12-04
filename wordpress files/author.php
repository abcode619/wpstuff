<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

			<header class="archive-header">
				<h1 class="archive-title">
					<?php
						/*
						 * Queue the first post, that way we know what author
						 * we're dealing with (if that is the case).
						 *
						 * We reset this later so we can run the loop properly
						 * with a call to rewind_posts().
						 */
						the_post();
                                                echo get_avatar( get_the_author_meta( 'ID' ) );
						printf( __( '%s', 'hsboard' ), get_the_author() );
					?>
				</h1>
				<?php if ( get_the_author_meta( 'description' ) ) : ?>
                               
				<div class="author-description"><?php _e( '<h2>About Me</h2>','hsboard' ).the_author_meta( 'description' ); ?></div>
				<?php endif; ?>
			</header><!-- .archive-header -->

			<?php
					/*
					 * Since we called the_post() above, we need to rewind
					 * the loop back to the beginning that way we can run
					 * the loop properly, in full.
					 */
					rewind_posts();
                                        $prefix = HSBOARD_META_PREFIX;
					// Start the Loop.
					while ( have_posts() ) : the_post();
                                                $post_id = $post->ID;

                                                $story_tag_line  = get_post_meta( $post_id, $prefix . 'story_tag_line', true );
                                                $story_tag_line  = !empty( $story_tag_line ) ? hsboard_escape_attr( $story_tag_line ) : '';
                                               
                                                $feat_image = wp_get_attachment_url(get_post_thumbnail_id( $post_id ) );
                                        ?>            
                                        <h2><a href="<?php echo get_permalink(); ?>"><?php  the_title() ?></a></h2>
                                                
                                                <h3><?php echo $story_tag_line; ?></h3>
                                                
                                                <?php if( !empty($feat_image) ){?> 
                                                        <img src="<?php echo $feat_image; ?>" alt="" />
                                                <?php }?>
                                               
                                                <?php
                                                the_excerpt();
                                       
					endwhile;
					// Previous/next page navigation.
					hsboard_paging_nav();

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>
                 <!--  #Right Sidebar  -->
                <?php dynamic_sidebar( 'story-page' ); ?>
		</div><!-- #content -->
	</div><!-- #primary -->
 
<?php
    get_footer();
?>