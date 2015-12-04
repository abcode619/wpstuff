<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Newsletter List Page
 *
 * The html markup for the product list
 */
if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class SellerReview_List extends WP_List_Table {

    function __construct() {

        //Set parent defaults
        parent::__construct(array(
            'singular' => 'newslwetter', //singular name of the listed records
            'plural' => 'newslwetters', //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ));
    }

    /**
     * Displaying Prodcuts
     *
     * Does prepare the data for displaying the products in the table.
     */
    function display_seller_review() {

        $data = array();

        $prefix = FARMTOYOU_META_PREFIX;
        //if search is call then pass searching value to function for displaying searching values
        $args = array(
            'post_type' => FARMTOYOU_SELLER_REVIEW_POST_TYPE,
            'post_status' => 'any',
            'posts_per_page' => '-1'
        );

        //get seller_review data from database
        $all_seller_review = get_posts($args);
        
        foreach ($all_seller_review as $key => $value) {
            
            $seller_id = get_post_meta( $value->ID, $prefix.'seller_id', true );
            $store_info = dokan_get_store_info( $seller_id );
            $store_name = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', 'dokan' );
            
            $curr_user_id = get_post_meta( $value->ID, $prefix.'current_user_id', true );
            $user_info = get_userdata( $curr_user_id );
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
            $user_email = $user_info->user_email;

            
            $data[$key]['ID'] = isset($value->ID) ? $value->ID : '';
            $data[$key]['seller_store'] = $store_name;
            $data[$key]['curr_user_name'] = $first_name." ".$last_name;
            $data[$key]['curr_user_email'] = $user_email;
            $data[$key]['user_rating'] = get_post_meta( $value->ID, $prefix.'seller_rating', true );
            $data[$key]['user_comment'] = get_post_meta( $value->ID, $prefix.'user_comment', true );
            $data[$key]['post_status'] = isset($value->post_status) ? $value->post_status : '';
            $data[$key]['post_date'] = isset($value->post_date) ? $value->post_date : '';
        }

        return $data;
    }

    /**
     * Mange column data
     *
     * Default Column for listing table
     */
    function column_default($item, $column_name) {

        switch ($column_name) {
            case 'seller_store':
                return $item[$column_name];
            case 'curr_user_name':
                return $item[$column_name];
            case 'curr_user_email':
                return $item[$column_name];
            case 'user_rating':
                return $item[$column_name] . ' / 5';
            case 'user_comment':
                return $item[$column_name];
            case 'post_status':
                
                $seller_review_params = array( 'seller_review_id' => $item['ID'], 'seller_review_status' => $item['post_status'] );
                $seller_review_query = add_query_arg( $seller_review_params, admin_url() );
                
                return '<a class="button" href="'.$seller_review_query.'">'.ucwords($item[$column_name]).'</a>';
            case 'post_date' :
                $format = get_option('date_format') . ' ' . get_option('time_format');
                $datetime = !empty($item[$column_name]) ? date_i18n($format, strtotime($item[$column_name])) : '';
                return $datetime;
            default:
                return $item[$column_name];
        }
    }

    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />',
                /* $1%s */ $this->_args['singular'], //Let's simply repurpose the table's singular label ("movie")
                /* $2%s */ $item['ID']                //The value of the checkbox should be the record's id
        );
    }

    /**
     * Display Columns
     *
     * Handles which columns to show in table
     */
    function get_columns() {

        $columns = array(
            'seller_store'      => __('Seller Name', 'farmtoyou'),
            'curr_user_name'    => __('User Name', 'farmtoyou'),
            'curr_user_email'   => __('User Email', 'farmtoyou'),
            'user_rating'       => __('User Rating', 'farmtoyou'),
            'user_comment'      => __('User Review', 'farmtoyou'),
            'post_status'       => __('Review Status', 'farmtoyou'),
            'post_date'         => __('Date', 'farmtoyou'),
        );
        return $columns;
    }

    /**
     * Sortable Columns
     *
     * Handles soratable columns of the table
     */
    function get_sortable_columns() {

        $sortable_columns = array();
        return $sortable_columns;
    }

    function no_items() {
        //message to show when no records in database table
        _e('No Seller Review Found.', 'farmtoyou');
    }

    /**
     * Bulk actions field
     *
     * Handles Bulk Action combo box values
     */
    function get_bulk_actions() {
        //bulk action combo box parameter
        //if you want to add some more value to bulk action parameter then push key value set in below array
        $actions = array();
        return $actions;
    }

    function prepare_items() {

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = '10';

        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();


        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);

        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        //$this->process_bulk_action();

        /**
         * Instead of querying a database, we're going to fetch the example data
         * property we created for use in this plugin. This makes this example 
         * package slightly different than one you might build on your own. In 
         * this example, we'll be using array manipulation to sort and paginate 
         * our data. In a real-world implementation, you will probably want to 
         * use sort and pagination data to build a custom query instead, as you'll
         * be able to use your precisely-queried data immediately.
         */
        $data = $this->display_seller_review();

        /**
         * This checks for sorting input and sorts the data in our array accordingly.
         * 
         * In a real-world situation involving a database, you would probably want 
         * to handle sorting by passing the 'orderby' and 'order' values directly 
         * to a custom query. The returned data will be pre-sorted, and this array
         * sorting technique would be unnecessary.
         */
        function usort_reorder($a, $b) {
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'post_date'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order === 'asc') ? $result : -$result; //Send final sort direction to usort
        }

        usort($data, 'usort_reorder');


        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();

        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);


        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data, (($current_page - 1) * $per_page), $per_page);


        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;


        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page, //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
        ));
    }

}

//Create an instance of our package class...
$SellerReviewListTable = new SellerReview_List();

//Fetch, prepare, sort, and filter our data...
$SellerReviewListTable->prepare_items();
?>

<div class="wrap">

    <h2 class="farmtoyou-settings-title">
    <?php echo __('Seller Ratings &amp; Reviews', 'farmtoyou'); ?>
    </h2>

    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="product-filter" method="get" class="farmtoyou-form">

        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <input type="hidden" name="post_type" value="<?php echo FARMTOYOU_NEWSLETTER_POST_TYPE; ?>" />

        <!-- Now we can render the completed list table -->
        <?php $SellerReviewListTable->display(); ?>

    </form>
</div><!--wrap-->