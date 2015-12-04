<?php

function wc_remove_related_products( $args ) {
	return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10); 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if( !defined( 'WOOCOMMERCE_PRODUCT_POST_TYPE' ) ) {
    define( 'WOOCOMMERCE_PRODUCT_POST_TYPE', 'product' );
}
if( !defined( 'WOOCOMMERCE_PRODUCT_COLLECTION_TAX' ) ) {
    define( 'WOOCOMMERCE_PRODUCT_COLLECTION_TAX', 'collection' );
}
if( !defined( 'WOOCOMMERCE_PRODUCT_SERIES_TAX' ) ) {
    define( 'WOOCOMMERCE_PRODUCT_SERIES_TAX', 'series' );
}
if( !defined( 'CANVAS_CHILD_META_PREFIX' ) ) {
    define( 'CANVAS_CHILD_META_PREFIX', '_canvas_child_' );
}

// Include custom post types & taxonomies
require get_stylesheet_directory() . '/includes/custom-posttypes.php';

// Include custom widget
require get_stylesheet_directory() . '/widgets/class-collection-category-widget.php';

// Include custom widget
require get_stylesheet_directory() . '/widgets/class-series-category-widget.php';

//Include custom shortcode file
include( get_stylesheet_directory() . '/includes/custom-shortcodes.php' );

// Change post per page in series view page
function number_of_product_per_page( $query ){
    $current_term = get_queried_object();
    
    if( !empty( $current_term ) && !is_admin() ){
        
        $query->set( 'orderby', 'post_date' );   
        $query->set( 'order', 'DESC' );    
        
        if( $current_term->taxonomy ==  WOOCOMMERCE_PRODUCT_SERIES_TAX )
        {
            $query->set( 'posts_per_page', 50 );  
            $query->set( 'orderby', 'post_date' );   
            $query->set( 'order', 'ASC' );            
        }
    }
}

add_filter( 'pre_get_posts', 'number_of_product_per_page');

// Pagination
function woothemes_paging_nav() {
	global $wp_query, $wp_rewrite;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Previous', 'woothemes' ),
		'next_text' => __( 'Next &rarr;', 'woothemes' ),
	) );

	if ( $links ) :
?>
            <div class="pagination woo-pagination">
                <?php echo $links; ?>
            </div>
<?php        
	endif;
}

// ajax to add multiple episodes in cart

function add_multiple_episode_in_cart() {
   if( !empty( $_POST['selected_ids'] ) ){
       
       $id_arrays = $_POST['selected_ids'];
       foreach( $id_arrays as $id )
       {
           WC()->cart->add_to_cart( $id );
       }
       
       $cart_page_id = wc_get_page_id( 'cart' );
       $view_cart_link = !empty( $cart_page_id ) ? get_permalink( $cart_page_id ) : '' ;
       if( !empty( $view_cart_link ) ){
?>
        <div class="woocommerce-message">            
            <a class="button wc-forward" href="<?php echo $view_cart_link; ?>"><?php _e('View Cart','woocommerce');?></a>
            <a class="button wc-forward" href="<?php echo get_permalink(); ?>"><?php _e('Continue Shopping','woocommerce');?></a>            
            <?php _e( 'Your product has been successfully added to the cart', 'woocommerce'); ?>
        </div>
<?php   
       }
       exit;
   }
   else{
?>
        <div class="woocommerce-message">
            <?php echo "Please Select Episodes to add in cart"; ?>
        </div>
<?php
       exit;
   }
}

add_action('wp_ajax_add_multiple_episode_in_cart', 'add_multiple_episode_in_cart');
add_action("wp_ajax_nopriv_add_multiple_episode_in_cart", "add_multiple_episode_in_cart");

/* slider on front page */
if ( ! function_exists( 'canvas_child_load_slider_js' ) ) {
	function canvas_child_load_slider_js( $flag ) {
            if( is_front_page() ) {
                $flag = true;
            }
            return $flag;
        }
}


