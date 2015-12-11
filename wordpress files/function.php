INDEX : 
1 . Plugin         

Required plugin :
1.esb url extension 
       2 .Social share : Social Media Feather - lightweight social media sharing and follow buttons
       3. Hidden fileds :  Contact Form 7 Modules: Hidden Fields.
4 . minify css : Better minify css wordpress
5 for image size reduce : WP Smush
 --------------------------------------------------------------------------------------------------------
Password protected custom form login : 
Add file  : client-template.php
Login action  : 

function artist_client_login() {
       
    if( !empty($_POST['category_name']) && !empty($_POST['category_password']) ) {
        $category_name = $_POST['category_name'];
        $new_password  = $_POST['category_password'];
        
        $args = array(
                'name'           => $category_name,
                'post_type'      => ARTIST_CATEGORIES_POST_TYPE,
                'post_status'    => 'any',
                'posts_per_page' => -1,
            );
        $cat_array = get_posts( $args );
       
        foreach ( $cat_array as $category )
        {
            $old_password = $category->post_password;
            if( $new_password == $old_password ) {
                require_once ABSPATH . WPINC . '/class-phpass.php';
                $hasher = new PasswordHash( 8, true );

                /**
                 * Filter the life span of the post password cookie.
                 *
                 * By default, the cookie expires 10 days from creation. To turn this
                 * into a session cookie, return 0.
                 *
                 * @since 3.7.0
                 *
                 * @param int $expires The expiry time, as passed to setcookie().
                 */
                $expire = apply_filters( 'post_password_expires', time() + DAY_IN_SECONDS );
                $secure = ( 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
                setcookie( 'wp-postpass_' . COOKIEHASH, $hasher->HashPassword( wp_unslash( $_POST['category_password'] ) ), $expire, COOKIEPATH, COOKIE_DOMAIN, $secure );
                
                $cat_page_url = get_permalink( $category->ID );
                wp_safe_redirect( $cat_page_url );
                exit();
            }
        }
    }
}

add_action( 'wp', 'artist_client_login' );

--------------------------------------------------------------------------------------------------------

--------------------------------------------------------------------------------------------------------
//add action to hide admin panel
add_filter('show_admin_bar', '__return_false');
--------------------------------------------------------------------------------------------------------
Contact Form in POP up : 
<a href="#contact_form_pop" class="request-quotelink fancybox"><?php _e('Claim listing', 'pexeto'); ?></a>
        <div style="display:none" class="fancybox-hidden">
            <div id="contact_form_pop">
                <?php echo do_shortcode( '[contact-form-7 id="11782" title="Claim List"]' ); ?> 
            </div>
</div>


Category with link for custom Post Type 
$story_cat = get_the_terms($post_id, HSBOARD_STORY_POST_TAX );

                    if ( $story_cat && ! is_wp_error( $story_cat ) ) {

                        echo '<ul>';

                        foreach ( $story_cat as $term ) {

                            // The $term is an object, so we don't need to specify the $taxonomy.
                            $term_link = get_term_link( $term );

                            // If there was an error, continue to the next term.
                            if ( is_wp_error( $term_link ) ) {
                                continue;
                            }

                            // We successfully got a link. Print it out.
                            echo '<li><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></li>';
                        }
                        
                         echo '</ul>';
                    }
DROP DOWN  FILTERING
<?php $destination_url = get_permalink(EXPAT_DESTINATION_PAGE_ID); ?>
              <a href="<?php echo add_query_arg( array( 'location' => 'at'), $destination_url ); ?>" class="usemap-link">Use the map</a>
                <div class="select-desination">
                    <?php
                    $terms = get_terms(EXPAT_POST_POST_TAX);
                    if (!empty($terms) && !is_wp_error($terms))
                    { ?> <span>Choose a country</span>
                        <ul name="jobs-dropdown" onchange="document.location.href = this.options[this.selectedIndex].value;">
                            <?php
                            foreach ($terms as $term)
                            {  ?>
                                <li> <a href="<?php echo get_term_link($term); ?>"><?php echo $term->name; ?></a></li>
                            <?php }
                            ?>
                        </ul>
                    <?php }
                    ?>
                </div>

--------------------------------------------------------------------------------------------------------



Redirection for non logged in user : 
function redirect_non_logged_in()
{

    if (!is_user_logged_in() && is_page(SPE_TRANSACTION_PAGE_ID))
    {
       wp_redirect(get_permalink(SPE_SIGNIN_PAGE_ID), 301);
        exit;
    }
}
//add action to check  Logged in or not
add_filter('wp', 'redirect_non_logged_in');

--------------------------------------------------------------------------------------------------------


Worpdresss backend Block : 


function blockusers_init()
{
    if (is_admin() && !current_user_can('administrator') &&
            !( defined('DOING_AJAX') && DOING_AJAX ))
    {
        wp_redirect(home_url());
        exit;
    }
}
add_action('init', 'blockusers_init');

--------------------------------------------------------------------------------------------------------


CPT  PAGINATION :
Note : Page and cpt name is not same(slug) .
CPT add this code : 
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; 
This to arguments : 
'paged' => $paged,
Using of function:
spe_paging_nav($article_query);
template-tags.php
if( !empty( $article_query ) ) {
            $max_num_pages = $article_query->max_num_pages;
        } else {
            $max_num_pages = $wp_query->max_num_pages;
        }
Change argument parameter : 
'total'    => $max_num_pages,
--------------------------------------------------------------------------------------------------------

Calling template file in folder  : 
In fact you can, I have a folder in my theme directory called /partials/ in in that folder I have files such as latest-articles.php, latest-news.php and latest-statements.php and I load these files using get_template_part() like:
get_template_part('partials/latest', 'news');

get_template_part('partials/latest', 'articles');

get_template_part('partials/latest', 'statements');


--------------------------------------------------------------------------------------------------------

META BOX PAGE CONDITION :
if (isset( $_REQUEST['post'] ) && ( $_REQUEST['post'] == SPE_HOME_PAGE_ID))
    {
        add_meta_box('spe_home_meta', __('Home Content Information', 'spe'), 'spe_home_meta_options_page', SPE_PAGE_POST_TYPE);
    }

--------------------------------------------------------------------------------------------------------

Style .css  
/*
Theme Name: Twenty Fifteen
Theme URI: https://wordpress.org/themes/twentyfifteen
Author: the WordPress team
 URI: https://wordpress.org/
Description: Our 2015 default theme is clean, blog-focused, and designed for clarity. Twenty Fifteen's simple, straightforward typography is readable on a wide variety of screen sizes, and suitable for multiple languages. We designed it using a mobile-first approach, meaning your content takes center-stage, regardless of whether your visitors arrive by smartphone, tablet, laptop, or desktop computer.
*/
--------------------------------------------------------------------------------------------------------

SERCH FORM:
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
                            <input type="text" value="<?php the_search_query(); ?>" name="s" placeholder="search">
                        </form>
--------------------------------------------------------------------------------------------------------


Walker Class For add DIV OR CLASS To the MENU
Function.php
 class Menu_With_Description extends Walker_Nav_Menu {
    
    // add classes to ul sub-menus
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // depth dependent classes
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth
            );
        $class_names = implode( ' ', $classes );
        
        $sub_menu_icon = ( $depth == 0 ) ? '<div class="menulinks2"><i class="fa fa-caret-square-o-down"></i></div>' : ( ( $depth == 1 ) ? '<div class="menulinks3"><i class="fa fa-caret-square-o-down"></i></div>' : '' );

        // build html
        $output .= "\n" . $sub_menu_icon . $indent . '<ul class="' . $class_names . '">' . "\n";
    }
    
}

