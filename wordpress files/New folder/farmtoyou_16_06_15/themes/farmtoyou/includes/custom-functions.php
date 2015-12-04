<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if( !defined( 'FARMTOYOU_POST_POST_TYPE' ) ) {
    define( 'FARMTOYOU_POST_POST_TYPE', 'post' );
}
if( !defined( 'FARMTOYOU_PAGE_POST_TYPE' ) ) {
    define( 'FARMTOYOU_PAGE_POST_TYPE', 'page' );
}
if( !defined( 'FARMTOYOU_BANNER_POST_TYPE' ) ) {
    define( 'FARMTOYOU_BANNER_POST_TYPE', 'farmtoyou_banner' );
}
if( !defined( 'FARMTOYOU_META_PREFIX' ) ) {
    define( 'FARMTOYOU_META_PREFIX', '_farmtoyou_' );
}
if( !defined( 'FARMTOYOU_ACCOUNT_PAGE_ID' ) ) {
    define( 'FARMTOYOU_ACCOUNT_PAGE_ID', '11' );
}
if( !defined( 'FARMTOYOU_STORE_LIST_PAGE_ID' ) ) {
    define( 'FARMTOYOU_STORE_LIST_PAGE_ID', '6' );
}
if( !defined( 'FARMTOYOU_NEWSLETTER_POST_TYPE' ) ) {
    define( 'FARMTOYOU_NEWSLETTER_POST_TYPE', 'farmtoyou_news' );
}
if( !defined( 'FARMTOYOU_STORE_RESULT_PAGE_ID' ) ) {
    define( 'FARMTOYOU_STORE_RESULT_PAGE_ID', '159' );
}
if( !defined( 'FARMTOYOU_BLOG_PAGE_ID' ) ) {
    define( 'FARMTOYOU_BLOG_PAGE_ID', '163' );
}
if( !defined( 'FARMTOYOU_DASHBOARD_PAGE_ID' ) ) {
    define( 'FARMTOYOU_DASHBOARD_PAGE_ID', '5' );
}
if( !defined( 'FARMTOYOU_SELLER_REVIEW_POST_TYPE' ) ) {
    define( 'FARMTOYOU_SELLER_REVIEW_POST_TYPE', 'farmtoyou_seller_rev' );
}
if( !defined( 'FARMTOYOU_STORE_POLICY_PAGE_ID' ) ) {
    define( 'FARMTOYOU_STORE_POLICY_PAGE_ID', '263' );
}

// Include custom post types & taxonomies
require get_template_directory() . '/includes/custom-posttypes.php';

// Include custom manage columns
require get_template_directory() . '/includes/custom-manage-columns.php';

//include custom scripts file 
include( get_template_directory() . '/includes/custom-scripts.php' );

//Include for newsletter widget
include ( get_template_directory() . '/widgets/class-custom-social-widget.php' );

//Include for newsletter widget
include ( get_template_directory() . '/widgets/class-custom-featured-farm.php' );

//include woocommerce custom fields file 
include( get_template_directory() . '/woocommerce/woocommerce-custom-fields.php' );

//include woocommerce custom fields file 
include( get_template_directory() . '/dokan/register-seller-form.php' );

//include woocommerce custom fields file 
include( get_template_directory() . '/dokan/dokan-custom-email.php' );

/**
* Escape Tags & Slashes
*
* Handles escapping the slashes and tags
*/
function farmtoyou_escape_attr($data){
       return !empty( $data ) ? esc_attr( stripslashes( $data ) ) : '';
}

/**
* Strip Slashes From Array
*/
function farmtoyou_escape_slashes_deep($data = array(),$flag=true){

    if($flag != true) {
         $data = farmtoyou_nohtml_kses($data);
    }
    $data = stripslashes_deep($data);
    return $data;
}

/**
* Strip Html Tags 
* 
* It will sanitize text input (strip html tags, and escape characters)
*/
function farmtoyou_nohtml_kses($data = array()) {

    if ( is_array($data) ) {
        $data = array_map(array($this,'farmtoyou_nohtml_kses'), $data);
    } elseif ( is_string( $data ) ) {
        $data = wp_filter_nohtml_kses($data);
    }
   return $data;
}

/**
 * Display Short Content By Character
 */
function farmtoyou_excerpt_char( $content, $length = 40 ) {
    
    $text = '';
    if( !empty( $content ) ) {
        $text = strip_shortcodes( $content );
        $text = str_replace(']]>', ']]&gt;', $text);
        $text = strip_tags($text);
        $excerpt_more = apply_filters('excerpt_more', ' ' . '');
        $text = substr($text, 0, $length);
        $text = $text . $excerpt_more;
    }
    return $text;
}

