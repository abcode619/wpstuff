<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'widgets_init', 'esb_search_widget' );

/**
 * Register the Search Widget
 */
function esb_search_widget() {
    register_widget( 'ESB_Search' );
}

class ESB_Search extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function ESB_Search() {
	
            /* Widget settings. */
            $widget_ops = array( 'classname' => 'esb-search', 'description' => __( 'A search form for your site.', 'esparkbiz' ) );

            /* Create the widget. */
            $this->WP_Widget( 'esb-search', __( 'ESB - Search', 'esparkbiz' ), $widget_ops );

	}
	
        /**
	 * Outputs the content of the widget
	 */
	function widget( $args, $instance ) {
            
            /** This filter is documented in wp-includes/default-widgets.php */
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

            if ( $title ) {
                    echo $args['before_title'] . $title . $args['after_title'];
            }
            ?>
                <div class="sidebar_cont search_cont">
                    <form action="<?php echo site_url() ?>" class="search-form" method="get" role="search">
                        <input type="text" name="s" value="" placeholder="<?php _e('Enter keywords...', 'esparkbiz'); ?>" class="search-field">
                        <input type="submit" value="<?php _e('Search', 'esparkbiz'); ?>" class="search-submit">
                    </form>
                </div>
            <?php
        }
	
        /**
	 * Updates the widget control options for the particular instance of the widget
	 */
	function update( $new_instance, $old_instance ) {
            
            $instance = $old_instance;
            $new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
            $instance['title'] = strip_tags($new_instance['title']);
            return $instance;
        }
	
	/*
	 * Displays the widget form in the admin panel
	 */
	function form( $instance ) {
            $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
            $title = $instance['title'];
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'esparkbiz'); ?>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        <?php
	}
}