Header.php
<?php $walker = new Menu_With_Description(); ?>
		<div id="nav"><?php wp_nav_menu( array('menu' => 'Top Menu','container_class' => 'main_menu' ,'theme_location' => 'primary', 'walker' => $walker)); ?><br class="clear" /></div>

--------------------------------------------------------------------------------------------------------

Excerpt to any pages :

	add_action( 'init', 'my_add_excerpts_to_pages' );
	function my_add_excerpts_to_pages() {
	     add_post_type_support( 'page', 'excerpt' );
	}

--------------------------------------------------------------------------------------------------------

Calling any file :
<?php 
get_template_part( 'nav', 'single' ); // Navigation bar to use in single pages (nav-single.php) 
?>
•	Wordpress function

--------------------------------------------------------------------------------------------------------


SOCIAL LINKS : 
 
<a href="javascript:void(0);"  class="addthis_button_facebook bloglfacebook-link" addthis:url="<?php echo get_permalink(); ?>" addthis:title="<?php echo get_the_title(); ?>"><i class="fa fa-facebook"></i></a>
        <a href="javascript:void(0);"  class="addthis_button_twitter blogltwitter-link" addthis:url="<?php echo get_permalink(); ?>" addthis:title="<?php echo get_the_title(); ?>"><i class="fa fa-twitter"></i></a>
        <a href="javascript:void(0);"  class="addthis_button_google_plusone_share bloglgooglepplus-link" addthis:url="<?php echo get_permalink(); ?>" addthis:title="<?php echo get_the_title(); ?>"><i class="fa fa-google-plus"></i></a>
        <a href="javascript:void(0);"  class="addthis_button_linkedin blogllinkedin-link" addthis:url="<?php echo get_permalink(); ?>" addthis:title="<?php echo get_the_title(); ?>"><i class="fa fa-linkedin"></i></a>
       
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script>
                <script type="text/javascript">
                    var addthis_config = addthis_config||{};
                    addthis_config.data_track_addressbar = false;
                    addthis_config.data_track_clickback = false;
                </script>