/**
 * Custom Meta box for post types.
 */
function farmtoyou_meta_box() {
    
    add_meta_box( 'farmtoyou_header_section_meta', __( 'Header Section Options', 'farmtoyou' ), 'farmtoyou_header_section_meta_options_page', FARMTOYOU_PAGE_POST_TYPE );
    add_meta_box( 'farmtoyou_banner_meta', __( 'Banner Information', 'farmtoyou' ), 'farmtoyou_banner_meta_options_page',FARMTOYOU_BANNER_POST_TYPE );
}

/**
 * Custom Meta box page.
 */
function farmtoyou_header_section_meta_options_page() {
    
    include get_template_directory() . '/includes/custom-header-section-meta.php';
}

/**
 * Custom Meta box page.
 */
function farmtoyou_banner_meta_options_page() {
    
    include get_template_directory() . '/includes/custom-banner-meta.php';
}

/**
 * Save Meta for post types.
 */
function farmtoyou_save_meta( $post_id ) {
    
    if( empty( $post_id ) ) { return; }
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    $prefix = FARMTOYOU_META_PREFIX;
    
    // Check post type is page
    if ( isset( $_POST['post_type'] ) && $_POST['post_type'] == FARMTOYOU_PAGE_POST_TYPE ) {
            
        /* Header Section Meta Start */
        if( isset( $_POST[$prefix.'header_disable'] ) ) {
            update_post_meta( $post_id, $prefix.'header_disable', farmtoyou_escape_slashes_deep($_POST[$prefix.'header_disable']) );
        }
        if( isset( $_POST[$prefix.'header_image'] ) ) {
            update_post_meta( $post_id, $prefix.'header_image', farmtoyou_escape_slashes_deep($_POST[$prefix.'header_image']) );
        }
        /* Header Section Page Meta End */
    }
    
    // Check post type is banner
    if ( isset( $_POST['post_type'] ) && FARMTOYOU_BANNER_POST_TYPE == $_POST['post_type'] ) {
        
        if( isset( $_POST[$prefix.'link'] ) ) {
            update_post_meta( $post_id, $prefix.'link', farmtoyou_escape_slashes_deep( $_POST[$prefix.'link'] ) );
        }
    }
}


/**
 * Add Register Settings
 */
function farmtoyou_register_settings() {
    
    register_setting( 'farmtoyou-settings-group', 'farmtoyou_options', 'farmtoyou_options_validate' );
}

/**
 * Validate Settings
 */
function farmtoyou_options_validate( $input ) {
    
    $input['404_img']    = farmtoyou_escape_slashes_deep( $input['404_img'] );
    $input['search_img'] = farmtoyou_escape_slashes_deep( $input['search_img'] );
    
    $input['fb_url']    = farmtoyou_escape_slashes_deep( $input['fb_url'] );
    $input['tw_url']    = farmtoyou_escape_slashes_deep( $input['tw_url'] );
    $input['pt_url']    = farmtoyou_escape_slashes_deep( $input['pt_url'] );
    $input['insta_url'] = farmtoyou_escape_slashes_deep( $input['insta_url'] );
    
    $input['cpy_text']  = farmtoyou_escape_slashes_deep( $input['cpy_text'] );
    
    return $input;
}

/**
 * Adding Menu Pages
 */
function farmtoyou_add_menu_pages() {
    
    add_theme_page( __( 'Theme Options', 'farmtoyou' ), __( 'Theme Options', 'farmtoyou' ), 'manage_options', 'farmtoyou-theme-options', 'farmtoyou_theme_options_page' );
    add_menu_page( __( 'Newsletter', 'farmtoyou' ), __( 'Newsletter', 'farmtoyou' ), 'manage_options', 'farmtoyou-newsletter', 'farmtoyou_newsletter_page' );
}

/**
 * Theme Options Page.
 */
function farmtoyou_theme_options_page() {
    
    include get_template_directory() . '/includes/theme-options.php';
}

/**
 * Newsletter Page.
 */
function farmtoyou_newsletter_page() {
    
    include get_template_directory() . '/includes/newsletter-page.php';
}

/**
 * search in posts and pages
 */
