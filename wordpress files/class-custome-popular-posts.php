<?php

// POPULAR POST WIDGET
class show_popular extends WP_Widget
{

    function show_popular()
    {
        $widget_ops = array('classname' => 'show_popular', 'description' => __('Show your popular posts.'));
        $this->WP_Widget('show_popular', __('EXPAT - Popular Posts'), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);

//$options = get_option('custom_recent');
        $title = $instance['title'];
        $postscount = $instance['posts'];

//GET the posts
        global $postcount;

        $myposts = get_posts(array('orderby' => 'comment_count', 'numberposts' => $postscount));



//SHOW the posts
        ?>
        <div class = "sidebar-box">
            <div class="sidebar-box">
                <h4><?php echo $before_widget . $before_title . $title . $after_title; ?></h4>
                <div class="sidebar-b">               
                    <?php
                    foreach ($myposts as $post)
                    {
                        setup_postdata($post);

                        $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                        ?>
                        <div class="sidebar-poppost">
                            <div class="sidebar-poppostimg"><img src="<?php echo $feat_image; ?>" alt="" class="img-responsive2"></div>
                            <div class="sidebar-popposttitle">
                                <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                                <span>By <?php the_author(); ?> on <?php the_time('F j, Y') ?></span>
                            </div>
                        </div>

            <?php
        }
        echo $after_widget;
        ?>



                </div>
            </div>
        </div>
        <?php
    }

    function update($newInstance, $oldInstance)
    {
        $instance = $oldInstance;
        $instance['title'] = strip_tags($newInstance['title']);
        $instance['posts'] = $newInstance['posts'];

        return $instance;
    }

    function form($instance)
    {
        echo '<p style="text-align:right;"><label  for="' . $this->get_field_id('title') . '">' . __('Title:') . '  <input style="width: 200px;" id="' . $this->get_field_id('title') . '"  name="' . $this->get_field_name('title') . '" type="text"  value="' . $instance['title'] . '" /></label></p>';

        echo '<p style="text-align:right;"><label  for="' . $this->get_field_id('posts') . '">' . __('Number of Posts:', 'widgets') . ' <input style="width: 50px;"  id="' . $this->get_field_id('posts') . '"  name="' . $this->get_field_name('posts') . '" type="text"  value="' . $instance['posts'] . '" /></label></p>';

        echo '<input type="hidden" id="custom_recent" name="custom_recent" value="1" />';
    }

}

add_action('widgets_init', create_function('', 'return register_widget("show_popular");'));
?>