--------------------------------------------------------------------------------------------------------




THEME OPTION 
LOGO Image File upload	
<tr valign="top">
                        <td scope="row">
                            <label for="rct_options_logo"><?php _e( 'Logo', 'rct' ) ?></label>
                        </td>
                        <td>
                        <?php
                            $html = '';
                            
                            $html .= "<div class='file-input-advanced'>";
                            $html .= "<input type='text' name='rct_options[rct_logo]' value='".$rct_logo."' style='width:40%;' class='rct-upload-file-link' placeholder='http://'/>";
                            $html .= "<span class='rct-upload-files'><a class='rct-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','rct')."</a></span>";
                            $html .= "</div><!-- End .file-input-advanced -->";
                            
                            echo $html;
                        ?>
                        </td>
                    </tr>




META CODE 
Select box 	<tr>
        <td>
            <label for="<?php echo $prefix ?>is_home_page"><?php _e( 'Is Home Page', 'botani' ) ?></label>
        </td>
        <td>
            <select name="<?php echo $prefix ?>is_home_page">
                <option value="0" <?php selected( $is_home_page, '0' ) ?>><?php _e( 'No', 'botani' ) ?></option>
                <option value="1" <?php selected( $is_home_page, '1' ) ?>><?php _e( 'Yes', 'botani' ) ?></option>
            </select>
        </td>
    </tr>
Simple Button	<tr>
        <td>
            <label for="<?php echo $prefix ?>button_text"><?php _e( 'Button Text', 'botani' ) ?></label>
        </td>
        <td>
            <input type="text" name="<?php echo $prefix ?>button_text" id="<?php echo $prefix ?>button_text" class="regular-text" value="<?php echo $button_text ?>" />
        </td>
    </tr>
Image upload	<tr>
        <td>
            <label for="botani_home_post_background_image"><?php _e( 'Home Post Background Image ', 'botani' ); ?></label>
        </td>
        <td>
            <div class="file-input-advanced">
                <input type="text" name="<?php echo $prefix ?>home_post_background_image" class="regular-text botani-upload-file-link" value="<?php echo $home_post_background_image; ?>"/>
                <span><a href="javascript:void(o);" class="botani-upload-fileadvanced button">Upload</a></span>                                
            </div>
        </td>
    </tr>
Image upload2	 <tr>
        <td>
            <label for="hainesbros_img_gallery"><?php _e( 'Product Image', 'hainesbros' ) ?></label>
        </td>
        <td>
        <?php
            $html = '';
            if( !empty( $hainesbros_product_image_url ) ) {
                foreach( ( array )$hainesbros_product_image_url as $key => $att ) {
                    if(!empty($att)) {
                        $splitname = pathinfo( $att );
                        $html .= "<div class='file-input-advanced'>";
                        $html .= "<input type='text' name='". $prefix . "product_image_url[]' value='".$att."' style='width:60%;' class='hainesbros-upload-file-link' placeholder='http://'/>";
                        $html .= "<span class='hainesbros-upload-files'><a class='hainesbros-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','hainesbros')."</a></span>";
                        $html .= "</div><!-- End .file-input-advanced -->";
                    }
                }
            } 
            if( empty( $hainesbros_product_image_url[0] ) ) {

                    $html .= "<div class='file-input-advanced'>";
                    $html .= "<input type='text' name='". $prefix . "product_image_url[]' value='' style='width:60%;' class='hainesbros-upload-file-link' placeholder='http://'/>";
                    $html .= "<span class='hainesbros-upload-files'><a class='hainesbros-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','hainesbros')."</a></span>";
                    $html .= "</div><!-- End .file-input-advanced -->";
            }
            echo $html;
        ?>
        </td>
    </tr>


$hainesbros_product_image_url = get_post_meta( $post_id, $prefix . 'product_image_url', true );

Wpeditor in meta 	wp_editor( htmlspecialchars_decode($valueeee2), 'mettaabox_ID_stylee', $settings = array('textarea_name'=>'MyInputNAME') );
    }









Function	desc

Bloginfo()	
wp_title()	wp_title('|', true, 'right');

Get style sheet or any path :

get_stylesheet_uri();	
get_template_directory_uri();



Menu :

wp_list_pages('sort_column=menu_order&depth=1&title_li=')	
wp_nav_menu(array('menu' => 'Main menu'));	
	
Main Function

get_header();
get_sidebar();
get_footer();	
	
IF LOOP

<?php if (have_posts()) : ?>

<?php else: ?>	
<?php endif; ?>	Ternary opertor :

$box_css = ( $i % 3 == 0 ) ? 'padil0' : ( ( $i % 3 == 1 ) ? 'padilr7' : 'padir0' );
	
While LOOP

        <?php while (have_posts()) : the_post(); ?>
        
       <?php endwhile; ?>

	
Content Function