/* hide sidebar */
if ( ! function_exists( 'canvas_child_add_before_content' ) ) {
	function canvas_child_add_before_content() {
	?>
		<!-- #content Starts -->
                             
		<?php woo_content_before(); ?>
	    <div id="content" class="col-full">
                <?php 
                    $sidebar_hide_class = 'sidebar-show category-series';
                                        
                    $options = get_option( 'woo_sidebar_in_page' );
                    if(!( ( is_product_category() && in_array( get_queried_object()->name, $options ) ) || ( ( is_product() || is_tax( get_object_taxonomies( WOOCOMMERCE_PRODUCT_SERIES_TAX ) ) ) && !is_product_category() ) ) ){
                    
                        $sidebar_hide_class = 'sidebar-hide compact-discpage';
                    }
                   
                    
                ?>
                
                <?php
                    /* sidebar... */
                    // woo_main_after(); 
                ?>
                
                <div id="main-sidebar-container" class="<?php echo $sidebar_hide_class; ?>">

	            <!-- #main Starts -->
	            <?php woo_main_before(); ?>
	            <section id="main" class="col-left">
	    <?php
	}
}

if ( ! function_exists( 'canvas_child_add_after_content' ) ) {
	function canvas_child_add_after_content() {
            
	?>		
                    </section><!-- /#main -->
                                
                </div><!-- /#main-sidebar-container -->
                
                <?php woo_main_after(); ?>
                
                <?php get_sidebar( 'alt' ); ?>

	    </div><!-- /#content -->
            
            <?php woo_content_after(); 
	}
}

function canvas_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
    
    $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    wp_register_script( 'flexslider', get_template_directory_uri() . '/includes/js/jquery.flexslider' . $suffix . '.js', array( 'jquery' ) );
    wp_enqueue_script( 'flexslider' );
    
    wp_enqueue_style( 'djquery.fancybox', get_stylesheet_directory_uri() . '/includes/css/jquery.fancybox.css', array(), NULL );
    wp_enqueue_script( 'jquery.fancybox', get_stylesheet_directory_uri() . '/includes/js/jquery.fancybox.js', array(), NULL );
}

function canvas_child_apply_when_load() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_canvas_before_content', 10 );
    add_action( 'woocommerce_before_main_content', 'canvas_child_add_before_content', 10 );
    
    remove_action( 'woocommerce_after_main_content', 'woocommerce_canvas_after_content', 10 );
    add_action( 'woocommerce_after_main_content', 'canvas_child_add_after_content', 10 );
    
    add_filter( 'woo_load_slider_js', 'canvas_child_load_slider_js' );
    
    add_action( 'wp_enqueue_scripts', 'canvas_child_enqueue_styles' );
    
    // set default product image
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
    add_action( 'woocommerce_before_shop_loop_item_title', 'canvas_child_loop_product_thumbnail', 10 );
   
    // remove total product count (show total number of products)
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    
    // review tab only in specific product category single product page
    add_filter( 'woocommerce_product_tabs', 'canvas_child_remove_reviews_tab', 98);
    function canvas_child_remove_reviews_tab($tabs) {
        global $product;       
        
        $current_product_cat = wp_get_object_terms( $product->id, 'product_cat', array( 'fields' => 'slugs' ) );
        if( $current_product_cat[0] != 'compact-discs' && $current_product_cat[0] != 'collections' ) {                        
            unset($tabs['reviews']);
        }
        return $tabs;
    }  
    
}
add_action( 'wp_loaded', 'canvas_child_apply_when_load' );

/* zip button in collection product */

function canvas_child_create_downloads_zip(){
    
    if( class_exists( 'WC_Bulk_Download' ) ) { 
        $bulk_download_obj = WC_Bulk_Download::get_instance();

        if ( isset( $_POST['create-order-zip'] ) && '1' == $_POST['create-order-zip'] ) {

            $download_data = json_decode( urldecode( $_POST['wcbd-download-data'] ) );

            $user_ID = get_current_user_id();

            set_transient( 'wcbd-' . $user_ID, $bulk_download_obj->zip_location( '/' ) . $bulk_download_obj->zip_name() . '.zip', 3600 );

            $result = $bulk_download_obj->create_zip( $bulk_download_obj->get_order_downloads( $download_data ), get_transient( 'wcbd-' . $user_ID ), false );

            echo $bulk_download_obj->download_file( get_transient( 'wcbd-' . $user_ID ) );

            delete_transient( 'wcbd-' . $user_ID );

        }
    }
}

add_action( 'init', 'canvas_child_create_downloads_zip' );

