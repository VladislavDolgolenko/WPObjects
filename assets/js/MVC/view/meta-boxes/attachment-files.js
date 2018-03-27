/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
 */


(function(MSP, Backbone, _, $, wp){
    
    MSP.ViewAttachmentFilesList = Backbone.View.extend({
        
        className: 'msp-bootstrap-wrapper msp-form msp-attch-files',
        
        template: _.template( MSP.TmplAttachmentFilesList ), 
        
        initialize: function (options) {
            this.files_ids = options.files_ids;
            this.Collection = new Backbone.Collection();
            
            var self = this;
            _.each(this.files_ids, function(id){
                var attachment = new wp.media.model.Attachment.get(id);
                self.Collection.add(attachment);
            });
            
            this.listenTo(this.Collection, 'add remove reset', this.render);
        },
        
        events: {
            'click .js-show-gallery': 'showGallery'
        },
        
        render: function () {
            this.$el.html( this.template() );
            
            var self = this;
            var $list = this.$('.js-collection');
            this.Collection.each(function(File){
                var View = new MSP.ViewAttachmentFilesFile({
                    model: File,
                    Collection: self.Collection
                });
                $list.append( View.render().el );
            });
            
            this.$('.js-collection').sortable();
            
            return this;
        },
        
        showGallery: function (e) {
            var title = $(e.currentTarget).attr('title');
            
            this.frame = wp.media({
                    title : title,
                    multiple : true,
                    button : { text : title }
            });

            this.frame.on('close', _.bind(this.setFiles, this));
            this.frame.open();
            
            return false;
        },
        
        setFiles: function (e) {
            var attachments = this.frame.state().get('selection');
            
            var self = this;
            this.$('.attached-images').html(null);
            attachments.each(function (attachment, index) {
                console.log(attachment);
                self.Collection.add(attachment);
            });
        }
        
    });
    
    MSP.ViewAttachmentFilesFile = Backbone.View.extend({
       
        className: 'file',
       
        template: _.template( MSP.TmplAttachmentFilesFile ),
       
        initialize: function (options) {
            this.Collection = options.Collection;
            this.listenTo(this.model, 'sync', this.render);
            this.model.fetch();
        },
        
        events: {
            'click .js-remove-file': 'removeFile'
        },
       
        render: function () {
            this.$el.html( this.template({File: this.model}) );
            
            return this;
        },
        
        removeFile: function () {
            this.Collection.remove([this.model]);
        }
        
    });
    
    $('.js-attachment-files').each(function(){
        var files_ids_string = $(this).attr('data-attachments-ids');
        var files_ids = [];
        if (files_ids_string) {
            files_ids = files_ids_string.split(',');
        } 
        
        var View = new MSP.ViewAttachmentFilesList({
            files_ids: files_ids
        });
        $(this).html( View.render().el );
    });
    
})(MSP, Backbone, _, jQuery, wp);