get_the_date();
the_title();
get_permalink();
echo get_the_tag_list('<p>', ', ', '</p>');
comments_number(  '0 Comment', '1 Comment', '% Comments');

  $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID) );
 

$img_url       = wp_get_attachment_image_src( $attachment_id, 'post-thumbnails' );


the_category(', ');
	

get_the_content();
the_excerpt();

the_post_thumbnail( 'full' );	
	
wp_get_recent_posts($args)   	$args = array('numberposts' => '5');
	
TAX QUERY :

<?php
            $args = array(
                'post_type' => VICTORIA_PROJECT_POST_TYPE,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => VICTORIA_PROJECT_POST_TAX,
                        'field' => 'id',
                        'terms' => $terms[0]->term_id
                    )
                ) 
            );
            $the_query = new WP_Query($args);
           
            while ($the_query->have_posts()) : $the_query->the_post();
            //content
            endwhile;
            ?>


	
Demo theme replacement

demotheme->you
DemoTheme
Demo_Theme
Demo Theme
DEMOTHEME	
TAXONOMY COMBO BOX	$terms = get_terms($venue_type);
            $x = '<label>Venue Type</label>';
            $x .= '<select name="' . $venue_type . '" id="' . $venue_type . '">';
                $x .= '<option value="">Select Venue Type</option>';
                foreach ($terms as $term)
                {
                    $x .= '<option value="' . $term->slug . '">' . $term->name . '</option>';
                }
                $x .= '</select>';
                echo $x;
Create New Role    . . add this code before after_setup_theme

	// Staff role
        add_role('saviours_staff', __('Staff', 'saviours'), array(
            'level_9' => true,
            'level_8' => true,
            'level_7' => true,
            'level_6' => true,
            'level_5' => true,
            'level_4' => true,
            'level_3' => true,
            'level_2' => true,
            'level_1' => true,
            'level_0' => true,
            'read' => true,
            'read_private_pages' => true,
            'read_private_posts' => true,
            'edit_users' => true,
            'edit_posts' => true,
            'edit_pages' => true,
            'edit_published_posts' => true,
            'edit_published_pages' => true,
            'edit_private_pages' => true,
            'edit_private_posts' => true,
            'edit_others_posts' => true,
            'edit_others_pages' => true,
            'publish_posts' => true,
            'publish_pages' => true,
            'delete_posts' => true,
            'delete_pages' => true,
            'delete_private_pages' => true,
            'delete_private_posts' => true,
            'delete_published_pages' => true,
            'delete_published_posts' => true,
            'delete_others_posts' => true,
            'delete_others_pages' => true,
            'manage_categories' => true,
            'manage_links' => true,
            'moderate_comments' => true,
            'unfiltered_html' => true,
            'upload_files' => true,
            'export' => true,
            'import' => true,
            'list_users' => true
        ));




Custome Post Type: 
Default Post Types
There are five post types that are readily available to users or internally used by the WordPress installation by default : 
•	Post (Post Type: 'post') 
•	Page (Post Type: 'page') 
•	Attachment (Post Type: 'attachment') 
•	Revision (Post Type: 'revision') 
•	Navigation menu (Post Type: 'nav_menu_item') 




Query :


<?php
         $service_args = array(
        'post_type'      => HDS_SERVICE_POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => 5,
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );
        
        // the query
        $the_query = new WP_Query($service_args);
        
        
        ?>

        <?php if ($the_query->have_posts()) : ?>

            <!-- pagination here -->

            <!-- the loop -->
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                
            <h2><?php the_title(); ?></h2>
                
            <?php endwhile; ?>
            <!-- end of the loop -->

            <!-- pagination here -->

            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <p><?php _e('Sorry, no posts to show.'); ?></p>
       
        <?php endif; ?>


--------------------------------------------------------------------------------------------------------



GET PAGE data 


<?php
        $ourteam = get_post(OUR_TEAM_ID);
        ?>
        <h2><?php echo $ourteam->post_title; ?></h2>
        <?php echo $ourteam->post_excerpt; ?>





Get the data by query of specific POST Type: 

<?php
            // the query
            $the_query = new WP_Query(array('post_type' => 'ourteam', 'post_status' => 'publish'));
            ?>
            <?php if ($the_query->have_posts()) : ?>

                <!-- pagination here -->

                <!-- the loop -->
                <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

                    <div class="col-md-3 text-center team_box">
                        <?php echo the_post_thumbnail('full') ?>
                        <h5> <?php echo the_title() ?>
                        </h5>
                        <?php echo the_content(); ?>
                    </div>

                <?php endwhile; ?>
                <!-- end of the loop -->

                <!-- pagination here -->

                <?php wp_reset_postdata(); ?>

            <?php else : ?>
                <p><?php _e('Sorry, no posts to show.'); ?></p>

            <?php endif; ?>

--------------------------------------------------------------------------------------------------------



GET DAYNAMIC SIDEBAR AND LISTING :

