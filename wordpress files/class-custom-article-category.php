<?php

// Creating the widget 
class spe_category_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
// Base ID of your widget
                'spe_category_widget',
// Widget name will appear in UI
                __('Spe - Categories Widget', 'expat'),
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
        ?>

        <div class="article-category">
            <?php
            $catArgs = array(
                'taxonomy' => SPE_ARTICLES_POST_TAX
                    // post_type isn't a valid argument, no matter how you use it.
            );
            $categories = get_categories('taxonomy=' . SPE_ARTICLES_POST_TAX . '&post_type=' . SPE_ARTICLES_POST_TYPE);
            ?>
            <?php foreach ($categories as $category) : ?>
                <div class="category-slide">
                    <div class="title-div">
                        <a href="javascript:void(0)" class="category-title"><span><?php echo $category->name; ?></span></a>
                    </div>
                  
                    <?php
                
                    $postArgs = array(
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'post_type' => SPE_ARTICLES_POST_TYPE,
                        SPE_ARTICLES_POST_TAX => $category->slug,
                    );
                   $categories_post =  query_posts($postArgs);
                  
                    ?>
                    <div class="category-list">
                        <ul>
                            <?php while (have_posts()): the_post(); ?>
                            <li><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title() ?></a></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>    
            <?php endforeach; ?>
            <?php wp_reset_query(); ?>
            
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
        register_widget('spe_category_widget');
    }

    add_action('widgets_init', 'wpc_load_widget');
    ?>