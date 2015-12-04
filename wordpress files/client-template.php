<?php



// Exit if accessed directly

if ( !defined( 'ABSPATH' ) ) exit;



/**

 * Template Name: Client Page

 *

 * @package WordPress

 * @subpackage Artist

 * @since Artist 1.0

 */



get_header(); ?>



            <div class="portfolio-section">

                <div class="container">
                    <div class="entry-header">
                    	<h1>
                            <?php while ( have_posts() ) : the_post();
                                        the_title();
                                endwhile;
                            ?>
                        </h1>
                    </div>

					<div class="client-form">
                        <form action="" method="post">
                            <div class="client-username">
                                <label>Username: </label><input type="text" name="category_name" id="category_name">    
                            </div>
    
                            <div class="client-password">
                                <label>Password: </label><input type="password" name="category_password" id="category_password">    
                            </div>
                            <input type="submit" value="Submit">
    
                        </form>    
                    </div>
                    <!--Client form end-->
                </div>
            </div>



<?php get_footer(); ?>