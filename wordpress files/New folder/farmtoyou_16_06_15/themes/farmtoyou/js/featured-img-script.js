jQuery(document).ready(function ($) {
    var customMediaSelector = {
      init: function() {
        $('.farmtoyou_custom_media_add').on('click', function (e) { 
          var $el;
          e.preventDefault();
          $el = customMediaSelector.el = $(this).parent();
          $el.image = $el.find('.farmtoyou_custom_media_image');
          $el.id = $el.find('.farmtoyou_custom_media_id');
          customMediaSelector.frame().open();
        });
 
        $('.farmtoyou_custom_media_remove').on('click', function (e) {
          var $el = $(this).parent();
          e.preventDefault();
 
          $el.find('.farmtoyou_custom_media_image').attr('src', '').hide();
          $el.find('.farmtoyou_custom_media_id').val('');
          $el.find('.farmtoyou_custom_media_add, .farmtoyou_custom_media_remove').toggle();
        });
      },
 
      // Update the selected image in the media library based on the attachment ID in the field.
      open: function() {
        var selection = this.get('library').get('selection'),
            attachment, selected;
 
        selected = customMediaSelector.el.id.val();
 
        if ( selected && '' !== selected && -1 !== selected && '0' !== selected ) {
            attachment = wp.media.model.Attachment.get( selected );
            attachment.fetch();
        }
 
        selection.reset( attachment ? [ attachment ] : [] );
      },
 
      // Update the control when an image is selected from the media library.
      select: function() {
        var $el = customMediaSelector.el,
            selection = this.get('selection'),
            sizes = selection.first().get('sizes'),
            size;
 
        // Insert the selected attachment id into the target element.
        $el.id.val( selection.first().get( 'id' ) );
 
        // Update the image preview tag.
        if ( sizes ) {
            // The image size to show for the preview.
            size = sizes['post-thumbnail'] || sizes.medium;
        }
 
        size = size || selection.first().toJSON();
        $el.image.attr( 'src', size.url ).show();
        $el.find('.farmtoyou_custom_media_add, .farmtoyou_custom_media_remove').toggle();
        selection.reset();
      },
 
      // Initialize a new frame or return an existing frame.
      frame: function() {
        if ( this._frame )
          return this._frame;
 
        this._frame = wp.media({
          title: 'Set Image',
          library: {
              type: 'image'
          },
          button: {
              text: 'Set image'
          },
          multiple: false
        });
 
        this._frame.on( 'open', this.open ).state('library').on( 'select', this.select );
        return this._frame;
      }
    };
 
    customMediaSelector.init();
});