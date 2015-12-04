<?php

/**
 * Register [hds_blogpost] shortcode
 */
function hds_blogpost($atts){
    global $post;

    extract( shortcode_atts( array(
        'columns' => '2'
                    ), $atts ) );

    ob_start();

    $blogpostargs = array(
        'post_type'      => HDS_POST_POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => '3',
        'orderby'        => 'post_date',
        'order'          => 'DESC'
    );

    //fire query in to table for retriving data
    $blogpost_query = new WP_Query( $blogpostargs );
    if( $blogpost_query->have_posts() ){
        while( $blogpost_query->have_posts() )
        {
            $blogpost_query->the_post();

            $attachment_id  = get_post_thumbnail_id( $post->ID );            
            $img_url = wp_get_attachment_image_src( $attachment_id, 'post-thumbnails' );            

            if( $img_url == '' ){
                $img_url[0] = get_template_directory_uri().'/images/default-portfolio.jpg';
                $full_img[0] = '#';
            }
            else{
                $full_img =  wp_get_attachment_image_src( $attachment_id, 'full' );
            }            
            $comments_count = get_comments_number();
            $title          = get_the_title();
            $excerpt        = get_the_excerpt();
            $author_name    = get_the_author();
            $author_name    = !empty( $author_name ) ? ' By ' . $author_name : '';
            $blogpost_date  = get_the_date();
            $blogpost_day   = date( 'd', strtotime( $blogpost_date ) );
            $blogpost_month = date( 'M', strtotime( $blogpost_date ) );          
            
            ?>
                <div class="col-md-4 blog-box">
                    <div class="blog-img">
                        <img src="<?php echo $img_url[0]; ?>" class="img-responsive2">
                        <div class="date-message">
                            <ul>
                                <li><h5><?php echo $blogpost_day; ?></h5><?php echo $blogpost_month; ?></li>
                                <?php /* ?>
                                <li><i class="fa fa-comments"></i><?php // printf( '%02d', $comments_count ) ?></li>-->
                                <?php */ ?>
                            </ul>
                        </div>
                        <div class="bloghover-link">
                            <ul>
                                <li><a href="<?php echo get_permalink(); ?>"><i class="fa fa-link"></i></a></li>
                                <?php 
                                    if( $full_img[0] != '#' ){
                                ?>
                                       <li><a href="<?php echo $full_img[0]; ?>" class="fancybox"><i class="fa fa-search"></i></a></li> 
                                <?php
                                    }
                                ?>                                
                            </ul>
                        </div>
                    </div>
                    <div class="blog-content">
                        <h5><?php echo $title; ?></h5>
                        <span><?php echo $author_name; ?></span>
                        <p> <?php echo hds_excerpt_char( $excerpt, 100 ); ?> </p>
                        <a href="<?php echo get_permalink(); ?>">Read More >></a>
                    </div>
                </div>
            <?php
        }
        wp_reset_query();
    }
    $html = ob_get_clean();

    return $html;
}

/**
 * Register [hds_testimonial] shortcode
 */
function hds_testimonial($atts){
    global $post;
    $prefix = HDS_META_PREFIX;

    extract( shortcode_atts( array(
        'per_page' => '2'
                    ), $atts ) );

    ob_start();

    $testimonialargs   = array(
        'post_type'      => HDS_TESTIMONIAL_POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );
    $testimonial_query = new WP_Query( $testimonialargs );

    if( $testimonial_query->have_posts() ){
        if( is_front_page() ){
            while( $testimonial_query->have_posts() ) : $testimonial_query->the_post(); 
            $excerpt        = get_the_excerpt();
                ?>
                <div class="testi2">
                    <div class="testi-box">
                        <div class="testi-message">
                            <div class="testi-less2">
                            <?php echo hds_excerpt_char( $excerpt, 100 ); ?>
                            </div>
                            <div class="testi-more2">
                                <?php the_content(); ?>
                            </div>
                            <a class="readmore_link2 extratext">
                                <span class="more_span2"><?php _e( 'Read More', 'hds' ); ?></span> 
                                <span class="less_span2"><?php _e( 'Read Less', 'hds' ); ?></span>
                            </a>
                        </div>   
                        <div class="client-info"><?php the_post_thumbnail( array( 61, 61) ); ?><h6><?php the_title(); ?></h6></div>
                    </div>
                </div>
                <?php
            endwhile;
            //reset the query
            wp_reset_query();
        }
        else{
            while( $testimonial_query->have_posts() ) : $testimonial_query->the_post(); 
                $post_id = $post->ID;

                $testi_email = get_post_meta( $post_id, $prefix . 'testi_email', true );
                $testi_email = !empty( $testi_email ) ? $testi_email : '';
                $excerpt        = get_the_excerpt();
        ?>
                <div class="col-md-6 testi">
                    <div class="testi-box">
                        <div class="testi-message">
                            <div class="testi-less">
                            <?php echo hds_excerpt_char( $excerpt, 100 ); ?>
                            </div>
                            <div class="testi-more">
                                <?php the_content(); ?>
                            </div>
                            <a class="readmore_link extratext">
                                <span class="more_span"><?php _e( 'Read More', 'hds' ); ?></span> 
                                <span class="less_span"><?php _e( 'Read Less', 'hds' ); ?></span>
                            </a>
                        </div>     
                        <div class="client-info">
                            <?php the_post_thumbnail( array( 61, 61) ); ?>
                            <div class="web-detail">
                                <h6><?php the_title(); ?></h6>
                                <?php 
                                    if( !empty( $testi_email ) ){
                                        $website = str_replace("http://","",$testi_email);
                                        $website = str_replace("https://","",$website);
                                ?>
                                       <a href="<?php echo $testi_email; ?>"><?php echo $website; ?></a> 
                                <?php
                                    }
                                ?>                                
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            endwhile;
            //reset the query
            wp_reset_query();
        }
    }
    $html = ob_get_clean();

    return $html;
}

/**
 * Register [hds_featured_product] shortcode
 */
function hds_featured_product($atts){
    global $post;
    
    extract( shortcode_atts( array(
        'cat' => ''
                    ), $atts ) );

    ob_start();
    
    $portfolioargs   = array(
        'post_type'      => HDS_PORTFOLIO_POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC'        
    );
    if(!empty($cat))
    {
        $portfolioargs['tax_query'] = array(
                array(
                    'taxonomy' => HDS_PORTFOLIO_POST_TAX,
                    'field'    => 'slug',
                    'terms'    => $cat
                )
            );
    }
    $feature_product_query = new WP_Query( $portfolioargs );
    
    if( $feature_product_query->have_posts() ){
?>
        <div class="col-md-12 feature-product-title">
            <h1><?php _e( 'Featured Products', 'hds');?></h1>
        </div>
<?php
        while( $feature_product_query->have_posts() ) : $feature_product_query->the_post();
            $attachment_id  = get_post_thumbnail_id( $id );
            $img_url = wp_get_attachment_image_src( $attachment_id, 'large' );
            ?>
                <div class="col-md-4 product-box">
                    <a href='#'>
                        <img src='<?php echo $img_url[0]; ?>' class="img-responsive2" alt='' />
                    </a>
                </div>  
            <?php
        endwhile;;
    }
    $html = ob_get_clean();

    return $html;
}
//add shortcode for display blogpost
add_shortcode( 'hds_blogpost', 'hds_blogpost' );

//add shortcode for display testimonial
add_shortcode( 'hds_testimonial', 'hds_testimonial' );

//add shortcode for display featured product
add_shortcode( 'hds_featured_product', 'hds_featured_product' );
?>