function farmtoyou_filter_search( $query ) {
    if( !is_admin() && $query->is_search ) {
	$query->set( 'post_type', array( FARMTOYOU_POST_POST_TYPE, FARMTOYOU_PAGE_POST_TYPE ) );
    };
    return $query;
}

function woo_add_cart_fee(){
    
    global $woocommerce;
    $post_data = array();
    parse_str($_POST['post_data'], $post_data);//This will convert the string to array
    
    /*
    if( !session_id() ) {
        session_start();
    }
    
    if( isset( $post_data['dokan_product_shipping_choice'] ) ) {
        $_SESSION['dokan_product_shipping_choice'] = $post_data['dokan_product_shipping_choice'];
    }
    */
    
    if( isset( $post_data['dokan_product_shipping_choice'] ) ) {
        WC()->session->set( 'dokan_product_shipping_choice', $post_data['dokan_product_shipping_choice'] );
    }
    
    $shipping_choice = WC()->session->get( 'dokan_product_shipping_choice' );
    
    if( !empty($shipping_choice) ){
        foreach ($shipping_choice as $key => $value) {

            $store_settings = dokan_get_store_info( $key );
            $store_name = $store_settings['store_name'];

            if( $value == "dokan_product_shipping" ) {
                $seller_shipping_charge = get_user_meta( $key, 'dokan_seller_shipping_charge', true );
                $woocommerce->cart->add_fee( "$store_name Shipping", $seller_shipping_charge, false, '' );
            }

        }
    }
    
    WC()->session->__unset( 'dokan_product_shipping_choice' );
}

// Add term page
function farmtoyou_taxonomy_add_new_meta_field() {
	// this will add the custom meta field to the add new term page
	?>
	<div class="form-field">
		<label for="term_meta[custom_term_meta]"><?php _e( 'Icon url', 'farmtoyou' ); ?></label>
		<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="">
		<p class="description"><?php _e( 'Enter a url for icon of product category','farmtoyou' ); ?></p>
	</div>
<?php
}

// Edit term page
function farmtoyou_taxonomy_edit_meta_field($term) {
 
	// put the term ID into a variable
	$t_id = $term->term_id;
 
	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( "taxonomy_$t_id" ); ?>
	<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[custom_term_meta]"><?php _e( 'Icon url', 'farmtoyou' ); ?></label></th>
            <td>
                <input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="<?php echo esc_attr( $term_meta['custom_term_meta'] ) ? esc_attr( $term_meta['custom_term_meta'] ) : ''; ?>">
                <p class="description"><?php _e( 'Enter a url for icon of product category','farmtoyou' ); ?></p>
            </td>
	</tr>
<?php
}

// Save extra taxonomy fields callback function.
function save_taxonomy_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
                if ( isset ( $_POST['term_meta'][$key] ) ) {
                    $term_meta[$key] = $_POST['term_meta'][$key];
                }
        }
        // Save the option array.
        update_option( "taxonomy_$t_id", $term_meta );
    }
}

function add_gravatar_class($class) {
    $class = str_replace("class='avatar", "class='img-responsive2", $class);
    return $class;
}

//----------FAVORITE AJAX-----------//
function ajax_add_favorite_detail() {
    ob_start();
    
    $prefix = FARMTOYOU_META_PREFIX;
    $vendor_id       = $_REQUEST['vendor_id'];
    $curr_user_email = $_REQUEST['curr_user_email'];
    $current_user_id = $_REQUEST['current_user_id'];
    
    $news_old_post = array(
                            'post_type'      => FARMTOYOU_NEWSLETTER_POST_TYPE,
                            'post_status'    => 'pending',
                            'posts_per_page' => '-1',
                            'meta_query' => array(
                                                    array(
                                                            'key'     => $prefix.'post_author',
                                                            'value'   => $vendor_id,
                                                    ),
                                                    array(
                                                            'key'     => $prefix.'post_title',
                                                            'value'   => $curr_user_email,
                                                    ),
                                                    array(
                                                            'key'     => $prefix.'curr_user_id',
                                                            'value'   => $current_user_id,
                                                    ),    
                                                ),
                        );
    
    $all_newsletter = get_posts($news_old_post);
    
    if( !empty($all_newsletter) && count($all_newsletter) > 0 ) {
        foreach ($all_newsletter as $value) {
            $my_post = array(
                                'ID'          => $value->ID,
                                'post_date'   => current_time('mysql'),
                                'post_status' => 'publish',
                            );
            wp_update_post( $my_post, true );
        }
    } else {
        $news_post  = array(
                                'post_type'     => FARMTOYOU_NEWSLETTER_POST_TYPE,
                                'post_status'   => 'publish',
                          );
        $last_id = wp_insert_post( $news_post );

        update_post_meta($last_id, $prefix.'post_author', $vendor_id );
        update_post_meta($last_id, $prefix.'post_title', $curr_user_email );
        update_post_meta($last_id, $prefix.'curr_user_id', $current_user_id );
    }
    $result = ob_get_clean(); 
    echo $result;
    exit();
}
//----------FAVORITE AJAX-----------//

