/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery( document ).ready(function($) { 
  
    //set selected tab for reports page default first tab will be selected
    $( '.farmtoyou-settings-page .nav-tab-wrapper a:first' ).addClass( 'nav-tab-active' );
    $( '.farmtoyou-settings-page .farmtoyou-content div:first' ).show();

    //  When user clicks on tab, this code will be executed
    $( document ).on( 'click', '.nav-tab-wrapper a', function() {

        //  First remove class "active" from currently active tab
        $(".nav-tab-wrapper a").removeClass('nav-tab-active');
 
        //  Now add class "active" to the selected/clicked tab
        $(this).addClass("nav-tab-active");
 
        //  Hide all tab content
        $(".farmtoyou-tab-content").hide();
 
        //  Here we get the href value of the selected tab
        var selected_tab = $(this).attr("href");
 
        //  Show the selected tab content
        $(selected_tab).show();
        
        //  At the end, we add return false so that the click on the link is not executed
        return false;
    });
  
    /*
    * Advanced Add Files
    */
    jQuery( document ).on( 'click', '.farmtoyou-meta-add-fileadvanced', function() {
        var jQueryfirst = jQuery(this).parent().find('.file-input-advanced:last');
        jQueryfirst.clone().insertAfter(jQueryfirst).show();
        jQuery(this).parent().find('.file-input-advanced:last .farmtoyou-upload-file-link').val('');
        jQuery(this).parent().find('.file-input-advanced:last .farmtoyou-upload-file-title').val('');
        jQuery(this).parent().find('.file-input-advanced:last .farmtoyou-upload-file-sub-title').val('');
        jQuery(this).parent().find('.file-input-advanced:last .farmtoyou-upload-file-url').val('');
        return false;
    });
   
    /*
     * Advanced Add Files
     */
    jQuery( document ).on( 'click', '.farmtoyou-delete-fileadvanced', function() {
        var row = jQuery(this).parent().parent().parent( 'tr' );
        var count =	row.find('.file-input-advanced').length;
        if(count > 1) {
            jQuery(this).parent('.file-input-advanced').remove();
        } else {
            alert( FarmtoyouAdmin.one_file_min );
        }
        return false;
    });
   
    // WP 3.5+ uploader
    jQuery( document ).on( 'click', '.farmtoyou-upload-fileadvanced', function(e) {

        e.preventDefault();

        if(typeof wp == "undefined" || FarmtoyouAdmin.new_media_ui != '1' ){// check for media uploader

                //Old Media uploader

                window.formfield = '';
                e.preventDefault();

                window.formfield = jQuery(this).closest('.file-input-advanced');

                tb_show('', 'media-upload.php?post_id='+ jQuery('#post_ID').val() + '&type=image&amp;TB_iframe=true');
              //store old send to editor function
              window.restore_send_to_editor = window.send_to_editor;
              //overwrite send to editor function
              window.send_to_editor = function(html) {
                attachmenturl = jQuery('a', '<div>' + html + '</div>').attr('href');
                attachmentname = jQuery('a', '<div>' + html + '</div>').html();

                window.formfield.find('.farmtoyou-upload-file-link').val(attachmenturl);
                //window.formfield.find('.farmtoyou-upload-file-name').val(attachmentname);
                tb_remove();
                //restore old send to editor function
                window.send_to_editor = window.restore_send_to_editor;
              }
            return false;

        } else {

                var file_frame;
                window.formfield = '';

                //new media uploader
                var button = jQuery(this);

                window.formfield = jQuery(this).closest('.file-input-advanced');

                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                        //file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
                        file_frame.open();
                  return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                        frame: 'post',
                        state: 'insert',
                        title: button.data( 'uploader_title' ),
                        button: {
                                text: button.data( 'uploader_button_text' ),
                        },
                        multiple: true  // Set to true to allow multiple files to be selected
                });

                file_frame.on( 'menu:render:default', function(view) {
                // Store our views in an object.
                var views = {};

                // Unset default menu items
                view.unset('library-separator');
                view.unset('gallery');
                view.unset('featured-image');
                view.unset('embed');

                // Initialize the views in our view object.
                view.set(views);
            });

                // When an image is selected, run a callback.
                file_frame.on( 'insert', function() {

                        // Get selected size from media uploader
                        //var selected_size = jQuery('.attachment-display-settings .size').val();

                        var selection = file_frame.state().get('selection');
                        selection.each( function( attachment, index ) {
                                attachment = attachment.toJSON();

                                // Selected attachment url from media uploader
                                //var attachment_url = attachment.sizes[selected_size].url;

                                if(index == 0){
                                        // place first attachment in field
                                        window.formfield.find('.farmtoyou-upload-file-link').val( attachment.url );
                                        //window.formfield.find('.farmtoyou-upload-file-name').val( attachment.name );

                                } else{
                                        //window.formfield.find('.farmtoyou-upload-file-name').val( attachment.name );
                                        window.formfield.find('.farmtoyou-upload-file-link').val( attachment.url );

                                }
                        });
                });

                // Finally, open the modal
                file_frame.open();
        }
    });
    
    /* Gallery Images JS start */
    // Product gallery file uploads
    var wp_gallery_frame;
    var $image_gallery_ids = $('#wp_gallery_image_gallery');
    var $wp_gallery_images = $('#wp_gallery_images_container ul.wp_gallery_images');

    jQuery('.add_wp_gallery_images').on( 'click', 'a', function( event ) {
        var $el = $(this);
        var attachment_ids = $image_gallery_ids.val();

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if ( wp_gallery_frame ) {
                wp_gallery_frame.open();
                return;
        }

        // Create the media frame.
        wp_gallery_frame = wp.media.frames.wp_gallery = wp.media({
                // Set the title of the modal.
                title: $el.data('choose'),
                button: {
                        text: $el.data('update'),
                },
                states : [
                        new wp.media.controller.Library({
                                title: $el.data('choose'),
                                filterable :	'all',
                                multiple: true,
                        })
                ]
        });

        // When an image is selected, run a callback.
        wp_gallery_frame.on( 'select', function() {

            var selection = wp_gallery_frame.state().get('selection');

            selection.map( function( attachment ) {

                    attachment = attachment.toJSON();

                    if ( attachment.id ) {
                            attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

                            $wp_gallery_images.append('\
                                    <li class="image" data-attachment_id="' + attachment.id + '">\
                                            <img src="' + attachment.url + '" />\
                                            <ul class="actions">\
                                                    <li><a href="#" class="delete" title="' + $el.data('delete') + '">X</a></li>\
                                            </ul>\
                                    </li>');
                            }

                    });

                    $image_gallery_ids.val( attachment_ids );
            });

            // Finally, open the modal.
            wp_gallery_frame.open();
    });

    // Image ordering
    $wp_gallery_images.sortable({
            items: 'li.image',
            cursor: 'move',
            scrollSensitivity:40,
            forcePlaceholderSize: true,
            forceHelperSize: false,
            helper: 'clone',
            opacity: 0.65,
            placeholder: 'wc-metabox-sortable-placeholder',
            start:function(event,ui){
                    ui.item.css('background-color','#f6f6f6');
            },
            stop:function(event,ui){
                    ui.item.removeAttr('style');
            },
            update: function(event, ui) {
                    var attachment_ids = '';

                    $('#wp_gallery_images_container ul li.image').css('cursor','default').each(function() {
                            var attachment_id = jQuery(this).attr( 'data-attachment_id' );
                            attachment_ids = attachment_ids + attachment_id + ',';
                    });

                    $image_gallery_ids.val( attachment_ids );
            }
    });

    // Remove images
    $('#wp_gallery_images_container').on( 'click', 'a.delete', function() {
            $(this).closest('li.image').remove();

            var attachment_ids = '';

            $('#wp_gallery_images_container ul li.image').css('cursor','default').each(function() {
                    var attachment_id = jQuery(this).attr( 'data-attachment_id' );
                    attachment_ids = attachment_ids + attachment_id + ',';
            });

            $image_gallery_ids.val( attachment_ids );

            runTipTip();

            return false;
    });
    /* Gallery Images JS end */
});