/* product default image */
if ( ! function_exists( 'canvas_child_loop_product_thumbnail' ) ) {
    function canvas_child_loop_product_thumbnail(){
        $product_image = woocommerce_get_product_thumbnail();
        if( empty( $product_image ) ){
            $product_image = get_stylesheet_directory_uri().'/images/comapct-disk-default.png';
            ?>
                <img src="<?php echo $product_image; ?>">
            <?php
        }
        else{
            echo $product_image;
        }
    }
}

/**
 * Strip Slashes From Array
 */
function canvas_child_escape_slashes_deep($data = array(), $flag = true){

    if( $flag != true ){
        $data = canvas_child_nohtml_kses( $data );
    }
    $data = stripslashes_deep( $data );
    return $data;
}

/**
 * Strip Html Tags 
 * 
 * It will sanitize text input (strip html tags, and escape characters)
 */
function canvas_child_nohtml_kses($data = array()){

    if( is_array( $data ) ){
        $data = array_map( array($this, 'canvas_child_nohtml_kses'), $data );
    }
    elseif( is_string( $data ) ){
        $data = wp_filter_nohtml_kses( $data );
    }
    return $data;
}

// add meta box
function canvas_child_meta_box() {
    
    add_meta_box( 'canvas_child_product_meta', __( 'Display Products', 'canvas_child' ), 'canvas_child_product_meta_options_page',WOOCOMMERCE_PRODUCT_POST_TYPE, 'side' );
    add_meta_box( 'canvas_child_product_description_meta', __( 'Product Information', 'canvas_child' ), 'canvas_child_product_description_meta_options_page',WOOCOMMERCE_PRODUCT_POST_TYPE );
}

/**
 * Custom Meta box page.
 */
function canvas_child_product_meta_options_page() {    
    include get_stylesheet_directory() . '/includes/custom-meta/custom-product-meta.php';
}
function canvas_child_product_description_meta_options_page() {
    
    include get_stylesheet_directory() . '/includes/custom-meta/custom-product-description-meta.php';
}

/**
 * Save Meta for post types.
 */
function canvas_child_save_meta( $post_id ) {
       
    if( empty( $post_id ) ) { return; }
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    $prefix = CANVAS_CHILD_META_PREFIX;
    
    if ( isset( $_POST['post_type'] ) && WOOCOMMERCE_PRODUCT_POST_TYPE == $_POST['post_type'] ) {
        if( isset( $_POST[$prefix.'product_show'] ) ) {
            update_post_meta( $post_id, $prefix.'product_show', $_POST[$prefix.'product_show'] );
        }  
        if( isset( $_POST[$prefix.'product_show_on_home'] ) ) {
            update_post_meta( $post_id, $prefix.'product_show_on_home', $_POST[$prefix.'product_show_on_home'] );
        }  
        if( isset( $_POST[$prefix.'product_description'] ) ) {
            update_post_meta( $post_id, $prefix.'product_description', canvas_child_escape_slashes_deep( $_POST[$prefix.'product_description'], true) );
        }  
    }
}

//add action to create custom meta box
add_action( 'admin_init', 'canvas_child_meta_box' );
//add action to save custom 
add_action( 'save_post', 'canvas_child_save_meta' );

// add meta field in product category

function canvas_child_taxonomy_add_new_meta_field() {
// this will add the custom meta field to the add new term page 
?>
	<div class="form-field">
		<label for="term_meta[canvas_child_page_title]"><?php _e( 'Page Title', 'canvas_child' ); ?></label>
		<input type="text" name="term_meta[canvas_child_page_title]" id="term_meta[canvas_child_page_title]" value="">
		<p class="description"><?php _e( 'Enter a title to show on category page','canvas_child' ); ?></p>
	</div>
	<div class="form-field">
		<label for="term_meta[canvas_child_home_title]"><?php _e( 'Home Page Title', 'canvas_child' ); ?></label>
		<input type="text" name="term_meta[canvas_child_home_title]" id="term_meta[canvas_child_home_title]" value="">
		<p class="description"><?php _e( 'Enter a title to show on home page','canvas_child' ); ?></p>
	</div>
	<div class="form-field">
		<label for="term_meta[canvas_child_digital_download_title]"><?php _e( 'Digital Download Page Title', 'canvas_child' ); ?></label>
		<input type="text" name="term_meta[canvas_child_digital_download_title]" id="term_meta[canvas_child_digital_download_title]" value="">
		<p class="description"><?php _e( 'Enter a title to show on digital download page','canvas_child' ); ?></p>
	</div>
<?php
}
add_action( 'product_cat_add_form_fields', 'canvas_child_taxonomy_add_new_meta_field', 10, 2 );