/**
 * Call Web Service
 */
function farmtoyou_web_find_location() {
    
    if( !empty( $_GET['zipcode'] ) ) {
        $store_result_page_id = get_permalink( FARMTOYOU_STORE_RESULT_PAGE_ID );
        
        $param1 = array( 'farmtoyou_zip' => $_GET['zipcode'], 'miles' => $_GET['miles'] );
        $store_result_url = add_query_arg( $param1, $store_result_page_id );
        
        wp_redirect( $store_result_url );
        exit();
    }
}

function get_zips($zipcode, $miles) {
    
    $response = wp_remote_get( "https://www.zipcodeapi.com/rest/GqzStWghMjB1krPMicz5rczAz8acdNXTdxLHt2YgmAhG27tkk2pMeZmN7x0lkYey/radius.json/$zipcode/$miles/mile" );
    if( is_array($response) && !empty( $response ) ) {
        $body = $response['body'];
        $json = json_decode( $body );
    }
    
    if(!empty($json) && is_object($json) && empty($json->error_code)) {
        foreach($json->zip_codes as $k=>$v) {
            $result[] = $v;
        }
    }
    
    return $result;
}

function farmtoyou_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] ); // Remove the description tab
//    unset( $tabs['reviews'] ); // Remove the reviews tab
    unset( $tabs['additional_information'] ); // Remove the additional information tab
    unset( $tabs['seller'] ); // Remove the seller tab

    return $tabs;
}

function farmtoyou_seller_lists( $seller_listing_args ){
    $seller_listing_args['order']   = 'DESC';
    $seller_listing_args['meta_query'] = array(
                                                array(
                                                    'key'   => 'dokan_feature_seller',
                                                    'value' => 'yes'
                                                )
                                            );
    return $seller_listing_args;
}

/**
 * Redirect users to custom URL based on their role after login
 */
function wc_custom_login_redirect( $redirect, $user ) {
    
	// Get the roles assigned to the user
	$role = $user->roles[0];
        
        $dashboard_page = get_permalink( FARMTOYOU_DASHBOARD_PAGE_ID );
        $myaccount_page = get_permalink( wc_get_page_id( 'myaccount' ) );
        
        if( $role == 'seller' ) {
            $redirect = $dashboard_page;
        } elseif ( $role == 'customer' ) {
            $redirect = $myaccount_page;
        }
        
        return $redirect;
}

function wc_custom_registration_redirect( $dashboard_page ) 
{
    $dashboard_page = get_permalink( FARMTOYOU_DASHBOARD_PAGE_ID );
    
    // make filter magic happen here...
    return $dashboard_page;
}

/**
 * Change comment form default field names.
 */
function farmtoyou_change_dashboard_error_text( $translated_text, $text, $domain ) {
    
    switch ( $translated_text ) {
        case 'Error!' :
            $translated_text = __( 'Notice!', 'farmtoyou' );
            break;
        case 'Your account is not enabled for selling, please contact the admin' :
            $translated_text = __( 'Your profile is being reviewed.', 'farmtoyou' );
            break;
    }


    return $translated_text;
}

/**
 * Call function for seller ratings and reviews
 */
function farmtoyou_seller_rating_review() {
    
    if( !empty( $_POST['rating'] ) && !empty($_POST['comment']) ) {
        
        $prefix = FARMTOYOU_META_PREFIX;
        $current_user = wp_get_current_user();
        $seller_id = $_POST['seller_id'];
        $seller_rating  = $_POST['rating'];
        $user_comment   = $_POST['comment'];
        
        $seller_post  = array(
                                'post_type'     => FARMTOYOU_SELLER_REVIEW_POST_TYPE,
                                'post_status'   => 'pending',
                          );
        $last_id = wp_insert_post( $seller_post );

        update_post_meta($last_id, $prefix.'seller_id', $seller_id );
        update_post_meta($last_id, $prefix.'seller_rating', $seller_rating );
        update_post_meta($last_id, $prefix.'user_comment', $user_comment );
        update_post_meta($last_id, $prefix.'current_user_id', $current_user->ID );
        
        $store_url  = dokan_get_store_url( $seller_id );
        
        wp_redirect( $store_url );
        exit();
    }
}

