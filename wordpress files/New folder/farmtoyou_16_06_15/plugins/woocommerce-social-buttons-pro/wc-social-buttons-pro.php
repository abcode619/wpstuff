<?php

/*
Plugin Name: WooCommerce Social Buttons PRO
Plugin URI: http://terrytsang.com/shop/shop/woocommerce-social-buttons-pro/
Description: Add social sharing buttons on woocommerce product page with flexible options
Version: 1.1.0
Author: Terry Tsang
Author URI: http://terrytsang.com/shop
*/

/*  
Copyright 2012-2015 Terry Tsang (email: terrytsang811@gmail.com)
License: Single Site
*/


// Define plugin name.
define('wc_social_buttons_pro_plugin_name', 'WooCommerce Social Buttons PRO');

// Checks if the WooCommerce plugins is installed and active.
if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){
	if(!class_exists('WooCommerce_Social_Buttons_PRO')){
		class WooCommerce_Social_Buttons_PRO{

			public static $plugin_prefix;
			public static $plugin_url;
			public static $plugin_path;
			public static $plugin_basefile;

			var $tab_name;
			var $hidden_submit;
			var $current_tab;
			
			var $field_options;
			var $field_types;
			
			/**
			 * initialize this plugin
			 */
			public function __construct(){
				global $woocommerce;
				
				self::$plugin_prefix = 'wc_social_buttons_pro_';
				self::$plugin_basefile = plugin_basename(__FILE__);
				self::$plugin_url = plugin_dir_url(self::$plugin_basefile);
				self::$plugin_path = trailingslashit(dirname(__FILE__));
				
				$this->tab_name = 'wc-social-buttons-pro';
				$this->hidden_submit = self::$plugin_prefix . 'submit';
				
				$this->field_options = array('enabled', 'order');
				$this->field_types = array('facebook', 'twitter', 'googleplus', 'pinterest', 'linkedin', 'stumbleupon', 'tumblr', 'fancy', 'svpply', 'email');
				
				$this->display_positions = array( 'default' => __( 'Default', 'woocommerce-social-buttons-pro' ), 'after_title' => __( 'After Product Title', 'woocommerce-social-buttons-pro' ), 'after_price' => __( 'After Product Price', 'woocommerce-social-buttons-pro' ), 'after_short_desc' => __( 'After Short Desc', 'woocommerce-social-buttons-pro' ), 'after_meta' => __( 'After SKU,Categories & Tags', 'woocommerce-social-buttons-pro' ));
				$this->fancy_categories = array( 
						"Men's" => __( "Men's", 'woocommerce-social-buttons-pro' ), 
						"Women's" => __( "Women's", 'woocommerce-social-buttons-pro' ), 
						"Kids" => __( "Kids", 'woocommerce-social-buttons-pro' ), 
						"Pets" => __( "Pets", 'woocommerce-social-buttons-pro' ), 
						"Home" => __( "Home", 'woocommerce-social-buttons-pro' ), 
						"Gadgets" => __( "Gadgets", 'woocommerce-social-buttons-pro' ), 
						"Art" => __( "Art", 'woocommerce-social-buttons-pro' ), 
						"Food" => __( "Food", 'woocommerce-social-buttons-pro' ), 
						"Media" => __( "Media", 'woocommerce-social-buttons-pro' ), 
						"Architecture" => __( "Architecture", 'woocommerce-social-buttons-pro' ), 
						"Travel &amp; Destinations" => __( "Travel &amp; Destinations", 'woocommerce-social-buttons-pro' ),
						"Sports &amp; Outdoors" => __( "Sports &amp; Outdoors", 'woocommerce-social-buttons-pro' ),
						"DIY &amp; Crafts" => __( "DIY &amp; Crafts", 'woocommerce-social-buttons-pro' ),
						"Workspace" => __( "Workspace", 'woocommerce-social-buttons-pro' ),
						"Cars &amp; Vehicles" => __( "Cars &amp; Vehicles", 'woocommerce-social-buttons-pro' ),
						"Other" => __( "Other", 'woocommerce-social-buttons-pro' )
				);
				
				add_action('woocommerce_init', array(&$this, 'init'));

			}
			
			/**
			 * Load stylesheet for the page
			 */
			public function custom_plugin_stylesheet() {
				wp_register_style( 'social-buttons-stylesheet', plugins_url('/css/social.css', __FILE__) );
				wp_enqueue_style( 'social-buttons-stylesheet' );
				
				$social_buttons_display_lightbox	= get_option( 'social_buttons_display_lightbox' );
				if($social_buttons_display_lightbox)
				{
					wp_register_style( 'social-buttons-display', plugins_url('/css/basic.css', __FILE__) );
					//wp_register_style( 'social-buttons-display-ie', plugins_url('/css/basic_ie.css', __FILE__) );
					wp_enqueue_style( 'social-buttons-display' );
					//wp_enqueue_style( 'social-buttons-display-ie' );
				}
			}
			
			/**
			 * Load javascripts for the page
			 */
			public function custom_plugin_javascript() {
				wp_register_script( 'social-buttons-modal-js', plugins_url('/js/jquery.simplemodal.js', __FILE__), array('jquery') );
				wp_register_script( 'social-buttons-js', plugins_url('/js/basic.js', __FILE__) );
				wp_enqueue_script( 'social-buttons-modal-js' );
				wp_enqueue_script( 'social-buttons-js' );
			}

			
			/**
			 * Init WooCommerce Social Buttons PRO
			 */
			public function init(){
				global $woocommerce;
				
				//include
				$this->includes();
				
				//load stylesheet
				add_action( 'wp_enqueue_scripts', array(&$this, 'custom_plugin_stylesheet') );
				
				$social_buttons_display_lightbox = get_option( 'social_buttons_display_lightbox' );
				if($social_buttons_display_lightbox)
				{
					add_action( 'wp_enqueue_scripts', array(&$this, 'custom_plugin_javascript') );
				}
				
				//add menu link
				add_action( 'admin_menu', array( &$this, 'add_menu_socialbuttons' ) );
				
				//add sharing media at product summary page 
				$default_position = get_option('social_buttons_display_position');
				
				$position_index = 100;
				switch($default_position)
				{
					case 'default':
						$position_index = 100;
						break;
					case 'after_title':
						$position_index = 8;
						break;
					case 'after_price':
						$position_index = 15;
						break; 
					case 'after_short_desc':
						$position_index = 30;
						break;
					case 'after_meta':
						$position_index = 45;
						break;
				}
				add_action( 'woocommerce_single_product_summary', array( &$this, 'social_buttons_widget' ), $position_index );
				
				//add og meta - image_src link for facebook thumbnail generation
				add_action( 'wp_head', array( &$this, 'add_og_meta' ) );
				
				//add extra javascript code before </body> 
				add_action( 'wp_footer', array( &$this, 'add_javascript_body' ) );

				$social_buttons_post_page = get_option('social_buttons_post_page');
				if($social_buttons_post_page)
					add_filter( 'the_content', array( &$this, 'postpage_socialbuttons_widget' ) );

				add_shortcode( 'socialbuttonspro', array( $this, 'social_buttons_widget') );
				add_filter( 'widget_text', 'do_shortcode' );
			}
			
			public function includes()
			{
				include_once( 'includes/languages.php');
				include_once( 'includes/languages_plus.php');
			}
			
			public function add_og_meta()
			{
			global $post;
			$post_object = get_post( $post->ID );
			$post_content = esc_attr(strip_tags(substr($post_object->post_content, 0, 100)));
			?>
				<?php if (is_single()) { ?>  
				<link rel="image_src" href="<?php if (function_exists('wp_get_attachment_thumb_url')) {echo wp_get_attachment_thumb_url(get_post_thumbnail_id($post->ID)); } ?>" />
				<meta property="og:url" content="<?php the_permalink() ?>"/>  
				<meta property="og:title" content="<?php single_post_title(''); ?>" />  
				<meta property="og:description" content="<?php echo $post_content; ?>" />  
				<meta property="og:type" content="product" />  
				<meta property="og:image" content="<?php if (function_exists('wp_get_attachment_thumb_url')) {echo wp_get_attachment_thumb_url(get_post_thumbnail_id($post->ID)); }?>" />  
				<?php } 
			}
			
			public function add_javascript_body()
			{
				$social_buttons_javascript_body = "";
				$social_buttons_javascript_body = get_option( 'social_buttons_javascript_body' );
				
				$this->options = $this->get_options();
				
				$social_buttons_fb_language = $this->options['social_buttons_fb_language'];
					
				if ( ! $social_buttons_fb_language )
					$social_buttons_fb_language = 'en_GB';
				
				$social_buttons_plus_language = $this->options['social_buttons_plus_language'];
					
				if ( ! $social_buttons_plus_language )
					$social_buttons_plus_language = 'en-GB';
				
				foreach($this->field_types as $field_type)
				{
					foreach($this->field_options as $option_name)
					{
						$field_name = 'social_buttons_'.$option_name.'_'.$field_type;
						
						$$field_name = $this->options[$field_name];
					}
				}
				
				if ( ! $social_buttons_javascript_body ) 
				{
					if($social_buttons_enabled_facebook)
					{
						$social_buttons_javascript_body .= '
						<div id="fb-root"></div> 
						<script>(function(d, s, id) { 
							var js, fjs = d.getElementsByTagName(s)[0]; 
							if (d.getElementById(id)) return; 
							js = d.createElement(s); js.id = id; 
							js.src = "//connect.facebook.net/'.$social_buttons_fb_language.'/all.js#xfbml=1&appId=54854384568"; 
							fjs.parentNode.insertBefore(js, fjs); 
						}(document, \'script\', \'facebook-jssdk\'));</script>
						';
					}
					
					if($social_buttons_enabled_twitter)
					{
						$social_buttons_javascript_body .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="http://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
					}
					
					if($social_buttons_enabled_googleplus)
					{
						$social_buttons_javascript_body .= '
						<script type="text/javascript">
							window.___gcfg = {
						        lang: \''.$social_buttons_plus_language.'\'
						      };
						
						  (function() {
						    var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
						    po.src = "https://apis.google.com/js/plusone.js";
						    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
						  })();
						</script>
						';
					}
					
					if($social_buttons_enabled_pinterest)
					{
						$social_buttons_javascript_body .= '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>';
					}
					
					if($social_buttons_enabled_linkedin)
					{
						$social_buttons_javascript_body .= '<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>';
					}
					
					if($social_buttons_enabled_stumbleupon)
					{
						$social_buttons_javascript_body .= '
						<script type="text/javascript">
						  (function() {
						    var li = document.createElement(\'script\'); li.type = \'text/javascript\'; li.async = true;
						    li.src = (\'https:\' == document.location.protocol ? \'https:\' : \'http:\') + \'//platform.stumbleupon.com/1/widgets.js\';
						    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(li, s);
						  })();
						</script>
						';
					}
					
					if($social_buttons_enabled_tumblr)
					{
						$social_buttons_javascript_body .= '<script src="http://platform.tumblr.com/v1/share.js"></script>';
					}
					
					if($social_buttons_enabled_fancy)
					{
						$social_buttons_javascript_body .= '<script src="http://www.thefancy.com/fancyit.js" type="text/javascript"></script>';
					}
					
					if($social_buttons_enabled_svpply)
					{
						$social_buttons_javascript_body .= '<script src="//svpply.com/api/all.js#xsvml=1" type="text/javascript"></script>';
					}

				}

				echo $social_buttons_javascript_body;
				
			}
			

			function postpage_socialbuttons_widget( $content )
			{
				// add buttons to content
				return '<div style="height:30px;">'.$this->social_buttons_widget() .'</div>'. $content;
			}
				
			/**
			 * Add a menu link to the woocommerce section menu
			 */
			function add_menu_socialbuttons() {
				$wc_page = 'woocommerce';
				$comparable_settings_page = add_submenu_page( $wc_page , __( 'Social Buttons PRO', $this->tab_name ), __( 'Social Buttons PRO', $this->tab_name ), 'manage_options', 'social-buttons-pro', array(
					&$this,
					'create_settings_page'
				));
			}
			
			
			/**
			 * Create the settings page content
			 */
			public function create_settings_page() {
			 
				// If form was submitted 
				if ( isset( $_POST['submitted'] ) ) 
				{			
					check_admin_referer( $this->tab_name );
					
					$options = array(
							'social_buttons_enabled_facebook' => '',
							'social_buttons_enabled_twitter' => '',
							'social_buttons_enabled_googleplus' => '',
							'social_buttons_enabled_pinterest' => '',
							'social_buttons_enabled_linkedin' => '',
 							'social_buttons_enabled_stumbleupon' => '',
							'social_buttons_enabled_tumblr' => '',
							'social_buttons_enabled_fancy' => '',
							'social_buttons_enabled_svpply' => '',
							'social_buttons_enabled_email' => '',
							'social_buttons_order_facebook' => '',
							'social_buttons_order_twitter' => '',
							'social_buttons_order_googleplus' => '',
							'social_buttons_order_pinterest' => '',
							'social_buttons_order_linkedin' => '',
							'social_buttons_order_stumbleupon' => '',
							'social_buttons_order_tumblr' => '',
							'social_buttons_order_fancy' => '',
							'social_buttons_order_svpply' => '',
							'social_buttons_order_email' => '',
							'social_buttons_display_position' => '',
							'social_buttons_fb_language' => '',
							'social_buttons_plus_language' => '',
							'social_buttons_display_lightbox' => '',
							'social_buttons_fancy_category' => '',
							'social_buttons_enabled_fbshare' => '',
							'social_buttons_post_page' => '',
							'social_buttons_email_to' => ''
					);
					
					$this->options['social_buttons_enabled_facebook'] = ! isset( $_POST['social_buttons_enabled_facebook'] ) ? '1' : $_POST['social_buttons_enabled_facebook'];
					$this->options['social_buttons_enabled_twitter'] = ! isset( $_POST['social_buttons_enabled_twitter'] ) ? '1' : $_POST['social_buttons_enabled_twitter'];
					$this->options['social_buttons_enabled_googleplus'] = ! isset( $_POST['social_buttons_enabled_googleplus'] ) ? '1' : $_POST['social_buttons_enabled_googleplus'];
					$this->options['social_buttons_enabled_pinterest'] = ! isset( $_POST['social_buttons_enabled_pinterest'] ) ? '1' : $_POST['social_buttons_enabled_pinterest'];
					$this->options['social_buttons_enabled_linkedin'] = ! isset( $_POST['social_buttons_enabled_linkedin'] ) ? '1' : $_POST['social_buttons_enabled_linkedin'];
					$this->options['social_buttons_enabled_stumbleupon'] = ! isset( $_POST['social_buttons_enabled_stumbleupon'] ) ? '1' : $_POST['social_buttons_enabled_stumbleupon'];
					$this->options['social_buttons_enabled_tumblr'] = ! isset( $_POST['social_buttons_enabled_tumblr'] ) ? '1' : $_POST['social_buttons_enabled_tumblr'];
					$this->options['social_buttons_enabled_fancy'] = ! isset( $_POST['social_buttons_enabled_fancy'] ) ? '1' : $_POST['social_buttons_enabled_fancy'];
					$this->options['social_buttons_enabled_svpply'] = ! isset( $_POST['social_buttons_enabled_svpply'] ) ? '1' : $_POST['social_buttons_enabled_svpply'];
					$this->options['social_buttons_enabled_email'] = ! isset( $_POST['social_buttons_enabled_email'] ) ? '1' : $_POST['social_buttons_enabled_email'];
						
					$this->options['social_buttons_order_facebook'] = ! isset( $_POST['social_buttons_order_facebook'] ) ? '1' : $_POST['social_buttons_order_facebook'];
					$this->options['social_buttons_order_twitter'] = ! isset( $_POST['social_buttons_order_twitter'] ) ? '2' : $_POST['social_buttons_order_twitter'];
					$this->options['social_buttons_order_googleplus'] = ! isset( $_POST['social_buttons_order_googleplus'] ) ? '3' : $_POST['social_buttons_order_googleplus'];
					$this->options['social_buttons_order_pinterest'] = ! isset( $_POST['social_buttons_order_pinterest'] ) ? '4' : $_POST['social_buttons_order_pinterest'];
					$this->options['social_buttons_order_linkedin'] = ! isset( $_POST['social_buttons_order_linkedin'] ) ? '5' : $_POST['social_buttons_order_linkedin'];
					$this->options['social_buttons_order_stumbleupon'] = ! isset( $_POST['social_buttons_order_stumbleupon'] ) ? '6' : $_POST['social_buttons_order_stumbleupon'];
					$this->options['social_buttons_order_tumblr'] = ! isset( $_POST['social_buttons_order_tumblr'] ) ? '7' : $_POST['social_buttons_order_tumblr'];
					$this->options['social_buttons_order_fancy'] = ! isset( $_POST['social_buttons_order_fancy'] ) ? '8' : $_POST['social_buttons_order_fancy'];
					$this->options['social_buttons_order_svpply'] = ! isset( $_POST['social_buttons_order_svpply'] ) ? '9' : $_POST['social_buttons_order_svpply'];
					$this->options['social_buttons_order_email'] = ! isset( $_POST['social_buttons_order_email'] ) ? '10' : $_POST['social_buttons_order_email'];

					$this->options['social_buttons_display_position'] = ! isset( $_POST['social_buttons_display_position'] ) ? 'default' : $_POST['social_buttons_display_position'];
					$this->options['social_buttons_fb_language'] = ! isset( $_POST['social_buttons_fb_language'] ) ? 'en_GB' : $_POST['social_buttons_fb_language'];
					$this->options['social_buttons_plus_language'] = ! isset( $_POST['social_buttons_plus_language'] ) ? 'en-GB' : $_POST['social_buttons_plus_language'];
					$this->options['social_buttons_display_lightbox'] = ! isset( $_POST['social_buttons_display_lightbox'] ) ? '1' : $_POST['social_buttons_display_lightbox'];
					$this->options['social_buttons_fancy_category'] = ! isset( $_POST['social_buttons_fancy_category'] ) ? 'Other' : $_POST['social_buttons_fancy_category'];
					$this->options['social_buttons_enabled_fbshare'] = ! isset( $_POST['social_buttons_enabled_fbshare'] ) ? '1' : $_POST['social_buttons_enabled_fbshare'];
					$this->options['social_buttons_post_page'] = ! isset( $_POST['social_buttons_post_page'] ) ? '' : $_POST['social_buttons_post_page'];
					$this->options['social_buttons_email_to'] = ! isset( $_POST['social_buttons_email_to'] ) ? '' : $_POST['social_buttons_email_to'];
						
					
					foreach($options as $field => $value)
					{
						$option = get_option( $field );
						
						if($option != $this->options[$field])
							update_option( $field, $this->options[$field] );
					}
					
					// Show message
					echo '<div id="message" class="updated fade"><p>' . __( 'Social Button PRO options saved.', $this->tab_name ) . '</p></div>';
				} 
				
				$this->options = $this->get_options();
				
				foreach($this->field_types as $field_type)
				{
					foreach($this->field_options as $option_name)
					{
						$field_name = 'social_buttons_'.$option_name.'_'.$field_type;
						
						//echo '$field_name :'.$field_name.'---value :'.$this->options[$field_name].'<br />';
						
						$$field_name = $this->options[$field_name];
					}
				}
				
				$social_buttons_display_position	= get_option( 'social_buttons_display_position' );
				$social_buttons_fb_language	= get_option( 'social_buttons_fb_language' );
				$social_buttons_plus_language	= get_option( 'social_buttons_plus_language' );
				$social_buttons_display_lightbox	= get_option( 'social_buttons_display_lightbox' );
				$social_buttons_fancy_category	= get_option( 'social_buttons_fancy_category' );
				$social_buttons_enabled_fbshare	= get_option( 'social_buttons_enabled_fbshare' );
				$social_buttons_post_page	= get_option( 'social_buttons_post_page' );
				$social_buttons_email_to	= get_option( 'social_buttons_email_to' );

				$checked_value1 = '';
				$checked_value2 = '';
				$checked_value3 = '';
				$checked_value4 = '';
				$checked_value5 = '';
				$checked_value6 = '';
				$checked_value7 = '';
				$checked_value8 = '';
				$checked_value9 = '';
				$checked_value10 = '';
				$checked_value11 = '';
				$checked_value12 = '';
				$checked_value13 = '';

				if($social_buttons_enabled_facebook)
					$checked_value1 = 'checked="checked"';	
				
				if($social_buttons_enabled_twitter)
					$checked_value2 = 'checked="checked"';
					
				if($social_buttons_enabled_googleplus)
					$checked_value3 = 'checked="checked"';
				
				if($social_buttons_enabled_pinterest)
					$checked_value4 = 'checked="checked"';
				
				if($social_buttons_enabled_linkedin)
					$checked_value5 = 'checked="checked"';
				
				if($social_buttons_enabled_stumbleupon)
					$checked_value6 = 'checked="checked"';
				
				if($social_buttons_enabled_tumblr)
					$checked_value7 = 'checked="checked"';
				
				if($social_buttons_display_lightbox)
					$checked_value8 = 'checked="checked"';
				
				if($social_buttons_enabled_fancy)
					$checked_value9 = 'checked="checked"';
				
				if($social_buttons_enabled_svpply)
					$checked_value10 = 'checked="checked"';
				
				if($social_buttons_enabled_fbshare)
					$checked_value11 = 'checked="checked"';

				if($social_buttons_post_page)
					$checked_value12 = 'checked="checked"';
				
				if($social_buttons_enabled_email)
					$checked_value13 = 'checked="checked"';

				$actionurl = $_SERVER['REQUEST_URI'];
				$nonce = wp_create_nonce( $this->tab_name );
				
						
				// Configuration Page
						
				?>
				<div id="icon-options-general" class="icon32"></div>
				<h3><?php _e( 'Social Buttons PRO Options', $this->tab_name); ?></h3>
				
				
				<table width="90%" cellspacing="2">
				<tr>
					<td width="70%">
						<form action="<?php echo $actionurl; ?>" method="post">
						<table class="widefat fixed" cellspacing="0">
								<thead>
									<th width="35%"><?php _e( 'Option', 'woocommerce-social-buttons-pro' ); ?></th>
									<th><?php _e( 'Setting', 'woocommerce-social-buttons-pro' ); ?></th>
								</thead>
								<tbody>
									<tr>
										<td><?php _e( 'Display Position', 'woocommerce-social-buttons-pro' ); ?></td>
										<td>
											<select name="social_buttons_display_position">
											<?php foreach($this->display_positions as $option => $option_name): ?>
												<?php if($option == $social_buttons_display_position): ?>
													<option selected="selected" value="<?php echo $option; ?>"><?php echo $option_name; ?></option>
												<?php else: ?>
													<option value="<?php echo $option; ?>"><?php echo $option_name; ?></option>
												<?php endif; ?>
											<?php endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td><?php _e( 'Enabled Lightbox Button (Share/Like)', 'woocommerce-social-buttons-pro' ); ?></td>
										<td>
											<input class="checkbox" name="social_buttons_display_lightbox" id="social_buttons_display_lightbox" value="0" type="hidden">
											<input class="checkbox" name="social_buttons_display_lightbox" id="social_buttons_display_lightbox" value="1" <?php echo $checked_value8; ?> type="checkbox">
										</td>
									</tr>
									<tr>
										<td><?php _e( 'Enabled Facebook Share Button', 'woocommerce-social-buttons-pro' ); ?></td>
										<td>
											<input class="checkbox" name="social_buttons_enabled_fbshare" id="social_buttons_enabled_fbshare" value="0" type="hidden">
											<input class="checkbox" name="social_buttons_enabled_fbshare" id="social_buttons_enabled_fbshare" value="1" <?php echo $checked_value11; ?> type="checkbox">
										</td>
									</tr>
									<tr>
										<td><?php _e( 'Show In Blog Post/Page', 'woocommerce-social-buttons-pro' ); ?></td>
										<td>
											<input class="checkbox" name="social_buttons_post_page" id="social_buttons_post_page" value="0" type="hidden">
											<input class="checkbox" name="social_buttons_post_page" id="social_buttons_post_page" value="1" <?php echo $checked_value12; ?> type="checkbox">
										</td>
									</tr>
									<tr>
										<td colspan="2">
										<table class="widefat fixed" cellspacing="0">
										<thead>
											<th width="20%"><?php _e( 'Social Media', 'woocommerce-social-buttons-pro' ); ?></th>
											<th width="20%"><?php _e( 'Enabled', 'woocommerce-social-buttons-pro' ); ?></th>
											<th width="15%"><?php _e( 'Sort Order', 'woocommerce-social-buttons-pro' ); ?></th>
											<th><?php _e( 'Language', 'woocommerce-social-buttons-pro' ); ?></th>
										</thead>
										<tr>
											<td><img src="<?php echo plugins_url('/images/social_facebook.png', __FILE__); ?>" title="Facebook" alt="Facebook" />&nbsp;Facebook</td>
											<td>
												<input class="checkbox" name="social_buttons_enabled_facebook" id="social_buttons_enabled_facebook" value="0" type="hidden">
												<input class="checkbox" name="social_buttons_enabled_facebook" id="social_buttons_enabled_facebook" value="1" <?php echo $checked_value1; ?> type="checkbox">
											</td>
											<td>
												<input type="text" id="social_buttons_order_facebook" name="social_buttons_order_facebook" value="<?php echo $social_buttons_order_facebook; ?>" size="3" />
											</td>
											<td>
												<select name="social_buttons_fb_language">
												<?php foreach($this->language as $lang_code => $lang_name): ?>
													<?php if($lang_code == $social_buttons_fb_language): ?>
														<option selected="selected" value="<?php echo $lang_code; ?>"><?php echo $lang_name; ?></option>
													<?php else: ?>
														<option value="<?php echo $lang_code; ?>"><?php echo $lang_name; ?></option>
													<?php endif; ?>
												<?php endforeach; ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><img src="<?php echo plugins_url('/images/social_twitter.png', __FILE__); ?>" title="Twitter" alt="Twitter" />&nbsp;Twitter</td>
											<td>
												<input class="checkbox" name="social_buttons_enabled_twitter" id="social_buttons_enabled_twitter" value="0" type="hidden">
												<input class="checkbox" name="social_buttons_enabled_twitter" id="social_buttons_enabled_twitter" value="1" <?php echo $checked_value2; ?> type="checkbox">
											</td>
											<td>
												<input type="text" id="social_buttons_order_twitter" name="social_buttons_order_twitter" value="<?php echo $social_buttons_order_twitter; ?>" size="3" />
											</td>
											<td>-</td>
										</tr>
										<tr>
											<td><img src="<?php echo plugins_url('/images/social_googleplus.png', __FILE__); ?>" title="Google+" alt="Google+" />&nbsp;Google+</td>
											<td>
												<input class="checkbox" name="social_buttons_enabled_googleplus" id="social_buttons_enabled_googleplus" value="0" type="hidden">
												<input class="checkbox" name="social_buttons_enabled_googleplus" id="social_buttons_enabled_googleplus" value="1" <?php echo $checked_value3; ?> type="checkbox">
											</td>
											<td>
												<input type="text" id="social_buttons_order_googleplus" name="social_buttons_order_googleplus" value="<?php echo $social_buttons_order_googleplus; ?>" size="3" />
											</td>
											<td>
												<select name="social_buttons_plus_language">
												<?php foreach($this->language_plus as $lang_code => $lang_name): ?>
													<?php if($lang_code == $social_buttons_plus_language): ?>
														<option selected="selected" value="<?php echo $lang_code; ?>"><?php echo $lang_name; ?></option>
													<?php else: ?>
														<option value="<?php echo $lang_code; ?>"><?php echo $lang_name; ?></option>
													<?php endif; ?>
												<?php endforeach; ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><img src="<?php echo plugins_url('/images/social_pinterest.png', __FILE__); ?>" title="Pinterest" alt="Pinterest" />&nbsp;Pinterest</td>
											<td>
												<input class="checkbox" name="social_buttons_enabled_pinterest" id="social_buttons_enabled_pinterest" value="0" type="hidden">
												<input class="checkbox" name="social_buttons_enabled_pinterest" id="social_buttons_enabled_pinterest" value="1" <?php echo $checked_value4; ?> type="checkbox">
											</td>
											<td>
												<input type="text" id="social_buttons_order_pinterest" name="social_buttons_order_pinterest" value="<?php echo $social_buttons_order_pinterest; ?>" size="3" />
											</td>
											<td>-</td>
										</tr>
										<tr>
											<td><img src="<?php echo plugins_url('/images/social_linkedin.png', __FILE__); ?>" title="LinkedIn" alt="LinkedIn" />&nbsp;LinkedIn</td>
											<td>
												<input class="checkbox" name="social_buttons_enabled_linkedin" id="social_buttons_enabled_linkedin" value="0" type="hidden">
												<input class="checkbox" name="social_buttons_enabled_linkedin" id="social_buttons_enabled_linkedin" value="1" <?php echo $checked_value5; ?> type="checkbox">
											</td>
											<td>
												<input type="text" id="social_buttons_order_linkedin" name="social_buttons_order_linkedin" value="<?php echo $social_buttons_order_linkedin; ?>" size="3" />
											</td>
											<td>-</td>
										</tr>
										<tr>
											<td><img src="<?php echo plugins_url('/images/social_stumbleupon.png', __FILE__); ?>" title="StumbleUpon" alt="StumbleUpon" />&nbsp;StumbleUpon</td>
											<td>
												<input class="checkbox" name="social_buttons_enabled_stumbleupon" id="social_buttons_enabled_stumbleupon" value="0" type="hidden">
												<input class="checkbox" name="social_buttons_enabled_stumbleupon" id="social_buttons_enabled_stumbleupon" value="1" <?php echo $checked_value6; ?> type="checkbox">
											</td>
											<td>
												<input type="text" id="social_buttons_order_stumbleupon" name="social_buttons_order_stumbleupon" value="<?php echo $social_buttons_order_stumbleupon; ?>" size="3" />
											</td>
											<td>-</td>
										</tr>
										<tr>
											<td><img src="<?php echo plugins_url('/images/social_tumblr.png', __FILE__); ?>" title="Tumblr" alt="Tumblr" />&nbsp;Tumblr</td>
											<td>
												<input class="checkbox" name="social_buttons_enabled_tumblr" id="social_buttons_enabled_tumblr" value="0" type="hidden">
												<input class="checkbox" name="social_buttons_enabled_tumblr" id="social_buttons_enabled_tumblr" value="1" <?php echo $checked_value7; ?> type="checkbox">
											</td>
											<td>
												<input type="text" id="social_buttons_order_tumblr" name="social_buttons_order_tumblr" value="<?php echo $social_buttons_order_tumblr; ?>" size="3" />
											</td>
											<td>-</td>
										</tr>
										<tr>
											<td><img src="<?php echo plugins_url('/images/social_fancy.png', __FILE__); ?>" title="Fancy" alt="Fancy" />&nbsp;Fancy</td>
											<td>
												<input class="checkbox" name="social_buttons_enabled_fancy" id="social_buttons_enabled_fancy" value="0" type="hidden">
												<input class="checkbox" name="social_buttons_enabled_fancy" id="social_buttons_enabled_fancy" value="1" <?php echo $checked_value9; ?> type="checkbox">
											</td>
											<td>
												<input type="text" id="social_buttons_order_fancy" name="social_buttons_order_fancy" value="<?php echo $social_buttons_order_fancy; ?>" size="3" />
											</td>
											<td>
											<select name="social_buttons_fancy_category">
											<?php foreach($this->fancy_categories as $option => $option_name): ?>
												<?php if($option == $social_buttons_fancy_category): ?>
													<option selected="selected" value="<?php echo $option; ?>"><?php echo $option_name; ?></option>
												<?php else: ?>
													<option value="<?php echo $option; ?>"><?php echo $option_name; ?></option>
												<?php endif; ?>
											<?php endforeach; ?>
											</select>
											</td>
										</tr>
										<tr>
											<td><img src="<?php echo plugins_url('/images/social_svpply.png', __FILE__); ?>" title="Svpply" alt="Svpply" />&nbsp;Svpply</td>
											<td>
												<input class="checkbox" name="social_buttons_enabled_svpply" id="social_buttons_enabled_svpply" value="0" type="hidden">
												<input class="checkbox" name="social_buttons_enabled_svpply" id="social_buttons_enabled_svpply" value="1" <?php echo $checked_value10; ?> type="checkbox">
											</td>
											<td>
												<input type="text" id="social_buttons_order_svpply" name="social_buttons_order_svpply" value="<?php echo $social_buttons_order_svpply; ?>" size="3" />
											</td>
											<td>-</td>
										</tr>
										<tr>
											<td><img src="<?php echo plugins_url('/images/social_email.png', __FILE__); ?>" title="Email To" alt="Email To" />&nbsp;Email</td>
											<td>
												<input class="checkbox" name="social_buttons_enabled_email" id="social_buttons_enabled_email" value="0" type="hidden">
												<input class="checkbox" name="social_buttons_enabled_email" id="social_buttons_enabled_email" value="1" <?php echo $checked_value13; ?> type="checkbox">
											</td>
											<td>
												<input type="text" id="social_buttons_order_email" name="social_buttons_order_email" value="<?php echo $social_buttons_order_email; ?>" size="3" />
											</td>
											<td><input type="text" id="social_buttons_email_to" name="social_buttons_email_to" value="<?php echo $social_buttons_email_to; ?>" size="20" placeholder="Default Email Address" /></td>
										</tr>
									</table>
									</td>
									</tr>
									<tr>
										<td colspan=2">
											<input class="button-primary" type="submit" name="Save" value="<?php _e('Save Options', 'woocommerce-social-buttons-pro' ); ?>" id="submitbutton" />
											<input type="hidden" name="submitted" value="1" /> 
											<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo $nonce; ?>" />
										</td>
									</tr>
								
								</tbody>
						</table>
						</form>
					
					</td>
					
					<td width="30%" style="background:#ececec;padding:10px 5px;" valign="top">
						<p><b>WooCommerce Social Buttons PRO</b> is a premium woocommerce plugin developed by <a href="http://www.terrytsang.com" target="_blank" title="Terry Tsang - a php and symfony developer">Terry Tsang</a>. This plugin aims to add Social Media Share Buttons at the product page. All your visitors now can share content through social media, and it has become the best way to drive traffic.</p>
						
						<h3>Get MORE Extensions</h3>
					
						<p>Vist <a href="http://www.terrytsang.com/shop" target="_blank" title="Premium &amp; Free Extensions/Plugins for E-Commerce by Terry Tsang">My Shop</a> to get more free and premium extensions/plugins for your ecommerce platform.</p>
					
						<h3>Spreading the Word</h3>
	
						<ul style="list-style:dash">If you find this plugin helpful, you can:	
							<li>- Write and review about it in your blog</li>
							<li>- Share on your facebook, twitter, google+ and others</li>
						</ul>
	
						<h3>Thank you for your support!</h3>
					</td>
					
				</tr>
				</table>
				
				
				<br />
				
			<?php
			}
			
			
			/**
			 * Get the setting options
			 */
			function get_options() {
				$options = array(
						'social_buttons_enabled_facebook' => '',
						'social_buttons_enabled_twitter' => '',
						'social_buttons_enabled_googleplus' => '',
						'social_buttons_enabled_pinterest' => '',
						'social_buttons_enabled_linkedin' => '',
						'social_buttons_enabled_stumbleupon' => '',
						'social_buttons_enabled_tumblr' => '',
						'social_buttons_enabled_fancy' => '',
						'social_buttons_enabled_svpply' => '',
						'social_buttons_enabled_email' => '',
						'social_buttons_order_facebook' => '',
						'social_buttons_order_twitter' => '',
						'social_buttons_order_googleplus' => '',
						'social_buttons_order_pinterest' => '',
						'social_buttons_order_linkedin' => '',
						'social_buttons_order_stumbleupon' => '',
						'social_buttons_order_tumblr' => '',
						'social_buttons_order_fancy' => '',
						'social_buttons_order_svpply' => '',
						'social_buttons_order_email' => '',
						'social_buttons_javascript_body' => '',
						'social_buttons_display_position' => 'default',
 						'social_buttons_fb_language' => 'en_GB',
						'social_buttons_plus_language' => 'en-GB',
						'social_buttons_fancy_category' => 'Other',
						'social_buttons_enabled_fbshare' => '',
						'social_buttons_post_page' => '',
						'social_buttons_email_to' => ''
				);
				$array_options = array();
					
				
				foreach($options as $field => $value)
				{
					$array_options[$field] = get_option( $field );
				}
					
				return $array_options;
			}
			
			function compare($value1, $value2) {
				if ($value1 == $value2) {
					return 0;
				}
				return ($value1 < $value2) ? -1 : 1;
			}
			
			/**
			 * Get the settings page orders
			 */
			function get_options_order() {
				$options = array(
						'facebook' => '',
						'twitter' => '',
						'googleplus'=> '',
						'pinterest'=> '',
						'linkedin'=> '',
						'stumbleupon'=> '',
						'tumblr' => '',
						'fancy' => '',
  						'svpply' => '',
  						'email' => ''
				);
				$array_orders = array();	
				$array_buttons = array();
				
				$index = 1;
				foreach($options as $field => $value)
				{
					$sort_order = get_option( 'social_buttons_order_'.$field );
					
					if($sort_order == '')
						$array_orders[$field] = $index;
					else
						$array_orders[$field] = $sort_order;

					$index++;
				}
				
				uasort($array_orders, array( &$this, 'compare' ));
				
				foreach($array_orders as $field => $order)
					$array_buttons[] = $field;
					
				return $array_buttons;
			}
			
			/**
			 * Show social sharing widget
			 */
			public function social_buttons_widget()
			{
				global $woocommerce, $post, $product;
					
				$this->options = $this->get_options();
				
				foreach($this->field_types as $field_type)
				{
					foreach($this->field_options as $option_name)
					{
						$field_name = 'social_buttons_'.$option_name.'_'.$field_type;
						
						$$field_name = $this->options[$field_name];
					}
				}
				
				$this->options_order = $this->get_options_order();		
				
				$social_buttons_fancy_category	= get_option( 'social_buttons_fancy_category' );
				$social_buttons_enabled_fbshare	= get_option( 'social_buttons_enabled_fbshare' );
				$social_buttons_email_to		= get_option( 'social_buttons_email_to' );

				$widget_html = '<div id="basic-modal-content" class="social-button-container">';
				
				$enabled_fbshare 		= 'false';
				
				if( $social_buttons_enabled_fbshare == true )
					$enabled_fbshare = 'true';

				$product_title = esc_attr(get_the_title() ? get_the_title() : '');
				$product_url = esc_attr(get_permalink() ? get_permalink() : home_url());
				
				foreach($this->options_order as $widget_name)
				{
					switch ($widget_name) {
						case 'facebook':
							if($social_buttons_enabled_facebook)
								$widget_html .= '<div class="social-button-facebook"><div class="fb-like" data-href="'.get_permalink().'" data-layout="button_count" data-send="'.$enabled_fbshare.'" data-width="100" data-show-faces="false"></div></div>';
							break;
						case 'twitter':
							if($social_buttons_enabled_twitter)
								$widget_html .= '<div class="social-button-twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a></div>';
							break;
						case 'googleplus':
							if($social_buttons_enabled_googleplus)
								$widget_html .= '<div class="social-button-plus"><div class="g-plusone" data-size="medium" data-width="100"></div></div>';
							break;
						case 'pinterest':
							if($social_buttons_enabled_pinterest)
								$widget_html .= '<div class="social-button-pinterest"><a href="http://pinterest.com/pin/create/button/?url='. urlencode(get_permalink()).'&media='.urlencode(wp_get_attachment_url( get_post_thumbnail_id() )).'&description='.strip_tags($post->post_title).'" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>';
							break;
						case 'linkedin':
							if($social_buttons_enabled_linkedin)
								$widget_html .= '<div class="social-button-linkedin"><script type="IN/Share" data-url="'.get_permalink().'" data-counter="right"></script></div>';
							break;
						case 'stumbleupon':
							if($social_buttons_enabled_stumbleupon)
								$widget_html .= '<div class="social-button-stumbleupon"><su:badge layout="1" location="'.get_permalink().'"></su:badge></div>';
							break;
						case 'tumblr':
							if($social_buttons_enabled_tumblr)
								$widget_html .= '<div class="social-button-tumblr"><a href="http://www.tumblr.com/share" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:71px; height:20px; background:url(http://platform.tumblr.com/v1/share_2.png) top left no-repeat transparent;">Share on Tumblr</a></div>';
							break;
						case 'fancy':
							if($social_buttons_enabled_fancy)
								$widget_html .= '<div class="social-button-fancy"><a id="FancyButton" href="http://www.thefancy.com/fancyit?ItemURL='.urlencode(get_permalink()).'&Title='.strip_tags($post->post_title).'&Category='.$social_buttons_fancy_category.'&ImageURL='.urlencode(wp_get_attachment_url( get_post_thumbnail_id() )).'&showcount=false">Fancy</a></div>';
							break;
						case 'svpply':
							if($social_buttons_enabled_svpply)
								$widget_html .= '<div class="social-button-svpply"><sv:product-button type="boxed"></sv:product-button></div>';
							break;
						case 'email':
							if($social_buttons_enabled_email)
								$widget_html .= '<div class="social-button-email"><a href="mailto:'.$social_buttons_email_to.'?subject='.$product_title.'&body=Hi,I found this product and thought you might like it '.$product_url.'">Email</a></div>';
							break;
						
					}
				}
				
				
				$widget_html .= '</div>';
				
				
				$social_buttons_display_lightbox	= get_option( 'social_buttons_display_lightbox' );
				if($social_buttons_display_lightbox)
				{
					echo '<div id="social-button"><a href="#" class="btn">Share/Like</a></div>';
				}
				
				echo $widget_html;
			}
	
	
		}
	}

	/* 
	 * Instantiate plugin class and add it to the set of globals.
	 */
	$WooCommerce_Social_Buttons_PRO = new WooCommerce_Social_Buttons_PRO();

	function socialbuttonspro() {
		$woo_socialbuttonspro = new WooCommerce_Social_Buttons_PRO();
		add_action('init', $woo_socialbuttonspro->social_buttons_widget());
	}
}
else{
	add_action('admin_notices', 'wc_social_buttons_pro_notice');
	function wc_social_buttons_pro_notice(){
		global $current_screen;
		if($current_screen->parent_base == 'plugins'){
			echo '<div class="error"><p>For your information, '.__(wc_social_buttons_pro_plugin_name.' requires <a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a> to be installed and activated. Please install and activate <a href="'.admin_url('plugin-install.php?tab=search&type=term&s=WooCommerce').'" target="_blank">WooCommerce</a> first.').'</p></div>';
		}
	}
}
?>