$topLevel = get_pages(array(
        'sort_column' => 'post_date',
        'hierarchical' => 0
        ));

    foreach($topLevel as $page){
        /* register sidebar for each parent page */
        register_sidebar(array(  
          'name' => $page->post_title,  
          'id'   => 'sidebar-'.$page->post_name, 
          'description'   => 'This widget display on page "'.$page->post_title.'"',  
          'before_widget' => '',
          'after_widget'  => '',  
          'before_title'  => '<h1>', 
          'after_title'   => '</h1>', 
        ));
    }

SIDEBAR.php

if (is_home() && get_option('page_for_posts')) {
    
    $blog_page_ID = get_option('page_for_posts');
    $blog_post = get_post( $blog_page_ID );
    $post_name = $blog_post->post_name;
    
} else {
    $post_name = $post->post_name;
}

if ( ! is_active_sidebar( 'sidebar-'.$post_name ) ) {
	return;
}
?>
<div id="content2">

    <?php
    
        dynamic_sidebar('sidebar-'.$post_name);
    

    ?>



--------------------------------------------------------------------------------------------------------



META CODE :

<tr>
        <td>
            <label for="oreva_img_gallery"><?php _e( 'DOWNLOAD URL', 'oreva' ) ?></label>
        </td>
        <td>
        <?php
            $html = '';
            if( !empty( $oreva_catelogue_download_url ) ) {
                foreach( ( array )$oreva_catelogue_download_url as $key => $att ) {
                    if(!empty($att)) {
                        $splitname = pathinfo( $att );
                        $catelogue_title = isset( $oreva_catelogue_title[$key] ) && !empty( $oreva_catelogue_title[$key] ) ? $oreva_catelogue_title[$key] : '';
                        $html .= "<div class='file-input-advanced'>";
                        $html .= "<input type='text' name='". $prefix . "catelogue_title[]' value='".$catelogue_title."' style='width:25%;' class='oreva-download-title' placeholder='Title'/>";
                        $html .= "<input type='text' name='". $prefix . "catelogue_download_url[]' value='".$att."' style='width:60%;' class='oreva-upload-file-link' placeholder='http://'/>";
                        $html .= "<span class='oreva-upload-files'><a class='oreva-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','oreva')."</a></span>";
                        $html .= "<a href='javascript:void(o);' class='oreva-delete-fileadvanced'><img src='".get_template_directory_uri()."/images/delete.png' alt='".__('Delete','oreva')."'/></a>";
                        $html .= "</div><!-- End .file-input-advanced -->";
                    }
                }
            } 
            if( empty( $oreva_catelogue_download_url[0] ) ) {

                    $html .= "<div class='file-input-advanced'>";
                    $html .= "<input type='text' name='". $prefix . "catelogue_title[]' value='' style='width:25%;' class='oreva-download-title' placeholder='Title'/>";
                    $html .= "<input type='text' name='". $prefix . "catelogue_download_url[]' value='' style='width:60%;' class='oreva-upload-file-link' placeholder='http://'/>";
                    $html .= "<span class='oreva-upload-files'><a class='oreva-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','oreva')."</a></span>";
                    $html .= "<a href='javascript:void(o);' class='oreva-delete-fileadvanced'><img src='".get_template_directory_uri()."/images/delete.png' alt='".__('Delete','oreva')."'/></a>";
                    $html .= "</div><!-- End .file-input-advanced -->";
            }

            $html .= "<a class='oreva-meta-add-fileadvanced button' href='javascript:void(o);'>" . __( 'Add more', 'oreva' ) . "</a>";
            echo $html;
        ?>
        </td>
    </tr>





META IMAGES :

<tr>
        <td>
            <label for="hainesbros_img_gallery"><?php _e( 'Product Image', 'hainesbros' ) ?></label>
        </td>
        <td>
        <?php
            $html = '';
            if( !empty( $hainesbros_product_image_url ) ) {
                foreach( ( array )$hainesbros_product_image_url as $key => $att ) {
                    if(!empty($att)) {
                        $splitname = pathinfo( $att );
                        $html .= "<div class='file-input-advanced'>";
                        $html .= "<input type='text' name='". $prefix . "product_image_url[]' value='".$att."' style='width:60%;' class='hainesbros-upload-file-link' placeholder='http://'/>";
                        $html .= "<span class='hainesbros-upload-files'><a class='hainesbros-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','hainesbros')."</a></span>";
                        $html .= "</div><!-- End .file-input-advanced -->";
                    }
                }
            } 
            if( empty( $hainesbros_product_image_url[0] ) ) {

                    $html .= "<div class='file-input-advanced'>";
                    $html .= "<input type='text' name='". $prefix . "product_image_url[]' value='' style='width:60%;' class='hainesbros-upload-file-link' placeholder='http://'/>";
                    $html .= "<span class='hainesbros-upload-files'><a class='hainesbros-upload-fileadvanced button' href='javascript:void(0);'>".__( 'Upload','hainesbros')."</a></span>";
                    $html .= "</div><!-- End .file-input-advanced -->";
            }
            echo $html;
        ?>
        </td>
    </tr>


