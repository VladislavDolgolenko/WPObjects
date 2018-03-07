/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
 */

(function(Backbone, $, wp){
    
    var View = Backbone.View.extend({
        
        initialize: function () {
            
        },
        
        events: {
            'click .add-image': 'showMedia'
        },
        
        showMedia: function (e) {
            e.preventDefault();
            var title = $(e.currentTarget).attr('title');
            
            var frame = wp.media({
                title : title,
                multiple : false,
                library : { type : 'image' },
                button : { text : title }
            });

            var self = this;
            frame.on('close', function( ) {
                var attachments = frame.state().get('selection').toJSON();
                if (attachments[0] === undefined) {
                    return;
                }
                self.attachImage(attachments[0].id, attachments[0].url);
            });

            frame.open();
            return false;
        },
        
        attachImage: function (id, url) {
            this.$('.attached-image').attr('src', url);
            this.$('.attached-image').show();
            this.$('.input-attach-img-id').val(id);
            this.trigger('change');
        }
               
    });
    
    $('.msp-image-picker').each(function(){
        new View({el: $(this)}); 
    });
    
})(Backbone, jQuery, wp);

