/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function ($) {
    
    $('.fancybox').fancybox();
    
    $(".dokan_product_shipping_choice").click(function () {

        var data_id = $(this).attr("data-id");
        var value = $(this).val();

        $('body').trigger('update_checkout');
    });

    $(".favourite").click(function () {

        var vendor_id = $(this).attr("data-id");
        var curr_user_email = $(this).attr("data-user-email");
        var current_user_id = $(this).attr("data-user-id");
        
        var r = confirm("Are You sure you want to add this seller to Favorite?");
        
        if (r == true) {
            jQuery.post(
                    FarmtoyouPublic.ajaxurl,
                    {
                        action          : 'add_fav_detail',
                        vendor_id       : vendor_id,
                        curr_user_email : curr_user_email,
                        current_user_id : current_user_id,
                    },
                    function (response) {

                    }
            );
        }
    });
});