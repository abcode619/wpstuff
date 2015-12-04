<?php

// Creating the widget 
class expat_category_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
// Base ID of your widget
                'expat_category_widget',
// Widget name will appear in UI
                __('Expat - Resources Widget', 'expat'),
// Widget description
                array('description' => __('Widget that shows the link of category media', 'expat'),)
        );
    }

// Creating widget front-end
// This is where the action happens
    public function widget($args, $innce)
    {
        $title = apply_filters('widget_title', $innce['title']);
// before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
        {
            echo $args['before_title'] . $title . $args['after_title'];
        }


        $args = array(
            'type' => 'post',
            'child_of' => 0,
            'parent' => '',
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => 1,
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'number' => '',
            'taxonomy' => 'category',
            'pad_counts' => false
        );
        ?>
        <div id="main-content" class="main-content">


            <div id="primary" class="content-area">
                <div id="content" class="site-content" role="main">
                    <?php
                    $categories = get_categories($args);
                    if ($categories)
                    {

                        foreach ($categories as $category)
                        {
                            $category_id = $category->term_id;
                            $img_url = z_taxonomy_image_url($category_id);
                            if (!empty($img_url))
                            {
                                echo '<img src="' . $img_url . '" />';
                            }
                            if (!empty($category_id))
                            {
                                echo '<p>Category: <a href="' . get_category_link($category->term_id) . '" title="' . sprintf(__("View all posts in %s"), $category->name) . '" ' . '>' . $category->name . '</a> </p> ';
                            }
                        }
                    }
                    ?>

                </div><!-- #content -->
            </div><!-- #primary -->
        </div>
        <?php
        echo $args['after_widget'];
    }

// Widget Backend 
    public function form($innce)
    {
        if (isset($innce['title']))
        {
            $title = $innce['title'];
        } else
        {
            $title = __('New title', 'expat');
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <?php
    }

// Updating widget replacing old innces with new
    public function update($new_innce, $old_innce)
    {
        $innce = array();
        $innce['title'] = (!empty($new_innce['title']) ) ? strip_tags($new_innce['title']) : '';
        return $innce;
    }

}

// Class wpb_widget ends here
// Register and load the widget
function wpc_load_widget()
{
    register_widget('expat_category_widget');
}

add_action('widgets_init', 'wpc_load_widget');
?>