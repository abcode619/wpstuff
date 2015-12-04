<?php

// require_once( get_template_directory() . '/timeline-widget.php' );



$theme = wp_get_theme();

define( 'THEME_URI', get_template_directory_uri() );
define( 'THEME_DIR', get_template_directory() );
define( 'THEME_VERSION', $theme->get('Version') );

add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($text) {
  return '';
}

//add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function custom_excerpt_length( $length ) {
  return 55;
}

add_action( 'after_setup_theme', 'theme_setup' );
function theme_setup() {
	// Theme Support
  add_theme_support( 'post-thumbnails' );

  // Thumb Size
  add_image_size( 'featured-slide', 410, 210, true );
  add_image_size( 'post-thumb', 600, false );



  // Menu
	register_nav_menu( 'primary', 'Primary Menu' );
  register_nav_menu( 'secondary', 'Secondary Menu' );

  // Widget
  add_filter('widget_text', 'do_shortcode');
  add_filter('widget_execphp', 'do_shortcode');


  register_sidebar(array(
    'id' => 'blog-sidebar',
    'name' =>  'Blog Sidebar',
    'description' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="widget-title">',
    'after_title' => '</div>',
  ));
  // register_sidebar(array(
  //   'id' => 'page-sidebar',
  //   'name' =>  'Page Sidebar',
  //   'description' => '',
  //   'before_widget' => '<div id="%1$s" class="widget %2$s">',
  //   'after_widget' => '</div>',
  //   'before_title' => '<div class="widget-title">',
  //   'after_title' => '</div>',
  // ));
  register_sidebar(array(
    'id' => 'footer-1',
    'name' =>  'Footer #1',
    'description' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="widget-title">',
    'after_title' => '</div>',
  ));
  register_sidebar(array(
    'id' => 'footer-2',
    'name' =>  'Footer #2',
    'description' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="widget-title">',
    'after_title' => '</div>',
  ));
  register_sidebar(array(
    'id' => 'footer-3',
    'name' =>  'Footer #3',
    'description' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="widget-title">',
    'after_title' => '</div>',
  ));
  register_sidebar(array(
    'id' => 'footer-4',
    'name' =>  'Footer #4',
    'description' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="widget-title">',
    'after_title' => '</div>',
  ));
  register_sidebar(array(
    'id' => 'footer-5',
    'name' =>  'Footer #5',
    'description' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="widget-title">',
    'after_title' => '</div>',
  ));


  	if( !is_admin() ) {
		// Style        
    wp_enqueue_style( 'flexslider', THEME_URI . '/styles/flexslider.css', true, THEME_VERSION );
    
    // Load our main stylesheet.
    wp_enqueue_style( 'main-style', get_stylesheet_uri() );

    wp_enqueue_style( 'normalize', THEME_URI . '/styles/normalize.css' );
		wp_enqueue_style( 'bootstrap-grid', THEME_URI . '/styles/bootstrap-grid.css' );
    
    wp_enqueue_style( 'font-awesome', THEME_URI . '/styles/font-awesome.min.css', true, THEME_VERSION );
    wp_enqueue_style( 'fancybox', THEME_URI . '/libraries/fancybox/jquery.fancybox-1.3.4.css', true, THEME_VERSION );
    wp_enqueue_style( 'screen', THEME_URI . '/styles/screen.css', true, THEME_VERSION );
    wp_enqueue_style( 'media-queries', THEME_URI . '/styles/media-queries.css', true, THEME_VERSION );
    

		// Scripts
		wp_enqueue_script('jquery');
	  	wp_enqueue_script('common');
      wp_enqueue_script('fitvids', THEME_URI . '/libraries/jquery.fitvids.js', false, 1, true );
      wp_enqueue_script('fancybox', THEME_URI . '/libraries/fancybox/jquery.fancybox-1.3.4.pack.js', false, 1, true );
       wp_enqueue_script('masonry', THEME_URI . '/libraries/masonry.pkgd.min.js', false, 1, true );
        wp_enqueue_script('transit', THEME_URI . '/libraries/jquery.transit.min.js', false, 1, true );
      wp_enqueue_script('flexslider', THEME_URI . '/libraries/jquery.flexslider.js', false, 1, true );
      wp_enqueue_script('script', THEME_URI . '/libraries/script.js', false, 1, true );
	  	wp_enqueue_script('custom', THEME_URI . '/libraries/custom.js', false, THEME_VERSION, true );
	}
  
}

// Space Shortcode
add_shortcode('space', 'theme_space');
function theme_space($atts, $content = null, $code) {
    extract(shortcode_atts(array(
      'size' => '20',
    ), $atts));
    return '<div class="vspace" style="padding: '.($size/2).'px 0;"></div>';
}

// Clear
add_shortcode('clear', 'theme_clear');
function theme_clear($atts, $content = null, $code) {
  return '<div class="clear"></div>';
}