$hainesbros_product_image_url = get_post_meta( $post_id, $prefix . 'product_image_url', true );

--------------------------------------------------------------------------------------------------------

REMOVE ADD TO CART BUTTON TO WHOLE SITE :


remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );

remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );

--------------------------------------------------------------------------------------------------------

TAXonomy QUERY for fetch and with images:

<?php
            $Service_tax_args = array(
                'hide_empty' => 0,
            );

            $categories = get_terms(HAINESBROS_SERVICES_POST_TAX, $Service_tax_args);
            ?>


            <?php
            $count = count($categories);
            if ($count > 0)
            {
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12 loader-images">
                    <?php
                    foreach ($categories as $term)
                    {
                        ?>
                        <div class = "col-md-3 col-sm-6 col-xs-12 loader">
                            <a href = "#">
                                <div class = "loader-title">
                                    <h6><?php echo $term->name; ?></h6>
                                </div>
                                <div class = "loader-img">
                                    <img src="<?php echo z_taxonomy_image_url($term->term_id); ?>" />
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>



--------------------------------------------------------------------------------------------------------




EXCERPT FUNCTION TO ADD >>>>>>

if (!function_exists('get_excerpt'))
{

    function get_excerpt($limit, $source = null)
    {

        if ($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
        $excerpt = preg_replace(" (\[.*?\])", '', $excerpt);
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = strip_tags($excerpt);
        $excerpt = substr($excerpt, 0, $limit);
        $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
        $excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));
//        $excerpt = $excerpt . '... <a href="' . get_permalink($post->ID) . '">more</a>';
        return $excerpt;
    }

}

get_excerpt(140, 'content'); //excerpt is grabbed from get_the_content
This tells the function that you want the first 140 characters from the_content, regardless of whether an excerpt is set in the_excerpt box.
get_excerpt(140); //excerpt is grabbed from get_the_excerpt
This tells the function that you want the first 140 characters from the_excerpt first, where no excerpt exists, the_content will be used as a fallback.

--------------------------------------------------------------------------------------------------------


HEADER SECTION META 

    add_meta_box('maple_header_section_meta', __('Header Section Options', 'maple'), 'maple_header_section_meta_options_page', MAPLE_PAGE_POST_TYPE, 'normal', 'high');

function expat_header_section_meta_options_page()
{

    include get_template_directory() . '/includes/custom-header-section-meta.php';
}

Add file   custom-header-section-meta.php

Save code


    // Check post type is product
    if (isset($_POST['post_type']) && SPE_PAGE_POST_TYPE == $_POST['post_type'])
    {

        if (isset($_POST[$prefix . 'header_disable']))
        {
            update_post_meta($post_id, $prefix . 'header_disable', spe_escape_slashes_deep($_POST[$prefix . 'header_disable']));
        }
        if (isset($_POST[$prefix . 'header_title']))
        {
            update_post_meta($post_id, $prefix . 'header_title', spe_escape_slashes_deep($_POST[$prefix . 'header_title'], true));
        }
        if (isset($_POST[$prefix . 'header_image']))
        {
            update_post_meta($post_id, $prefix . 'header_image', spe_escape_slashes_deep($_POST[$prefix . 'header_image'], true));
        }
       
    }




Include js featured-img-script.js 
Change prefix and enque in the admin script 



<?php
                if (!is_front_page() && ( is_page() || is_single() || is_home() || is_category() ))
                {

                    $prefix = EXPAT_META_PREFIX;

                    $post_id = ( is_home() || is_singular(MAPLE_POST_POST_TYPE) ) || is_category() ? MAPLE_BLOG_PAGE_ID : $post->ID;
//            $post_id = ( is_singular(OEL_SERVICES_POST_TYPE) ) ? OEL_SERVICES_PAGE_ID : $post->ID;

                    $post_id = ( is_singular(MAPLE_TEAM_POST_TYPE) ) ? MAPLE_ABOUT_PAGE_ID : $post->ID;


                    $header_disable = get_post_meta($post_id, $prefix . 'header_disable', true);

                    $header_title = get_post_meta($post_id, $prefix . 'header_title', true);
                    $header_title = !empty($header_title) ? $header_title : get_the_title();



                    $header_image = get_post_meta($post_id, $prefix . 'header_image', true);
                    $header_image_data = !empty($header_image) ? wp_get_attachment_image_src($header_image, 'full') : '';
                    $header_image_url = !empty($header_image_data[0]) ? $header_image_data[0] : '';

                    if ($header_disable != '1')
                    {
                        ?>
                        <div id="mid">
                            <div class ="hero-section"> 
                                <?php
                                if (!empty($header_image_url))
                                {
                                    ?>
                                    <img src="<?php echo $header_image_url ?>" alt="">
                                    <?php
                                    if (!empty($header_title))
                                    {
                                        ?>
                                        <div class="header-text about-us-header-text">


                                            <h2><?php echo $header_title ?></h2>


                                        </div>
                                        <!--page-title end-->
                                    <?php } ?>
                                </div>
                                <!--header end-->
                            <?php } ?>

                            <?php
                        }
                    }
                    ?>

--------------------------------------------------------------------------------------------------------

Category META
 cUSTOME 

http://wordpress.stackexchange.com/questions/112866/adding-colorpicker-field-to-category

COLOR  PICKER ADD IN WORDPRESS

// Enqueu built-in style for color picker.
  if( wp_style_is( 'wp-color-picker', 'registered' ) ) { //since WordPress 3.5
   wp_enqueue_style( 'wp-color-picker' );
  } else {
   wp_enqueue_style( 'farbtastic' );
  }
// Enqueu built-in script for color picker.
  if( wp_script_is( 'wp-color-picker', 'registered' ) ) { //since WordPress 3.5
   wp_enqueue_script( 'wp-color-picker' );
  } else {
   wp_enqueue_script( 'farbtastic' );
  }

Then
  jQuery('.colorpicker').wpColorPicker();


use: 
<div class="form-field">
        <label for="expatposttax_custom_color">Title Bg Color</label>
        <input name="cat_meta[catBG]" class="colorpicker" type="text" value="" />
        <p class="description">Pick a Country Background Color</p>
    </div> . 

--------------------------------------------------------------------------------------------------------

WORDPRESS AJAX

1 .Make  localize script to make variable Custom-scripts.php

wp_localize_script( 'farmtoyou-public-script', 'FarmtoyouPublic', array(
'ajaxurl'   => admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ),


2 . Put the ajax on the public-script.php
$(".venuserch-btn").click(function () {


        var type = $(this).parents(".venue-filterbox").find("#elegantfarevenuetype option:selected").attr("data-id");
        var location = $(this).parents(".venue-filterbox").find("#elegantfarevenuelocation option:selected").attr("data-id");
        var seating = $(this).parents(".venue-filterbox").find("#elegantfarevenueseating option:selected").attr("data-id");
        var people = $(this).parents(".venue-filterbox").find("#elegantfarevenuepeople option:selected").attr("data-id");

        jQuery.post(
                ElegantFarePublic.ajaxurl,
                {
                    action: 'add_venue_location',
                    type: type,
                    location: location,
                    seating: seating,
                    people: people
                },
        function (response) {
           //  alert(response);
                           $('.venue-boxes').html(response);
        }
        );

    });


});