function register_my_custom_submenu_page() {
    add_submenu_page( 'dokan', 'Seller Ratings', 'Seller Ratings', 'manage_options', 'seller-ratings-review', 'seller_review_submenu_page_callback');
}

function seller_review_submenu_page_callback() {
    include get_template_directory() . '/includes/custom-seller-review.php';
}

function farmtoyou_change_seller_review_status() {
    
    if( !empty( $_REQUEST['seller_review_id'] ) && !empty( $_REQUEST['seller_review_status'] ) ) {
        
        $seller_review_id     = $_REQUEST['seller_review_id'];
        $seller_review_status = $_REQUEST['seller_review_status'];
        
        $seller_review_post = array(
                            'ID'    => $seller_review_id,
                        );
        if( $seller_review_status == 'pending' ) {
            $seller_review_post['post_status'] = 'publish';
        } else if( $seller_review_status == 'publish' ) {
            $seller_review_post['post_status'] = 'pending';
        }
        
        wp_update_post( $seller_review_post );
       
        $arr_params = array( 'page' => 'seller-ratings-review' );
        $seller_ratings_url = add_query_arg( $arr_params, admin_url( 'admin.php' ) );
        
        wp_redirect( $seller_ratings_url );
        exit();
    }
    
}

/**
 * Call function for guest user add to favorite
 */
//function farmtoyou_add_guest_fav_detail() {
//    if( !empty( $_REQUEST['user_name'] ) && !empty( $_REQUEST['user_email'] ) ) {
//        
//        $prefix = FARMTOYOU_META_PREFIX;
//        $user_name = $_REQUEST['user_name'];
//        $user_email = $_REQUEST['user_email'];
//        $seller_id = $_REQUEST['seller_id'];
//        
//        if( is_email( $user_email ) ){
//            
//            $args = array(
//                'post_type' => FARMTOYOU_NEWSLETTER_POST_TYPE,
//                'post_status' => 'publish',
//                'posts_per_page' => '-1',
//                'meta_query' => array(
//                    array(
//                        'key' => $prefix . 'post_author',
//                        'value' => $seller_id,
//                    ),
//                ),
//            );
//
//            //get newsletter data from database
//            $all_newsletter = get_posts($args);
//            
//            foreach ($all_newsletter as $value) {
//                $exist_user_emails = get_post_meta($value->ID, $prefix.'post_title', true);
//                
//                echo '<pre>';
//                print_r($exist_user_emails);
//                echo '</pre>';
//                
//                if( $user_email != $exist_user_emails ) {
//                    echo "insert";
//                } else {
//                    echo "alredy exist";
//                }
//            }
//        }
//    }
//}

//function farmtoyou_vendor_setup_gridlist() {
//    
//        $list_grid = new WC_List_Grid();
//    
//        add_action( 'wp_enqueue_scripts', array( $list_grid, 'setup_scripts_styles' ), 20);
//        add_action( 'wp_enqueue_scripts', array( $list_grid, 'setup_scripts_script' ), 20);
//        add_action( 'woocommerce_before_shop_loop', array( $list_grid, 'gridlist_toggle_button' ), 30);
//        add_action( 'woocommerce_after_shop_loop_item', array( $list_grid, 'gridlist_buttonwrap_open' ), 9);
//        add_action( 'woocommerce_after_shop_loop_item', array( $list_grid, 'gridlist_buttonwrap_close' ), 11);
//        add_action( 'woocommerce_after_shop_loop_item', array( $list_grid, 'gridlist_hr' ), 30);
//        add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 5);
//        add_action( 'woocommerce_after_subcategory', array( $list_grid, 'gridlist_cat_desc' ) );
//        
//        // Scripts & styles
//        function setup_scripts_styles() {
//                wp_enqueue_style( 'grid-list-layout', plugins_url( '/woocommerce-grid-list-toggle/assets/css/style.css' ) );
//                wp_enqueue_style( 'grid-list-button', plugins_url( '/woocommerce-grid-list-toggle/assets/css/button.css' ) );
//        }
//        function setup_scripts_script() {
//                wp_enqueue_script( 'cookie', plugins_url( '/woocommerce-grid-list-toggle/assets/js/jquery.cookie.min.js'), array( 'jquery' ) );
//                wp_enqueue_script( 'grid-list-scripts', plugins_url( '/woocommerce-grid-list-toggle/assets/js/jquery.gridlistview.min.js'), array( 'jquery' ) );
//                add_action( 'wp_footer', array( $list_grid, 'gridlist_set_default_view') );
//        }
//}