// Edit term page
function canvas_child_taxonomy_edit_meta_field($term) {
 
 // put the term ID into a variable
 $t_id = $term->term_id;
        
 // retrieve the existing value(s) for this meta field. This returns an array
 $page_title        = get_option( "taxonomy_page_title_$t_id" );
 $home_title        = get_option( "taxonomy_home_title_$t_id" );
 $digital_download  = get_option( "taxonomy_digital_download_$t_id" );

?>
<tr class="form-field">
 <th scope="row" valign="top"><label for="term_meta[canvas_child_page_title]"><?php _e( 'Page Title', 'canvas_child' ); ?></label></th>
    <td>
        <input type="text" name="term_meta[canvas_child_page_title]" id="term_meta[canvas_child_page_title]" value="<?php echo !empty( $page_title ) ? $page_title : '';?>">
    </td>
<tr class="form-field">
 <th scope="row" valign="top"><label for="term_meta[canvas_child_home_title]"><?php _e( 'Home Page Title', 'canvas_child' ); ?></label></th>
    <td>
        <input type="text" name="term_meta[canvas_child_home_title]" id="term_meta[canvas_child_home_title]" value="<?php echo !empty( $home_title ) ? $home_title : '';?>">
    </td>
 </tr>
 <tr class="form-field">
     <th scope="row" valign="top"><label for="term_meta[canvas_child_digital_download_title]"><?php _e( 'Digital Download page Title', 'canvas_child' ); ?></label></th>
     <td>
        <input type="text" name="term_meta[canvas_child_digital_download_title]" id="term_meta[canvas_child_digital_download_title]" value="<?php echo !empty( $digital_download ) ? $digital_download : ''; ?>">                
    </td>
 </tr>
<?php
}
add_action( 'product_cat_edit_form_fields', 'canvas_child_taxonomy_edit_meta_field', 10, 2 );

// Save extra taxonomy fields callback function.
function canvas_child_save_taxonomy_custom_meta( $term_id ) {
       
    if ( !empty( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $page_title             = $_POST['term_meta']['canvas_child_page_title'];
        $home_title             = $_POST['term_meta']['canvas_child_home_title'];
        $digital_download_title = $_POST['term_meta']['canvas_child_digital_download_title'];

        // Save the option array.
        update_option( "taxonomy_page_title_$t_id", $page_title );
        update_option( "taxonomy_home_title_$t_id", $home_title );
        update_option( "taxonomy_digital_download_$t_id", $digital_download_title );
    }
}
add_action( 'create_product_cat', 'canvas_child_save_taxonomy_custom_meta', 10, 2 );
add_action( 'edited_product_cat', 'canvas_child_save_taxonomy_custom_meta', 10, 2 ); 

if ( ! function_exists( 'canvas_child_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Mrp 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function canvas_child_paging_nav( $canvas_child_query = '' ) {
	global $wp_query, $wp_rewrite;
      
	if( !empty( $canvas_child_query ) ) {
            
            $max_num_pages = $canvas_child_query->max_num_pages;
            
        } else {
            
            $max_num_pages = $wp_query->max_num_pages;
        }
        
	// Don't print empty markup if there's only one page.
	if ( $max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );
        
	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Previous', 'canvas_child' ),
		'next_text' => __( 'Next &rarr;', 'canvas_child' ),
	) );
       
	if ( $links ) :

	?>
	<div class="pagination woo-pagination">	
            <?php echo $links; ?>
	</div><!-- .navigation -->
	<?php
	endif;
}
endif;

//add html before price of product
add_filter( 'woocommerce_get_price_html', 'add_strike_before_del_when_sale', 100, 2 );
function add_strike_before_del_when_sale( $price, $product ){   
    if( !empty( $product->sale_price ) ){
        $price1 = str_replace( '<del><span class="amount">', '<del><span class="amount"><strike>', $price );
        return str_replace( '</span></del>', '</strike></span></del>', $price1 );
    }
    return $price;
}

// change number of products per page
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 20;' ), 20 );
?>