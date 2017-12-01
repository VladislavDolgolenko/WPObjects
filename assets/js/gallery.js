(function(Backbone, _, $, wp){
    
    var ViewElement = Backbone.View.extend({
        
        template: _.template( $('#tmp-msp-ui-gallery-element').html() ),
        
        tagName: 'article',
        className: 'col-sm-2 col-md-4 col-lg-2',
        
        initialize: function () {
            
        },
        
        render: function (img_url, attach_id) {
            this.$el.html( this.template({
                'img_url' : img_url,
                'attach_id' : attach_id
            }));
        },
        
        events: {
            'click .delete-attach' : 'remove'
        }
        
    });
    
    var View = Backbone.View.extend({
        
        initialize: function () {
            this.$('.attached-images article').each(function(index, article){
                new ViewElement({el: article});
            });
            this.render();
        },
        
        render: function () {
            var $sortable = this.$( ".attached-images" );
            $sortable.sortable();
            $sortable.disableSelection();
        },
        
        events: {
            'click button.add-attachments': 'showMedia'
        },
        
        showMedia: function (e) {
            var title = $(e.currentTarget).attr('title');
            
            this.frame = wp.media({
                    title : title,
                    multiple : true,
                    library : { type : 'image' },
                    button : { text : title }
            });

            this.frame.on('close', _.bind(this.addAttachments, this));
            this.frame.open();
            
            return false;
        },
        
        addAttachments: function () {
            var attachments = this.frame.state().get('selection').toJSON();
            
            var self = this;
            this.$('.attached-images').html(null);
            _.each(attachments, function (attachment, index) {
                console.log(attachment);
                var url = attachment.sizes.thumbnail !== undefined ? attachment.sizes.thumbnail.url : attachment.sizes.full.url;
                var Element = new ViewElement();
                self.$('.attached-images').append(Element.el);
                Element.render(url, attachment.id);
            });
        }
        
    });
    
    if ($('#msp-ui-gallery').length) {
        new View({el: $('#msp-ui-gallery')});
    }
    
})(Backbone, _, jQuery, wp);

