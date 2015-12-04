<?php

// POPULAR POST WIDGET
class show_related extends WP_Widget
{

    function show_related()
    {
        $widget_ops = array('classname' => 'show_related', 'description' => __('Show your related posts.'));
        $this->WP_Widget('show_related', __('EXPAT - Related Posts'), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);

//$options = get_option('custom_related');
        $title = $instance['title'];
        $postscount = $instance['posts'];


//GET the posts
        global $postcount, $post;



//SHOW the posts
        ?>


        <?php
        $tags = wp_get_post_tags($post->ID);

        if ($tags)
        {
            $tag_ids = array();
            foreach ($tags as $individual_tag)
                $tag_ids[] = $individual_tag->term_id;

            $args = array(
                'tag__in' => $tag_ids,
                'post__not_in' => array($post->ID),
                'showposts' => $postscount // Number of related posts that will be shown.
            );
            $my_query = new wp_query($args);
            ?>



            <div class="relatedpost-main">
                <div class="relatedpost-boxes">
                    <?php
                    if ($my_query->have_posts())
                    {
                        echo ' <h4 class="title-style">' . $before_widget . $before_title . $title . $after_title . '</h4>';

                        $count = 0;
                        while ($my_query->have_posts())
                        {
                            $count++;

                            $class = ($count % 2 == 0) ? 'padir0' : 'padil0';
                            $my_query->the_post();
                            $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full');
                            ?>

                            <div class="col-md-6 <?php echo $class; ?> relatedpost-box">
                                <div class="relatedpost-bimg">
                                    <?php
                                    if (!empty($feat_image)):
                                        ?>
                                        <img src = "<?php echo $feat_image; ?>" />

                                        <?php
                                    endif;
                                    ?>
                                </div>
                                <div class="relatedpost-btext">
                                    <p><a href="<?php the_permalink() ?>" class="text-uppercase"><?php the_title(); ?></a></p>
                                        <?php
                                        $content = get_the_content();
                                        echo expat_excerpt_char($content, 159);
                                        ?>
                                </div>
                            </div>

                                                                                                            <!--<li><a href="" rel="bookmark" title="Permanent Link to <?php //the_title_attribute();     ?>"></a></li>-->
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>       

            <?php
        }
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

        echo '<input type="hidden" id="custom_related" name="custom_related" value="1" />';
    }

}

add_action('widgets_init', create_function('', 'return register_widget("show_related");'));
?>