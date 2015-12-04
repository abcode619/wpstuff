<?php

// Creating the widget 
class farmtoyou_featured_farm_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
// Base ID of your widget
                'farmtoyou_featured_farm_widget',
// Widget name will appear in UI
                __('FarmToYou - Featured Farm Widget', 'farmtoyou'),
// Widget description
                array('description' => __('Widget that shows the latest featured farm', 'farmtoyou'),)
        );
    }

// Creating widget front-end
// This is where the action happens
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        $sellers = dokan_get_sellers( 1 );
        
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
            <?php } ?>

        <?php
        echo $args['after_widget'];
        }

// Widget Backend 
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'farmtoyou');
        }
// Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <?php
    }

// Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

}

// Class wpb_widget ends here
// Register and load the widget
function farmtoyou_load_widget() {
    register_widget('farmtoyou_featured_farm_widget');
}

add_action('widgets_init', 'farmtoyou_load_widget');
?>