function farmtoyou_vendor_review_sidebar() {
    
    global $post;
    if(is_product() ) {
        $store_user = get_userdata($post->post_author);
    } else {
        $store_user = get_userdata(get_query_var('author'));
    }
?>
        <div id="seller-review" class="woocommerce" style="display: none;">
            <div class="user-seller-review">
                <h3 class="comment-reply-title" id="reply-title">Add a review</h3>
                <form novalidate="" class="comment-form" id="commentform" method="post" action="">
                    <input type="hidden" name="seller_id" id="seller_id" value="<?php echo $store_user->ID ?>">
                    <p class="comment-form-rating">
                        <label for="rating">Your Rating</label>
                        <select id="rating" name="rating">
                            <option value="1">Very Poor</option>
                            <option value="2">Not that bad</option>
                            <option value="3" selected>Average</option>
                            <option value="4">Good</option>
                            <option value="5">Perfect</option>
                        </select>
                    </p>
                    <p class="comment-form-comment">
                        <label for="comment">Your Review</label>
                        <textarea aria-required="true" rows="8" cols="45" name="comment" id="comment"></textarea>
                    </p>						
                    <p class="form-submit">
                        <input type="submit" value="Submit" class="submit" id="submit" name="submit">
                    </p>
                </form>
            </div>
        </div>    
<?php
}

function farmtoyou_gridlist_cat_desc() {
    
    global $post;
    if( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
        echo farmtoyou_excerpt_char( $post->post_excerpt, 180 );
        echo '<a href="'.get_permalink().'"> Read More... </a>';
    } else {
        echo $post->post_excerpt;
    }
}

//add action to create custom meta box
add_action( 'admin_init', 'farmtoyou_meta_box' );

//add action to save custom 
add_action( 'save_post', 'farmtoyou_save_meta' );

//add action to add theme options page
add_action( 'admin_menu', 'farmtoyou_add_menu_pages' );

//add action to call register settings function
add_action( 'admin_init', 'farmtoyou_register_settings' );

//add filter to search in posts and pages
add_filter('pre_get_posts', 'farmtoyou_filter_search');

add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );

add_action( 'product_cat_add_form_fields', 'farmtoyou_taxonomy_add_new_meta_field', 12, 2 );
add_action( 'product_cat_edit_form_fields', 'farmtoyou_taxonomy_edit_meta_field', 12, 2 );
  
add_action( 'edited_product_cat', 'save_taxonomy_custom_meta', 12, 2 );  
add_action( 'create_product_cat', 'save_taxonomy_custom_meta', 12, 2 );

//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

add_filter('get_avatar','add_gravatar_class');

//ajax call for condition detail
add_action( 'wp_ajax_add_fav_detail', 'ajax_add_favorite_detail' );
add_action( 'wp_ajax_nopriv_add_fav_detail', 'ajax_add_favorite_detail' );

//add action to add web service call
add_action( 'init', 'farmtoyou_web_find_location' );

//add filter to remove tabs from product page
add_filter( 'woocommerce_product_tabs', 'farmtoyou_remove_product_tabs', 98 );

add_filter( 'dokan_seller_list_query', 'farmtoyou_seller_lists');

//add filter to redirect after login
add_filter( 'woocommerce_login_redirect', 'wc_custom_login_redirect', 10, 2 );
add_filter( 'woocommerce_registration_redirect', 'wc_custom_registration_redirect', 10, 1 );

add_filter( 'gettext', 'farmtoyou_change_dashboard_error_text', 20, 3 );

//add action to add seller rating & review
add_action( 'init', 'farmtoyou_seller_rating_review' );

//add action for register seller ratings & review page
add_action('admin_menu', 'register_my_custom_submenu_page');

//add action for register seller ratings & review page
add_action('admin_init', 'farmtoyou_change_seller_review_status');

//add action for guest user favorite
//add_action( 'wp', 'farmtoyou_add_guest_fav_detail' );

//add_action( 'wp_loaded', 'farmtoyou_vendor_setup_gridlist');

add_action( 'wp_footer', 'farmtoyou_vendor_review_sidebar');

add_filter( 'woocommerce_short_description', 'farmtoyou_gridlist_cat_desc' );
?>