// Image Text
add_shortcode('image_text', 'theme_image_text');
function theme_image_text($atts, $content = null, $code) {
    extract(shortcode_atts(array(
      'image' => '',
      'title' => '',
      'link_url' => '',
      'link_text' => '',
      'description' => ''
    ), $atts));
    return '<div class="col-md-6 col-sm-6 image_text"><a href="'.$link_url.'"><image src="'.$image.'" /></a><div class="title">'.$title.'</div><p>'.$description.'</p><p><a href="'.$link_url.'">'.$link_text.'</a></p></div>';
}

// Image Text with Order
add_shortcode('image_text_order', 'theme_image_text_order');
function theme_image_text_order($atts, $content = null, $code) {
    extract(shortcode_atts(array(
      'image' => '',
      'title' => '',
      'order' => '',
      'description' => ''
    ), $atts));
    return '<div class="image_text_order"><div class="inner"><image src="'.$image.'" /><div class="title"><span class="order">'.$order.'</span> '.$title.'</div><p>'.$description.'</p></div></div>';
}

//move wpautop filter to AFTER shortcode is processed
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99);
add_filter( 'the_content', 'shortcode_unautop',100 );


// SECTION
add_shortcode('section', 'theme_section');
function theme_section($atts, $content = null, $code) {
    extract(shortcode_atts(array(
      'bg' => '#fff',
      'color' => '',
      'padding' => true
    ), $atts));
    $padding_style = ($padding)?'':'padding: 0;';
    return '<section class="full-width" style="background:'.$bg.'; color:'.$color.'; '.$padding_style.'">'.do_shortcode($content).'</section>';
}
// ROW
add_shortcode('row', 'theme_row');
function theme_row($atts, $content = null, $code) {
    extract(shortcode_atts(array(
    ), $atts));
    return '<div class="row">'.do_shortcode($content).'</div>';
}
// COL
add_shortcode('col', 'theme_col');
function theme_col($atts, $content = null, $code) {
    extract(shortcode_atts(array(
      'cols' => 4
    ), $atts));
    return '<div class="col-md-'.$cols.'">'.do_shortcode($content).'</div>';
}
// BOX
add_shortcode('box', 'theme_box');
function theme_box($atts, $content = null, $code) {
    extract(shortcode_atts(array(
    ), $atts));
    return '<div class="box">'.do_shortcode($content).'</div>';
}

// CTA SHORTCODE 
add_shortcode('ctabutton', 'theme_ctabutton');
function theme_ctabutton($atts, $content = null, $code) {
    extract(shortcode_atts(array(
      'bg' => '#20ae3b',
      'color' => '#fff',
      'size' => 'medium',
      'link' => '#',
      'display' => 'inline-block'
    ), $atts));
    $padding_style = ($padding)?'':'padding: 0;';
    return '<a href="'.$link.'" class="cta-button '.$size.' '.$display.'" style="background-color:'.$bg.'; color:'.$color.'; display:'.$display.'; ">'.do_shortcode($content).'</a>';
}


// FAQs
register_post_type('faqs', array(  'label' => 'faqs','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => 'faqs', 'with_front' => false),'query_var' => true,'has_archive' => false,'exclude_from_search' => false,'supports' => array('title', 'editor'),'taxonomies' => array(),'labels' => array (
'name' => 'FAQs',
'singular_name' => 'FAQs',
'menu_name' => 'FAQs',
'add_new' => 'Add FAQs',
'add_new_item' => 'Add New FAQs',
'edit' => 'Edit',
'edit_item' => 'Edit FAQs',
'new_item' => 'New FAQs',
'view' => 'View FAQs',
'view_item' => 'View FAQs',
'search_items' => 'Search FAQs',
'not_found' => 'No FAQs Found',
'not_found_in_trash' => 'No FAQs Found in Trash',
'parent' => 'Parent FAQs',
),) );

// Press
register_post_type('testimonial', array(  'label' => 'testimonial','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => 'testimonial', 'with_front' => false),'query_var' => true,'has_archive' => false,'exclude_from_search' => false,'supports' => array('title', 'editor'),'taxonomies' => array(),'labels' => array (
'name' => 'Testimonial',
'singular_name' => 'Testimonial',
'menu_name' => 'Testimonial',
'add_new' => 'Add Testimonial',
'add_new_item' => 'Add New Testimonial',
'edit' => 'Edit',
'edit_item' => 'Edit Testimonial',
'new_item' => 'New Testimonial',
'view' => 'View Testimonial',
'view_item' => 'View Testimonial',
'search_items' => 'Search Testimonial',
'not_found' => 'No Testimonial Found',
'not_found_in_trash' => 'No Testimonial Found in Trash',
'parent' => 'Parent Testimonial',
),) );

// Add-ons 
//define( 'ACF_LITE', true );
include_once('add-ons/advanced-custom-fields/acf.php');
include_once('add-ons/acf-repeater/acf-repeater.php');
include_once( 'add-ons/acf-options-page/acf-options-page.php' );


function excerpt_read_more_link($output) {
 global $post;
 return $output . '<a href="'. get_permalink($post->ID) . '"> Read More...</a>';
}
add_filter('the_excerpt', 'excerpt_read_more_link');

?>