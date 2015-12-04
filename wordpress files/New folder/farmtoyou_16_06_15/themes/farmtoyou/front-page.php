<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

get_header();
?>

<?php 
    $sellers = dokan_get_sellers( 8 );    
?>
    <div class="featured-farm-section">
        <div class="container">
            <h2><span><?php _e('Featured farms', 'farmtoyou'); ?></span></h2>
            <?php
                foreach ($sellers['users'] as $seller) {

                    $args = array(
                                    'post_type'      => 'product',
                                    'post_status'    => 'publish',
                                    'posts_per_page' => -1,
                                    'author'         => $seller->ID,
                                    'fields'         => 'ids',
                                );

                    $product_ids = get_posts( $args );
                    $seller_products = !empty( $product_ids ) ? count($product_ids) : 0;

                    $store_info = dokan_get_store_info( $seller->ID );
                    $banner_id  = isset( $store_info['banner'] ) ? $store_info['banner'] : 0;
                    $store_name = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', 'dokan' );
                    $store_url  = dokan_get_store_url( $seller->ID );
                    $seller_icon = get_user_meta( $seller->ID, 'dokan_seller_icon', true );
            ?>
                    <div class="col-md-3 feature-box">
                        <div class="ff-box">
                            <?php 
                                if ( $banner_id ) {
                                $banner_url = wp_get_attachment_image_src( $banner_id, 'full' );
                            ?>
                                <a href="<?php echo $store_url; ?>">
                                    <img src="<?php echo $banner_url[0]; ?>" class="img-responsive2">
                                </a>
                            <?php } ?>
                            <div class="ff-detail">
                                <?php if( !empty( $seller_icon ) ) { ?>
                                    <div class="ffd-image">
                                        <a href="<?php echo $store_url; ?>">
                                            <img src="<?php echo $seller_icon; ?>" class="img-responsive2">
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="feature-title">
                                    <?php if( !empty( $store_name ) ) { ?>
                                        <h6><a href="<?php echo $store_url; ?>"><?php echo $store_name; ?></a></h6>
                                    <?php } ?>    
                                    <span><?php echo sprintf( _n( '%s item', '%s items', $seller_products, 'farmtoyou' ), $seller_products ); ?></span>
                                </div>
                                <div class="ffd-click"><a href="<?php echo $store_url; ?>"><i class="fa fa-angle-right"></i></a></div>
                            </div>
                        </div>
                    </div>
            <?php } ?>

            <div class="viewmore-box"><a class="view-more-farms" href="<?php echo get_permalink( FARMTOYOU_STORE_LIST_PAGE_ID ); ?>"><?php _e('View More Farms', 'farmtoyou'); ?></a></div>
        </div>
    </div>
    <!--Featured Farm Section-->

<?php
    $product_categories = get_terms( 'product_cat', 'number=8&hide_empty=0' );
?>

<div class="shopping-section">
    <div class="container">
        <h2><span><?php _e('Shopping Categories', 'farmtoyou'); ?></span></h2>
        <div class="shopping-box-container">
            
            <?php
                foreach ($product_categories as $product_category) {
                    
                    $thumbnail_id = get_woocommerce_term_meta( $product_category->term_id, 'thumbnail_id', true );
                    $image = wp_get_attachment_url( $thumbnail_id );
                    
                    $metafieldArray = get_option('taxonomy_'. $product_category->term_id);
                    $metafieldoutput = $metafieldArray['custom_term_meta'];
            ?>
                <div class="col-md-3 shopping-box">
                    <div class="shopping-box-content">
                        <a href="<?php echo get_term_link($product_category->slug, 'product_cat'); ?>">
                            <img src="<?php echo $image; ?>" class="img-responsive2" >
                        </a>
                        
                        <div class="shopping-icon">
                            <a href="<?php echo get_term_link($product_category->slug, 'product_cat'); ?>">
                                <img src="<?php echo $metafieldoutput; ?>" class="img-responsive2">
                            </a>
                        </div>
                        
                        <div class="shopping-detail">
                            <h6>
                                <a href="<?php echo get_term_link($product_category->slug, 'product_cat'); ?>">
                                    <?php echo $product_category->name; ?>
                                </a>
                            </h6>
                            <span><?php echo sprintf( _n( '%s item', '%s items', $product_category->count, 'farmtoyou' ), $product_category->count ); ?></span>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
            
            <div class="viewmorecat-box">
                <a class="view-more-categories" href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>"><?php _e('View More Categories', 'farmtoyou'); ?></a>
            </div>

        </div>

    </div>
</div>
<!--Shopping Section-->

<?php
    $best_product_args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 3,
                    'meta_key'       => 'total_sales',
                    'orderby'        => 'meta_value_num',
                );
    
    $best_products = new WP_Query( $best_product_args );
    
?>
<div class="blog-section">
    <div class="container">
        <?php if ( $best_products->have_posts() ) { ?>
        <div class="col-md-5 blog-left">
            <h2><?php _e('This Weeks Best Sellers', 'farmtoyou'); ?></h2>
            <?php
                while ( $best_products->have_posts() ) : $best_products->the_post();
                    $product_feat_image = get_the_post_thumbnail( $post->ID, 'shop_catalog' );
                    
                    $terms = get_the_terms( $post->ID, 'product_cat' );
                    
                    $regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
                    $sale_price = get_post_meta( get_the_ID(), '_sale_price', true);
                    
                    $author_id = get_the_author_meta( 'ID' );
                    $author_url  = dokan_get_store_url( $author_id );
            ?>
                <div class="blog-box">
                    <div class="col-md-5 blog-image">
                        <?php echo $product_feat_image; ?>
                    </div>
                    <div class="col-md-7 blog-content">
                        <h6><?php the_title(); ?></h6>
                        <ul>
                            <li><a href="<?php echo $author_url; ?>"><?php the_author(); ?></a></li>
                            <?php foreach( $terms as $term ) { ?>
                                <li><a href="<?php echo get_term_link($term->slug, 'product_cat'); ?>"><?php echo $term->name; ?></a></li>
                            <?php } ?>    
                        </ul>
                        <div class="rate">
                            <?php if( !empty( $regular_price ) ) { ?>
                            <s><?php echo $regular_price; ?></s>
                            <?php } ?>
                            <?php echo $sale_price; ?>
                        </div>
                        <a href="<?php echo add_query_arg( 'add-to-cart', get_the_ID(), $term->slug ); ?>" class="addto-cart green-bg">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/add-cart.png"> Add to cart
                        </a>
                    </div>
                </div>
            <?php
                endwhile;
                //reset the query
                wp_reset_query();
            ?>
        </div>
        <?php } ?>
        
        <?php
            $post_args = array(
                                    'post_type'     => FARMTOYOU_POST_POST_TYPE,
                                    'post_status'   => 'publish', 
                                    'posts_per_page'=> 3,
                                    'order'         => 'DESC',
                                    'orderby'       => 'menu_order'
                                );

            $post_query = new WP_Query( $post_args );
            if ( $post_query->have_posts() ) {
        ?>
        
        <div class="col-md-7 blog-right">
            <h2><?php _e('Latest from the Farm to You Blog', 'farmtoyou'); ?></h2>
            <?php
                while ( $post_query->have_posts() ) : $post_query->the_post();
                    $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID),'full' );
                    
                    $content = get_the_content();
            ?>
            <div class="blog-article">
                <div class="col-md-3 blogarticle-image">
                    <img src="<?php echo $feat_image; ?>" class="img-responsive2" >
                </div>
                <div class="col-md-9 blogarticle-content">
                    <h6><?php the_title(); ?></h6>
                    <p><?php echo farmtoyou_excerpt_char( $content, 200 ); ?><a href="<?php echo get_permalink(); ?>"> <?php _e('Read more...', 'farmtoyou'); ?></a></p>
                </div>
            </div>
            <?php
                endwhile;
                //reset the query
                wp_reset_query();
            ?>
        </div>
        <?php } ?>
        
    </div>
</div>

<?php get_footer(); ?>