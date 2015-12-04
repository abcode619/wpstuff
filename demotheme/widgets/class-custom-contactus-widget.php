<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) )
    exit;

add_action( 'widgets_init', 'contactus_widget' );

/**
 * Register the Contact Us Widget
 */
function contactus_widget(){

    register_widget( 'Contactus' );
}

class Contactus extends WP_Widget{

    /**
     * Register widget with WordPress.
     */
    function __construct(){
        parent::__construct(
                'contactus', // Base ID
                __( 'DemoTheme - Contact Us', 'demotheme' ), // Name
                    array('description' => __( 'Contact Us Widget', 'demotheme' )) // Args
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
            echo $before_title . $title . $after_title;
        }
    ?>
        <ul>
    <?php
            if( !empty( $instance['address'] ) ){
                ?>
                    <li><i class="fa fa-map-marker"></i><p><?php echo $instance['address']; ?></p></li>
                <?php
            }
            if( !empty( $instance['phone'] ) ){
                ?>
                    <li><i class="fa fa-phone"></i><p><?php echo $instance['phone']; ?></p></li>
                <?php
            }
            if( !empty( $instance['email'] ) ){
                ?>
                    <li><a href="mailto:<?php echo $instance['email']; ?>"><i class="fa fa-envelope"></i><p><?php echo $instance['email']; ?></p></a></li>
                <?php
            }
            if( !empty( $instance['website'] ) ){
                $website = str_replace("http://","",$instance['website']);
                $website = str_replace("https://","",$website);
                ?>
                    <li><a href="<?php echo $instance['website']; ?>"><i class="fa fa-globe"></i><p><?php echo $website; ?></p></a></li>
                <?php
            }
    ?>
        </ul>
    <?php
        echo $after_widget;
    }

    /**
     * Update widget values
     * @param type $new_instance
     * @param type $old_instance
     * @return type
     */
    public function update($new_instance, $old_instance){
        $instance            = array();
        $instance['title']   = !empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';        
        $instance['address'] = !empty( $new_instance['address'] ) ? $new_instance['address'] : '';
        $instance['phone']   = !empty( $new_instance['phone'] ) ? $new_instance['phone'] : '';
        $instance['email']   = !empty( $new_instance['email'] ) ? $new_instance['email'] : '';
        $instance['website'] = !empty( $new_instance['website'] ) ? $new_instance['website'] : '';

        return $instance;
    }

    /*
     * Displays the widget form in the admin panel
     */

    function form($instance){
        $title       = !empty( $instance['title'] ) ? $instance['title'] : '';        
        $address     = !empty( $instance['address'] ) ? $instance['address'] : '';
        $phone       = !empty( $instance['phone'] ) ? $instance['phone'] : '';
        $email       = !empty( $instance['email'] ) ? $instance['email'] : '';
        $website     = !empty( $instance['website'] ) ? $instance['website'] : '';        
        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'demotheme' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
        </p>        
        <p>
            <label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address:', 'demotheme' ); ?></label> 
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" ><?php echo $address; ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone:', 'demotheme' ); ?></label> 
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo $phone; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email:', 'demotheme' ); ?></label> 
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $email; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'website' ); ?>"><?php _e( 'Website:', 'demotheme' ); ?></label> 
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'website' ); ?>" name="<?php echo $this->get_field_name( 'website' ); ?>" value="<?php echo $website; ?>">
        </p>
        <?php
    }

}
?>