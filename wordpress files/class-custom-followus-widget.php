<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) )
    exit;

add_action( 'widgets_init', 'followus_widget' );

/**
 * Register the Follow Us Widget
 */
function followus_widget(){

    register_widget( 'Followus' );
}

class Followus extends WP_Widget{

    /**
     * Register widget with WordPress.
     */
    function __construct(){
        parent::__construct(
                'followus', // Base ID
                __( 'Hds - Follow Us', 'text_domain' ), // Name
                    array('description' => __( 'Follow Us Widget', 'text_domain' )) // Args
        );
    }

    /**
     * Front end display
     * @param type $args
     * @param type $instance
     */
    public function widget($args, $instance){

        extract( $args );

        echo $before_widget;

        $title = apply_filters( 'widget_title', $instance['title'] );

        if( !empty( $title ) ){
    ?>
            <div class="followus">
                <h4><?php echo $title; ?></h4>
                <ul>
                    <!--AddThis Button BEGIN -->
                    <li><a href="javascript:void(o);" class="f-facebook addthis_button_facebook" addthis:url = "<?php echo get_permalink(); ?>"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="javascript:void(o);" class="f-twitter addthis_button_twitter" addthis:url = "<?php echo get_permalink(); ?>"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="javascript:void(o);" class="f-google addthis_button_google_plusone_share" addthis:url = "<?php echo get_permalink(); ?>" ><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="javascript:void(o);" class="f-vimeo addthis_button_vimeo_share" addthis:url = "<?php echo get_permalink(); ?>" ><i class="fa fa-vimeo-square"></i></a></li>
                    <li><a href="javascript:void(o);" class="f-pinterest addthis_button_pinterest_share" addthis:url = "<?php echo get_permalink(); ?>" ><i class="fa fa-pinterest"></i></a></li>

                    <script type = "text/javascript" src = "http://s7.addthis.com/js/250/addthis_widget.js"></script> 
                    <!-- AddThis Button END -->
                </ul>                
            </div>
    <?php
        }
        echo $after_widget;
    }

    /**
     * Update widget values
     * @param type $new_instance
     * @param type $old_instance
     * @return type
     */
    public function update($new_instance, $old_instance){
        $instance                       = array();
        $instance['title']              = !empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
        
        return $instance;
    }

    /*
     * Displays the widget form in the admin panel
     */

    function form($instance){
        $title              = !empty( $instance['title'] ) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'hds' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
        </p>
                
        <?php
    }

}
?>