3. Put the Script to the header  
  <script type="text/javascript">
            var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
   </script>

4 .Start the code in the custom-function.php
   global $post;
ob_start();

$result = ob_get_clean();
    echo $result;
    exit();
5 .add two action : 

add_action('wp_ajax_add_venue_location', 'ajax_add_venue_location');
add_action('wp_ajax_nopriv_add_venue_location', 'ajax_add_venue_location');
--------------------------------------------------------------------------------------------------------
ISOTOPE ADD FILTER : 

Add enque : 
// Load isotrope script
wp_enqueue_script( 'sonarsource-jquery.isotope.min', get_template_directory_uri() . '/js/jquery.isotope.min.js', array(), NULL );

ADD js : 
jquery.isotope.min.js TO JS FOLDER 

Code : 
/**
 * Register [odintext_usecases_filter] shortcode
 */
function odintext_usecases_filter($atts)
{
    global $post;
    $prefix = ODINTEXT_META_PREFIX;

    extract(shortcode_atts(array(
        'columns' => '2'
                    ), $atts));

    ob_start();


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
        'taxonomy' => ODINTEXT_USE_CASE_POST_CAT,
        'pad_counts' => false
    );
    $categories = get_categories($args);

    $usecase_args = array(
        'post_type' => ODINTEXT_USE_CASE_POST_TYPE,
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    $usecase_query = new WP_Query($usecase_args);

    if ($usecase_query->have_posts() && !empty($categories))
    {
        ?>
        <ul id="filters" class="option-set gallerytab" data-option-key="filter">
            <li><a class="active" data-option-value="*" href="#filter"><?php _e('All', 'odintext'); ?></a></li>
            <?php
            foreach ($categories as $cat)
            {
                ?>
                <li><a data-option-value=".<?php echo $cat->slug; ?>" href="#filter"><?php echo $cat->name; ?></a></li>
            <?php } ?>
        </ul>



        <div class="usecases-continer">
            <?php
            $prefix = ODINTEXT_META_PREFIX;
            while ($usecase_query->have_posts()) : $usecase_query->the_post();
                $id = $post->ID;

                $usecase_video_url = get_post_meta($id, $prefix . 'usecase_video_url', true);
                $usecase_video_url = !empty($usecase_video_url) ? $usecase_video_url : '';

                $usecase_pdf_url   = get_post_meta( $post_id, $prefix . 'usecase_pdf_url', true );
                $usecase_pdf_url   = !empty( $usecase_pdf_url ) ? odintext_escape_attr( $usecase_pdf_url ) : '';
                
                $cat_name = wp_get_object_terms($id, ODINTEXT_USE_CASE_POST_CAT, array('fields' => 'slugs'));
                $cat_orginal_name = wp_get_object_terms($id, ODINTEXT_USE_CASE_POST_CAT, array('fields' => 'names'));

                $cat_name = !empty($cat_name) ? $cat_name : array();
                $cat_orginal_name = !empty($cat_orginal_name) ? $cat_orginal_name : array();

                $cat_name[] = 'all';
                $cat_name = implode('  ', $cat_name);

                // $cat_orginal_name = implode(' , ', $cat_orginal_name);
                $attachment_id = get_post_thumbnail_id($id);

                $img_url = wp_get_attachment_image_src($attachment_id, 'large');
                if (empty($img_url))
                {
                    $img_url[0] = get_template_directory_uri() . '/images/default.jpg';
                }
                ?>
                <div class="gallery-box element <?php echo $cat_name; ?>">

                    <?php
                    if (!empty($usecase_video_url))
                    {
                        ?><a class="fancybox" data-type="iframe" href="<?php echo $usecase_video_url; ?>"
                           title="<?php the_title(); ?>">

                            <div class="gallery-bimg">
                                <?php
                                if (!empty($img_url))
                                {
                                    ?>
                                    <img src="<?php echo $img_url[0]; ?>" alt="">
                                <?php }
                                ?>
                            </div>
                        </a>
                        <?php
                    } else
                    {
                        ?>
                        <div class="gallery-bimg">
                            <?php
                            if (!empty($img_url))
                            {
                                ?>
                                <img src="<?php echo $img_url[0]; ?>" alt="">
                            <?php }
                            ?>
                        </div>
                    <?php }
                    ?>

                    <div class="gallery-btext">
                        <h4><?php the_title(); ?></h4>
                        <?php
                        if (!empty($cat_orginal_name))
                        {
                            ?>
                            <div class="gallery-bcatname">

                                <?php
                                foreach ($cat_orginal_name as $key => $value):
                                    ?>
                                    <span
                                        class="<?php echo strtolower(str_replace(' ', '_', $value)); ?>"><?php echo $value; ?></span>
                                        <?php
                                    endforeach;
                                    ?>

                            </div>
                        <?php } ?>
                        
                        
                        
                    </div>

                </div>

                <?php
            endwhile;
            ?>
        </div>
        <?php
    }
    ?>

    <?php
    $html = ob_get_clean();

    return $html;
}

