<?php

// Creating the widget 
class farmtoyou_social_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
// Base ID of your widget
                'farmtoyou_social_widget',
// Widget name will appear in UI
                __('FarmToYou - Social Widget', 'farmtoyou'),
// Widget description
                array('description' => __('Widget that shows the link of social media', 'farmtoyou'),)
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
        
        $farmtoyou_options = get_option('farmtoyou_options');
        $fb_url = isset($farmtoyou_options['fb_url']) ? $farmtoyou_options['fb_url'] : '';
        $tw_url = isset($farmtoyou_options['tw_url']) ? $farmtoyou_options['tw_url'] : '';
        $pt_url = isset($farmtoyou_options['pt_url']) ? $farmtoyou_options['pt_url'] : '';
        $insta_url = isset($farmtoyou_options['insta_url']) ? $farmtoyou_options['insta_url'] : '';
        ?>
            <?php if (!empty($fb_url) || !empty($tw_url) || !empty($pt_url) || !empty($insta_url)) { ?>
                <ul>
                    <?php if (!empty($fb_url)) { ?>
                        <li><a href="<?php echo $fb_url; ?>"><i class="fa fa-facebook"></i></a></li>
                    <?php } ?>   
                    <?php if (!empty($tw_url)) { ?>
                        <li><a href="<?php echo $tw_url; ?>"><i class="fa fa-twitter"></i></a></li>
                    <?php } ?>   
                    <?php if (!empty($pt_url)) { ?>    
                        <li><a href="<?php echo $pt_url; ?>"><i class="fa fa-pinterest"></i></a></li>
                    <?php } ?>   
                    <?php if (!empty($insta_url)) { ?>    
                        <li><a href="<?php echo $insta_url; ?>"><i class="fa fa-instagram"></i></a></li>
                    <?php } ?>    
                </ul>
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
function wpb_load_widget() {
    register_widget('farmtoyou_social_widget');
}

add_action('widgets_init', 'wpb_load_widget');
?>