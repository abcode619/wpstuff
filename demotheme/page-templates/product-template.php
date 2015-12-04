<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Template Name: Product Template
 *
 * @package WordPress
 * @subpackage demotheme
 * @since demotheme 1.0
 */

get_header(); ?>

<?php
    $prefix = DEMOTHEME_META_PREFIX;
    
    $product_args = array(
                            'post_type'     => DEMOTHEME_PRODUCT_POST_TYPE,
                            'post_status'   => 'publish', 
                            'posts_per_page'=> -1,
                            'order'         => 'ASC',
                            'orderby'       => 'menu_order'
                        );
    
    $product_query = new WP_Query( $product_args );
    if ( $product_query->have_posts() ) {
?>

    <div id="main-content" class="main-content">
        <div id="primary" class="content-area">
            <div id="content" class="site-content" role="main">
                <?php 
                    while ( $product_query->have_posts() ) : $product_query->the_post();
                    $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID),'full' );
                    
                    $post_id = $post->ID;
                    $product_video_url   = get_post_meta( $post_id, $prefix . 'product_video_url', true );
                ?>
                    <img src="<?php echo $feat_image; ?>" alt="">
                    <h1><?php the_title(); ?></h1>
                <?php
                    the_content();
                    
                    if ( strpos($product_video_url,'youtube' ) !== false ) {

                        $video_embed_url = str_replace('watch?v=', 'embed/', $product_video_url);

                        $video_id = str_replace('http://www.youtube.com/embed/', '', $video_embed_url);
                        $video_id = str_replace('https://www.youtube.com/embed/', '', $video_id);

                        $image_url = 'http://i1.ytimg.com/vi/'. $video_id .'/mqdefault.jpg';

                        $videophoto_code = '<iframe width="100%" height="450px" src="'.$video_embed_url.'" frameborder="0" allowfullscreen></iframe>';

                    } else if( strpos($product_video_url,'vimeo' ) !== false ) {

                        $video_embed_url = str_replace('vimeo.com/', 'player.vimeo.com/video/', $product_video_url);

                        $video_id = str_replace('http://vimeo.com/', '', $product_video_url);
                        $video_id = str_replace('https://vimeo.com/', '', $video_id);
                        $video_embed_url = str_replace('vimeo.com/', 'player.vimeo.com/video/', $product_video_url);

                        $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));

                        if( !empty( $hash[0] ) && !empty( $hash[0]['thumbnail_large'] ) ) {
                            $image_url = $hash[0]['thumbnail_large'];
                        }
                        $videophoto_code = '<iframe width="100%" height="450px" src="'.$video_embed_url.'" frameborder="0" allowfullscreen></iframe>';

                    }
                    
                    echo $videophoto_code;
                    
                    endwhile;
                    //reset the query
                    wp_reset_query();
                ?>
            </div><!-- #content -->
        </div><!-- #primary -->
    </div><!-- #main-content -->
    <?php } ?>

<?php
    get_sidebar();
    get_footer();
?>