----------------------------------------------------------------------------------------------------
Add extra filed to user
/*
 * Show extra user profile fields
 */
function hsboard_show_extra_profile_fields( $user ) {
    $fb_profile         = get_the_author_meta( 'fb_profile', $user->ID );
    $twitter_profile    = get_the_author_meta( 'twitter_profile', $user->ID );
    $gp_profile         = get_the_author_meta( 'gp_profile', $user->ID );
?>
	<h3>Extra profile information</h3>
	<table class="form-table">
            <tr>
                <th><label for="fb_profile">Facebook</label></th>
                <td>
                    <input type="text" name="fb_profile" id="fb_profile" value="<?php echo esc_attr( $fb_profile ); ?>" class="regular-text" /><br />
                    <span class="description">Please enter your Facebook URL.</span>
                </td>
            </tr>
            <tr>
                <th><label for="twitter_profile">Twitter</label></th>
                <td>
                    <input type="text" name="twitter_profile" id="twitter_profile" value="<?php echo esc_attr( $twitter_profile ); ?>" class="regular-text" /><br />
                    <span class="description">Please enter your Twitter URL.</span>
                </td>
            </tr>
            <tr>
                <th><label for="gp_profile">Google plus</label></th>
                <td>
                    <input type="text" name="gp_profile" id="gp_profile" value="<?php echo esc_attr( $gp_profile ); ?>" class="regular-text" /><br />
                    <span class="description">Please enter your Google Plus URL.</span>
                </td>
            </tr>
	</table>
<?php
}

/*
 * Save extra user profile fields
 */
function hsboard_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }

    update_usermeta( $user_id, 'fb_profile', $_POST['fb_profile'] );
    update_usermeta( $user_id, 'twitter_profile', $_POST['twitter_profile'] );
    update_usermeta( $user_id, 'gp_profile', $_POST['gp_profile'] );
}

//add action to show extra user profile fields
add_action( 'show_user_profile', 'hsboard_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'hsboard_show_extra_profile_fields' );

//add action to save extra user profile fields
add_action( 'personal_options_update', 'hsboard_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'hsboard_save_extra_profile_fields' );
