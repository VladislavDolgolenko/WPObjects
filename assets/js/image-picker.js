/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
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

